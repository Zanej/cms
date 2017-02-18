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
class RouteReg {
    
    public static $possibili = array();
    
    static function checkValidRoute($url,$route, $pars, $parameters = array()){
                  
        
        if(substr_count($route,"{") == 0 && strlen($url) != strlen($route)){

            return false;
        }
                               
        if(substr_count($route,"{") > 0){
            
            $matches = array();
            $m = preg_match_all("({(.*?)})", $route, $matches);
            
            $params = array();
            $arr_pos = array();
            $arr_pos_next = array();            
            $arr_regexp = array();
            $index_trov = 0;
            if($m > 0){
                
                $params = $matches[0];
            }
            
            foreach($params as $k => $v){
//                
                $index_trov = strpos($route, $v, $index_trov);
//                
                $arr_pos[$k] = $index_trov - 1;
//                
                $index_trov+=strlen($v);
//                
                if($index_trov >= strlen($route) - 1)
                    $index_trov = strlen($route) - 1;
                
                $arr_pos_next[$k] = $index_trov;
//                
            }
                        
            $regexp_rules = array();
            if(isset($pars['rules']) && json_decode($pars['rules']) != null && json_last_error() == JSON_ERROR_NONE){
                
                $regexp_rules = json_decode($pars['rules']);
            }
            
            $string_reg = "";
            $ind_pre = 0;
            foreach($arr_pos as $k => $v){
                                         
                if(isset($regexp_rules[$k]))
                    $reg_usa = $regexp_rules[$k];
                else
                    $reg_usa = "(.+)";
                
                $string_reg.= substr($route,$ind_pre,$v + 1 - $ind_pre).$reg_usa;
                
                $arr_regexp[$k] = $reg_usa;
                $ind_pre = $arr_pos_next[$k];                                
                
                if(count($arr_pos) == $k + 1){
                    
                    if($ind_pre < strlen($route) - 1)
                        $string_reg.=substr($route,$ind_pre);
                }
            }

            $values = array();
            
//            echo "<pre>".$string_reg."</pre>";
            if(preg_match_all("#".$string_reg."$#iUs", $url, $values)){
                
                $split = preg_split("#".$string_reg."$#iUs", $url);
                
                $continua = true;
                foreach($split as $k => $v){
                    if($v != ""){
                        $continua = false;
                    }
                }
                
                if($continua){
                    $val_passa = array();

                    foreach($values as $kv => $vv)
                        if($kv > 0)
                            $val_passa[] = $vv;
                        
                    self::$possibili[] = array("route" => $route, "reg" => "#".$string_reg."#iUs", "url" => $url, "matches" => $params, "values" => $val_passa, "parameters" => $parameters);
                }
            }
            
        }elseif($route == $url){
            self::$possibili[] = array("route" => $route,  "url" => $url, "matches" => array(), "values" => array(), "parameters" => $parameters);
        }
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
