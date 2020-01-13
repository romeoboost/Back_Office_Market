<?php

function getFees($pdo, $total_amount_cart){

  $shippingFees = 0; // initie les frais à 0

  //recuperer les frais
  if($total_amount_cart <= 0 ){ //si le montant du panier est 0
    $shippingFees = 0; // retourne 0 comme frais
  }else{
    $req['condition'] = " min <= $total_amount_cart AND max >= $total_amount_cart "; // recupere les frais dans le pallier adequat
    $feeRow = current( sql_select($pdo, $req, 'frais_livraison') );
    // debugger($total_amount_cart);
    if( !empty( $feeRow ) ){
      $shippingFees = $feeRow->frais;
    }else{
      unset($req['condition']);
      $req['order']['champs'] = ' max '; $req['order']['param'] = ' DESC ';
      $TopFeeRow = current( sql_select($pdo, $req, 'frais_livraison') );
      $shippingFees = $TopFeeRow->frais;
    }
  }

  return $shippingFees;
}


function send_mail($to, $Subject, $message){
  require_once('../phpmailer/class.phpmailer.php');
  //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

  $mail             = new PHPMailer();

  // $body             = file_get_contents('contents.html');
  // $body             = "TEST TEST";
  $body             = str_replace("\\",'',$message);

  $mail->IsSMTP(); // telling the class to use SMTP
  // $mail->Host       = "mail.yourdomain.com"; // SMTP server
  $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                             // 1 = errors and messages
                                             // 2 = messages only
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  $mail->Port       = 25;                   // set the SMTP port for the GMAIL server
  //$mail->Username   = "test.ngser@gmail.com";  // GMAIL username
  $mail->Username   = "afromart225@gmail.com"; //"test.application.ngser@gmail.com";
  $mail->Password   = "02378124BB";//"password2018#"; //"@dtngser";            // GMAIL password

  $mail->SetFrom('service.clients@afromart.com', 'SERVICE CLIENT AFROMART');

  $mail->AddReplyTo("service.clients@afromart.com","SERVICE CLIENT");

  $mail->Subject    = $Subject;

  $mail->AltBody    = "Pour afficher le message, veuillez utiliser un client de méssagerie électronique compatible HTML!"; // optional, comment out and test

  $mail->MsgHTML($body);

  $address = $to;
  $mail->AddAddress($address, $to);

  // $mail->AddAttachment("images/phpmailer.gif");      // attachment
  // $mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

  if(!$mail->Send()) {
    return "Mailer Error: " . $mail->ErrorInfo;
  } else {
    return true;
  }
}


function html_list_avis($elements, $offset ){
  $html = '';
  // debugger($elements);
  //$elements['liste'], $elements['stat']['total']['nbre'], $offset, $elements['liste_order']
  $nbre_product_plus = $elements['stat']['total']['nbre'] + 1;
  $nbre_product_plus_offset = $elements['stat']['total']['nbre'] - $offset;
  foreach ($elements['liste'] as $element) {
    $isClient = ($element->id_c == 0) ? 'NON' : 'OUI' ;
    $nom = ($element->id_c == 0) ? $element->nom_avis.' '.$element->prenoms_avis : $element->nom_client.' '.$element->prenoms_client;
    $email = ($element->id_c == 0) ? $element->email_avis : $element->email_client;
    $reponse_admin_contenu = !empty($element->reponse_admin_contenu) ? "REPONSE ".$element->reponse_admin_contenu : '';
    $page_accueil = ($element->page_accueil == 0) ? 'NON' : 'OUI' ;
    $statut = ($element->statut == 0) ? 'EN ATTENTE' : 'REPONDU' ;
    $contenu = substr($element->contenu, 60) ; 
    $contenu .= strlen($element->contenu) > 60 ? '...' : $element->contenu ;

    $html .= '<tr class="text-center '.$element->token.'">';
    $html .=    '<td>'.$nbre_product_plus_offset-- .'</td>';
    $html .=    '<td class="isClient" >'.$isClient .'</td>
                <td class="Nom" >'.ucfirst($nom) .'</td>
                <td class="Email" >'.$email .'</td>
                <td class="Produit" >'.$element->produit .'</td>
                <td class="Contenu">
                  '.$contenu .'
                </td>
                <td class="isHome" >'.$page_accueil .'</td>
                <td class="statut" >'.$statut .'</td>
                <td class="date_debut">'.dateFormat($element->date_creation).'</td>
                <td class="">';
    if( empty($element->reponse_admin_contenu) ){
    $html .=  '<button type="button" class="btn btn-icon-toggle response-btn" data-toggle="tooltip" data-placement="top" 
                element-id="'.$element->token .'" data-original-title="Repondre au commentaire">
                <a href="'.BASE_URL.'avis/modifier/'.$element->token .'">
                    <i class="md md-insert-comment"></i>
                </a>
              </button>';
    }else{ 
    $html .=  '<button type="button" class="btn btn-icon-toggle update-response-btn " data-toggle="tooltip" data-placement="top" 
                element-id="'.$element->token .'" data-original-title="Modifier la reponse au commentaire">
                <a href="'.BASE_URL.'avis/modifier/'.$element->token .'">
                    <i class="fa fa-pencil"></i>
                </a>
              </button>';
    }
    if( $element->page_accueil == 0 ){
    $html .=  '<button type="button" class="btn btn-icon-toggle response-btn" data-toggle="tooltip" data-placement="top" 
                element-id="'.$element->token .'" data-original-title="Afficher sur la page d\'acceuil">
                    <i class="md md-home"></i>
              </button>';
    }else{ 
    $html .=  '<button type="button" class="btn btn-icon-toggle update-response-btn " data-toggle="tooltip" data-placement="top" 
                element-id="'.$element->token .'" data-original-title="Rétirer de la page d\'acceuil">
                    <i class="md md-check-box-outline-blank"></i>
              </button>';
    } 
    $html .=  '<button type="button" class="btn btn-icon-toggle detail-element-btn " data-toggle="tooltip" data-placement="top" category-id="'.$element->token .'"
                 data-original-title="Voir les détails du commentaire">
                  <a href="'.BASE_URL.'avis/details/'.$element->token .'">
                      <i class="md md-description"></i>
                  </a>
                </button>
                <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" element-id="'.$element->token .'"
                 data-original-title="Supprimer l\'element"><i class="fa fa-trash-o"></i>
                </button>
              </td>';    
    $html .= '</tr>';
  }

  return $html;

}

