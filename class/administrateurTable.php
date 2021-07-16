<?php
    class administrateurTable extends Table{
        protected $database;
        protected $pdo;
        protected $table_attribute = ['id','grade','description','user_id'];
        function __construct(Database $dbname){
            $this->database = $dbname;
        }
        function getIdByUser(usersTable $table):int{
            $id = $table->getId();
            $sql = $this->query("select","administrateur","id","where user_id = $id");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            return $res?$res['id']:-1;
        }

        #retourne le pdo de la base de donnes injecté
        function getPdo(){
            if($this->pdo==null){
                $this->pdo=$this->database->getPdo();
                return $this->pdo;
            }
            return $this->pdo;
        }
        #function qui recupere le nom
        function getNom(usersTable $table,int $id):String{
            $pdo = $this->getPdo();
            $res = $table->getNom($id);
            #je selectionne le titre de la personne
            $titre = $this->select('grade',"where id = $id");
            $titre = $titre['grade'];
            return $titre." ".$res;
        }
        #selectione les donnes
        function select(Array | String $settings,String $clause):Array{
            $sql = $this->query("select","administrateur",$settings,$clause);
            $pdo = $this->getPdo();
            $req=$pdo->query($sql);
            $res=$req->fetch();
            return $res?$res:[];
        }
    }

