<?php
    namespace CMS\AdminBundle\Controller;
    use CMS\Controller\AbstractController;
    use CMS\AdminBundle\Entity\Sezioni;
    class SezioniController extends AbstractController{
        function __construct(){
            parent::__construct('sezioni');
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
        public function showAction($sezione){
            $sezione = new Sezioni($sezione);  
            $user = new Adm_usersController();
            $username = $user->getUserLogged();
            return $this->render("admin/sezioni",array("sezione"=>$sezione,"user"=>$username));
        }
    }