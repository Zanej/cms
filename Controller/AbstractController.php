<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CMS\Controller;
use CMS\DbWorkers\Table;
use CMS\Conf\Config;
/**
 * Description of AbstractController
 *
 * @author zane2
 */
abstract class AbstractController extends Table{
    private $rows;
    private $wheredone;
    public function __construct($name){
        parent::__construct($name);
        $this->rows = [];
        $this->wheredone = [];
    }
    /**
     * Returns the primary key
    */
    public static function getKeyName(){
        $class_name = get_called_class();
        $real_name = str_replace("controller","",strtolower(substr($class_name,strrpos($class_name,"\\")+1)));
        //echo Config::getDB()->getPrimaryKey($real_name);
        return Config::getDB()->getPrimaryKey($real_name);
    }
    /**
     * Finds records by attributes
     * @param type $where
     */
    public function findBy($where){
        $find = $this->isInController($where);
        if($find !== false){
            return $this->rows[$find];
        }
        $this->wheredone[] = $where;
        if($where == "*"){
            $where = "";
        }
        $associative = parent::findBy($where);
        $new_arr = $associative;
        /*foreach($associative as $key => $val){
            $nome_id = ucwords($val->getKeyName());
            $nome_metodo="get".str_replace(" ","",ucwords(str_replace("_"," ",$nome_id)));
            $new_arr[$val->$nome_metodo()] = $val;
        }*/
        $this->rows[] = $new_arr;
        return $new_arr;
        //print_r($this->rows);
    }
    private function isInController($where){
        $trovato = true;
        foreach($this->wheredone as $key => $outer){
            foreach($outer as $chiave => $val){
                if(!array_key_exists($chiave,$where) || (array_key_exists($chiave,$where) && $where[$chiave] != $val)){
                    $trovato = false;
                }
            }
            if($trovato){
                return $key;
                
            }
        }
        return false;
    }
    /**
     * Refreshes from database
     */
    public function refresh($element){
        if(is_array($element)){
            foreach($element as $chiave => $elem){
                foreach($this->rows as $key => $outer){
                    $nome_id = ucwords($this->getKey());
                    $nome_metodo="get".$nome_id;
                    $outer[$elem->$nome_metodo()]->updateParams();
                }
            }
        }else{
            foreach($this->rows as $key => $outer){
                $nome_id = ucwords($this->getKey());
                $nome_metodo="get".$nome_id;
                $outer[$element->$nome_metodo()]->updateParams();
            }
        }
        
    }
    /**
     * Refreshes everything from database
     */
    public function refreshAll(){
        foreach($this->wheredone as $key => $outer){
            $inner = [];
            foreach($outer as $chiave => $val){
                $inner[$chiave] = $val;
            }
            $queries[] = $inner;
        }
        $this->wheredone = [];
        $this->rows = [];
        foreach($queries as $val){
            $this->findBy($val);
        }
    }
    /**
     * Render a file based on smarty
     * @param type $templatename Template name
     * @param type $params parametri
     */
    public function render($templatename,$params){
        if(!file_exists($_SERVER["DOCUMENT_ROOT"]."/Resources/$templatename.tpl")){
            throw new \Exception("Template not found!");
        }else{
            $filename = $_SERVER["DOCUMENT_ROOT"]."/Resources/$templatename.tpl";
        }
        /* @var CMS\Conf\Smarty $smarty*/
        $smarty = Config::getSmarter();
        //print_r($params);
        //exit;
        foreach($params as $key => $val){
            $smarty->assign($key,$val);
        }
        $smarty->display($filename);
    }
    public function getRows(){
        return $this->findBy("*");
    }
}
