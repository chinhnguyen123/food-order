
<?php include('partrials/menu.php') ?>

<div class="main_content">
  <div class="wrapper">
    <h1>Update Admin</h1>
    <br><br>
  <?php

  //1. Get the ID of selected Admin
  $id = $_GET['id'];

  //2.Create SQL Query to get the Details
  $sql = "SELECT *FROM tbl_admin WHERE id=$id";

  //Execute the query
  $res = mysqli_query($conn, $sql);

  //Check whether the query is excuted or not
  if($res==true){
    //check whether the data is avaiable or not
    $count= mysqli_num_rows($res);
    //check whether we have admin data or not
    if($count==1){
      //get the details
      //echo "Admin availble";
      $row = mysqli_fetch_assoc($res);
      $full_name = $row['full_name'];
      $username = $row['username'];

    }
    else{
      //redirect to manage  Admin page
      header("location:".SITEURL.'admin/manage-admin.php');
    }
  }


  ?>

    <form action="" method="POST">

    <table class="tbl-30">
      <tr>
        <td>Full name: </td>
        <td>
          <input type="text" name="full_name" value="<?php echo $full_name; ?>">
        </td>
      </tr>

      <tr>
        <td>Username: </td>
        <td>
          <input type="text" name="username" value="<?php echo $username; ?>">
        </td>
      </tr>

      <tr>
        <td>Password: </td>
        <td>
          <input type="password" name="password" value="">
        </td>
      </tr>

      <tr>
        <td colspan="2">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="submit" name="submit" value="Update Admin" class="btn-secondary  ">
        </td>
      </tr>
    </table>

  </form>
  </div>
</div>

<?php
//check whether the submit button is clicked or not
if(isset($_POST['submit'])){
  //echo "Button Clicked";
  //get all the values from form to update
  $id = $_POST['id'];
  $full_name = $_POST['full_name'];
  $username = $_POST['username'];
  $id = $_POST['id'];

  //Ccrate a SQL Query to update Admin
  $sql1 = "UPDATE tbl_admin SET
  full_name = '$full_name',
  username = '$username'
  WHERE id = '$id'
  ";

  //Execute the query
  $res = mysqli_query($conn, $sql1);

  //check whether the query excuted successfully or not
  if($res){
    //Query executed and admin updated
    $_SESSION['update'] ="<div class='success'>Admin Updated Successfully</div>";
    header("location:".SITEURL.'admin/manage-admin.php');
  }
  else{
    //failed to update admin
    $_SESSION['update'] ="<div class='error'>Failed to Update Admin. Try Again Later.</div>";
    //Redicrect to manage Admin page
    header("location:".SITEURL.'admin/manage-admin.php');
  }
}

?>

<?php include('partrials/footer.php') ?>