function html_list_pubs($elements, $offset ){
  $html = '';
  // debugger($elements);
  //$elements['liste'], $elements['stat']['total']['nbre'], $offset, $elements['liste_order']
  $nbre_product_plus = $elements['stat']['total']['nbre'] + 1;
  $nbre_product_plus_offset = $elements['stat']['total']['nbre'] - $offset;
  foreach ($elements['liste'] as $element) {
    $status = ($element->statut == 1) ? 'ACTIF' : 'NON ACTIF';
    $html .= '<tr class="text-center '.$element->token.'">';
    $html .=    '<td>'.$nbre_product_plus_offset-- .'</td>
                 <td class="element_name" >'.ucfirst( $element->entreprise ).'</td>
        <td>'.$element->position.'</td>
        <td><img class="img-circle width-1" src="'.WEBROOT_URL_FRONT.'images/pub/'.$element->image.'.png?1422538624" alt="" /></td>
        
        <td>'.$status.'</td>
        <td class="date_debut_pub">'.dateFormat($element->date_debut).'</td>
        <td class="date_fin_pub">'.dateFormat($element->date_fin).'</td>
        <td class="">
          <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" 
            element-id="'.$element->token.'" data-original-title="Modifier les informations de l\'element">
            <a href="'.BASE_URL.'pubs/modifier/'.$element->token.'">
                <i class="fa fa-pencil"></i>
            </a>
          </button>
          <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" element-id="'.$element->token.'"
           data-original-title="Supprimer la element"><i class="fa fa-trash-o"></i>
          </button>
        </td>';
    $html .= '</tr>';
  }

  return $html;
}

function html_list_communes($communes, $offset ){
  $html = '';
  // debugger($communes);
  //$communes['liste'], $communes['stat']['total']['nbre'], $offset, $communes['liste_order']
  $nbre_product_plus = $communes['stat']['total']['nbre'] + 1;
  $nbre_product_plus_offset = $communes['stat']['total']['nbre'] - $offset;
  foreach ($communes['liste'] as $commune) {
    $status = ($commune->statut == 1) ? 'ACTIF' : 'NON ACTIF';
    $html .= '<tr class="text-center '.$commune->token.'">';
    $html .=    '<td>'.$nbre_product_plus_offset-- .'</td>
                  <td class="element_name" >'.ucfirst( $commune->commune ) .'</td>
                  <td>'.$status.'</td>
                  <td>'.number_format($communes['liste_order'][$commune->id], 0, '', ' ') .'</td>
                  <td>'.$commune->longitude .'</td>
                  <td>'.$commune->lagitude .'</td>
                  <td>'.dateFormat($commune->date_creation) .'</td>
                  <td>'.dateFormat($commune->date_modification) .'</td>
                  <td class="">
                    <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" commune-id="'.$commune->token .'"
                     data-original-title="Modifier les informations de la commune">
                      <a href="'.BASE_URL.DS.'communesLivraison/modifier/'.$commune->token .'">
                          <i class="fa fa-pencil"></i>
                      </a>
                    </button>
                    <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" commune-id="'.$commune->token .'"
                     data-original-title="Supprimer la commune"><i class="fa fa-trash-o"></i>
                    </button>
                  </td>';
    $html .= '</tr>';
  }

  return $html;
}

function getNeverOrderPlace($pdo, $request_params){
      $req = [
              'fieldsmain' => ['id as idDest'],
              'fieldstwo' => ['id_livraison_destination'],
              'count' => [  'champs' => 'commandes.id_livraison_destination',  'alias' => 'nbre'  ]
              ,'fields' => array(  array(  'main' => 'id',  'second' => 'id_livraison_destination'  )  )
              ,'group' => 'livraison_destinations.id'
              ,'condition' => $request_params['condition']." AND id_livraison_destination is null"
              ,'array_filter' => $request_params['array_filter']
          ];    
      $nbre = count( findLeftJoin($pdo, $req, 'livraison_destinations','commandes') );
      unset($req['condition']);

      $listeSql = findLeftJoin($pdo, $req, 'livraison_destinations','commandes');
      $listeArray = array();
      foreach ($listeSql as $c) {
        $listeArray[$c->idDest] = $c->nbre;
      }

      return [ 'nbre' => $nbre, 'liste' => $listeArray];

    }

function isSetAsFees($pdo, $amount, $selfElementToken=null){

  $shippingFees = false; // initie les frais à 0

  $req['condition'] = ' min <= :min AND max >= :max '; // recupere les frais dans le pallier adequat  
  $req['array_filter'] = [
    ':min' => $amount,
    ':max' => $amount
  ];
  if ( isset( $selfElementToken ) ){ //au cas ou ne souhaite pas inclure une ligne frais dans la verification
    $req['condition'] .= " AND token NOT LIKE :token " ;
    $req['array_filter'][':token'] =  $selfElementToken ;
  }
  // debugger($req);

  $feeRow = current( sql_select($pdo, $req, 'frais_livraison') );
  
  if( !empty( $feeRow ) ){
    $shippingFees = true;
    // debugger($feeRow);
  }

  return $shippingFees;
}

