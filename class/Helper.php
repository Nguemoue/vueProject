<?php
    class Helper{
        public static function previousPage(){
            if(isset($_SERVER['HTTP_REFERER']) and !isset($_GET['id'])){
                $res = $_SERVER['HTTP_REFERER'];
                $res = explode("/",$res);
                $res = end($res);
                return ''.$res;
            }else{
                return 'index.php';
            }
        }

    }
