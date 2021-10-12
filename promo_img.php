<?php

if(isset($_POST['submit'])){

  
            
  $status = 'error';
  if(!empty($_FILES['banner_img']['name'])) {
      // Get the file info
      $fileName = basename($_FILES['banner_img']['name']);
      $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

      // Allow certain file formats
      $allowTypes = array('jpg','png','jpeg','gif');
        if(in_array($fileType, $allowTypes)){
          $image      = $_FILES['banner_img']['tmp_name'];
          $imgContent = addslashes(file_get_contents($image));

      // $select = "SELECT * FROM promo_banner Where 1";

      // Insert image content into database
      $insert = $conn->query("INSERT INTO promo_banner (banner_img) VALUES ('$imgContent')");

      if($insert){
              $status = 'success';
              $statusMsg = "File uploaded successfully.";
              echo "<script>
              Qual.info('Thank you for joining Beetriv!','Runner dashboard will appear on your profile once your documentation has been reviewed.');
              </script>";
              // $updte = $conn->query("UPDATE users SET type='runner' WHERE email='$email'");
          } else {
             $statusMsg = "File upload failed. Please try again."; 
          }
      } else { 
          $statusMsg = "Only JPG, JPEG, PNG, & GIF files are allowed.";
      }
      //update user type
      
  }
  // $updte = $conn->query("UPDATE users SET type='runner' WHERE email='$email'");
   else {
      $statusMsg = "Select a file.";
  }
  // $updte = $conn->query("UPDATE users SET type='runner' WHERE email='$email'");
}

//echo $statusMsg;
?>