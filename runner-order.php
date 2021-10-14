<?php
ob_start();
session_start();
require_once "connection.php";
//$email = $_SESSION['email'];
//select db
$result = "SELECT * FROM order_details";
$statement = $conn->prepare($result);
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);
//select email
$result1 = $conn->query("SELECT * FROM order_details");
$row1 = $result1->fetch(PDO::FETCH_ASSOC);
$name = $row1['username'];

//to display per customer
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Order Request</title>
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

    /* ul{
      text-align: center;
    }
    
    ul li{
      display: inline-block;
      width: 200px;
      position: relative;
      
    } */

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
        <!--content-->
        <?php if($row1 == $row1){ ?>
            <table class ='table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Product ID</th>
                        <th>Product Quantity</th>
                        <th>Product Price</th>
                        <th>Customer Email</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Delivery Status</th>
                        <th>Contact Number</th>
                        <th> </th>
                        <!-- <th>Customer Contact Number</th>to be added -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($row as $orders){ ?>
                        <tr>
                            <td><?php echo $orders['id'] ?></td>
                            <td><?php echo $orders['username'] ?></td>
                            <td><?php echo $orders['prd_name'] ?></td>
                            <td><?php echo $orders['prd_id'] ?></td>
                            <td><?php echo $orders['prd_qty'] ?></td>
                            <td><?php echo $orders['prd_price'] ?></td>
                            <td><?php echo $orders['email'] ?></td>
                            <td><?php echo $orders['payment_mthd'] ?></td>
                            <td><?php echo $orders['payment_stat'] ?></td>
                            <td><?php echo $orders['stat'] ?></td>
                            <td><?php echo $orders['contact_no'] ?></td>
                            <td><a href="runnerDate.php?id=<?php echo $orders['id'];?>">
					        <button class="btn btn-warning btn-lg float-right">Accept</button>
				            </a></td>
                            

                        </tr>
                        <?php } ?>
                </tbody>
            </table>
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