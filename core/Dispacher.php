<?php
    class Dispacher{
        
        var $request;
        function __construct()
        {
           $this->request = NEW Request();
           Router::parse($this->request->url, $this->request);
           $controller = $this->loadcontroller();
           //print_r($controller);
           //die();
           if(!in_array($this->request->action, array_diff(get_class_methods($controller), 
                   get_class_methods('controller')))){
               $this->error(' le controlleur '.$this->request->controller.' n\'a pas de methode 
                   du nom de '.$this->request->action);
           }
           call_user_func_array(array($controller, $this->request->action), $this->request->params);
           $controller->render($this->request->action); 
        }
        
        function error($message) 
        {
            $maincontroll = NEW Controller($this->request);
            $maincontroll->e404($message);
           // echo $message;            
           // die();
        }
        function loadcontroller()
        {
           $name = ucfirst($this->request->controller).'Controller';
           $file = ROOT.DS.'controller'.DS.$name.'.php';
           require $file;
           return NEW $name($this->request); 
        }
    }