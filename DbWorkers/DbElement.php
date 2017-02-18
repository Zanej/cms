<?php
    namespace CMS\DbWorkers;
    use CMS\Conf\Config;
	/**
	 * Classe per gestire un elemento generico del db
	 */
	class DbElement{
		protected $conn;
		protected $params;
		protected $return;
		protected $table;
		protected $key;
        private $querybuilder;
		/**
		 * @see Element
		 */
		function __construct($id=null,$params="*",$key_name=null,$table_name=null,$md5=false){
			global $db;

			if(!$db){

				$db = Config::getDB();
			}
			
            $this->querybuilder = new QueryBuilder();
            //print_r($this->querybuilder);   
			$this->return = array();
			if (!is_null($key_name)) {
                $this->key = $key_name;
            }
            if(!is_null($table_name)){
               $this->table = $table_name;
            }
			$this->return["success"]=false;
            //$db = new MySQL(true, "test", "localhost", "root", "");
            //$db = new MySQL(true,DB_HOST,DB_NAME,DB_PASSWORD,DB_USER);
			if($db->Error()){
				$this->return["message"] = "Errore";
			}
			if($id==null && $params!="*"){
				$this->create($params);
			}
			else{
				$this->updateParams($id,$params,$md5);
			}
		}
		/**
		 * @see Element
		 */
		function create($params){
			global $db;
            //echo "aaa";
            $do = $this->querybuilder->insert($this->table, $params);
            if($id = $do->getResult()){
               $this->return["success"] = true;
                   $this->return["message"] = "Elemento aggiunto";
                   //$id = $db->GetLastInsertID();
                   $this->updateParams($id);
            }else{
               $this->return["message"] ="Non sono riuscito ad aggiungere l'elemento".$db->Error();
            }
		}
		/**
		 * @see Element
		 */
		function update($params){
			global $db;
			$keys=array_keys($params);
			$query="UPDATE ".$this->table." SET ";
			for($i=0;$i<count($params);$i++){
				if($keys[$i] != "email" && $keys[$i] != "img_orig_facebook" && $keys[$i] != "img" && $keys[$i] != "img_orig_google" && $keys[$i] != "data_ultimo_accesso" && $keys[$i] != "data_ultima_modifica"){
					$query.=$keys[$i]."='".addslashes(htmlentities($params[$keys[$i]]))."',";
				}
				elseif($keys[$i] == "data_ultimo_accesso" || strtolower($keys[$i]) == "data_ultima_modifica"){
					$query.=$keys[$i]."=".$params[$keys[$i]].",";
				}
				else {
					$query.=$keys[$i]."='".$params[$keys[$i]]."',";
				}
			}
			$query = substr($query,0,-1);
			$query.=" WHERE ".$this->key."='".$this->getId()."'";
			$db->Query($query);
			if($db->Error()){
				$this->return["message"]="Errore nella modifica dei dati";
			} else {
				$this->return["success"] = true;
				$this->return["message"]="Modifiche effettuate";
			}
			$this->updateParams();
			return $this->return;
		}
		/**
		 * @see Element
		 */
		function getParams(){
			return $this->params;
		}
		/**
		 * @see Element
		 */
		function updateParams($id=null,$params="*",$md5=false){
			global $db;
			$id_query = $id == null ? $this->getId() : $id;
            if(is_array($params)){
               $search = implode(",",$params);
               $params = $search;
            }
            $sql = "SELECT $params FROM ".$this->table." WHERE ";
            if($md5){
               $sql.= " md5(".$this->key.") = '".$id_query."'";
            }else{
               $sql.= $this->key." = '".$id_query."'";
            }
            #echo $sql;
            $result = $db->QuerySingleRowArray($sql,MYSQL_ASSOC);
            $this->params = $result;
            foreach($result as $key => $val){
                $this->$key = $val;
            }
        }
		/**
		 * @see Element
		 */
		function setTable($table_name){
			$this->table = $table_name;
		}
		/**
		 * @see Element
		 */
		function getResult(){
			return $this->return;
		}
		/**
		 * @see Element
		 */
		function setElem($name,$value){
			if (isset($this->params[$name])) {
            $this->update(array($name => $value));
         }
         return $this->return;
		}
		/**
		 * @see Element
		 */
		function get($name){
			if(isset($this->params[$name])){
				if (!is_numeric($this->params[$name])) {
               return utf8_decode($this->params[$name]);
            }
         return $this->params[$name];
			}
			return false;
		}
		/**
		 * @see Element
		 */
		function getId(){
			return $this->get($this->key);
		}
		/**
		 * @see Element
		 */
		function setKey($key_name){
			$this->key = $key_name;
		}
		/**
		 * @see Element
		 */
		function isEqual($key,$val){
			global $db;	
			$tipo = $db->GetColumnDataType($key,$this->table);
			if($tipo == "blob" || $tipo=="string"){
				return $this->params[$key] == htmlentities($val);
			}elseif($tipo == "time"){
				return date('H:i',strtotime($val)) == date('H:i',strtotime($this->params[$key]));
			}elseif($tipo == "date"){
				return date('Y-m-d',strtotime($val)) == date('Y-m-d',strtotime($this->params[$key]));
			}
			else{
				return $this->params[$key] == $val;
			}
		}
		/**
		 * @see Element
		 */
		function areParamsEqual($params){
			foreach($params as $key=>$value){
				if (!$this->isEqual($key, $value)) {
               return false;
            }
      }
			return true;
		}
	}