function html_list_livreurs($pdo, $livreurs, $nombre_total_livreur, $offset){
  
  $html = '';
  $nbre_product_plus = $nombre_total_livreur + 1;
  $nbre_product_plus_offset = $nombre_total_livreur - $offset;
  foreach ($livreurs as $livreur) {
    $html .= '<tr class="text-center '.$livreur->token.'">';
    $html .=    ' <td>'.$nbre_product_plus_offset--.'</td>
                  <td class="token" >'.$livreur->token.' </td>
                  <td class="name_supplier" >'.ucfirst( $livreur->nom ).' '.ucfirst( $livreur->prenoms ).'</td>
                  <td> '.$livreur->tel.' </td>
                  <td> '.$livreur->email.' </td>
                  <td>'.dateFormat($livreur->date_creation).'</td>
                  <td>'.dateFormat($livreur->date_modification).'</td>
                  <td class="">
                    <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" livreurs-id="'.$livreur->token.'"
                     data-original-title="Modifier les informations du livreur">
                      <a href="'.BASE_URL.DS.'livreurs/modifier/'.$livreur->token.'">
                          <i class="fa fa-pencil"></i>
                      </a>
                    </button>
                    <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" livreurs-id="'.$livreur->token.'"
                     data-original-title="Voir les détails du livreur">
                      <a href="'.BASE_URL.DS.'livreurs/details/'.$livreur->token.'">
                          <i class="md md-description"></i>
                      </a>
                    </button>
                    <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" livreurs-id="'.$livreur->token.'"
                     data-original-title="Supprimer le livreur"><i class="fa fa-trash-o"></i></button>
                  </td>';
    $html .= '</tr>';

  }

  return $html;
}

function html_list_fournisseurs($pdo, $fournisseurs, $nombre_total_produit, $offset){
  //recupere les unités de mésures

  $html = '';
  $nbre_product_plus = $nombre_total_produit + 1;
  $nbre_product_plus_offset = $nombre_total_produit - $offset;
  foreach ($fournisseurs as $fournisseur) {
    $html .= '<tr class="text-center '.$fournisseur->token.'">';
    $html .=    ' <td>'.$nbre_product_plus_offset--.'</td>
                  <td class="token" >'.$fournisseur->token.' </td>
                  <td class="name_supplier" >'.ucfirst( $fournisseur->nom ).'</td>
                  <td> '.$fournisseur->tel.' </td>
                  <td> '.$fournisseur->email.' </td>
                  <td>'.dateFormat($fournisseur->date_creation).'</td>
                  <td>'.dateFormat($fournisseur->date_modification).'</td>
                  <td class="">
                    <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" fournisseurs-id="'.$fournisseur->token.'"
                     data-original-title="Modifier les informations du produit">
                      <a href="'.BASE_URL.DS.'fournisseurs/modifier/'.$fournisseur->token.'">
                          <i class="fa fa-pencil"></i>
                      </a>
                    </button>
                    <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" fournisseurs-id="'.$fournisseur->token.'"
                     data-original-title="Voir les détails du produit">
                      <a href="'.BASE_URL.DS.'fournisseurs/details/'.$fournisseur->token.'">
                          <i class="md md-description"></i>
                      </a>
                    </button>
                    <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" fournisseurs-id="'.$fournisseur->token.'"
                     data-original-title="Supprimer le fournisseur"><i class="fa fa-trash-o"></i></button>
                  </td>';
    $html .= '</tr>';

  }

  return $html;
}

function update($pdo, $req, $table){
   $cond = array();
   $sql = ' UPDATE '.$table.' SET ';
   // $sql .= implode('=?, ', $req['fields']).'=?';
   // $sql .= implode(', ', $req['fields']).')';
   // $sql .= ' VALUE (:'.implode(', :',$req['fields']).')';
   foreach ( $req['fields'] as $field ) {
     $sql .= ' '.$field.' = :'.$field.',';
   }
   $sql = trim($sql, ","  );
   // debugger($sql);
   if( isset($req['condition']) ){
          $sql .= ' WHERE '.$req['condition']; 
    }
   //die($sql);
   // debugger($sql);
   $pre = $pdo->prepare($sql);
   $pre->execute($req['values']);
}

//renvoi html pour la liste des produits
function html_list_stocks($pdo, $stocks, $nombre_total_produit, $offset){

  //recupere les unités de mésures
  $unit_mesure = get_unit_mesure($pdo);

  $html = '';
  $nbre_product_plus = $nombre_total_produit + 1;
  $nbre_product_plus_offset = $nombre_total_produit - $offset;
  foreach ($stocks as $stock) {
    $html .= '<tr class="'.$stock->stock_id.'">';
    $html .=    ' <td>'.$nbre_product_plus_offset--.'</td>
                  <td class="token" >'.$stock->stock_id.' </td>
                  <td class="montant_ht" >'.number_format($stock->montant_ht, 0, '', ' ').' </td>
                  <td class="frais_livraison" >'.number_format($stock->frais_livraison, 0, '', ' ').' </td>
                  <td class="montant_total" >'.number_format($stock->montant_total, 0, '', ' ').' </td>
                  <td class="produit" >'.$stock->produit.' </td>
                  <td class="qtte" >'.number_format($stock->qtte, 0, '', ' ').' </td>
                  <td class="unite" >'.ucfirst( $unit_mesure[$stock->unite] ).'</td>
                  <td class="produit" >'.ucfirst( $stock->fournisseur_nom ).' </td>
                  <td>'.dateFormat($stock->date_creation).'</td>
                  <td>'.dateFormat($stock->date_modification).'</td>
                  <td class="">
                    <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top"
                      stock-id="'.$stock->stock_id.'" data-original-title="Modifier le stock">
                      <a href="'.BASE_URL.'stocks/modifier/'.$stock->stock_id.'">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </button>
                    <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" 
                       data-placement="top" stock-id="'.$stock->stock_id.'" data-original-title="Supprimer le stock">
                      <i class="fa fa-trash-o"></i>
                    </button>
                  </td>';

    $html .= '</tr>';



  }

  return $html;
}

