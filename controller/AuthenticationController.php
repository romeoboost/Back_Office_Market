<?php
class AuthenticationController extends Controller {
    
    public function login(){
      $this->loadmodel('Accueil');

      
    }  

    public function index_old(){
        $this->loadmodel('Accueil');
        $d['annee'] = current($this->Accueil->find(array(
           'condition' => array('statut' => 1)
        ),'annee'));
        $_SESSION['annee'] = $d['annee']->annee;
       if($d['annee']->validate == 0){
          header('Location: '.BASE_URL.'/verrou/authentification'); 
       }
        $d['error'] = '';        
        if(isset($_POST['submit'])){
          if($_POST['login'] && $_POST['pwd']){
              
              $check = current($this->Accueil->find(array(
                  'condition' => array('login' => $_POST['login'])
              ),'users'));
              if(empty($check)){
                 $d['error'] = 'Login ou mot de passe incorrect,<br/> réessayez avec les acces corrects'; 
                 $_SESSION['flash']['danger'] = '<strong>ERROR!!<strong> Login ou mot de passe incorrect, réessayez avec les accès corrects';
              }else{
                  if($check->passwd === $_POST['pwd']){                      
                      $_SESSION['username'] = $check->login; 
                      $_SESSION['userprofil'] = $check->profil;
                      $_SESSION['id_prof'] = $check->id_prof;
                      $_SESSION['id_user'] = $check->id;
                      if($check->profil === 'admin'){   
                          $_SESSION['flash']['success'] = "Vous êtes à présent connecté";
                           header('Location: '.BASE_URL.'/adminClasse/index'); // a ameliorer avec $check[0]->profil
                           exit;
                      }elseif($check->profil === 'utilisateur'){
                           header('Location: '.BASE_URL.'/utilisateur/classe/index');
                      }elseif($check->profil === 'professeur') {
                           header('Location: '.BASE_URL.'/classe/index');
                      }
                  }else{
                    $d['error'] = 'Login ou mot de passe incorrect,<br/> réssayez avec les acces corrects';  
                    $_SESSION['flash']['danger'] = '<strong>ERROR!!<strong> Login ou mot de passe incorrect, réssayez avec les accès corrects';
                  }
              }
          }else{
              $d['error'] = 'Veuillez remplir tous les champs,<br/> s\'il vous plait';
              $_SESSION['flash']['danger'] = '<strong>ERROR!!<strong> Veuillez remplir tous les champs s\'il vous plait';
          }  
        }
       //debug($d);
        $this->set($d);
        
    }
    
    public function deconnect(){
        if(isset($_SESSION['user'])){ 
          unset($_SESSION['user']); 
        }
        header('Location: '.BASE_URL.'/accueil/index');
    }

    public function getCategoryProduit(){
      $this->loadmodel('Accueil');
      $result = $this->Accueil->find(array(
          'condition' => array('statut' => 1)
        ),'categories_produits');
            
      return $result;
    }
    
    public function getInfo(){
        $this->loadmodel('Choice');
        $d['ecole'] = current($this->Choice->find(array(
               'condition' => array('id' => 1),
               'fields' => 'nom_ecole'
        ),'info'));
        $d['annee'] = current($this->Choice->find(array(
           'condition' => array('statut' => 1),
           'fields' => 'annee'
        ),'annee')); 
        return $d;
    }
    
//    public function getAnnee(){
//        $this->loadmodel('Choice');
//        $d['ecole'] = current($this->Choice->find(array(
//               'condition' => array('id' => 1),
//               'fields' => 'nom_ecole'
//        ),'info'));
//        $d['annee'] = current($this->Choice->find(array(
//           'condition' => array('statut' => 1),
//           'fields' => 'annee'
//        ),'annee')); 
//        return $d;
//    }
    
    
}
