<!DOCTYPE HTML>

<html>
<head>
      <meta charset="UTF-8"/>
      <title><?php gettitle(); ?></title>
      <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css"/>
      <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css"/>      
      <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css"/> 
      <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css"/> 

      <link rel="stylesheet" href="<?php echo $css; ?>frontend.css"/>                 
                  

      </head>
    <body>
<div class="upper-bar">
   <div class="container">
<?php 
if(isset($_SESSION['user']))
{ ?>

<div class="btn-group my-info">
    <span class="btn btn-primary dropdown-toggle " data-toggle="dropdown">
      <img class="img-responsive img-thumbnail " src="new.png" alt="">
      <?php echo $_SESSION['user']?>
      <span class="caret"></span>
      </span>
      <ul class="dropdown-menu">
        <li><a href="profile.php">My Profile</a></li>
        <li><a href="newads.php">Add item</a></li>
        <li><a href="profile.php#my-item">My item</a></li>
        <li><a href="logout.php">logout</a></li>
      </ul>
      
</div>

  <?php
  
   
}
else
{?>


   <a href="login.php">
        <span class="pull-right">Login/Signup</span>
   </a>

   <?php }?>
   </div>
  
</div>



  <nav class="navbar navbar-inverse" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-nav">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php 
        $select = getAllFrom('*', 'categories','WHERE parent= 0',"",'ID',"");
        foreach($select as $cat)
        {
          echo '<li><a href="categories.php?catid='  . $cat['ID'] . '">' . $cat['Name'] .'</a> </li>';
        }
        ?>
       
      </ul>
     
     
     
    </div>
  </div>
</nav>