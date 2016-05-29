<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Conf_table extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id_conf;
        /**
         *@var varchar(255)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $field;
        /**
         *@var varchar(255)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $label;
        /**
         *@var varchar(255)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $object;
        /**
         *@var varchar(255)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $table;
        /**
         *@var int(11)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $id_sezione;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $view_admin;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $view_frontend;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $view_lista;
        public function setIdConf($id_conf){
            $this->id_conf=$id_conf;
        }
        public function setField($field){
            $this->field=$field;
        }
        public function setLabel($label){
            $this->label=$label;
        }
        public function setObject($object){
            $this->object=$object;
        }
        public function setTable($table){
            $this->table=$table;
        }
        public function setIdSezione($id_sezione){
            $this->id_sezione=$id_sezione;
        }
        public function setViewAdmin($view_admin){
            $this->view_admin=$view_admin;
        }
        public function setViewFrontend($view_frontend){
            $this->view_frontend=$view_frontend;
        }
        public function setViewLista($view_lista){
            $this->view_lista=$view_lista;
        }
        public function getIdConf(){
            return $this->id_conf;
        }
        public function getField(){
            return $this->field;
        }
        public function getLabel(){
            return $this->label;
        }
        public function getObject(){
            return $this->object;
        }
        public function getTable(){
            return $this->table;
        }
        public function getIdSezione(){
            return $this->id_sezione;
        }
        public function getViewAdmin(){
            return $this->view_admin;
        }
        public function getViewFrontend(){
            return $this->view_frontend;
        }
        public function getViewLista(){
            return $this->view_lista;
        }
    }