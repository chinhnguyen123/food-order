<?php 
  include('partrials/menu.php');
?>

<!-- Main content section starts -->
<div class="main_content">
  <div class="wrapper">
       <h1>Manage Admin</h1>
       <br /><br />
       <?php
      // echo "adss2";
        if(isset($_SESSION['add'])){
          echo $_SESSION['add'];//display
          unset($_SESSION['add']);//removw
        }
        if(isset($_SESSION['delete'])){
          echo $_SESSION['delete'];//display
          unset($_SESSION['delete']);//removw
        }

        if(isset($_SESSION['update'])){
          echo $_SESSION['update'];//display
          unset($_SESSION['update']);//removw
        }
        if(isset($_SESSION['user-not-found'])){
          echo $_SESSION['user-not-found'];//display
          unset($_SESSION['user-not-found']);//removw
        }
        if(isset($_SESSION['pwd-not-match'])){
          echo $_SESSION['pwd-not-match'];//display
          unset($_SESSION['pwd-not-match']);//removw
        }
        if(isset($_SESSION['change-pwd'])){
          echo $_SESSION['change-pwd'];//display
          unset($_SESSION['change-pwd']);//removw
        }

       ?>
       <br /><br><br>
       <!-- Button to add admin -->
       <a href="add-admin.php" class="btn-primary">Add Admin</a>


       <table class="tbl_full">
         <tr>
           <th>Seri Number</th>
           <th>Full name</th>
           <th>User name</th>
           <th>Actions</th>
         </tr>

             <?php
         //qurery to get all admin
         $sql = "SELECT * from tbl_admin ";

         //execute the query
         $res = mysqli_query($conn, $sql);

         //check whether the query is executed or not
         if($res){
            //count rows to check whether we have data in database or not
            $count = mysqli_num_rows($res);//function to get all the rows in database

            //create a variable  and assign the value
            $sn=1;

           //check the num of rows
           if($count > 0){
             //we have data in database
             while($rows = mysqli_fetch_assoc($res)){
               //using while loop to get all the data from database
               //and while loop will run as long as we have data in database

               //Get individual data
               $id = $rows['id'];
               $full_name = $rows['full_name'];
               $username = $rows['username'];

               //display the values in our table
               ?>
                 <tr>
                  <td><?php  echo $sn++;  ?></td>
                  <td><?php  echo $full_name;  ?></td>
                  <td><?php  echo $username;  ?></td>
                  <td>
                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id ?>" class="btn-primary">Change password</a>
                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id ?>" class="btn-secondary">Update admin </a>
                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id ?>" class="btn-danger"> Delete admin </a>
                    
                  </td>
                </tr>
              <?php
             }

           }
           else{
             //we do not have data in database

           }
         }

         ?>



         <!-- <tr>
           <td>1.</td>
           <td>Nguyen Chung Chinh</td>
           <td>Chinhnguyen</td>
           <td>
             <a href="#" class="btn-secondary">Update admin </a>
             <a href="#" class="btn-danger"> Delete admin </a>
             
           </td>
         </tr> -->
      
       </table>

  </div>
</div>
<!-- Main content section Ends -->

<?php 
  include('partrials/footer.php');
?>