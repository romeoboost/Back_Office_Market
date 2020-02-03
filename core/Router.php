<?php
    class Router{
        /**
         * fonction permettant de parser une url
         * @param url à parser
         * @return un tableau contenant les url
         * **/
                
        static function parse($url, $request)
        {
           $url = trim($url, '/'); //pour enlever les / en debut et/ou fin de ligne
           $params = explode('/', $url);
           if($params[0]){
               $request->controller = ( isset($params[0]) && !empty($params[0]) )  ? $params[0] : 'accueil' ; 
               $request->action = isset($params[1]) ? $params[1] : 'index';
               $request->params = array_slice($params, 2);
           }         
           //debug($request);
           return true;
          //print_r($r);
        }
    }