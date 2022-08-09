<?php include('partrials/menu.php')  ?>
<div class="main_content">
  <div class="wrapper">
    <h1>Manage Food</h1>
    <br><br><br>
       <!-- Button to add food -->
       <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>

       <br><br><br>
       <?php
         if(isset($_SESSION['add'])){
          echo $_SESSION['add'];//display
          unset($_SESSION['add']);//removw
        }
        if(isset($_SESSION['delete'])){
          echo $_SESSION['delete'];//display
          unset($_SESSION['delete']);//removw
        }
        if(isset($_SESSION['upload'])){
          echo $_SESSION['upload'];//display
          unset($_SESSION['upload']);//removw
        }
        if(isset($_SESSION['unauthorize'])){
          echo $_SESSION['unauthorize'];//display
          unset($_SESSION['unauthorize']);//removw
        }
        if(isset($_SESSION['no-food-found'])){
          echo $_SESSION['no-food-found'];//display
          unset($_SESSION['no-food-found']);//removw
        }
        if(isset($_SESSION['update'])){
          echo $_SESSION['update'];//display
          unset($_SESSION['update']);//removw
        }
        if(isset($_SESSION['failed-remove'])){
          echo $_SESSION['failed-remove'];//display
          unset($_SESSION['failed-remove']);//removw
        }
        


       ?>


       <table class="tbl_full">
         <tr>
           <th>Seri Number</th>
           <th>Title</th>
           <th>Price</th>
           <th>Image</th>
           <th>Featured</th>
           <th>Active</th>
           <th>Actions</th>
         </tr>

         <?php
          //create a sql query to ge all the food
          $sql = "SELECT * FROM tbl_food";

          //execute query
          $res = mysqli_query($conn, $sql);

          //count row to check
          $count = mysqli_num_rows($res);
          //create seiral number
          $sn=1;

          if($count>0){
            //we  have food in database
            //get the foods from databse and display
            while($row= mysqli_fetch_assoc($res)){
              //get the values from individual columns
              $id = $row['id'];
              $title = $row['title'];
              $price = $row['price'];
              $image_name = $row['image_name'];
              $featured = $row['featured'];
              $active = $row['active'];

              ?>
                <tr>
                  <td><?php echo $sn++;?></td>
                  <td><?php echo $title;?></td>
                  <td><?php echo $price;?></td>
                  <td>
                       <?php 
                          //check whether image name is availble or not
                          if($image_name!=""){
                            //display the image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name;?>" width="100px" >
                            <?php


                          }
                         else{
                          //display the message
                          echo "<div class='error'>Image not Added. </div>";
                         }
                       ?>
                   </td>
                  <td><?php echo $featured;?></td>
                  <td><?php echo $active;?></td>
                  <td>
                    <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update food </a>
                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name; ?>" class="btn-danger"> Delete food </a>
                    
                  </td>
                </tr>

              <?php
            }
          }
          else{
            //food not add in database
            echo "<tr><td colspan='7' class='error'>Food not Add yet  </td> </tr>";
          }
         ?>
         
       </table>
  </div>
</div>


<?php include('partrials/footer.php')  ?>