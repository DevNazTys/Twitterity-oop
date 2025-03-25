<?php

define('DB_HOST', 'db');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'twitterity');

// connect to MySQL database
global  $db;
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check db connection
if($db === false){
    die("Error: connection error. " . mysqli_connect_error());
}
