<?php
    namespace CMS\AdminBundle\Controller;
    use CMS\Controller\AbstractController;
    use CMS\AdminBundle\Entity\Sezioni;
    class SezioniController extends AbstractController{

        function __construct(){
            parent::__construct('sezioni');
        }

        /**
         * [formalizzaCampi description]
         * @param  [type] $campi         [description]
         * @param  [type] &$titolo_field [description]
         * @param  [type] &$campi_hidden [description]
         * @return [type]                [description]
         */
        public function formalizzaCampi($campi,&$titolo_field,&$campi_hidden){
            foreach($campi as $k => $v){
                $arr = array();

                if(is_object($v)){

                    if($v->getTitle()){
                        $titolo_field = $v->getField();
                    }
                    $arr["field"] = $v->getField();
                    $arr["label"] = $v->getLabel();
                    $arr["field_label"] = $v->getFieldLabel();
                    $arr["field_used"] = $v->getFieldUsed();                    
                    $arr["table"] = $v->getTable();
                    $arr["object"] = $v->getObject();
                    $arr["type"] = $v->getType();
                    $arr["hidden"] = $v->getHidden();
                    $arr["id_sezione"] = $v->getIdSezione();
                    $arr["add"] = $v->getAdd();
                    $arr["where"] = $v->getWhere();
                    $arr["where_object"] = $v->getWhereObject();
                    $arr["values"] = $v->checkCampi();
                }else{

                    $v["field"] = $v["label"] = $v["name"];
                    $arr = $v;
                    if($v["titolo"]){
                        $titolo_field = $v["field"];
                    }                                       
                }

                if($arr["hidden"]){
                    $campi_hidden[] = $arr;
                }
                $campi_arr[] = $arr;
            }

            return $campi_arr;
        }

        public function getGruppiByLevel($livello){            
            /*@var $qb QueryBuilder*/
            $qb = $this->getQB();            
            $arr = $qb->select($this->getTableName(),array("id"),array("stato"=>1,"livello"=>$livello))
                    ->join("gruppi_sezioni",array("gruppo"=>"id"),array("nome","id","ordine"))->getResult(false);
            $arr_gruppi = array();
            foreach($arr as $k => $v){
                if(!isset($arr_gruppi[$v["ordine"]])){
                    $arr_gruppi[$v["ordine"]]["nome"] = $v["nome"];
                }
                $sez = new Sezioni($v["id"]);                
                $arr_gruppi[$v["ordine"]]["sezioni"][] = $sez;
            }
            ksort($arr_gruppi);
            //print_r($arr_gruppi);
            return $arr_gruppi;
        }

        public function showAction($sezione,$page=""){
            $sezione = new Sezioni($sezione,"*","lista");  

//            $this->echo_array($sezione,1);
            if(is_null($sezione->getId()))
                exit("Not allowed");
            $user = new Adm_usersController();
            $username = $user->getUserLogged();
            if($page){
                $lista = $sezione->getRows("lista",$page);
            }else{
                $lista = $sezione->getRows("lista");
            }
            $campi_hidden = array();
            $titolo_field = "";

            // $this->echo_array($lista,1);
            $campi = $this->formalizzaCampi($sezione->getCampi("lista"),$titolo_field,$campi_hidden);
            
            // $this->echo_array($campi,1);
            $lista_arr = array();

            

            foreach($lista as $k => $v){

            }

            return $this->render("admin/sezioni",array("sezione"=>$sezione,"user"=>$username,"page"=>$page,"campi"=>$campi,"lista"=>$lista,"titolo_field"=>$titolo_field,"campi_hidden"=>$campi_hidden));
        }

        public function insertAction($sezione){
            $sezione = new Sezioni($sezione,"*","scheda");  
            $user = new Adm_usersController();
            $username = $user->getUserLogged();
            return $this->render("admin/scheda",array("sezione"=>$sezione,"user"=>$username));
        }

        public function echo_array($array,$exit = 0,$comment = 0){

            if($comment == 1){
                echo "<!--";
            }

            echo "<pre>";
                print_r($array);
            echo "</pre>";

            if($comment == 1){
                echo "-->";
            }

            if($exit == 1){
                exit;
            }
        }
        public function editAction($sezione,$id){
            $sezione = new Sezioni($sezione,"*","scheda");  
            $user = new Adm_usersController();
            $username = $user->getUserLogged();
            $titolo_field = "";
            $campi_hidden = "";
            $campi = $this->formalizzaCampi($sezione->getCampi("scheda"));

            $object = $sezione->getRows("scheda",array($sezione->getChiave()=>$id),"1");

            // $this->echo_array($campi,1);

            return $this->render("admin/scheda",array("sezione"=>$sezione,"user"=>$username,"id"=>$id,"object"=>$object[0],"campi"=>$campi));
        }
    }