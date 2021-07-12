<?php
    class videosTable extends Table{
    protected $table_attribute = ['nom','titre','description','create_at','id_admin','categorie','path','extension','id_img'];
    protected $database;
    protected $pdo;
    /**
     * Class Constructor
     */
    public function __construct(Database $db){
        $this->database = $db;
    }
    function getPdo(){
        if($this->pdo==null){
            $this->pdo = $this->database->getPdo();
            return $this->pdo;
        }
        return $this->pdo;
    }
    function find():Array{
        $sql = $this->query('select',"videos","*","where 1");
        $pdo = $this->getPdo();
        $req = $pdo->query($sql);
        return $req->fetchAll();
    }
    function insert(Array | String $settings):bool{
        #je recupere l'id de l'utilisateur
        var_dump($settings);
        $sql = $this->query('insert','videos',$settings,null);
        var_dump($sql);
        $pdo = $this->getPdo();
        $req = $pdo->exec($sql);
        return $req;
    }
    function getImg(imageTable $table , $id):Array{
        $sql = $this->query("select","image",["path","extension"],"where id = $id");
        $pdo = $this->getPdo();
        $req = $pdo->query($sql);
        $res = $req->fetch();
        return $res;
    }

    }

