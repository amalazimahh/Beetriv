<?php
ob_start();
session_start();
require_once "connection.php";

$email = $_SESSION['email'];
//echo $email;

$select = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
$statement = $conn->prepare($select);
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Checkout - Pay</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/user-profile.css">
  <style>
    .checkout-progress{
      margin: 80px auto;
    }

    ul{
      text-align: center;
    }
    
    .dot{
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
    ul li:nth-child(2) .fas{
      background: #148e14;
    }

    ul li:nth-child(1) .fas::after,
    ul li:nth-child(2) .fas::after{
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
      padding: 20px;
    }

    .paypal-button{
      text-align: center;
      margin: 30px;
      padding: 10px;
    }
    #nnv{
        text-align: center;
        font-size: 24px;
        color: #000000;
        width: 100%;
        padding: 15px;
        border:0px;
        outline: none;
        cursor: pointer;
        margin-top: 5px;
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;
        }
  </style>
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
                    <form action = "store.php" method = "post">
                        <ul class="nav justify-content-end">
                    <!-- <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="wishlist.php"> -->
                    <li><button id="nnv" type="submit" name="wishlist" class="bi bi-heart" style='color:black;background-color:transparent'><?php echo (isset($_SESSION['wish_items']) && count($_SESSION['wish_items'])) > 0 ? count($_SESSION['wish_items']):''; ?></i></li>
                    <!-- <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="cart.php"> -->
                    <li><button id="nnv" type="submit" name="cart" class="bi bi-cart4" style='color:black;background-color:transparent'><?php echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):''; ?></i></button></li>
                    <li><button id="nnv" type="submit" name="profile" class="nav-item" style='background-color:transparent'><i class="bi-person-circle"></i></button></li>
                    <li><button id="nnv" type="submit" name="logout" class="nav-item" style='background-color:transparent'><i class="bi bi-box-arrow-right"></i></button></li>
                    </ul>
                    </form>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="checkout-progress">
        <ul>
          <li class="dot">
            <i class="fas fa-check-circle"></i>
            <p>Shopping Cart</p>
          </li>

          <li class="dot">
            <i class="fas fa-times-circle"></i>
            <p><b>Place Order</b></p>
          </li>

          <li class="dot">
            <i class="fas fa-times-circle"></i>
            <p>Pay</p>
          </li>

          <li class="dot">
            <i class="fas fa-times-circle"></i>
            <p>Order Completed</p>
          </li>
        </ul>
      </div>

      <section class="container px-4 px-lg-5 my-5" >
        <?php if(empty($_SESSION['cart_items'])){?>
        <table class="table">
            <tr>
                <td>
                    <p>Your cart is empty</p>
                </td>
            </tr>
        </table>
        <?php }?>
        <?php if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0){?>
        <table class="table">
           <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalCounter = 0;
                    $itemCounter = 0;
                    foreach($_SESSION['cart_items'] as $key => $item){ 

                    $img = $item['product_img'];
                    
                    $total = $item['product_price'] * $item['qty'];
                    $totalCounter+= $total;
                    $itemCounter+=$item['qty'];
                    ?>
                    <tr>
                        <td>
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img); ?>"class="rounded img-thumbnail mr-2" style="width:40px;">
                            <?php echo $item['product_name'];?>               
                        </td>
                        <td>
                            $<?php echo $item['product_price'];?>
                        </td>
                        <td>
                            <?php echo $item['qty'];?>
                        </td>
                        <td>
                            <?php echo $total;?>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                  <td></td>
                  <td></td>
                  <td>Delivery charge</td>
                  <td>$<?php foreach($row as $user){
                      if($user['province'] == 'Bandar Seri Begawan'){
                        echo $charge = 4;
                      }
                      if($user['province'] == 'Tutong'){
                        echo $charge = 5;
                      }
                      if($user['province'] == 'Kuala Belait'){
                        echo $charge = 6;
                      }
                      if($user['province'] == 'Temburong'){
                        echo $charge = 5;
                      }?>

                  </td>
                </tr>
                <tr class="border-top border-bottom">
                    <td></td>
                    <td></td>
                    <td>
                        <strong>
                            <?php 
                                echo ($itemCounter==1)?$itemCounter.' item':$itemCounter.' items'; ?>
                        </strong>
                    </td>
                    <td><strong>$<?php $totalSum = $totalCounter+$charge;
                                        echo $totalSum;?></strong></td>
                </tr> 
                </tr>
            </tbody> 
        </table>
            <?php }?>
        </section>

      <div class="checkout-form">
        <form class="needs-validation" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="row">

            <h4 class="mb-2">Shipping Address</h4>
            <hr class="mb-3">

              <div class="col-md-5 mb-2">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" value="<?php echo $user['fname'] ?>" disabled>
                
              </div>
              <div class="col-md-5 mb-2">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" value="<?php echo $user['lname'] ?>" disabled>
                
              </div>
            </div>

            <div class="col-md-6 mb-2">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" value="<?php echo $email ?>" disabled>
              
            </div>
            
            <div class="row">
            <div class="col-md-4 mb-2">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['address']; ?>"disabled>
            </div>
            <div class="col-md-3 mb-2">
              <label for="address">Postcode</label>
              <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['postcode']; ?>"disabled>
            </div>
            <div class="col-md-3 mb-2">
              <label for="address">Province</label>
              <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['province']; ?>"disabled>
            </div>
            </div>

          <?php } ?>

      <div class="paypal-button">
        <div id="paypal-payment-button">
        </div>
      </div>

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
                          value: '<?php echo $totalSum;?>'
                      }
                  }]
              });
          },
          onApprove:function(data, actions){
              return actions.order.capture().then(function(details){
                  console.log(details)
                  window.location.href='order-complete.php?pay='+details.id;
              })
          },
          onCancel:function(data){
              window.location.href='payment-fail.php';
          }
         }).render('#paypal-payment-button');
        </script>

</body>
</html>