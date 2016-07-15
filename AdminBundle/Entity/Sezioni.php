<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    use \CMS\AdminBundle\Controller\Conf_tableController;
    use \CMS\DbWorkers\QueryBuilder;
    class Sezioni extends AbstractDbElement{
    
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $ordine;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $gruppo;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $nome;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $sottotitolo;
        /**
         *@var enum('0','1')
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $box;
        /**
         *@var enum('0','1')
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $stato;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $table;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $object;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $where;
        /**
         *@var enum('0','1')
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $insert;
        /**
         *@var enum('0','1')
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $edit;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $per_page;
        /**
         *@var enum('0','1')
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $view;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $livello;
        
        private $controller;
        private $ct_controller;
        private $campi;
        private $chiave;
        private $from;
        public function __construct($id, $params = "*",$from="") {
            parent::__construct($id, $params);            
            $this->from = "";
            /*@var $controller_conf Conf_tableController*/
            if($from == "scheda"){
                $this->from="view_admin";
            }elseif($from == "frontend"){
                $this->from="view_frontend";
            }elseif($from == "lista"){
                $this->from="view_lista";
            }
            $this->ct_controller = new Conf_tableController(); 
            $this->initFields();
                                   
        }
        public function setId($id){
            $this->id=$id;
        }
        public function setOrdine($ordine){
            $this->ordine=$ordine;
        }
        public function setGruppo($gruppo){
            $this->gruppo=$gruppo;
        }
        public function setNome($nome){
            $this->nome=$nome;
        }
        public function setSottotitolo($sottotitolo){
            $this->sottotitolo=$sottotitolo;
        }
        public function setBox($box){
            $this->box=$box;
        }
        public function setStato($stato){
            $this->stato=$stato;
        }
        public function setTable($table){
            $this->table=$table;
        }
        public function setObject($object){
            $this->object=$object;
        }
        public function setWhere($where){
            $this->where=$where;
        }
        public function setInsert($insert){
            $this->insert=$insert;
        }
        public function setEdit($edit){
            $this->edit=$edit;
        }
        public function setPerPage($per_page){
            $this->per_page=$per_page;
        }
        public function setView($view){
            $this->view=$view;
        }
        public function setLivello($livello){
            $this->livello=$livello;
        }
        public function getId(){
            return $this->id;
        }
        public function getOrdine(){
            return $this->ordine;
        }
        public function getGruppo(){
            return $this->gruppo;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getSottotitolo(){
            return $this->sottotitolo;
        }
        public function getBox(){
            return $this->box;
        }
        public function getStato(){
            return $this->stato;
        }
        public function getTable(){
            return $this->table;
        }
        public function getObject(){
            return $this->object;
        }
        public function getWhere(){
            return $this->where;
        }
        public function getInsert(){
            return $this->insert;
        }
        public function getEdit(){
            return $this->edit;
        }
        public function getPerPage(){
            return $this->per_page;
        }
        public function getView(){
            return $this->view;
        }
        public function getLivello(){
            return $this->livello;
        }
        public function initFields(){
            if($this->from){
                $this->campi = $this->ct_controller->findBy(array("id_sezione"=>$this->getId(),$this->from=>1));                                
            }else{
                $this->campi = $this->ct_controller->findBy(array("id_sezione"=>$this->getId()));                
            }            
            $chiave_titolo = false;
            if(!isset($this->table)){
                /*@var $controller_obj AbstractController*/
                $this->controller = new $this->object();
                $this->chiave = \CMS\Conf\Config::getDB()->getPrimaryKey($this->controller->getTableName());    
            }else{
                $this->chiave = \CMS\Conf\Config::getDB()->getPrimaryKey($this->table);                                                                                
            }
            if($this->campi == false){                       
                if(isset($this->table)){                    
                    $this->campi =  \CMS\Conf\Config::getDB()->GetColumnNames($this->table);                    
                }else{                                                                
                    $this->campi =  \CMS\Conf\Config::getDB()->GetColumnNames($this->controller->getTableName());
                }
                $chiave_titolo = true;            
                foreach($this->campi as $kk => $vv){
                    $this->campi[$kk] = array("field"=>$vv,"hidden"=>false,"key"=>false);
                    if($kk == $this->chiave){
                        $this->campi[$kk]["hidden"] = true;
                        $this->campi[$kk]["key"] = true;
                        if($chiave_titolo){
                            $this->campi[$kk]["titolo"] = true;
                        }
                    }
                    $this->campi[$kk] = (Object) $this->campi[$kk];                    
                    $this->campi[$kk]= new \CMS\Controller\AbstractStdClass(get_object_vars($this->campi[$kk]));                    
                }                                
            }
            foreach($this->campi as $kk => $vv){
                $this->getExternalValues($this->campi[$kk]);
            }            
        }
        /**
         * 
         * @param type $object
         */
        public function getExternalValues(&$object){            
            if($object->get("table")){
                $qb = new QueryBuilder();
                $object->values = $qb->select($object->get("table"), "*")->getResult(false);      
                foreach($object->values as $k => $v){
                    $v = (Object) $v;
                    $object->values[$k] = new \CMS\Controller\AbstractStdClass(get_object_vars($v));
                }                
            }elseif($object->get("object")){
                $controller = new $object->get("object");
                $object->values = $controller->findBy("");
            }
        }
        public function getCampi(){            
            return $this->campi;
        }
        /**
         * 
         * @param type $type
         * @param type $filter
         * @param type $page
         * @return type
         */
        public function getRows($type="",$filter="",$page=""){
            /*@var $controller_conf Conf_tableController*/            
            $campi_r = $this->getCampi($type);
            foreach($campi_r as $k => $v){
                if(is_object($v)){
                    $campi[] = $v->get("field"); 
                }else{
                    $campi[] = $v["field"];
                }
            }            
            if($page > 1){
                $limit_from = (($page+1)*$this->getPerPage());
                $limit_to = $this->getPerPage();
            }elseif($page == 1){
                $limit_from = 0;
                $limit_to = $this->getPerPage();
            }                        
            if(isset($this->controller)){                                
                /*@var $controller AbstractController*/                                    
                if($limit_from){                    
                    $rows = $this->controller->findBy($filter,true,$campi,$limit_from,$limit_to);                                        
                }else{
                    $rows = $this->controller->findBy($filter,true,$campi);                                        
                }                
                
            }else{
                $qb = new QueryBuilder();                
                if($limit_from){
                    $rows = $qb->select($this->table,$campi,$filter)->limit($limit_from,$limit_to)->getResult(true);
                }else{
                    $rows = $qb->select($this->table,$campi,$filter)->getResult(true);
                }
            }
            return $rows;
        }
        public function getEditLink($id_el){
            if(is_object($id_el)){
                $id = $id_el->getId();
            }elseif(is_array($id_el)){                
                $id = $id_el[$this->chiave];
            }
            return "/admin/sezioni/".$this->getId()."/edit/".$id;
        }
        public function getChiave(){
            return $this->chiave;
        }
    }