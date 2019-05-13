<?php
$pdo = new PDO('mysql:dbname=ecole;host=localhost', 'root', '',
                             array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
 extract($_POST);
 $nommat = array();
 $i = 0;
 $notExist = '';
 $matiere = array();
     if(!empty($myCheckboxes)){
         //recupere les moyennes pour chaque trimestre selectionné
   $req = $pdo->prepare('SELECT * FROM moyennes_trim WHERE id_matiere = :matiere AND trim = :myTrim AND id_classe = :classe');
        foreach ($myCheckboxes as $k ){
           $req->execute(array(':matiere' => $mat,
                ':myTrim' => $k,
               ':classe' => $classe));
           $matiere[$k] = $req->fetchAll(PDO::FETCH_OBJ); 
           if(empty($matiere[$k])){ // verifie si les moyennes  ont été calculées pour tous les trimestres choisies
             $null[$k] = false;  
           }
        }
        $req = $pdo->query('SELECT id,titre FROM matieres WHERE id = '.$mat);
        $titre = $req->fetchAll(PDO::FETCH_OBJ); // recupere le nom de la matiere
        if(isset($null)){ //renvoie une erreur si les les moyyennes n'ont pat été calculées pour les trim choisies
         $notExist .= ' Les moyennes en '.$titre[0]->titre.' pour le :';   
            foreach ($null as $n => $f){
                if($n == 1){
                   $notExist .= '<br/> - Premier Trimestre';
                }elseif($n == 2){
                   $notExist .= '<br/> - Deuxième Trimestre';
                }elseif($n == 3){
                   $notExist .= '<br/> - Troisième Trimestre'; 
                }
            }
        $notExist .= '<br/> n\'ont pas encore été calculées veuillez d\'abord les 
            calculer ou ne pas la/les prendre en compte les décochant ';
        echo $notExist;
        }
        else{ //au cas ou les moyennes ont été calculé pour les trim choisies
          //$div = taille array  
          $req = $pdo->prepare('SELECT id FROM eleves WHERE id_classe = :classe');
          $req->execute(array(':classe' => $classe));
          $eleves = $req->fetchAll(PDO::FETCH_OBJ); // recupere les id de tt les eleves de la classe
          foreach ($eleves as $id) {
            $som[$id->id] = 0;
            foreach ($matiere as $sm) { // $matiere contient les moyennes pour tt les eleves pour les trim choisies 
                foreach ($sm as $m) {
                   if($id->id == $m->id_eleve){
                      $som[$id->id] += $m->moy_eleve*$m->coef_trim;  
                   } 
                }                
            }
          }
          $req = $pdo->prepare('SELECT DISTINCT coef_trim FROM moyennes_trim WHERE id_classe = :classe');
          $req->execute(array(':classe' => $classe));
          $div = $req->fetchAll(PDO::FETCH_OBJ);
          foreach($matiere as $m){ // calcule le dividande = somme des coeff pour chak trim
            $i += $m[0]->coef_trim;
          }
          foreach ($som as $k => $v) {
//           $moy[$k] = $v/$i; 
            $moy[$k] = round($v/$i, 2);
          }
          $req = $pdo->prepare('SELECT annee FROM annee WHERE statut = :stat'); 
          $req->execute(array(':stat' => 1));
          $year = $req->fetchAll(PDO::FETCH_OBJ); //recuperation de l'annee en cours
          
          $moy_classe = array_sum($moy) / count($moy); //calcul de moyenne annuelle de la classe
          $moy_classe = round($moy_classe, 2);
          
          $req = $pdo->prepare('INSERT INTO moyennes_ann (id_eleve, id_classe, id_matiere, moy_eleve, moy_classe, annee)
                  VALUES(:id_eleve, :id_classe, :id_matiere, :moy, :moy_classe, :annee)');
          foreach ($moy as $id => $m){
              $req->execute(array(
                  'id_eleve' => $id,
                  'id_classe' => $classe,
                  'id_matiere' => $mat,                  
                  'moy' => $m,
                  'moy_classe' => $moy_classe,
                  'annee' => $year[0]->annee,
                ));
          }
          /**
           * attribution de rang
           */
       $rang = array();
       $r = 1;
       $mprev = 0; // moyenne precedente
      $req = $pdo->prepare('SELECT id,id_eleve,moy_eleve FROM moyennes_ann WHERE id_matiere = :matiere AND id_classe = :classe AND annee = :an 
          ORDER BY moy_eleve DESC');
        $req->execute(array(
            ':matiere' => $mat,
            ':classe' => $classe,
            ':an' => $year[0]->annee,));
        $recup = $req->fetchAll(PDO::FETCH_OBJ);
        $rang [$recup[0]->id_eleve] = $r; 
        $rprev = $rang [$recup[0]->id_eleve];
        $mprev = $recup[0]->moy_eleve;
        foreach ($recup as $k => $v){
            if($k != 0){
                $r += 1;
                if($v->moy_eleve == $mprev){
                   $rang [$v->id_eleve] = $rprev;
                }elseif($v->moy_eleve < $mprev){
                  $rang [$v->id_eleve] = $r;  
                }
                $mprev = $v->moy_eleve;
                $rprev = $rang [$v->id_eleve];
            }
        }
        
          foreach ($rang as $id => $ra){
   $req = $pdo->query('UPDATE moyennes_ann SET rang = '.$ra.' WHERE id_eleve ='.$id.
           ' AND id_classe ='.$classe.' AND id_matiere='.$mat); 
          }
          
          
          echo 'ok';
//          echo ' <pre>';print_r($recup);echo '</pre>';
//          echo ' <pre>';print_r($rang);echo '</pre>';
          
        }
        
     }else{
       echo 'Choisissez les trimestres à prendre en compte';        
     }
     
     
//echo ' <pre>';print_r($null);echo '</pre>';
//echo ' <pre>';print_r($matiere);echo '</pre>';




