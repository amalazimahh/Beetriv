<?php
ob_start();
session_start();
require_once "connection.php";

$email = $_SESSION['email'];
//echo $email;

$result = $conn->query("SELECT * FROM users WHERE email = '$email'");
$row    = $result->fetch(PDO::FETCH_ASSOC);

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

input[type=text], input[type=number], select, textarea {
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
 /* Remove arrows on number field */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.add-prd {
        padding-top: 20px;
        margin-bottom: 20px;
        margin-left: 80px;
        padding-left: 20px;
      }

.gallery img {
    height: 300px;
    width: 300px;
    margin: 30px 10px;
}
</style>

    <title>Add Product</title>
</head>
<body>

<!-- Navigation-->
        <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light" style='color:black' > 
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bid</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Active Bid</a></li>
                                <li><a class="dropdown-item" href="#!">Ending Soon</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav justify-content-end">
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="wishlist.php">
                    <i class="bi bi-heart" style='color:black'><?php echo (isset($_SESSION['wish_items']) && count($_SESSION['wish_items'])) > 0 ? count($_SESSION['wish_items']):''; ?></i>
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="cart.php">
                    <i class="bi bi-cart4" style='color:black'><?php echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):''; ?></i>
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="user-profile.php"><i class="bi-person-circle"></i></a></li>
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="login.php"><i class="bi bi-box-arrow-right"></i></a></li>
                    </a></li>
                    </ul>
                </div>
            </div>
        </nav>

<div class="prd-container">
<div class="add-prd"><h3>New Item Details</h3></div>
<hr>
  <form method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-25">
        <label for="name">Display Name</label>
      </div>
      <div class="col-75">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="text" name="display_name" placeholder="<?php echo $email; ?>" disabled>
      </div>
</div>
      <div class="row">
    <div class="col-25">
        <label for="name">Username</label>
      </div>
    <div class="col-75">
        <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
        <input type="text" name="username" placeholder="<?php echo $row['username']; ?>" disabled>
      </div>
</div>
<div class="row">
    <div class="col-25">
        <!-- <label for="name">Phone Number</label>
      </div>
    <div class="col-75"> -->
        <input type="hidden" name="phone_number" value="<?php echo $row['phone_number']; ?>">
        <!-- <input type="text" name="phone_number" placeholder="<?php echo $row['phone_number']; ?>" disabled> -->
      </div>
