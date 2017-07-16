<?php

// start the session 
session_start();
// unset the data
session_unset();
//destroy the session 
session_destroy();

header('location:index.php');

exit();