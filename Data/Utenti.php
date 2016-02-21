<?php
    class Utenti extends DbElement{
        private $id;
        private $nome;
        private $cognome;
        private $codice_fiscale;
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