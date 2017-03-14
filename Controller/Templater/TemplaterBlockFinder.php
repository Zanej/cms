<?php
	class TemplaterBlockFinder{

		private $matches = array();

		public function __construct($template){

			$m = preg_match_all("({{(.*?)}})", $template, $this->matches);
		}
	}