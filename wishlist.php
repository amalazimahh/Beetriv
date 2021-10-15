<?php 
    session_start();
    require_once('connection.php');
  

    if(isset($_GET['action'],$_GET['item']) && $_GET['action'] == 'remove')
    {
        unset($_SESSION['wish_items'][$_GET['item']]);
        header('location:wishlist.php');
        exit();
    }
	
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Wishlist</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/user-profile.css">
        <style>
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
        
        <!-- Product section-->
        <div class="row mt-3">
            <div class="col-md-12">
                <section class="container px-4 px-lg-5 my-5">
                    <!-- Display this is wishlist is empty -->
                    <?php if(empty($_SESSION['wish_items'])){?>
                        <table class="table">
                            <tr>
                                <td>
                                    <p>Your wishlist is empty</p>
                                </td>
                            </tr>
                        </table>
                    <?php }?>

                    <!-- Display this if wishlist is not empty -->
                    <?php if(isset($_SESSION['wish_items']) && count($_SESSION['wish_items']) > 0){?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                    $totalCounter = 0;
                                    $itemCounter = 0;
                                    foreach($_SESSION['wish_items'] as $key => $item){ 

                                    $img = $item['product_img'];
                                    // $total = $item['product_price'] * $item['qty'];
                                    // $totalCounter+= $total;
                                    // $itemCounter+=$item['qty'];
                                ?>
                                <tr>
                                    <td>
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img); ?>"class="rounded img-thumbnail mr-2" style="width:40px;">
                                        <?php echo $item['product_name'];?>
                                        
                                        <a href="wishlist.php?action=remove&item=<?php echo $key?>" class="text-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>

                                    </td>
                                    <td>
                                        $<?php echo $item['product_price'];?>
                                    </td>
                                    <td>
                                        <!-- <?php echo $item['qty'];?> -->
                                    </td>
                                    <td>
                                        <!-- <?php echo $total;?> -->
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody> 
                        </table>
                    <?php }?>
                </section>
            </div>
        </div>

        <!-- Add wish item to cart -->
        <?php
            if (isset($_POST['wish_to_cart'])){
            }
        ?>
     
        <br><br><br><br><br><br><br><br>

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

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>

