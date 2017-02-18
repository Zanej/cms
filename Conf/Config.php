<?php
    namespace CMS\Conf;
    use CMS\DbWorkers\Table;
    use CMS\DbWorkers\DbElement;
    use CMS\Conf\EntityCreator;
    use CMS\Conf\ControllerCreator;
    use CMS\DbWorkers\MySQL as DB;
    //use CMS\Conf\smarty\libs\Smarty;
    class Config{
        private static $db;
        private static $smarter;
        /**
         * 
         * @param string $filename
         * @throws Exception
         */
        public static function readProperties($filename="resources.prop"){
            $filename = $_SERVER["DOCUMENT_ROOT"]."/Init/".$filename;
            $read = fopen($filename,"r");
            if(!$read){
                throw new \Exception("File not found");
            }else{
                $text = fread($read,filesize($filename));
                $properties = explode("\n",$text);
                for($i=0;$i<count($properties);$i++){
                    if($properties[$i]=="database:"){
                        $arr_prop = array();
                        while(substr($properties[++$i],0,4) === "    " && $i < count($properties)){
                            $prop_db = explode(":",substr($properties[$i],4));
                            $arr_prop[$prop_db[0]]=$prop_db[1];
                        }
                        self::setDB($arr_prop);
                    }
                }
            }
        }
        /**
         * 
         * @param type $array
         */
        private static function setDB($array){

            self::$db = new DB(true,$array["name"],$array["host"],$array["user"],$array["password"]); 
        }
        /**
         * 
         */
        public static function getDB(){
            return self::$db;
        }
        /**
         * 
         * @throws \Exception
         */
        public static function dataBundle(){
            if (!isset(self::$db)) {
                throw new \Exception("Choose a database first");
            }
            $tables = self::$db->GetTables();
            if(!file_exists($_SERVER["DOCUMENT_ROOT"]."\Data")){
                mkdir($_SERVER["DOCUMENT_ROOT"]."\Data",0755);
            }
            $dir = $_SERVER["DOCUMENT_ROOT"]."\Data";
            foreach($tables as $key => $table){
                //if(!file_exists($filename)){
                    self::designDbClass($table);
                    self::designDbController($table);
                //}
            }
        }
        /**
         * 
         * @throws \Exception
         */
        public static function createBundle($name,$tables){
            $bundle = new Bundle($name,$tables);
        }
        /**
         * Designs the php class of a table
         * @param $table table name
         */
        private static function designDbClass($table,$bundlename='Data'){
            $dir = $_SERVER["DOCUMENT_ROOT"]."\\".$bundlename."Bundle\Entity";
            if(!file_exists($dir)){
                mkdir($dir,0755);
            }
            $filename = $dir."\\".ucfirst($table).".php";
            $fop = fopen($filename,"w");
            if(!$fop){
                throw new \Exception("Error writing file");
            }
            /* @var self::$db MySQL*/
            $keys = self::$db->getAllKeys($table);
            $columnnames = self::$db->GetColumnNames($table);
            $spaces= "    ";
            fwrite($fop,"<?php\n".$spaces."namespace CMS\\".$bundlename."Bundle\Entity;\n");
            fwrite($fop,$spaces."use CMS\DbWorkers\AbstractDbElement; \n");
            fwrite($fop,$spaces."class ".ucfirst($table)." extends AbstractDbElement{\n");
            foreach($columnnames as $chiave => $column){
                self::designDbVar($fop, $spaces.$spaces, $column, $keys, $table);
            }
            foreach($columnnames as $chiave => $column){
                self::designSetter($fop,$spaces.$spaces,$column);
            }
            foreach($columnnames as $chiave => $column){
                self::designGetter($fop,$spaces.$spaces,$column);
            }
            fwrite($fop,"\n} ?>");
        }
        /**
         * Designs the controller of a table
         * @param $table table_name
         */
        private static function designDbController($table,$bundlename="Data"){
            $dir = $_SERVER["DOCUMENT_ROOT"]."\\".$bundlename."Bundle\Controller";
            if(!file_exists($dir)){
                mkdir($dir,0755);
            }
            $filename = $dir."\\".ucfirst($table)."Controller.php";
            $fop = fopen($filename,"w");
            $spaces="    ";
            if(!$fop){
                throw new \Exception ("Error writing file");
            }
            fwrite($fop,"<?php\n".$spaces."namespace CMS\\".$bundlename."Bundle\Controller;\n");
            fwrite($fop,$spaces."use CMS\Controller\AbstractController; \n");
            fwrite($fop,$spaces."class ".ucfirst($table)."Controller extends AbstractController{\n");
            self::designDbControllerConstruct($fop, $spaces.$spaces, $table);
            fwrite($fop,"\n} ?>");
        }
        /**
         * Design construct of a table controller
         */
        private static function designDbControllerConstruct($resource,$indent,$table){
            fwrite($resource,$indent."function __construct(){\n");
            fwrite($resource,$indent."    "."parent::__construct('$table');\n");
            fwrite($resource,$indent."}");
        }
        /**
         * Designs the setter of a variable
         * @param file resource $resource file resource
         * @param string $indent spaces to indent
         * @param string $column name of the variable
         */
        private static function designSetter($resource,$indent,$column){
            $column_set=str_replace(" ","",ucwords(str_replace("_"," ",$column)));
            fwrite($resource,$indent."public function set".$column_set."($".$column."){\n");
            fwrite($resource,$indent."     \$this->".$column."=$".$column.";\n");
            fwrite($resource,$indent."}\n");
        }
        /**
         * Designs the getter of a variable
         * @param file resource $resource file resource
         * @param string $indent spaces to indent
         * @param string $column name of the variable
         */
        private static function designGetter($resource,$indent,$column){
            $column_get=str_replace(" ","",ucwords(str_replace("_"," ",$column)));
            fwrite($resource,$indent."public function get".$column_get."(){\n");
            fwrite($resource,$indent."    return \$this->".$column.";\n");
            fwrite($resource,$indent."}\n");
        }
        /**
         * Designs a db variable
         * @param file resource $resource file resource
         * @param string $indent spaces to indent
         * @param string $column name of the column
         * @param array $keys table keys array
         * @param type $table name of the table
         */
        private static function designDbVar($resource,$indent,$column,$keys,$table){
            fwrite($resource,$indent."/**\n");
            fwrite($resource,$indent." *@var ".self::$db->getColumnType($column,$table)."\n");
            if(isset($keys[$column])){
                fwrite($resource,$indent." *@key ".$keys[$column]["key_name"]."|".$keys[$column]["key_type"]."\n");
            }
            fwrite($resource,$indent." *@default ".self::$db->GetDefaultValue($column,$table)."\n");
            fwrite($resource,$indent." *@extra ".self::$db->GetColumnExtras($column,$table)."\n");
            fwrite($resource,$indent." *@nullable ".self::$db->IsNullableColumn($column,$table)."\n");
            fwrite($resource,$indent." */\n");
            fwrite($resource,$indent."protected $".$column.";\n");
        }
        /**
         * Reads parameters
         */
        public static function readParameters(){
            $filename = $_SERVER["DOCUMENT_ROOT"]."/Init/parameters.prop";
            $contents = explode("\n",  file_get_contents($filename));
            foreach($contents as $val){
                if(strpos($val,":")){
                    $def = explode(":",$val);
                    define(strtoupper(trim($def[0])),trim($def[1]));
                }
            }
            //print_r(get_defined_constants(true)["user"]);
        }
        /**
         * Initialize smarter
         */
        public static function setSmarter(){
            self::$smarter = new \Smarty();
        }
        /**
         * Gets smarty object
         */
        public static function getSmarter(){
            return self::$smarter;
        }
        /**
         * Check for dirs that requires login
         */
        public static function checkReservedDirs($filename="reserved.prop"){

            $filename = $_SERVER["DOCUMENT_ROOT"]."/Init/".$filename;
            $read = fopen($filename,"r");
            if(!$read){

                throw new \Exception("File not found");
            }else{

                $text = fread($read,filesize($filename));
                $properties = explode("\n",$text);

                for($i=0;$i<count($properties);$i++){

                    if(substr($properties[$i],0,1) != " "){

                        $arr_prop = array();

                        while(substr($properties[++$i],0,4) === "    " && $i < count($properties)){
                            $prop_db = explode(":",substr($properties[$i],4));
                            $arr_prop[$prop_db[0]]=trim($prop_db[1]);
                        }
                        
                        $reserved_dirs[] = $arr_prop;
                        $i--;
                    }

                }

                foreach($reserved_dirs as $k => $v){                    

                    if(self::isReservedDir($v)){

                        return true;
                    }
                }

                return false;                
            }
        }

        private static function isReservedDir($array){                

            $check_equal = $_SERVER['REQUEST_URI'] == $array["path"] || $_SERVER['REQUEST_URI'] == "/".$array["path"] || $_SERVER['REQUEST_URI'] == $array["path"]."/" || $_SERVER['REQUEST_URI'] == "/".$array["path"]."/";

            $check = substr($_SERVER['REQUEST_URI'],0,strlen($array["path"])) == $array["path"] || substr($_SERVER['REQUEST_URI'],0,strlen($array["path"])+1) == "/".$array["path"];
            
//            echo $check_equal? "true " : "false ";
//            echo $check? "true " : "false ";
            
            if($check){

                $name = "\\".$array["controller"];                                
                
                $controller = new $name();
            }

            if( $check_equal && COUNT($_POST) > 0){ 

                if($controller::$array["login_check"]()){

                    if($array["method"] == "md5"){

                        $cook = md5($_POST["username"]).$array["separator"].md5($_POST["password"]);
                    }elseif($array["method"] == "sha1"){

                        $cook = sha1($_POST["username"]).$array["separator"].sha1($_POST["password"]);
                    }else{

                        $method = $array["method"];

                        $cook = $controller::$method($_POST["username"]).$array["separator"].$controller::$method($_POST["password"]);
                    }
                    
                    setcookie($array["cookie_name"],$cook,time()+3600*24*2,"/");

                    $user = $controller->findBy(array("username"=>$_POST["username"]));   

                    if(!isset($_SESSION["admin_user"]) || $_SESSION["admin_user"] != $_COOKIE["authenticate_user"]){

                        $_SESSION[$array["session_name"]] = $_COOKIE[$array["cookie_name"]];
                        $setAccess = true;
                    }else{

                        $setAccess = false;
                    }

                    $method_name = $array["index_action"];
                    $controller->$method_name($user[0],$setAccess);        

                    return true;
                }else{ 

                    $method_name = $array["login_action"];
                    $controller->$method_name();

                    return true;
                }
            }elseif($check && $controller->isUserLogged ()){ 

                $cook = explode($array["separator"],$_COOKIE[$array["cookie_name"]]);

                if($array["method"] == "md5"){

                    $user = $controller->findBy(array("md5(username)"=>$cook[0]));
                }elseif($array["method"] == "sha1"){

                    $user = $controller->findBy(array("sha1(username)"=>$cook[0]));
                }else{

                    $user = $controller->findBy(array("username"=>$controller->$array["method_decrypt"]($cook[0])));
                }
                

                $session_name = $array["session_name"];
                $cookie_name = $array["cookie_name"];
                
                if(!isset($_SESSION[$session_name]) || $_SESSION[$session_name] != $_COOKIE[$cookie_name]){

                    $_SESSION[$session_name] = $_COOKIE[$cookie_name];
                    $setAccess = true;
                }else{

                    $setAccess = false;
                }

                if($check_equal){

                    $controller->$array["index_action"]($user[0], $setAccess);

                    return true;
                }else{

                    return false;
                }

            }elseif($check){    

                $controller->$array["login_action"]();    
                return true;
            }else{

                return false;
            }
        }
    }
	

