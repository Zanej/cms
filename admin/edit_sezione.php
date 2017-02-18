<?php

	use CMS\AdminBundle\Entity\Sezioni;

	if($_POST["type"] == "lock"){

		if(!$_POST["sezione"] || !$_POST["id"]){

			echo json_encode(array("success"=>false,"message"=>"Mandatory fields not set"));
			exit;
		}

		$sezione = new Sezioni($_POST["sezione"]);


		$object = $sezione->getRows("scheda",array($sezione->getChiave()=>$_POST["id"]),"1");				

		$object = $object[0];
		$object->setStato("0");
		$object->save();
		$result = $object->getResult();		

		echo json_encode($result);

	}elseif($_POST["type"] == "unlock"){

		
		if(!$_POST["sezione"] || !$_POST["id"]){

			echo json_encode(array("success"=>false,"message"=>"Mandatory fields not set"));
			exit;
		}

		$sezione = new Sezioni($_POST["sezione"]);		

		$object = $sezione->getRows("scheda",array($sezione->getChiave()=>$_POST["id"]),"1");

		$object = $object[0];
		$object->setStato("1");
		$object->save();
		$result = $object->getResult();

		echo json_encode($result);		

	}

