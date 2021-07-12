<?php
    /**
     * class qui vas representer l'ensemble des utilisateur
     * */
class usersTable extends Table{
    protected $table_attribute = ['nom','email','age','tel','sexe','ville','pays','password',
        'create_at','activate_at','token','active'];
        // on cree les attribut etranger
    protected $database;
    private $all;
    private $pdo;
    private $default_path = "img/profil/default.jpg";
    function __construct(Database $dbname){
        $this->database = $dbname;
    }
        // la fonction return un tableau contenant toutes les donnes des utilisateurs
        function find(){
            $pdo = $this->database->getPDo();
            $req = $pdo->prepare("SELECT *  FROM users ");
            $res = $req->execute();
            if(!$res){
                die("Erreur : veuillez verifier les champs de la bd ");
            }
            return $req->fetchAll();
        }

        #met à jour les info de l'utilisateur retourne vrai ou faux
        function update(Array | String $settings,String $clause):bool{
            $sql = $this->query("update","users",$settings,$clause);

            #je recupere mon pdo
            $pdo = $this->getPdo();
            #j'execute ma requete
            return $pdo->exec($sql);
        }
        #suprime seln une condition
        function delete(String $clause):bool{
            $sql = $this->query("delete","users",null,$clause);
            $pdo = $this->getPdo();
            return $pdo->exec($sql);
        }
        #selectione les donnes
        function select(Array | String $settings,String $clause):Array{
            $sql = $this->query("select","users",$settings,$clause);

            $pdo = $this->getPdo();
            $req=$pdo->query($sql);
            $res=$req->fetch();
            return $res?$res:[];
        }

        #insert les donnes suivant une condition
        function insert(Array $settings):bool{
            $sql = $this->query("insert","users",$settings,"null");
            $pdo = $this->getPdo();
            return $pdo->exec($sql);
        }

        // met a jour le profil de l'utilisateur
        function updateProfil(profilTable $table,Array $settings):bool{
            $res = $table->updateByUser($settings,$this->getId());
            return $res;
        }
        function deleteProfil(profilTable $table):bool{
            $res = $table->deleteByUser($this->getId());
            return $res;
        }

        // recupere tout les message de l'utilisateur
        function getReceiveMessage(Message $table){

        }

    #recupere le profile de l'utilisateur
    function getProfil(profilTable $table): mixed{
        $res = $table->select(['nom','extension'],"where id_user = {$this->getId()}");
        if(empty($res)){
            return $this->default_path;
        }
        return App::getInstance()->getImage("profil",$res['nom'],$res['extension']);
    }

    function keysMatched(Array $keys):Bool{
        $result = true;
        foreach (array_keys($keys) as $key=>$value){
            if(!in_array($value,$this->table_attribute)){
             $result = false;
            }
        }
        return $result;
    }

    function getDatabase(){return $this->database;}

    function getToken():String{return substr( str_shuffle(uniqid('L')),0,4);}

    function updateToken($id):bool{
        $token=$this->getToken();
        return $this->update(['token'=>$token],"where id = $id");
    }

    #retourne le pdo de la base de donnes injecté
    function getPdo(){
        if($this->pdo==null){
            $this->pdo=$this->database->getPdo();
            return $this->pdo;
        }
        return $this->pdo;
    }
        #retourne l'id de l'utilisateur connecté
    function getId():int{
        if(App::getInstance()->isConnected()){
            $pdo = $this->getPdo();
            $sql = $this->query("select","users","id","where email = '".$_SESSION['auth']."'");
            $req = $pdo->query($sql);
            $res = $req->fetch();
            if($res){
                return $res['id'];
            }
        }
        return 0;
    }

    public function insertProfil(imageTable $table , $settings):bool{
        $res = $table->insert($settings);
        return $res;
    }

    function getNom():String{
        #je verifie si l'utilisateur est connecté
        if($this->getId()==0){
            $this->all = ['nom'=>'user','email'=>'user@gmail.com'];
        }else{
            if($this->all == null){
                $id = $this->getId();
                $this->all = $this->select("*"," where id = ".$id);
            }
        }
        return $this->all['nom'];
    }
    function getIdProfil():String{
        #je verifie si l'utilisateur est connecté
        if($this->getId()==0){
            $this->all = ['nom'=>'user','email'=>'user@gmail.com',''];
        }else{
            if($this->all == null){
                $id = $this->getId();
                $this->all = $this->select("*"," where id = ".$id);
            }
        }
        return $this->all['nom'];
    }

    function getEmail():String{
            #je verifie si l'utilisateur est connecté
            if($this->getId()==0){
                $this->all = ['nom'=>'user','email'=>'user@gmail.com'];
            }else{
                if($this->all == null){
                    $id = $this->getId();
                    $this->all = $this->select("*","where id = ".$id);
                }
            }
            return $this->all['email'];
    }
    function getData():Array{
        $pdo = $this->getPdo();
        $req=$pdo->query("SELECT nom , email , password as 'mot de passe',create_at as 'Crée le', activate_at as 'Activé le', active as 'Actif',ville,pays,age from users where id =  ".$this->getId());
        $res =  $req->fetch();
        if($res){
            return $res;
        }
        return ['nom'=>'user','email'=>'user@gmail.com','age'=>'?','tel'=>'?','sexe'=>'?','ville'=>'?','pays'=>'?','password'=>'?','active'=>'?'];
    }



}