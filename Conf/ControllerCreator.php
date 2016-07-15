<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CMS\Conf;

/**
 * Description of ControllerCreator
 *
 * @author zane2
 */
class ControllerCreator {
    private $name;
    private $foreignclasses;
    private $bundle;
    private $stream;
    private $filename;
    private $indent = 4;
    public function __construct($name,$bundlename){
        $this->bundle = $bundlename;
        $this->name = $name;
        $dir = $_SERVER["DOCUMENT_ROOT"]."/".$bundlename."Bundle/"."Controller";
        if(!file_exists($dir)){
            mkdir($dir,0755);
        }
        $this->filename = $dir."\\".ucfirst($name)."Controller.php";
        if(!file_exists($this->filename)){
            $this->create();
        }
    }
    public function updateFromDatabase(){
        
    }
    public function create(){
        $this->stream = fopen($this->filename,'w');
        $this->print_();
    }
    public function updateToDatabase(){
        
    }
    private function print_(){
        $this->header();
        $this->construct();
        $this->footer();
    }
    private function header(){
        fwrite($this->stream,"<?php\n".$this->printSpaces($this->indent)."namespace CMS\\".$this->bundle."Bundle\Controller;\n");
        fwrite($this->stream,$this->printSpaces($this->indent)."use CMS\Controller\AbstractController; \n");
        fwrite($this->stream,$this->printSpaces($this->indent)."class ".ucfirst($this->name)."Controller extends AbstractController{\n");
        $this->indent*=2;
    }
    private function construct(){
        fwrite($this->stream,$this->printSpaces($this->indent)."function __construct(){\n");
        fwrite($this->stream,$this->printSpaces($this->indent).$this->printSpaces($this->indent/2)."    "."parent::__construct('".$this->name."');\n");
        fwrite($this->stream,$this->printSpaces($this->indent)."}\n");
    }
    private function footer(){
        $this->indent/=2;
        fwrite($this->stream,$this->printSpaces($this->indent)."}");
        fclose($this->stream);
    }
    private function printSpaces($howmuch){
        $string = "";
        for($i=0;$i<$howmuch;$i++){
            $string.=" ";
        }
        return $string;
    }
}
