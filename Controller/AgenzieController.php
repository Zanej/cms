<?php
    namespace CMS\Controller;
    class AgenzieController extends AbstractController{
        function __construct(){
            parent::__construct('agenzie');
        }
        function showAction($agenzia){
            #print_r(array($this->getKeyName()=>$agenzia));
            #exit;
            $agenzie = $this->findBy(array($this->getKeyName()=>$agenzia));
            if(count($agenzie) == 0){
                return $this->render("404",array());
            }
            $agenzie = $agenzie[0];
            return $this->render("view",array(
               "agenzia"=>$agenzie
            ));
        }
}