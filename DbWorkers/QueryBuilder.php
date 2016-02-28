<?php
namespace CMS\DbWorkers;
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
      flush();
      $this->builders->action = "INSERT";
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
      flush();
      $this->builders->action = "SELECT";
      $this->builders->from = $table;
      $this->builders->values = implode(",",$what);
      $this->buildQuery($table,$where);
      return this;
   }
   /**
    * 
    * @param type $table
    * @param type $what
    * @param type $where
    * @return \QueryBuilder
    */
   public function update($table,$what,$where){
      flush();
      return $this;
   }
   /**
    * 
    * @param type $table
    * @param type $what
    * @param type $where
    * @return \QueryBuilder
    */
   public function delete($table,$what,$where){
      flush();
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
      $this->builders = (Object)[
         "action","values","from","where","join","group","having","order","limit" 
      ];
      //print_r($this->builders);
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
         $this->query = " SELECT ".$this->builders->values." FROM ".$this->builders->from." AS a WHERE ".$this->builders->where;
      }
   }
   private function setWhere($where){
      if($this->builders->where != ""){
         $this->builders->where.=" AND ";
      }
      foreach($where as $key => $value){
         $this->builders->where.=$key." = '".$value."' AND ";
      }
      $this->builders->where = substr($this->builders->where,strlen($this->builders->where)-4);
   }
   /**
    * 
    * @global type $db
    * @return boolean
    */
   public function getResult(){
      global $db;
      if($this->builders->action == "INSERT"){
         $db->Query($this->query);
        //echo $db->Error();
         if($db->Error())
            return false;
         return $db->getLastInsertId();
      }
   }
   //put your code here
}
