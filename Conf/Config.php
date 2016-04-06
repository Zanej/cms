<?php
    namespace CMS\Conf;
    use CMS\DbWorkers\Table;
    use CMS\DbWorkers\DbElement;
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
                throw new Exception("File not found");
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
                mkdir($_SERVER["DOCUMENT_ROOT"]."\Data",0777);
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
         * Designs the php class of a table
         * @param $table table name
         */
        private static function designDbClass($table){
            $filename = $_SERVER["DOCUMENT_ROOT"]."\Data\\".ucfirst($table).".php";
            $fop = fopen($filename,"w");
            if(!$fop){
                throw new \Exception("Error writing file");
            }
            /* @var self::$db MySQL*/
            $keys = self::$db->getAllKeys($table);
            $columnnames = self::$db->GetColumnNames($table);
            $spaces= "    ";
            fwrite($fop,"<?php\n".$spaces."namespace CMS\Data;\n");
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
        private static function designDbController($table){
            $filename = $_SERVER["DOCUMENT_ROOT"]."\Controller\\".ucfirst($table)."Controller.php";
            $fop = fopen($filename,"w");
            $spaces="    ";
            if(!$fop){
                throw new \Exception ("Error writing file");
            }
            fwrite($fop,"<?php\n".$spaces."namespace CMS\Controller;\n");
            //fwrite($fop,$spaces."use CMS\Controller\AbstractController \n");
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
    }
	

