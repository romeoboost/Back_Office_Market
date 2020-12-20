<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Back Office - <?php echo APPLI_NAME; ?></title>

        <!-- BEGIN META -->
        <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="your,keywords">
        <meta name="description" content="Short explanation about this website">
        <!-- END META -->

        <!-- BEGIN STYLESHEETS -->
                <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/bootstrap.css?1422823238" />

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/materialadmin.css?<?php echo VERSION; ?>" />

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/font-awesome.min.css?1422823239" />

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/material-design-iconic-font.min.css?1422823240" />

    
        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/rickshaw/rickshaw.css?1422823372" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/morris/morris.core.css?1422823370" />
        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/select2/select2.css?1422823373" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/multi-select/multi-select.css?1422823371" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1422823364" />
        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/forDatetimepicker/bootstrap-datetimepicker.css?1422823364" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/jquery-ui/jquery-ui-theme.css?1422823370" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/bootstrap-colorpicker/bootstrap-colorpicker.css?1422823362" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1422823365" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/typeahead/typeahead.css?1422823375" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/dropzone/dropzone-theme.css?1422823366" />

        <link rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/from_front/css/flaticon.css?000000003" type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/from_front/css/sweetalert2.min.css?000000003" type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/from_front/css/bootstrap_select.min.css?000000003" type="text/css" media="all">
        
        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/loading-btn/loading.css?1422823240" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/loading-btn/loading-btn.css?1422823240" />

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/materialadmin_print.css?1422823243"  media="print"/>

        <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote.css?1422823374" />
        <!-- END STYLESHEETS -->


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
    <script type="text/javascript" src="http://www.codecovers.eu/assets/js/modules/materialadmin/libs/utils/html5shiv.js?1422823601"></script>
    <script type="text/javascript" src="http://www.codecovers.eu/assets/js/modules/materialadmin/libs/utils/respond.min.js?1422823601"></script>
    <![endif]-->
    </head>

<body class="menubar-hoverable header-fixed ">
        <!-- BEGIN HEADER-->
