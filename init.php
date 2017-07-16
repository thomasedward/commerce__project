<?php

//error reporting 
ini_set('display_errors' , 'on');
error_reporting(E_ALL);
include 'connect.php';
$sessionUser='';
if(isset($_SESSION['user']))
{
    $sessionUser=$_SESSION['user'];
}

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

