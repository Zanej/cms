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
    
    public function __construct($id,$params="*"){
        $this_table = strtolower(substr(get_class($this),strrpos(get_class($this),"\\")+1));
        //echo $this_table;
        parent::__construct($id,$params,$this->getKeyName(),$this_table);
    }
    public function getKeyName(){
        $this_class = get_class($this);
        $name = "\\".substr($this_class,0,strpos($this_class,"\\"));
        $name.="\Controller\\".substr($this_class,strrpos($this_class,"\\")+1)."Controller";
        /* @var AbstractController $name*/
        return $name::getKeyName();
    }
    //put your code here
}
