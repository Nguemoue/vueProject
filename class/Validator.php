<?php

class Validator{
   private  $errors = [];
   private  int $max_size = 2;

   function __construct(){

   }

    function validateAge($age){
        $age = (int) $age;
        if($age < 0 or $age > 100){
            $this->addError("l'age est incorect");
        }
    }

    function validateImg($img){
        $taille = (int) $img["size"];
        $max_size = 4;
        if($taille > pow(10,6)*$this->max_size){
            $this->addError("La taille de votre photo ne doit pas depasse {$this->getMaxSize()} méga");
        }
        if($img['error']!=0){
            $this->addError("Erreur rencontré sur la photo de profil");
        }
    }
    function setMaxSize(int $size){
      $this->max_size = $size;
    }
    function  getMaxSize():int{
      return $this->max_size;
    }

    function validateVideo($video){
        $taille = (int) $video["size"];
        $max_size = pow(10,6)*100;
        if($taille > $max_size){
            $this->addError("La taille de la video ne doit pas depasse 100 méga");
        }
        if($video['error']!=0){
            $this->addError("Erreur rencontré sur la video ");
        }
    }

    function validateEmail($email){
        if(empty($email) or !filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $this->addError("Adresse mail invalide");
        }
    }
    function validateNom($nom){
        if(empty($nom)){
            $this->addError('Le Champ Nom ne doit pas être vide');
        }else if(strlen($nom)>=100){
            $this->addError('La longeur de Votre Nom ne doit pas dépasse 100 caractères');
        }
    }
    function validateVille($ville){
        if(empty($ville)){
            $this->addError('Le ville ou le pays ne doit pas être vide');
        }else if(strlen($ville)>=100){
            $this->addError('La longeur de la ville ou du pays pas dépasse 100 caractères');
        }
    }

    function validateTel($tel){
        $tel = (int) $tel;
        if(!preg_match('/^([0-9]){5,20}$/',$tel)){
            $this->addError('Votre Numero de télephone doit être entre 5 et 20 caractères');
        }
    }

    function getErrors(){
        return $this->errors;
    }

   function validatePassword($p,$cp){
        if(empty($p) or empty($cp)){
            $this->addError('Les Champ mot de passe ne doivent pas être vide');
        }
        if(strlen($p)>=20 or strlen($cp)>=20 ){
             $this->addError('Mots de passe trop long (20 caractères min)');
        }
        if($p!==$cp){
            $this->addError("Les mot de passe doivent correspondre");
        }
    }

    function addError($err){
        array_push($this->errors,$err);
    }

    function hasError(){
        return !empty($this->errors);
    }


}


