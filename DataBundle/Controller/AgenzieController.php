<?php
    namespace CMS\DataBundle\Controller;
    use CMS\Controller\AbstractController; 
    class AgenzieController extends AbstractController{
        function __construct(){
            parent::__construct('agenzie');
        }
        function showAction($agenzia){
            $agenzie = $this->findBy(array($this->getKeyName()=>$agenzia));
            if(count($agenzie) == 0){
                return $this->render("404",array());
            }
            $agenzie = $agenzie[0];
            return $this->render("view",array(
               "agenzia"=>$agenzie,"agenzie"=>$this->getRows()
            ));
        }
} ?>