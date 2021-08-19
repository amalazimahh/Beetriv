<?php
session_start();
require_once "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
        <meta name="author" content="" />
    <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/footer.css">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/user-profile.css">
    <style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #fff;
  color: black;
  padding: 12px 20px;
  border: none;
  border-radius: 20px;
  cursor: pointer;
  float: right;
  margin-top: 50px;
  margin-bottom: 30px;
}

input[type=submit]:hover {
  background-color: #ead3d7;
}

.prd-container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}

.add-prd {
        padding-top: 20px;
        margin-bottom: 20px;
        margin-left: 80px;
        padding-left: 20px;
      }
</style>

    <title>Add Product</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="store.php">Beetriv</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="store.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<div class="prd-container">
<div class="add-prd"><h3>New Item Details</h3></div>
<hr>
  <form action="/action_page.php">
    <div class="row">
      <div class="col-25">
        <label for="fname">Product Name</label>
      </div>
      <div class="col-75">
        <input type="text" name="name">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="category">Product Category</label>
      </div>
      <div class="col-75">
        <select name="category">
        <option value="Select">Select</option>
          <option value="Clothing">Clothing</option>
          <option value="Electronics">Electronics</option>
          <option value="Kitchen Appliances">Kitchen Appliances</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="price">Product Price</label>
      </div>
      <div class="col-75">
        <input type="text" name="price">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="quantity">Product Quantity</label>
      </div>
      <div class="col-75">
        <input type="text" name="quantity">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="condition">Product Condition</label>
      </div>
      <div class="col-75">
        <input type="radio" name="condition" value="New">
    <label for="New">New</label>
    <input type="radio" name="condition" value="Used">
    <label for="Used">Used</label>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="description">Product Description</label>
      </div>
      <div class="col-75">
        <textarea name="description" placeholder="Write something.." style="height:200px"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="rating">Product NumericRating</label>
      </div>
      <div class="col-75">
        <input type="text" name="rating">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="meetup">Meet-up Location</label>
      </div>
      <div class="col-75">
        <input type="text" name="meetup">
      </div>
    </div>

    <!-- bid details -->
    <div class="add-prd"><h3>Bid Details</h3></div>
    <hr>
    <div class="row">
      <div class="col-25">
        <label for="bid_stat">Bid Status</label>
      </div>
      <div class="col-75">
    <input type="radio" name="bid_status" id="yes" onkeyup="compare_input();" value="Yes">
    <label for="Yes">Yes</label>
    <input type="radio" name="bid_status" id="no" onkeyup="compare_input();" value="No">
    <label for="No">No</label>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="time_limit">Bid Time Limit</label>
      </div>
      <div class="col-75">
        <input type="text" name="time_limit" id="time_limit">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="start_bid">Starting Bid</label>
      </div>
      <div class="col-75">
        <input type="text" name="start_bid" id="start_bid">
      </div>
    </div>
    
    <!-- item media and tags -->
    <div class="add-prd"><h3>Item Media</h3></div>
    <hr>
    
	<div class="row">
      <div class="col-25">
        <label for="image">Select Image File </label>
      </div>
      <div class="col-75">
        <input type="file" name="image">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="tags">Add Tags</label>
      </div>
      <div class="col-75">
        <input type="text" name="tags" placeholder="vintage, summer, red..">
      </div>
    </div>
    
    <div class="row">
      <input type="submit" value="Submit">
    </div>
  </form>
</div>

    <!-- <script>
    document.getElementById("time_limit").disabled = true;
                document.getElementById("start_bid").disabled = true;
        function compare_input(){
            if(document.querySelector('input[name="bid_status"]:checked').value === "Yes"){
                document.getElementById("time_limit").disabled = false;
                document.getElementById("start_bid").disabled = false;
        }
        }
        
    </script> -->

      <!-- Footer-->
      <footer class="site-footer">

<div class="container">
    <div class="row">
    <!-- first section -->
    <div class="col-xs-6 col-md-3">
        <h6>CORPORATE</h6>
        <ul class="footer-links">
            <li><a href="footer/about.php">About Beetriv</a></li>
            <li><a href="footer/privacy-policy.php">Privacy Policy</a></li>
            <li><a href="footer/termsco.php">Terms and Conditions</a></li>
        </ul>
    </div>

    <!-- second section -->
    <div class="col-xs-6 col-md-3">
        <h6>DEALS, PAYMENT & DELIVERY</h6>
        <ul class="footer-links">
            <li><a href="footer/deals.php">Our Deals</a></li>
            <li><a href="footer/delivery.php">Delivery Services</a></li>
            <li><a href="footer/payment.php">Payment</a></li>
        </ul>
    </div>

    <!-- third section -->
    <div class="col-xs-6 col-md-3">
        <h6>CUSTOMER CARE</h6>
        <ul class="footer-links">
            <li><a href="footer/be-seller.php">Become Our Seller</a></li>
            <li><a href="footer/buy-guides.php">How to Buy on Beetriv</a></li>
            <li><a href="footer/sell-guides.php">How to Sell on Beetriv</a></li>
            <li><a href="footer/bid-guides.php">How Bidding Works</a></li>
            <li><a href="footer/customer-protection.php">Customer Protection</a></li>
            <li><a href="footer/faq.php">FAQ</a></li>
        </ul>
    </div>

    <!-- fourth section -->
    <div class="col-xs-6 col-md-3">
        <h6>CONTACT US</h6>
        <p>Phone: 257 3663</p>
        <p>Email: beetrivteam@gmail.com</p>
        <p>Instagram: @beetriv</p>
        <p>Facebook: @beetriv</p>
    </div>
  </div>
</div>
</footer>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>

    <?php
        $status = $statusMsg = '';
        if(isset($_POST["submit"])){
            if(!empty($_FILES['image']['name'])) {
                // Get the file info
                $fileName = basename($_FILES['image']['name']);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                $name = $_POST['name'];
                $category = $_POST['category'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $description = $_POST['description'];
                $rating = $_POST['rating'];
                $meetup = $_POST['meetup'];
                $bid_status = $_POST['bid_status'];
                $condition = $_POST['condition'];
                $time_limit = $_POST['time_limit'];
                $start_bid = $_POST['start_bid'];
                $status = 'error';

                // Allow certain file formats
                $allowTypes = array('jpg','png','jpeg','gif');
                if(in_array($fileType, $allowTypes)){
                    $image = $_FILES['image']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));

                //Select from Database 
                $select = "SELECT * FROM NEW_PRODUCT WHERE 1";
                // Insert image content into database
                $insert = $conn->query("INSERT into NEW_PRODUCT(prd_name,prd_category, prd_price, prd_qty, prd_desc, prd_rate, prd_meetup, prd_bidstat, prd_img) VALUES ('$name', '$category', '$price', '$quantity', '$description', '$rating', '$meetup', '$bid_status', '$imgContent')");
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

