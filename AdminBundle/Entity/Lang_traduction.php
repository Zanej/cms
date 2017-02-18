<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Lang_traduction extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id_trad;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $id_lang;
        /**
         *@var varchar(255)
         *@key No traduzioni duplicate|UNIQUE
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $key_name;
        /**
         *@var varchar(1000)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $traduction;
        /**
         *@var enum('text','textarea')
         *@default text
         *@extra 
         *@nullable NO
         */
        protected $type;
        /**
         *@var enum('0','1')
         *@default 1
         *@extra 
         *@nullable NO
         */
        protected $stato;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $page;
        public function setIdTrad($id_trad){
            $this->id_trad=$id_trad;
        }
        public function setIdLang($id_lang){
            $this->id_lang=$id_lang;
        }
        public function setKeyName($key_name){
            $this->key_name=$key_name;
        }
        public function setTraduction($traduction){
            $this->traduction=$traduction;
        }
        public function setType($type){
            $this->type=$type;
        }
        public function setStato($stato){
            $this->stato=$stato;
        }
        public function setPage($page){
            $this->page=$page;
        }
        public function getIdTrad(){
            return $this->id_trad;
        }
        public function getIdLang(){
            return $this->id_lang;
        }
        public function getKeyName(){
            return $this->key_name;
        }
        public function getTraduction(){
            return $this->traduction;
        }
        public function getType(){
            return $this->type;
        }
        public function getStato(){
            return $this->stato;
        }
        public function getPage(){
            return $this->page;
        }
    }