<?php
namespace CMS\Conf;
require_once(__DIR__."/smarty/libs/Smarty.php");
class Rewriter{
    private static $routes;
    public static function readRoutes($url,$params=array()){
        if(isset(self::$routes)){
            
        }else{
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
                $i--;
                if(self::checkMe($url, $params)){
                    break;
                }
            }
        }
    }
    /**
     * 
     * @param type $url
     * @param type $params
     */
    private static function checkMe($url,$params){
        if(count($params) > 0 && isset($params["path"]) && isset($params["path"])){
            $is_it = Route::checkValidRoute($url, $params["path"]);
            if($is_it === true){
                $file = self::fileExists($params["page"]);
                if($file !== false){
                    require_once($file);
                    return true;
                }
                return false;
            }elseif(is_array($is_it)){
                $method = Route::methodExists($params["page"]);
                if($method !== false){
                    $object = new $method["class"];
                    //exit;
                    $values = implode(",",$is_it);
                    return call_user_func_array(array($object,$method["method"]), $is_it);
                    //return $object->$method["method"]($is_it);
                }
                return false;
            }
        }
        return false;
    }
    /**
     * Gets parameters from an url
     * @param type $url
     */
    private static function getUrlParameters(&$url){
        $urlnew = "";
        $parameters = array();
        if(substr_count($url,"{") != substr_count($url,"}")){
            throw new \Exception("Syntax error");
        }
        if(strpos($url,"{") === false){
            return array();
        }else{
            $find = explode("{",$url);
            foreach($find as $key => $val){
                if($key == 0){
                    $urlnew.=$val;
                }else{
                    $parameters[] = substr($val,0,strpos($val,"}"));
                    $urlnew.=substr($val,strpos($val,"}")+1);
                }
            }
        }
        $url = $urlnew;
        return $parameters;
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
        if(count($riga) > 2){
            return false;
        }
        foreach($riga as $key => $val){
            $riga[$key] = trim($val);
            if(substr($riga[$key],0,1) == "/"){
                $riga[$key] = substr($riga[$key],1);
            }
        }
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
        if($class_name[count($class_name)-1] == "Config"){
            $class::setSmarter();
            $class::readProperties();
            $class::readParameters();
        }
    }
});
$url = $_GET["url"];
$page = $_SERVER["DOCUMENT_ROOT"]."/web/".$url;
//echo $page;
//exit;
if(file_exists($page)){
    require_once($page);
}else{
    Rewriter::readRoutes($url);
}
//print_r($_GET);

