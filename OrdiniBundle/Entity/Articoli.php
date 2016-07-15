<?php
    namespace CMS\OrdiniBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Articoli extends AbstractDbElement{
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
         *@key codice_articolo|UNIQUE
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $codice_articolo;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $codice_macro;
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
        /**
         *@var double
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $prezzo_1;
        /**
         *@var double
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $prezzo_2;
        /**
         *@var enum('0','1','tmp')
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $stato;
        public function setId($id){
             $this->id=$id;
        }
        public function setCodiceArticolo($codice_articolo){
             $this->codice_articolo=$codice_articolo;
        }
        public function setCodiceMacro($codice_macro){
             $this->codice_macro=$codice_macro;
        }
        public function setNome($nome){
             $this->nome=$nome;
        }
        public function setDescrizione($descrizione){
             $this->descrizione=$descrizione;
        }
        public function setPrezzo1($prezzo_1){
             $this->prezzo_1=$prezzo_1;
        }
        public function setPrezzo2($prezzo_2){
             $this->prezzo_2=$prezzo_2;
        }
        public function setStato($stato){
             $this->stato=$stato;
        }
        public function getId(){
            return $this->id;
        }
        public function getCodiceArticolo(){
            return $this->codice_articolo;
        }
        public function getCodiceMacro(){
            return $this->codice_macro;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getDescrizione(){
            return $this->descrizione;
        }
        public function getPrezzo1(){
            return $this->prezzo_1;
        }
        public function getPrezzo2(){
            return $this->prezzo_2;
        }
        public function getStato(){
            return $this->stato;
        }

} ?>