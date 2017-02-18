<?php
namespace CMS\Conf;
use CMS\Conf\Config as Config;
use \CMS\AdminBundle\Controller\Adm_usersController as AdminController;
use CMS\AdminBundle\Entity\Adm_users as User;

error_reporting(E_ERROR);
session_start();
require_once(__DIR__."/smarty/libs/Smarty.php");
class Rewriter{
    private static $routes;
    public static function readRoutes($url,$params=array()){

        $check =array();

        $filename = $_SERVER["DOCUMENT_ROOT"]."/Init/routing.prop";
        $f = fopen($filename,"r");
        $r = fread($f,filesize($filename));
        $prop =explode("\n",$r);

        for($i=0;$i<count($prop);$i++){                
            if(substr($prop[$i],0,4) != "    "){
                continue;
            }                
            $params = array();
            $row = true;
            while($row){
                $row = self::readRoutingRow($prop[$i++]);                    
                if($row){
                    $params[$row[0]] = $row[1];                                                
                }
            }
            
            self::$routes[$params['path']] = $params;
            $i--;

            $check_what = self::checkMe($url, $params);                                
        }
        
//        echo "<pre>";
//            print_r(RouteReg::$possibili);
//        echo "</pre>";
        
        if(is_array(RouteReg::$possibili)){
            
            if(count(RouteReg::$possibili) == 1){
                
                $route_found = RouteReg::$possibili[0];
                
                $route_found['page'] = self::$routes[$route_found['route']]['page'];
                
                $file = self::fileExists($route_found["page"]);

                if($file){

                    require_once($file);
                    exit;
                }
                
                
                
                $method = Route::methodExists($route_found["page"]);
                

                if($method !== false){

                    
                    $object = new $method["class"];                    
                    $keys = $route_found['matches'];
                    $values = array();
                    $parameters_add = array();
                    
                    if(is_array($route_found['parameters'])){
                        
                        
                        foreach($route_found['parameters'] as $kpp => $vpp){
                            
                            $obj_vars = get_object_vars($vpp);
                            
                            $parameters_add[key($obj_vars)] = $obj_vars[key($obj_vars)];
                        }
                    }
                    
                    foreach($keys as $kk => $vv){
                        $keys[$kk] = str_replace(array("{","}","$"),"", $vv);
                        
                        $values[$keys[$kk]] = $route_found["values"][$kk][0];
                    }
                    
                    foreach($parameters_add as $kpa => $vpa)
                        $values[$kpa] = $vpa;
                    
//                    print_r($values);
                    return call_user_func_array(array($object,$method["method"]), $values);                    
                }
//                return false;
            
            }
        }
//                
    }
    /**
     * 
     * @param type $url
     * @param type $params
     */
    private static function checkMe($url,$params){

        if(count($params) > 0 && isset($params["path"]) && isset($params["page"])){
            
            // echo "<pre>";
            //     print_r($params["parameters"]);
            // echo "</pre>";
            $is_it = RouteReg::checkValidRoute($url, $params["path"], $params, isset($params["parameters"]) ? json_decode($params["parameters"]) : array());            
            
        }
        return false;
    }
    /**
     * 
     * @param type $prop
     * @param type $index
     * @return boolean
     */
    private static function readRoutingRow($row){
        //echo $row;
        if(!strstr($row,":") || substr($row,0,4) != "    "){
            return false;
        }
        $riga = explode(":",$row);        
        if(count($riga) > 2 && substr(trim($row),0,strlen("parameters")) != "parameters"){

            return false;

        }elseif(substr(trim($row),0,strlen("parameters")) == "parameters"){

            $riga[1] = substr($row,strpos($row,":")+1);

            if(substr($riga[1],0,1) != "[" && substr($riga[1],-1) != "]"){

                throw new \Exception("Invalid JSON - ".$riga[1], 1);
                
                return false;
            }

            $param_json = json_decode($riga[1]);

            if(json_last_error() != JSON_ERROR_NONE){

                throw new \Exception("Invalid JSON - ".$riga[1], 1);

                return false;
            }

        }
                
        
        foreach($riga as $key => $val){

            $riga[$key] = trim($val);

            if(substr($riga[$key],0,1) == "/"){

                $riga[$key] = substr($riga[$key],1);
            }
        }
//        echo "<pre>";
//        print_r($riga);
//        echo "</pre>";
        
        return $riga;
    }
    /**
     * 
     * @param type $page
     * @return boolean
     */
    private static function fileExists($page){
        $perc = explode("\\",$page);
        $file = $_SERVER["DOCUMENT_ROOT"]."/web/";
        for($i=1;$i<count($perc)-1;$i++){
            $file.=$perc[$i]."/";
        }        
        $file_php = $perc[count($perc)-1];
        //echo $file_php;
        return self::fileVariants($file,$file_php);
    }
    /**
     * 
     * @param type $dir
     * @param type $filename
     */
    static function fileVariants($dir,$filename){
        $file_normal = str_replace("//","/",$dir.$filename.".php");
        $file_lower = str_replace("//","/",$dir.strtolower($filename).".php");
        $file_upper = str_replace("//","/",$dir.strtoupper($filename).".php");
        $file_first = str_replace("//","/",$dir.ucfirst($filename).".php");
        if(file_exists($file_normal)){

            return $file_normal;
        }elseif(file_exists($file_lower)){

            return $file_lower;
        }elseif(file_exists($file_upper)){

            return $file_upper;
        }elseif(file_exists($file_first)){

            return $file_first;
        }
        return false;
    }
    public static function readAllRoutes(){
        
    }
    public static function findUrl($url){
        
    }
}

spl_autoload_register(function($class){
    $class_name = explode("\\",$class);
    $percorso = $_SERVER["DOCUMENT_ROOT"]."/";
    for($i=1;$i<count($class_name)-1;$i++){
        $percorso.=$class_name[$i]."/";
    }
    $percorso.=$class_name[count($class_name)-1].".php";
    if(strstr($percorso,"Smarty")){
        //echo $percorso;
    }
    
    if(file_exists($percorso)){
        require_once(str_replace("//","/",$percorso));
        /*if($class_name[count($class_name)-1] == "Config"){
            $class::setSmarter();
            $class::readProperties();
            $class::readParameters();
        }*/
    }
});

Config::readParameters();
Config::setSmarter();
Config::readProperties();
if(!Config::checkReservedDirs()){

    $url = urldecode(substr($_SERVER["REQUEST_URI"],1));
    $page = str_replace("//","/",$_SERVER["DOCUMENT_ROOT"]."/web/".$url);         
    $page_ad = str_replace("//","/",$_SERVER["DOCUMENT_ROOT"]."/".$url);        


//    echo $page_ad;

    if(file_exists($page)){        

        require_once($page);
        exit;
    }elseif(file_exists($page_ad)){        
        
//        echo "A";
        require_once($page_ad);
        exit;
    }else{

        Rewriter::readRoutes($url);
        exit;
    }
}

