<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Todolist extends AbstractDbElement{
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
         *@nullable NO
         */
        protected $id_user;
        /**
         *@var datetime
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $data_aggiunta;
        /**
         *@var datetime
         *@default CURRENT_TIMESTAMP
         *@extra on update CURRENT_TIMESTAMP
         *@nullable NO
         */
        protected $data_modifica;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $testo;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $img;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $allegato;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $gallery;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $completata;
        /**
         *@var int(11)
         *@default 0
         *@extra 
         *@nullable YES
         */
        protected $id_rif;
        public function setId($id){
            $this->id=$id;
        }
        public function setIdUser($id_user){
            $this->id_user=$id_user;
        }
        public function setDataAggiunta($data_aggiunta){
            $this->data_aggiunta=$data_aggiunta;
        }
        public function setDataModifica($data_modifica){
            $this->data_modifica=$data_modifica;
        }
        public function setTesto($testo){
            $this->testo=$testo;
        }
        public function setImg($img){
            $this->img=$img;
        }
        public function setAllegato($allegato){
            $this->allegato=$allegato;
        }
        public function setGallery($gallery){
            $this->gallery=$gallery;
        }
        public function setCompletata($completata){
            $this->completata=$completata;
        }
        public function setIdRif($id_rif){
            $this->id_rif=$id_rif;
        }
        public function getId(){
            return $this->id;
        }
        public function getIdUser(){
            return $this->id_user;
        }
        public function getDataAggiunta(){
            return $this->data_aggiunta;
        }
        public function getDataModifica(){
            return $this->data_modifica;
        }
        public function getTesto(){
            return $this->testo;
        }
        public function getImg(){
            return $this->img;
        }
        public function getAllegato(){
            return $this->allegato;
        }
        public function getGallery(){
            return $this->gallery;
        }
        public function getCompletata(){
            return $this->completata;
        }
        public function getIdRif(){
            return $this->id_rif;
        }
    }