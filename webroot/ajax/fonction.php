<?php

function debugger($var, $second_var=null){
  print_r($var);
  print_r(' '.$second_var);
  die();
  return true;
}

function formatdate($date){
    return implode('-', array_reverse(explode('-', $date)));
}

function formatdatetime($datetime){
   $cup = explode(' ', $datetime);
   $date = $cup[0];
   $time = $cup[1];
   $daterev = implode('-', array_reverse(explode('-', $date)));
   $result = $daterev.' '.$time;
   return $result;
}

function getDuree($date_arrivee, $date_depart){
//    $date1 = formatdatetime($date_arrivee);
//    $date2 = formatdatetime($date_depart);
    $datetime1 = new DateTime($date_arrivee);
    $datetime2 = new DateTime($date_depart);
    $interval = $datetime1->diff($datetime2);
    if($interval->invert != 0){
       return false; 
    }else{
       $resultat = '';
       $resultat .= ($interval->y > 0) ? $interval->y.' Ans ' : ' ';
       $resultat .= ($interval->m > 0) ? $interval->m.' Mois ' : ' ';
       $resultat .= ($interval->d > 0) ? $interval->d.' jour(s) ' : ' ';
       $resultat .= ($interval->h > 0) ? $interval->h.' Heure(s) ' : ' ';
       $resultat .= ($interval->i > 0) ? $interval->i.' Min' : ' ';
       return $resultat;
    }
      
}

function getMemberNumber($Nbre_Mbre_Actuel, $Abreviation_Pays){

        $Identifiant = 'CLI'; //

        $Date_Identifiant = date("Ym"); //
        $Identifiant .= "".$Date_Identifiant;        
        $Numero_Mbre = "".($Nbre_Mbre_Actuel + 1);
        //echo '<pre>';print_r($Identifiant);echo '</pre>';
        $Taille_Fixe = 4;
        $Numero_Mbre_Good = str_pad($Numero_Mbre, $Taille_Fixe, "0", STR_PAD_LEFT);
        $Identifiant .= $Numero_Mbre_Good;

        //$Abreviation_Pays = 'CI'; // A automatiser
        $Identifiant .= $Abreviation_Pays;

        return $Identifiant;
}

function getCmdeNumber($Nbre_Mbre_Actuel, $Abreviation_Pays){

        $Identifiant = 'CMD'; //

        $Date_Identifiant = date("Ym"); //
        $Identifiant .= "".$Date_Identifiant;        
        $Numero_Mbre = "".($Nbre_Mbre_Actuel + 1);
        //echo '<pre>';print_r($Identifiant);echo '</pre>';
        $Taille_Fixe = 4;
        $Numero_Mbre_Good = str_pad($Numero_Mbre, $Taille_Fixe, "0", STR_PAD_LEFT);
        $Identifiant .= $Numero_Mbre_Good;

        //$Abreviation_Pays = 'CI'; // A automatiser
        $Identifiant .= $Abreviation_Pays;

        return $Identifiant;
}

function getPaymentParams($name, $service_token){

  $result = array();
  $time = time();
  $base_order = "AIESAEAPMT";
  $order=$base_order.$time;

  $curl = curl_init('http://crossroadtest.net:6968/service/auth');
    curl_setopt($curl, CURLOPT_POSTFIELDS, '{
        "auth": {
        "name": "'.$name.'",
        "authentication_token": "'.$service_token.'",
        "order": "'.$order.'"
        }
      }');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    
    try {
      $reponse_in_json = curl_exec($curl);
      curl_close($curl);
      $response = json_decode($reponse_in_json, true);
    } catch (Exception $e) {
        //echo 'Exception reçue : ',  $e->getMessage(), "\n";
        $reponse_in_json = ''.$e->getMessage();
    }

    //$jwt = $response['auth_token'];
  if(isset($response['auth_token'])){
    $result['gtw_payment_available']  = 'oui';
    $result['order']  = $order;
    $result['jwt']  = $response['auth_token'];
    $result['response_error']  = " ";
  }else{
    $result['gtw_payment_available']  = 'non';
    $result['order']  = $order;
    $result['response_error']  = "".$reponse_in_json;
    $result['jwt']  = '';
  }
  
  return $result;
}


