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

        <link rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/from_front/css/flaticon.css?000000002" type="text/css" media="all">
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

<div class="headerbar">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="headerbar-left">
        <ul class="header-nav header-nav-options">
            <li class="header-nav-brand" >
                <div class="brand-holder">
                    <a href="../../materialadmin.1">
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
            <li class="dropdown hidden-xs">
                <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
                    <i class="fa fa-bell"></i><sup class="badge style-danger">4</sup>
                </a>
                <ul class="dropdown-menu animation-expand">
                    <li class="dropdown-header">Messages du jour</li>
                    <li>
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
                    <li><a href="../pages/login">Voir tous les messages<span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li>
                    <li><a href="../pages/login">Marquer comme lus<span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li>
                </ul><!--end .dropdown-menu -->
            </li><!--end .dropdown -->

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
                    <li><a href="#">Mon profile</a></li>
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
                    <a href="">
                        <span class="text-lg text-bold text-primary "><?php echo APPLI_NAME; ?></span>
                    </a>
                </div>
            </div>
            <div class="menubar-scroll-panel">
                <!-- BEGIN MAIN MENU -->
<ul id="main-menu" class="gui-controls">
    <!-- BEGIN DASHBOARD -->
    <li>
        <a href="" class="active">
            <div class="gui-icon"><i class="md md-assessment"></i></div>
            <span class="title">Tableau de bord</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END DASHBOARD -->
    
    <li class="">
        <a href="">
            <!-- <div class="gui-icon"><i class="md md-email"></i></div> -->
            <div class="gui-icon"><i class="fa fa-shopping-cart"></i></div>
            <span class="title">Commandes</span>
        </a>
    </li>
    
    <!-- BEGIN DASHBOARD -->
    <li>
        <a href="" >
            <div class="gui-icon"><i class="fa fa-users"></i></div>
            <span class="title">Clients</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END DASHBOARD -->
    
    <!-- BEGIN UI -->
    <li class="">
        <a href="">
            <div class="gui-icon"><i class=" flaticon-basket"></i></div>
            <span class="title">Produits</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END UI -->
    
    <!-- BEGIN TABLES -->
    <li class="">
        <a href="">
            <div class="gui-icon"><i class="glyphicon glyphicon-map-marker"></i></div>
            <span class="title">Communes Livraison</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END TABLES -->
    
    <!-- BEGIN FORMS -->
    <li class="">
        <a href="">
            <div class="gui-icon"><span class="md md-web"></span></div>
            <span class="title">Stocks</span>
        </a>
    </li>
    <!-- END FORMS -->
    
    <!-- BEGIN PAGES -->
    <li class="">
        <a href="">
            <div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
            <span class="title">Fournisseurs</span>
        </a>
    </li>
    <li class="">
        <a href="">
            <div class="gui-icon"><i class="fa fa-image"></i></div>
            <span class="title">Bannières publicitaires</span>
        </a>
    </li>
    <!--end /menu-li -->
    <!-- END FORMS -->
    
    <!-- BEGIN CHARTS -->
    <li>
        <a href="" >
            <div class="gui-icon"><i class="glyphicon glyphicon-comment"></i></div>
            <span class="title">Avis</span>
        </a>
    </li>

    <li>
        <a href="" >
            <div class="gui-icon"><i class="md md-email"></i></div>
            <span class="title">Mails</span>
        </a>
    </li>
    <!--end /menu-li -->
    <!-- END CHARTS -->
    
    <!-- BEGIN LEVELS -->
    <li class="gui-folder">
        <a>
            <div class="gui-icon"><i class="md md-settings"></i></div>
            <span class="title">Paramétrages</span>
        </a>
        <!--start submenu -->
        <ul>
            <li><a href=""><span class="title">Utilisateurs</span></a></li>
            <li><a href=""><span class="title">Profils</span></a></li>            
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
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/spin.js/spin.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/autosize/jquery.autosize.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/moment/moment.min.js"></script>
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
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/App.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppNavigation.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppOffcanvas.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppCard.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppForm.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppNavSearch.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppVendor.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/demo/Demo.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/demo/DemoDashboard.js"></script>

    
    <!-- END JAVASCRIPT -->

    

    </body>
</html>
