<?php
    class dailybreadsTable extends Table{

        protected $table_attribute = ['id','titre','path','create_at','extension','description','nom','id_post'];
        private $database;
        private $pdo;
        function __construct(Database $db){$this->database = $db;}

        function insert(Array|String $settings):bool{
            $sql = $this->query("insert","dailybreads",$settings,null);
            $pdo = $this->getPdo();
            return $pdo->exec($sql);
        }
        function find():Array{
            $sql = $this->query("select","dailybreads","*","where 1");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            return $req->fetchAll();
        }
        #retourne le pdo de la base de donnes injecté
        function updateByUser(Array | String $params , int $id):bool{
            $sql = $this->query("update","dailybreads",$params,"where id_post = $id");
            $pdo = $this->getPdo();
            return $pdo->exec($sql);
        }

        #retourne le nom de l'image de profil suivant la condition
        function select(Array | String $settings,string $clause):?Array{
            $sql = $this->query("select","dailybreads",$settings,$clause);
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            if(!$res){
                return [];
            }
            return $res;
        }
        #retoure
        function deleteByUser($id):bool{
        $sql = $this->query("delete","dailybreads",null,"where id_post = $id ");
        $pdo = $this->getPdo();
        return $pdo->exec($sql);
        }



        function getPdo(){
        if($this->pdo==null){
            $this->pdo = $this->database->getPdo();
            return $this->pdo;
        }
        return $this->pdo;
        }

        function findById(int $id):Array{
            return $this->select("id,nom,titre,description","where id = $id");
        }

    }