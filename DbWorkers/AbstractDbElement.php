<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CMS\DbWorkers;

/**
 * Description of AbstractDbElement
 *
 * @author zane2
 */
abstract class AbstractDbElement extends DbElement{
    private $qb;
    /**
     * 
     * @param type $id
     * @param type $params
     */
    public function __construct($id,$params="*"){

        $this->qb = new QueryBuilder();        
        $this_table = strtolower(substr(get_class($this),strrpos(get_class($this),"\\")+1));                     
        $this_class = get_class($this);                
        $pos_first = strpos($this_class,"\\");
        $pos_second = strpos($this_class,"\\",$pos_first+1);        
        $name = "\\".substr($this_class,0,$pos_second);
        $name.="\Controller\\".substr($this_class,strrpos($this_class,"\\")+1)."Controller";               
        $key_name = $name::getKeyName(); 
        
        $this->key_name = $key_name;                

        parent::__construct($id,$params,$key_name,$this_table);
    }
    /**
     * 
     * @return type
     */
    public function getKeyName(){

        return $this->key;
    }
    /**
     * Creates a new Element
     * @param array $params
     */
    public function create($params){
        //print_r($params);
        $ins = $this->qb->insert($this->table,$params)->getResult();
        if($ins !== false){
            $this->return["success"] = true;
            $this->updateParams($ins);
        }else{
            $this->return["success"] = false;
        }
    }
    /**
     * Updates this element
     * @param array $params
     */
    public function update($params){
        $key = $this->getKeyName();
        $upd = $this->qb->update($this->table,$params,array($key=>$this->$key))->getResult();
        if($upd){
            $this->return["success"] = true;
        }else{
            $this->return["success"] = false;
        }
    }
    /**
     * Saves this element to db
     */
    public function save(){
        $vars = get_object_vars($this);        
        foreach($vars as $key => $val){                        
            if(!array_key_exists($key,$this->params) || $this->params[$key] == $vars[$key] || 
                htmlentities($this->params[$key]) == $vars[$key] || $this->params[$key] == htmlentities($vars[$key])){
                unset($vars[$key]);
            }
        }                

        if(count($vars) == 0){
            $this->return["success"] = true;
        }else{

            $variable = $this->key;                        

            $upd = $this->qb->update($this->table,$vars,array($variable=>$this->$variable))->getResult();            

            if($upd){

                $this->params = $vars;

                $this->return["success"] = true;
            }else{

                $this->return["success"] = false;
            }
        }
    }
    /**
     * 
     * @param type $field
     * @return type
     */
    public function getterName($field){
        $field_get = str_replace(" ","",ucwords(str_replace("_"," ",$field)));
        return "get".$field_get;
    }
    /**
     * 
     * @param type $field
     * @return type
     */
    public function setterName($field){
        $field_set = str_replace(" ","",ucwords(str_replace("_"," ",$field)));
        return "set".$field_set;
    }
    
}
