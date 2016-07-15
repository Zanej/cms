<?php

namespace CMS\Conf;
use CMS\DbWorkers\Table;
use CMS\DbWorkers\QueryBuilder;
/**
 * Description of ControllerCreator
 *
 * @author zane2
 */
class EntityCreator {
    private $name;
    private $fields;
    private $foreignkeys;
    private $bundle;
    private $dir;
    private $filename;
    private $diversi;
    private $fieldsinfile;
    private $qb;
    private $fieldsindb;
    private $exclude;
    private $rowstoexclude;
    private $stream;
    private $new;
    private $old;
    private $indent = 4;
    /**
     * 
     * @param type $name
     * @param type $keys
     * @param type $columnnames
     * @param type $bundlename
     */
    public function __construct($name,$keys,$columnnames,$bundlename="Data"){
        $this->qb = new QueryBuilder();
        $this->bundle = $bundlename;
        $this->name = $name;
        $this->dir = $_SERVER["DOCUMENT_ROOT"]."\\".$bundlename."Bundle\Entity";
        if(!file_exists($this->dir)){
            mkdir($this->dir,0755);
        }
        $this->filename = $this->dir."\\".ucfirst($name).".php";
        $this->keys = $keys;
        $this->columnnames = $columnnames;
    }
    /**
     * 
     */
    public function create(){
        if(!file_exists($this->filename)){
            $this->stream = fopen($this->filename,'w');
            $this->updateFromDatabase(true);
        }else{
            $this->updateFromDatabase();
        }
    }
    /**
     * Aggiorna (o crea) l'entity da database
     * @param type $create devo crearlo?
     */
    public function updateFromDatabase($create = false){
        $this->getFileContents();
        $this->getDbContents();
        $this->fields = $this->fieldsindb;
        $this->writeToFile();
    }
    /**
     * 
     */
    public function updateToDatabase(){
        $this->getDbContents();
        $this->getFileContents();
        if(count($this->fieldsindb) == 0){
            echo "bbb";
            $this->fields = $this->fieldsinfile;
        }else{
            $this->checkFields("file");
            print_r($this->diversi);
            print_r($this->new);
            print_r($this->old);
            foreach($this->diversi as $chiave => $valore){
                $this->generaAlter($chiave,$valore);
            }
            foreach($this->new as $chiave => $valore){
                $this->generaAdd($chiave,$valore);
            }
            foreach($this->old as $chiave => $valore){
                $this->generaDrop($chiave);
            }
        }
    }
    /**
     * 
     * @param type $nome
     * @param type $campi
     */
    private function generaAlter($nome,$campi){
        $sql_="";
        if($campi->getDefault()){
            $sql_.= "DEFAULT = ".$campi->getDefault().",";
        }        
        $this->qb->alterColumn($this->name, $nome, $sql_,$campi->getType(),$campi->getNullable());
    }
    /**
     * 
     * @param type $nome
     * @param type $campi
     */
    private function generaAdd($nome,$campi){
        $sql_ =$type = $campi->getType().", ";
        if($campi->getDefault()){
            $sql_.= "DEFAULT = ".$campi->getDefault().",";
        }        
        if($campi->getNullable()){
            $sql.=" NULLABLE = ".$campi->getNullable();
        }
        if($sql_[strlen($sql_)-1] == ","){
            $sql_ = substr($sql_,0,-1);
        }
        if($sql_){
            $this->qb->addColumn($this->name, $nome, $sql_);
        }
    }
    /**
     * 
     * @param type $nome
     */
    private function generaDrop($nome){
        $this->qb->dropColumn($this->name, $nome);
    }
    private function writeToFile(){
        
        $this->setDaEscludere();
        $tmp_filename = substr($this->filename,0,-4).".php";
        $this->stream = fopen($tmp_filename,"w");
        $this->header();
        $this->pre();
        $this->writeFields();
        $this->writeSetters();
        $this->writeGetters();
        $this->corpo();
        $this->footer();
    }
    /**
     * 
     */
    private function getFileContents(){
        $contents = file_get_contents($this->filename);
        $rows = explode("\n",$contents);
        for($i=1;$i<count($rows);$i++){
            $row = trim($rows[$i]);
            if(substr($row,0,3) == "/**"){
                $field = Field::isField($rows, $i+1);
                if($field !== false){
                    $this->fieldsinfile[$field->getName()] = $field;
                    while(!strstr($rows[$i],"protected $".$field->getName()) && $i < count($rows)){
                        $i++;
                    }
                    
                }else{
                    $this->rowstoexclude[] = array("before"=>count($this->fieldsinfile) == 0 ? true : false,
                        "content"=>$rows[$i]);
                }
            }else{
                $this->rowstoexclude[] = array("before"=>count($this->fieldsinfile) == 0 ? true : false,""
                    . "content"=>$rows[$i]);
            }
        }
    }
    /**
     * 
     */
    private function getDbContents(){
        if(Table::exists($this->name)){
            $names = Config::getDB()->GetColumnNames($this->name);
            foreach($names as $chiave => $nome){
                $valori_var  = $this->getDbVarInfoByDB($nome);
                $field_tmp = new Field($valori_var["type"]);
                $field_tmp->setNullable($valori_var["nullable"]);
                $field_tmp->setDefault($valori_var["default"]);
                $field_tmp->setName($nome);       
                if($valori_var["key"]){
                    $field_tmp->setKey($valori_var["key"]);       
                }
                $field_tmp->setExtra($valori_var["extra"]);   
                $this->fieldsindb[$nome] = $field_tmp;
            }
        }        
    }
    /**
     * 
     * @param type $var
     * @return type
     */
    private function getDbVarInfoByDB($var){
        return array(
            "type"=>Config::getDB()->getColumnType($var,$this->name),
            "default"=>Config::getDb()->GetDefaultValue($var,$this->name),
            "key"=>isset($this->keys[$var]) ? $this->keys[$var] : null,
            "extra"=>Config::getDb()->GetColumnExtras($var,$this->name),
            "nullable"=>Config::getDb()->IsNullableColumn($var,$this->name)
        );
    }
    /**
     * 
     * @param type $whichimportant
     */
    private function checkFields($whichimportant="file"){
        $old = $whichimportant == "file" ? $this->fieldsindb : $this->fieldsinfile;
        $new = $whichimportant == "file" ? $this->fieldsinfile : $this->fieldsindb;
        $chiavi  = array_keys($old);
        foreach($chiavi as $chiave){
            if(!isset($new[$chiave])){
                $this->old[$chiave] = false;
            }
        }
        foreach($new as $chiave => $valore){
            if(!isset($old[$chiave])){
                $this->new[$chiave] = $valore;
            }else{
                $this->isDifferent($old[$chiave], $valore);
            }
        }
        //print_r($this->diversi);
    }
    /**
     * 
     * @param type $original_field
     * @param type $newfield
     */
    private function isDifferent($original_field,$newfield){
        $check = array(
            "type"=>array("setter"=>"setType","getter"=>"getType"),
            "default"=>array("setter"=>"setDefault","getter"=>"getDefault"),
            "extra"=>array("setter"=>"setExtra","getter"=>"getExtra"),
            "key"=>array("setter"=>"setKey","getter"=>"getKey"),
            "nullable"=>array("setter"=>"setNullable","getter"=>"getNullable")            
        );
        $diverso = false;
        foreach($check as $nome => $metodi){
            $getter = $metodi["getter"];    
            if(trim(strtolower($original_field->$getter())) != trim(strtolower($newfield->$getter()))){
                $diverso = true;
            }
        }
        if($diverso){
            $this->diversi[$original_field->getName()] = $newfield;
        }
    }
    private function writeFields(){
        
        foreach($this->fields as $chiave => $valore){
            fwrite($this->stream,$this->printSpaces($this->indent)."/**\n");
            fwrite($this->stream,$this->printSpaces($this->indent)." *@var ".$valore->getType()."\n");
            if($valore->getKey()){
                fwrite($this->stream,$this->printSpaces($this->indent)." *@key ".$valore->getKey()."\n");
            }
            fwrite($this->stream,$this->printSpaces($this->indent)." *@default ".$valore->getDefault()."\n");
            fwrite($this->stream,$this->printSpaces($this->indent)." *@extra ".$valore->getExtra()."\n");
            fwrite($this->stream,$this->printSpaces($this->indent)." *@nullable ".$valore->getNullable()."\n");
            fwrite($this->stream,$this->printSpaces($this->indent)." */\n");
            fwrite($this->stream,$this->printSpaces($this->indent)."protected $".$chiave.";\n");
        }
    }
    /**
     * 
     */
    private function writeSetters(){
        foreach($this->fields as $chiave => $valore){
            $column_set=str_replace(" ","",ucwords(str_replace("_"," ",$chiave)));
            fwrite($this->stream,$this->printSpaces($this->indent)."public function set".$column_set."($".$chiave."){\n");
            fwrite($this->stream,$this->printSpaces($this->indent).$this->printSpaces($this->indent/2)."\$this->".$chiave."=$".$chiave.";\n");
            fwrite($this->stream,$this->printSpaces($this->indent)."}\n");
        }
    }
    /**
     * 
     */
    private function writeGetters(){
        foreach($this->fields as $chiave => $valore){
            $column_get=str_replace(" ","",ucwords(str_replace("_"," ",$chiave)));
            fwrite($this->stream,$this->printSpaces($this->indent)."public function get".$column_get."(){\n");
            fwrite($this->stream,$this->printSpaces($this->indent).$this->printSpaces($this->indent/2)."return \$this->".$chiave.";\n");
            fwrite($this->stream,$this->printSpaces($this->indent)."}\n");
        }
        
    }
    /**
     * 
     */
    private function header(){
        fwrite($this->stream,"<?php\n".$this->printSpaces($this->indent)."namespace CMS\\".$this->bundle."Bundle\Entity;\n");
        fwrite($this->stream,$this->printSpaces($this->indent)."use CMS\DbWorkers\AbstractDbElement; \n");
        fwrite($this->stream,$this->printSpaces($this->indent)."class ".ucfirst($this->name)." extends AbstractDbElement{\n");
        $this->indent=$this->indent*2;
    }
    /**
     * 
     */
    private function footer(){
        $this->indent=$this->indent/2;
        fwrite($this->stream,$this->printSpaces($this->indent)."}");
        fclose($this->stream);
    }
    /**
     * 
     */
    private function corpo(){
        foreach($this->rowstoexclude as $row){
            if($row["before"] == 0){
                if($this->isToExclude($row["content"])){
                    fwrite($this->stream,$row["content"]."\n");
                }
            }
        }
    }
    /**
     * 
     */
    private function pre(){
        foreach($this->rowstoexclude as $row){
            if($row["before"] == 1){
                if($this->isToExclude($row["content"])){
                    fwrite($this->stream,$row["content"]."\n");
                }
            }
        }
    }
    /**
     * 
     * @param type $howmuch
     * @return string
     */
    private function printSpaces($howmuch){
        $string = "";
        for($i=0;$i<$howmuch;$i++){
            $string.=" ";
        }
        return $string;
    }
    /**
     * 
     */
    private function setDaEscludere(){
        $this->exclude = array();
        foreach($this->fields as $chiave => $valore){
            $nome_colonna_setter=str_replace(" ","",ucwords(str_replace("_"," ",$chiave)));
            $this->exclude[] = array("function"=>"public function get$nome_colonna_setter","num_rows"=>"3");
            $this->exclude[] = array("function"=>"public function set$nome_colonna_setter","num_rows"=>"3");
        }
        for($i=count($this->rowstoexclude)-1;$i>=0;$i--){
            if(trim($this->rowstoexclude[$i]["content"]) == "}"){                
                unset($this->rowstoexclude[$i]);
                break;
            }
        }
        foreach($this->rowstoexclude as $chiave => $riga){
            foreach($this->exclude as $escludi){
                if(strstr($riga["content"],$escludi["function"])){
                    for($j=$chiave;$j<$chiave + $escludi["num_rows"];$j++){
                        unset($this->rowstoexclude[$j]);
                    }
                }
            }
        }
        
    }
    /**
     * 
     * @param type $row
     * @return boolean
     */
    private function isToExclude($row){
        if(strstr($row,"class ".ucfirst($this->name)." extends AbstractDbElement")){
            return false;
        }
        if(strstr($row,"namespace CMS\\".$this->bundle."Bundle\Entity")){
            return false;
        }
        if(strstr($row,"use CMS\DbWorkers\AbstractDbElement")){
            return false;
        }
        if(trim($row) == ""){
            return false;
        }
        foreach($this->exclude as $escludi){
            if(strstr($row,$escludi)){
                return false;
            }
        }
        //return false;
        return true;
    }
}