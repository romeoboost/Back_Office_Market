<?php
class AccueilController extends Controller {
    
    public function index(){
      conf::redir();
      $this->loadmodel('Accueil');
      $_SESSION['bo_menu'] = 'Accueil';

    }  

    public function deconnect(){
        if(isset($_SESSION['bo_user'])){ 
          unset($_SESSION['bo_user']); 
        }
        header('Location: '.BASE_URL.'/authentication/login');
    }
    
}
