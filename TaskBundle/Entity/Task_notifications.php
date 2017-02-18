<?php
    namespace CMS\TaskBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Task_notifications extends AbstractDbElement{
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
        protected $from;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $to;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $type;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $id_rif;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $link;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $text;
        /**
         *@var enum('0','1')
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $letta;
        public function setId($id){
            $this->id=$id;
        }
        public function setFrom($from){
            $this->from=$from;
        }
        public function setTo($to){
            $this->to=$to;
        }
        public function setType($type){
            $this->type=$type;
        }
        public function setIdRif($id_rif){
            $this->id_rif=$id_rif;
        }
        public function setLink($link){
            $this->link=$link;
        }
        public function setText($text){
            $this->text=$text;
        }
        public function setLetta($letta){
            $this->letta=$letta;
        }
        public function getId(){
            return $this->id;
        }
        public function getFrom(){
            return $this->from;
        }
        public function getTo(){
            return $this->to;
        }
        public function getType(){
            return $this->type;
        }
        public function getIdRif(){
            return $this->id_rif;
        }
        public function getLink(){
            return $this->link;
        }
        public function getText(){
            return $this->text;
        }
        public function getLetta(){
            return $this->letta;
        }
    }