<header id="header" >
    <span id="linkToAddToCart" class="hidden"><?php echo WEBROOT_URL.'ajax/ajoutPanier.php'; ?></span>
    <span id="linkToDeleteToCart" class="hidden"><?php echo WEBROOT_URL.'ajax/supprimerPanier.php'; ?></span>
    <span id="linkToAddCustomerToCart" class="hidden"><?php echo WEBROOT_URL.'ajax/ajoutClientPanier.php'; ?></span>
    <span id="linkToDeleteCustomerToCart" class="hidden"><?php echo WEBROOT_URL.'ajax/supprimerClientPanier.php'; ?></span>
    <span id="linkToUpdateToCart" class="hidden"><?php echo WEBROOT_URL.'ajax/modifPanier.php'; ?></span>
    

    <span id="linkToStatOrder" class="hidden"><?php echo WEBROOT_URL.'ajax/statOrder.php'; ?></span>
    <span id="linkToStatCustomer" class="hidden"><?php echo WEBROOT_URL.'ajax/statCustomer.php'; ?></span>
    <span id="linkToStatProducts" class="hidden"><?php echo WEBROOT_URL.'ajax/statProducts.php'; ?></span>
    <span id="linkToSearchOrders" class="hidden"><?php echo WEBROOT_URL.'ajax/searchOrders.php'; ?></span>
    <span id="linkToSearchQuickOrders" class="hidden"><?php echo WEBROOT_URL.'ajax/searchQuickOrders.php'; ?></span>
    <span id="linkToSetConfirmOrderDelivrery" class="hidden"><?php echo WEBROOT_URL.'ajax/setConfirmOrderDelivrery.php'; ?></span>
    <span id="linkToSetConfirmQuickOrderDelivrery" class="hidden"><?php echo WEBROOT_URL.'ajax/setConfirmQuickOrderDelivrery.php'; ?></span>
    <span id="linkToSetOrderDelivrery" class="hidden"><?php echo WEBROOT_URL.'ajax/setOrderDelivrery.php'; ?></span>
    <span id="linkToSetQuickOrderDelivrery" class="hidden"><?php echo WEBROOT_URL.'ajax/setQuickOrderDelivrery.php'; ?></span>
    <span id="linkToSetStopQuickOrderDelivrery" class="hidden"><?php echo WEBROOT_URL.'ajax/setStopQuickOrderDelivrery.php'; ?></span>
    <span id="linkToGetLivreur" class="hidden"><?php echo WEBROOT_URL.'ajax/getLivreur.php'; ?></span>
    <span id="linkToGetQuickLivreur" class="hidden"><?php echo WEBROOT_URL.'ajax/getQuickLivreur.php'; ?></span>
    <span id="linkToSetStopOrderDelivrery" class="hidden"><?php echo WEBROOT_URL.'ajax/setStopOrderDelivrery.php'; ?></span>
    <span id="linkToRejectOrder" class="hidden"><?php echo WEBROOT_URL.'ajax/rejectOrder.php'; ?></span>
    <span id="linkToRejectQuickOrder" class="hidden"><?php echo WEBROOT_URL.'ajax/rejectQuickOrder.php'; ?></span>
    <span id="linkToRestoreOrder" class="hidden"><?php echo WEBROOT_URL.'ajax/restoreOrder.php'; ?></span>
    <span id="linkToRestoreQuickOrder" class="hidden"><?php echo WEBROOT_URL.'ajax/restoreQuickOrder.php'; ?></span>
    <span id="linkToDeleteOrder" class="hidden"><?php echo WEBROOT_URL.'ajax/deleteOrder.php'; ?></span>
    <span id="linkToDeleteQuickOrder" class="hidden"><?php echo WEBROOT_URL.'ajax/deleteQuickOrder.php'; ?></span>
    <span id="linkToSearchProducts" class="hidden"><?php echo WEBROOT_URL.'ajax/searchProducts.php'; ?></span>
    <span id="linkToSearchCategory" class="hidden"><?php echo WEBROOT_URL.'ajax/searchCategory.php'; ?></span>
    <span id="linkToAddProduct" class="hidden"><?php echo WEBROOT_URL.'ajax/AddProduct.php'; ?></span>
    <span id="linkToUpdateProduct" class="hidden"><?php echo WEBROOT_URL.'ajax/updateProduct.php'; ?></span>
    <span id="linkToDeleteProduct" class="hidden"><?php echo WEBROOT_URL.'ajax/deleteProduct.php'; ?></span>
    <span id="linkToAddCategory" class="hidden"><?php echo WEBROOT_URL.'ajax/AddCategory.php'; ?></span>
    <span id="linkToUpdateCategory" class="hidden"><?php echo WEBROOT_URL.'ajax/UpdateCategory.php'; ?></span>
    <span id="linkToDeleteCategory" class="hidden"><?php echo WEBROOT_URL.'ajax/DeleteCategory.php'; ?></span>
    <span id="linkToSearchClients" class="hidden"><?php echo WEBROOT_URL.'ajax/SearchClients.php'; ?></span>
    <span id="linkToRejectClients" class="hidden"><?php echo WEBROOT_URL.'ajax/RejectClients.php'; ?></span>
    <span id="linkToRestoreClients" class="hidden"><?php echo WEBROOT_URL.'ajax/RestoreClients.php'; ?></span>
    <span id="linkToDeleteClients" class="hidden"><?php echo WEBROOT_URL.'ajax/DeleteClients.php'; ?></span>
    <span id="linkToSearchStocks" class="hidden"><?php echo WEBROOT_URL.'ajax/SearchStocks.php'; ?></span>
    <span id="linkToAddStock" class="hidden"><?php echo WEBROOT_URL.'ajax/AddStock.php'; ?></span>
    <span id="linkToUpdateStock" class="hidden"><?php echo WEBROOT_URL.'ajax/UpdateStock.php'; ?></span>
    <span id="linkToDeleteStock" class="hidden"><?php echo WEBROOT_URL.'ajax/DeleteStock.php'; ?></span>
    <span id="linkToSearchFournisseurs" class="hidden"><?php echo WEBROOT_URL.'ajax/SearchFournisseurs.php'; ?></span>
    <span id="linkToAddFournisseur" class="hidden"><?php echo WEBROOT_URL.'ajax/AddFournisseur.php'; ?></span>
    <span id="linkToUpdateSupplier" class="hidden"><?php echo WEBROOT_URL.'ajax/UpdateSupplier.php'; ?></span>
    <span id="linkToDeleteSupplier" class="hidden"><?php echo WEBROOT_URL.'ajax/DeleteSupplier.php'; ?></span>
    <span id="linkToAddCity" class="hidden"><?php echo WEBROOT_URL.'ajax/AddCity.php'; ?></span>
    <span id="linkToUpdateCity" class="hidden"><?php echo WEBROOT_URL.'ajax/UpdateCity.php'; ?></span>
    <span id="linkToDeleteCity" class="hidden"><?php echo WEBROOT_URL.'ajax/DeleteCity.php'; ?></span>
    <span id="linkToUpdateAdminPassword" class="hidden"><?php echo WEBROOT_URL.'ajax/UpdateAdminPassword.php'; ?></span>


    <span id="linkToWebroot" class="hidden"><?php echo WEBROOT_URL; ?></span>

