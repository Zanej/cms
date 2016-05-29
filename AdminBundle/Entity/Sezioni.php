<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Sezioni extends AbstractDbElement{
    use CMS\AdminBundle\Controller\Conf_tableController;
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
        public function getView(){
            return $this->view;
        }
        public function getLivello(){
            return $this->livello;
        }
        public function getCampi(){
            $controller_conf = new Conf_tableController();
        }        
    }