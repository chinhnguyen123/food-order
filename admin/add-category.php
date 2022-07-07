<?php include('partrials/menu.php') ?>

<div class="main_content">
  <h1>Add Category</h1>
  <br><br>

  <?php
      if(isset($_SESSION['add'])){
        echo $_SESSION['add'];//display
        unset($_SESSION['add']);//removw
      }
      if(isset($_SESSION['upload'])){
        echo $_SESSION['upload'];//display
        unset($_SESSION['upload']);//removw
      }
  ?>
  <br><br>

  <!-- Add category Form Starts -->
  <!-- multipart data to display image in form -->

  <form action="" method="POST" enctype="multipart/form-data">
    <table class="tbl-30">
      <tr>
        <td>Title</td>
        <td>
          <input type="text" name="title" placeholder="Category Title">
        </td>
      </tr>
      <tr>
        <td>Select Image: </td>
        <td>
          <input type="file" name="image">
        </td>
      </tr>

      <tr>
        <td>Featured: </td>
        <td>
          <input type="radio" name="featured" value="Yes">Yes
          <input type="radio" name="featured" value="No">No
        </td>
      </tr>

      <tr>
        <td>Active: </td>
        <td>
          <input type="radio" name="active" value="Yes">Yes
          <input type="radio" name="active" value="No">No
        </td>
      </tr>

      <tr>
        <td colspan="2"> 
          <input type="submit" name="submit" value="Add Category" class="btn-secondary"> 

        </td>
      </tr>

    </table>
  </form>


  <!-- Add category Form Ends -->

  <?php
    //check whether the submit button is clicked or not
    if(isset($_POST['submit'])){
      //echo "Clicked";
      //1. Get the value from Category form
      $title = $_POST['title'];

      //For radio input, we need to check whether the button is selected or not
      if(isset($_POST['featured'])){
        //Get the value from form
        $featured = $_POST['featured'];
      }
      else{
        //Set the default value
        $featured = "No";
      }

      if(isset($_POST['active'])){
        //Get the value from form
        $active = $_POST['active'];
      }
      else{
        //Set the default value
        $active = "No";
      }

      //check whether the image is selected or not and set the value for image name accoridingly
     // print_r($_FILES['image']);
      //die(); break the code
      if(isset($_FILES['image']['name'])){
        //upload the image
        //To upload image we need image name, source path and destination path
        $image_name = $_FILES['image']['name'];

        //upload the image only if image is selected
        if($image_name !=''){
          
            //auto rename or image
          //get the extension of our imgae(ipg, png, gif, etc)...
          $ext = end(explode('.', $image_name));//lay duoc phan duoi

          //rename the image
          $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g Food_Category_843.ipg

          $source_path = $_FILES['image']['tmp_name'];

          $destination_path = "../images/category/".$image_name;

          //Finally upload the image
          $upload = move_uploaded_file($source_path, $destination_path);

          //Check whether the image is upload or not
          //And if the image is not uploaded then we will stop the process and redirect with error message
          if($upload==false){
            //set message
            $_SESSION['upload'] ="<div class='error'>Failed to Upload Image.</div>";
            //Redicrect to AddcCategory page
            header("location:".SITEURL.'admin/add-category.php');
            //stop process
            die();
          }

        }

        
      }
      else{
        //DOnt upload image add set the image_name value as blank
        $image_name="";
      }


      //2. Create SQL Query to insert Category into Database
      $sql = "INSERT INTO tbl_category SET
        title = '$title',
        image_name = '$image_name',
        featured = '$featured',
        active = '$active'
      ";

      //3.Executed the query and save in database
      $res = mysqli_query($conn, $sql);

      //4. Check whether the query  executed or not and data added or not
      if($res==true){
        //query executed and Category 
        $_SESSION['add'] ="<div class='success'>Category Added Successfully</div>";
        //REdirect to Manage Category Page
        header("location:".SITEURL.'admin/manage-category.php');
      }
      else{
        //Failed to Add Category
        $_SESSION['add'] ="<div class='error'>Failed to Add  Successfully</div>";
        //REdirect to Manage Category Page
        header("location:".SITEURL.'admin/add-category.php');
      }
    }

  ?>
</div>

<?php include('partrials/footer.php') ?>