</div>
    <div class="row">
      <div class="col-25">
        <label for="price">Product Name</label>
      </div>
      <div class="col-75">
        <input type="text" name="prd_name" step="any">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="category">Product Category</label>
      </div>
      <div class="col-75">
      <select name="prd_category">
        <option value="Select">Select</option>
          <option value="Home">Home and Living</option>
          <option value="Fashion">Fashion</option>
          <option value="Mobile">Mobile and Electronics</option>
          <option value="Hobbies">Hobbies and Games</option>
          <option value="Cars">Cars and Property</option>
          <option value="Freebies">Freebies, Deals and More!</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="price">Product Price</label>
      </div>
      <div class="col-75">
        <input type="number" name="prd_price" step="any">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="quantity">Product Quantity</label>
      </div>
      <div class="col-75">
        <input type="number" name="prd_qty">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="condition">Product Condition</label>
      </div>
      <div class="col-75">
        <input type="radio" name="prd_condition" value="New"/>
    <label for="New">New</label>
    <input type="radio" name="prd_condition" value="Used">
    <label for="Used">Used</label>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="description">Product Description</label>
      </div>
      <div class="col-75">
        <textarea name="prd_desc" placeholder="Write something.." style="height:200px"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="prd_rating">Product Numeric Rating</label>
      </div>
      <div class="col-75">
        <input type="number" name="prd_rating">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="prd_location">Meet-up Location</label>
      </div>
      <div class="col-75">
      <select name="prd_location">
        <option value="Select">Select</option>
          <option value="KB">Kuala Belait</option>
          <option value="Tutong">Tutong</option>
          <option value="BSB">Bandar Seri Begawan</option>
          <option value="Temburong">Temburong</option>
        </select>
      
    </div>
        </div>

    <!-- bid details -->
    <div class="add-prd"><h3>Bid Details</h3></div>
    <hr>

    <div class="row">
      <div class="col-25">
        <label for="bid_stat">Please select bid status for product </label>
      </div>

      <div class="col-75">
        <select name="bid_status" id="bid_stat" class="col-75">
          <option value="no">No</option>
          <option value="yes">Yes</option>
        </select>
      </div>

      <div class="col-25" id="bid_details">
        <label for="bid_date">Choose Date Expiry</label>
      </div>

      <div class="col-75">
          <input type="date" name="date_expired" id="date_expired">
      </div>

      <div class="col-25" id="bid_details">
        <label for="time_expired">Choose Time Expiry</label>
      </div>

      <div class="col-75">
          <input type="time" name="time_expired" id="time_expired">
      </div>

      <!-- Starting Price for Bidding -->
      <div class="col-25" id="bid_details">
        <label for="starting_price">Enter Starting Price for Bid</label>
      </div>

      <div class="col-75">
          <input type="number" name="starting_price" id="starting_price">
      </div>
      
      <!-- Bid Increment -->
      <div class="col-25" id="bid_details">
        <label for="bid_increment">Enter Bid Increment</label>
      </div>

      <div class="col-75">
          <input type="number" name="bid_increment" id="bid_increment">
      </div>

      <!-- <p id="timer_value"></p> -->

      <!-- <script type="text/javascript">
        
      </script> -->

    </div>

    <!--<div class="row">
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
        <label for="time_upload">Bid Time Limit</label>
      </div>
      <div class="col-75">
        <input type="text" name="time_upload" id="time_limit">
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

    -->
    
    <!-- item media and tags -->
    <div class="add-prd"><h3>Item Media</h3></div>
    <hr>
    
	<div class="row">
      <div class="col-25">
        <label for="image">Select Image File(s)</label>
      </div>
      <div class="col-75">
        <input type="file" name="prd_img"><br>
        <div class="gallery">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
          $(function() {
            // Multiple images preview in browser
            var imagesPreview = function(input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('#gallery-photo-add').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });
        });
        </script>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="tags">Add Tags</label>
      </div>
      <div class="col-75">
      <input type="text" id="prd_tag" name="prd_tag">
      </div>
    </div>
    
    <div class="row">
      <input type="submit" name="add_product" value="Submit" onclick="settimer();">
    </div>
  </form>
