<?php
    class Request{ //receuillir les url saisi par le user
        
        public $url;
        public $page = 1;
        public $prefix = false;
        function __construct(){
            $this->url = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO'] : '/';            
            if(isset($_GET['page'])){
                if(is_numeric($_GET['page'])){
                    if($_GET['page'] > 0){
                    $this->page = $_GET['page'];                         
                    }
                }
            }
        }
    }