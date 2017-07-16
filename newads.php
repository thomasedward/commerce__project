<?php 
ob_start();
session_start();
$pagetitle='New Ads';
include  "init.php";
if(isset($_SESSION['user']))
{
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    
     {
        $formerrors = array();

        $name    = filter_var( $_POST['name'],FILTER_SANITIZE_STRING);
        $desc    = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        $price   = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        $status  = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $cat     = filter_var($_POST['categories'],FILTER_SANITIZE_NUMBER_INT);
        $mem     = filter_var($_SESSION['uid'],FILTER_SANITIZE_NUMBER_INT);
        $tags    = filter_var( $_POST['tags'],FILTER_SANITIZE_STRING);

        if (empty($name))
      {
      $formerrors [] ='error empty <strong>user name </strong>';
      }
     
      if (empty($cat))
      {
      $formerrors [] ='error empty <strong>categoies </strong>';
      }
     


      if(empty( $formerrors ))
      {  

       
            $stmtadd = $connect->prepare("INSERT INTO  items (Name,Description, Price, Country_Made ,Status,Cat_ID,Member_ID,Add_Date,tags)
                                       VALUES (?,?,?,?,?,?,?,now(),?) ");
            $stmtadd->execute(array($name,$desc,$price,$country,$status,$cat,$mem,$tags));
            
            $count = $stmtadd->rowCount();

                    if ($count > 0)
                    {

                    echo ' <div class="container" > <h1></h1> <div class="alert alert-success" role="alert"> Add item done  </div>' ;

                    echo '</div>';
                    }
                else 
                {
                    echo  '<div class="alert alert-info" role="alert"> Error :  No add done </div>';
                
                }
     
      
      }
    

    } 
         
    


?>
<h1 class="text-center">CReate new ads</h1>
<div class="create-ad block">
    <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading">Create new ad </div>
            <div class="panel-body">
           <div class="row">
               <div class="col-sm-9">
                   <form class="form-horizontal" action="<?php ECHO $_SERVER['PHP_SELF']?>" method="POST">
   <!-- Start name field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> name items</label> 
   <div class="col-sm-10">
      <input pattern=".{4,}" title="less than 4" type="text" name="name" class="form-control live"placeholder="name categorie " required= "required" autocomplete"off" data-class=".live-name"/> 
      
   </div>
   </div>
   <!-- End name field -->
   <!-- Start description field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> description</label> 
   <div class="col-sm-10">
      <input type="text" name="description" class=" form-control live" placeholder="description " autocomplete="newpassword" data-class=".live-desc"/> 
   </div>
   </div>
   <!-- End description field -->
   <!-- Start price field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> price</label> 
   <div class="col-sm-10">
      <input type="text" name="price" class="form-control live" placeholder=" price" required= "required" data-class=".live-price"> 
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
                   <div class="col-sm-3">
                     <div class="thumbnail item-box live-preview"> ';
                     <span class="price-tag ">$<span class="live-price">0</span></span>
                     <img class="img-responsive" src="new.png" alt="">
                     <div class="caption">
                     <h3 class="live-name">title</h3>
                      <p class="live-desc">Description</p>
                     </div>
                  </div>
               </div>



               </div>
               <!-- looping errors -->
               <?php 
               if(!empty($formerrors))
               {
                   foreach( $formerrors  as $error)
      {
                    echo '<div class="alert alert-danger">' . "ohhh ! "  . $error . '</div>' . "<br>";
       
      }

               }
               ?>
               <!-- looping errors -->
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