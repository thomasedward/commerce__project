<?php 

$nonavbar='';
$pagetitle = 'login ';
session_start();
if (isset($_SESSION['Username']))
{

      header('location:home.php');//go to home page

}

include 'init.php';



// check If user coming from http request

if ( $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = $_POST['user'];
    $password = $_POST['pass'];
    // for encerption password
    $hashedpass = sha1($password);

//check if the user exists in database
//do select
$stmt = $connect->prepare("SELECT userID,Username,Password FROM Users WHERE Username=? AND Password=? AND GroupID=1 LIMIT 1");

//execute select
$stmt->execute(array($username , $hashedpass));
//save select in array
$row = $stmt->fetch();
$count = $stmt->rowCount();



//if count > 0 this mean the database contain record about this user 


if( $count > 0)
{
  $_SESSION['Username'] = $username;//regiseter session
  $_SESSION['ID'] = $row['userID'];//REgiset session id 
  header('location:home.php');//go to home page
  exit();
}


}


?>



<form class="login" /*for take user & pass with post */ action="<?php echo $_SERVER['PHP_SELF'] ?>"  method="POST">
<h4 class="text-center">Admin login<h4>
<input class="form-control inpur-lg" type="text" name="user" placeholder="user name" autocomplete="off"/>
<input class="form-control inpur-lg" type="password" name="pass" placeholder="password" autocomplete="new_password"/>
<input class="btn btn-primary btn-block" type="submit" value="login" />
</form>



<?php
 include $tpl .  "footer.php"; 
 ?>