<?php include('partrials/menu.php')  ?>

<div class="main_content">
  <div class="wrapper">
    <h1>Manage Category</h1>
    <br><br><br>
    <?php
      if(isset($_SESSION['add'])){
        echo $_SESSION['add'];//display
        unset($_SESSION['add']);//removw
      }
      if(isset($_SESSION['remove'])){
        echo $_SESSION['remove'];//display
        unset($_SESSION['remove']);//removw
      }
      if(isset($_SESSION['delete'])){
        echo $_SESSION['delete'];//display
        unset($_SESSION['delete']);//removw
      }
      if(isset($_SESSION['no-category-found'])){
        echo $_SESSION['no-category-found'];//display
        unset($_SESSION['no-category-found']);//removw
      }
      if(isset($_SESSION['update'])){
        echo $_SESSION['update'];//display
        unset($_SESSION['update']);//removw
      }
      if(isset($_SESSION['upload'])){
        echo $_SESSION['upload'];//display
        unset($_SESSION['upload']);//removw
      }
      if(isset($_SESSION['failed-remove'])){
        echo $_SESSION['failed-remove'];//display
        unset($_SESSION['failed-remove']);//removw
      }
    ?>
    <br><br>
  
       <!-- Button to add category -->
       <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>


       <table class="tbl_full">
         <tr>
           <th>Seri Number</th>
           <th>Title</th>
           <th>Image</th>
           <th>Featured</th>
           <th>Active</th>
           <th>Actions</th>
         </tr>
        <?php
            //query to get all categories from database
            $sql = "SELECT * FROM tbl_category";

            //executeQuery
            $res = mysqli_query($conn, $sql);

            //count Rows
            $count = mysqli_num_rows($res); 

            //create serial Number Variable and assign value as 1
            $sn = 1;

            //check the whether we have data in database or not
            if($count>0){
              //we have data in database
              //get the data and display
              while($row = mysqli_fetch_assoc($res)){
                $id = $row['id']; 
                $title = $row['title']; 
                $image_name = $row['image_name']; 
                $featured = $row['featured']; 
                $active = $row['active']; 

                ?>
                   <tr>
                    <td><?php echo $sn++ ?></td>
                    <td><?php echo $title ?></td>

                    <td>
                        <?php 
                        //check whether image name is availble or not
                        if($image_name!=""){
                          //display the image
                          ?>
                          <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>" width="100px" >
                          <?php


                        }
                        else{
                          //display the message
                          echo "<div class='error'>Image not Added. </div>";
                        }
                        ?>
                    </td>

                    <td><?php echo $featured ?></td>
                    <td><?php echo $active ?></td>
                    <td>
                      <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id;?>" class="btn-secondary">Update Category </a>
                      <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id ?>&image_name=<?php  echo $image_name;?>" class="btn-danger"> Delete Category</a>
                    </td>
                  </tr>
                <?php

              }
            }
            else{
              //we do not have dataa
              //we will display the mesaage inside table
              ?>

              <tr>
                <td colspan="6"><div class="error">No Category Added.</div></td>
              </tr>

              <?php
            }

        ?>
       </table>
  </div>
</div>


<?php include('partrials/footer.php')  ?>