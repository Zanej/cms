<?php
   require_once($_SERVER["DOCUMENT_ROOT"]."/dbworkers/Table.class.php");
   global $db;
   /*$field = array(
       "nome"=>"VARCHAR|255",
       "cognome"=>"VARCHAR|255",
       "codice_fiscale"=>"VARCHAR|16|UNIQUE"
   );
   $table = new Table("Utenti", true, false, $field);
   */
   $table = new Table("Utenti");
   $table->insert(array("nome"=>"asd","cognome"=>"asd","codice_fiscale"=>"asdasdasd"));
   $table->updateKey(23,array("nome"=>"Dennis","cognome"=>"Zanetti","codice_fiscale"=>"Z23G64"));
  // $db_elem = new DbElement(null,,"id_utente","utenti");
  //echo json_encode($db_elem->getResult());
   echo $db->Error();