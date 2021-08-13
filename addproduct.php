<?php
session_start();
require_once "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <div class="container">
    <h3>Add product to store</h3>
    <?php if (!empty($statusMsg)) { ?> 
    <p class="status <?php echo $status; ?>"><?php echo $statusMsg;?></p>
    <?php } ?>

    <form action="addproduct.php" method="post" enctype="multipart/form-data">

    <label for="name">Product Name: </label>
    <input type="text" name="name">

    <br><br>

    <label for="price">Product Price: </label>
    <input type="number" name="price">

    <br><br>

    <label for="image">Select Image File: </label>
    <input type="file" name="image">

    <br><br>

    <input type="submit" value="SUBMIT" name="submit">

    </form>
    </div>

    <?php
        $status = $statusMsg = '';
        if(isset($_POST["submit"])){
            if(!empty($_FILES['image']['name'])) {
                // Get the file info
                $fileName = basename($_FILES['image']['name']);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                $name = $_POST['name'];
                $price = $_POST['price'];
                $status = 'error';

                // Allow certain file formats
                $allowTypes = array('jpg','png','jpeg','gif');
                if(in_array($fileType, $allowTypes)){
                    $image = $_FILES['image']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));

                //Select from Database 
                $select = "SELECT * FROM PRODUCT WHERE 1";
                // Insert image content into database
                $insert = $conn->query("INSERT into PRODUCT(prd_name, prd_price, prd_img) VALUES ('$name', '$price', '$imgContent')");
                if($insert){
                        $status = 'success';
                        $statusMsg = "File uploaded successfully.";
                    } else {
                       $statusMsg = "File upload failed. Please try again."; 
                    }
                } else { 
                    $statusMsg = "Only JPG, JPEG, PNG, & GIF files are allowed.";
                }
            } else {
                $statusMsg = "Please select a file.";
            }
            echo $statusMsg;
            header("location: store.php");
            exit;
        }

        
    ?>
</body>
</html>