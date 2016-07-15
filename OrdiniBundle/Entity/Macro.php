<?php
    namespace CMS\OrdiniBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Macro extends AbstractDbElement{
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
         *@var text
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $descrizione;
        public function setId($id){
             $this->id=$id;
        }
        public function setNome($nome){
             $this->nome=$nome;
        }
        public function setDescrizione($descrizione){
             $this->descrizione=$descrizione;
        }
        public function getId(){
            return $this->id;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getDescrizione(){
            return $this->descrizione;
        }

} ?>