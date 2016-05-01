<?php
    namespace CMS\OrdiniBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Ordini_righe extends AbstractDbElement{
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
         *@key id_ordine|FOREIGN KEY|ordini|id
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $id_ordine;
        /**
         *@var int(11)
         *@key id_articolo|FOREIGN KEY|articoli|id
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $id_articolo;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $prezzo_1;
        /**
         *@var timestamp
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $data_aggiunta;
        /**
         *@var timestamp
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $data_rimozione;
        public function setId($id){
             $this->id=$id;
        }
        public function setIdOrdine($id_ordine){
             $this->id_ordine=$id_ordine;
        }
        public function setIdArticolo($id_articolo){
             $this->id_articolo=$id_articolo;
        }
        public function setPrezzo1($prezzo_1){
             $this->prezzo_1=$prezzo_1;
        }
        public function setDataAggiunta($data_aggiunta){
             $this->data_aggiunta=$data_aggiunta;
        }
        public function setDataRimozione($data_rimozione){
             $this->data_rimozione=$data_rimozione;
        }
        public function getId(){
            return $this->id;
        }
        public function getIdOrdine(){
            return $this->id_ordine;
        }
        public function getIdArticolo(){
            return $this->id_articolo;
        }
        public function getPrezzo1(){
            return $this->prezzo_1;
        }
        public function getDataAggiunta(){
            return $this->data_aggiunta;
        }
        public function getDataRimozione(){
            return $this->data_rimozione;
        }

} ?>