<?php 
ob_start();
session_start();
$pagetitle='Profile';
include  "init.php";
if(isset($_SESSION['user']))
{
    $stmtUser = $connect->prepare("SELECT * FROM users WHERE Username=?");
    $stmtUser->execute(array($sessionUser));
    $info = $stmtUser->fetch();


?>
<h1 class="text-center">My Profile</h1>
<div class="information block">
    <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading">My Information</div>
            <div class="panel-body">
            <ul class="list-unstyled">
                <li>
                    <i class="fa fa-unlock-alt fa-fw"></i>
                     <span>name</span>     : <?php echo $info['Username'];?> </li>
                <li> 
                    <i class="fa fa-envelope-o fa-fw"></i>
                    <span>email</span>     : <?php echo $info['Email'];?> </li>
                <li> 
                    <i class="fa fa-user fa-fw"></i>
                    <span>Full Name</span> : <?php echo $info['FullName'];?> </li>
                <li> 
                    <i class="fa fa-tag fa-fw"></i>
                    <span>Reg</span>       : <?php echo $info['RegStatus'];?> </li>
            </ul>
            <div class="btn btn-primary"><a href="">Edit Informatiom</a></div>
            </div> 
         </div>   
    </div>
</div>

<div id="my-item" class="my-Ads block">
    <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading">My ads</div>
            <div class="panel-body">
                
                 <div class="row">
            <?php
            $item = getitem('Member_ID',$info['userID'],'every');
            if (!empty($item))
            {
            foreach($item as $item)
            { 
                echo '<div class="max-h">';
                echo '<div class="col-sm-6 col-md-3">';
                  echo '<div class="thumbnail item-box"> ';
                  if($item['Approve'] == 0 )
                  {
                      echo '<span class="approve-status"> Waiting approve </span>';
                  }
                  else
                  {
                      echo '<span class="approved">  approved </span>';
                  }
                     echo '<span class="price-tag">' . $item ['Price'] . '</span>';
                     echo '<img class="img-responsive" src="new.png" alt="">';
                     echo '<div class="caption">';
                         echo '<h3><a href="items.php?itemid='. $item['item_ID'] .'">' .$item['Name'] . '</a></h3>';
                         echo '<p>'  . $item['Description'] . '</p>' ;
                         echo '<div class="date">'  . $item['Add_Date'] . '</div>' ;
                     echo '</div>';
                  echo '</div>';
                echo '</div>';
               echo '</div>';

            }
            }else
            {
                echo 'no ads  <a href="newads.php"> Add Ads </a>';
            } 
            ?>
    
    </div>
    
            </div> 
         </div>   
    </div>
</div>

<div class="my-comment block">
    <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading">Latest Comments</div>
            <div class="panel-body">
                <?php
                $stmt = $connect->prepare("SELECT comments
                           FROM comments
                           WHERE user_id=? " );
                 $stmt->execute(array($info['userID']));
                 $com = $stmt->fetchAll();
                 if(!empty($com))
                 {
                     foreach($com as $com)
                     {
                         echo $com['comments' ] . '<br>';
                     }
                 }
                 else 
                 {
                     echo 'no';
                 }

                
                ?>
            </div> 
         </div>   
    </div>
</div>

<?php
}
else
{
    header('location:login.php');
    exit();
}
 include $tpl .  "footer.php"; 
 ob_end_flush();
 ?>