function html_list_clients($pdo, $clients, $nombre_total_produit, $offset){
  $html = '';
  $nbre_product_plus = $nombre_total_produit + 1;
  $nbre_product_plus_offset = $nombre_total_produit - $offset;
  foreach ($clients as $client) {
    $html .= '<tr class="text-center '.$client->token.'">';
    $html .=    '<td>'.$nbre_product_plus_offset--.'</td>';
    $html .=    '<td class="nom">'.ucfirst( $client->nom ).'</td>';
    $html .=    '<td class="prenom">'.ucfirst( $client->prenoms ).' </td>';
    $html .=    '<td class="token">'.$client->token.' </td>';
    $html .=    '<td class="">'.$client->tel.' </td>';
    $html .=    '<td class="">'.$client->email .'</td>';
    $sexe =     ($client->sexe == 1) ? 'HOMME' : 'FEMME';
    $html .=    '<td  class="sexe">'.$sexe.'</td>';
    $statut =   ($client->statut == 1) ? 'ACTIF' : 'NON ACTIF';
    $html .=    '<td  class="statut">'.$statut.'</td>';
    $html .=    '<td>'.dateFormat($client->date_creation).'</td>';
    $html .=    '<td class="">'; 

    if( $client->statut == 1 ){
    $html .=    '<button type="button" class="btn btn-icon-toggle set-rejected-btn" data-toggle="tooltip" 
                    data-placement="top" data-original-title="Desactiver le client " clients-id="'.$client->token.'">
                    <i class="fa fa-times-circle-o"></i>
                </button>';
      }  
    if( $client->statut == 0 ){
    $html .=    '<button type="button" class="btn btn-icon-toggle set-restore-btn" data-toggle="tooltip" 
                clients-id="'.$client->token.'" data-placement="top" data-original-title="Reactiver le client">
                    <i class="md md-settings-backup-restore"></i>
                </button>';
      }
    $html .=      '<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" clients-id="'.$client->token.'"
                                         data-original-title="Voir les détails du client">
                                         <a href="'.SITE_BASE_URL.'clients/details/'.$client->token.'">
                                                    <i class="md md-description"></i>
                                          </a>
                    </button>';
    $html .=       '<button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" clients-id="'.$client->token.'"
                                         data-original-title="Supprimer le client"><i class="fa fa-trash-o"></i></button>';
    $html .=    '</td>';

    $html .= '</tr>';

  }

  return $html;
}

function html_list_categories($pdo, $categories, $nombre_total_produit, $offset){
  $html = '';
  $nbre_product_plus = $nombre_total_produit + 1;
  $nbre_product_plus_offset = $nombre_total_produit - $offset;
  foreach ($categories as $categorie) {
    $html .= '<tr class="text-center '.$categorie->token.'">';
    $html .=    '<td>'.$nbre_product_plus_offset--.'</td>';
    $html .=    '<td> <img class="img-circle width-1" src="'.WEBROOT_URL_FRONT.'images/category/'.$categorie->image.'.png?1422538624" alt="" /> </td>';
    $html .=    '<td class="name_category"> '.ucfirst( $categorie->nom ).' </td>';
    $html .=    '<td> <i class="glyph-icon flaticon-'.$categorie->icon.'"></i> </td>';
    $statut = ($categorie->statut == 1) ? 'ACTIF' : 'NON ACTIF';  
    $html .=    '<td>'.$statut.'</td>';
    $html .=    '<td>'.dateFormat($categorie->date_creation).'</td>';
    $html .=    '<td class="">';      
    $html .=      '<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" category-id="'.$categorie->token.'"
                                         data-original-title="Modifier les informations de la categorie"> 
                                            <a href=" '.SITE_BASE_URL.'categories/modifier/'.$categorie->token.'">
                                                    <i class="fa fa-pencil"></i>
                                            </a>
                                         </button>';
    $html .=      '<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" category-id="'.$categorie->token.'"
                                         data-original-title="Voir les détails de la categorie">
                                         <a href="'.SITE_BASE_URL.'categories/details/'.$categorie->token.'">
                                                    <i class="md md-description"></i>
                                          </a>
                                         </button>';
    $html .=       '<button type="button" class="btn delete-category-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" category-id="'.$categorie->token.'"
                                         data-original-title="Supprimer la categorie"><i class="fa fa-trash-o"></i></button>';
    $html .=    '</td>';

    $html .= '</tr>';

  }

  return $html;
}

function findJoinType($pdo, $req, $maintable, $secondtable, $thirdtable=NULL){
    $sql = ' SELECT ';            
    $sql .= $maintable.'.'.implode(', '.$maintable.'.',$req['fieldsmain']);
    $sql .= ', '.$secondtable.'.'.implode(', '.$secondtable.'.',$req['fieldstwo']);
    if(isset($thirdtable)){
        $sql .= ', '.$thirdtable.'.'.implode(', '.$thirdtable.'.',$req['fieldsthree']);
    }
    $sql .= ' FROM '.$maintable;
    $sql .= ' '.$req['fields'][0]['type'];
    $sql .= ' '.$secondtable.' ON '.$maintable.'.'.$req['fields'][0]['main'].' = '.$secondtable.'.'.$req['fields'][0]['second'];
    if(isset($thirdtable)){
      $sql .= ' '.$req['fields'][1]['type'];
      $sql .= ' '.$thirdtable.' ON '.$maintable.'.'.$req['fields'][1]['main'].' = '.$thirdtable.'.'.$req['fields'][1]['third']; 
    }
    if(isset($req['condition'])){
          $sql .= ' WHERE '.$req['condition']; 
    }
    if(isset($req['order'])){
        if(is_array($req['order'])){
           $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param']; 
        }else{
          $sql .= ' ORDER BY '.$req['order'].' ASC';  
        }
    }
    //reglage pour LIMIT
   if(isset($req['limit'])){
      $sql .= ' LIMIT '.$req['limit'];              
   }
    //die ($sql);
   $pre = $pdo->prepare($sql);

   if( isset( $req['array_filter'] ) ){
      // debugger($req['array_filter']);    
      $pre->execute($req['array_filter']);  
    }else{
      $pre->execute(); 
    }
   
   if(isset($req['assos'])){
     return $pre->fetchAll(PDO::FETCH_ASSOC);  
   }else{
     return $pre->fetchAll(PDO::FETCH_OBJ);  
   }
}


