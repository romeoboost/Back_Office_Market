<?php
$pdo = new PDO('mysql:dbname=ecole;host=localhost', 'root', '',
                             array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
extract($_POST);

if($table === 'eleves'){
    $sql2 = 'SELECT * FROM '.$table.' WHERE id = '.$id;
    $req1 = $pdo->query('SELECT * FROM '.$table.' WHERE id = '.$id);
    $eleve = $req1->fetchAll(PDO::FETCH_OBJ);
    $req2 = $pdo->query('SELECT * FROM classes WHERE id = '.$id_classe);
    $info = $req2->fetchAll(PDO::FETCH_OBJ);
    $elv_sex = $eleve[0]->sexe;
    $eff = $info[0]->nbre_eleve;
    $boy = $info[0]->nbre_boys;
    $girl = $info[0]->nbre_girls;
    if($elv_sex == 'M'){ //update les effectifs
         $boy = $boy - 1; 
      }else{
         $girl = $girl - 1; 
      }
      $eff = $eff - 1;
    $req3 = $pdo->prepare('UPDATE classes SET nbre_eleve=?, nbre_girls=?, nbre_boys=? WHERE id ='.$id_classe);
    $req3->execute(array($eff,$girl,$boy));

}

$sql = 'DELETE FROM '.$table.' WHERE id=:id ';
$req = $pdo->prepare($sql);
$req->execute(array(':id' => $id));

if($table === 'eleves'){
   /*
   * gestion des numeros de liste de classe
   */ 
   $req2 = $pdo->query('SELECT id,nom,prenoms FROM eleves WHERE id_classe ='.$id_classe);
   $objets = $req2->fetchAll(PDO::FETCH_OBJ);
    foreach($objets as $o => $ov){
          $objets[$o]->nom = $ov->nom.' '.$ov->prenoms; 	
    }
  function comparer($a, $b) {
        return strcmp(strtoupper($a->nom), strtoupper($b->nom));
   }
   
  usort($objets, 'comparer');
  $n = 1;
  foreach($objets as $ov){
      $req3 = $pdo->prepare('UPDATE eleves SET numero=? WHERE id ='.$ov->id);
      $req3->execute(array($n));
      $n = $n + 1;
    }
}



