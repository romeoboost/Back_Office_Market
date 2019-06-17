<?php
class ProduitsController extends Controller {
    
    public function liste(){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';
      $_SESSION['bo_sub_menu'] = 'Produits';
      $d['numero_page_encours']=1;
      //Total produits
      $total = $this->Produits->findCountAll('produits');

      //Total stocke epuisé
       $produits_stock_off = $this->Produits->findCount( array( 'stock' => 0 ),'produits' );     

      //Total non commandé
      $produits_non_cmd = $this->Produits->findLeftJoin(array(
        'fieldsmain' => array('id AS id_p','nom AS nom_produit','token AS token_produit','quantite_unitaire as qtite_unit', 'id_unite as unite',
            'prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo','pourcentage_promo as percent_promo',
            'image as image'),
        'fieldstwo' => array('id_produit'),
        'fields' => array(array('main' => 'id','second' => 'id_produit')),
        'condition' => 'commandes_produits.id_produit IS NULL',
        'order' => array('champs' => 'produits.id' , 'param' => 'desc')
      ),'produits','commandes_produits');

      //total non actifs
      $produits_non_actif = $this->Produits->findCount( array( 'statut' => 0 ),'produits' );

      $d['produits_stat']['produits_non_cmd'] = count($produits_non_cmd);
      $d['produits_stat']['produits_non_actif'] = $produits_non_actif;
      $d['produits_stat']['produits_stock_off'] = $produits_stock_off;
      $d['produits_stat']['total'] = $total;

      $d['nombre_pages']=ceil($total / 10);
      // $d['nombre_pages']=1;
      // $d['numero_page_encours']=1;
      
      //Liste des produits
      $d['produits'] = $this->Produits->findJoin(array(
           'fieldsmain' => array('id AS id','nom AS nom_produit','token AS token_produit','quantite_unitaire as qtite_unit',
            'id_unite as unite','prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo',
            'pourcentage_promo as percent_promo','image as image','statut AS produit_statut','stock AS stock','date_creation as date_creation'),
            'fieldstwo' => array('nom AS categorie','statut AS categorie_statut'),
            'fieldsthree' => array('nom AS taille'),
            'fields' => array(
                          array(
                            'main' => 'id_categorie_produit',
                            'second' => 'id'
                            )
              ),
              'order' => array('champs' => 'prix_quantite_unitaire','param' => 'ASC'), //
              'limit' => '0,10'
            ),'produits','categories_produits');
      
      $d['unit_mesure'] = $this->unit_mesure();
      $d['categories'] = $this->get_category();
      // debug($d);
      $this->set($d);
    } 



    public function ajouter(){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';
      $_SESSION['bo_sub_menu'] = 'Produits';
      $d['unit_mesure'] = $this->unit_mesure();
      $d['categories'] = $this->get_category();
      // debug($d);
      $this->set($d);
    }

    private function get_livreur($id_livreur){
      $livreur = current ( $this->Commandes->find( array( 'fields' => 'id,nom,prenoms', 'condition' => 'id = '.$id_livreur )
                                ,'livreurs' ) );
      return $livreur;

    }

    private function unit_mesure(){
      //recuperer les unité de mésure
          $unites_from_bd = $this->Produits->find(array(
              'fields' => array('id','libelle','symbole')
            ),'unites');
          $unites = array();
          foreach ($unites_from_bd as $u) {
            $unites[$u->id] = ($u->symbole == 'NA') ? 'nombre' : $u->symbole;
          }

          return $unites;
    }

    private function get_category(){
      //recuperer les unité de mésure
          $category_from_bd = $this->Produits->find(array(
              'fields' => array('id','nom','statut')
            ),'categories_produits');
          $categories = array();
          // foreach ($category_from_bd as $u) {
          //   $categories[$u->id] = ($u->symbole == 'NA') ? 'nombre' : $u->symbole;
          // }

          return $category_from_bd;
    }

}