<div class="headerbar">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="headerbar-left">
        <ul class="header-nav header-nav-options">
            <li class="header-nav-brand" >
                <div class="brand-holder">
                    <a href="<?php echo BASE_URL.DS.'accueil/index'; ?>">
                        <span class="text-lg text-bold text-primary"><?php echo APPLI_NAME; ?></span>
                    </a>
                </div>
            </li>
            <li>
                <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="headerbar-right">
        <ul class="header-nav header-nav-options">
            <!-- Search form -->
            <!-- <li>
                
                <form class="navbar-search" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" name="headerSearch" placeholder="Enter your keyword">
                    </div>
                    <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                </form>
            </li> -->

            <li class="dropdown hidden-xs cart-header">
                <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
                    <i class="md md-add-shopping-cart"></i>
                    <?php $NbreCart= isset( $_SESSION['cart']['total_nbre'] ) ? $_SESSION['cart']['total_nbre'] : "0" ?>
                    <sup class="mini-cart-icon badge style-danger"><?php echo $NbreCart ?></sup>
                </a>
                <ul class="dropdown-menu animation-expand widget-shopping-cart-container">
                    <!-- <li class="dropdown-header">Messages du jour</li> -->

                    <li class="widget-shopping-cart-content">
                        <ul class="cart-list">
                        <?php if( !isset($_SESSION['cart']['products_list']) || empty($_SESSION['cart']['products_list']) ) { ?>
                            <div class="empty-cart text-center col-md-12"> 
                                Votre panier est vide 
                            </div>
                        <?php }else{ ?>
                            <?php foreach ($_SESSION['cart']['products_list'] as $token => $p): ?>
                                <li class="<?php echo $token; ?>" id-product="<?php echo $token; ?>" >
                                    <!-- <a href="#" class="remove">×</a> -->
                                    <a href="" class="remove remove-product-cart" id-product="<?php echo $token; ?>">×</a>
                                    <a href="<?php echo $p['link_to_details']; ?>">
                                        <img src="<?php echo $p['link_to_image']; ?>" alt="" />
                                        <?php echo $p['nom']; ?> &nbsp;
                                    </a>
                                    <span class="quantity">
                                        <span class="nbre-cart-product"><?php echo $p['qtite_cart']; ?></span> x
                                        <span class="amount-cart-product"><?php echo $p['prix_qtite_unit']; ?></span> F
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        <?php } ?>
                        </ul>
                        <p class="total">
                            <strong>Sous Total:</strong> 
                            <span class="amount">
                                <?php echo isset( $_SESSION['cart']['total_amount'] ) ? $_SESSION['cart']['total_amount'] : "0" ?> F
                            </span>
                        </p>
                        <p class="header-cart-customer-info">
                            <strong>
                                Le client :
                                <span class="header-cart-customer-name">
                                    <?php echo isset( $_SESSION['cart']['customer'] ) ? $_SESSION['cart']['customer']['name'] : "Aucun client" ?> 
                                </span> 
                        
                            </strong>

                            <span class="header-cart-customer-action">
                                <?php if( isset( $_SESSION['cart']['customer'] ) ){ ?>
                                    <a class="header-cart-add-customer delete-pusher"
                                        title="retirer le client"> 
                                        <i class="fa fa-times-circle-o"></i>
                                    </a>
                                    <a class="header-cart-add-customer update-pusher"
                                        title="changer le client"> 
                                        <i class="fa fa-pencil"></i>
                                    </a>                                    
                                <?php }else{ ?>
                                    <a class="header-cart-add-customer add-pusher" 
                                        title="ajouter un client"> 
                                        <i class="fa fa-user-plus"></i> 
                                    </a>
                                <?php } ?>
                            </span>
                            
                        </p>
                        <p class="buttons">
                            <a href="<?php echo SITE_BASE_URL ; ?>commandes/cart" class="view-cart">
                                Le Panier
                            </a>
                            <a href="<?php echo SITE_BASE_URL ; ?>commandes/send_cart_to_validation"
                                class="order-connect-btn order-cmd-button-base">
                                    ENREGISTRER
                            </a>
                        </p>
                    </li>

                    <!-- <li>
                        <a class="alert alert-callout alert-warning" href="javascript:void(0);">
                            <strong>Alex Anistor</strong><br/>
                            <small>Testing functionality...</small>
                        </a>
                    </li>
                    <li>
                        <a class="alert alert-callout alert-info" href="javascript:void(0);">
                            <strong>Alicia Adell</strong><br/>
                            <small>Reviewing last changes...</small>
                        </a>
                    </li>
                    <li class="dropdown-header">Options</li>
                    <li><a href="">Voir tous les messages<span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li>
                    <li><a href="">Marquer comme lus<span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li> -->
                </ul><!--end .dropdown-menu -->
            </li>
            <!--end .dropdown -->


            <!--end .dropdown -->
        </ul><!--end .header-nav-options -->
        <ul class="header-nav header-nav-profile">
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                    <img src="<?php echo WEBROOT_URL; ?>images/admin_black_cravate.png?1422538623" alt="" />
                    <span class="profile-info">
                        <?php echo $_SESSION['bo_user']['nom'].' '.$_SESSION['bo_user']['prenoms']; ?>
                        <small>Admin</small>
                    </span>
                </a>
                <ul class="dropdown-menu animation-dock">
                    <!-- <li class="dropdown-header">Configs</li> -->
                    <li><a href="<?php echo BASE_URL.DS.'accueil/modifier_password'; ?>">Modifier Mot de passe</a></li>
                    <li class="divider"></li>
                    <!-- <li><a href="../pages/locked"><i class="fa fa-fw fa-lock"></i> Lock</a></li> -->
                    <li>
                        <a href="<?php echo BASE_URL.DS.'accueil/deconnect'; ?>">
                            <i class="fa fa-fw fa-power-off text-danger"></i> 
                            Deconnexion
                        </a>
                    </li>
                </ul><!--end .dropdown-menu -->
            </li><!--end .dropdown -->
        </ul><!--end .header-nav-profile -->
        
    </div><!--end #header-navbar-collapse -->
