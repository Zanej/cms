<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CMS\Conf;
use CMS\DbWorkers\Table as Tab;
use CMS\Conf\Config;
/**
 * Description of Bundle
 *
 * @author zane2
 */
class Bundle {
    private $namespace;
    private $name;
    private $entities;
    private $controllers;
    /**
     * 
     * @param type $bundlename
     * @param type $tables
     * @param type $update
     */
    public function __construct($bundlename,$tables=array(),$update = 0){
        $dir = $bundlename."Bundle";
        $this->name = $bundlename;
        $this->namespace = "CMS\\".$dir;
        $dir = $_SERVER["DOCUMENT_ROOT"]."\\".$dir;
        if(!file_exists($dir)){
            mkdir($dir,0755);
            foreach($tables as $nome => $campi){
                if(is_array($campi) && !Tab::exists($nome)){
                    $result = Tab::create($nome,$campi);
                }else{
                    $result = true;
                    $nome = $campi;
                }
                
                if($result){
                    $this->createController($nome);
                    $this->createEntity($nome);                    
                }
            }
        }else{
            if($update == 1){
                foreach($tables as $name){
                    $keys = Config::getDB()->getAllKeys($name);
                    $creator = new EntityCreator($name, $keys,"", $this->name);
                    $creator->updateFromDatabase();
                    if(!file_exists($_SERVER["DOCUMENT_ROOT"]."\\".$this->name."Bundle"."\Controller\\".$name."Controller")){
                        $this->createController($name);
                    }
                }
            }
            if($update == 2){
                foreach($tables as $name){
                    $keys = Config::getDB()->getAllKeys($name);
                    $creator = new EntityCreator($name, $keys,"", $this->name);
                    $creator->updateToDatabase();
                }
            }
        }
    }
    public function createController($name){
        if(!class_exists($this->namespace."\\Controller\\".ucfirst($name)."Controller")){
            $creator = new ControllerCreator($name, $this->name);
        }
    }
    public function createEntity($name){
        $keys = Config::getDB()->getAllKeys($name);
        $creator = new EntityCreator($name,$keys,"", $this->name);
        $creator->create();
    }
}
