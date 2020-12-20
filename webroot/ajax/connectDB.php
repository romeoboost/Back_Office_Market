<?php
$pdo = new PDO('mysql:dbname=cisse_soft;host=localhost', 'root', '',
                             array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

define('WEBROOT_URL_FRONT', 'http://localhost/CISSE_SOFT/webroot/');
// define('WEBROOT_FRONT_DIR', 'C:\wamp\www\Market\webroot\\');
define('WEBROOT_FRONT_DIR', 'C:/wamp64/www/CISSE_SOFT/webroot/');
define('SITE_BASE_URL', 'http://localhost/CISSE_SOFT/');
define('BASE_URL', 'http://localhost/CISSE_SOFT/');
define('DS', '/');
//echo 'bd bien chargé';
