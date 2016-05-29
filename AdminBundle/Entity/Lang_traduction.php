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
        public function setTraduction($traduction){
            $this->traduction=$traduction;
        }
        public function setType($type){
            $this->type=$type;
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
        public function getTraduction(){
            return $this->traduction;
        }
        public function getType(){
            return $this->type;
        }
        public function getPage(){
            return $this->page;
        }
    }