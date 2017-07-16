<?php

function lang( $phrase )
{
    static $lang = array(
     
 // navbar links

  'HOME_ADMIN'  => 'Home' ,
  'CATEGORIES' => 'categories',
  'ITEMS' => 'Items',
  'MEMBERS' => 'Members',
  'COMMENT' => 'Comment',
  'STATISTICS' => 'Statistics',
  'LOGS' => 'logs'
 
    );

    return $lang[$phrase];
}