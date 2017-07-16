<?php

include 'connect.php';

// routes

$tpl = 'includes/templates/';//templates directory
$css = 'layout/css/';//css directory
$func = 'includes/functions/';
$js = 'layout/js/';//js directory
$lang = 'includes/languages/';//languages directory  


//include the important files
include $func . 'function.php';
include  $lang . 'english.php';
include  $tpl . "header.php"; 

//include navbar on all pages expect the one with $nonavbar variables

 if ( !isset($nonavbar))
{
include  $tpl . "navbar.php"; 
}