</div>
<!-- tag bootsrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
<!-- auto complete tags -->
<script>
 $(document).ready(function(){
 
 $('#prd_tag').tokenfield({
  autocomplete:{
   source: ['Home','Furniture','Fashion','Mobiles','Electronic','Shirt','t-shirt','Jacket','Hoodie','Socks','Shawl','Game','Car',],
   delay:100
  },
  showAutocompleteOnFocus: true

 });
 });</script>
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
        // $status = $statusMsg = '';
        // if(isset($_POST["submit"])){
        //     if(!empty($_FILES['image']['name'])) {
        //         // Get the file info
        //         $fileName = basename($_FILES['image']['name']);
        //         $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        //         $name = $_POST['name'];
        //         $category = $_POST['category'];
        //         $price = $_POST['price'];
        //         $quantity = $_POST['quantity'];
        //         $condition = $_POST['condition'];
        //         $description = $_POST['description'];
        //         $rating = $_POST['rating'];
        //         $location = $_POST['location'];
        //         $bid_status = $_POST['bid_status'];
        //         $time_limit = $_POST['time_limit'];
        //         $start_bid = $_POST['start_bid'];
        //         $status = 'error';

        //         // Allow certain file formats
        //         $allowTypes = array('jpg','png','jpeg','gif');
        //         if(in_array($fileType, $allowTypes)){
        //             $image = $_FILES['image']['tmp_name'];
        //             $imgContent = addslashes(file_get_contents($image));

        //         //Select from Database
        //         $select = "SELECT * FROM product WHERE 1";
        //         // Insert image content into database
        //         $insert = $conn->query("INSERT into product (prd_name, prd_price, prd_qty, prd_condition, prd_desc, prd_rating, prd_location, bid_status) VALUES ('$name', '$price', '$quantity', '$condition', '$description', '$rating', '$location', '$bid_status')");
        //         if($insert){
        //                 $status = 'success';
        //                 $statusMsg = "File uploaded successfully.";
        //             } else {
        //                $statusMsg = "File upload failed. Please try again.";
        //             }
        //         } else {
        //             $statusMsg = "Only JPG, JPEG, PNG, & GIF files are allowed.";
        //         }
        //     } else {
        //         $statusMsg = "Please select a file.";
        //     }
        //     echo $statusMsg;
        //     header("location: store.php");
        //     exit;
        // }

        $status = $statusMsg = '';
        if(isset($_POST["add_product"])){
            if(!empty($_FILES['prd_img']['name'])) {
                // Get the file info
                $fileName = basename($_FILES['prd_img']['name']);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                $displayname  = $_POST['email'];
                $username     = $_POST['username'];
                $phone_number = $_POST['phone_number'];
                $name         = $_POST['prd_name'];
                $price        = $_POST['prd_price'];
                $qty          = $_POST['prd_qty'];
                $condition    = $_POST['prd_condition'];
                $desc         = $_POST['prd_desc'];
                $rating       = $_POST['prd_rating'];
                $location     = $_POST['prd_location'];
                $tag          = $_POST['prd_tag'];
                $bid_status   = $_POST['bid_status'];
                $time_upload  = date('Y-m-d');
                $category     = $_POST['prd_category'];
                $date_expired = $_POST['date_expired'];
                $time_expired = $_POST['time_expired'];
                $starting_price = $_POST['starting_price'];
                $bid_increment = $_POST['bid_increment'];

                // Allow certain file formats
                $allowTypes = array('jpg','png','jpeg','gif');
                if(in_array($fileType, $allowTypes)){
                    $image = $_FILES['prd_img']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));
                    

                //Select from Database 
                $select = "SELECT * FROM PRODUCT WHERE 1";
                //$insert = "INSERT INTO PRODUCT(prd_name, prd_price, prd_img) VALUES (':name', ':price', ':imgContent')"

                // Insert image content into database
                $insert = $conn->query ("INSERT INTO product (display_name,username,phone_number,prd_name,prd_price,prd_qty,prd_condition,prd_desc,prd_rating,prd_location,prd_tag,bid_status,time_upload,prd_img,prd_category, date_expired, time_expired, starting_bid, bid_increment) 
                VALUES ('$displayname','$username','$phone_number','$name','$price','$qty','$condition','$desc','$rating','$location','$tag','$bid_status','$time_upload', '$imgContent', '$category', '$date_expired', '$time_expired', '$starting_price', '$bid_increment')");

                //$insertimage = $conn->query("INSERT INTO product_image (prd_imgfile)VALUES ('$image')");


                // $insert =$conn->query("INSERT INTO product (product_Name, product_Desc,product_Price, product_Category, product_Quantity,product_Condition, product_Rate, bid_Status, meetup_location, bid_starting_price, bid_maximum_price, time_limit) 
                // VALUES ('$name', '$description', '$price', '$category', '$quantity', '$condition', '$rating', '$bid_status, '$location', '$start_bid', '$time_limit')");
                // , '$imgContent'
               
                if($insert){
                  echo '<script>updated</script>';
                }else{
                  echo '<script>failed</script>';
                }
                        $status  = '<script>updated</script>';
                        $statusMsg = "<script>updated</script>";
                    } else {
                       $statusMsg = "<script>failed</script>"; 
                    }
                } else { 
                    $statusMsg = "Only JPG, JPEG, PNG, & GIF files are allowed.";
                }
            } else {
                // $statusMsg = "Select a file.";
            }

            echo $statusMsg;
          
        
    ?>
</body>
</html>

