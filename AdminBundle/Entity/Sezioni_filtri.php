<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    class Sezioni_filtri extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id_filtro;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $label;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $field;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $placeholder;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $object;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $table;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $field_s;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable NO
         */
        protected $field_w;
        /**
         *@var int(11)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $id_sezione;
        public function setIdFiltro($id_filtro){
            $this->id_filtro=$id_filtro;
        }
        public function setLabel($label){
            $this->label=$label;
        }
        public function setField($field){
            $this->field=$field;
        }
        public function setPlaceholder($placeholder){
            $this->placeholder=$placeholder;
        }
        public function setObject($object){
            $this->object=$object;
        }
        public function setTable($table){
            $this->table=$table;
        }
        public function setFieldS($field_s){
            $this->field_s=$field_s;
        }
        public function setFieldW($field_w){
            $this->field_w=$field_w;
        }
        public function setIdSezione($id_sezione){
            $this->id_sezione=$id_sezione;
        }
        public function getIdFiltro(){
            return $this->id_filtro;
        }
        public function getLabel(){
            return $this->label;
        }
        public function getField(){
            return $this->field;
        }
        public function getPlaceholder(){
            return $this->placeholder;
        }
        public function getObject(){
            return $this->object;
        }
        public function getTable(){
            return $this->table;
        }
        public function getFieldS(){
            return $this->field_s;
        }
        public function getFieldW(){
            return $this->field_w;
        }
        public function getIdSezione(){
            return $this->id_sezione;
        }
    }