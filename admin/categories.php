<?php

ob_start();
$pagetitle = 'Categories';
session_start();
if(isset($_SESSION['Username']))
{
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
    if($do == 'manage')
    {

       $sort = 'ASC';
       $sort_array = array('ASC','DESC');
       if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array))
       {
         $sort = $_GET['sort'];

       }
       $stmt = $connect->prepare("SELECT * FROM categories WHERE parent=0 ORDER BY Ordering $sort ");
       $stmt->execute();
       $row =$stmt->fetchAll();
       if (!empty($row))
       {

       
       ?>
       <h1 class="text-center">Manage Categories</h1>
       <div class="container category">
         <div class="panel panel-default">
            <div class="panel-heading">Manage Categories
              <div class="option pull-right">
                ordering : 
                <a  class="<?php if($sort=='ASC'){ echo 'active'; }?>" href="?sort=ASC">ASC</a> | 
                <a  class="<?php if($sort=='DESC'){ echo 'active'; }?>" href="?sort=DESC">DESC</a>
                view : 
                <span class="active" data-view="full">Full </span>|
                <span  date-view="Classic">Classic</span>
                
                </div>
            </div>
            <div class="panel-body">
            <?php
            foreach($row as $row)
            {
                echo '<div class="cat">';
                
                echo '<div class="hidden-btn">';
                echo '<a href="?do=edit&id='. $row['ID'] .' "class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> edit </a>';
                echo '<a href="?do=delete&id=' . $row['ID'] .  '" class="btn btn-xs btn-danger confirm"><i class="fa fa-close"></i> delete </a>';
                echo '</div>';                
                echo    '<h3>' .$row['Name'] . '</h3>';
                echo '<div class="full-view">';
                 echo    '<p>';
                  if (empty($row['Description'])) 
                  {
                echo 'no description here categoies';    
                  }
                  else
                  {
                      echo $row['Description'];
                  }
                  echo '</p>';
                  
                  if($row['Visibility'] == 1)
                  {
                    echo '<span class="vis"> Hidden </span>';    
                  }

                  if($row['Allow_Comment'] == 1)
                  {
                    echo  '<span class="com"> Comment Display  </span>';    
                  }
                  
                  if($row['Allow_Ads'] == 1)
                  {
                    echo  '<span class="ads"> Ads Display </span>';    
                  }


                  echo '</div>';
                                  
                // chile categories 
                   $chile = getAllFrom("*", "categories","WHERE parent ={$row['ID']}","","ID","");
       if(!empty($chile))
       {
         echo '<h5 class="child-h"> Child category </h5>';
        echo '<ul class="list-unstyled child-cat">';

        foreach($chile as $cat)
        {
          echo '<li class="child-n"><a href="categories.php?do=edit&id='  . $cat['ID'] .'" >' . $cat['Name'] .'</a>     
          <a href="?do=delete&id=' . $cat['ID'] .  '" class="show-delete confirm"> delete </a>
          </li>';
        }
            }
           echo '</ul>';


                 echo '</div>';
             echo '<hr>'; }
              ?>
            </div>
         </div>

                <a href="?do=add"class="btn  btn-primary"> <i class="fa fa-plus"> </i> Add categories </a>
       
       </div>


    <?php
    
     }

    else
{
  echo '<div class="container">';

          echo  '<div class="alert alert-danger">ohhh !  no categories </div>' ;
          echo '                <a href="?do=add"class="btn  btn-primary"> <i class="fa fa-plus"> </i> Add categories </a>
';

  echo '</div>';
}
    
    }
    elseif($do == 'add')
    {
    ?>
      <h1 class="text-center"> ADD Categories </h1>  
   <div class="container">

   <form class="form-horizontal" action="?do=insert" method="POST">
   <!-- Start name field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> name categorie</label> 
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
   <!-- Start ordering field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> ordering</label> 
   <div class="col-sm-10">
      <input type="text" name="ordering" class="form-control" placeholder="ordering "> 
   </div>
   </div>
   <!-- End ordering field -->
   <!--start categoiry type-->
    <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> parent </label> 
   <div class="col-sm-10">
        <select name="parent">
        <option value="0">None</option>
          <?php
    $select = getAllFrom('*', 'categories','WHERE parent= 0',"",'ID',"");
    foreach($select as $row)
    {
           echo '<option value="' .$row['ID'] . '">' .$row['Name'] . '</option>';

    }
           // $select = getAllFrom('*', 'categoires','WHERE parent=0','ID');
            // foreach($row as $select)
            // {
            //   echo '<option value="' .$select['ID'] .'">' . $select['Name'] . '</option>';
            // }
          ?>
        </select>
   </div>
   </div>
   <!--end category type-->
   <!-- Start visibility field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> visibility</label> 
   <div class="col-sm-10">
      <div>
      <input id="vis-yes" type="radio" name="visibility" value="0" checked >
      <label for="vis-yes">Yes</label>
      </div> 
      <div>
      <input id="vis-no" type="radio" name="visibility" value="1">
      <label for="vis-no">No</label>
      </div> 
  
   </div>
   </div>
   <!-- End visibility field -->
     <!-- Start comment field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg">Allow comment</label> 
   <div class="col-sm-10">
      <div>
      <input id="com-yes" type="radio" name="comment" value="0" checked >
      <label for="com-yes">Yes</label>
      </div> 
      <div>
      <input id="com-no" type="radio" name="comment" value="1">
      <label for="com-no">No</label>
      </div> 
  
   </div>
   </div>
   <!-- End comment field -->
     <!-- Start ads field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg">Allow ads</label> 
   <div class="col-sm-10">
      <div>
      <input id="ads-yes" type="radio" name="ads" value="0" checked >
      <label for="ads-yes">Yes</label>
      </div> 
      <div>
      <input id="ads-no" type="radio" name="ads" value="1">
      <label for="ads-no">No</label>
      </div> 
  
   </div>
   </div>
   <!-- End ads field -->
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   
   <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" value="Add member" class="btn btn-primary btn-lg "> 
   </div>
   </div>
   <!-- End username field -->

   </form>

 </div>


    <?php
    }
    elseif($do == 'insert')
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')

        {
            echo '<div class="container">';
            echo '<h1 class="text-center">insert page</h1>';
            $name   = $_POST['name'];
            $desc   = $_POST['description'];
            $order  = $_POST['ordering'];
            $vis    = $_POST['visibility'];
            $com    = $_POST['comment'];
            $ads    = $_POST['ads'];
            $parent = $_POST['parent'];

            $check = checkitem('Name','categories',$name);
            if($check == 0)
            {

            
            
            $stmt = $connect->prepare("INSERT INTO categories (Name,Description,parent,Ordering,Visibility,Allow_Comment,Allow_Ads)
                                       VALUES (?,?,?,?,?,?,?)");
            $stmt->execute(array($name,$desc,$parent,$order,$vis,$com,$ads));
            $count = $stmt->rowCount();
            if($count > 0 )
            {
                $mge = '<div class="alert alert-info" role="alert">Add done</div>';
                rehome($mge,'back',6);

            }
            else
            {
                 $mge = '<div class="alert alert-info" role="alert">no Add</div>';
                rehome($mge,'back',6);

            }
          }
          else
          {
               $mge = '<div class="alert alert-info" role="alert">name categories is unique</div>';
                rehome($mge,'back',6);
          }

        }

        else
        {
            $mge = '<div class="alert alert-danger" role="alert">cant browse this page directly </div>';
        rehome($mge,'back',4);
        }
    }
    elseif($do == 'edit')
    {

 $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

 
           $stmt = $connect->prepare('SELECT * FROM categories WHERE ID=?');
           $stmt->execute(array($id));
           $row = $stmt->fetch();
           $count=$stmt->rowCount();
           if ( $count > 0 )
           
           {

?>        
        <h1 class="text-center"> Edit Categories </h1>  
   <div class="container">

   <form class="form-horizontal" action="?do=update" method="POST">
   <!-- Start name field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> name categorie</label> 
   <div class="col-sm-10">
      <input type="text" name="name" class="form-control" value="<?php echo $row['Name'] ?>" placeholder="name categorie " required= "required" autocomplete"off"/> 
      <input type="hidden" name="id"  value="<?php echo $row['ID'] ?>" /> 
      
   </div>
   </div>
   <!-- End name field -->
   <!-- Start description field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> description</label> 
   <div class="col-sm-10">
      <input type="text" name="description" class=" form-control" value="<?php echo $row['Description'] ?>" placeholder="description " autocomplete="newpassword"/> 
   </div>
   </div>
   <!-- End description field -->
   <!-- Start ordering field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> ordering</label> 
   <div class="col-sm-10">
      <input type="text" name="ordering" class="form-control" value="<?php echo $row['Ordering']?>" placeholder="ordering "> 
   </div>
   </div>
   <!-- End ordering field -->
   <!--start categoiry type-->
    <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> parent </label> 
   <div class="col-sm-10">
        <select name="parent">
        <option value="0">None</option>
          <?php
    $select = getAllFrom('*', 'categories','WHERE parent= 0',"",'ID',"");
    foreach($select as $cat)
    {
           echo '<option value="' .$cat['ID'] .' "'; 
          
          //  if(!empty($_GET['parent']))
          //  {
          //  if($cat['ID'] === $_GET['parent']){echo 'selected' ;}
          //  }
          if($cat['ID'] === $row['parent']){echo 'selected' ;}
            
           echo  '>';
            echo $cat['Name'] . '</option>';

    }
           // $select = getAllFrom('*', 'categoires','WHERE parent=0','ID');
            // foreach($row as $select)
            // {
            //   echo '<option value="' .$select['ID'] .'">' . $select['Name'] . '</option>';
            // }
          ?>
        </select>
   </div>
   </div>
   <!--end category type-->
   <!-- Start visibility field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg"> visibility</label> 
   <div class="col-sm-10">
      <div>
      <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($row['Visibility'] ==0 ){echo 'checked';} ?> >
      <label for="vis-yes">Yes</label>
      </div> 
      <div>
      <input id="vis-no" type="radio" name="visibility" value="1" <?php if($row['Visibility'] == 1 ){echo 'checked';} ?> >
      <label for="vis-no">No</label>
      </div> 
  
   </div>
   </div>
   <!-- End visibility field -->
     <!-- Start comment field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg">Allow comment</label> 
   <div class="col-sm-10">
      <div>
      <input id="com-yes" type="radio" name="comment" value="0" <?php if($row['Allow_Comment'] ==0 ){echo 'checked';} ?>  >
      <label for="com-yes">Yes</label>
      </div> 
      <div>
      <input id="com-no" type="radio" name="comment" value="1" <?php if($row['Allow_Comment'] ==1){echo 'checked';} ?> >
      <label for="com-no">No</label>
      </div> 
  
   </div>
   </div>
   <!-- End comment field -->
     <!-- Start ads field -->
   <div class="form-group form-group-lg">
   <label class="col-sm-2 control-label control-label-lg">Allow ads</label> 
   <div class="col-sm-10">
      <div>
      <input id="ads-yes" type="radio" name="ads" value="0" <?php if($row['Allow_Ads'] == 0 ){echo 'checked';} ?>  >
      <label for="ads-yes">Yes</label>
      </div> 
      <div>
      <input id="ads-no" type="radio" name="ads" value="1" <?php if($row['Allow_Ads'] == 1 ){echo 'checked';} ?> >
      <label for="ads-no">No</label>
      </div> 
  
   </div>
   </div>
   <!-- End ads field -->
   <!-- Start username field -->
   <div class="form-group form-group-lg">
   
   <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" value="save" class="btn btn-primary btn-lg "> 
   </div>
   </div>
   <!-- End username field -->

   </form>

 </div>

<?php
}
else
{

 $mge = '<div class="alert alert-danger" role="alert">cant browse this page directly </div>';
        rehome($mge,'back',4);

}
       


    }
    elseif($do == 'update')
    {
         if($_SERVER['REQUEST_METHOD'] == 'POST')
         {
          
          echo '<div class="container">';
            echo '<h1 class="text-center">insert page</h1>';
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['ordering'];
            $vis = $_POST['visibility'];
            $com = $_POST['comment'];
            $ads = $_POST['ads'];
            $id = $_POST['id'];
            $parent = $_POST['parent'];

            

            
            
            $stmt = $connect->prepare("UPDATE categories SET Name=?,Description=?,Ordering=?,parent=?,Visibility=?,Allow_Comment=?,Allow_ads=? WHERE ID=? ");
            $stmt->execute(array($name,$desc,$order,$parent,$vis,$com,$ads,$id));
            $count = $stmt->rowCount();
            if($count > 0 )
            {
                $mge = '<div class="alert alert-info" role="alert">Update done</div>';
                rehome($mge,'back',6);

            }
            else
            {
                 $mge = '<div class="alert alert-info" role="alert">no update</div>';
                rehome($mge,'back',6);

            }
          
         }
         else
         {
           $mge = '<div class="alert alert-danger" role="alert">cant browse this page directly </div>';
        rehome($mge,'back',4);
         }


    }
    elseif($do == 'delete')
    {
           echo '<div class="container">';
           echo '<h1 class="text-center"> Delete <h1>';
             $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $check = checkitem('ID','categories',$id);
         
         if ($check > 0)
         { 
           $stmt = $connect->prepare('DELETE FROM categories WHERE ID=?');
           $stmt->execute(array($id));
           $count=$stmt->rowCount();
           if ( $count > 0 )
           {
             $mge = '<div class="alert alert-danger" role="alert"> deleted done </div>';
              rehome($mge,'back',6);
           }
           else
           {
             
             $mge = '<div class="alert alert-danger" role="alert"> No deleted  </div>';
              rehome($mge,'back',6);
           }
           
         }else
         {
           $mge = '<div class="alert alert-danger" role="alert"> Id no\'t corect   </div>';
              rehome($mge,'back',6);
         }

         echo "</div>";
    }
    else
    {
       $mge = '<div class="alert alert-danger" role="alert">no page here </div>';
        rehome($mge,'categories.php',4);
    }

   include $tpl . 'footer.php';
}
else
{

    header('location:index.php');
        exit();

}

?>