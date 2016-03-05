<?php
namespace CMS\Conf;
class Rewriter{
    private static $routes;
    public static function readRoutes($url){
        if(isset(self::$routes)){
            
        }else{
            $filename = $_SERVER["DOCUMENT_ROOT"]."/Init/routing.prop";
            $f = fopen($filename,"r");
            $r = fread($f,filesize($filename));
            $prop =explode("\n",$r);
            for($i=0;$i<count($prop);$i+=3){
                if($i >= count($prop) -1){
                    continue;
                }
                $prop[$i+1] = trim($prop[$i+1]);
                $prop[$i+2] = trim($prop[$i+2]);
                if(substr($prop[$i+1],0,4) == "path"){
                    $path = explode(":",$prop[$i+1]);
                    $path = $path[1];
                    if(substr($prop[$i+2],0,4) == "page"){
                        $page = explode(":",$prop[$i+2]);
                        $page = $page[1];
                    }
                    $path = ltrim($path,"/");
                    if($path == $url){
                        $perc = explode("\\",$page);
                        $file = $_SERVER["DOCUMENT_ROOT"]."/";
                        for($i=1;$i<count($perc)-1;$i++){
                            $file.=$perc[$i]."/";
                        }
                        $file_php = $perc[count($perc)-1];
                        $file_normal = str_replace("//","/",$file.$file_php.".php");
                        $file_lower = str_replace("//","/",$file.strtolower($file_php).".php");
                        $file_upper = str_replace("//","/",$file.strtoupper($file_php).".php");
                        $file_first = str_replace("//","/",$file.ucfirst($file_php).".php");
                        if(file_exists($file_normal)){
                            require_once($file_normal);
                            break;
                        }elseif(file_exists($file_lower)){
                            require_once($file_lower);
                            break;
                        }elseif(file_exists($file_upper)){
                            require_once($file_upper);
                            break;
                        }elseif(file_exists($file_first)){
                            require_once($file_first);
                            break;
                        }else{
                            echo "MISPELLED";
                            break;
                        }
                    }
                }
            }
        }
    }
    public static function readAllRoutes(){
        
    }
    public static function findUrl($url){
        
    }
}
/*class Route{
    private $key;
    private $path;
    private $route;
    public function __construct($key,$path,$route){
        $this->key = $key;
        $this->path = $path;
        $this->route = $route;
    }
    public function getUrl(){
        
    }
}*/
spl_autoload_register(function($class){
    $class_name = explode("\\",$class);
    $percorso = $_SERVER["DOCUMENT_ROOT"]."/";
    for($i=1;$i<count($class_name)-1;$i++){
        $percorso.=$class_name[$i]."/";
    }
    $percorso.=$class_name[count($class_name)-1].".php";
    if(file_exists($percorso)){
        require_once(str_replace("//","/",$percorso));
        if($class_name[count($class_name)-1] == "Config"){
            $class::readProperties();
            $class::readParameters();
        }
    }
});
$url = $_GET["url"];
$page = $_SERVER["DOCUMENT_ROOT"]."/".$url;
if(file_exists($page)){
    require_once($page);
}else{
    Rewriter::readRoutes($url);
}
//print_r($_GET);

