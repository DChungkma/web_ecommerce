<?php
// define('DB_SERVER', '192.168.142.131');
// define('DB_USER', 'username');
// define('DB_PASS', 'password');
// define('DB_NAME', 'databasemayao');
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'database');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// $con = mysqli_connect("localhost", "root", "", "database")
// $