<?php
    if(!isset($_SESSION)) session_start();
    #je demare ma session
    foreach ($_SESSION as $key => $value){
        if($value != 'started'){
            unset($_SESSION[$key]);
        }
    }
    header("Location:index.php");

 ?>