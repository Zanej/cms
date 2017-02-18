<?php
    namespace CMS\TaskBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Task_comments extends AbstractDbElement{
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
        protected $id_rif;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $id_rif_parent;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $text;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $likes;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $user;
        /**
         *@var timestamp
         *@default CURRENT_TIMESTAMP
         *@extra 
         *@nullable NO
         */
        protected $date;
        /**
         *@var timestamp
         *@default CURRENT_TIMESTAMP
         *@extra on update CURRENT_TIMESTAMP
         *@nullable NO
         */
        protected $date_edit;
        public function setId($id){
            $this->id=$id;
        }
        public function setIdRif($id_rif){
            $this->id_rif=$id_rif;
        }
        public function setIdRifParent($id_rif_parent){
            $this->id_rif_parent=$id_rif_parent;
        }
        public function setText($text){
            $this->text=$text;
        }
        public function setLikes($likes){
            $this->likes=$likes;
        }
        public function setUser($user){
            $this->user=$user;
        }
        public function setDate($date){
            $this->date=$date;
        }
        public function setDateEdit($date_edit){
            $this->date_edit=$date_edit;
        }
        public function getId(){
            return $this->id;
        }
        public function getIdRif(){
            return $this->id_rif;
        }
        public function getIdRifParent(){
            return $this->id_rif_parent;
        }
        public function getText(){
            return $this->text;
        }
        public function getLikes(){
            return $this->likes;
        }
        public function getUser(){
            return $this->user;
        }
        public function getDate(){
            return $this->date;
        }
        public function getDateEdit(){
            return $this->date_edit;
        }
    }