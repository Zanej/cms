<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Adm_users extends AbstractDbElement{
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
         *@key username|UNIQUE
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $username;
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
        protected $cognome;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $last_ip;
        /**
         *@var datetime
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $ultimo_accesso;
        /**
         *@var datetime
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $ultima_modifica;
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
        public function setUsername($username){
            $this->username=$username;
        }
        public function setNome($nome){
            $this->nome=$nome;
        }
        public function setCognome($cognome){
            $this->cognome=$cognome;
        }
        public function setLastIp($last_ip){
            $this->last_ip=$last_ip;
        }
        public function setUltimoAccesso($ultimo_accesso){
            $this->ultimo_accesso=$ultimo_accesso;
        }
        public function setUltimaModifica($ultima_modifica){
            $this->ultima_modifica=$ultima_modifica;
        }
        public function setLivello($livello){
            $this->livello=$livello;
        }
        public function getId(){
            return $this->id;
        }
        public function getUsername(){
            return $this->username;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getCognome(){
            return $this->cognome;
        }
        public function getLastIp(){
            return $this->last_ip;
        }
        public function getUltimoAccesso(){
            return $this->ultimo_accesso;
        }
        public function getUltimaModifica(){
            return $this->ultima_modifica;
        }
        public function getLivello(){
            return $this->livello;
        }
    }