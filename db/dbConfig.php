<?php

define('DB_SERVER', "localhost");
define('DB_USERNAME', "root");
define('DB_NAME', "evanshoe");
define('DB_PASSWORD', "");


$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false) {
    die("ERROR: Could not connect," . mysqli_connect_error());
}else{
    // echo "Connection success!!!";
}
?>