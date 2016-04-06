<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CMS\Conf;

/**
 * Description of Route
 *
 * @author zane2
 */
class Route {
    static function checkValidRoute($url,$route){
        $prefix = "";
        $where = 0;
        for($i=1;$i<=strlen($route);$i++){
            if(substr($url,0,$i) == substr($route,0,$i)){
                $prefix.=$url[$i-1];
            }else{
                $where = $i-1;
                break;
            }
        }
        if($prefix == $route){
            return true;
        }else{
            if(substr_count($route,"{") == 0){
                return false;
            }
            if(substr_count($url,"{") != substr_count($url,"}")){
                throw new \Exception("Syntax error in route $route");
            }
            $keys = substr($route,$where);
            $params = substr($url,$where);
            $values = self::getUrlParams($params, $keys);
            if(count($values) > 0){
                return $values;
            }else{
                return false;
            }
        }
    }
    /**
     * 
     * @param type $afterurl
     * @param type $exafterurl
     */
    static function getUrlParams($afterurl,$exafterurl){
        $values = array();
        $chiavi = array();
        $counter = 0;
        $offset_val = 0;
        for($j=0;$j<strlen($exafterurl);$j++){
            $pos_graf = strpos($exafterurl,"{",$j);
            $pos = strpos($exafterurl,"}",$j);
            if($pos === false){
                break;
            }
            if($pos_graf > $pos){
                $chiavi[$counter] = str_replace("{","",substr($exafterurl,$j,($pos-$j)));
                $divisore = "";
            }else{
                $chiavi[$counter] = str_replace("{","",substr($exafterurl,$pos_graf,($pos-$pos_graf)));
            }
            $new_pos_graf = strpos($exafterurl,"{",$pos);
            if($new_pos_graf !== false){
                $divisore = substr($exafterurl,$pos+1,($new_pos_graf-$pos-1));
                $find = strpos($afterurl,$divisore,$offset_val);
                $values[$counter] = substr($afterurl,$offset_val,$find-$offset_val);
                $offset_val = $find+1;
            }else{
                $values[$counter] = substr($afterurl,$offset_val);
                if(substr($values[$counter],strlen($values[$counter]-1) == "/")){
                    $values[$counter] = substr($values[$counter],0,strlen($values[$counter]-1));
                }
            }
            $counter++;
            $j = $pos;
            //echo $pos;
            //exit;
        }
        $val_array = array();
        foreach($chiavi as $key => $val){
            $val_array[$val] = $values[$key];
        }
        return $val_array;
    }
    /**
     * 
     * @param type $method
     */
    static function methodExists($method){
        $perc = explode("\\",$method);
        $file = $_SERVER["DOCUMENT_ROOT"];
        for($i=1;$i<count($perc)-2;$i++){
            $file.=$perc[$i]."/";
        }
        $file_php = $perc[count($perc)-2];
        $filename = Rewriter::fileVariants($file, $file_php);
        if($filename === false){
            return false;
        }
        $class = substr($method,0,strrpos($method,"\\"));
        //echo $class;
        if(method_exists($class,$perc[count($perc)-1])){
            return array("class"=>$class,"method"=>$perc[count($perc)-1]);
        }
        return false;
    }
    /**
     * 
     * @param type $method
     */
    static function callMethod($method){
        
    }
}
