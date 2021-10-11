<?php
ob_start();
session_start();

require_once "connection.php";
$email = $_SESSION['email'];
// echo $email;
$result = $conn->query("SELECT * FROM product");
$row = $result->fetch(PDO::FETCH_ASSOC);

$result1 = $conn->query("SELECT * FROM users WHERE email = '$email'");
$row1 = $result1->fetch(PDO::FETCH_ASSOC);

$status = "pending";
$paymentStat ="pending";
$payment_mthd ="Cash";


$binde = [
    'user_id' => $row1['user_id'],
  ];
  $testting = 'insert into user_test(user_id) values (:user_id)';
  $statement1 = $conn->prepare($testting);
  $statement1->execute($binde);
  
  if($statement1->rowCount() == 1)
      {    
    if(isset($_SESSION['cart_items']) || !empty($_SESSION['cart_items']))
  {
        $orderID = $conn->lastInsertId();
        foreach($_SESSION['cart_items'] as $item)
          {
            //$totalPrice+=$item['total_price'];
            $paramOrderDetails = [
              'order_id' => $orderID,
              'product_id' =>  $item['product_id'],
              'product_name' =>  $item['product_name'],
              'product_price' =>  $item['product_price'],
              'qty' =>  $item['qty'],
              'email' => $_SESSION['email'],
              'username' => $row1['username'],
              'user_id' => $row1['user_id'],
              'stat' => $status,
              'contact_no' => $row1['phone_number'],
              'payment_mthd' => $payment_mthd,
              'payment_stat' => $paymentStat
               ];       
               $sqlDetails = 'insert into order_details (request_id,prd_id, prd_name, prd_price, prd_qty, user_id, email, username, stat, contact_no, payment_mthd, payment_stat) 
               values(:order_id,:product_id,:product_name,:product_price,:qty,:user_id,:email,:username,:stat,:contact_no,:payment_mthd,:payment_stat) ';
               $orderDetailStmt = $conn->prepare($sqlDetails);
            
                $orderDetailStmt->execute($paramOrderDetails);
          }

        unset($_SESSION['cart_items']);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Cash on Delivery</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/user-profile.css">
</head>
<body>

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
                    <form action = "product-details.php" method = "post">
                    <li><a type="submit" name="logout" class="nav-item nav-link" style='color:black' aria-current="page" href="login.php"><i class="bi bi-box-arrow-right"></i></a></li>
                    </form>
                    </a></li>
                    </ul>
                </div>
            </div>
        </nav>
      <section class="container px-4 px-lg-5 my-5" >
        <?php if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0){?>
            <?php }?>

            <h3>Your orders has been completed!</h3>
            <h5>Your Items will be Deliver on 10th August 2021.</h5>
            <p>A Runner will contact you As Soon As Possible. Thank You for using Beetriv!!</p>


            
        </section>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>