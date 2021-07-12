<?php
    class encounterTable  extends videosTable{
        function __construct (Database $db){
            parent::__construct($db);
        }
        function find():Array{
            $pdo = $this->getPdo();
            $sql = $this->query("select","videos","*","where categorie = 'Encounter'");
            $req = $pdo->query($sql);
            $res = $req->fetchAll();
            return $res;
        }
        function findById(int $id):Array{
            $pdo = $this->getPdo();
            $sql = $this->query("select","videos","*","where categorie = 'Encounter' and id = $id");
            $req = $pdo->query($sql);
            $res = $req->fetch();
            return $res;
        }
        function select(Array|String $params,String $clause):Array{
            $sql = $this->query("select","videos",$params, $clause." and categorie = 'Encounter' ");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetchAll();
            return $res;
        }
        function getVideoPath(int $id):String{
            $sql = $this->query("select","videos",['path','extension'],"where id = $id and categorie = 'Encounter' ");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            if(!$res)
                return '';
            return App::getInstance()->getImage("all_cat",$res['path'].".".$res['extension']);
        }
        function getDescription(int $id):String{
            $sql = $this->query("select","videos","description","where id = $id ");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            return $res['description'];
        }
        function getPoster(imageTable $table,int $id):String{
            return $table->getImagePath($id);
        }



    }
