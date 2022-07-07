<?php include('partrials/menu.php'); ?>

<div class="main_content">
  <div class="wrapper">
    <h1>Update categoory</h1>

    <br><br>

    <?php
    //check whether the id is set or not
    if(isset($_GET['id'])){
      //get the ID and all other deltails
     // echo 'Getting the data';
     $id = $_GET['id'];
     //create SQL query to get all other detals
     $sql = "SELECT * from tbl_category where id = $id";

     //Execute the query
     $res = mysqli_query($conn, $sql);

     //count to rows to check whether the id is valid or not
     $count = mysqli_num_rows($res);

     if($count == 1){
       //get all the data
       $row = mysqli_fetch_assoc($res);
       $title = $row['title'];
       $current_image = $row['image_name'];
       $active = $row['active'];
       $featured =  $row['featured'];
       
     }
     else{
       //redirect to manage category with session message
       $_SESSION['no-category-found'] ="<div class='error'>Category Not Found.</div>";
       header('location:'.SITEURL.'admin/manage-category.php');
     }


    }
    else{
      //redirect to manage category
      header('location:'.SITEURL.'admin/manage-category.php');
    }

    ?>
    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td>Title: </td>
          <td>
            <input type="text" name="title" value="<?php echo $title; ?>">
          </td>
        </tr>

        <tr>
          <td>Current Image: </td>
          <td>
            <?php 
            if($current_image !=""){
              //display the image
              ?>
              <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image ?>" width="150px" >

              <?php
            }
            else{
              //display the message
              echo "<div class='error'>Image not Added. </div>";
            }
             ?>
          </td>
        </tr>

        <tr>
          <td>New Image: </td>
          <td>
            <input type="file" name="image">
          </td>
        </tr>

        <tr>
          <td>Featured: </td>
          <td>
            <input <?php if($featured =="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
            <input <?php if($featured =="No"){echo "checked";} ?> type="radio" name="featured" value="No">No

          </td>
        </tr>
        <tr>
          <td>Active: </td>
          <td>
             <input <?php if($active =="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
             <input <?php if($active =="No"){echo "checked";} ?> type="radio" name="active" value="No">No
          </td>
        </tr>
        <tr>
          <td>
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
          </td>
        </tr>
      </table>

    </form>

    <?php
      if(isset($_POST['submit'])){
        echo "clicked";
        //1.get all the values from our form
        $id = $_POST['id'];
        $title = $_POST['title'];
        $current_image = $_POST['current_image'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

      

        //2.Updating New Image if selected
        //check whether the image
        if(isset($_FILES['image']['name'])){
            //get the image detals
            $image_name =  $_FILES['image']['name'];

            //Check whether the image is availble or not
            if($image_name != ""){

                //image Available
                //upload the new Image
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
                    header("location:".SITEURL.'admin/manage-category.php');
                    //stop process
                    die();
                  }
              //Remove the Current Image if available
              if($current_image !=""){
                $remove_path ="../images/category/".$current_image;
                $remove = unlink($remove_path);
  
                //Check the whether is image is removed or not
                //if failed to remove, then display  message and stop the process
                if($remove == false){
                  //failed to remove image
                  $_SESSION['failed-remove'] ="<div class='error'>Failed to remove current Image.</div>";
                  header("location:".SITEURL.'admin/manage-category.php');
                  die();//stop the process
                }
              }
              
            }
            else{
              $image_name = $current_image;
            }

        }
        else{
          $image_name = $current_image;
        }
        

        //3.Update the database
        $sql2 = "UPDATE tbl_category SET
          title = '$title',
          
          active = '$active',
          featured = '$featured',
          image_name ='$image_name'
          WHERE id = $id
        ";
        //execute the query
        $res2 = mysqli_query($conn,$sql2);

        //4.Redirect to manage Category with message
        //check whether executed or not
        if($res2 == true){
          //category updated
          $_SESSION['update'] ="<div class='success'>Category Updated Successfully  $active  </div>";
          header("location:".SITEURL.'admin/manage-category.php');
        }
        else{
          //failed to update category
          $_SESSION['update'] ="<div class='error'>Category Updated Failed</div>";
          header("location:".SITEURL.'admin/manage-category.php');

        }
        
      }

    ?>
   
  </div>
</div>
<?php include('partrials/footer.php'); ?> 
