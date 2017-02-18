<?php
    namespace CMS\TaskBundle\Controller;
    use CMS\Controller\AbstractController; 
    use CMS\DbWorkers\QueryBuilder;
    use CMS\TaskBundle\Entity\Cms_lang;

    class Cms_langController extends AbstractController{

    	private static $traductions;
    	private static $lang;

        function __construct(){
            parent::__construct('cms_lang');
            self::$lang = $_SESSION["LANG"];
            if(!self::$lang){

            	self::$lang = 1;
            }

            self::getTraductions();
        }

        static function gsl($key,$position){

        	$key_add = trim(strtolower(strip_tags($key)));
    		$position_add = trim(strtolower(strip_tags($position)));    		

        	if(!isset(self::$traductions[$key_add][$position_add])){
        		
				$traduction_add = trim($key);

				$params = array(
					"key_name"=>$key_add,
					"position"=>$position_add,
					"traduction"=>$traduction_add,
					"lang"=>self::$lang
				);				

				$trad = new Cms_lang(null,$params);

				self::$traductions[$key_add][$position_add] = $traduction_add;				

        		return $key;
        	}else{


        		return self::$traductions[$key_add][$position_add];
        	}
        }

        static function getTraductions(){

        	$qb = new QueryBuilder();

        	$result = $qb->Select("cms_lang","*",array("lang"=>self::$lang))->getResult(false);


        	if($result){
        		

        		foreach($result as $k => $v){

        			self::$traductions[$v["key_name"]][$v["position"]]=$v["traduction"];
        		}        		

        	}else{

        		self::$traductions = array();
        	}
        	
        }


    }
