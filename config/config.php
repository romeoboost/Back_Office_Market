<?php
    class conf{
        
        static $debug = 1;
        static $database = array(
            'default' => array(
              'dbname' => 'cisse_soft',
              'hostname' => 'localhost',
              'login' => 'root',
              'passwd' => ''  
            )
        );
        
        static function redir(){
            if(!isset($_SESSION['bo_user'])){
                header('Location: '.BASE_URL.DS.'authentication/login');            
            }       
        }   
    }   
   
?>
