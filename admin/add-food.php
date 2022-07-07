<?php include('partrials/menu.php'); ?>

<div class="main_content">
  <div class="wrapper">
    <h1>Add Food</h1>

    <br><br>

    <?php
       if(isset($_SESSION['upload'])){
        echo $_SESSION['upload'];//display
        unset($_SESSION['upload']);//removw
      }
      if(isset($_SESSION['add'])){
        echo $_SESSION['add'];//display
        unset($_SESSION['add']);//removw
      }
    ?>
    <form action="" method="POST" enctype = "multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td>Title: </td>
          <td>
            <input type="text" name="title" placeholder="Title of the Food">
          </td>
        </tr>

        <tr>
          <td>Description: </td>
          <td>
            <textarea name="description"  cols="30" rows="5" placeholder="Description of the Food"></textarea>
          </td>
        </tr>

        <tr>
          <td>Price: </td>
          <td>
            <input type="number" name="price" >
          </td>
        </tr>

        <tr>
          <td>Select Image: </td>
          <td>
            <input type="file" name="image">
          </td>
        </tr>

        <tr>
          <td>Category: </td>
          <td>
            <select name="category">
              <?php
                //create php code to display categories from database
                //1. CreateSQL to get all active categories from database
                $sql = "SELECT * from tbl_category where active='Yes'";

                //executing query
                $res = mysqli_query($conn, $sql);

                //count rows to check  whether we have categories or not
                $count = mysqli_num_rows($res);

                //if count is greater than 0, we have categories else we do not have categories
                if($count>0){
                  //we have categories
                  while($row = mysqli_fetch_assoc($res)){
                    //get the details of categories
                    $id = $row['id'];
                    $title = $row['title'];
                    ?>
                    <!-- why choose values is $id insead of title??????????// -->
                      <option value="<?php echo $id; ?>"><?php  echo $title; ?></option> 

                    <?php

                  }
                }
                else{
                  //we do not have categories
                  ?>
                  <option value="0">No Category Found</option>

                  <?php
                }

                


                //2.Display on dropdown

              ?>
            </select>
          </td>
        </tr>

        <tr>
          <td>Featured: </td>
          <td>
            <input type="radio" name="featured" value="Yes"> Yes
            <input type="radio" name="featured" value="No"> No
          </td>
        </tr>

        <tr>
          <td>Active: </td>
          <td>
            <input type="radio" name="active" value="Yes"> Yes
            <input type="radio" name="active" value="No"> No
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
          </td>
        </tr>

      </table>
    </form>


    <?php
    //check the whether the button is clicked or not
    if(isset($_POST['submit'])){
      //add food in database

      //1.Get the data from form
      $title = $_POST['title'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $category = $_POST['category'];

      //check the radio button for featured and active are checked or not
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
      //2.Upload the image if selected
      //check  whether the select image is clicked  or not and upload the image only if 
      //the image is selected
      if(isset($_FILES['image']['name'])){
        //get the details of the select image
        $image_name = $_FILES['image']['name'];

        //check whether the image is selected or not and upload image only if selected
        if($image_name !=""){
          //image is selected
          //A.rename the image
          //get the extension of selected image(jpg, png...)
          $ext = end(explode('.',$image_name));

          //create new name for image
          $image_name = "Food-Name-".rand(0000,9999).".".$ext;//new name

          //B. Upload the image
          //get the src path and destination path

          //source path is current location of image
          $src = $_FILES['image']['tmp_name'];

          //destination path for the image uploaded
          $dst = "../images/food/".$image_name;

          //finally upload the food image
          $upload = move_uploaded_file($src, $dst);

          //check the whether image uploaded or not
          if($upload == false){
            //failed to upload
            //redirect
            $_SESSION['upload'] ="<div class='error'>Failed to Upload Image.</div>";
            //Redicrect to AddcCategory page
            header("location:".SITEURL.'admin/add-food.php');
            die();
          }


        }
        

      }
      else{
        $image_name = "";//setting default values is blank
      }

      //3.Insert into database
      //create a SQLquery to save or add food
      $sql2 = "INSERT INTO tbl_food SET
      title = '$title',
      description = '$description',
      price = $price,
      image_name = '$image_name',
      category_id = '$category',
      featured = '$featured',
      active = '$active'
      ";

      //execute the query
      $res2 = mysqli_query($conn, $sql2);

      //check whether data inserted or not
      if($res2==true){
        //data inserted successfully
        $_SESSION['add'] ="<div class='success'>Category Added Successfully</div>";
        //REdirect to Manage Fodd Page
        header("location:".SITEURL.'admin/manage-food.php');
      }
      else{
        //Failed to Add Food
        $_SESSION['add'] ="<div class='error'>Failed to Add Food.</div>";
        //REdirect to Manage Food Page
        header("location:".SITEURL.'admin/add-food.php');
      }

      //4.Redirect with message to manage food page
    }
    ?>
  </div>
</div>



<?php include('partrials/footer.php'); ?>