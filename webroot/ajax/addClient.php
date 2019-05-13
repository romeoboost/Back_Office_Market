<?php
include 'connectDB.php';
include 'fonction.php';
 
 if(!isset($_POST['id_hotel'])){
    //mettre header adequat ici pour faire l'action dans false 
    echo 'badForm|Votre requete ne peut aboutir'; 
 }else{
     extract($_POST);
     $numero_piece = strtoupper($numero_piece);
     $date_arrivee = formatdatetime($date_arrivee); //formatage des dates
     $date_depart = formatdatetime($date_depart); //formatage des dates
     $duree = getDuree($date_arrivee, $date_depart); // calcul de la duree
//     echo '<br/> date_arrivee : '.$date_arrivee.' date_depart: '.$date_depart.' durée: '.$duree.'<br/>';
     if($duree == false){
        //mettre header adequat ici pour faire l'action dans false 
        echo 'badDate|la date de depart doit etre plus récente que la date d\'arrivée'; 
     }else{
            // verifie si l'individu n'est pas dans la liste des clients
         $date_validite = formatdate($date_validite); 
         $req = $pdo->prepare('SELECT id FROM clients WHERE numero_piece = :numero_piece'); 
         $req->execute(array(':numero_piece' => $numero_piece));
         $individu = current($req->fetchAll(PDO::FETCH_OBJ));
         if(empty($individu)){ // si l'individividu n'existe pas en base
             $req = $pdo->prepare('INSERT INTO clients (nom, prenoms, sexe, type_piece, numero_piece, date_validite)
                          VALUES(:nom, :prenoms, :sexe, :type_piece, :numero_piece, :date_validite)');
             $req->execute(array(
                  'nom' => $nom,
                  'prenoms' => $prenom,
                  'sexe' => $sexe,                  
                  'type_piece' => $type_piece,
                  'numero_piece' => $numero_piece,
                  'date_validite' => $date_validite 
             ));
             $req = $pdo->prepare('SELECT id FROM clients WHERE numero_piece = :numero_piece'); 
             $req->execute(array(':numero_piece' => $numero_piece));
             $individu = current($req->fetchAll(PDO::FETCH_OBJ));
         }
         
         $req = $pdo->prepare('INSERT INTO hotels_clients (id_hotel, id_client, type_chambre, type_client, date_arrivee, date_depart, duree)
                          VALUES(:id_hotel, :id_client, :type_chambre, :type_client, :date_arrivee, :date_depart, :duree)');
         $req->execute(array(
              'id_hotel' => $id_hotel,
              'id_client' => $individu->id,
              'type_chambre' => $type_chambre,                  
              'type_client' => $type_client,
              'date_arrivee' => $date_arrivee,
              'date_depart' => $date_depart,
              'duree' => $duree,
         )); 
     }
     
     
  }
 //         echo 'OK';    
//echo ' <pre>';print_r($_POST);echo '</pre>';
//echo ' <pre>';print_r($matiere);echo '</pre>';
// CL20180300033
  // structure numero de membre
  // AIESAEA AAAA MM NUMERO




