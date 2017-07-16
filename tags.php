<?php 
ob_start();

session_start();
$pagetitle='Tags ';
include  "init.php"; 



 ?>

<div class="container">

    <?php 
   
   if( isset($_GET['name']))
   {
       ?>
    <h1 class="text-center">Show categoies Tags</h1>
    <div class="row">
            <?php
            
            $tag =$_GET['name'];
             $item=getAllFrom("*", 'items', "WHERE tags like '%$tag%' ","AND Approve =1", "item_ID");
            foreach($item as $item)
            {
                echo '<div class="col-sm-6 col-md-3">';
                  echo '<div class="thumbnail item-box"> ';
                     echo '<span class="price-tag">' . $item ['Price'] . '</span>';
                     echo '<img class="img-responsive" src="new.png" alt="">';
                     echo '<div class="caption">';
                         echo '<h3> <a href="items.php?itemid='. $item['item_ID'].' ">' . $item['Name'] . ' </a></h3>';
                         echo '<p>'  . $item['Description'] . '</p>' ;
                         echo '<div class="date">'  . $item['Add_Date'] . '</div>' ;
                     echo '</div>';
                  echo '</div>';
                echo '</div>';


            } 
            ?>
    
    </div>

                <?php
                }
                else
                {
                    echo '<div class="alert alert-danger">dont page id</div>';
                }

                ?>



</div>

<?php

 include $tpl .  "footer.php"; 

 ob_end_flush();
 ?>