<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CMS\Conf;

/**
 * Description of Console
 *
 * @author zane2
 */
class Console {
    /**
     * 
     * @param type $name
     */
    public static function getController($name){
        if(strpos($name,":") === false){
            $obj = "\CMS\DataBundle\Controller\\".$name."Controller";
        }else{
            $path = str_replace(":","\\",substr($name,0,strrpos($name,":")));
            $path.="\\Controller\\";
            $obj = "\CMS\\".$path.substr($name,strrpos($name,":")+1)."Controller";
        }
        return new $obj();
    }
    /**
     * 
     * @param type $name
     */
    public static function getElement($name,$where){
        if(strpos($name,":") === false){
            $obj = "\CMS\DataBundle\\Entity\\".$name;
        }else{
            $path = str_replace(":","\\",substr($name,0,strrpos($name,":")));
            $path.="\\Entity\\";
            $obj = "\CMS\\".$path.substr($name,strrpos($name,":")+1);
        }
        return new $obj();
    }
    /**
     * Creates a controller and the table associated
     * @param string $bundlename bundle name
     * @param string $name controller/table name
     * @param array $values values 
     */
    public static function createController($bundlename,$name,$values){
        $res = \CMS\DbWorkers\Table::create($name, $values);
        if($res){
            self::createBundle($bundlename,array($name));
        }
        #$dirname = $_SERVER["DOCUMENT_ROOT"]."\\".$bundlename."Bundle";
        
    }
    /**
     * Updates the tables from php bundle
     */
    public static function updateBundle($bundlename = "Data"){
        //$bundle = new Bundle($bundlename);
        $dir = $bundlename."Bundle\Entity";
        $namespace = "CMS\\".$dir;
        $dir = $_SERVER["DOCUMENT_ROOT"]."\\".$dir;
        if(!file_exists($dir)){
            throw new Exception("Bundle not found");
        }
        $files = scandir($dir);
        foreach($files as $val){
            $realfile = $dir."\\".$val;
            $info = pathinfo($realfile);
            if($info["extension"] == "php"){
                $class = $namespace."\\".basename($val,".php");
                if(class_exists($class)){
                    $righe = explode("\n",file_get_contents($realfile));
                    foreach($righe as $key => $riga){
                        $righe[$key] = trim(strip_tags($riga));
                    }
                    foreach($righe as $key => $riga){
                        if($riga == "/**"){
                            $field = Field::isField($righe, $key+1);
                            if($field !== false){
                                print_r($field);
                            }
                            echo "<br>";
                        }
                        
                    }
                    //print_r($righe);
                    //echo addslashes($contenuto)."\n";
                }
            }
        }
        //print_r($files);
        //echo $dir;
        exit;
    }
    /**
     * Creates a bundle
     */
    public static function createBundle($bundlename = "Data",$tables = array()){
        $dirname = $_SERVER["DOCUMENT_ROOT"]."\\".$bundlename."Bundle";
        if(!file_exists($dirname)){
            mkdir($dirname, 0755);
        }
        if(count($tables) > 0){
            foreach($tables as $key => $val){
                if(\CMS\DbWorkers\Table::exists($val)){
                    \CMS\Conf\Config::createBundle($bundlename, $tables);
                }
            }
        }
    }
    //put your code here
}
