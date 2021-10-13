<?php
ob_start();
session_start();
$email=$_SESSION['email'];
// echo $email;
require_once "connection.php";

// get product id
$id = $_GET['id'];


// echo $id;

$selectproduct = "SELECT * FROM product WHERE prd_id = '$id' LIMIT 1";
$result = $conn->query($selectproduct);
$result->execute();
$rowProduct = $result->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['saves'])){

    $prd_price      = $_POST['prd_price'];
    $new_price      = $_POST['new_price'];
    $prd_category   = $_POST['prd_category'];
    $prd_discount   = $_POST['prd_discount'];
    $start_promo    = $_POST['start_promo'];
    $end_promo      = $_POST['end_promo'];
  
    
    $pdoQuery = ("UPDATE product SET prd_price = '$new_price', new_price = '$prd_price', prd_category = '$prd_category', 
    prd_discount = '$prd_discount', start_promo = '$start_promo', end_promo = '$end_promo' WHERE prd_id = '$id' ");
    $pdoQuery_run = $conn->prepare($pdoQuery);
    $pdoQuery_run->execute();
    header('location: seller-profile.php ');

    
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beetriv - Discount Promotion</title>
    <link rel="stylesheet" href="css/edit-profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/footer.css">

    <!-- disabled previous day -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  	<!-- <script>
            $( function() {
	   			$("#start_promo").datepicker({
	   				minDate: 0
	   			});
	  		});
              
	  	</script>
          <script>
              $( function() {
	   			$("#end_promo").datepicker({
	   				minDate: 0
	   			});
	  		});
          </script> -->
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

        <!-- Edit Product -->
        <?php foreach($rowProduct as $product){ ?> 
            <form action="" method="post" enctype="multipart/form-data">
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <img class="rounded-circle mt-5" width="150px" id="output" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product['prd_img']);?>" onerror="this.src='img/profile-img.png';"><br></label></div>
            <script>
                var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
                }
            };
            </script>
        </div>
        <div class="col-md-9 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Product Details</h4>
                </div>
                <hr>
                <!-- <form action="seller-profile.php" method="post" enctype="multipart/form-data"> -->
                <div class="row mt-2">
                    <input type="hidden" name="product" value="<?php echo $id; ?>">
                    <div class="col-md-12"><label class="labels">Product Name</label><input type="text" class="form-control" placeholder="<?php echo $product['prd_name']; ?>" id="prd_name" name="prd_name" disabled></div>
                    <div class="col-md-12"><label class="labels">Category</label>
                    <select name="prd_category" class="form-control">
                        <!-- <option value="Select">Select Category</option>
                        <option value="Home">Home and Living</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Mobile">Mobile and Electronics</option>
                        <option value="Hobbies">Hobbies and Games</option>
                        <option value="Cars">Cars and Property</option> -->
                        <option value="Freebies">Freebies, Deals and More!</option>
                        </select>
                    </div>
                    <div class="col-md-12"><label class="labels">Price</label><input type="number" class="form-control" id="prd_price" name="prd_price" placeholder="<?php echo $product['prd_price']; ?>"  disabled></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Product Quantity</label>
                    <input type="number" class="form-control" id="prd_qty" name="prd_qty" placeholder="<?php echo $product['prd_qty']; ?>"   disabled></div>

                    <div class="col-md-12"><label class="labels">Product Condition</label>
                    <div class="col-md-12">
                    <input type="radio" name="prd_condition" value="New" disabled/>
                    <label for="New">New</label>
                    <input type="radio" name="prd_condition" value="Used" disabled>
                    <label for="Used" >Used</label>
                    </div>

                    <div class="col-md-12"><label class="labels">Product Description</label>
                    <input type="text" class="form-control" id="prd_desc" name="prd_desc" placeholder="<?php echo $product['prd_desc']; ?>"  disabled></div>

                    <div class="col-md-12"><label class="labels">Product Numeric Rating</label>
                    <input type="number" class="form-control" id="prd_rating" name="prd_rating" placeholder="<?php echo $product['prd_rating']; ?>" id="prd_rating" name="prd_rating"  disabled></div>
                    
                    <div class="col-md-12"><label class="labels">Meet up location</label>
                    <input type="text" class="form-control" id="prd_location" name="prd_location" placeholder="<?php echo $product['prd_location']; ?>"  disabled></div>
                </div>

                <!-- discount calculation -->
                
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
        $(document).on("keyup", "#prd_discount", function() {
            var oriPrice = "<?php echo $product['prd_price']; ?>";
            var percentage = $('#prd_discount').val();
            var formula = (percentage / 100).toFixed(2); 
            var multiply = oriPrice * formula;
            var discount = oriPrice - multiply;
            $("input[name=new_price]").val(discount);

            console.log(percentage);
            console.log(oriPrice);
            console.log(discount);
        });
    </script>
            <!-- discount form -->
            <form action="" method="POST">
            <input type="hidden" name="prd_price" value="<?php echo $product['prd_price']?>">
            <input type="hidden" name="new_price" value="<?php echo $product['new_price']?>">
                <div class="row mt-3">
                <h4 class="text-right">Discount Promotion</h4><hr>
                <div class="col-md-12"><label class="labels">Discount Percentage</label><input  type="number" class="form-control" placeholder="Discount Percentage" id="prd_discount" name="prd_discount" ></div>
                <div class="col-md-12"><label class="labels">Original Price</label><input  type="number" class="form-control" value="<?php echo $product['prd_price']; ?>" id="prd_price" name="prd_price" disabled></div> 

            </div>
            <div class="col-md-12"><label class="labels">New Price</label><input type="number" class="form-control" placeholder="New Price" id="new_price" name="new_price" step="0.1" disabled></div>

                <div class="col-md-12"><label class="labels">Start Promotions</label><input type="date" class="form-control" placeholder="Start Date" id="start_promo" name="start_promo" autocomplete="off" require></div>
                <div class="col-md-12"><label class="labels">End Promotions</label><input type="date" class="form-control" placeholder="End Date" id="end_promo" name="end_promo" autocomplete="off" require></div>
            </div>
                <div class="mt-5 text-center"><input class="btn btn-warning profile-button" type="submit" value="Save Product" name="saves" ></div>
                <!-- onclick="return confirm('Once product updated you are not allowed to update in 30 Days');" -->
                
            </form>
        </div>
    </div>
</div>
</div>
</div>
<?php } ?>

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
            <li><a href="footer/faq.php">FAQ</a></li>
            <li><a href="footer/buy-guides.php">How to Buy on Beetriv</a></li>
            <li><a href="footer/sell-guides.php">How to Sell on Beetriv</a></li>
            <li><a href="footer/bid-guides.php">How Bidding Works</a></li>
            <li><a href="footer/customer-protection.php">Customer Protection</a></li>
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
</body>
</html>