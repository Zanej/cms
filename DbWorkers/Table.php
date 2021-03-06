<?php
    namespace CMS\DbWorkers;
    use \CMS\Conf\Config;
	class Table{
        private $rows;
        protected $key;
        private $name;
        private $querybuilder;
        /**
         * 
         * @param string $name nome
         * @param boolean $force if true creates the table if doesn't exist
         * @param boolean $get returns row if true
         * @param array $values if table has to be created, these are the fields to be inserted
         */
		public function __construct($name,$force=false,$get=true,$values=null){
            $this->name = $name;
            $this->querybuilder = new QueryBuilder();
			if(is_null($values) && self::exists($name)){
                $this->key = $this->getKey();
                if($get){
                   $this->setRows();
                }
            }elseif(is_array($values)){
               if($force){
                  self::create($name,$values);
               }else{
                  $return["success"]=false;
               }
            }else{
               $return["success"] = true;
            }	
		}
        /**
         * 
         * @param type $name
         * @param type $values
         */
        public static function create($name,$values){
            $query = "CREATE TABLE $name (";
            $query.="id INTEGER AUTO_INCREMENT PRIMARY KEY ,";
            foreach($values as $key => $val){
                $query.="`".$key."` ".$val.",";
                /*$add = explode("|",$val);
                $query.=" ".$add[0]."(".$add[1].")".$add[2].",";*/
            }
            $query =substr($query,0,strlen($query)-1);
            $query.=")";
            if(strstr(strtolower($query),"references ")){
                $query.=" ENGINE='InnoDB'";
                Config::getDB()->Query("SET FOREIGN_KEY_CHECKS=1");
            }
            if(Config::getDb()->Query($query)){
                //echo json_encode(array("success"=>true));
                return true;
            }else{
                //echo $query;
                return false;
            }
        }
        /**
         * 
         * @param type $table_name Nome della tabella
         */
        public static function exists($table_name){
           Config::getDb()->Query("SELECT * FROM $table_name LIMIT 1");
           return !Config::getDb()->Error();
        }
        /**
         * 
         * @param type $params
         */
		public function insert($params){
			$db_elem = new DbElement(null,$params,$this->key,$this->name);
            return $db_elem->getResult();
		}
        /**
         * 
         * @param type $where
         * @param boolean $cacheable
         */
        public function findBy($where,$cacheable = true,$fields="*",$limit_from="",$limit_to=""){
            /*if(is_array($fields)){
                $fields = implode(",",$fields);
            }*/            
            #exit;
            if($limit_from){               
                $arr = $this->querybuilder->select($this->name,$fields,$where)->limit($limit_from,$limit_to)->getResult($cacheable);            
            }else{                
                $arr = $this->querybuilder->select($this->name,$fields,$where)->getResult($cacheable);            
            }            
            
            if(is_array($arr) && count($arr) > 0){
                foreach($arr as $key => $val){
                    $classe = get_class($this);
                    $namespace_fk = substr($classe,0,strrpos($classe,"\\"));
                    $namespace = substr($namespace_fk,0,strrpos($namespace_fk,"\\"))."\Entity\\";
                    $nome_classe = $namespace.ucfirst($this->name);
                    if(!class_exists($nome_classe)){                        
                        $arr[$key] = new DbElement($val[$this->key],$fields,$this->key,$this->name);
                    }else{ 
                        $arr[$key] = new $nome_classe($val[$this->key],$fields);                        
                    }

                }
            }
            return $arr;
        }
        /**
         * 
         * @param type $params
         * @param type $where
         */
		public function update($params,$where){
			return $this->querybuilder->update($this->name,$params,$where)->getResult();
		}
        /**
         * 
         */
        public function delete($where){
            return $this->querybuilder->delete($this->name, $where)->getResult();
        }
        /**
         * 
         * @param type $id
         * @param type $params
         */
        public function updateKey($id,$params){
            $db_elem = new DbElement($id,$params,$this->key,$this->name);
            //$db_elem->update($params);
            return $db_elem->getResult();
        }
        /**
         * 
         * @param type $what
         * @param type $where
         * @param type $join
         */
        private function setRows($what="*",$where="1=1",$join=""){
            if($what == "*" && $where == "1=1" && $join==""){
                $arr = Config::getDb()->QueryArray("SELECT * FROM ".$this->name,MYSQLI_ASSOC);
                foreach($arr as $key => $val){
                    $classe = get_class($this);
                    $namespace_fk = substr(get_class($this),0,strrpos($classe,"\\"));
                    $namespace = substr($namespace_fk,0,strrpos($namespace_fk,"\\"))."\Entity\\";
                    $classname= $namespace.ucfirst($this->name);
                    $this->rows[$val[$this->key]] = new $classname($val[$this->key],"*");
                }
            }
        }
        /**
         * 
         * @return QueryBuilder object
         */
        public function getQB(){
            return $this->querybuilder;
        }
        /**
         * 
         */
        public function getTableName(){
            return $this->name;
        }
        /**
         * Returns the primary key
         */
        protected function getKey(){
            return Config::getDb()->getPrimaryKey($this->name);
        }
        
        /**
         * Returns all the foreign keys of this table
         */
        private function getForeignKeys(){
            return Config::getDb()->getForeignKeys($this->name);
        }
        /**
         * Returns all keys of this table
         */
        private function getAllKeys(){
            return Config::getDb()->getAllKeys($this->name);
        }
	}
?>
