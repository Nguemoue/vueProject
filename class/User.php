<?php
    class User{
        private static $connected = false;

        public static function connected(){
            return isset($_SESSION['auth']);
        }

        public static function disconnect(){
            #je detruit ma session lie a l'auth
            if(self::connected()) unset($_SESSION['auth']);
        }
        public static function getNom(){
            if(self::connected()){
                // on recupere le nom depuis la bd
                return Database::getInstance()->getNomByEmail(self::getEmail());
            }else{
                return 'Utilisateur';
            }
        }
        public static function getEmail(){
            if(self::connected()){
                return $_SESSION['auth'];
            }else{
                return 'user@gmail.com';
            }
        }
        public static function getId(){
            if(self::connected()){
                return Database::getInstance()->getIdByEmail($_SESSION['auth']);
            }else{
                return -1;
            }
        }

        public static function getProfil(){
            #elle retourne le chemin de la photo de profile de l'utilisateur connecté
            if(self::connected()){
                #je recupere le chemin ver la bd de mon imgae
                $id_user = Database::getInstance()->getIdByEmail(self::getEmail());
                #je recupere le nom puis l'exetension du fichier dans la table profil suivant l'id
                $profil_info = Database::getInstance()->getProfil($id_user);
                return $profil_info;
            }else{
                return "img".DIRECTORY_SEPARATOR."profil".DIRECTORY_SEPARATOR."default.jpg";
            }
        }
        public static function isAdmin(){
            $f;
            $id=0;
            $champ = User::getEmail();
            if(is_string($champ)){
                $id = Database::getInstance()->getIdByEmail($champ);
            }

            $pdo = Database::getInstance()->getPdo();
            $res=$pdo->query("SELECT * FROM administrateur where user_id = '$champ' or user_id = $id ");
            $res = $res->fetch();
            if($res){
                return true;
            }
            return false;
        }
        public static function getIdAdmin(){
            if(self::isAdmin()){
                $id = (int) self::getId();
                $f = Database::getInstance()->getPdo()->query("SELECT id from administrateur where user_id = ".$id);
                $f = $f->fetch();
                if($f){
                    $res = $f['id'];
                }else $res = -1;
                return (int) $res;
            }
        }

    }

