<?php

// $prix_produit = $produit->prix_quantite_unitaire - 
// ($produit->prix_quantite_unitaire*$produit->pourcentage_promo/100);

function productPrice($prix_quantite_unitaire, $pourcentage_promo){
  return $prix_quantite_unitaire - ($prix_quantite_unitaire*$pourcentage_promo/100);
}

/*
*$date au format YYYY-mm-dd H:i:s
*/
function dateFormat($date){
  $date_c = new DateTime($date);
  $dateFormated = $date_c->format('d-m-Y H:i');
  return $dateFormated;
}

function debug($var){
    
   $debug = debug_backtrace();   
   echo '<br/><p><a href="#" onclick="$(this).parent().next
       (\'ol\').slideToggle(); return false;"><strong>'.$debug[0]['file'].
           ' </strong></a>à la ligne : '.$debug[0]['line'].'</p>';
   echo '<ol"> ';
   foreach ($debug as $k => $v) {
       echo '<li><strong>'.$v['file'].' '.$v['line'].'</li></strong>';
   }
   echo '</ol>';
   echo '<pre>';
   print_r($var);
   echo '</pre>';
}
function accentdel($var){
		$var = str_replace(
			array(
				'à', 'â', 'ä', 'á', 'ã', 'å',
				'î', 'ï', 'ì', 'í', 
				'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
				'ù', 'û', 'ü', 'ú', 
				'é', 'è', 'ê', 'ë', 
				'ç', 'ÿ', 'ñ',
				'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
				'Î', 'Ï', 'Ì', 'Í', 
				'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø', 
				'Ù', 'Û', 'Ü', 'Ú', 
				'É', 'È', 'Ê', 'Ë', 
				'Ç', 'Ÿ', 'Ñ', 
			),
			array(
				'a', 'a', 'a', 'a', 'a', 'a', 
				'i', 'i', 'i', 'i', 
				'o', 'o', 'o', 'o', 'o', 'o', 
				'u', 'u', 'u', 'u', 
				'e', 'e', 'e', 'e', 
				'c', 'y', 'n', 
				'A', 'A', 'A', 'A', 'A', 'A', 
				'I', 'I', 'I', 'I', 
				'O', 'O', 'O', 'O', 'O', 'O', 
				'U', 'U', 'U', 'U', 
				'E', 'E', 'E', 'E', 
				'C', 'Y', 'N', 
			),$var);
		return $var;
	}

 // Fonction qui retourne l'âge
function age($naiss)  {
// Découper la date dans un tableau associatif
    list($annee, $mois, $jour) = explode('-', $naiss);
    // Récupérer la date actuelle dans des variables
    $today['mois'] = date('n');
    $today['jour'] = date('j');
    $today['annee'] = date('Y');
    // Calculer le nombre d'années entre l'année de naissance et l'année en cours
    $annees = $today['annee'] - $annee;
    // Si le mois en cours est inférieur au mois d'anniversaire, enlever un an
    if ($today['mois'] < $mois) {
        $annees--;
    }
    // Pareil si on est dans le bon mois mais que le jour n'est pas encore venu
    if ($mois == $today['mois'] && $jour> $today['jour']) {
        $annees--;
    }
    return $annees;

} 

function ancien($debut){
    $actuel = date("Y-m-d");
    $datetime1 = new DateTime($debut);
    $datetime2 = new DateTime($actuel);
    $interval = $datetime1->diff($datetime2);
    if($interval->invert != 0){
       return 0; 
    }else{
       $resultat = '';
       if($interval->y > 0){
           $resultat .= ($interval->y > 1) ? $interval->y.' ans ' : $interval->y.' an ';
       }
       //$resultat .= ($interval->y > 0) ? $interval->y.' an(s) ' : ' ';
       $resultat .= ($interval->m > 0) ? $interval->m.' mois ' : ' ';
       if($interval->d >= 1){
           $resultat .= ($interval->d > 1) ? $interval->d.' jours ' : $interval->d.' jour ';
       }  else {
           $resultat .= '';
       }
      // $resultat .= ($interval->d > 0) ? $interval->d.' jour(s) ' : ' ';
       return $resultat;
    }
   
}

function dateFormat_old($date){
    //$source = '2012-07-31';
    //$date = new DateTime($source);
    return implode('-', array_reverse(explode('-', $date)));
    //return $date; // 31-07-2012 
}
function rang($recup) {
      $rang = array();
      $r = 1;
      $mprev = 0;
      $rang[$recup[0]->id_eleve] = $r; 
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
      return $rang;      
}

function annrecal($recup) {
   $moy = array();
   $moy_classe = 0;
   foreach ($recup as $k){
      $moy[$k->id_eleve] = $k->moy_eleve;
    }
    $moy_classe = array_sum($moy) / count($moy);
    return $moy_classe;
}

function cycle($niveau){
    $firstCycle = array('6ème','5ème','4ème','3ème');
    if(in_array($niveau,$firstCycle)){
       return true; 
    }else{
       return false; 
    }
    
}

function upload($file) {
    $img = $file['name'];
       $img_tmp = $file['tmp_name'];
       $image = explode('.',$img);
       $image_ext = end($image);
       $error = '';
       if(in_array(strtolower($image_ext),array('png','jpeg','jpg'))=== false){
           $error = 'veuillez entrer une image valable';
           return false;
       }else{
           $image_size = getimagesize($img_tmp);
           if($image_size['mime'] === 'image/png'){
               $image_src = imagecreatefrompng($img_tmp);
           }elseif($image_size['mime'] === 'image/jpeg'){
               $image_src = imagecreatefromjpeg($img_tmp);
           }elseif($image_size['mime'] === 'image/jpg'){
               $image_src = imagecreatefromjpg($img_tmp);
           }else{
               $image_src = false;
               $error =  'veuillez entrer une image valide';
               return false;
           }
           if($image_src !== false){
               $image_width = 100;
               if($image_size[0] == $image_width){
                   $image_finale = $image_src;
               }else{
                   $new_width = $image_width;
                   $new_height = 100;
                   $image_finale= imagecreatetruecolor($new_width,$new_height);
                   imagecopyresampled($image_finale,$image_src,0,0,0,0,$new_width,$new_height,
                           $image_size[0],$image_size[1]);
               }
               //imagejpeg($image_finale,'C:\wamp\www\mareussite\webroot\photo\1.jpg');
               return $image_finale;
           }
       }
}

function orderMatiere($matiere){ //$matiere = array(objects)
    foreach ($matiere as $v) {
            if($v->genre === 'Littérature'){
               $d['keys'][$v->idm] = $v->idm; 
               $d['values'][$v->idm] = $v->matiere;
           }
        }
        foreach ($matiere as $v) {
            if($v->genre === 'Sciences'){
              $d['keys'][$v->idm] = $v->idm; 
              $d['values'][$v->idm] = $v->matiere;  
           }
        }
        foreach ($matiere as $v) {
            if($v->genre === 'Autre'){
               $d['keys'][$v->idm] = $v->idm; 
               $d['values'][$v->idm] = $v->matiere; 
           }
        }
        $matieres = array_combine($d['keys'], $d['values']);
    return $matieres;
}

function comparer($a, $b) {
  return strcmp(strtoupper($a->nom), strtoupper($b->nom));
}


function getStatus($statut){

        $statutPaiement[0]['titre']='Echec';
        $statutPaiement[0]['action']='Reprendre';
        $statutPaiement[0]['description']='Votre précédente transaction a éechoué. Veuillez cliquer sur le bouton pour la reprendre.';
        $statutPaiement[0]['couleur']='warning';//jaune
        $statutPaiement[0]['icon']='refresh';

        $statutPaiement[1]['titre']='Payé';
        $statutPaiement[1]['action']='';
        $statutPaiement[1]['description']='';
        $statutPaiement[1]['couleur']='success';//vert
        $statutPaiement[1]['icon']='';

        $statutPaiement[2]['titre']='Echec';
        $statutPaiement[2]['action']='Reprendre';
        $statutPaiement[2]['description']='Votre précédente transaction a échoué pour insuffisance de fond sur votre solde.
         veuillez cliquer sur le bouton pour la reprendre.';
        $statutPaiement[2]['couleur']='warning';//jaune
        $statutPaiement[2]['icon']='refresh';

        $statutPaiement[3]['titre']='Traitement En cours';
        $statutPaiement[3]['action']='Actualiser';
        $statutPaiement[3]['description']='Le traitement de votre transaction est en cours de traitement.';
        $statutPaiement[3]['couleur']='primary';//bleu repeat
        $statutPaiement[3]['icon']='repeat';
        
        $statutPaiement[5]['titre']='Echec';
        $statutPaiement[5]['action']='Reprendre';
        $statutPaiement[5]['description']='Votre précédente transaction n\'a pas abouti. Veuillez cliquer sur le bouton pour la reprendre.';
        $statutPaiement[5]['couleur']='warning';//jaune
        $statutPaiement[5]['icon']='refresh';
        
        $statutPaiement[10]['titre']='Innachevé';
        $statutPaiement[10]['action']='Reprendre';
        $statutPaiement[10]['description']='Votre précédente transaction n\'a pas abouti. veuillez cliquer sur le bouton pour la reprendre.';
        $statutPaiement[10]['couleur']='default';//gris
        $statutPaiement[10]['icon']='refresh';
        
        return $statutPaiement[$statut];

    }







function array_to_object($array){ //convertir un tableau (array) en objet (object)
      $obj= new stdClass();
      foreach ($array as $k=> $v) {
         if (is_array($v)){
            $v = convert_array_to_object($v);   
         }
         $obj->{strtolower($k)} = $v;
      }
      return $obj;
      
    }
