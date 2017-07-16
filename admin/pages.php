<?php
/*
     categories => [manage | Edit | Updata | Add | insert | delete |stat]
*/

$do ='';
if(isset($_GET['do']))
{
    $do = $_GET['do'];
}
else
{
  $do = 'manage';
}

//if the page is main page

if($do = 'manage')
{

}
elseif ($do == 'add')
{

}