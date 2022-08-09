<?php include('partrials/menu.php'); ?>
<div class="main_content">
  <div class="wrapper">
    <h1>Update Food</h1>
    <br><br><br>


    <?php
    //check whether the id is set or not
    if(isset($_GET['id'])){
      //get the ID and all other deltails
     // echo 'Getting the data';
     $id = $_GET['id'];
     //create SQL query to get all other detals
     $sql2 = "SELECT * from tbl_food where id = $id";

     //Execute the query
     $res2 = mysqli_query($conn, $sql2);

     //count to rows to check whether the id is valid or not
     $count = mysqli_num_rows($res2);

     if($count == 1){
       //get all the data
       $row2 = mysqli_fetch_assoc($res2);
       $title = $row2['title'];
       $description = $row2['description'];
       $price = $row2['price'];
       $current_image = $row2['image_name'];
       $current_category = $row2['category_id'];
       $active = $row2['active'];
       $featured =  $row2['featured'];
       
     }
     else{
       //redirect to manage food with session message
       $_SESSION['no-food-found'] ="<div class='error'>Food Not Found.</div>";
       header('location:'.SITEURL.'admin/manage-food.php');
     }


    }
    else{
      //redirect to manage food
      header('location:'.SITEURL.'admin/manage-food.php');
    }

    ?>


    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td>Title: </td>
          <td>
            <input type="text" name="title" value="<?php echo $title; ?>" >
          </td>
        </tr>

        <tr>
          <td>Description: </td>
          <td>
            <textarea name="description"  cols="30" rows="5" ><?php echo $description; ?></textarea>
          </td>
        </tr>

        <tr>
          <td>Price: </td>
          <td>
            <input type="number" name="price" value="<?php echo $price; ?>">
          </td>
        </tr>

        <tr>
          <td>Current Image: </td>
          <td>
            <?php 
              if($current_image !=""){
                //display the image
                ?>
                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image ?>" width="150px" >

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
          <td>Select new Imnage: </td>
          <td>
            <input type="file" name="image">
          </td>
        </tr>

        <tr>
          <td>Category: </td>
          <td>
            <select name="category" >

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
                    $category_id = $row['id'];
                    $category_title = $row['title'];
                    ?>
                    <!-- why choose values is $id insead of title??????????// -->
                    <!-- noteeeeeeeeee selected -->
                      <option <?php if($current_category==$category_id){echo "selected";}  ?>
                      value="<?php echo $category_id; ?>"><?php  echo $category_title; ?></option> 

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
            <input <?php if($featured =="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
            <input <?php if($featured =="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
          </td>
        </tr>

        <tr>
          <td>Active: </td>
          <td>
            <input <?php if($featured =="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
            <input <?php if($featured =="No"){echo "checked";} ?> type="radio" name="active" value="No">No
          </td>
        </tr>

        <tr>
          <td>
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Update food" class="btn-secondary">
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
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category =$_POST['category'];
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
                      $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext; //e.g Food_name_843.ipg

                      $source_path = $_FILES['image']['tmp_name'];

                      $destination_path = "../images/food/".$image_name;

                      //Finally upload the image
                      $upload = move_uploaded_file($source_path, $destination_path);

                      //Check whether the image is upload or not
                      //And if the image is not uploaded then we will stop the process and redirect with error message
                      if($upload==false){
                        //set message
                        $_SESSION['upload'] ="<div class='error'>Failed to Upload new Image.</div>";
                        //Redicrect to AddcCategory page
                        header("location:".SITEURL.'admin/manage-food.php');
                        //stop process
                        die();
                      }
                  //Remove the Current Image if available
                  if($current_image !=""){
                    $remove_path ="../images/food/".$current_image;
                    $remove = unlink($remove_path);
      
                    //Check the whether is image is removed or not
                    //if failed to remove, then display  message and stop the process
                    if($remove == false){
                      //failed to remove image
                      $_SESSION['failed-remove'] ="<div class='error'>Failed to remove current Image.</div>";
                      header("location:".SITEURL.'admin/manage-food.php');
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
            $sql3 = "UPDATE tbl_food SET
              title = '$title',
              description ='$description',
              price =$price,
              category_id = '$category',
              
              active = '$active',
              featured = '$featured',
              image_name ='$image_name'
              WHERE id = $id
            ";
            //execute the query
            $res3 = mysqli_query($conn,$sql3);

            //4.Redirect to manage Food with message
            //check whether executed or not
            if($res3 == true){
              //Food updated
              $_SESSION['update'] ="<div class='success'>Food Updated Successfully  </div>";
              header("location:".SITEURL.'admin/manage-food.php');
            }
            else{
              //failed to update category
              $_SESSION['update'] ="<div class='error'>Food Updated Failed</div>";
              header("location:".SITEURL.'admin/manage-food.php');

            }
            
          }

        ?>


  </div>
</div>

<?php include('partrials/footer.php'); ?>