</div>
            </header>
    <!-- END HEADER-->

    <!-- BEGIN BASE-->
    <div id="base">
        <!-- BEGIN OFFCANVAS LEFT -->
        <div class="offcanvas">
                    </div><!--end .offcanvas-->
        <!-- END OFFCANVAS LEFT -->

        <?php

            
             echo '' ;  
             echo $contain_for_layout;
             echo '';
                                          
        ?>

        <!-- BEGIN MENUBAR-->
        <div id="menubar" class="menubar-inverse ">
            <div class="menubar-fixed-panel">
                <div>
                    <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <div class="expanded">
                    <a href="<?php echo BASE_URL.DS.'accueil/index'; ?>">
                        <span class="text-lg text-bold text-primary "><?php echo APPLI_NAME; ?></span>
                    </a>
                </div>
            </div>
            <div class="menubar-scroll-panel">
                <!-- BEGIN MAIN MENU -->
<ul id="main-menu" class="gui-controls">
    <!-- BEGIN DASHBOARD -->
    <li>
        <a href="<?php echo BASE_URL.DS.'dashboard/index'; ?>" class=" <?php echo active_menu('Dashboard'); ?> ">
            <div class="gui-icon"><i class="md md-assessment"></i></div>
            <span class="title">Tableau de bord</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END DASHBOARD -->
    
    <li class="gui-folder <?php echo active_menu('Commandes'); ?>">
        <a>
            <div class="gui-icon"><i class="fa fa-shopping-cart"></i></div>
            <span class="title">Commandes</span>
        </a>
        <ul>
            <li class="<?php echo active_sub_menu('Commandes'); ?>">
                <a href="<?php echo BASE_URL.DS.'commandes/init_order'; ?>">
                    <span class="title <?php echo active_sub_menu('Init'); ?>">Créer une commande</span>
                </a>
            </li>
            <li class="<?php echo active_sub_menu('Commandes'); ?>">
                <a href="<?php echo BASE_URL.DS.'commandes/liste'; ?>">
                    <span class="title">Toutes les commandes</span>
                </a>
            </li>
            <li class="<?php echo active_sub_menu('Commandes'); ?>">
                <a href="<?php echo BASE_URL.DS.'commandes/liste_to_validation'; ?>">
                    <span class="title">Commandes à Valider</span>
                </a>
            </li>
            <li class="<?php echo active_sub_menu('Commandes'); ?>">
                <a href="<?php echo BASE_URL.DS.'commandes/liste_to_pay'; ?>">
                    <span class="title">Commandes à Payer</span>
                </a>
            </li>        
        </ul>
    </li>

    <!-- BEGIN DASHBOARD -->
    <li class="<?php echo active_menu('Clients'); ?>">
        <a href="<?php echo SITE_BASE_URL.'clients/liste'; ?>" >
            <div class="gui-icon"><i class="fa fa-users"></i></div>
            <span class="title">Clients</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END DASHBOARD -->
    
    <!-- BEGIN UI -->
    <li class="gui-folder <?php echo active_menu('Produits'); ?>">
        <a >
            <div class="gui-icon"><i class=" flaticon-basket"></i></div>
            <span class="title">Produits</span>
        </a>
        <ul>
            <li class="<?php echo active_sub_menu('Produits'); ?>">
                <a href="<?php echo BASE_URL.DS.'produits/liste'; ?>"><span class="title <?php echo active_sub_menu('Produits'); ?>">Les Produits</span></a>
            </li>
            <li class="<?php echo active_sub_menu('Categories'); ?>">
                <a href="<?php echo BASE_URL.DS.'categories/liste'; ?>">
                    <span class="title">Les Catégories</span>
                </a>
            </li>
            <li class="<?php echo active_sub_menu('unitesMesure'); ?>">
                <a href="<?php echo BASE_URL.DS.'unitesMesure/liste'; ?>"><span class="title <?php echo active_sub_menu('unitesMesure'); ?>">Les Unités De Mésure</span></a>
            </li>            
        </ul>
    </li><!--end /menu-li -->
    <!-- END UI -->
    
    <!-- BEGIN FORMS -->
    <li class="<?php echo active_menu('Stocks'); ?>">
        <a href="<?php echo BASE_URL.DS.'stocks/liste'; ?>">
            <div class="gui-icon"><span class="md md-web"></span></div>
            <span class="title">Stocks</span>
        </a>
    </li>
    <!-- END FORMS -->

     <!-- BEGIN FORMS -->
    <li class="<?php echo active_menu('Magasins'); ?>">
        <a href="<?php echo BASE_URL.DS.'magasins/liste'; ?>">
            <div class="gui-icon"><span class="md md-store-mall-directory"></span></div>
            <span class="title">Magasins</span>
        </a>
    </li>
    <!-- END FORMS -->
    
    <!-- BEGIN PAGES -->
    <li class="<?php echo active_menu('Fournisseurs'); ?>">
        <a href="<?php echo BASE_URL.DS.'fournisseurs/liste'; ?>">
            <div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
            <span class="title">Fournisseurs</span>
        </a>
    </li>
    
    
    <!-- BEGIN LEVELS -->
    <li class="gui-folder">
        <a >
            <div class="gui-icon"><i class="md md-settings"></i></div>
            <span class="title">Paramétrages</span>
        </a>
        <!--start submenu -->
        <ul>
            <li><a href="<?php echo BASE_URL.DS.'utilisateurs/liste'; ?>"><span class="title">Utilisateurs</span></a></li>
            <!-- <li><a href="<?php echo BASE_URL.DS.'profils/liste'; ?>"><span class="title">Profils</span></a></li>             -->
        </ul><!--end /submenu -->
    </li><!--end /menu-li -->
    <!-- END LEVELS -->
    
