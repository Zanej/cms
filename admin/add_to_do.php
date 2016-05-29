<?php
    use CMS\Conf\FileUploader;
    use CMS\AdminBundle\Entity\Todolist;   
    use CMS\Conf\Config;
    use CMS\AdminBundle\Controller\Adm_usersController as AdminController;
    if(!AdminController::isUserLogged()){
        echo json_encode(array("error"=>"Non sei loggato","logout"=>true));
        exit;
    }
    if(!isset($_POST["messaggio"])){
        echo json_encode(array("error"=>"Inserire il testo!"));
        exit;
    }
    $controller = new AdminController();
    $user = $controller->getUserLogged();
    if(!$user){
        exit;
    }
    $params = array(
        "testo"=>trim(addslashes($_POST["messaggio"])),
        "data_aggiunta"=>date("Y-m-d H:i:s"),
        "id_user"=> $user->getId()
    );
    $list = new Todolist(null, $params);        
    if(is_numeric($list->getId())){
        $success = true;
    }else{
        echo json_encode(array("error"=>"There was an error"));
        exit;
    }
    if(count($_FILES["immagini"]) > 0){
        $imm = new FileUploader("immagini","admin/upNoteImages/".$list->getId());
        $result = $imm->getResult();
        $list->setGallery(implode(",",$result["success"]));
        //print_r($result);
    }
    if(count($_FILES["file"]) > 0){
        $file = new FileUploader("file","admin/upNoteAllegati/".$list->getId());
        $result = $file->getResult();
        $list->setAllegato(implode(",",$file->getResult()));
    }
    $list->save();
    echo json_encode(array("success"=>true,"lista"=>$list->getParams()));

