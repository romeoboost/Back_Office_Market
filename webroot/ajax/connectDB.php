<?php
$pdo = new PDO('mysql:dbname=market;host=localhost', 'root', '',
                             array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
//echo 'bd bien chargé';
