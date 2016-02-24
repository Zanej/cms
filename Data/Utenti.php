<?php
    namespace CMS\Data;
    use CMS\DbWorkers\DbElement; 
    class Utenti extends DbElement{
        /**
         *@var int(11)
         *@key PRIMARY
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
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $cognome;
        /**
         *@var varchar(16)
         *@key codice_fiscale
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $codice_fiscale;
        public function setId($id){
            $this->id=$id;
        }
        public function setNome($nome){
            $this->nome=$nome;
        }
        public function setCognome($cognome){
            $this->cognome=$cognome;
        }
        public function setCodice_fiscale($codice_fiscale){
            $this->codice_fiscale=$codice_fiscale;
        }
        public function getId(){
            return $this->id;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getCognome(){
            return $this->cognome;
        }
        public function getCodice_fiscale(){
            return $this->codice_fiscale;
        }

} ?>