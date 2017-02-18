<?php
    namespace CMS\TaskBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Cms_lang extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id;
        /**
         *@var varchar(255)
         *@key key_lang_position|UNIQUE
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $key_name;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $traduction;
        /**
         *@var int(11)
         *@default 1
         *@extra 
         *@nullable NO
         */
        protected $lang;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $position;
        public function setId($id){
            $this->id=$id;
        }
        public function setKeyName($key_name){
            $this->key_name=$key_name;
        }
        public function setTraduction($traduction){
            $this->traduction=$traduction;
        }
        public function setLang($lang){
            $this->lang=$lang;
        }
        public function setPosition($position){
            $this->position=$position;
        }
        public function getId(){
            return $this->id;
        }
        public function getKeyName(){
            return $this->key_name;
        }
        public function getTraduction(){
            return $this->traduction;
        }
        public function getLang(){
            return $this->lang;
        }
        public function getPosition(){
            return $this->position;
        }
        public function setKey($key){
            $this->key=$key;
        }
        public function getKey(){
            return $this->key;
        }
    }