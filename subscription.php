<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription</title>
    <link rel="stylesheet" href="css/subscription.css">
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
        <link rel="stylesheet" href="css/user-profile.css">
        <style>
            .paypal-button{
            text-align: center;
            margin: 5px;
            }
        </style>
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

    <!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

<section class="pricing py-3">
  <div class="container">
      <div><h2 class="text-center">Join Our Team!</h2></div>
    <div class="row justify-content-center p-5">
      <!-- Free Tier -->
      <div class="col-lg-4">
        <div class="card mb-5 mb-lg-0">
          <div class="card-body">
            <h5 class="card-title text-muted text-uppercase text-center">Runner</h5>
            <h2 class="card-price text-center">$0<span class="period">/month</span></h2>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Single User</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Deliver Product(s)</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Maximum of 5 Deliveries Per Day</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Weekly Commission</li>
                <p class="text-uppercase text-left"><strong>Requirements</strong></p>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Minimum Age of 18</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Have a Valid Class 3 Driver's License</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Have All Legal Related Documentation</li>
            </ul>
            <div class="d-grid">
              <a href="#" class="btn btn-warning text-uppercase">Upgrade</a>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Pro Tier -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-muted text-uppercase text-center">Vendor</h5>
            <h2 class="card-price text-center">$10<span class="period">/month</span></h2>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Single User</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Sell Product(s)</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Put Product(s) on Auction</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Monthly Statistical Reports</li>
              <p class="text-uppercase text-left"><strong>Requirements</strong></p>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Minimum Age of 18</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Have a PayPal Account</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Have All Legal Related Documentation</li>
            </ul>
            <div class="d-grid">
              <a type="button" class="btn btn-warning text-uppercase" data-bs-toggle="modal" data-bs-target="#modalForm">Upgrade</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upgrade Your Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            
                            <div class="mb-3 form-check">
                                <form>
                                <input type="checkbox" class="form-check-input" id="check" required/>
                                <label class="form-check-label" for="check">I have read, understood and agreed with <a class="text-warning" href="#">Beetriv Terms and Conditions</a> in becoming one of the vendors.</label>
                                </form>
                            </div>
                            <div class="modal-footer d-block">
                            <div class="paypal-button">
                                <div id="paypal-payment-button">
                                </div>
                                <p>Note: You will be directed to PayPal Login Page to proceed with your payment.</p>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>

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

<!-- PayPal Payment -->
<script src="https://cdn.jsdelivr.net/gh/cosmogicofficial/quantumalert@latest/minfile/quantumalert.js" charset="utf-8"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AXuQ2h0um_ALgb9wZNHXwi7eEIXRIdnaNXKcfn7GQw7v5SnUuXRpL71Ysjr5h6Y8Ac-5OwDRqLtB975P&disable-funding=credit,card"></script>
        <script>
          paypal.Buttons({
          style: {
              color:'gold',
              shape: 'pill',
              height: 50
          },
          createOrder:function(data, actions){
              return actions.order.create({
                  purchase_units:[{
                      amount: {
                          value: '0.1'
                      }
                  }]
              });
          },
          onApprove:function(data, actions){
              return actions.order.capture().then(function(details){
                  console.log(details)
                  Qual.success("Successful Payment","Welcome and thank you for joining us!");
              })
          },
          onCancel:function(data){
            Qual.error("Unsuccessful Payment","Something wrong happened. Please try again later.");
          }
         }).render('#paypal-payment-button');
        </script>

</body>
</html>