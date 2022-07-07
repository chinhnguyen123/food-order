<?php
  include('../config/constants.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="login">
    <h1 class="text_center">Login</h1>

    <?php
    if(isset($_SESSION['login'])){
      echo $_SESSION['login'];//display
      unset($_SESSION['login']);//removw
    }
    if(isset($_SESSION['not-login-message'])){
      echo $_SESSION['not-login-message'];//display
      unset($_SESSION['not-login-message']);//removw
    }
    ?>
    <br><br>
    <!-- Login Form Starts Here -->
    <form action="" method="POST" class="text_center">
      Username: <br>
      <input type="text" name="username" placeholder="Enter Username"> <br>

      Password:  <br>
      <input type="password" name="password" placeholder="Enter Password"><br><br>
      <input type="submit" name="submit" value="Login" class="btn-primary">

    </form>
    <!-- Login Form Ends Here -->
    <p class="text_center">Created By - <a href="#">Chinhnguyen</a></p>

  </div>
  
</body>
</html>

<?php
  //check whether the submit button is clicked or not
  if(isset($_POST['submit'])){
    //Process for login
    //1.Get the data from Login form
    echo $username = mysqli_real_escape_string($conn, $_POST['username']);
     $password = mysqli_real_escape_string($conn, md5($_POST['password']));

     //2. SQL so check whether the user with username and password exists or not
     $sql = "SELECT * FROM  tbl_admin WHERE username = '$username' AND password = '$password'";

     //3. Execute query
     $res = mysqli_query($conn, $sql);

     //4. Count rows to check whether the user exists or not
     $count = mysqli_num_rows($res);
     echo $count;

     if($count == 1){
        //User Available and login success

        $_SESSION['login'] = "<div class='success text_center'>Login successfully</div>";
        $_SESSION['user'] = $username;//to check whether the user is logged in or not and and log out will unset it


        //Redirect to home Page/Dashboard
        header("location:".SITEURL.'admin/');
     }
     else{
       //User not available and login failed
       $_SESSION['login'] = "<div class='error text_center'>Username or Password did not match</div>";
       //Redirect to home Page/Dashboard
       header("location:".SITEURL.'admin/login.php');
     }
  }
?>