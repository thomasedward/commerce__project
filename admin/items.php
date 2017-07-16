<?php

ob_start();
session_start();
$pagetitle = 'Items';
if(isset($_SESSION['Username']))
{
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
    if($do == 'manage')
    {
        
        
//very good 
//for using join
$stmt = $connect->prepare("SELECT items.*,categories.Name As cat_name ,users.Username AS member_name
                           FROM items
                           INNER JOIN categories ON categories.ID =items.Cat_ID 
                           INNER JOIN users ON users.userID =items.Member_ID
                           
                           ORDER BY item_ID DESC" );
$stmt->execute();
$row = $stmt->fetchAll();


if (!empty($row))
{


?>




   <h1 class="text-center">  Items </h1>  
   <div class="container">
   <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
        <tr>
            <td>#ID</td>
            <td>Name</td>
            <td>Description</td>
            <td>Price</td>
            <td>Adding Date</td>
            <td>categories</td>
            <td>user name</td>
            <td>Control</td>
        </tr>
    <?php 


    foreach($row as $row)
    {
    echo "<tr>";

echo "<td>" . $row['item_ID'] . "</td>";
echo "<td>" . $row['Name'] . "</td>";
echo "<td>" . $row['Description'] . "</td>";
echo "<td>" . $row['Price'] . "</td>";
echo "<td>" . $row['Add_Date'] . "</td>";
echo "<td>" . $row['cat_name'] . "</td>";
echo "<td>" . $row['member_name'] . "</td>";
   echo "<td>" . '<a href="items.php?do=edit&id=' . $row['item_ID'] . ' " class="btn btn-success "> <i class="fa fa-edit"></i> Edit</a>' . ' ' 
               . '<a href="items.php?do=delete&id='. $row['item_ID'] .'" class="btn btn-danger confirm"> <i class="fa fa-close"></i> Delete</a>' ;
 if($row['Approve'] == 0){
  echo ' <a href="items.php?do=activate&id=' . $row['item_ID'] . ' " class="btn btn-info "> <i class="fa fa-check"></i> Apporve</a> </td>';
   }
    echo "</tr>";
    }




    ?>

      
    </table>
</div>

        <a href="items.php?do=add" class="btn btn-primary "> <i class="fa fa-plus"></i> ADD item </a>

    </div>



<?php

}
else
{
  echo '<div class="container">';

          echo  '<div class="alert alert-danger">ohhh ! no items exists </div>' ;
  echo '<a href="items.php?do=add" class="btn btn-primary "> <i class="fa fa-plus"></i> ADD item </a>';

echo '</div>';
 
}     

    }
    elseif($do == 'add')
    {
        ?>
      <h1 class="text-center"> ADD Items </h1>  
   <div class="container">

   <form class="form-horizontal" action="?do=insert" method="POST">
   <!-- Start name field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> name items</label> 
   <div class="col-sm-10">
      <input type="text" name="name" class="form-control"placeholder="name categorie " required= "required" autocomplete"off"/> 
      
   </div>
   </div>
   <!-- End name field -->
   <!-- Start description field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> description</label> 
   <div class="col-sm-10">
      <input type="text" name="description" class=" form-control" placeholder="description " autocomplete="newpassword"/> 
   </div>
   </div>
   <!-- End description field -->
   <!-- Start price field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> price</label> 
   <div class="col-sm-10">
      <input type="text" name="price" class="form-control" placeholder=" price" required= "required"> 
   </div>
   </div>
   <!-- End price field -->
    <!-- Start country field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> country</label> 
   <div class="col-sm-10">
      <input type="text" name="country" class="form-control" placeholder=" country of made" required= "required"> 
   </div>
   </div>
   <!-- End country field -->

   <!-- Start status field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> status</label> 
   <div class="col-sm-10">
    <select  name="status" >
    <option value="0">New</option>
    <option value="1">Like New</option>
    <option value="2">Used</option>
    <option value="3">Very Old</option>
    </select>
   </div>
   </div>
   <!-- End status field -->
     <!-- Start members field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> users</label> 
   <div class="col-sm-10">
    <select  name="members">
    <?php 
    $stmt=$connect->prepare("SELECT  userID,Username FROM users");
    $stmt->execute();
    $row = $stmt->fetchAll();
    foreach($row as $row)
    {
           echo '<option value="' .$row['userID'] . '">' .$row['Username'] . '</option>';

    }
     ?>

    

    </select>
   </div>
   </div>
   <!-- End members field -->
    <!-- Start CATEGORIES field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> categories</label> 
   <div class="col-sm-10">
    <select  name="categories">
    
    <?php 
    $stmt=$connect->prepare("SELECT ID,Name FROM categories");
    $stmt->execute();
    $row = $stmt->fetchAll();
    foreach($row as $row)
    {
           echo '<option value="' .$row['ID'] . '">' .$row['Name'] . '</option>';
           $select = getAllFrom("*", "categories","WHERE parent= {$row['ID']}","","ID","");
    foreach($select as $cat)
    {
           echo '<option value="' .$cat['ID'] .' "';            
           echo  '>';
            echo ' -> '.$cat['Name'] . '</option>';

    }

    }
     ?>

    

    </select>
   </div>
   </div>
   <!-- End CATEGORIES field -->
   <!-- Start tags field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> tags</label> 
   <div class="col-sm-10">
      <input type="text" name="tags" class="form-control" placeholder=" separator tags with comma (,)"> 
   </div>
   </div>
   <!-- End tags field -->
   
   <!-- Start submit field -->
   <div class="form-group form-group-lg">
   
   <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" value="Save" class="btn btn-primary btn-lg "> 
   </div>
   </div>
   <!-- End submit field -->

   </form>

 </div>


    <?php


    }
    elseif($do == 'insert')
    {
         if ( $_SERVER['REQUEST_METHOD'] == 'POST')
  {
            $name    =  $_POST['name'];
            $desc    =  $_POST['description'];
            $price   =  $_POST['price'];
            $country =  $_POST['country'];
            $status  =  $_POST['status'];
            $mem  =  $_POST['members'];
            $cat  =  $_POST['categories'];
            $tags  =  $_POST['tags'];
           
        
                   $formerror = array();

      if (empty($name))
      {
      $formerror [] ='error empty <strong>user name </strong>';
      }
      if (empty($mem))
      {
      $formerror [] ='error empty <strong>members</strong>';
      }
      if (empty($cat))
      {
      $formerror [] ='error empty <strong>categoies </strong>';
      }
     


      foreach( $formerror  as $error)
      {
       $mge =  '<div class="alert alert-danger">' . "ohhh ! "  . $error . '</div>' . "<br>";
        rehome($mge,'back',4);
      }


      if(empty( $formerror ))
      {  

       
            $stmt = $connect->prepare("INSERT INTO  items (Name,Description, Price, Country_Made ,Status,Approve,Cat_ID,Member_ID,Add_Date,tags)
                                       VALUES (?,?,?,?,?,1,?,?,now(),?) ");
            $stmt->execute(array($name,$desc,$price,$country,$status,$cat,$mem,$tags));
            
            $count = $stmt->rowCount();

            if ($count > 0)
        {

         $mge =' <div class="container" > <h1></h1> <div class="alert alert-success" role="alert"> Add item done  </div>' ;

       
        rehome($mge,'back',4);
        echo '</div>';
        }
      else 
      {
        $mge = '<div class="alert alert-info" role="alert"> Error :  No add done </div>';
        rehome($mge,'back',4);
      }
     
      
      }
    

  }
    else
  {
    $mge = '<div class="alert alert-info" role="alert"> Sorry you cant browse this page directly </div>';
    rehome($mge);
  }

    }
    elseif($do == 'edit')
    {
          //check if get request userid is numerc
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

//check if the user exists in database
//do select
$stmt = $connect->prepare("SELECT *
                           FROM items
                           WHERE item_ID=?  LIMIT 1");
//execute select
$stmt->execute(array($id));
$row = $stmt->fetch();  //save select in array
$count = $stmt->rowCount(); //row count 
//if there's found
if($count > 0)
{
?>

 <h1 class="text-center">Edit Item</h1>
 <div class="container">
 
 <form class="form-horizontal" action="?do=update" method="POST">
   <!-- Start name field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> name items</label> 
   <div class="col-sm-10">
         <input type="hidden" name="item_id" value="<?php echo $row['item_ID']; ?>" /> 

      <input type="text" name="name" class="form-control" placeholder="name categorie " value="<?php echo $row['Name']; ?>" required= "required" autocomplete"off"/> 
      
   </div>
   </div>
   <!-- End name field -->
   <!-- Start description field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> description</label> 
   <div class="col-sm-10">
      <input type="text" name="description" class=" form-control" placeholder="description " value="<?php echo $row['Description']; ?>" autocomplete="newpassword"/> 
   </div>
   </div>
   <!-- End description field -->
   <!-- Start price field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> price</label> 
   <div class="col-sm-10">
      <input type="text" name="price" class="form-control" placeholder="  price" value="<?php echo $row['Price']; ?>" required= "required"> 
   </div>
   </div>
   <!-- End price field -->
    <!-- Start country field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> country</label> 
   <div class="col-sm-10">
      <input type="text" name="country" class="form-control" placeholder=" country of made" value="<?php echo $row['Country_Made']; ?>" required= "required"> 
   </div>
   </div>
   <!-- End country field -->

   <!-- Start status field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> status</label> 
   <div class="col-sm-10">
    <select  name="status" >
    
    <option value="0"<?PHP if($row['Status']==1){echo 'selected';} ?>>New</option>
    <option value="1" <?PHP if($row['Status']==2){echo 'selected';} ?>>Like New</option>
    <option value="2" <?PHP if($row['Status']==3){echo 'selected';} ?>>Used</option>
    <option value="3" <?PHP if($row['Status']==4){echo 'selected';} ?>>Very Old</option>
    </select>
   </div>
   </div>
   <!-- End status field -->
     <!-- Start members field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> users</label> 
   <div class="col-sm-10">
    <select  name="members">
   
    <?php 
    $stmt=$connect->prepare("SELECT  userID,Username FROM users");
    $stmt->execute();
    $use = $stmt->fetchAll();
    foreach($use as $use)
    {
           echo '<option value="' .$use['userID'] . ' "';

          if(  $row['Member_ID'] == $use['userID']  ) {echo 'selected';}  
          echo '>' .$use['Username'] . '</option>';

    }
     ?>

    

    </select>
   </div>
   </div>
   <!-- End members field -->
    <!-- Start CATEGORIES field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> categories</label> 
   <div class="col-sm-10">
    <select  name="categories" value="<?php echo $row['Cat_ID']; ?>">
    
    <?php 
    $stmt=$connect->prepare("SELECT ID,Name FROM categories");
    $stmt->execute();
    $cat = $stmt->fetchAll();
    foreach($cat as $cat)
    {
           echo '<option value="' .$cat['ID'] . '"'; 
            if(  $row['Cat_ID'] == $cat['ID']  ) {echo 'selected';}  
           echo'>' .$cat['Name'] . '</option>';

    }
    
?>
    

    </select>
   </div>
   </div>
   <!-- End CATEGORIES field -->
    <!-- Start tags field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> tags</label> 
   <div class="col-sm-10">
      <input type="text" name="tags" class="form-control" placeholder=" separator tags with comma (,)"> 
   </div>
   </div>
   <!-- End tags field -->
   
   <!-- Start submit field -->
   <div class="form-group form-group-lg">
   
   <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" value="Save" class="btn btn-primary btn-lg "> 
   </div>
   </div>
   <!-- End submit field -->

   </form>

   <?php
             
//very good 
//for using join



$stmt = $connect->prepare("SELECT comments.*
                                  ,users.Username AS user_name 
                           FROM comments
                           INNER JOIN users ON users.userID=comments.user_id
                           WHERE item_id=? " );
$stmt->execute(array($id));
$com = $stmt->fetchAll();

if(! empty($com))
{
?>




   <h1 class="text-center"> <?php echo $row['Name']; ?> Comments </h1>  
   <div class="container">
   <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
        <tr>
            <td>Comment</td>
            <td>User Name</td>
            <td>Adding Date</td>
            <td>Control</td>
        </tr>
    <?php 


    foreach($com as $com)
    {
    echo "<tr>";

echo "<td>" . $com['comments'] . "</td>";
echo "<td>" . $com['user_name'] . "</td>";
echo "<td>" . $com['comment_date'] . "</td>";
   echo "<td>" . '<a href="comments.php?do=edit&comid=' . $com['c_id'] . ' " class="btn btn-success "> <i class="fa fa-edit"></i> Edit</a>' . ' ' 
               . '<a href="comments.php?do=delete&comid='. $com['c_id'] .'" class="btn btn-danger confirm"> <i class="fa fa-close"></i> Delete</a>' ;
 if($com['status'] == 0){
  echo ' <a href="comments.php?do=activate&comid=' . $com['c_id'] . ' " class="btn btn-info "> <i class="fa fa-check"></i> Apporve</a> </td>';
   }
    echo "</tr>";
    }
    
    ?>

      
    </table>
</div>


    </div>
<?php } ?>

 </div>

 
<?php

 }
    }
    elseif($do == 'update')
    {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST')
      { ?>

                <h1 class="text-center">update Item</h1>
              
                <?php

              echo '<div class="container">';

                $item_ID = $_POST['item_id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $country = $_POST['country'];
                $status = $_POST['status'];
                $members = $_POST['members'];
                $categories = $_POST['categories'];
                $tags = $_POST['tags'];
               

              //validation backend items  /*server*//* by php  */

              $formerror = array();

             

              if (empty($name))
              {
              $formerror [] ='error empty <strong>user name </strong>';
              }



              foreach( $formerror  as $error)
              {
                echo  '<div class="alert alert-danger">' . "ohhh ! "  . $error . '</div>' . "<br>";
              }
              //if no error do update 
              if (empty($formerror))
              {

                

          
                //update date 
                $stmt = $connect->prepare("UPDATE items SET 
                                           Name=?, Description = ?,Price=?,Country_Made=? ,Status=?,Cat_ID=?,Member_ID=?,tags=? 
                                           WHERE item_ID=?");
                $stmt->execute(array($name , $description, $price ,$country,$status,$categories,$members,$tags ,$item_ID ));
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
            
              }
              
       }else
              {
              $mge = '<div class="alert alert-danger" role="alert">Sorry you cant browse this page directly</div>';
              rehome($mge);

               } 
     


    }
    elseif($do == 'delete')
    {
     
     $item_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
     
     $check = checkitem('item_ID','items',$item_id);

       if ($check > 0)
        {
         $stmt = $connect->prepare(" DELETE FROM items WHERE item_ID =? LIMIT 1");
         $stmt->execute(array($item_id));
        $mge = '<div class="container"> <h1></h1><h1></h1> <div class="alert alert-success" role="alert"> Delete done  </div>';
        rehome($mge,'back');
        }
        else 
        {
          $mge = '<div class="alert alert-info" role="alert">No Delete done </div>';
          rehome($mge,'back');
        }
       
       echo '</div> ';

    }
    elseif($do == 'activate')
    {
        
        $item_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
     
     $check = checkitem('item_ID','items',$item_id);

       if ($check > 0)
        {
         $stmt = $connect->prepare("UPDATE items SET Approve=? WHERE item_ID=? LIMIT 1");
         $stmt->execute(array(1,$item_id));
        $mge = '<div class="container"> <h1></h1><h1></h1> <div class="alert alert-success" role="alert"> Approve done  </div>';
        rehome($mge,'back');
        }
        else 
        {
          $mge = '<div class="alert alert-info" role="alert">No Approve done </div>';
          rehome($mge,'back');
        }
       
       echo '</div> ';

    }

   include $tpl . 'footer.php';
}
else
{

    header('location:index.php');
        exit();

}

?>