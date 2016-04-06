<?php
	/** 
	 * Interfaccia per gestire un elemento generico del db
	 */
	interface Element{
		/**
		 * Costruttore che inizializza l'elemento, chiama create se nel db l'elemento non esiste, update se esiste
		 * @param id id dell'elemento, null se bisogna crearlo
		 * @param params parametri da inserire/modificare
		 * @param key_name nome del campo chiave
		 * @param table_name nome della tabella su cui lavorare
		 * @param md5 indica se l'elemento passato per la select è md5
		 */
		function __construct($id=null,$params=null,$key_name=null,$table_name=null,$md5=false);
		/**
		 * Funzione che inserisce l'elemento nel db
		 */
		function create($params);
		/**
		 * Funzione che effettua l'update nel db
		 */
		function update($params);
		/**
		 * Ritorna l'id dell'elemento
		 */
		function getParams();
		/**
		 * Aggiorna i parametri dopo la creazione o la modifica nel database
		 */
		function updateParams($id=null,$params="all",$md5=false);
		/**
		 * Ritorna il risultato delle operazioni (success,error,message)
		 */
		function getResult();
		/**
		 * Ritorna il parametro dal database
		 * @param $name nome del parametro
		 */
		function get($name);
		/**
		 * Imposta la tabella
		 */
		function setTable($table_name);
		/**
		 * Ritorna la chiave primaria dell'elemento
		 */
		function getId();
		/**
		 * Imposta il campo chiave
		 */
		function setKey($key_name);
		/**
		 * Ritorna se il singolo campo è uguale a quello passato
		 */
		function isEqual($key,$val);
		/**
		 * Ritorna se i dati inseriti sono uguali a quelli dell'elemento
		 */
		function areParamsEqual($params);
	}
	/**
	 * Classe per gestire un elemento generico del db
	 */
	class DbElement implements Element{
		protected $conn;
		protected $params;
		protected $return;
		protected $table;
		protected $key;
		/**
		 * @see Element
		 */
		function __construct($id=null,$params=null,$key_name=null,$table_name=null,$md5=false){
			global $db;
			$this->return = array();
			if(!is_null($key_name))
				$this->key = $key_name;
			if(!is_null($table_name))
				$this->table = $table_name;
			$this->return["error"]=true;
			$this->return["success"]=false;
			if($db->Error()){
				//echo $db->ErrorNumber();
				$this->return["message"] = "Errore";
			}
			//print_r($db);
			//else{
			if($id==null){
				$this->create($params);
			}
			else{
				$this->updateParams($id,$params,$md5);
				//$this->return["params"]=$this->params;
			}
			//}	
		}
		/**
		 * @see Element
		 */
		function create($params){
			global $db;
			//print_r($params);
			$keys = array_keys($params);
			//print_r($keys);
			//echo $this->table;
			$query="INSERT INTO ".$this->table." (";
			foreach($keys as $key){
				$query.=$key.",";
			}
			$query = substr($query,0,-1);
			$query.=") VALUES (";
			foreach($params as $param){
				$query.="'".$param."',";
			}
			$query = substr($query,0,-1).")";
			//echo $query;
			//echo $query;
			
			$db->Query($query);
			if($db->Error()){
				$this->return["message"] = "Non sono riuscito ad aggiungere l'elemento";
			} else {
				$this->return["success"] = true;
				$this->return["error"] = false;
				$this->return["message"] = "Elemento aggiunto";
				$id = $db->GetLastInsertID();
				$this->updateParams($id);
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
					$query.=$keys[$i]."='".htmlentities($params[$keys[$i]])."',";
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
			//echo $query;
			$db->Query($query);
			if($db->Error()){
				$this->return["message"]="Errore nella modifica dei dati";
			} else {
				$this->return["success"] = true;
				$this->return["error"] = false;
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
		function updateParams($id=null,$params="all",$md5=false){
			global $db;
			$id_query = $id == null ? $this->getId() : $id;
			if($params == "all"){
				if(!$md5)
					$sql = "SELECT * FROM ".$this->table." WHERE ".$this->key."='".$id_query."'";
				else
					$sql = "SELECT * FROM ".$this->table." WHERE md5(".$this->key.")='".$id_query."'";
			}else{
				$sql = "SELECT ";
				foreach($params as $key => $val){
					$sql.= $val;
				}
				$sql.=" FROM ".$this->table." WHERE ";
				if($md5){
					$sql.= " md5(".$this->key.") = '".$id_query."'";
				}else{
					$sql.= $this->key." = '".$id_query."'";
				}
			}
			$result = $db->QuerySingleRowArray($sql,MYSQL_ASSOC);
			$this->params = $result;
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
			if(isset($this->params[$name]))
				$this->update(array($name => $value));
			return $this->return;
		}
		/**
		 * @see Element
		 */
		function get($name){
			if(isset($this->params[$name])){
				if(!is_numeric($this->params[$name]))
					return utf8_decode($this->params[$name]);
				return $this->params[$name];
			}
			else
				return false;
		}
		/**
		 * @see Element
		 */
		function getInstance(){
			return $this;
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
				return date('H:i',strtotime($val) == date('H:i',strtotime($this->params[$key])));
			}elseif($tipo == "date"){
				return date('Y-m-d',strtotime($val) == date('Y-m-d',strtotime($this->params[$key])));
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
				if(!$this->isEqual($key,$value))
					return false;
			}
			return true;
		}
	}