</ul><!--end .main-menu -->
                <!-- END MAIN MENU -->

                <div class="menubar-foot-panel">
                    <small class="no-linebreak hidden-folded">
                        <span class="opacity-75">Copyright &copy; 2019</span> <strong><?php echo APPLI_NAME; ?></strong>
                    </small>
                </div>
            </div><!--end .menubar-scroll-panel-->
        </div><!--end #menubar-->
        <!-- END MENUBAR -->


        
        <!-- BEGIN OFFCANVAS RIGHT -->
        <div class="offcanvas">

<!-- START MODAL ADD CLIENT TO CART -->
<div class="modal own-modal fade" id="modal-add-customer-to-cart" tabindex="-1" role="dialog" 
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> AJOUTER UN CLIENT AU PANIER</h4>
      </div>
      <form id="form-add-customer-to-cart" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    Selectionner le nom du client ou son numero de téléphone
                </em>
            </div>
            
            <div class="card-body ">
                <div id="" class="col-md-12 text-center errorForm"></div>

                <?php 
                    $token_client_used = isset( $_SESSION['cart']['customer']['token'] ) ? $_SESSION['cart']['customer']['token'] : '';
                ?>
                
                <?php $liste = $this->request('Clients', 'getListe'); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group ">
                            <select id="select2" name="client" class="form-control dirty selectpicker" 
                                data-live-search="true">
                                <option value="" >&nbsp;</option>
                                <?php foreach( $liste as $client ): ?>
                                    <option value="<?php echo $client->token; ?>"
                                        <?php echo ( $token_client_used == $client->token ) ? 'selected' : ''; ?>>
                                        <?php 
                                            echo $client->tel.' - '.ucfirst($client->nom).' '.ucfirst($client->prenoms).''; 
                                        ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="select2">Téléphone - Nom et Prénom des clients</label>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="actioner" value="">

            </div>


        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                        CONFIRMER
                        <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
      </div>
      </form>

    </div>
  </div>
