<?php 

/*function for all */
function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = 'DESC')
{
global $connect;
    $getall = $connect->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");
    $getall->execute();
    $all = $getall->fetchAll();
    
    return $all;

}






/*
** title function  that echo the page title in case the page
** has  the variable $pagetitle and echo defailt title for other pages
*/

function gettitle()
{
    global $pagetitle;
    if ( isset($pagetitle) )
    {
        echo $pagetitle;
    } 
    else

    {
        echo 'defailt';
    }
}


//redirect function v.01
/*

function rehome($errormessage,$second = 3)
{
 echo '<div class="alert alert-danger" role="alert">' . $errormessage . '</div> ' ;
 echo '<div class="alert alert-danger" role="alert"> you will be redirect to home after ' . $second . '</div>';
 header("refresh:$second;url=index.php");
 exit();

}

*/
//redirect function v.02
function rehome($msg,$url = null,$second = 3)
{
   
   global $redirect;
  if($url === null)
  {
      $url = 'index.php';
      $redirect = 'home';
  }
  else
  {
      if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '')
      {
      //back to url
    $url = $_SERVER['HTTP_REFERER'];
    $redirect = 'back';
    }
    else 
    {
        $url = 'index.php';
    }
  }
  

 echo  $msg  ;
 echo '<div class="alert alert-info" role="alert"> you will be redirect to ' . $redirect . ' after ' . $second . ' second </div>';
  header("refresh:$second;url=$url");
 exit();

}


//function to check item in database


function checkitem($select , $from ,$value)
{
    global $connect;
    $stmt2 = $connect->prepare("SELECT $select FROM $from WHERE $select=?");
    $stmt2->execute(array($value));
    $count = $stmt2->rowCount();
    
    return $count;

}


//calculate items v1.0

function countitem($item ,$form )
{
    global $connect;

    //function count to calculate number of users
    $stmt2 = $connect->prepare(" SELECT COUNT($item) FROM $form");
    $stmt2->execute();
    //to have col here
    return $stmt2->fetchColumn();

}
/*
//calculate iteam v1.1 upadata with me
function countitem($item ,$form ,$query = '')
{
    global $connect;

    //function count to calculate number of users
    $stmt2 = $connect->prepare(" SELECT COUNT($item) FROM $form $query");
    $stmt2->execute();
    //to have col here
    return $stmt2->fetchColumn();

}*/

//get latest v1.0

function getlatest($item ,$form ,$order,$limit = 5 )
{
  global $connect;


$stmt2 = $connect->prepare(" SELECT $item  FROM $form  ORDER BY $order DESC LIMIT $limit ");
    $stmt2->execute();
    //to have col here
    $row = $stmt2->fetchAll();
    return $row;

}