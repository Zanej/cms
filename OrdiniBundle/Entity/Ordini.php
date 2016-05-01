<?php
    namespace CMS\OrdiniBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Ordini extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id;
        /**
         *@var double
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $totale;
        /**
         *@var int(11)
         *@key id_cliente|FOREIGN KEY|utenti|id
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $id_cliente;
        /**
         *@var double
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $sconto;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $sconto_perc;
        public function setId($id){
             $this->id=$id;
        }
        public function setTotale($totale){
             $this->totale=$totale;
        }
        public function setIdCliente($id_cliente){
             $this->id_cliente=$id_cliente;
        }
        public function setSconto($sconto){
             $this->sconto=$sconto;
        }
        public function setScontoPerc($sconto_perc){
             $this->sconto_perc=$sconto_perc;
        }
        public function getId(){
            return $this->id;
        }
        public function getTotale(){
            return $this->totale;
        }
        public function getIdCliente(){
            return $this->id_cliente;
        }
        public function getSconto(){
            return $this->sconto;
        }
        public function getScontoPerc(){
            return $this->sconto_perc;
        }

} ?>