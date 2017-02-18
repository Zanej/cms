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

    static function checkValidRoute($url,$route, $pars, $parameters = array()){
        $prefix = "";
        $where = 0;                      

        if(substr_count($route,"{") == 0 && strlen($url) != strlen($route)){

            return false;
        }

        $words = array();
        if(substr_count($route,"{") > 0){

            $c_url = 0;           
            $last_u = 0;
            $last_r = 0;

            $in_parentesi = false;
            $r_w = "";
            $u_w = "";

            for($i=0;$i<strlen($route);$i++){

                if($route[$i] == "{"){

                    $arr_word = array();
                    $arr_word["url"] = substr($url,$last_u,$c_url-$last_u);
                    $arr_word["route"] = substr($route,$last_r,$i-$last_r);

                    $words[] = $arr_word;

                    $i = strpos($route,"}",$i)+1;      

                    if($i >= strlen($route)){

                        continue;                        
                    }

                    $c_url = strpos($url,$route[$i],$c_url);
                    $last_u = $c_url;
                    $last_r = $i;
                }

                $c_url++;                
            }
            
        }

        foreach($words as $w){

            if($w["url"] != $w["route"]){

                return false;
            }
        }        


        for($i=1;$i<=strlen($route);$i++){

            if(substr(trim($url),0,$i) == substr(trim($route),0,$i)){

                $prefix.=$url[$i-1];                  

            }else{                

                $where = $i-1;                
                break;
            }
        }
        

        if($where == 0 && $url != "" && $prefix != $route){
            
            return false;
        }        

        if($prefix == $route){
            

        #if($prefix == $url){                    
            if(file_exists($url) && !is_dir($url)){

                return true;
            }else{
                

                $ret = array();

                if(count($parameters) > 0){

                    foreach($parameters as $k => $param){

                        $arr = get_object_vars($param);                        

                        $keys = array_keys($arr);

                        $ret[$keys[0]] = $arr[$keys[0]];
                    }
                }                                                

                return $ret;
            }
            
        }else{            

            if(substr_count($route,"{") == 0){
                return false;
            }

            if(substr_count($url,"{") != substr_count($url,"}")){
                throw new \Exception("Syntax error in route $route");
            }

            $keys = substr($route,$where);
            $params = substr($url,$where);                  

            $values = self::getUrlParams($params, $keys,$parameters);    
                           
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
    static function getUrlParams($afterurl,$exafterurl,$parameters){
        $values = array();
        $chiavi = array();
        $counter = 0;
        $offset_val = 0;
        $val_s = substr($afterurl,strlen($afterurl)-1,1) == "/" ? substr($afterurl,0,-1) : $afterurl;
        $val_e = substr($exafterurl,strlen($exafterurl)-1,1) == "/" ? substr($exafterurl,0,-1) : $exafterurl;
        $search = explode("/",$val_s);
        $search_c = explode("/",$val_e);  
        

        if(count($search) != count($search_c)){

            return false;
        }
        foreach($search_c as $ks => $vs){

            if(strpos($vs,"{") !== false && strpos($vs,"}") !== false){
                continue;
            }

            if($search[$ks] != $vs){   

                $ret = array();

                if(count($parameters) > 0){

                    foreach($parameters as $k => $param){

                        $arr = get_object_vars($param);                        

                        $keys = array_keys($arr);

                        $ret[$keys[0]] = $arr[$keys[0]];                       
                    }
                }             
                return $ret;
            }
        }        

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
                $offset_val = strpos($afterurl,"/",$find+1)+1;
            }else{

                $values[$counter] = substr($afterurl,$offset_val);
                if(substr($values[$counter],strlen($values[$counter]-1) == "/")){
                    $values[$counter] = substr($values[$counter],0,strlen($values[$counter]-1));
                }
            }

            $counter++;
            $j = $pos;
        }

        $val_array = array();
        foreach($chiavi as $key => $val){

            $val_array[$val] = $values[$key];
        }                        

        if(count($parameters) > 0){
            

            foreach($parameters as $k => $param){

                $arr_param = get_object_vars($param);                        

                $keys_arr = array_keys($arr_param);                

                $val_array[$keys_arr[0]] = $arr[$keys_arr[0]];                       
            }
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
        if(method_exists($class,$perc[count($perc)-1])){
            return array("class"=>$class,"method"=>$perc[count($perc)-1]);
        }
        return false;
    }
}
