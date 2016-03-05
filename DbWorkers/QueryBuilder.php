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
            $this->builders->values = "*";
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
            $this->builders->values.=" $key = '".$val."',";
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
    * 
    * @param type $tables
    * @param type $fields
    * @return \QueryBuilder
    */
    public function join($tables,$fields){
        return $this;
    }
    /**
    * 
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
    private function buildQuery($table,$where=""){
        if(count($this->alias) == 0){
            $this->alias[] = "a";
        }else{
            $this->alias[] = chr(ord($this->alias[count($this->alias)]-1)+1);
        }
        $this->setWhere($where);
        if($this->builders->action == "INSERT"){
            $this->query = "INSERT INTO $table (".$this->builders->from.") VALUES(".$this->builders->values.")";
            //echo $this->query;
        }
        elseif($this->builders->action == "SELECT"){
            $this->query = "SELECT ".$this->builders->values." FROM ".$this->builders->from." AS a WHERE ".$this->builders->where;
        }elseif($this->builders->action == "DELETE"){
            $this->query= "DELETE FROM ".$this->builders->from." WHERE ".$this->builders->where;
        }elseif($this->builders->action == "UPDATE"){
            $this->query=" UPDATE ".$this->builders->from." AS a SET ".$this->builders->values." WHERE ".$this->builders->where;
        }
    }
    private function setWhere($where){
        foreach($where as $key => $value){
            //echo $key." ".$value;
            $this->builders->where.=$key." = '".$value."' AND ";
        }
        $this->builders->where = substr($this->builders->where,0,strlen($this->builders->where)-4);
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
            if($db->Error()){
                return false;
            }
            return $db->getLastInsertId();
        }elseif($this->builders->action == "DELETE"){
            $db->Query($this->query);
            //echo $db->Error();
            if($db->Error()){
                return false;
            }
            return true;
        }elseif($this->builders->action == "SELECT"){
            $cache = $this->isQueryCached();
            if($cache !== false){
                return $cache;
            }
            $arr = $db->QueryArray($this->query,MYSQLI_ASSOC);
            if($db->Error()){
                return false;
            }
            if(count($arr) == 1 && count($arr[0]) == 1){
                $arr = $arr[0][0];
            }
            $this->cacheQuery($arr);
            return $arr;
        }elseif($this->builders->action == "UPDATE"){
            $res = $db->Query($this->query);
            return $res;
        }
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
}
