<?php
    class teatchingTable  extends videosTable{
        function __construct (Database $db){
            parent::__construct($db);
        }
        function find():Array{
            $pdo = $this->getPdo();
            $sql = $this->query("select","videos","*","where categorie = 'Teatching'");
            $req = $pdo->query($sql);
            $res = $req->fetchAll();
            return $res;
        }
        function findById(int $id):Array{
            $pdo = $this->getPdo();
            $sql = $this->query("select","videos","*","where categorie = 'Teatching' and id = $id");
            $req = $pdo->query($sql);
            $res = $req->fetchAll();
            return $res;
        }

        function select(Array|String $params,String $clause):Array{
            $sql = $this->query("select","videos",$params, $clause." and categorie = 'Teatching' ");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetchAll();
            return $res;
        }
        function getVideo(int $id):String{
            $sql = $this->query("select","videos",['path','extension'],"where id = $id and categorie = 'Teatching' ");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            return App::getInstance()->getImage("all_cat",$res['path'],$res['extension']);
        }
        function getDescriptionById(int $id):String{
            $sql = $this->query("select","videos","description","where id = $id ");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            return $res['description'];
        }


    }
