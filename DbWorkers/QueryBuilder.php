<?php
namespace CMS\DbWorkers;
use CMS\Conf\Config;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
    private static $queryhistory;
    function __construct() {
        flush();
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
        $this->checkValuesType($what, $table);
        foreach($what as $key => $val){
            $this->builders->values.=" a.$key = '".$val."',";
        }
        $this->builders->values = substr($this->builders->values,0,-1);
        $this->buildQuery($table, $where);
        //echo $this->query;
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
        //echo $this->query; 
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
                $this->builders->where.="$newalias.$key = '$val' AND ";
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
            //echo $al;
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
    }
    /**
     * 
     * @param type $where
     */
    private function setWhere($where){
        foreach($where as $key => $value){
            //echo $key." ".$value;
            if($this->builders->action !== "DELETE"){
                $this->builders->where.="a.$key = '".$value."' AND ";
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
    public function getResult(){
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
            return $this->selectCached();
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
    private function selectCached(){
        $db = Config::getDb();
        $cache = $this->isQueryCached();
        if($cache !== false){
            $this->addToHistory(true, is_array($cache) ? $cache : false, "Errors");
            return $cache;
        }
        $arr = $db->QueryArray($this->query,MYSQLI_ASSOC);
        if($db->Error()){
            $this->addToHistory(false, false, $db->Error());
            return false;
        }
        if(count($arr) == 1 && count($arr[0]) == 1){
            $arr = $arr[0][0];
        }
        $this->addToHistory(false, $arr, "");
        $this->cacheQuery($arr);
        return $arr;
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
            if($type == "VAR_STRING" || $type == "VAR_BLOB"){
                $values[$key] = addslashes(htmlentities($val));                
            }
        }
    }
    /**
     * Check if a query is cached
     */
    private function isQueryCached(){
        $filename = $_SERVER["DOCUMENT_ROOT"]."/var/querycache";
        $arr = json_decode(file_get_contents($filename));
        if($arr != "" && is_array($arr)){
            foreach($arr as $key => $outer){
                if($outer->query == $this->query){
                    if(time() - strtotime($outer->time) > CACHE_RELOAD){
                        unset($arr[$key]);
                        $new_arr = [];
                        foreach($arr as $value){
                            $new_arr = $value;
                        }
                        $handle = fopen($filename,'w');
                        fwrite($handle,json_encode($new_arr));
                        fclose($handle);
                        return false;
                    }else{
                        if(is_array($outer->result)){
                            $result = $outer->result;
                            foreach($result as $key => $res_obj){
                                $result[$key] = get_object_vars($res_obj);
                            }
                            return $result;
                        }
                    }
                    return $outer->result;
                }
            }
        }
        return false;
    }
    /**
     * Caches a query
     */
    private function cacheQuery($results){
        $filename =$_SERVER["DOCUMENT_ROOT"]."/var/querycache";
        $arr = json_decode(file_get_contents($filename));
        $query["time"]=date('Y-m-d H:i:s');
        $query["query"]=$this->query;
        $query["result"]=$results;
        $arr[] = $query;
        $handle = fopen($filename,"w");
        fwrite($handle,json_encode($arr));
        fclose($handle);
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
    }
    /**
     * Returns query history
     */
    public static function getQueryHistory(){
        return self::$queryhistory;
    }
}
