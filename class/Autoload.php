<?php
	/*namespace App\Util;*/
	class Autoload{
		function __construct(){}
		public static function  autoload($class_name){
			// var_dump($class_name);
			// $class_name = str_replace(__NAMESPACE__,'',$class_name);
			require 'class'.DIRECTORY_SEPARATOR.$class_name.'.php';
		}
		public static function register(){
			spl_autoload_register([__CLASS__,'autoload']);
		}
	}