function findLeftJoin($pdo, $req, $maintable, $secondtable, $thirdtable=NULL){
    $sql = ' SELECT ';            
    $sql .= $maintable.'.'.implode(', '.$maintable.'.',$req['fieldsmain']);
    $sql .= ', '.$secondtable.'.'.implode(', '.$secondtable.'.',$req['fieldstwo']);
    if(isset($thirdtable)){
        $sql .= ', '.$thirdtable.'.'.implode(', '.$thirdtable.'.',$req['fieldsthree']);
    }
    if(isset($req['count'])){
      $sql .= ', COUNT('.$req['count']['champs'].') AS '.$req['count']['alias'];
    }
    $sql .= ' FROM '.$maintable;
    $sql .= ' LEFT JOIN '.$secondtable.' ON '.$maintable.'.'.$req['fields'][0]['main'].' = '.$secondtable.'.'.$req['fields'][0]['second'];
    if(isset($thirdtable)){
      $sql .= ' INNER JOIN '.$thirdtable.' ON '.$maintable.'.'.$req['fields'][1]['main'].' = '.$thirdtable.'.'.$req['fields'][1]['third']; 
    }
    if(isset($req['condition'])){
          $sql .= ' WHERE '.$req['condition']; 
    }
    if(isset($req['order'])){
        if(is_array($req['order'])){
           $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param']; 
        }else{
          $sql .= ' ORDER BY '.$req['order'].' ASC';  
        }
    }

    //group by
    if(isset($req['group'])){
      $sql .= ' GROUP BY '.$req['group'];             
    }
    // debug($sql);
    $pre = $pdo->prepare($sql);
    if( isset( $req['array_filter'] ) ){  
      $pre->execute($req['array_filter']);  
    }else{
      $pre->execute(); 
    }
    return $pre->fetchAll(PDO::FETCH_OBJ);
}

//peut prendre les conditions listées dans un tableau ou pas
function sql_select($pdo, $req, $table=null){
   $sql = 'SELECT ';
   //reglage pour les doublons
   if(isset($req['distinct'])){
      $sql .= 'DISTINCT '; 
   }
   //reglage pour les champs
   if(isset($req['fields'])){
      if(is_array($req['fields'])){
          $sql .= implode(', ',$req['fields']); 
       }else {
          $sql .= $req['fields']; 
       }              
   }else{
      $sql .= '*'; 
   } 
   $sql .= ' FROM '.$table;
    //condition
   if(isset($req['condition'])){
       $sql .= ' WHERE ';
       $sql .= $req['condition'];
       
   }
   //group by
   if(isset($req['group'])){
      $sql .= ' GROUP BY '.$req['group'];             
   }

   //reglage order by
   if(isset($req['order'])){
      $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param'];              
   }
   //reglage pour LIMIT
   if(isset($req['limit'])){
      $sql .= ' LIMIT '.$req['limit'];              
   }           
   //die ($sql);
   $pre = $pdo->prepare($sql);
   if( isset( $req['array_filter'] ) ){
      // debugger($req['array_filter']);    
      $pre->execute($req['array_filter']);  
    }else{
      $pre->execute(); 
    }
   
   if(isset($req['assos'])){
     return $pre->fetchAll(PDO::FETCH_ASSOC);  
   }else{
     return $pre->fetchAll(PDO::FETCH_OBJ);  
   } 
}



function insert($pdo, $req, $table){
    $sql = ' INSERT INTO '.$table.' (';
    $sql .= implode(', ', $req['fields']).')';
    $sql .= ' VALUE (:'.implode(', :',$req['fields']).')';
    $pre = $pdo->prepare($sql);
    $pre->execute($req['values']);
}

//
function upload($file, $width, $height) {
   $img = $file['name'];
   $img_tmp = $file['tmp_name'];
   $image = explode('.',$img);
   $image_ext = end($image);
   $error = '';
   if( empty( $img ) ){
      return false;
   }
   if( in_array( strtolower($image_ext),array('png','jpeg','jpg') ) === false ){
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
           $image_width = $width;
           if($image_size[0] == $image_width){
               $image_finale = $image_src;
           }else{
               $new_width = $image_width;
               $new_height = $height;
               $image_finale= imagecreatetruecolor($new_width,$new_height);
               imagecopyresampled($image_finale,$image_src,0,0,0,0,$new_width,$new_height,
                       $image_size[0],$image_size[1]);
           }
           //imagejpeg($image_finale,'C:\wamp\www\mareussite\webroot\photo\1.jpg');
           return $image_finale;
       }
   }

}



//renvoi la coloration que doit prendre la ligne
function color_ligne_product($produit){
  $class_color = '';
  //stock
  if ( intval($produit->stock) == 0 ) {
    $class_color = ' danger ';
    return $class_color ;
  }

  //non ctif
  if ( intval($produit->produit_statut) == 0 ) {
    $class_color = ' warning ';
    return $class_color ;
  }

  //promo
  if ( intval($produit->ispromo) == 1 ) {
    $class_color = ' success ';
    return $class_color ;
  }

  //return $produit->stock ;
  return $class_color ;

}
//renvoi html pour la liste des produits
function html_list_product($pdo, $produits, $nombre_total_produit, $offset){

  //recupere les unités de mésures
  $unit_mesure = get_unit_mesure($pdo);

  $html = '';
  $nbre_product_plus = $nombre_total_produit + 1;
  $nbre_product_plus_offset = $nombre_total_produit - $offset;
  foreach ($produits as $produit) {
    $html .= '<tr class="'.$produit->token_produit.' '.color_ligne_product($produit).'">';
    $html .=    '<td>'.$nbre_product_plus_offset--.'</td>';
    $html .=    '<td> <img class="img-circle width-1" src="'.WEBROOT_URL_FRONT.'images/shop/'.$produit->image.'.jpg?1422538624" alt="" /> </td>';
    $html .=    '<td class="name_product"> '.ucfirst( $produit->nom_produit ).' </td>';
    $html .=    '<td> '.ucfirst( $produit->categorie ).' </td>';
    $html .=    '<td class="stock_product"> '.number_format($produit->stock, 0, '', ' ').' </td>';
    $html .=    '<td class=""> '.number_format($produit->qtite_unit, 0, '', ' ').' </td>';
    $html .=    '<td class=""> '.ucfirst( $unit_mesure[$produit->unite] ).' </td>';
    $html .=    '<td> '.number_format($produit->prix_qtite_unit, 0, '', ' ').' </td>';
    $promo = ($produit->ispromo == 1) ? 'OUI' : 'NON';
    $html .=    '<td>'.$promo.'</td>';
    $prix_promo = ($produit->ispromo == 1) ? number_format($produit->prix_qtite_unit - $produit->prix_qtite_unit*$produit->percent_promo/100, 0, '', ' ') : '-';
    $html .=    '<td>'.$prix_promo.'</td>';
    $statut = ($produit->produit_statut == 1) ? 'ACTIF' : 'NON ACTIF';
    $html .=    '<td>'.$statut.'</td>';
    
    $html .=    '<td>'.dateFormat($produit->date_creation).'</td>';
    $html .=    '<td class="text-right">';
      
    $html .=      '<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" product-id="'.$produit->token_produit.'"
                                         data-original-title="Modifier les informations du produit"> 
                                            <a href=" '.SITE_BASE_URL.'produits/modifier/'.$produit->token_produit.'">
                                                    <i class="fa fa-pencil"></i>
                                            </a>
                                         </button>';
    $html .=      '<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" product-id="'.$produit->token_produit.'"
                                         data-original-title="Voir les détails du produit">
                                         <a href="'.SITE_BASE_URL.'produits/details/'.$produit->token_produit.'">
                                                    <i class="md md-description"></i>
                                          </a>
                                         </button>';
    $html .=       '<button type="button" class="btn delete-product-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" product-id="'.$produit->token_produit.'"
                                         data-original-title="Supprimer le produit"><i class="fa fa-trash-o"></i></button>';
    $html .=    '</td>';

    $html .= '</tr>';



  }

  return $html;
}

