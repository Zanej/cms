<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CMS\Conf;

/**
 * Description of FileUploader
 *
 * @author zane2
 */
class FileUploader {
    private $multi = false;
    private $folder;
    private $newname;
    private $name;
    private $error;
    private $success;
    /**
     * 
     * @param type $name
     * @param type $folder
     * @param type $newname
     */
    public function __construct($name,$folder,$newname="",$overwrite=false) {
        if(is_array($_FILES[$name])){
            if(is_array($_FILES[$name]["name"])){
                $this->multi = true;
            }
            $this->name = $name;
            $this->folder = $_SERVER["DOCUMENT_ROOT"]."/".$folder;            
            $this->newname = $newname;
            $this->checkProgress();    
            $this->checkUpload();
        }
    }
    /**
     * 
     */
    public function checkUpload(){        
        if(!file_exists($this->folder)){            
            if(!mkdir($this->folder,0755)){
                $this->error = array("DIR_FAILED",$this->folder);
                return false;
            }
        }
        $F = $_FILES[$this->name];
        if($this->multi){
            if(!$this->newname){
                foreach($F["name"] as $k => $v){
                    $this->newname[] = basename($v,$this->getExtension($v));
                }
            }
            $error_array = array();
            foreach($F["name"] as $k => $v){
                if(is_uploaded_file($F["tmp_name"][$k])){
                    $new_filename = $this->newname[$k].$this->getExtension($v);
                    if(!$overwrite && file_exists($this->folder."/".$new_filename)){
                        $this->error[] = array("FILE_EXISTS",$new_filename);
                    }else{//overwrite
                        echo $F["tmp_name"];
                        if(!move_uploaded_file($F["tmp_name"][$k], $this->folder."/".$new_filename)){
                            $this->error[] = array("MOVE_FILE",$new_filename);
                        }else{
                            $this->success[] = $new_filename;
                        }
                    }//else_overwrite
                }//uploaded
            }            
        }else{
            if(is_uploaded_file($F["tmp_name"])){
                $new_filename = $this->newname.$this->getExtension($F["name"]);
                if(!$overwrite && file_exists($this->folder."/".$new_filename)){
                    $this->error[] = array("FILE_EXISTS",$new_filename);
                }else{//overwrite                        
                    if(!move_uploaded_file($F["tmp_name"], $this->folder."/".$new_filename)){
                        $this->error[] = array("MOVE_FILE",$new_filename);
                    }else{
                        $this->success[] = $new_filename;
                    }
                }//else_overwrite                
            }            
            //print_r($_FILES);
        }        
    }
    /**
     * 
     * @param type $filename
     */
    private function getExtension($filename){
        $info = pathinfo($filename);
        return $info["extension"];        
    }
    /**
     * 
     */
    public function checkProgress(){
        //$key = ini_get("session.upload_progress.prefix") . $_POST[ini_get("session.upload_progress.name")];        
    }
    /**
     * 
     */
    public function getResult(){
        return array("success"=>$this->success,"error"=>$this->error);
    }
}
