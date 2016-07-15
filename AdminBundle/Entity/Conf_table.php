<?php
    namespace CMS\AdminBundle\Entity;
    use CMS\DbWorkers\AbstractDbElement; 
    use CMS\DbWorkers\Table;
    class Conf_table extends AbstractDbElement{
        /**
         *@var int(11)
         *@key PRIMARY|PRIMARY KEY
         *@default 
         *@extra auto_increment
         *@nullable NO
         */
        protected $id_conf;
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
        protected $label;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $object;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $table;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $where;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $where_object;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $add;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $field_used;
        /**
         *@var varchar(255)
         *@default 
         *@extra 
         *@nullable YES
         */
        protected $field_label;
        /**
         *@var enum('single','multiple')
         *@default single
         *@extra 
         *@nullable NO
         */
        protected $type;
        /**
         *@var int(11)
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $id_sezione;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $hidden;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $title;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $view_admin;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $view_frontend;
        /**
         *@var enum('0','1')
         *@default 0
         *@extra 
         *@nullable NO
         */
        protected $view_lista;
        public function setIdConf($id_conf){
            $this->id_conf=$id_conf;
        }
        public function setField($field){
            $this->field=$field;
        }
        public function setLabel($label){
            $this->label=$label;
        }
        public function setObject($object){
            $this->object=$object;
        }
        public function setTable($table){
            $this->table=$table;
        }
        public function setWhere($where){
            $this->where=$where;
        }
        public function setWhereObject($where_object){
            $this->where_object=$where_object;
        }
        public function setAdd($add){
            $this->add=$add;
        }
        public function setFieldUsed($field_used){
            $this->field_used=$field_used;
        }
        public function setFieldLabel($field_label){
            $this->field_label=$field_label;
        }
        public function setType($type){
            $this->type=$type;
        }
        public function setIdSezione($id_sezione){
            $this->id_sezione=$id_sezione;
        }
        public function setHidden($hidden){
            $this->hidden=$hidden;
        }
        public function setTitle($title){
            $this->title=$title;
        }
        public function setViewAdmin($view_admin){
            $this->view_admin=$view_admin;
        }
        public function setViewFrontend($view_frontend){
            $this->view_frontend=$view_frontend;
        }
        public function setViewLista($view_lista){
            $this->view_lista=$view_lista;
        }
        public function getIdConf(){
            return $this->id_conf;
        }
        public function getField(){
            return $this->field;
        }
        public function getLabel(){
            return $this->label;
        }
        public function getObject(){
            return $this->object;
        }
        public function getTable(){
            return $this->table;
        }
        public function getWhere(){
            return $this->where;
        }
        public function getWhereObject(){
            return $this->where_object;
        }
        public function getAdd(){
            return $this->add;
        }
        public function getFieldUsed(){
            return $this->field_used;
        }
        public function getFieldLabel(){
            return $this->field_label;
        }
        public function getType(){
            return $this->type;
        }
        public function getIdSezione(){
            return $this->id_sezione;
        }
        public function getHidden(){
            return $this->hidden;
        }
        public function getTitle(){
            return $this->title;
        }
        public function getViewAdmin(){
            return $this->view_admin;
        }
        public function getViewFrontend(){
            return $this->view_frontend;
        }
        public function getViewLista(){
            return $this->view_lista;
        }

        /**
         * [checkCampi description]
         * @return [type] [description]
         */
        public function checkCampi(){

            if(!$this->table && ! $this->object){

                return false;
            }

            if($this->table){

                return $this->checkCampiTable();
            }else{

                return $this->checkCampiObject();
            }
        }

        /**
         * [checkCampiObject description]
         * @return [type] [description]
         */
        public function checkCampiObject(){

            if(!$this->object){

                return false;
            }

            if($this->where_object){

                $where = $this->object_to_array(json_decode($this->where_object));
            }

            $ct = new $this->object();

            $find = $ct->findBy($where,false,"*");

            return $find;
        }

        /**
         * [checkCampiTable description]
         * @return [type] [description]
         */
        public function checkCampiTable(){

            if(!$this->table){

                return false;
            }

            $ct = new Table($this->table,true,false);


            if($this->where){

                $where = $this->where;

            }elseif($this->where_object){

                $where = $this->object_to_array(json_decode($this->where_object));
            }

            $find = $ct->findBy($where,false,"*");
            
            return $find;
        }

        /**
         * [object_to_array description]
         * @param  [type] $obj [description]
         * @return [type]      [description]
         */
        public function object_to_array($obj){

            print_r($obj);

            $vars = get_object_vars($obj);

            $ret = array();

            foreach($vars as $k => $v){

                $ret[$k] = $v;
            }

            return $ret;

        }

    }