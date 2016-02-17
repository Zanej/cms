<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/include/inc_config.php");
	class Table{
		private $fields;
      private $rows;
      private $key;
      private $name;
      private $return;
      /**
       * 
       * @param type $name
       * @param type $force
       * @param type $get
       * @param type $values
       */
		public function __construct($name,$force=false,$get=true,$values=null){
         $this->name = $name;
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
         global $db;
         $query = "CREATE TABLE $name (";
         $query.="id INTEGER AUTO_INCREMENT PRIMARY KEY ,";
         foreach($values as $key => $val){
            $query.=$key." ";
            $add = explode("|",$val);
            $query.=" ".$add[0]."(".$add[1].")".$add[2].",";
         }
         $query =substr($query,0,strlen($query)-1);
         $query.=")";
         //echo $query;
         if($db->Query($query)){
            echo json_encode(array("success"=>true));
         }
      }
      /**
       * 
       * @param type $table_name Nome della tabella
       */
      public static function exists($table_name){
         global $db;
         $db->Query("SELECT * FROM $table_name LIMIT 1");
         return !$db->Error();
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
       * @param type $params
       * @param type $where
       */
		public function update($params,$where){
			//$db_elem = new DbElement(
		}
      /**
       * 
       * @param type $id
       * @param type $params
       */
      public function updateKey($id,$params){
         $db_elem = new DbElement($id,$this->key,$this->key,$this->name);
         $db_elem->update($params);
         return $db_elem->getResult();
      }
      /**
       * 
       * @param type $what
       * @param type $where
       * @param type $join
       */
      private function setRows($what="*",$where="1=1",$join=""){
         
      }
      /**
       * 
       */
      private function getKey(){
         global $db;
         $arr = $db->QuerySingleRow("SHOW KEYS FROM ".$this->name." WHERE Key_name='PRIMARY'");
         return $arr->Column_name;
         //echo $db->Error();
      }
	}
?>
