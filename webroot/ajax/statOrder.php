<?php
include 'connectDB.php';
include 'fonction.php';
// if (empty(session_id())) {
//     session_start();
//     $_SESSION['menu'] = 'Marche';
// }
setlocale(LC_TIME, "fr_FR", "French");
$error_statut = false;
$error_text = '';
$error_html = '';
$retour = array();

$conditions_prepare=array();

//sleep(5);

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = 'Une erreur s\'est produite veuillez reessayer plus tard.' ;
  $field_error ='none';
}else{
    extract($_POST);
  if( !isset( $period ) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Une erreur s\'est produite, veuillez reessayer plus tard sans modifier le Document HTML.';
    $field_error ='none';
    //debugger($_POST);
  }else{
    $period = empty( $period ) ? 'month' : trim($period);
    $result['days_list'][0] = 0;
    $result['count_list'][0] = 0;
    $result['amount_list'][0] = 0;
    $days_number_list = 6;
    $days_number_list_sql = $days_number_list + 1;

    //faire une boucle sur la liste des 30 jours tableau php (A)
    for($i=$days_number_list ; $i >= 0; $i--){
      $result['days_list'][] = date( 'Y-m-d', strtotime('today - '.$i.' day') );
      $result['count_list'][] = 0; //mettre la valeur de son cummul par defaut 0, cummul de jour (A) == 0
      $result['amount_list'][] = 0; //mettre la valeur de son cummul par defaut 0, cummul de jour (A) == 0
    }

    //recupérer la liste des cummuls pour les 30 derniers jours en base
    $sql_syntaxe =" SELECT SUM(montant_ht) as montant, count(montant_total) as nbre, DATE(date_creation) as date_stat 
                    FROM commandes 
                    WHERE DATE_SUB(CURDATE(),INTERVAL $days_number_list_sql DAY) <= date_creation
                    GROUP BY date_stat
                    ORDER BY date_stat ASC ";
    $req = $pdo->prepare($sql_syntaxe); 
    $req->execute();
    $stat_cmd_from_bd = $req->fetchAll(PDO::FETCH_OBJ);

    //faire une boucle la liste des des cummuls pour les 30 derniers jours recupérés en base (B)
    foreach ($stat_cmd_from_bd as $stat) {
      
      foreach ($result['days_list'] as $k => $dl) {
        if( $stat->date_stat == $dl ){ //si jour (A) == jour (B)
          $result['count_list'][$k] = (int)$stat->nbre; // cummul de jour (A) == cummul jour (B)
          $result['amount_list'][$k] = (int)$stat->montant; // cummul de jour (A) == cummul jour (B)
        }
        // $result['days_list'][$k] = date( 'd-M', strtotime( $dl ) );
      }

    }
    foreach ($result['days_list'] as $k => $dl) {
        if( $k != 0 ){
          $result['days_list_formated'][$k] = strftime( '%d-%b', strtotime( $dl ) );
        }else{
          $result['days_list_formated'][$k] = 0;
        }
        
      }

  }
}


$retour['result']=$result;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible text-align-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;

//echo 'OK';    
//echo ' <pre>'.print_r($_POST).'</pre>';
//echo ' <pre>';print_r($matiere);echo '</pre>';







