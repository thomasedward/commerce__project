<?php
session_start(); 
$pagetitle=" Login / Sin up ";
if (isset($_SESSION['user']))
{
    header('location : index.php'); 
    exit();
}
include 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['login']))
    {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $enpass = sha1($pass);

    $stmt= $connect->prepare("SELECT Username,Password,userID
                             FROM users 
                             WHERE Username=? AND Password=?");
    $stmt->execute(array($user,$enpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0)
    {
        $_SESSION['user']=$user;
        $_SESSION['uid']=$row['userID'];
        header('location:index.php');
        exit();
    }
    }
    else
    {
        $user      = $_POST['username'];
        $password  = $_POST['password'];
        $password2 = $_POST['password2'];
        $email     = $_POST['email'];
        $formerrors=array();
        if(isset($user ))
        {
            $filteruser=filter_var($user,FILTER_SANITIZE_STRING);
            if(strlen($filteruser) < 4)
            {
                $formerrors[] = 'less than 4  ';

            }
            
            
        }
        if(isset($password) && isset($password2))
        {
            if(empty($password))
            {
                $formerrors[] = 'sorry password cant be empty';
            }
            $pass1=sha1($password);
            $pass2=sha1($password2);
            if( $pass1 !== $pass2 )
            {
               $formerrors[] = ' password not match  ';
            }
           
        }
        if(isset($email))
        {
            $filteremail=filter_var($email,FILTER_SANITIZE_EMAIL);
            if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true )
            {
               $formerrors[] = ' email not right  ';
            }
            
        }
        
      if(empty( $formerrors ))
      {  

            $check = checkitem("Username","users",$filteruser);

            if ($check == 1)
            {

            $formerrors[] = 'ohhh !  user name unique please change ';
             
            }
            else {
            $stmtadd = $connect->prepare("INSERT INTO  users(Username,Password, Email,Registereddata) 
                                       VALUES (:name,:pass,:email,now())") ;
            $stmtadd->execute(array( 
              'name'  => $filteruser , 
              'pass'  => $pass1 ,
              'email' => $email 
              ));
            
            $count = $stmtadd->rowCount();

            if ($count > 0)
        {

         $formerrors[] ='  register done ';
      
        }
      else 
      {
        $formerrors[] = 'No register done ';
              }
      }
      } 




    }                         
}






?>

<div class="container login-page">
    <h1 class="text-center">
        <span data-class="login" class="selected">Login</span>  |  <span data-class="signup">Sign up</span>
    </h1>
    <!-- start login form -->
    <form class="login" action="<?php ECHO $_SERVER['PHP_SELF']?>" method="POST">
      <input class="form-control" type="text" name="username" autocomplete="off" placeholder="type your user name " required="required">
      <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type your password "required="required">
      <input class="btn btn-primary btn-block" name="login" type="submit" value="Login" >


    </form>
     <!-- end login form -->
      <!-- start signup form -->
     <form class="signup" action="<?php ECHO $_SERVER['PHP_SELF']?>" method="POST">
      <input class="form-control" type="text" name="username" autocomplete="off" placeholder="type your user name "required="required">
      <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type your password "required="required">
      <input class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="type your password again"required="required">
      <input class="form-control" type="email" name="email" placeholder="type your email"required="required">
      <input class="btn btn-success btn-block" name="signup" type="submit" value="Sign Up" >


    </form>

    <div class="the-errors text-center">

                <?php
                if(!empty($formerrors))
                {
                    
                    foreach($formerrors as $error)
                    {

                        echo '<div class="alert alert-danger" role="alert">' . $error . ' </div>';

                    }
                }
 



                ?>
    </div>
    <!-- end signup form -->
</div>

<?php 
include $tpl . 'footer.php';
?>