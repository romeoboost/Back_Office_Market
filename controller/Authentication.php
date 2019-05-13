<?php
class AuthenticationController extends Controller {
    
    public function login(){
      $this->loadmodel('Accueil');      
    }  

   
    public function deconnexion(){
        if(isset($_SESSION['bo_user'])){ 
          unset($_SESSION['bo_user']);
        }
        debug($_SESSION);
        header('Location: '.BASE_URL.'/authentication/login');
    }
  
    
}
