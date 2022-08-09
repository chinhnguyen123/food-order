<?php
  include('../config/constants.php');

  if(isset($_GET['id']) && isset($_GET['image_name'])){
   // echo "process to delete";
   //1.Get Id and image name
   $id = $_GET['id'];
   $image_name = $_GET['image_name'];

   
   //2.Remove the image if available
   //check whether the image is available or not and delete only of available
   if($image_name !=""){
     //IT has image and need to remove from folder
     //Get the image path
     $path = "../images/food/".$image_name;

     //remove image file from folder
     $remove = unlink($path);

     //check whether the image is  removed or not
     if($remove = false){
       //failed to remove
        //set the session message
        $_SESSION['upload'] ="<div class='error'>Failed to Remove Food Image</div>";
        //redirect to  manage food page
        header('location:'.SITEURL.'admin/manage-food.php');
        //stop the process
        die();
     }
   }

   //3. Delete food from database
    //SQL query to delete from database
    $sql = "DELETE FROM tbl_food WHERE id = $id";

    //execute
    $res = mysqli_query($conn, $sql);

    //check whether the data is delete from database or not
    if($res==true){
      //set success message and redirect
      $_SESSION['unauthorize'] ="<div class='success'>Food Deleted Successfully</div>";
      //redirect to manage food
      header('location:'.SITEURL.'admin/manage-food.php');

    }
    else{
      //set failed
      $_SESSION['unauthorize'] ="<div class='error'>Failed to Delete Food.</div>";
      //redirect to manage food
      header('location:'.SITEURL.'admin/manage-food.php');
    }

   //4. Redirect
  }
  else{
   // echo "Redirect";
   //redirect to manage food page
   $_SESSION['delete'] ="<div class='error'>Failed to Delete Food.</div>";
   header('location:'.SITEURL.'admin/manage-food.php');
  }
?>