<?php
 /*
 * Class Database : elle va repsesenté notre base de donnes et les opérations qui y vont avec
 */
    class Database{
        static private $_instance ;
        private $pdo;
        // function qui me renvera une instance de ma base de donnees
        static function getInstance(){
            if(self::$_instance==null){
                self::$_instance = new Database();
                return self::$_instance;
            }
            return self::$_instance;
        }
        // le constructeur de notre class
        function __construct(){

            // je recupere ma configuration
            $config = Config::getInstance();
            try{
                $this->pdo = new PDO($config->get('driver').'host='.$config->get('db_host').';dbname='.$config->get('db_name'),$config->get('db_user'),$config->get('db_password'));
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

            }catch(PDOException $e){
                die("Erreur : ".$e->getMessage());
            }

        }
        function getPdo(){
            return $this->pdo;
        }
        function query(){

        }
        function update(){

        }

    }