</div>
<!-- END MODAL ADD CLIENT TO CART -->


<!-- BEGIN OFFCANVAS SEARCH -->
<div id="offcanvas-search" class="offcanvas-pane width-8">
    <div class="offcanvas-head">
        <header class="text-primary">Search</header>
        <div class="offcanvas-tools">
            <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                <i class="md md-close"></i>
            </a>
        </div>
    </div>

    <div class="offcanvas-body no-padding">
        <ul class="list ">
            <li class="tile divider-full-bleed">
                <div class="tile-content">
                    <div class="tile-text"><strong>A</strong></div>
                </div>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar4.jpg?1422538625" alt="" />
                    </div>
                    <div class="tile-text">
                        Alex Nelson
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar9.jpg?1422538626" alt="" />
                    </div>
                    <div class="tile-text">
                        Ann Laurens
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile divider-full-bleed">
                <div class="tile-content">
                    <div class="tile-text"><strong>J</strong></div>
                </div>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar2.jpg?1422538624" alt="" />
                    </div>
                    <div class="tile-text">
                        Jessica Cruise
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar8.jpg?1422538626" alt="" />
                    </div>
                    <div class="tile-text">
                        Jim Peters
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile divider-full-bleed">
                <div class="tile-content">
                    <div class="tile-text"><strong>M</strong></div>
                </div>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar5.jpg?1422538625" alt="" />
                    </div>
                    <div class="tile-text">
                        Mabel Logan
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar11.jpg?1422538623" alt="" />
                    </div>
                    <div class="tile-text">
                        Mary Peterson
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar3.jpg?1422538624" alt="" />
                    </div>
                    <div class="tile-text">
                        Mike Alba
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile divider-full-bleed">
                <div class="tile-content">
                    <div class="tile-text"><strong>N</strong></div>
                </div>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar6.jpg?1422538626" alt="" />
                    </div>
                    <div class="tile-text">
                        Nathan Peterson
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile divider-full-bleed">
                <div class="tile-content">
                    <div class="tile-text"><strong>P</strong></div>
                </div>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar7.jpg?1422538626" alt="" />
                    </div>
                    <div class="tile-text">
                        Philip Ericsson
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
            <li class="tile divider-full-bleed">
                <div class="tile-content">
                    <div class="tile-text"><strong>S</strong></div>
                </div>
            </li>
            <li class="tile">
                <a class="tile-content ink-reaction" href="../../materialadmin.1#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
                    <div class="tile-icon">
                        <img src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar10.jpg?1422538623" alt="" />
                    </div>
                    <div class="tile-text">
                        Samuel Parsons
                        <small>123-123-3210</small>
                    </div>
                </a>
            </li>
        </ul>
    </div><!--end .offcanvas-body -->
</div><!--end .offcanvas-pane -->
<!-- END OFFCANVAS SEARCH -->

            


