<?php

ob_start();
$pagetitle = 'Comments';
session_start();
if(isset($_SESSION['Username']))
{
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
    
    if($do == 'manage')
    {
    
           
//very good 
//for using join
$stmt = $connect->prepare("SELECT comments.*,items.Name AS item_name 
                                  ,users.Username AS user_name 
                           FROM comments
                           INNER JOIN items ON items.item_ID=comments.item_id
                           INNER JOIN users ON users.userID=comments.user_id
                           ORDER BY c_id DESC" );
$stmt->execute();
$row = $stmt->fetchAll();


if(!empty($row))
{


?>




   <h1 class="text-center">  Comments </h1>  
   <div class="container">
   <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
        <tr>
            <td>#ID</td>
            <td>Comment</td>
            <td>Item name</td>
            <td>User Name</td>
            <td>Adding Date</td>
            <td>Control</td>
        </tr>
    <?php 


    foreach($row as $row)
    {
    echo "<tr>";

echo "<td>" . $row['c_id'] . "</td>";
echo "<td>" . $row['comments'] . "</td>";
echo "<td>" . $row['item_name'] . "</td>";
echo "<td>" . $row['user_name'] . "</td>";
echo "<td>" . $row['comment_date'] . "</td>";
   echo "<td>" . '<a href="comments.php?do=edit&comid=' . $row['c_id'] . ' " class="btn btn-success "> <i class="fa fa-edit"></i> Edit</a>' . ' ' 
               . '<a href="comments.php?do=delete&comid='. $row['c_id'] .'" class="btn btn-danger confirm"> <i class="fa fa-close"></i> Delete</a>' ;
 if($row['status'] == 0){
  echo ' <a href="comments.php?do=activate&comid=' . $row['c_id'] . ' " class="btn btn-info "> <i class="fa fa-check"></i> Apporve</a> </td>';
   }
    echo "</tr>";
    }
    
   
   }

else
{
  echo '<div class="container">';

          echo  '<div class="alert alert-danger">ohhh ! no comments  </div>' ;

  echo '</div>';
} ?>

      
    </table>
</div>


    </div>



<?php

       
    }
    elseif($do == 'edit')
    {
        
        //check if get request userid is numerc
$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

//check if the user exists in database
//do select
$stmt = $connect->prepare("SELECT * FROM comments WHERE c_id=?  LIMIT 1");
//execute select
$stmt->execute(array($comid));
$row = $stmt->fetch();  //save select in array
$count = $stmt->rowCount(); //row count 
//if there's found
if($count > 0)
{



?>

 <h1 class="text-center">Edit Comment</h1>
 <div class="container">

   <form class="form-horizontal" action="?do=update" method="POST">
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> comments</label> 
   <div class="col-sm-10">
      <input type="hidden" name="comid"  value="<?php echo $comid ?>"> 
<textarea class="form-control" name="comment"> <?php echo $row['comments'] ?>  </textarea>
   </div>
   </div>
   <!-- End username field -->
    <!-- End username field -->
   <!-- Start submit field -->
   <div class="form-group form-group-lg">
   
   <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" value="save" class="btn btn-primary btn-lg "> 
   </div>
   </div>
   <!-- End submit field -->
   </form>

 </div>

<?php
}
else
{
    $mge = '<div class="alert alert-danger role="alert">Sorry you cant browse this page directly</div>';
    rehome($mge);
}

     
    }
    elseif($do == 'update')
    {
        
         if ( $_SERVER['REQUEST_METHOD'] == 'POST')
      { ?>

                <h1 class="text-center">update comment</h1>
              
                <?php

              echo '<div class="container">';

                $comid = $_POST['comid'];
                $comment = $_POST['comment'];
            
             
            
                //update date 
                $stmt = $connect->prepare("UPDATE comments SET comments=? WHERE c_id=?");
                $stmt->execute(array($comment ,$comid ));
                $count = $stmt->rowCount(); //row count 
                
                //message for upate done or no
                if ($count > 0)
                {
               $mge =  ' <div class="alert alert-success" role="alert"> update done </div> ';
                rehome($mge,'back');
                }
                else 
                {
                   $mge =  '<div class="alert alert-info" role="alert">No update done </div>';
                   rehome($mge,'back');
                }
            
            
              
       }else
              {
              $mge = '<div class="alert alert-danger" role="alert">Sorry you cant browse this page directly</div>';
              rehome($mge);

               } 
     


    }
    elseif($do == 'delete')
    {
         $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
    
         $stmt = $connect->prepare(" DELETE FROM comments WHERE c_id =? LIMIT 1");
         $stmt->execute(array($comid));
         $count =$stmt->rowCount();
         if( $count > 0 )
         {
        $mge = '<div class="container"> <h1></h1><h1></h1> <div class="alert alert-success" role="alert"> Delete done  </div></div> ';
        rehome($mge,'back');
        }
        else 
        {
          $mge = '<div class="alert alert-info" role="alert">No Delete done </div>';
          rehome($mge,'back');
        }
    
}
    elseif($do == 'activate')
    { 

         echo '<div class="container text-center">';
  echo '<h1>Pending page</h1>';

    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

    $stmt = $connect->prepare("UPDATE comments SET status=? WHERE c_id=? ");
    
    $stmt->execute(array(1,$comid));

    $count = $stmt->rowCount();
    
    
    if  ( $count > 0 )

    {
     
      $mge = '<div class="alert alert-info" role="alert">pending done </div>';
       rehome($mge,'back');
      
    }
     else
    {
      $mge = '<div class="alert alert-danger" role="alert">no  pending  </div>';
       rehome($mge,'back');
    }
     echo '</div>';
   


    }

   include $tpl . 'footer.php';
}
else
{

    header('location:index.php');
        exit();

}

?>