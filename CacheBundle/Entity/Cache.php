<?php
    namespace CMS\CacheBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Cache extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id_cache;
        /**
         *@var timestamp
         *@default CURRENT_TIMESTAMP
         *@extra on update CURRENT_TIMESTAMP
         *@nullable NO
         */
        protected $timestamp;
        /**
         *@var varchar(767)
         *@key key_sql|UNIQUE
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $key_sql;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $result;
        public function setIdCache($id_cache){
             $this->id_cache=$id_cache;
        }
        public function setTimestamp($timestamp){
             $this->timestamp=$timestamp;
        }
        public function setKeySql($key_sql){
             $this->key_sql=$key_sql;
        }
        public function setResult($result){
             $this->result=$result;
        }
        public function getIdCache(){
            return $this->id_cache;
        }
        public function getTimestamp(){
            return $this->timestamp;
        }
        public function getKeySql(){
            return $this->key_sql;
        }
        public function getResult(){
            return $this->result;
        }

} ?>