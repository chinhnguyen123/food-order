<?php 
  include('partrials/menu.php');
?>

<!-- Main content section starts -->
<div class="main_content">
  <div class="wrapper">
        <!-- <strong>DASHBOARD</strong> -->
        <h1>Dashboard</h1>
        <?php
          if(isset($_SESSION['login']))
          echo $_SESSION['login'];//display
          unset($_SESSION['login']);//removw

        ?>
        <div class="col-4 text_center">
          <?php  
            $sql = "SELECT * from tbl_category";
            //execute
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);


          ?>
          <h1><?php echo $count; ?></h1>
          <br/>
          Categories
        </div>

        <div class="col-4 text_center">
          <?php  
            $sql2 = "SELECT * from tbl_food";
            //execute
            $res2 = mysqli_query($conn, $sql2);

            $count2 = mysqli_num_rows($res2);


          ?>
          <h1><?php echo $count2; ?></h1>
          <br/>
          Foods
        </div>

        <div class="col-4 text_center">

          <?php  
              $sql3 = "SELECT * from tbl_order";
              //execute
              $res3 = mysqli_query($conn, $sql3);

              $count3 = mysqli_num_rows($res3);

          ?>
          <h1><?php echo $count3; ?></h1>
          <br/>
          Total Orders
        </div>

        <div class="col-4 text_center">
          <?php  
              $sql4 = "SELECT sum(total) as Total from tbl_order where status='Delivered'";
              //execute
              $res4 = mysqli_query($conn, $sql4);

              //get the valuies
              $row4= mysqli_fetch_assoc($res4);

              //get the total
              $total_revenue = $row4['Total'];


             
          ?>
          <h1>$<?php echo $total_revenue; ?></h1>
          <br/>
          Revenue Generated
        </div>

        <div class="clear_fix"></div>

  </div>
</div>
<!-- Main content section Ends -->

<?php 
  include('partrials/footer.php');
?>