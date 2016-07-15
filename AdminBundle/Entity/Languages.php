<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Languages extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id;
        /**
         *@var varchar(50)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $descr;
        /**
         *@var varchar(50)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $descrizione;
        /**
         *@var varchar(50)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $preurlLang;
        public function setId($id){
            $this->id=$id;
        }
        public function setDescr($descr){
            $this->descr=$descr;
        }
        public function setDescrizione($descrizione){
            $this->descrizione=$descrizione;
        }
        public function setPreurlLang($preurlLang){
            $this->preurlLang=$preurlLang;
        }
        public function getId(){
            return $this->id;
        }
        public function getDescr(){
            return $this->descr;
        }
        public function getDescrizione(){
            return $this->descrizione;
        }
        public function getPreurlLang(){
            return $this->preurlLang;
        }
    }