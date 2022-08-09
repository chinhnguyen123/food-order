<?php include('partrials/menu.php') ?>

<div class="main-content"> 
  <div class="wrapper">
    <h1>Change password</h1>
    <br><br>
    <?php
      if(isset($_GET['id'])){
        $id = $_GET['id'];
      }

    ?>

      <form action="" method = "POST">
        <table class="tbl-30">
          <tr>
            <td>
              Current password:
          </td>
            <td>
              <input type="password" name="current_password" placeholder="Current Password">
            </td>
          </tr>
          <tr>
            <td>
              New password: 
            </td>
            <td>
              <input type="password" name = "new_password" placeholder="New Password">
            </td>
          </tr>

          <tr>
            <td>
              Confirm password: 
            </td>
            <td>
              <input type="password" name = "confirm_password" placeholder="Confirm Password">
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input type="submit" name="submit" value="Change Password"  class="btn-secondary">
            </td>
          </tr>
          
        </table>
      </form>
     
  </div>
</div>

<?php
  //check whether the submit button is clicked or not
  if(isset($_POST['submit'])){
   // echo "Clicked";

    //1. Get the data from form
    $id = $_GET['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //2. Check whether the user with current ID and Current Password Exist or not
    $sql = "SELECT * FROM tbl_admin WHERE  id = $id AND password = '$current_password'";

    //execute query
    $res = mysqli_query($conn, $sql);

    if($res){
      //check whether data  is availble  or not
       $count = mysqli_num_rows($res);

       if($count == 1){
         //User Exists and password can be change
        //  echo "User found";
        //check whether the new password and confirm pass match or not
        if($new_password == $confirm_password){
          //udpate the pass
         // echo "fdds";
         $sql2 = "UPDATE tbl_admin SET
                password = '$new_password'
                WHERE  id = $id
         ";

         //executet the query
         $res2 = mysqli_query($conn, $sql2);

         //check the query executed or not
         if($res2){
           //display success message
           $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully</div>";
           //redirect the user
           header("location:".SITEURL.'admin/manage-admin.php');
         }
         else{
            //display error message
            $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password</div>";
            //redirect the user
            header("location:".SITEURL.'admin/manage-admin.php');
         }

        }
        else{
          //redirect to manage admin page with error meesage
          $_SESSION['pwd-not-match'] = "<div class='error'>password Not Match</div>";
          //redirect the user
          header("location:".SITEURL.'admin/manage-admin.php');
        }

       }
       else{
         //User Does not Exist Set meesage and redirect
         $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
         //redirect the user
         header("location:".SITEURL.'admin/manage-admin.php');
       }
    }

    //3. Check whether the new password and confirm passord not Match or not

    //4. Change password if all above is true
  }


?>

<?php include('partrials/footer.php') ?>