<!-- BEGIN OFFCANVAS CHAT -->
<div id="offcanvas-chat" class="offcanvas-pane style-default-light width-12">
    <div class="offcanvas-head style-default-bright">
        <header class="text-primary">Chat with Ann Laurens</header>
        <div class="offcanvas-tools">
            <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                <i class="md md-close"></i>
            </a>
            <a class="btn btn-icon-toggle btn-default-light pull-right" href="../../materialadmin.1#offcanvas-search" data-toggle="offcanvas" data-backdrop="false">
                <i class="md md-arrow-back"></i>
            </a>
        </div>
        <form class="form">
            <div class="form-group floating-label">
                <textarea name="sidebarChatMessage" id="sidebarChatMessage" class="form-control autosize" rows="1"></textarea>
                <label for="sidebarChatMessage">Leave a message</label>
            </div>
        </form>
    </div>

    <div class="offcanvas-body">
        <ul class="list-chats">
            <li>
                <div class="chat">
                    <div class="chat-avatar"><img class="img-circle" src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar1.jpg?1422538623" alt="" /></div>
                    <div class="chat-body">
                        Yes, it is indeed very beautiful.
                        <small>10:03 pm</small>
                    </div>
                </div><!--end .chat -->
            </li>
            <li class="chat-left">
                <div class="chat">
                    <div class="chat-avatar"><img class="img-circle" src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar9.jpg?1422538626" alt="" /></div>
                    <div class="chat-body">
                        Did you see the changes?
                        <small>10:02 pm</small>
                    </div>
                </div><!--end .chat -->
            </li>
            <li>
                <div class="chat">
                    <div class="chat-avatar"><img class="img-circle" src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar1.jpg?1422538623" alt="" /></div>
                    <div class="chat-body">
                        I just arrived at work, it was quite busy.
                        <small>06:44pm</small>
                    </div>
                    <div class="chat-body">
                        I will take look in a minute.
                        <small>06:45pm</small>
                    </div>
                </div><!--end .chat -->
            </li>
            <li class="chat-left">
                <div class="chat">
                    <div class="chat-avatar"><img class="img-circle" src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar9.jpg?1422538626" alt="" /></div>
                    <div class="chat-body">
                        The colors are much better now.
                    </div>
                    <div class="chat-body">
                        The colors are brighter than before.
                        I have already sent an example.
                        This will make it look sharper.
                        <small>Mon</small>
                    </div>
                </div><!--end .chat -->
            </li>
            <li>
                <div class="chat">
                    <div class="chat-avatar"><img class="img-circle" src="<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/avatar1.jpg?1422538623" alt="" /></div>
                    <div class="chat-body">
                        Are the colors of the logo already adapted?
                        <small>Last week</small>
                    </div>
                </div><!--end .chat -->
            </li>
        </ul>
    </div><!--end .offcanvas-body -->
</div><!--end .offcanvas-pane -->
<!-- END OFFCANVAS CHAT -->

                    </div><!--end .offcanvas-->
        <!-- END OFFCANVAS RIGHT -->

    </div><!--end #base-->
    <!-- END BASE -->


    <!-- BEGIN JAVASCRIPT -->
        
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/spin.js/spin.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/autosize/jquery.autosize.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/inputmask/jquery.inputmask.bundle.min.js"></script>

<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/moment/moment.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/libs/forDatetimePicker/moment-with-locales.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/libs/forDatetimePicker/bootstrap-datetimepicker.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>

<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/flot/jquery.flot.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/flot/jquery.flot.orderBars.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/flot/jquery.flot.pie.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/flot/curvedLines.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/d3/d3.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/d3/d3.v3.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/rickshaw/rickshaw.min.js"></script>

<script src="<?php echo WEBROOT_URL; ?>assets/js/libs/Chart.js-master/dist/Chart.min.js"></script>


<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/App.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppNavigation.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppOffcanvas.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppCard.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppForm.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppNavSearch.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppVendor.js"></script>

<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/demo/Demo.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/demo/DemoFormComponents.js"></script>

<script type="text/javascript" src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/summernote/summernote.min.js"></script>

<script type="text/javascript" src="<?php echo WEBROOT_URL; ?>assets/js/own-script.js?<?php echo VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo WEBROOT_URL; ?>assets/js/sweetalert2.min.js?<?php echo VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo WEBROOT_URL; ?>assets/js/bootstrap_select.min.js?<?php echo VERSION; ?>"></script>



    
    <!-- END JAVASCRIPT -->

    

    </body>
</html>
