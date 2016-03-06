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
        $upd = $this->qb->update($table,$params,array($this->getKeyName()=>$this->$this->getKeyName()));
        if($upd){
            $this->return["success"] = true;
        }else{
            $this->return["succes"] = false;
        }
    }
    
}
