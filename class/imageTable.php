<?php
    class imageTable extends Table{
        protected $table_attribute = ['create_at','path','extension','id_post'];
        private $pdo;
    /**
     * Class Constructor
     */
    public function __construct(Database $db){ $this->database = $db;}

    function updateByUser(Array | String $params , int $id):bool{
        $sql = $this->query("update","image",$params,"where id_post = $id");
        $pdo = $this->getPdo();
        return $pdo->exec($sql);
    }

    #retourne le nom de l'image de profil suivant la condition
    function select($settings,$clause):?Array{
        $sql = $this->query("select","image",$settings,$clause);
        $pdo = $this->getPdo();
        $req = $pdo->query($sql);
        $res = $req->fetch();
        if(!$res){
            return [];
        }
        return $res;
    }

    function deleteByUser($id):bool{
        $sql = $this->query("delete","image",null,"where id_post = $id ");
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
    function insert(Array | String $settings):bool{
        $sql = $this->query("insert","image",$settings,null);
        $pdo= $this->getPdo();
        return $pdo->exec($sql);
    }
    function getLastId():int{
        $pdo = $this->getPdo();
        $sql = $this->query("select","image","id","order by id desc limit 1");
        $req = $pdo->query($sql);
        $res = $req->fetch();
        if($res){
           return $res['id'];
        }
        return -1;
    }
    function getImagePath(int $id):string{
        $sql = $this->query("select","image","path,extension","where id = $id ");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            return $res['path'].".".$res['extension'];
    }
    function getIdImg(int $id):int{
            $sql = $this->query("select","videos","id_img","where id = $id ");
            $pdo = $this->getPdo();
            $req = $pdo->query($sql);
            $res = $req->fetch();
            return $res['id_img'];
        }

}
