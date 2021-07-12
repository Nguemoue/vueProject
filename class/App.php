<?php
    /**
     * Class App elle va representé le centre de monn application et sa sera un singleton
     * elle fourni un acces à toutes le classes de notre app
    */
    class App{
        // il contient l'instace de notre table
        private static $_instance;
        private static $_table;
        private static $_database;

        // function getInstance qui vas me retourne une et une seule instance de ma class
        static function getInstance(){
            if(is_null(self::$_instance)){
                self::$_instance = new App();
            }
            return self::$_instance;
        }
        // constrcuteru de notre app
        function __construct(){

        }
        //je recupre les instance de chaque table

        function isConnected(){
            return isset($_SESSION['auth']);
        }
        function generateFileName(String $file_name):String{
            return $file_name."".date("Y_m_d_H_i_s");
        }
        function uploadFile(String $tmp,String $file,String $type):void{
            if($type=="profil"){
                move_uploaded_file($tmp,"img/profil/$file");
            }else if($type=="dailybreads"){
                move_uploaded_file($tmp,"../../img/dailyBreads/$file");
            }else if($type=="all_cat"){
                move_uploaded_file($tmp,"../../videos/all_cat/".$file);
            }
        }
        function getImage(String $type,String $filename):String{
            if($type=="profil"){
                return "img/profil/$filename";
            }else if($type=="dailybreads"){
                return "img/dailyBreads/$filename";
            }else if($type=="all_cat"){
                return "videos/all_cat/$filename";
            }
            return "";
        }
        function isAdmin(usersTable $table):bool{
            if(!$this->isConnected()){
                return false;
            }
            $id_user= $table->getId();
            $pdo = $table->getPdo();
            $req=$pdo->query("select * from administrateur where user_id = $id_user");
            $res=$req->fetch();
            if($res){
                return true;
            }
            return false;
        }
        function getIdAdmin(usersTable $table):int{
            if(!$this->isConnected()){
                die('erruer imposiible de recupere l id de l admin');
            }
            $id_user = $table->getId();
        }

    }