function get_unit_mesure($pdo){
    $sql_unite="SELECT id,libelle,symbole FROM unites";
    $req_unite = $pdo->prepare($sql_unite);
    $req_unite->execute(array());

    $unites_from_bd = $req_unite->fetchAll(PDO::FETCH_OBJ);

    foreach ($unites_from_bd as $u) {
       $unites[$u->id] = ($u->symbole == 'NA') ? 'nombre' : $u->symbole;
    }
    return $unites;
}

function sql_left_join($pdo, $req, $maintable, $secondtable, $thirdtable=NULL){
    $sql = ' SELECT ';            
    $sql .= $maintable.'.'.implode(', '.$maintable.'.',$req['fieldsmain']);
    $sql .= ', '.$secondtable.'.'.implode(', '.$secondtable.'.',$req['fieldstwo']);
    if(isset($thirdtable)){
        $sql .= ', '.$thirdtable.'.'.implode(', '.$thirdtable.'.',$req['fieldsthree']);
    }
    $sql .= ' FROM '.$maintable;
    $sql .= ' LEFT JOIN '.$secondtable.' ON '.$maintable.'.'.$req['fields'][0]['main'].' = '.$secondtable.'.'.$req['fields'][0]['second'];
    if(isset($thirdtable)){
      $sql .= ' INNER JOIN '.$thirdtable.' ON '.$maintable.'.'.$req['fields'][1]['main'].' = '.$thirdtable.'.'.$req['fields'][1]['third']; 
    }
    if(isset($req['condition'])){
          $sql .= ' WHERE '.$req['condition']; 
    }
    if(isset($req['order'])){
        if(is_array($req['order'])){
           $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param']; 
        }else{
          $sql .= ' ORDER BY '.$req['order'].' ASC';  
        }
    }
    $pre = $pdo->prepare($sql);
    if( isset( $req['array_filter'] ) ){
      $pre->execute($req['array_filter']);  
    }else{
      $pre->execute(); 
    }
    return $pre->fetchAll(PDO::FETCH_OBJ);
}

//Fonction de select jointure interne recupérée du model-core
function sql_inner_join($pdo, $req, $maintable, $secondtable, $thirdtable=NULL){
    $sql = ' SELECT ';            
    $sql .= $maintable.'.'.implode(', '.$maintable.'.',$req['fieldsmain']);
    $sql .= ', '.$secondtable.'.'.implode(', '.$secondtable.'.',$req['fieldstwo']);
    if(isset($req['count'])){
      $sql .= ', COUNT('.$req['count']['champs'].') AS '.$req['count']['alias'];
    }
    if(isset($thirdtable)){
        $sql .= ', '.$thirdtable.'.'.implode(', '.$thirdtable.'.',$req['fieldsthree']);
    }
    $sql .= ' FROM '.$maintable;
    $sql .= ' INNER JOIN '.$secondtable.' ON '.$maintable.'.'.$req['fields'][0]['main'].' = '.$secondtable.'.'.$req['fields'][0]['second'];
    if(isset($thirdtable)){
      $sql .= ' INNER JOIN '.$thirdtable.' ON '.$maintable.'.'.$req['fields'][1]['main'].' = '.$thirdtable.'.'.$req['fields'][1]['third']; 
    }
    if(isset($req['condition'])){
          $sql .= ' WHERE '.$req['condition']; 
    }

    //group by
    if(isset($req['group'])){
      $sql .= ' GROUP BY '.$req['group'];             
    }

    if(isset($req['order'])){
        if(is_array($req['order'])){
           $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param']; 
        }else{
          $sql .= ' ORDER BY '.$req['order'].' ASC';  
        }
    }
    if(isset($req['limit'])){
      $sql .= ' LIMIT '.$req['limit'];              
    } 
    $pre = $pdo->prepare($sql);
    if( isset( $req['array_filter'] ) ){
      $pre->execute($req['array_filter']);  
    }else{
      $pre->execute(); 
    }
    return $pre->fetchAll(PDO::FETCH_OBJ);
}


