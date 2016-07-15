<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Gruppi_sezioni extends AbstractDbElement{
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
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $nome;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $ordine;
        public function setId($id){
            $this->id=$id;
        }
        public function setNome($nome){
            $this->nome=$nome;
        }
        public function setOrdine($ordine){
            $this->ordine=$ordine;
        }
        public function getId(){
            return $this->id;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getOrdine(){
            return $this->ordine;
        }
    }