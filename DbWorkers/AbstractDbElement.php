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
        //echo $this_table;
        parent::__construct($id,$params,$this->getKeyName(),$this_table);
    }
    /**
     * 
     * @return type
     */
    public function getKeyName(){
        $this_class = get_class($this);
        $name = "\\".substr($this_class,0,strpos($this_class,"\\"));
        $name.="\Controller\\".substr($this_class,strrpos($this_class,"\\")+1)."Controller";
        /* @var AbstractController $name*/
        return $name::getKeyName();
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
            if(!isset($this->params[$key]) || $this->params[$key] == $vars[$key] || 
                htmlentities($this->params[$key]) == $vars[$key] || $this->params[$key] == htmlentities($vars[$key])){
                unset($vars[$key]);
            }
        }
        if(count($vars) == 0){
            $this->return["success"] = true;
        }else{
            $variable = $this->getKeyName();
            $upd = $this->qb->update($this->table,$vars,array($variable=>$this->$variable))->getResult();
            if($upd){
                $this->params = $vars;
                $this->return["success"] = true;
            }else{
                $this->return["success"] = false;
            }
        }
    }
    
}