//Renvoi HTML pour la liste des commandes Rapides
function html_list_quick_cmd( $commandes, $nombre_total_cmd, $offset){
  $html = '';
  $nbre_cmd_plus = $nombre_total_cmd + 1;
  $nbre_cmd_plus_offset = $nombre_total_cmd - $offset;
  foreach ($commandes as $commande) {
    $html .= '<tr class="'.$commande->cmd_id.'">';
    $html .=    '<td>'.$nbre_cmd_plus_offset--.'</td>';
    $html .=    '<td> '.ucfirst( $commande->client_nom ).' '.ucfirst( explode( ' ',$commande->client_prenoms )[0] ).' </td>';
    $html .=    '<td class="cmd_id"> '.$commande->client_tel.' </td>';
    $html .=    '<td data-list-montant-ht="'.$commande->montant_ht.'" class="montant_ht"> '.number_format($commande->montant_ht, 0, '', ' ').' </td>';
    $html .=    '<td data-list-frais-livraison="'.$commande->frais_livraison.'" class="frais_livraison"> '.number_format($commande->frais_livraison, 0, '', ' ').' </td>';
    $html .=    '<td data-list-montant-ttc="'.$commande->montant_total.'" class="montant_ttc"> '.number_format($commande->montant_total, 0, '', ' ').' </td>';
    $html .=    '<td class="cmd_id"> '.$commande->cmd_id.' </td>';
    $html .=    '<td>';
    $html .=      '<span class="cmd-status badge style-'.status_displayed($commande->cmd_statut)['color'].' ">';
    $html .=        status_displayed($commande->cmd_statut)['libele'];
    $html .=      '</span>';
    $html .=    '</td>';
    $html .=    '<td>'.dateFormat($commande->cmd_date_creation).'</td>';
    $html .=    '<td class="text-right">';
    if( $commande->cmd_statut == 0 ){
      $html .=      '<button type="button" cmd-id="'.$commande->cmd_id.'" class="btn btn-icon-toggle set-shipping-btn quick-order" data-toggle="tooltip"  data-placement="top" data-original-title="Livrer"> <i class="md md-local-shipping"></i> </button><button type="button" class="btn btn-icon-toggle set-rejected-btn quick-order" data-toggle="tooltip" data-placement="top" data-original-title="Rejetter la commande" cmd-id="'.$commande->cmd_id.'"><i class="fa fa-times-circle-o"></i></button>';  
    }
    if( $commande->cmd_statut == 1 ){
      $html .=      '<button type="button" class="btn btn-icon-toggle set-shipping-btn" data-toggle="tooltip" data-placement="top" data-original-title="Reprendre la livraison" cmd-id="'.$commande->cmd_id.'"><i class="md md-local-shipping"></i></button>';  
    }
    if( $commande->cmd_statut == 3 ){
      $html .=      '<button type="button" class="btn btn-icon-toggle set-stop-shipping-btn quick-order" data-toggle="tooltip" data-placement="top" data-original-title="Arrêter la livraison" cmd-id="'.$commande->cmd_id.'"> <i class="fa fa-pause"></i> </button>';  
      $html .=      '<button type="button" class="btn btn-icon-toggle set-confirm-shipping-btn quick-order" data-toggle="tooltip" cmd-id="'.$commande->cmd_id.'"data-placement="top" data-original-title="Confirmer la livraison"><i class="md md-check-box"></i></button>';  
    }
    if( $commande->cmd_statut == 4 ){
      $html .=      '<button type="button" class="btn btn-icon-toggle set-restore-btn quick-order" data-toggle="tooltip" data-placement="top" data-original-title="Restaurer la commande" cmd-id="'.$commande->cmd_id.'"> <i class="md md-settings-backup-restore"></i> </button>';  
    }
    
      $html .=      '<button type="button" class="btn btn-icon-toggle check-details-btn" data-toggle="tooltip" data-placement="top" data-original-title="Détails de la commandes" cmd-id="'.$commande->cmd_id.'"> <a href="'.SITE_BASE_URL.'commandesRapide/details/'.$commande->cmd_id.'"><i class="md md-description"></i></a></button>';
      $html .=      '<button type="button" class="btn btn-icon-toggle delete-order-btn quick-order" data-toggle="tooltip" data-placement="left" data-original-title="Supprimer la commandes" cmd-id="'.$commande->cmd_id.'"> <i class="fa fa-trash-o"></i></button>';
    $html .=    '</td>';

    $html .= '</tr>';
  }
  return $html;
}

