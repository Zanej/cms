<?php
   namespace CMS\View;
   //use CMS\DbWorkers\Table;
   use CMS\Conf\Config;
   use CMS\Controller\UtentiController;
   use CMS\Data\Utenti;
   use CMS\DbWorkers\QueryBuilder;
   echo "VIEW UTENTI";
   //GENERATE BUNDLE FROM DATABASE
   //Config::dataBundle();
   //CONTROLLER
   //$utenti = new UtentiController();
   //$utenti->update(array("nome"=>"Dennis"),array("id"=>5));
   //$dennis = $utenti->findBy(array("nome"=>"Dennis"));
   //print_r($dennis);
   //$utenti->update(array("nome"=>"Sinned"),array("id"=>5));
   //$utenti->insert(array("nome"=>"Try","cognome"=>"Catch","codice_fiscale"=>"Finally"));
   //$utente = new Utenti(null,array("nome"=>"Finally","cognome"=>"Try","codice_fiscale"=>"Catch"));
   //print_r($utente->getParams());
   //JOIN QUERYBUILDER
   $builder = new QueryBuilder();
   //JOIN WITH THE LAST
   //SELECT
   /*$select =$builder->select("utenti","*",array("nome"=>"Dennis"))
           ->join("agenzie",array("agenzia"=>"id_agenzia"),array("nome"),"")
           ->join("ordini",array("id_agenzia"=>"id_agenzia"),array("totale"),"")
           ->getResult();*/
   //UPDATE
   /*$update =$builder->update("utenti",array("nome"=>"Sinned"),array("nome"=>"Dennis"))
           ->join("agenzie",array("agenzia"=>"id_agenzia"),array("nome"=>"ASD"),array("id_agenzia"=>1))
           ->join("ordini",array("id_agenzia"=>"id_agenzia"),array("totale"=>100),array("totale"=>50));*/
   //JOIN WITH A TABLE IN QUERY
   //SELECT
   /*$select = $builder->select("utenti","*",array("nome"=>"Dennis"))
                ->join("agenzie",array("agenzia"=>"id_agenzia"),array("nome"),"")
                ->join(array("utenti","ordini"),array("id"=>"id_cliente"),array("totale"),"")->getResult();
   //UPDATE
   $update = $builder->update("utenti",array("nome"=>"Sinned"),array("nome"=>"Dennis"))
                ->join("agenzie",array("agenzia"=>"id_agenzia"),array("nome"=>"ASD"),array("nome"=>"WEGO"))
                ->join(array("utenti","ordini"),array("id"=>"id_cliente"),array("totale"=>"200"),array("totale"=>"100"))->getResult();
   print_r(QueryBuilder::getQueryHistory());*/
   