function getHtmlPaymentBody($operation_token, $jwt, $order){
  $html_body = '<div class="modal-header-pay" style="padding:8px 22px;">';
    $html_body .= '<h5><span class="glyphicon glyphicon-check"></span> Veuillez payer les frais d\'inscription pour terminer
               la création de votre compte membre.</h5>';
  $html_body .= '</div>';

  $html_body .= '<div class="modal-body" style="padding:40px 50px;">';
    $html_body .= '<div class="modal-body-amount" style="">';
      $html_body .= '<h6>Montant</h6><h4> 6 500 F CFA </h4>';
    $html_body .= '</div>';
  $html_body .= '</div>';

  $html_body .= '<div class="modal-footer">';
    $html_body .= '<form role="" action="http://crossroadtest.net:6968/order" method="POST">';
      $html_body .= '<input name="operation_token" hidden value="'.$operation_token.'" type="text"/>';
      $html_body .= '<input name="order" hidden placeholder="montant" value="'.$order.'" type="text" />';
      $html_body .= '<input name="jwt" hidden value="'.$jwt.'" type="text" />';
      $html_body .= '<input name="currency" hidden value="XOF" type="text" />';
      $html_body .= '<input name="transaction_amount" hidden placeholder="montant" value="6500" type="text" />';
      $html_body .= '<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-check"></span> Payer</button>';
      $html_body .= '';  
    $html_body .= '</form>';
  $html_body .= '</div>';

  return $html_body;

}

function getHtmlPaymentBodyError(){
  $html_body = '<div class="modal-header-pay-error" style="padding:8px 22px;">';
    $html_body .= '<h5 class="error-gateway-payment"><span class="glyphicon glyphicon-check"></span> La plateforme de paiement est indisponible pour l\'instant.</h5>';
  $html_body .= '</div>';

  $html_body .= '<div class="modal-body" style="padding:40px 50px;">';
    $html_body .= '<div class="modal-body-amount" style="">';
      $html_body .= '<h5>Prière réessayer plus tard pour terminer la création de votre compte membre.</h5>';
    $html_body .= '</div>';
  $html_body .= '</div>';

  $html_body .= '<div class="modal-footer">';
    $html_body .= '<button class="btn btn-default" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Fermer </button>';
  $html_body .= '</div>';  
  return $html_body;
}


 function getStatus($statut){

        $statutPaiement[0]['titre']='Echec';
        $statutPaiement[0]['action']='Reprendre';
        $statutPaiement[0]['description']='Votre précédente transaction a éechoué. veuillez cliquer sur le bouton pour la reprendre.';

        $statutPaiement[1]['titre']='Payé';
        $statutPaiement[1]['action']='';
        $statutPaiement[1]['description']='';

        $statutPaiement[2]['titre']='Echec';
        $statutPaiement[2]['action']='Reprendre';
        $statutPaiement[2]['description']='Votre précédente transaction a éechoué pour insuffisance de fond sur votre solde.
         veuillez cliquer sur le bouton pour la reprendre.';

        $statutPaiement[3]['titre']='Traitement En cours';
        $statutPaiement[3]['action']='Actualiser';
        $statutPaiement[3]['description']='Le traitement de votre transaction est en cours de traitement.';

        $statutPaiement[5]['titre']='Echec';
        $statutPaiement[5]['action']='Reprendre';
        $statutPaiement[5]['description']='Votre précédente transaction n\'a pas abouti. veuillez cliquer sur le bouton pour la reprendre.';

        $statutPaiement[10]['titre']='En attente';
        $statutPaiement[10]['action']='Reprendre';
        $statutPaiement[10]['description']='Votre précédente transaction n\'a pas abouti. veuillez cliquer sur le bouton pour la reprendre.';

        return $statutPaiement[$statut];

    }


/*
            <div class="modal-header-pay" style="padding:8px 22px;">
              <h5><span class="glyphicon glyphicon-check"></span> Veuillez payer les frais d'inscription pour terminer
               la création de votre compte membre.</h5>
            </div>
            <div class="modal-body" style="padding:40px 50px;">
              <div class="modal-body-amount" style="">
                <h6>Montant<h6>
                <h4>6 500 F CFA<h4>
              </div>
            </div>
            <div class="modal-footer">
                <form role="" action="http://crossroadtest.net:6968/order" method="POST">
                    <input name="operation_token" hidden value="" type="text"/>
                    <input name="order" hidden placeholder="montant" value="" type="text" />
                    <input name="jwt" hidden value="" type="text" />
                    <input name="currency" hidden value="XOF" type="text" />
                    <input name="transaction_amount" hidden placeholder="montant" type="text" />
                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-check"></span> Payer</button>
                    <!-- <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Fermer</button>-->
                </form> 
            </div>

*/
