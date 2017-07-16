<?php

/*
-manage member page

*/
ob_start();
session_start();

if (isset($_SESSION['Username']))
{
    
  $pagetitle = ' members ';

  include 'init.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
  
  //start manage page

  if($do == 'manage')
{

  $query = '';
  if(isset($_GET['page']) && $_GET['page'] == 'pending')
  {
    $query = 'AND RegStatus = 0';
  }

$stmt = $connect->prepare("SELECT * FROM users  WHERE GroupID != 1 $query ORDER BY userID DESC");
$stmt->execute();
$row = $stmt->fetchAll();


if(!empty($row))
{
?>




   <h1 class="text-center">  Members </h1>  
   <div class="container">
   <div class="table-responsive">
    <table class="main-table manage-member text-center table table-bordered">
        <tr>
            <td>#ID</td>
            <td>Image</td>
            <td>Usser Name</td>
            <td>Email</td>
            <td>Full Name</td>
            <td>Registered Date</td>
            <td>Control</td>
        </tr>
    <?php 


    foreach($row as $row)
    {
    echo "<tr>";

echo "<td>" . $row['userID'] . "</td>";

echo "<td>" ; 
if(!empty($row['image'])){
echo "<img src='../uploads/images/" . $row['image'] . "'alt=''/>";}
else {echo "<img src='../uploads/images/defailt.jpg'alt=''/>";}
echo "</td>";

echo "<td>" . $row['Username'] . "</td>";
echo "<td>" . $row['Email'] . "</td>";
echo "<td>" . $row['FullName'] . "</td>";
echo "<td>" . $row['Registereddata'] . "</td>";
   echo "<td>" . '<a href="member.php?do=edit&userid=' . $row['userID'] . ' " class="btn btn-success "> <i class="fa fa-edit"></i> Edit</a>' . ' ' 
               . '<a href="member.php?do=delete&userid='. $row['userID'] .'" class="btn btn-danger confirm"> <i class="fa fa-close"></i> Delete</a>' ;
   
   if ($row['RegStatus'] == 0)
   {
     echo ' <a href="member.php?do=pend&userid='. $row['userID'] .'" class="btn btn-info "> <i class="fa fa-close"></i> Approved</a>';
     echo '</td>';
      
   }
   
    echo "</tr>";
    }

    ?>
    

      
    </table>
</div>

        <a href="member.php?do=add" class="btn btn-primary "> <i class="fa fa-plus"></i> ADD member </a>

    </div>



<?php 


}
else
{
  echo '<div class="container">';

          echo  '<div class="alert alert-danger">ohhh ! </div>' ;
          echo ' <a href="member.php?do=add" class="btn btn-primary "> <i class="fa fa-plus"></i> ADD member </a>';

  echo '</div>';
}
    
}

elseif($do == 'add')
{
  
  
   ?> 
   <h1 class="text-center"> ADD Member </h1>  
   <div class="container">

   <form class="form-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> username</label> 
   <div class="col-sm-10">
      <input type="text" name="username" class="form-control"placeholder="user name " required= "required" autocomplete"off"/> 
      
   </div>
   </div>
   <!-- End username field -->
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> password</label> 
   <div class="col-sm-10">
       
      <input type="password" name="password" class="password form-control" placeholder="password "  required= "required" autocomplete="newpassword"/> 
      <i class="show-pass fa fa-eye fa-x2"></i>

   </div>
   </div>
   <!-- End username field -->
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> email</label> 
   <div class="col-sm-10">
      <input type="email" name="email" class="form-control" placeholder="email " required= "required"> 
   </div>
   </div>
   <!-- End username field -->
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> Full name</label> 
   <div class="col-sm-10">
      <input type="text" name="full" class="form-control"  placeholder="full name " required= "required"> 
   </div>
   </div>
   <!-- End username field -->
    <!-- Start user image field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> user image</label> 
   <div class="col-sm-10">
      <input type="file" name="image" class="form-control"   required= "required"> 
   </div>
   </div>
   <!-- End user image field -->
   <!-- Start submit field -->
   <div class="form-group form-group-lg">
   
   <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" value="Add member" class="btn btn-primary btn-lg "> 
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
           
            $imagefile = $_FILES['image'];
            $imagename = $imagefile['name'];
            $imagesize = $imagefile['size'];
            $imagetmp = $imagefile['tmp_name'];
            $imagetype = $imagefile['type'];
            // list of Allowed file typed to upload
            $imageAllowedExtension = array("jpeg","jpg","png","gif");
            // Get $imageAllowedExtension 
            $imageExtension = strtolower(end(explode('.',$imagename )));

            $name =  $_POST['username'];
            $pass =  $_POST['password'];
            $email =  $_POST['email'];
            $full =  $_POST['full'];
            $hashedpass = sha1($pass);
        
        $formerror = array();

      if(strlen($name) < 4)
      {
      $formerror [] = ' error user name less than<strong> 4</strong> ';
      }
      if(strlen($name) > 20)
      {
      $formerror [] = 'error user name greater  than <strong>20</strong>';
      }

      if (empty($name))
      {
      $formerror [] ='error empty <strong>user name </strong>';
      }
      if (empty($pass))
      {
      $formerror [] ='error empty <strong>password </strong>';
      }

      if (empty($email))
      {
        $formerror [] ='error empty <strong>email</strong>';
      }

      if (empty($full))
      {
        $formerror [] ='error empty <strong>full name</strong>';
      }

      if(   !empty($imagename) && ! in_array($imageExtension , $imageAllowedExtension))
      {
        $formerror[] = ' this is Extension for image cant be add in my project ';
      }
      if(empty($imagename) )
      {
        $formerror[] = ' image is empty';
      }
      if(   $imagesize > 4194304)
      {
        $formerror[] = ' your image must be larger than 4MB ';
      }

      foreach( $formerror  as $error)
      {
        echo  '<div class="alert alert-danger">' . "ohhh ! "  . $error . '</div>' . "<br>";
      }


      if(empty( $formerror ))
      {  
           $image = rand(0,100000) . '_' . $imagename; 

           move_uploaded_file($imagetmp,"..\uploads\images\\" .$image );
       
            $check = checkitem("Username","users",$name);

            if ($check == 1)
            {

             $mge ='<div class="alert alert-danger"> ohhh !  user name unique please change </div>' . "<br>";
             rehome($mge,'BACK');
            }
            else {
            $stmt = $connect->prepare("INSERT INTO  users(Username,Password, Email, FullName,image ,RegStatus,Registereddata) 
                                       VALUES (:name,:pass,:email,:full,:img,1,now())") ;
            $stmt->execute(array( 
              'name'  => $name , 
              'pass'  => $hashedpass ,
              'email' => $email ,
              'full'  => $full ,
              'img'   => $image
               ));
            
            $count = $stmt->rowCount();

            if ($count > 0)
        {

         $mge =' <div class="container" > <h1></h1> <div class="alert alert-success" role="alert"> Add member done </div> ' .  "<br> user name : " . $name . "<br> your email : "  . $email . "<br> full name : "  . $full . "</div> <br>";
        rehome($mge,'back',4);
        }
      else 
      {
        $mge = '<div class="alert alert-info" role="alert">No update done </div>';
        rehome($mge,'back',4);
      }
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
$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

//check if the user exists in database
//do select
$stmt = $connect->prepare("SELECT * FROM Users WHERE userID=?  LIMIT 1");
//execute select
$stmt->execute(array($userid));
$row = $stmt->fetch();  //save select in array
$count = $stmt->rowCount(); //row count 
//if there's found
if($count > 0)
{



?>

 <h1 class="text-center">Edit Member</h1>
 <div class="container">

   <form class="form-horizontal" action="?do=update" method="POST">
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> username</label> 
   <div class="col-sm-10">
      <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" required= "required"> 
      <input type="hidden" name="userid"  value="<?php echo $userid ?>"> 
   </div>
   </div>
   <!-- End username field -->
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> password</label> 
   <div class="col-sm-10">
      <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>"  > 
      <input type="password" name="newpassword" class="form-control" placeholder="leave blank if you don't want to change " > 


   </div>
   </div>
   <!-- End username field -->
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> email</label> 
   <div class="col-sm-10">
      <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required= "required"> 
   </div>
   </div>
   <!-- End username field -->
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> Full name</label> 
   <div class="col-sm-10">
      <input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>" required= "required"> 
   </div>
   </div>
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

 
 } elseif($do == 'update' )//update page
  {
        
      if ( $_SERVER['REQUEST_METHOD'] == 'POST')
      { ?>

                <h1 class="text-center">update Member</h1>
              
                <?php

              echo '<div class="container">';

                $id = $_POST['userid'];
                $name = $_POST['username'];
                $email = $_POST['email'];
                $full = $_POST['full'];

              //password trick
              $pass = ''; 
              if (empty($_POST['newpassword']))
              {
                $pass = $_POST['oldpassword'];
              }
              else
              {
                $pass = sha1($_POST['newpassword']);
              }

              //validation backend items  /*server*//* by php  */

              $formerror = array();

              if(strlen($name) < 4)
              {
              $formerror [] = ' error user name less than<strong> 4</strong> ';
              }
              if(strlen($name) > 20)
              {
              $formerror [] = 'error user name greater  than <strong>20</strong>';
              }

              if (empty($name))
              {
              $formerror [] ='error empty <strong>user name </strong>';
              }

              if (empty($email))
              {
                $formerror [] ='error empty <strong>email</strong>';
              }

              if (empty($full))
              {
                $formerror [] ='error empty <strong>full name</strong>';
              }


              foreach( $formerror  as $error)
              {
                echo  '<div class="alert alert-danger">' . "ohhh ! "  . $error . '</div>' . "<br>";
              }
              //if no error do update 
              if (empty($formerror))
              {

              $stmt2= $connect->prepare("SELECT * FROM users WHERE Username = ? AND userID != ? ");
              $stmt2->execute(array($name,$id));
              $count =$stmt2->rowCount();

              if($count == 0)
              {            
                //update date 
                $stmt = $connect->prepare("UPDATE users SET Username=?,Password = ?,Email=?,FullName=? WHERE userID=?");
                $stmt->execute(array($name , $pass, $email ,$full ,$id ));
                $count = $stmt->rowCount(); //row count 
                
                //message for upate done or no
                if ($count > 0)
                {
               $mge =  ' <div class="alert alert-success" role="alert"> update done </div> '.
                "your ID  : " .  $id . "<br> user name : " . $name . "<br> your email : "  . $email . "<br> full name : "  . $full;
                rehome($mge,'back');
                }
                else 
                {
                   $mge =  '<div class="alert alert-info" role="alert">No update done </div>';
                   rehome($mge,'back');
                
                }
                }
                else
                {
                  $mge =  '<div class="alert alert-info" role="alert">this user exits </div>';
                   rehome($mge,'back');
                }
            
              }
              
       }else
              {
              $mge = '<div class="alert alert-danger" role="alert">Sorry you cant browse this page directly</div>';
              rehome($mge);

               } 
     

      ?>


      <?php
  
  }
  elseif($do == 'delete')
 {
    
    

     
     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
     

     

     $check = checkitem('userID','users',$userid);

       if ($check > 0)
        {
         $stmt = $connect->prepare(" DELETE FROM users WHERE userID =? LIMIT 1");
         $stmt->execute(array($userid));
        $mge = '<div class="container"> <h1></h1><h1></h1> <div class="alert alert-success" role="alert"> Delete done  </div></div> ';
        rehome($mge,'back');
        }
        else 
        {
          $mge = '<div class="alert alert-info" role="alert">No Delete done </div>';
          rehome($mge,'back');
        }
       

 }
 elseif($do == 'pend')
  {
    
 echo '<div class="container text-center">';
  echo '<h1>Pending page</h1>';

    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $check = checkitem('userid','users',$userid);
    
    if($check > 0){
    $stmt = $connect->prepare("UPDATE users SET RegStatus=? WHERE userID=? ");
    
    $stmt->execute(array(1,$userid));

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
    }else
    {
      $mge = '<div class="alert alert-danger" role="alert">name unique  </div>';
       rehome($mge,'back');
    }
 
 
 }
  include $tpl . 'footer.php';
  }
  
   


  
    else
    {
        header('location:index.php');
        exit();

    }

    ob_end_flush();
?>