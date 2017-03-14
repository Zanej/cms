<?php
	namespace CMS\Controller;

	define("DIR_TEMPLATER", "Templater");
	class Templater{

		

		public function __construct(){
			
		}

		public function __autoload(){

			$scan = scandir(__DIR__."/".DIR_TEMPLATER);

			foreach($scan as $k => $v){

				if(strstr($v,".php") !== false){

					include($v);
				}
			}

		}

	}