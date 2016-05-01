<?php

namespace CMS\Conf;

/**
 * Description of Field
 *
 * @author zane2
 */
class Field {
    private $type;
    private $nullable;
    private $default;
    private $extra;
    private $key;
    private $name;
    private static $types = array("@key"=>"setKey","@default"=>"setDefault","@nullable"=>"setNullable","@extra"=>"setExtra");
    /**
     * 
     * @param type $rows
     */
    /**
     * 
     * @param type $type
     */
    public function __construct($type){
        $this->type = $type;
    }
    /**
     * 
     * @param type $nullable
     */
    public function setNullable($nullable){
        $this->nullable = $nullable;
    }
    /**
     * 
     * @param type $key
     */
    public function setKey($key){
        if(is_array($key)){
            $this->key = $key["key_name"]."|".$key["key_type"];
        }else{
            $this->key = $key;
        }
    }
    /**
     * 
     * @param type $default
     */
    public function setDefault($default){
        $this->default = $default;
    }
    /**
     * 
     * @param type $extra
     */
    public function setExtra($extra){
        $this->extra = $extra;
    }
    /**
     * 
     * @param type $name
     */
    
    public function setName($name){
        $this->name = $name;
    }
    /**
     * 
     * @return type
     */
    public function getName(){
        return $this->name;
    }
    /**
     * 
     * @return type
     */
    public function getKey(){
        return $this->key;
    }
    /**
     * 
     * @return type
     */
    public function getDefault(){
        return $this->default;
    }
    /**
     * 
     * @return type
     */
    public function getNullable(){
        return $this->nullable;
    }
    /**
     * 
     * @return type
     */
    public function getExtra(){
        return $this->extra;
    }
    /**
     * 
     * @return type
     */
    public function getType(){
        return $this->type;
    }
    /**
     * 
     */
    public function getForeignKeys(){
        
    }
    /**
     * 
     * @param type $field
     */
    public function setForeignKey($field){
        
    }
    /**
     * 
     * @param array $rows
     * @param integer $index
     */
    public static function isField($rows,$index){
        if(strstr($rows[$index],"@var")){            
            $field = new Field(self::removeComments($rows[$index], "@var"));
            $index++;
            while(!strstr($rows[$index],"*/")){
                $row = $rows[$index];
                foreach(self::$types as $type => $method){
                    if(strstr($row,$type)){
                        $field->$method(self::removeComments($row,$type));
                    }
                }
                $index++;
            }
            $field->setName(trim(str_replace("protected $","",str_replace(";","",$rows[$index+1]))));
            return $field;
        }else{
            return false;
        }
    }
    private static function removeComments($row,$type){
        return str_replace("*","",str_replace($type,"",trim($row)));
    }
}
