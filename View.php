<?php
   namespace CMS\View;
   //use CMS\DbWorkers\Table;
   use CMS\Conf\Config;
   use CMS\Controller\UtentiController;
   //Config::dataBundle();
   $utenti = new UtentiController();
   $utenti->update(array("nome"=>"Dennis"),array("id"=>5));
   $utenti->findBy(array("id"=>"5"));
   $utenti->update(array("nome"=>"Sinned"),array("id"=>5));
   