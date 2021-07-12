<?php
    class Config{
        private static $_instance;
        private $keys;
        function __construct(){
            $this->keys = require('ConfigSetting.php');
        }
        // function get :  retourne un parametre en fonction de la cle
        function get($key){
            if(isset($this->keys[$key])){
                return $this->keys[$key];
            }
            return null;
        }
        // function getInstance retournera une et une seule instance de notre class
        static function getInstance(){
            if(is_null(self::$_instance)){
                self::$_instance = new Config();
                return self::$_instance;
            }
            return self::$_instance;
        }

    }