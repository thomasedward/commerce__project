<?php 
ob_start();
session_start();
$pagetitle='Show item';
include  "init.php";

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

//check if the user exists in database
//do select
$stmt = $connect->prepare("SELECT items.*,categories.Name as cat_name,users.Username AS user
                           FROM items
                           INNER JOIN categories ON categories.ID = items.Cat_ID
                           INNER JOIN users ON users.userID = items.Member_ID
                           WHERE item_ID=? AND Approve=1 LIMIT 1");
//execute select
$stmt->execute(array($itemid));
$row = $stmt->fetch();  //save select in array
$count = $stmt->rowCount(); //row count 
//if there's found
if($count > 0)
{

?>
<h1 class="text-center"><?php echo $row['Name']?></h1>
<div class="container">
     <div class="row">
        <div class="col-md-3">
         <img class="img-responsive img-thumbnail" src="new.png" alt="">
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $row['Name']?></h2>
            <p><?php echo $row['Description']?></p>
            <ul class="list-unstyled">
            <li>
                <i class="fa fa-calendar fa-fw"></i>
                <?php echo $row['Add_Date']?></li>
            <li>
                <i class="fa fa-calendar fa-fw"></i>
                Price : <?php echo $row['Price']?></li>
            <li>
                <i class="fa fa-calendar fa-fw"></i>
                Made In : <?php echo $row['Country_Made']?></li>
             <li>
                 <i class="fa fa-calendar fa-fw"></i>
                 Category :<a href="categories.php?catid=<?php echo $row['Cat_ID']?>&pagename=<?php echo $row['cat_name']?>"> <?php echo $row['cat_name']?></a></li>
             <li>
                 <i class="fa fa-calendar fa-fw"></i>
                 Add By : <?php echo $row['user']?></li>
             <li>
                 <i class="fa fa-calendar fa-fw"></i>
                 Tags : 
                 <?php 
                 $alltags = explode(",",$row['tags']);
                 foreach($alltags as $alltags)
                 { 
                    //  for delete spaces
                     $alltags = str_replace(" ","",$alltags);
                     //  for delete convert to lower case
                     $alltags = strtolower($alltags);
                     if(!empty($alltags))
                     {
                   echo  "<a href='tags.php?name={$alltags}'>" .$alltags . "</a>" . ' ' ; 
                   }  
                 }
                 ?>

                 </li>
            </ul>
            
        </div>

     </div>
     <hr class="custom-hr">
       <!--start add comment-->
 <?php      if(isset($_SESSION['user']))
{?>
       <div class="row">

       <div class="col-md-offset-3">
       <div class="add-comment">
              <h3>Add Your Comment</h3>
              <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $row['item_ID'] ?>" method='POST'>
                    <textarea name="comment" required="required"></textarea>
                    <input class="btn btn-primary " type="submit" value="Add Comment">
              </form>
              <?php 
              if($_SERVER['REQUEST_METHOD'] =='POST')
           {
               $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
               $itemcom = $row['item_ID'];
               $usercom = $_SESSION['uid'];
               
               $stmcom = $connect->prepare("SELECT * FROM comments WHERE comments=?" );
               $stmcom->execute(array($comment));
               $rowcom = $stmcom->fetch();
               $conut = $stmcom->rowCount();
               if(! (($count > 0) && ($rowcom['user_id'] === $_SESSION['uid'])))
               {
               

              if(!empty($comment))
              {

              
               $stmcom = $connect->prepare("INSERT INTO comments (comments,comment_date,item_id,user_id) 
                                            VALUES (?,now(),?,?)");
               $stmcom->execute(array($comment,$itemcom,$usercom));
               $conut = $stmcom->rowCount();
               if($count > 0)
               {
                  
                  echo '<div class="alert alert-success"> Comment Added </div>';

               }
               else
               {
                
                echo '<div class="alert alert-danger"> not Comment Added </div>';

               }
               }
               else
               {
                
                echo '<div class="alert alert-danger">  Comment empty </div>';

               }
               } 
                    }
        


              ?>
        </div>
       </div>
        
     </div>   
     
     
<?php 
} 
else 
{
    echo '<a href="login.php">login </a>or  <a href="login.php">register</a> to add comment ';

}

?>
     <!--end add comment-->
     <hr class="custom-hr">
     <?php 
        
        $stmtselcom = $connect->prepare("SELECT comments.*,users.Username AS user
                           FROM comments
                           INNER JOIN users ON users.userID = comments.user_id
                           WHERE item_id=? AND status=1
                           ORDER BY c_id DESC" );
$stmtselcom->execute(array($itemid));
$com = $stmtselcom->fetchAll();




        ?>
     
<?php
       if(!empty($com))
{
    foreach($com as $com)

    {
?>
    <div class="comment-box">
    <div class="row">
    <div class="col-sm-2 text-center">
    <img class="img-responsive img-thumbnail img-circle" src="new.png" alt="">
    <?php echo $com['user'] ?> 
    </div>
    <div class="col-sm-10">
    <p class="lead"><?php echo $com['comments'] ?></p></div>
    </div>
    </div>
    <hr class="custom-hr">
 <?php  
    }  
}
     
 ?>      
     </div>
</div>
<?php

}
else
{
    echo '<div class="alert alert-danger">there\'s cant directy  Or it\'s item waiting approve </div>';
}
 include $tpl .  "footer.php"; 
 ob_end_flush();
 ?>