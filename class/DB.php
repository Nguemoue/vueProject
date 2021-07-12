<?php
     class DB{
        private $pdo;
        function __construct($dsn="mysql:host=localhost;dbname=light",$user="root",$password=""){
            if($this->pdo==null){
                try{
                $this->pdo = new PDO($dsn,$user,$password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            }catch (PDOException $e){
                die("Erreur : ".$e->getMessage());
            }
        }
            return $this->pdo;
        }

        /**
         * function find : recherche un utilisateur suivant l'id
         * @param id : int
         * @return array
         * */
        function findById($id){
            $res = [];
            $id = (int) $id;
            $prep = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $prep->execute([$id]);
            $res = $prep->fetch();
            if($res){
                return $res;
            }
            return [];
        }
        function findByEmail($email){
            $res = [];
            $prep = $this->pdo->prepare("SELECT * FROM users WHERE email LIKE ?");
            $prep->execute([$email]);
            $res = $prep->fetch();
            if($res){
                return $res;
            }
            return [];
        }
        function findByEmailAndPassword($mail,$p ){
            $res = [];
            $prep = $this->pdo->prepare("SELECT * FROM users WHERE email LIKE ? and password LIKE ?");
            $prep->execute([$mail,$p]);
            $res = $prep->fetch();
            if($res){
                return $res;
            }
            return [];
        }
        function findLimitByEmail($email){
            $res = [];
            $prep = $this->pdo->prepare("SELECT nom,email,age,tel,sexe,ville,pays,password as 'Mot de passe' , create_at as 'Date de creation' , activate_at as 'Date D activation' FROM users WHERE email LIKE ?");
            $prep->execute([$email]);
            $res = $prep->fetch();
            if($res){
                return $res;
            }
            return [];
        }
        function findAll(){
            $res = [];
            $prep = $this->pdo->prepare("SELECT * FROM users");
            $prep->execute();
            $res = $prep->fetchAll();
            return $res;
        }
        function addUser($nom,$email,$tel,$age,$password,$pays,$ville,$sexe){
            $i = $this->pdo->prepare("INSERT INTO users set nom = :nom,email=:email,tel=:tel,age=:age,password=:password,ville=:ville,sexe=:sexe,pays=:pays , create_at = NOW(),token=:token,active=0");
            $i->execute(['nom'=>$nom,'email'=>$email,'tel'=>$tel,'age'=>(int)$age,'password'=>$password,'ville'=>$ville,'sexe'=>$sexe,'pays'=>$pays,'token'=>$this->generateKey()]);
        }
        static function generateKey(){
            return substr( str_shuffle(uniqid('L')),0,4);
        }
        function getPdo(){
            return $this->pdo;
        }
        function getIdByEmail($email){
            $res = $this->pdo->query("select id from users where email = '$email'");
            $data = $res->fetch();
            if($data){
            $f =  (int) $data["id"];
                return $f;
            }
            return 0;
        }
        function updateToken($token,$email){
            try{
                $res = $this->pdo->prepare("UPDATE users set token = ? WHERE email = ? ");
            }catch (PDOException $e){
                die("Erreur : ".$e->getMessage());
            }
            $res->execute([$token,$email]);
        }
        function getToken($email){
            $res = $this->pdo->query("SELECT token from users where email = '$email' ");
            $res = $res->fetch();
            return $res["token"];
        }
        function activeAccount($email){
            $res = $this->pdo->exec("UPDATE users set active = 1 , token = null, activate_at = NOW() WHERE email = '$email' ");

           ;
        }
        #cette fonction donne le nom+l'extension du profile de l'utilisateur suivant l'id
        function getProfil($id){
            $id = (int) $id;
            $res = $this->pdo->query("SELECT nom,extension FROM profil where id_user = '$id' ");
            $res = $res->fetch();
            if($res){
                return "img/profil/".$res["nom"].".".$res["extension"];
            }
            return "";
        }

        function getNomByEmail($email){
            $res = $this->pdo->query("SELECT nom FROM users where email = '$email' ");
            $res = $res->fetch();
            return $res['nom'];
        }
        function getUpdateField($email){
            $res = $this->pdo->query("SELECT nom , password , tel , ville , pays  FROM users where email = '$email' ");
            $res = $res->fetch();
            return $res;
        }
        function insertDaily($nom,$titre,$path,$extension,$description,$id_post){
            $id_post = (int) $id_post;
            $prep = $this->pdo->prepare("INSERT INTO dailybreads set nom = '$nom' , titre = '$titre', path = '$path' , create_at = NOW(),extension = '$extension',description =
                '$description' , id_post = $id_post");
            $f = $prep->execute();
            if(!$f){
                die("erreur :<a href='index.php'>retour</a> ".$this->pdo->errorInfo());
            }

        }
        function createPath($file_name){
            return $file_name.date('Y_m_d_H_i_s');
        }
        function getDailyBreads(){
            $res = $this->pdo->query("SELECT * FROM dailybreads");
            $res = $res->fetchAll();
            return $res;
        }
        function insertImg($path,$extension,$id_post){
            $id_post = (int) $id_post;
            $res = $this->pdo->prepare("INSERT INTO image set create_at = NOW() , path = ? , extension = ? , id_post = ?");
            $f = $res->execute([$path,$extension,$id_post]);
            return $f;
        }
        function insertVideo($cat,$nom,$titre,$path,$extension,$id_admin,$id_img,$description){
            $req_prep = $this->pdo->prepare("INSERT INTO videos set categorie = :cat,nom = :nom,titre=:titre,extension = :ext,id_admin = :id_admin,create_at = NOW(), path = :path,id_img = :id_img ,description = :descr");
            $f = $req_prep->execute(['cat'=>$cat,'nom'=>$nom,'titre'=>$titre,'ext'=>$extension,'id_admin'=>$id_admin,'path'=>$path,'id_img'=>$id_img,'descr'=>$description]);
            if(!$f){
                die("Erreur : ".$this->pdo->errorInfo());
            }
        }
        function getIdImageByUser(){
            $req = $this->pdo->query("SELECT id from image where id_post = ".User::getId()." order by create_at desc limit 1");
            $req = $req->fetch();
            $req = $req['id'];
            if($req){
                $res = (int) $req;
            }else{
                die("Erreur  : l'image de la video n'as pas été enregistrez");
            }
            return $res;
        }
        function getImagePath($id){
            $req = $this->pdo->query("SELECT path , extension from image where id = ".$id);
            $res = $req->fetch();
            if($res){
                return $res['path'].".".$res['extension'];
            }else{
                die("Erreur : l'id de l'image n'existe pas dans la bd");
            }

        }
        function getVideoPath($id){
            $id = (int)$id;
            try {
                $req = $this->pdo->prepare("SELECT path , extension from videos where id =  ?");
                $res = $req->execute([$id]);
                if($res)
                    $res = $req->fetch();
                return $res['path'].'.'.$res['extension'];
            } catch (PDOException $e) {
                die("Erreur : ".$e->getMessage());
            }

        }
        function getAllTeatchings(){
            // les categories sont : Teatching Encounter Prayer Line
            try{
                $req = $this->pdo->prepare("SELECT * FROM videos where categorie = ? and path is not null and id_img is not null");
                $res = $req->execute(['Teatching']);
                $res = $req->fetchAll();
            }catch (PDOException $e){
                die('Erreur : '.$e->getMessage());
            }
            return $res;
        }





    }
