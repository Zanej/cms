<?php
    namespace CMS;
    //require_once($_SERVER["DOCUMENT_ROOT"]."/dbworkers/db_connection.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/dbworkers/db.class.inc.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/dbworkers/QueryBuilder.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/dbworkers/DbElement.class.php");
    use CMS\DbWorkers\MySQL as DB;
    
    class Config{
        private $db;
        /**
         * 
         */
        public function __construct(){
            $this->readProperties();
        }
        /**
         * 
         * @param string $filename
         * @throws Exception
         */
        private function readProperties($filename="resources.prop"){
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
                        $this->setDB($arr_prop);
                    }
                }
            }
        }
        /**
         * 
         * @param type $array
         */
        private function setDB($array){
            $this->db = new DB(true,$array["name"],$array["host"],$array["user"],$array["password"]); 
            //print_r($this->db);
        }
        /**
         * 
         * @throws \Exception
         */
        public function dataBundle(){
            if (!isset($this->db)) {
                throw new \Exception("Choose a database first");
            }
            $tables = $this->db->GetTables();
            if(!file_exists($_SERVER["DOCUMENT_ROOT"]."\Data")){
                mkdir($_SERVER["DOCUMENT_ROOT"]."\Data",0777);
            }
            $dir = $_SERVER["DOCUMENT_ROOT"]."\Data";
            foreach($tables as $key => $table){
                $filename = $dir."\\".ucfirst($table).".php";
                //if(!file_exists($filename)){
                    $fop = fopen($filename,"w");
                    if(!$fop){
                        throw new \Exception("Errorr");
                    }
                    $columnnames = $this->db->GetColumnNames($table);
                    $spaces= "    ";
                    fwrite($fop,"<?php\n".$spaces."class ".ucfirst($table)." extends DbElement{\n");
                    foreach($columnnames as $chiave => $column){
                        fwrite($fop,$spaces.$spaces."private $".$column.";\n");
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
                    /*foreach($columnnames as $chiave => $column){
                        fwrite($fop,$spaces.$spaces."private ".$column);
                    }*/
                    fwrite($fop,"\n} ?>");
                //}
                
            }
        }
    }
	

