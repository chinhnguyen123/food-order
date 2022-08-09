<?php  include("partrials/menu.php");  ?>
<div class="main_content">
  <div class="wrapper">
    <h1>Add admin</h1>
    <br><br>
    <?php
      if(isset($_SESSION['add'])){
        echo $_SESSION['add'];
        unset($_SESSION['add']);
      }

    ?>

    <form action="" method="POST">

    <table class="tbl-30">
      <tr>
        <td>Full name: </td>
        <td>
          <input type="text" name="full_name" placeholder="Enter Your Name">
        </td>
      </tr>

      <tr>
        <td>Username: </td>
        <td>
          <input type="text" name="username" placeholder="Your Username">
        </td>
      </tr>

      <tr>
        <td>Password: </td>
        <td>
          <input type="password" name="password" placeholder="Your Password">
        </td>
      </tr>

      <tr>
        <td colspan="2">
          <input type="submit" name="submit" value="Add Admin" class="btn-secondary  ">
        </td>
      </tr>
    </table>

    </form>

  </div>
</div>


<?php  include("partrials/footer.php");  ?>

<?php  
  //process the value from form and save it in database
  //check wheter the submit button is clicked or not

  if(isset($_POST['submit'])){
    //Button clicked
    //1. get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password Encription with MD5

    //2. SQL query to save the data into database
    $sql = "INSERT INTO  tbl_admin SET
      full_name = '$full_name',
      username = '$username',
      password = '$password'
    ";
    // echo $sql;

    //3. Execute Query and save data in database
    $res = mysqli_query($conn, $sql);
    echo DB_NAME;

    //4. Check whether the (Query is excecuted) data is inserted or not and isplay appropriate message
    if($res==TRUE){
      //Data inserted
      //echo "data inserted";
      //create a session variable to display message
      $_SESSION['add'] = "Admin add successfully";
      //Redirect page to manage admin
      header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
      //failed to inserted data
      //echo "fald";
      $_SESSION['add'] = "Admin add faild";
      //Redirect page to add admin
      header("location:".SITEURL.'admin/add-admin.php');
    }
  }
  else{
    //Button not click
    
  }
?>