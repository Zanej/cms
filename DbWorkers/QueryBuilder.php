<?php
namespace CMS\DbWorkers;
use CMS\Conf\Config;
/**
 * Description of QueryBuilder
 *
 * @author zane2
 */
class QueryBuilder {
   
    private $query;
    private $result;
    private $builders;
    private $alias;
    private $fields_seen;
    private static $queryhistory;
    function __construct() {         
        $this->flush();                
    }
    /**
    * 
    * @param type $table
    * @param type $what
    * @return \QueryBuilder
    */
    public function insert($table,$what){
       $this->flush();
       $this->builders->action = "INSERT";
       $this->checkValuesType($what, $table);
       $this->builders->from = implode(",",array_keys($what));
       $this->builders->values = "'".implode("','",$what)."'";
       $this->buildQuery($table);
       return $this;
    }
    /**
    * 
    * @param type $table
    * @param type $what
    * @param type $where
    * @return type
    */
    public function select($table,$what,$where){
        $this->flush();
        $this->builders->action = "SELECT";
        $this->builders->from = $table;
        if(is_array($what)){
            foreach($what as $k => $w){
                $what[$k] = "a.".$w;
                $this->fields_seen[] = $w;
            }
            $this->builders->values = implode(",",$what);
        }else{
            $this->builders->values = "a.*";
        }        
        $this->buildQuery($table,$where);
        return $this;
    }
    /**
    * 
    * @param type $table
    * @param type $what
    * @param type $where
    * @return \QueryBuilder
    */
    public function update($table,$what,$where){
        $this->flush();
        $this->builders->action = "UPDATE";
        $this->builders->from=$table;
        ////echo $table;
        $this->checkValuesType($what, $table);
        foreach($what as $key => $val){
            $this->builders->values.=" a.$key = '".$val."',";
        }
        $this->builders->values = substr($this->builders->values,0,-1);
        $this->buildQuery($table, $where);
        ////echo $this->query;
        //exit;
        return $this;
    }
    /**
    * 
    * @param type $table
    * @param type $where
    * @return \QueryBuilder
    */
    public function delete($table,$where){
        $this->flush();
        $this->builders->action="DELETE";
        $this->builders->from=$table;
        $this->builders->values="";
        $this->buildQuery($table,$where);
        ////echo $this->query; 
        return $this;
    }
    /**
    * Does a Join, if a single table is passed, does a join on the last table joined, otherwise does 
    * join on the two tables passed (one must be already in query)
    * @param string[] | string  $tables
    * @param array($key => $val) $on
    * @param array(string[]) | string[] $fields
    * @param array(string[]) | string[] $where
    * @return \QueryBuilder
    */
    public function join($tables,$on,$fields,$where){
        if(count($this->alias) == 0){
            $table = explode(" ",trim($this->builders->from));
            $this->alias["a"] = $table[0];
        }
        if(!is_array($tables) && is_string($tables)){
            $this->joinSingle($tables,$on,$fields,$where);
        }elseif(is_array($tables)){
            $this->joinMultiple($tables,$on, $fields, $where);
        }
        $this->buildQuery();
        return $this;
    }
    /**
     * Joins last table inserted with the one passed
     * @param string $table table name
     * @param array() $on $last_table_attr => $table_pass_attr
     * @param array() $fields fields to get or update of the table passed
     * @param array() $where where of the table passed
     */
    private function joinSingle($table,$on,$fields,$where){
        $keys = array_keys($this->alias);
        $lastalias = $keys[count($this->alias)-1];
        $newalias = chr(ord($lastalias)+1);
        $this->alias[$newalias] = $table;
        $this->setOn($lastalias,$newalias,$table,$on);
        if($this->builders->action == "SELECT"){
            $this->setParamsSelect($newalias,$fields);
        }elseif($this->builders->action == "UPDATE"){
            $this->setParamsUpdate($newalias,$fields);
        }
        $this->setWhereJoin($newalias, $where);
    }
    /**
     * Sets the where for a join (add to existent)
     * @param string $newalias alias of the table added
     * @param array $where
     */
    private function setWhereJoin($newalias,$where){
        if($this->builders->where != ""){
            $this->builders->where.=" AND ";
        }
        if(is_array($where)){
            foreach($where as $key => $val){
                if(substr($key,0,strlen("md5(")) == "md5("){                    
                    $this->builders->where.="md5(".$newalias.".".substr($key,strlen("md5("))." = '$val' AND ";
                }elseif(substr($key,0,strlen("sha1(")) == "sha1("){
                    $this->builders->where.="sha1(".$newalias.".".substr($key,strlen("sha1("))." = '$val' AND ";
                }else{
                    $this->builders->where.="$newalias.$key = '$val' AND ";
                }
            }
        }        
        $this->builders->where = substr($this->builders->where,0,-5);
    }
    /**
     * Sets On
     * @param string $old alias of the table already in query
     * @param string $new alias of the table added to query
     * @param string $table name of the table added to query
     * @param string $on array($old_table_param => $new_table_param)
     */
    private function setOn($old,$new,$table,$on){
        $join = " JOIN ".$table." AS ".$new." ON ";
        foreach($on as $key => $value){
            $join.="$old.$key = $new.$value AND ";
        }
        $join = substr($join,0,-5);
        $this->builders->join.=$join;
    }
    /**
     * Set params for an update
     * @param string $alias Alias
     * @param type $fields fields
     */
    private function setParamsUpdate($alias,$fields){
        $this->builders->values.=",";
        if(is_array($fields)){
            foreach($fields as $key => $val){
                $this->builders->values.="$alias.$key = '$val',";
            }
        }
        $this->builders->values = substr($this->builders->values,0,-1);
    }
    /**
     * Set params for a select
     * @param string $alias Alias
     * @param type $fields fields
     */
    private function setParamsSelect($alias,$fields){
        $this->builders->values.=",";
        if(is_array($fields)){
            foreach($fields as $val){
                if(!in_array($val,$this->fields_seen)){
                    $this->fields_seen[] = $val;
                }else{
                    $val.=" as ".$val."_".$this->alias[$alias];
                }
                $this->builders->values.="$alias.$val,";
            }
        }
        $this->builders->values = substr($this->builders->values,0,-1);
    }
    /**
     * Does a join with a table already in query, not the last one
     * @param array[string,string] $tables tables name
     * @param array $on
     * @param array $fields
     * @param array $where
     */
    private function joinMultiple($tables,$on,$fields,$where){
        $alias = "";
        $newtable = "";
        foreach($tables as $key => $val){
            ////echo $al;
            if(($al = array_search($val,$this->alias)) !== false){
                $newtable = $key == 0 ? $tables[1] : $tables[0];
                $alias = $al;
                break;
            }
        }
        if($alias == ""){
            return false;
        }
        $keys = array_keys($this->alias);
        $lastalias = $keys[count($this->alias)-1];
        $newalias = chr(ord($lastalias)+1);
        $this->alias[$newalias] = $newtable;
        $this->setOn($alias, $newalias, $newtable, $on);
        if($this->builders->action == "SELECT"){
            $this->setParamsSelect($newalias,$fields);
        }elseif($this->builders->action == "UPDATE"){
            $this->setParamsUpdate($newalias,$fields);
        }
        $this->setWhereJoin($newalias, $where);
    }
    /**
    * Flushes, unset old query
    */
    public function flush(){        
        $this->query = "";
        $this->result = array();
        $this->alias = array();
        $this->fields_seen = array();
        $this->builders = (Object) [
            "action"=>"","values"=>"","from"=>"","where"=>"","join"=>""
            ,"group"=>"","having"=>"","order"=>"","limit"=>"" 
        ];        
    }
    /**
    * 
    * @param type $table
    */
    private function buildQuery($table="",$where=""){
        if(!$this->builders->join){
            $this->normalQuery($table,$where);
        }else{
            $this->joinQuery();
        }
    }
    private function joinQuery(){
        $this->query = $this->builders->action." ";
        if($this->builders->action == "SELECT"){
            $this->query.=$this->builders->values." FROM ".$this->builders->from.$this->builders->join;
            if($this->builders->where != ""){
                $this->query.=" WHERE ".$this->builders->where;
            }
        }elseif($this->builders->action == "UPDATE"){
            $this->query.=$this->builders->from.$this->builders->join." SET ".$this->builders->values;
            if($this->builders->where != ""){
                $this->query.=" WHERE ".$this->builders->where;
            }
        }elseif($this->builders->action == "DELETE"){
            
        }
    }
    /**
     * 
     * @param type $table
     * @param type $where
     */
    private function normalQuery($table,$where=""){
        if($this->builders->action !== "INSERT" && $where){
            $this->setWhere($where);
        }
        if($this->builders->action == "INSERT"){
            $this->query = "INSERT INTO $table (".$this->builders->from.") VALUES(".$this->builders->values.")";
        }
        elseif($this->builders->action == "SELECT"){
            $this->builders->from.=" AS a";
            $this->query = "SELECT ".$this->builders->values." FROM ".$this->builders->from; 
            if($this->builders->where != ""){
                $this->query.=" WHERE ".$this->builders->where;
            }
            ////echo $this->query;
        }elseif($this->builders->action == "DELETE"){
            if($this->builders->where != ""){
                $this->query= "DELETE FROM ".$this->builders->from." WHERE ".$this->builders->where;
            }else{
               $this->query="TRUNCATE TABLE ".$this->builders->from; 
            }
        }elseif($this->builders->action == "UPDATE"){
            $this->builders->from.=" AS a";
            $this->query=" UPDATE ".$this->builders->from." SET ".$this->builders->values;
            if($this->builders->where != ""){
                $this->query.=" WHERE ".$this->builders->where;
            }
        }
        ////echo $this->query;
    }
    /**
     * 
     * @param type $where
     */
    private function setWhere($where){
        foreach($where as $key => $value){
            ////echo $key." ".$value;
            if($this->builders->action !== "DELETE"){
                if(substr($key,0,strlen("md5(")) == "md5("){    
                    $this->builders->where.="md5(a.".substr($key,strlen("md5("))." = '$value' AND ";
                }elseif(substr($key,0,strlen("sha1(")) == "sha1("){
                    $this->builders->where.="sha1(a.".substr($key,strlen("sha1("))." = '$value' AND ";
                }else{                    
                    $this->builders->where.="a.$key = '".$value."' AND ";
                }
            }else{
                $this->builders->where.=$key." = '".$value."' AND ";
            }
            
        }        
        $this->builders->where = substr($this->builders->where,0,-4);
    }
    /**
    * 
    * @global type $db
    * @return boolean
    */
    public function getResult($cacheable = true){
        $db = Config::getDb();
        if($this->builders->action == "INSERT"){
            $db->Query($this->query);
            $this->addToHistory(false, $db->Error() ? false : $db->GetLastInsertID(), $db->Error());
            return $db->Error() ? false : $db->GetLastInsertID();
        }elseif($this->builders->action == "DELETE"){
            $db->Query($this->query);
            $this->addToHistory(false, $db->Error() ? false : true, $db->Error());
            return !($db->Error());
        }elseif($this->builders->action == "SELECT"){            
            return $this->selectCached($cacheable);
        }elseif($this->builders->action == "UPDATE"){
            $res = $db->Query($this->query);
            self::$queryhistory[] = $this->addToHistory(false, $db->Error() ? false : true, $db->Error());
            return $res;
        }
    }
    /**
     * Gets a select result from cache if is cached, from db if it's not
     * @return array or false
     */
    private function selectCached($cacheable = true){
        ////echo $this->query;
        $db = Config::getDb();
        if(!$cacheable){
            $cache = false;
        }else{
            $cache = $this->isQueryCached();
        }
        if($cache !== false){
            if($cache != "cached"){
                $this->addToHistory(true, is_array($cache) ? $cache : false, "Errors");
                return $cache;
            }
        }
        //echo $this->query;        
        //print_r($arr);
        $arr = $db->QueryArray($this->query,MYSQLI_ASSOC);
//        print_r($arr);
        if($db->Error()){
            $this->addToHistory(false, false, $db->Error());
            return false;
        }
        if(count($arr) == 1 && count($arr[0]) == 1){
            $arr = $arr[0][0];
        }
        if(strtolower($this->builders->from) != "cache as a"){
            ////echo "aaaaaaa";
            $this->addToHistory(false, $arr, "");
            if($cacheable){
                $this->cacheQuery($arr);
            }
        }
        
        if($cache == "cached"){
            $db->Query("UPDATE cache SET result='".serialize($arr)."',timestamp='".date('Y-m-d H:i:s')."' WHERE key_sql='".md5($this->query)."'");
        }
        return $arr;
    }
    /**
     * 
     * @param type $table
     * @param type $column
     * @param type $what
     * @return type
     */
    public function alterColumn($table,$column,$what,$type = "",$null=""){
        $db = Config::getDB();
        $sql="ALTER TABLE $table ";
        $sql.=" ALTER COLUMN $column SET $what";
        $sql = trim($sql);
        if(strrpos($sql,",") !== false && strrpos($sql,",") == strlen($sql)-1){
            $sql = substr($sql,0,-1);
        }
        if($type || $null){
            if(trim($null) == "NO"){
                $null = "NOT NULL";
            }else{
                $null= "NULL";
            }
            $sql_2 = trim("ALTER TABLE $table MODIFY $column $type $null");            
            if(strrpos($sql_2,",") !== false && strrpos($sql_2,",") == strlen($sql_2)-1){
                $sql_2 = substr($sql_2,0,-1);
            }
            $db->Query($sql_2);
        }
        if(!$what){
            return true;
        }else{
            return $db->Query($sql);
        }
    }
    /**
     * 
     * @param type $table
     * @param type $column
     * @param type $what
     * @return type
     */
    public function addColumn($table,$column,$what){
        $db = Config::getDB();
        $sql="ALTER TABLE $table ";
        $sql.=" ADD COLUMN $column $what";
        $sql = trim($sql);
        if(strrpos($sql,",") !== false && strrpos($sql,",") == strlen($sql)-1){
            $sql = substr($sql,0,-1);
        }
        ////echo $sql;
        return $db->Query($sql);
    }
    public function dropColumn($table,$column){
        $db = Config::getDB();
        return $db->Query("ALTER TABLE $table DROP COLUMN $column");
    }
    /**
     * 
     * @param type $values
     * @param type $table
     */
    private function checkValuesType(&$values,$table){
        /*@var $db MySQL*/
        $db = Config::getDB();
        foreach($values as $key => $val){
            $type = $db->GetColumnDataType($key, $table);
            ////echo $type;
            if($type == "VAR_STRING" || $type == "VAR_BLOB"){
                $values[$key] = addslashes(htmlentities($val));                
            }
        }
    }
    /**
     * Check if a query is cached
     */
    private function isQueryCached(){
        global $db;
        $query = "SELECT id_cache,key_sql,result,timestamp FROM cache WHERE key_sql='".md5($this->query)."' LIMIT 1";
        $arr = $db->QueryArray($query,MYSQL_ASSOC);        
        if(!$arr){
            return false;
        }else{
            if(strtotime($arr[0]["timestamp"]) <= (strtotime(date('Y-m-d H:i:s')) - CACHE_RELOAD)){
                return "cached";
            }
            return unserialize($arr[0]["result"]);
        }
    }
    /**
     * Caches a query
     */
    private function cacheQuery($results){
        global $db;
        if(!$this->query){
            return false;
        }
        if(is_null($results) || count($results) == 0){
            $send = "";
        }else{
            $send = serialize($results);
        }
        $sql = "INSERT INTO cache (key_sql,result) VALUES('".md5($this->query)."','".$send."')";
        $db->Query($sql);
    }
    /**
     * Adds a query to query history
     */
    public function addToHistory($cached,$success,$error){
        $result["query"] = $this->query;
        $result["cached"] = $cached;
        if($success !== false){
            $result["success"] = true;
            $result["result"] = $success;
        }else{
            $result["success"] = false;
            $result["error"] = $error;
        }
        self::$queryhistory[] = $result;
        //print_r(self::$queryhistory);
    }    
    /**
     * Returns query history
     */
    public static function getQueryHistory(){
        return self::$queryhistory;
    }
}