//renvoi html pour la liste des commandes
function html_list_cmd( $commandes, $nombre_total_cmd, $offset){
  $html = '';
  $nbre_cmd_plus = $nombre_total_cmd + 1;
  $nbre_cmd_plus_offset = $nombre_total_cmd - $offset;
  foreach ($commandes as $commande) {
    $html .= '<tr class="'.$commande->cmd_id.'">';
    $html .=    '<td>'.$nbre_cmd_plus_offset--.'</td>';
    $html .=    '<td> '.ucfirst( $commande->client_nom ).' '.ucfirst( explode( ' ',$commande->client_prenoms )[0] ).' </td>';
    $html .=    '<td> '.$commande->client_id.' </td>';
    $html .=    '<td data-list-montant-ht="'.$commande->montant_ht.'" class="montant_ht"> '.number_format($commande->montant_ht, 0, '', ' ').' </td>';
    $html .=    '<td data-list-frais-livraison="'.$commande->frais_livraison.'" class="frais_livraison"> '.number_format($commande->frais_livraison, 0, '', ' ').' </td>';
    $html .=    '<td data-list-montant-ttc="'.$commande->montant_total.'" class="montant_ttc"> '.number_format($commande->montant_total, 0, '', ' ').' </td>';
    $html .=    '<td class="cmd_id"> '.$commande->cmd_id.' </td>';
    $html .=    '<td>';
    $html .=      '<span class="cmd-status badge style-'.status_displayed($commande->cmd_statut)['color'].' ">';
    $html .=        status_displayed($commande->cmd_statut)['libele'];
    $html .=      '</span>';
    $html .=    '</td>';
    $html .=    '<td>'.dateFormat($commande->cmd_date_creation).'</td>';
    $html .=    '<td class="text-right">';
    if( $commande->cmd_statut == 0 ){
      $html .=      '<button type="button" cmd-id="'.$commande->cmd_id.'" class="btn btn-icon-toggle set-shipping-btn" data-toggle="tooltip"  data-placement="top" data-original-title="Livrer"> <i class="md md-local-shipping"></i> </button><button type="button" class="btn btn-icon-toggle set-rejected-btn" data-toggle="tooltip" data-placement="top" data-original-title="Rejetter la commande" cmd-id="'.$commande->cmd_id.'"><i class="fa fa-times-circle-o"></i></button>';  
    }
    if( $commande->cmd_statut == 1 ){
      $html .=      '<button type="button" class="btn btn-icon-toggle set-shipping-btn" data-toggle="tooltip" data-placement="top" data-original-title="Reprendre la livraison" cmd-id="'.$commande->cmd_id.'"><i class="md md-local-shipping"></i></button>';  
    }
    if( $commande->cmd_statut == 3 ){
      $html .=      '<button type="button" class="btn btn-icon-toggle set-stop-shipping-btn" data-toggle="tooltip" data-placement="top" data-original-title="Arrêter la livraison" cmd-id="'.$commande->cmd_id.'"> <i class="fa fa-pause"></i> </button>';
      $html .=      '<button type="button" class="btn btn-icon-toggle set-confirm-shipping-btn" data-toggle="tooltip" cmd-id="'.$commande->cmd_id.'"data-placement="top" data-original-title="Confirmer la livraison"><i class="md md-check-box"></i></button>';   
    }
    if( $commande->cmd_statut == 4 ){
      $html .=      '<button type="button" class="btn btn-icon-toggle set-restore-btn" data-toggle="tooltip" data-placement="top" data-original-title="Restaurer la commande" cmd-id="'.$commande->cmd_id.'"> <i class="md md-settings-backup-restore"></i> </button>';  
    }
    
      $html .=      '<button type="button" class="btn btn-icon-toggle check-details-btn" data-toggle="tooltip" data-placement="top" data-original-title="Détails de la commandes" cmd-id="'.$commande->cmd_id.'"> <a href="'.SITE_BASE_URL.'commandes/details/'.$commande->cmd_id.'"><i class="md md-description"></i></a></button>';
      $html .=      '<button type="button" class="btn btn-icon-toggle delete-order-btn" data-toggle="tooltip" data-placement="left" data-original-title="Supprimer la commandes" cmd-id="'.$commande->cmd_id.'"> <i class="fa fa-trash-o"></i></button>';
    $html .=    '</td>';

    $html .= '</tr>';
  }
  return $html;
}

//renvoi le html de la pagination des listes du BO
function html_pagination( $nombre_pages, $numero_page_encours ){
  
  $html = '';
  $prev_disabled = ( $numero_page_encours == 1 ) ? 'disabled' : '';
  $prev_number = ( $numero_page_encours > 1 ) ? $numero_page_encours - 1 : '';

  $next_disabled = ( $numero_page_encours == $nombre_pages ) ? 'disabled' : '';
  $next_number = ( $numero_page_encours == $nombre_pages ) ? '' : $numero_page_encours + 1;

  $html .= '<li class="page-item '.$prev_disabled.'" >';
  $html .=   '<a class="page-link" href="'.$prev_number.'" aria-label="Previous">';
  $html .=     '<span aria-hidden="true">&laquo;</span>';
  $html .=     '<span class="sr-only">Previous</span>';
  $html .=   '</a>';
  $html .= '</li>';

  for( $i=1; $i <= $nombre_pages; $i++ ){ 
    $html .=  '<li class="page-item '. page_active($i, $numero_page_encours).'">';
    $link_page = ($numero_page_encours == $i) ? '' : $i;
    $html .=      '<a class="page-link" href="'.$link_page.'"> '. $i .'</a>';
    $html .=  '</li>';
   }

  $html .= '<li class="page-item '.$next_disabled.'" >';
  $html .=   '<a class="page-link" href="'.$next_number.'" aria-label="Previous">';
  $html .=     '<span aria-hidden="true">&raquo;</span>';
  $html .=     '<span class="sr-only">Next</span>';
  $html .=   '</a>';
  $html .= '</li>';

  return $html;

}

//renvoi le libellé et le style pour un status
function status_displayed( $status ){
  $command_status_desc[0]['libele']='en attente';
  $command_status_desc[0]['color']='info';

  $command_status_desc[1]['libele']='livrée';
  $command_status_desc[1]['color']='success';
  $command_status_desc[2]['libele']='annulée';
  $command_status_desc[2]['color']='danger';

  $command_status_desc[3]['libele']='en livraison';
  $command_status_desc[3]['color']='warning';

  $command_status_desc[4]['libele']='rejetée';
  $command_status_desc[4]['color']='default';

  return $command_status_desc[$status];

}

//pour la pagination : dit si une page est active ou non
function page_active($page_number, $number_page_running){
  $active = "";
  if( $page_number == $number_page_running ){
    $active = "active ";
  }

  return $active;
}

/*
*$date au format YYYY-mm-dd H:i:s
*/
function dateFormat($date){
  $date_c = new DateTime($date);
  $dateFormated = $date_c->format('d-m-Y H:i');
  return $dateFormated;
}

function debugger($var, $second_var=null){
  print_r($var);
  print_r(' ');
  print_r($second_var);
  die( header("arret pour debuggage", true, 501) );
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

function getTokenNumber($Nbre_Mbre_Actuel, $Abreviation_Pays, $Debut){

  $Identifiant = $Debut;

  $Date_Identifiant = date("Ym"); //
  $Identifiant .= "".$Date_Identifiant;        
  $Numero_Mbre = "".($Nbre_Mbre_Actuel + 0);
  $Taille_Fixe = 4;
  $Numero_Mbre_Good = str_pad($Numero_Mbre, $Taille_Fixe, "0", STR_PAD_LEFT);
  $Identifiant .= $Numero_Mbre_Good;

  //$Abreviation_Pays = 'CI'; // A automatiser
  $Identifiant .= $Abreviation_Pays;

  return $Identifiant;
}

function getProductNumber($Nbre_Mbre_Actuel, $Abreviation_Pays){

        $Identifiant = 'PDT';

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


