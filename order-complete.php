<?php
ob_start();
session_start();
require_once "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/footer.css">
  <title>Checkout - Order Complete</title>
  <style>
    .checkout-progress{
      margin: 80px auto;
    }

    ul{
      text-align: center;
    }
    
    ul li{
      display: inline-block;
      width: 200px;
      position: relative;
      
    }

    ul li .fas{
        background: #000;
        /* width: 8px;
        height: 8px;  */
        color: #fff;
        border-radius: 50%;
        padding: 6px;
    }

    ul li .fas::after{
      content: '';
      background: #ccc;
      height: 7px;
      width: 250px;
      display: block;
      position: absolute;
      left: 0;
      top: 10px;
      z-index: -1;
    }

    ul li:nth-child(1) .fas, 
    ul li:nth-child(2) .fas,
    ul li:nth-child(3) .fas,
    ul li:nth-child(4) .fas{
      background: #148e14;
    }

    ul li:nth-child(1) .fas::after,
    ul li:nth-child(2) .fas::after,
    ul li:nth-child(3) .fas::after,
    ul li:nth-child(4) .fas::after{
      background: #148e14;
      
    }

    ul li:first-child .fas::after{
      width: 105px;
      left: 100px;
    }

    ul li:last-child .fas::after{
      width: 105px;
    }

    .checkout-form{
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Beetriv</a>
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
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>                       
                    </form>
                </div>
            </div>
        </nav>

        <div class="checkout-progress">
        <ul>
          <li>
            <i class="fas fa-check-circle"></i>
            <p>Shopping Cart</p>
          </li>

          <li>
            <i class="fas fa-check-circle"></i>
            <p>Place Order</p>
          </li>

          <li>
            <i class="fas fa-check-circle"></i>
            <p>Pay</p>
          </li>

          <li>
            <i class="fas fa-check-circle"></i>
            <p><b>Order Completed</b></p>
          </li>
        </ul>
      </div>

      <div class="text-center">
          <h3>Your order has been submitted.</h3>
      </div>

          <br><br>

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