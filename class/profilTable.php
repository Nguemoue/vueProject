<?php
    class profilTable extends Table{

        protected $table_attribute = ['id','nom','extension','create_at','update_at','id_user'];
        private $database;
        private $pdo;
        function __construct(Database $db){$this->database = $db;}

        function insert(Array|String $settings):bool{
            $sql = $this->query("insert","profil",$settings,null);
            $pdo = $this->getPdo();
            return $pdo->exec($sql);
        }

        #retourne le pdo de la base de donnes injecté
        function updateByUser(Array | String $params , int $id):bool{
            $sql = $this->query("update","profil",$params,"where id_user = $id");
            $pdo = $this->getPdo();
            return $pdo->exec($sql);
        }
        #suprime le profil d'un utilisateur
        function deleteByUser(int $id):bool{
            $sql = $this->query("delete","profil",null,"where id_user = $id");
            $pdo = $this->getPdo();
            return $pdo->exec($sql);
        }

        #retourne le nom de l'image de profil suivant la condition
        function select($settings,$clause):?Array{
            $sql = $this->query("select","profil",$settings,$clause);
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            if(!$res){
                return [];
            }
            return $res;
        }


        function getPdo(){
            if($this->pdo==null){
                $this->pdo = $this->database->getPdo();
                return $this->pdo;
            }
            return $this->pdo;
            }
        }

        function getIdByUser(usersTable $table):int{
            $id = $table->getId();
            $pdo=$this->getPdo();
            $req = $this->query("select","profil","id","where id_user = $id");
            $res = $req->fetch();
            return $res['id'];
        }