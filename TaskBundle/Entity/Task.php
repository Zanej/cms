<?php
    namespace CMS\TaskBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Task extends AbstractDbElement{
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
         *@default 0
         *@extra 
         *@nullable YES
         */
        protected $creator;
        /**
         *@var int(11)
         *@default 0
         *@extra 
         *@nullable YES
         */
        protected $user;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $text;
        /**
         *@var date
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $date;
        /**
         *@var timestamp
         *@default CURRENT_TIMESTAMP
         *@extra 
         *@nullable NO
         */
        protected $date_add;
        /**
         *@var timestamp
         *@default CURRENT_TIMESTAMP
         *@extra on update CURRENT_TIMESTAMP
         *@nullable NO
         */
        protected $date_edit;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $likes;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $step;
        /**
         *@var int(11)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $id_rif;
        public function setId($id){
            $this->id=$id;
        }
        public function setCreator($creator){
            $this->creator=$creator;
        }
        public function setUser($user){
            $this->user=$user;
        }
        public function setText($text){
            $this->text=$text;
        }
        public function setDate($date){
            $this->date=$date;
        }
        public function setDateAdd($date_add){
            $this->date_add=$date_add;
        }
        public function setDateEdit($date_edit){
            $this->date_edit=$date_edit;
        }
        public function setLikes($likes){
            $this->likes=$likes;
        }
        public function setStep($step){
            $this->step=$step;
        }
        public function setIdRif($id_rif){
            $this->id_rif=$id_rif;
        }
        public function getId(){
            return $this->id;
        }
        public function getCreator(){
            return $this->creator;
        }
        public function getUser(){
            return $this->user;
        }
        public function getText(){
            return $this->text;
        }
        public function getDate(){
            return $this->date;
        }
        public function getDateAdd(){
            return $this->date_add;
        }
        public function getDateEdit(){
            return $this->date_edit;
        }
        public function getLikes(){
            return $this->likes;
        }
        public function getStep(){
            return $this->step;
        }
        public function getIdRif(){
            return $this->id_rif;
        }
    }