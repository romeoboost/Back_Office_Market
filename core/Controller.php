<?php
    class Controller
    {
        public $request;
        public $vars= array();
        private $rendered = false;
        
        public function __construct($request= NULL)
        {
            if($request)
            {
                $this->request = $request; 
            }
        }
        
        public function render($view)
        {
           if($this->rendered){
                              return false;}
           extract($this->vars);
           if (strpos($view, '/')===0){
               $view = ROOT.DS.'view'.$view.'.php';
           }
           else {
               $view = ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
           }
           //die($view);
           ob_start();
           require ($view);
           $contain_for_layout = ob_get_clean();
           //require ROOT.DS.'view'.DS.'layout'.DS.'default.php';
           if($this->request->controller == 'authentication'){
              require ROOT.DS.'view'.DS.'layout'.DS.'auth-default.php';
           }else{
              require ROOT.DS.'view'.DS.'layout'.DS.'default.php';
           } 
           $this->rendered = true;
        }
        
        public function set($key, $val=null)
        {
            if(is_array($key))
                {
                 $this->vars=$key;
            }
            else {
                  $this->vars[$key]=$val; 
            }
        }
        /*
         * une fonction qui permet de charger les models
         */
        public function loadmodel($name){
            $file = ROOT.DS.'model'.DS.$name.'.php';
            require_once $file;
            if(!isset($this->$name)){
                $this->$name = new $name;
            }  else {
                echo ' je suis deja chargé ';
            }  
        }
         /*
          * fonction permettant de charger les erreurs
          */ 
         public function e404($message) {
            header("HTTP/1.0 404 not found");
             $this->set('message', $message);
            $this->render('/errors/404');
            die();
         }
         
         /*
          * permet d'appeler les controller depuis une vue
          */
         public function request($controller, $action, $param = null) {
            $controller .= 'Controller'; 
            require_once ROOT.DS.'controller'.DS.$controller.'.php';
            $c = new $controller();
            if(isset($param)){
              return $c->$action($param);  
            }else{
              return $c->$action(); 
            }           
         }
    }
