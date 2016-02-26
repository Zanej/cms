<?php
    namespace CMS\Conf;
    use CMS\DbWorkers\Table;
    use CMS\DbWorkers\DbElement;
    use CMS\DbWorkers\MySQL as DB;
    class Config{
        private static $db;
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
                throw new \Exception("Errorr");
            }
            /* @var self::$db MySQL*/
            $keys = self::$db->getAllKeys($table);
            $columnnames = self::$db->GetColumnNames($table);
            $spaces= "    ";
            fwrite($fop,"<?php\n".$spaces."namespace CMS\Data;\n");
            fwrite($fop,$spaces."use CMS\DbWorkers\DbElement; \n");
            fwrite($fop,$spaces."class ".ucfirst($table)." extends DbElement{\n");
            foreach($columnnames as $chiave => $column){
                fwrite($fop,$spaces.$spaces."/**\n");
                fwrite($fop,$spaces.$spaces." *@var ".self::$db->getColumnType($column,$table)."\n");
                if(isset($keys[$column])){
                    fwrite($fop,$spaces.$spaces." *@key ".$keys[$column]["key_name"]."|".$keys[$column]["key_type"]."\n");
                }
                fwrite($fop,$spaces.$spaces." *@default ".self::$db->GetDefaultValue($column,$table)."\n");
                fwrite($fop,$spaces.$spaces." *@extra ".self::$db->GetColumnExtras($column,$table)."\n");
                fwrite($fop,$spaces.$spaces." *@nullable ".self::$db->IsNullableColumn($column,$table)."\n");
                fwrite($fop,$spaces.$spaces." */\n");
                fwrite($fop,$spaces.$spaces."protected $".$column.";\n");
            }
            foreach($columnnames as $chiave => $column){
                fwrite($fop,$spaces.$spaces."public function set".ucfirst($column)."($".$column."){\n");
                fwrite($fop,$spaces.$spaces.$spaces."\$this->".$column."=$".$column.";\n");
                fwrite($fop,$spaces.$spaces."}\n");
            }
            foreach($columnnames as $chiave => $column){
                fwrite($fop,$spaces.$spaces."public function get".ucfirst($column)."(){\n");
                fwrite($fop,$spaces.$spaces.$spaces."return \$this->".$column.";\n");
                fwrite($fop,$spaces.$spaces."}\n");
            }
            fwrite($fop,"\n} ?>");
        }
    }
	

