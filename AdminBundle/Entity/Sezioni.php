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
        public function getCampi($from="",$controller=false){
            /*@var $controller_conf Conf_tableController*/
            if($from == "scheda"){
                $addfrom="view_admin";
            }elseif($from == "frontend"){
                $addfrom="view_frontend";
            }elseif($from == "lista"){
                $addfrom="view_lista";
            }
            if(!$controller){                
                $controller_conf = new Conf_tableController();            
            }else{
                $controller_conf = $controller;
            }
            if($addfrom){
                $campi = $controller_conf->findBy(array("id_sezione"=>$this->getId(),$addfrom=>1));
            }else{
                $campi = $controller_conf->findBy(array("id_sezione"=>$this->getId()));
            }
            $chiave_titolo = false;
            if($campi == false){                       
                if(isset($this->table)){                    
                    $campi =  \CMS\Conf\Config::getDB()->GetColumnNames($this->table);
                    $chiave = \CMS\Conf\Config::getDB()->getPrimaryKey($this->table);                                                                                
                }else{
                    /*@var $controller_obj AbstractController*/
                    $controller_obj = new $this->object();                    
                    $chiave = \CMS\Conf\Config::getDB()->getPrimaryKey($controller_obj->getTableName());    
                    $campi =  \CMS\Conf\Config::getDB()->GetColumnNames($controller_obj->getTableName());
                }
                $chiave_titolo = true;
            }
            foreach($campi as $kk => $vv){
                $campi[$kk] = array("name"=>$vv,"hidden"=>false,"key"=>false);
                if($kk == $chiave){
                    $campi[$kk]["hidden"] = true;
                    $campi[$kk]["key"] = true;
                    if($chiave_titolo){
                        $campi[$kk]["titolo"] = true;
                    }
                }
            }
            return $campi;
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
            $controller_conf = new Conf_tableController();
            $campi_r = $this->getCampi($type,$controller_conf);
            foreach($campi_r as $k => $v){
                $campi[] = $v["name"];
            }
            if($page > 1){
                $limit_from = (($page+1)*$this->getPerPage());
                $limit_to = $this->getPerPage();
            }elseif($page == 1){
                $limit_from = 0;
                $limit_to = $this->getPerPage();
            }            
            if(isset($this->object)){
                $controller = new $this->object();
                /*@var $controller AbstractController*/         
                if($limit_from){
                    $rows = $controller->findBy("",true,$campi,$limit_from,$limit_to);
                }else{
                    $rows = $controller->findBy("",true,$campi);
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
    }