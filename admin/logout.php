<?php
  //include constants.php for SITEURL
  include('../config/constants.php');

  //1.Destory the session
  session_destroy();//unsets $_SESSION['user];

  //2. Redirect to Login Page
  header('location: '.SITEURL.'admin/login.php');


?>