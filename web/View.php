<?php
   namespace CMS\View;
   use CMS\Conf\Bundle;
   $nome = "ordini";
   $bundle = new Bundle("Admin", array("conf_table","languages","lang_traduction"),1);
   /*$bundle->createController("box");
   $bundle->createController("gruppi_sezioni");
   $bundle->createController("sezioni");
   $bundle->createController("adm_users");*/
   
   /*$bundle = new \CMS\Conf\Bundle("Admin",array(
       "adm_users"=>array(
           "username"=>"VARCHAR(255) UNIQUE",
           "nome"=>"VARCHAR(255)",
           "cognome"=>"VARCHAR(255)",
           "last_ip"=>"VARCHAR(255)",
           "ultimo_accesso"=>"DATETIME",
           "ultima_modifica"=>"DATETIME",
           "livello"=>"INTEGER",
           
       ),
       "gruppi_sezioni"=>array(
           "nome"=>"VARCHAR(255)",
           "ordine"=>"INTEGER"
       ),
       "sezioni"=>array(
           "ordine"=>"INTEGER",
           "gruppo"=>"INTEGER",
           "nome"=>"VARCHAR(255)",
           "sottotitolo"=>"VARCHAR(255)",
           "box"=>"ENUM('0','1')",
           "stato"=>"ENUM('0','1')",
           "table"=>"VARCHAR(255)",
           "insert"=>"ENUM('0','1')",
           "edit"=>"ENUM('0','1')",
           "view"=>"ENUM('0','1')",
           "livello"=>"INTEGER"
       ),
       "box"=>array(
           "id_sezioni"=>"INTEGER",
           "titolo"=>"TEXT",
           "sottotitolo"=>"TEXT",
           "descrizione"=>"TEXT",
           "img"=>"VARCHAR(255)",
           "img_2"=>"VARCHAR(255)",
           "img_3"=>"VARCHAR(255)",
           "img_4"=>"VARCHAR(255)",           
           "gallery"=>"TEXT",
           "viewport"=>"ENUM('','desktop','mobile')",
           "allegato"=>"VARCHAR(255)",
           "link"=>"VARCHAR(255)",
           "target"=>"ENUM('0','1')",
           "titolo_link"=>"VARCHAR(255)"
       )
   ));*/
   /*$values = array(
       "totale"=>"DOUBLE",
       "id_cliente"=>"INTEGER REFERENCES utenti(id) ON UPDATE CASCADE",
       "sconto"=>"DOUBLE",
       "sconto_perc"=>"INTEGER",
   );
   $nome_due = "ordini_righe";
   $values_due = array(
       "id_ordine"=>"INTEGER REFERENCES ordini(id) ON UPDATE CASCADE",
       "id_articolo"=>"INTEGER",
       "prezzo_1"=>"INTEGER",
       "data_aggiunta"=>"TIMESTAMP",
       "data_rimozione"=>"TIMESTAMP",       
   );
   \CMS\Conf\Console::createController("Ordini", $nome, $values);
   \CMS\Conf\Console::createController("Ordini", $nome_due, $values_due);*/
   /*$values_art = array(
       "codice_articolo"=>"VARCHAR(255) UNIQUE",
       "codice_macro"=>"VARCHAR(255)",
       "nome"=>"VARCHAR(255)",
       "descrizione"=>"TEXT",
       "prezzo_1"=>"DOUBLE",
       "prezzo_2"=>"DOUBLE",
       "stato"=>"ENUM('0','1','tmp')",
   );
   $values_promo = array(
       "articoli"=>"VARCHAR(255)",
       "macro"=>"VARCHAR(255)",
       "from"=>"DATE",
       "to"=>"DATE"
   );
   $values_macro = array(
       "nome"=>"VARCHAR(255)",
       "descrizione"=>"TEXT"
   );
   \Cms\Conf\Console::createController("Ordini","Articoli",$values_art);
   \Cms\Conf\Console::createController("Ordini","Promozioni",$values_promo);
   \Cms\Conf\Console::createController("Ordini","Macro",$values_macro);*/
   #\CMS\Conf\Console::createBundle("Ordini", array("articoli"));
   #\CMS\Conf\Console::updateBundle("Ordini");
   #\CMS\Conf\Console::createBundle("Data", array("utenti","agenzie"));
   #$utenti_tab = \CMS\Conf\Console::getController("DataBundle:Utenti");
   #$trovato = $utenti_tab->findBy(array($utenti_tab->getKeyName()=>"5"));
   #print_r($trovato);
   /* @var Utenti $trovato*/
   /*$trovato[0]->setNome("Dennis");
   #$trovato[0]->setNome("Sinned");
   $trovato[0]->save();*/
   //print_r($trovato);
   