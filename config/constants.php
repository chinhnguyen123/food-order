<?php
//Start session
session_start();


// Create constants to store non repeating Values
define("SITEURL", "http://localhost/food-order/");
define("LOCALHOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");  
define("DB_NAME", "food-order");

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD); //database Connection
    $db_select = mysqli_select_db($conn, DB_NAME);//SELECTING DATABASE
?>