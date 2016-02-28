<?php
   namespace CMS\View;
   //use CMS\DbWorkers\Table;
   use CMS\Conf\Config;
   use CMS\Controller;
   //Config::dataBundle();
   $utenti = new Controller\UtentiController();
   $utenti->insert(array("nome"=>"Trollo","cognome"=>"Trollo","codice_fiscale"=>"ASDASDASDASD"));
   //$table = new Table("Utenti");