<?php
    namespace CMS\Data;
    use CMS\DbWorkers\DbElement; 
    class Agenzie extends DbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id_agenzia;
        /**
         *@var varchar(255)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $nome;
        public function setId_agenzia($id_agenzia){
            $this->id_agenzia=$id_agenzia;
        }
        public function setNome($nome){
            $this->nome=$nome;
        }
        public function getId_agenzia(){
            return $this->id_agenzia;
        }
        public function getNome(){
            return $this->nome;
        }

} ?>