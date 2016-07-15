<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Box extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $id;
        /**
         *@var int(11)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $id_sezioni;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $titolo;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $sottotitolo;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $descrizione;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $img;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $img_2;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $img_3;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $img_4;
        /**
         *@var text
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $gallery;
        /**
         *@var enum('','desktop','mobile')
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $viewport;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $allegato;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $link;
        /**
         *@var enum('0','1')
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $target;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $titolo_link;
        /**
         *@var date
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $data_da;
        /**
         *@var date
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $data_a;
        public function setId($id){
            $this->id=$id;
        }
        public function setIdSezioni($id_sezioni){
            $this->id_sezioni=$id_sezioni;
        }
        public function setTitolo($titolo){
            $this->titolo=$titolo;
        }
        public function setSottotitolo($sottotitolo){
            $this->sottotitolo=$sottotitolo;
        }
        public function setDescrizione($descrizione){
            $this->descrizione=$descrizione;
        }
        public function setImg($img){
            $this->img=$img;
        }
        public function setImg2($img_2){
            $this->img_2=$img_2;
        }
        public function setImg3($img_3){
            $this->img_3=$img_3;
        }
        public function setImg4($img_4){
            $this->img_4=$img_4;
        }
        public function setGallery($gallery){
            $this->gallery=$gallery;
        }
        public function setViewport($viewport){
            $this->viewport=$viewport;
        }
        public function setAllegato($allegato){
            $this->allegato=$allegato;
        }
        public function setLink($link){
            $this->link=$link;
        }
        public function setTarget($target){
            $this->target=$target;
        }
        public function setTitoloLink($titolo_link){
            $this->titolo_link=$titolo_link;
        }
        public function setDataDa($data_da){
            $this->data_da=$data_da;
        }
        public function setDataA($data_a){
            $this->data_a=$data_a;
        }
        public function getId(){
            return $this->id;
        }
        public function getIdSezioni(){
            return $this->id_sezioni;
        }
        public function getTitolo(){
            return $this->titolo;
        }
        public function getSottotitolo(){
            return $this->sottotitolo;
        }
        public function getDescrizione(){
            return $this->descrizione;
        }
        public function getImg(){
            return $this->img;
        }
        public function getImg2(){
            return $this->img_2;
        }
        public function getImg3(){
            return $this->img_3;
        }
        public function getImg4(){
            return $this->img_4;
        }
        public function getGallery(){
            return $this->gallery;
        }
        public function getViewport(){
            return $this->viewport;
        }
        public function getAllegato(){
            return $this->allegato;
        }
        public function getLink(){
            return $this->link;
        }
        public function getTarget(){
            return $this->target;
        }
        public function getTitoloLink(){
            return $this->titolo_link;
        }
        public function getDataDa(){
            return $this->data_da;
        }
        public function getDataA(){
            return $this->data_a;
        }
        public function getMyself(){
            echo "I'm dummyyy";
        }
    }