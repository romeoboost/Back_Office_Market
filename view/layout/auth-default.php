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

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/materialadmin.css?000000001" />

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/font-awesome.min.css?1422823239" />

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/modules/materialadmin/css/theme-default/material-design-iconic-font.min.css?1422823240" />

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/loading-btn/loading.css?1422823240" />

            <link type="text/css" rel="stylesheet" href="<?php echo WEBROOT_URL; ?>assets/css/loading-btn/loading-btn.css?1422823240" />

    
        <!-- END STYLESHEETS -->


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
    <script type="text/javascript" src="http://www.codecovers.eu/assets/js/modules/materialadmin/libs/utils/html5shiv.js?1422823601"></script>
    <script type="text/javascript" src="http://www.codecovers.eu/assets/js/modules/materialadmin/libs/utils/respond.min.js?1422823601"></script>
    <![endif]-->
    </head>

    <body class="menubar-hoverable body-authentication header-fixed ">
    
    <!-- BEGIN LOGIN SECTION -->
    <section class="section-account">
        <div class="img-backdrop" style="background-image: url('<?php echo WEBROOT_URL; ?>assets/img/modules/materialadmin/about.jpg')"></div>
        <div class="spacer"></div>
        <span id="linkToLogin" class="hidden"><?php echo WEBROOT_URL.'ajax/logIn.php'; ?></span>
        <span id="linkToHome" class="hidden"><?php echo BASE_URL.DS.'accueil/index'; ?></span>

        <?php
             echo '' ;  
             echo $contain_for_layout;
             echo '';                     
        ?>


    </section>
    <!-- END LOGIN SECTION -->


    <!-- BEGIN JAVASCRIPT -->
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/spin.js/spin.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/autosize/jquery.autosize.min.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/libs/nanoscroller/jquery.nanoscroller.min.js"></script>

<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/App.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/App_own.js?<?php echo VERSION; ?>"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppNavigation.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppCard.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppForm.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppNavSearch.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/source/AppVendor.js"></script>
<script src="<?php echo WEBROOT_URL; ?>assets/js/modules/materialadmin/core/demo/Demo.js"></script>

<script type="text/javascript" src="<?php echo WEBROOT_URL; ?>assets/js/own-script.js?<?php echo VERSION; ?>"></script>
    
    <!-- END JAVASCRIPT -->

    </body>
</html>
