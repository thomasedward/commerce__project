<?php 
ob_start();
session_start();

if (isset($_SESSION['Username']))
{
    
  $pagetitle = ' Home ';
  include 'init.php';

/* start home page */

?>

<div class="container home-stats text-center">
<h1>Home Page</h1>
<div class="row">
  <div class="col-sm-3">
     <div class="stat st-members">
     <i class="fa fa-users"></i>
    <div class="info">
     Total Member
      <a href="member.php"> <span>
      <?php $num =  countitem('userID' ,'users');
      echo $num;
      ?>
       <span></a>
       </div>
     </div>
     
  </div>
  <div class="col-sm-3">
     <div class="stat st-pend-members">
         <i class="fa fa-plus"></i>

       <div class="info">

         Pending Member
<a href="member.php?do=manage&page=pending"> 
      <span>
      <?php echo checkitem('RegStatus','users',0)
      /*  by updata countitem v1.1
      $num =  countitem('userID','users','WHERE RegStatus = 0');
      echo $num;*/
      ?>
       <span></a>
       </div>
     </div>
    
  </div>
  <div class="col-sm-3">
     <div class="stat st-items">
       
         <i class="fa fa-tag"></i>
       <div class="info">

Total items
      <a href="items.php"> <span>
      <?php echo countitem('item_ID','items');
      /*  by updata countitem v1.1
      $num =  countitem('userID','users','WHERE RegStatus = 0');
      echo $num;*/
      ?>
       <span></a>

       </div>
     </div>
     
  </div>
  <div class="col-sm-3">
     <div class="stat st-comments">
  <i class="fa fa-comments"></i>
       <div class="info">
Total comments
      <a href="comments.php"> <span>
      <?php $num =  countitem('c_id' ,'comments');
      echo $num;
      ?>
       <span></a>

       </div>
     </div>
    
  </div>
</div>

</div>


<div class="container latest">
  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">
       <div class="panel-heading">
         <i class="fa fa-users"></i> Laster users
       <span class="toggle-info pull-right">
         <i class="fa fa-plus fa-lg"></i>
         </span>
       </div>
       <div class="panel-body"> 
       <?php $row = getlatest('*','users',"userID");
       ?>
       <ul class='list-unstyled latest-users'>
       
       <?php 
       if(! empty($row))
       {
       foreach($row as $key )
       {
         
         echo  '<li>' . $key['Username'] . " \x0B \x0B " . ' <span>   <a href="member.php?do=edit&userid=' . $key['userID'] . ' " class="btn btn-success pull-right"> <i class="fa fa-edit"></i> Edit </a> <a href="member.php?do=delete&userid='. $key['userID'] .'" class="btn btn-danger confirm pull-right"> <i class="fa fa-close"></i> Delete </a>  ';
      
       if ($key['RegStatus'] == 0)
   {
     echo ' <a href="member.php?do=pend&userid='. $key['userID'] .'" class="btn btn-info pull-right"> <i class="fa fa-close"></i> Approved</a> </span>';
     echo '</li>';
      
   }
   
       
       }
       }
       else
       {
         echo 'no member';
       }
?> </ul>
        
       </div>
       </div>
     </div>
     <div class="col-sm-6">
      <div class="panel panel-default">
       <div class="panel-heading">
         <i class="fa fa-tag"></i> laster items 
         <span class="toggle-info pull-right">
         <i class="fa fa-plus fa-lg"></i>
         </span>
       </div>
       <div class="panel-body">
       <?php $row = getlatest('*','items',"item_ID");
       ?>
       <ul class='list-unstyled latest-users'>
       <?php 
       if(!empty($row))

      {
       foreach($row as $key )
       {
         
         echo  '<li>' . $key['Name'] . " \x0B \x0B " . ' <span>   <a href="items.php?do=edit&id=' . $key['item_ID'] . ' " class="btn btn-success pull-right"> <i class="fa fa-edit"></i> Edit </a> <a href="items.php?do=delete&id='. $key['item_ID'] .'" class="btn btn-danger confirm pull-right"> <i class="fa fa-close"></i> Delete </a>  ';
      
       if ($key['Approve'] == 0)
   {
     echo ' <a href="items.php?do=activate&id='. $key['item_ID'] .'" class="btn btn-info pull-right"> <i class="fa fa-check"></i> Approved</a> </span>';
     echo '</li>';
      
   }
   
       
       
       }
       }
       else
       {
         echo 'no items';
       }
?> </ul>
       </div>
       </div>
     </div>
   </div>
   <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">
       <div class="panel-heading">
         <i class="fa fa-comments"></i> Laster comment
       <span class="toggle-info pull-right">
         <i class="fa fa-plus fa-lg"></i>
         </span>
       </div>
       <div class="panel-body"> 
       <?php

       $stmt = $connect->prepare("SELECT comments.*
                                  ,users.Username AS user_name 
                           FROM comments
                           INNER JOIN users ON users.userID=comments.user_id
                           " );
       $stmt->execute();
       $comment = $stmt->fetchAll();

      if(!empty($comment))
      {
       foreach($comment as $com)
        {
          echo "<div class='comment-box'>";
           echo "<span class='member-n'>" . $com['user_name'] . "</span>";
            echo "<p class='member-c'>" . $com['comments'] . "</p>";
          echo "</div>";
        }
}
else
{
  echo 'no comments';
}
       ?>
        
       </div>
       </div>
     </div>
     <div class="col-sm-6">
      <div class="panel panel-default">
       <div class="panel-heading">
         <i class="fa fa-tag"></i> laster items 
         <span class="toggle-info pull-right">
         <i class="fa fa-plus fa-lg"></i>
         </span>
       </div>
       <div class="panel-body">
       <?php $row = getlatest('*','items',"item_ID");
       ?>
       <ul class='list-unstyled latest-users'>
       <?php foreach($row as $key )
       {
         
         echo  '<li>' . $key['Name'] . " \x0B \x0B " . ' <span>   <a href="items.php?do=edit&id=' . $key['item_ID'] . ' " class="btn btn-success pull-right"> <i class="fa fa-edit"></i> Edit </a> <a href="items.php?do=delete&id='. $key['item_ID'] .'" class="btn btn-danger confirm pull-right"> <i class="fa fa-close"></i> Delete </a>  ';
      
       if ($key['Approve'] == 0)
   {
     echo ' <a href="items.php?do=activate&id='. $key['item_ID'] .'" class="btn btn-info pull-right"> <i class="fa fa-check"></i> Approved</a> </span>';
     echo '</li>';
      
   }
   
       
       }
?> </ul>
       </div>
       </div>
     </div>
   </div>
  </div>

<?php
/* End home page */


  include $tpl . 'footer.php';
}
else
{
    header('location:index.php');
    exit();

}
ob_end_flush();