<?php
session_start();
require_once "../connection.php";

$email = $_SESSION['email'];
// echo $email;
$session=$_SESSION['email'];

if (!$session)
{
    header ('location: login.php');
    die ('Login required');
    
}
else if (isset($_POST['logout']))
{
    session_destroy();
    echo "Logout successfull. ";
    header ('location: login.php');
}

// Get image data from database
$result = "SELECT * FROM product WHERE prd_category= 'Freebies'";
$handle = $conn->prepare($result);
$handle->execute();
$row = $handle->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
        * {box-sizing: border-box;}
        body {font-family: Verdana, sans-serif;}
        .mySlides {display: none;}
        img {vertical-align: middle;}

        /* Slideshow container */
        .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
        }

        /* The dots/bullets/indicators */
        .dot {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
        margin-bottom: 50px;
        }

        .active {
        background-color: #717171;
        }

        /* Fading animation */
        .fade {
        -webkit-animation-name: fade;
        -webkit-animation-duration: 1.5s;
        animation-name: fade;
        animation-duration: 1.5s;
        }

        @-webkit-keyframes fade {
        from {opacity: .4}
        to {opacity: 1}
        }

        @keyframes fade {
        from {opacity: .4}
        to {opacity: 1}
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
        .text {font-size: 11px}
        }

        /* Product Display */

        body{
        margin: 0;
        font-family:Nunito Sans;
        }
        h3{
        text-align: left;
        font-size: 30px;
        margin: 0;
        padding-top: 10px;
        padding-left: 20px;
        }
        a{
        text-decoration: none;
        }
        .prd-grid{
        display: flex;
        /* width: 60%; */
        margin: 20px 30px;
        }
        .prd-flex{
        -webkit-flex: 1 0 0;
        flex: 1 0 0;
        }
        .prd-flex-2{
        -webkit-flex: 3 0 0;
        flex: 3 0 0;
        }
        .category-bar{
        margin: 10px;
        }
        .product{
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        justify-content: space-evenly;
        /* align-items: center; */
        margin: 20px 0;
        /* flex-basis: 100%; */
        }
        .content{
        width: 20%;
        margin: 10px;
        box-sizing: border-box;
        float: left;
        text-align: center;
        border-radius:10px;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        padding-top: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: .4s;
        }
        .content:hover{
        box-shadow: 0 0 11px rgba(33,33,33,.2);
        transform: translate(0px, -8px);
        transition: .6s;
        }
        img{
        width: 150px;
        height: 150px;
        text-align: center;
        margin: 0 auto;
        display: block;
        }
        h6{
        font-size: 26px;
        text-align: left;
        color: #222f3e;
        margin: 0;
        padding-left: 20px;
        }
        ul{
        list-style-type: none;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0px;
        }
        li{
        padding: 5px;
        }
        .fa{
        color: #ff9f43;
        font-size: 26px;
        transition: .4s;
        }
        .fa:hover{
        transform: scale(1.3);
        transition: .6s;
        }
        button{
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
        .buy-prd{
        font-size: 20px;
        }

        .prd-div {
        margin-top: 10px;
        margin-left: 80px;
        padding-left: 20px;
        }

        @media(max-width: 1000px){
            .content{
            width: 46%;
            }
        }
        @media(max-width: 750px){
            .content{
            width: 100%;
            }
        }

        </style>
        <title>Beetriv</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Search bar -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/user-profile.css">
        <link href="../css/responsive.css" rel="stylesheet">
        <link href="../css/category.css" rel="stylesheet">

    </head>
    <body>
        
    
        <!-- Navigation-->
        <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light" style='color:black' > 
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="../store.php">Beetriv</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="../store.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="../about.php">About</a></li>
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
                        <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="../wishlist.php">
                        <i class="bi bi-heart" style='color:black'><?php echo (isset($_SESSION['wish_items']) && count($_SESSION['wish_items'])) > 0 ? count($_SESSION['wish_items']):''; ?></i>
                        <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="../cart.php">
                        <i class="bi bi-cart4" style='color:black'><?php echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):''; ?></i>
                        <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="../user-profile.php"><i class="bi-person-circle"></i></a></li>
                        <form action = "../store.php" method = "post">
                            <button type="submit" name="logout" class="nav-item" style='background-color:transparent'><i class="bi bi-box-arrow-right"></i></button>
                        </form>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End of Nav Bar -->

        <!-- Slideshow -->
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="../img/store/delivery.png" style="width:100%">
            </div>

            <div class="mySlides fade">
                <img src="../img/store/summer.png" style="width:100%">
            </div>

            <div class="mySlides fade">
                <img src="../img/store/collab.png" style="width:100%">
            </div>

        </div>

        <br>

        <div style="text-align:center">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>

        <!-- Slideshow Js -->
        <script>
            var slideIndex = 0;
            showSlides();

            function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
            setTimeout(showSlides, 2000); // Change image every 2 seconds
            }
        </script>

        <!-- End of slideshow -->

        <!-- Search bar -->
        <form method = "POST" action="../search.php" class="input-group">
            <div class="container">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
		                <div class="input-group">
                            <div class="input-group-btn search-panel">
                                <!-- Filter by function -->
                                <script language="javascript">
                                    function SelectRedirect(){
                                        switch(document.getElementById('category').value)
                                        {
                                        case "Home":
                                        window.location="homeliving.php";
                                        break;

                                        case "Fashion":
                                        window.location="fashion.php";
                                        break;

                                        case "Mobiles":
                                        window.location="mobile.php";
                                        break;
                                        case "Hobbies":
                                        window.location="hobbies.php";
                                        break;

                                        case "Cars":
                                        window.location="cars.php";
                                        break;

                                        case "Freebies":
                                        window.location="freebies.php";
                                        break;

                                        default:
                                        window.location="store.php"; // if no selection matches then redirected to home page
                                        break;
                                        }                           
                                    }
                                </script>

                                <SELECT id="category" class="btn btn-default dropdown-toggle" name="section" onChange="SelectRedirect();">
                                <Option value="">Filter By</option>
                                <Option value="Home">Home and Living</option>
                                <Option value="Fashion">Fashion</option>
                                <Option value="Mobiles">Mobiles and Electronics</option>
                                <Option value="Hobbies">Hobbies and Games</option>
                                <Option value="Cars">Cars and Property</option>
                                <Option value="Freebies">Freebies, Deals and More!</option>
                                </SELECT>
                    

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#contains">Contains</a></li>
                                    <li><a href="#its_equal">It's equal</a></li>
                                    <li><a href="#greather_than">Greather than ></a></li>
                                    <li><a href="#less_than">Less than < </a></li>
                                    <li class="divider"></li>
                                    <li><a href="#all">Anything</a></li>
                                </ul>
                            </div>
                                <input type="hidden" name="search_param" value="all" id="search_param">
                                <input type="text" class="form-control" name="search" placeholder="Search item...">
                                <input type="submit" class="btn btn-default" name="search_item" placeholder="Search" value="Search">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Dropdown for search by categories Js -->
        <script>
        $(document).ready(function(e){
            $('.search-panel .dropdown-menu').find('a').click(function(e) {
                e.preventDefault();
                var param = $(this).attr("href").replace("#","");
                var concept = $(this).text();
                $('.search-panel span#search_concept').text(concept);
                $('.input-group #search_param').val(param);
            });
        });
        </script>

        <div class="prd-div"><h3>Discount and Promotions</h3></div>

        <!-- Product preview -->
        <section>
            <!-- Place category sidebar and products in a container  -->
            <div class="prd-grid">
                <div class="prd-flex">
                    <!-- Category -->
                    <!-- <div class="col-sm-3"> -->
                        <div class="category-bar">
                            <div class="left-sidebar">
                                <h2>Category</h2>
                                <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a href="homeliving.php">Home and Living</a></h4>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a href="fashion.php">Fashion</a></h4>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a href="mobiles.php">Mobiles and Electronics</a></h4>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a href="hobbies.php">Hobbies and Games</a></h4>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a href="car.php">Car and Property</a></h4>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a href="freebies.php">Freebies, Deals and More!</a></h4>
                                        </div>
                                    </div>

                                </div>

                                <!-- Item condition -->
                                <div class="Item_condition">
                                    <h2>Item Condition</h2>
                                    <div class="brands-name">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="newfreebies.php"> <span class="pull-right"></span>New</a></li>
                                            <li><a href="usedfreebies.php"> <span class="pull-right"></span>Used</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!--price-range-->
                                <div class="price-range">
                                    <h2>Price Range</h2>
                                    <div class="well text-center">
                                        <!-- <b class="pull-left">$ 0</b>
                                            <input id="sl2" type="range" class="span2" value="" data-slider-min="5" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]"/>
                                        <b class="pull-right">$ 10000</b>
                                        <script>
                                            // $("#sl2").slider({});

                                            // Without JQuery
                                            // var slider = new Slider('#sl2', {});
                                        </script> -->
                                        <form method="post">
                                        <div class="data-slider"><span>From
                                            <input type="number" value="50" name="min_range" min="0" max="1000"/>	To
                                            <input type="number" value="500" name="max_range" min="0" max="1000"/></span>
                                            <input value="50" min="0" max="1000" step="10" type="range"/>
                                            <input value="500" min="0" max="1000" step="10" type="range"/>
                                            <svg width="100%" height="24">
                                                <line x1="4" y1="0" x2="300" y2="0" stroke="#212121" stroke-width="12" stroke-dasharray="1 28"></line>
                                            </svg>
                                            <div class="pt-5">
                                            <button type="submit" name="filter" class="btn btn-outline-dark">Filter</button>
                                            </div>
                                        </form>
                                        <?php 
                                        if(isset($_POST['filter'])){
                                            $min = $_POST['min_range'];
                                            $max = $_POST['max_range'];
                                        // $stmt = $conn->query("SELECT * FROM product WHERE prd_price BETWEEN '$min' AND '$max'");
                                        // $res = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $result = "SELECT * FROM product WHERE prd_price BETWEEN '$min' AND '$max' AND prd_category= 'Home'";
                                        $handle = $conn->prepare($result);
                                        $handle->execute();
                                        $row = $handle->fetchAll(PDO::FETCH_ASSOC);
                                        } ?>

                                            <!-- Javascript for price slider -->
                                            <script>
                                                (function() {
                                                    
                                                    // fetch id of slider from html using query selector
                                                    var parent = document.querySelector(".data-slider");
                                                    if(!parent) return;
                                                    
                                                    // fetch value for ranger using query selecter all and stored in variables
                                                    var
                                                    rangeNum = parent.querySelectorAll("input[type=range]"),
                                                    numberSlider = parent.querySelectorAll("input[type=number]");

                                                    rangeNum.forEach(function(el) {
                                                        el.oninput = function() {
                                                                var slideNum1 = parseFloat(rangeNum[0].value),
                                                                    slideNum2 = parseFloat(rangeNum[1].value);
                                                                
                                                                // when first num range exceed value of second num range, enable second num range to fetch largest value
                                                                if (slideNum1 > slideNum2) {
                                                                [slideNum1, slideNum2] = [slideNum2, slideNum1];
                                                                }

                                                                numberSlider[0].value = slideNum1;
                                                                numberSlider[1].value = slideNum2;
                                                            }
                                                        });

                                                        numRangeSlider.forEach(function(el) {
                                                            el.oninput = function() {
                                                                var num1 = parseFloat(numRangeSlider[0].value),
                                                                num2 = parseFloat(numRangeSlider[1].value);
                                                                
                                                                // if num1 largest than num2, store the value in a temporary variable and pass the temporary variable to num2
                                                                if (num1 > num2) {
                                                                var tmp = num1;
                                                                numRangeSlider[0].value = num2;
                                                                numRangeSlider[1].value = tmp;
                                                                }

                                                                rangeNum[0].value = num1;
                                                                rangeNum[1].value = num2;

                                                            }
                                                        });

                                                    })();
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </div><!--end category-products left bar-->
                        </div>
                    <!-- </div> -->
                </div>

                <div class="prd-flex-2">
                <?php if (isset($row['prd_id']) ): ?>
                    <div class="container">         
                            <div class=" text-center"><h1>No items found!</h1></div>
                    </div>
                <?php endif; ?>
                    <div class="product">
                        <?php foreach($row as $product){ ?>
                            <div class="content">
                                <form method="POST"></form>
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product['prd_img']); ?>">
                                    <input type="hidden" name="ide" value=<?php echo $product['prd_id'];?> >
                                    <h3><?php echo $product['prd_name']; ?></h3>
                                    <h6 class="text-muted text-decoration-line-through">$<?php echo $product['new_price']; ?></h6><h6>$<?php echo $product['prd_price']; ?></h6>
                                    <a class="text-warning" href="../product-details.php?product=<?php echo $product['prd_id'];?>">View</a>
                                    <button class="buy-prd btn-warning">Add to cart</button>
                                </form>  
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
                        
        <!-- Footer-->
        <footer class="site-footer">
            <div class="container">
                <div class="row">
                <!-- first section -->
                <div class="col-xs-6 col-md-3">
                    <h6>CORPORATE</h6>
                    <ul class="footer-links">
                        <li><a href="../about.php">About Beetriv</a></li>
                        <li><a href="../footer/privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="../footer/termsco.php">Terms and Conditions</a></li>
                    </ul>
                </div>

                <!-- second section -->
                <div class="col-xs-6 col-md-3">
                    <h6>DEALS, PAYMENT & DELIVERY</h6>
                    <ul class="footer-links">
                        <li><a href="../footer/deals.php">Our Deals</a></li>
                        <li><a href="../footer/delivery.php">Delivery Services</a></li>
                        <li><a href="../footer/payment.php">Payment</a></li>
                    </ul>
                </div>

                <!-- third section -->
                <div class="col-xs-6 col-md-3">
                    <h6>CUSTOMER CARE</h6>
                    <ul class="footer-links">
                        <li><a href="../footer/be-seller.php">Become Our Seller</a></li>
                        <li><a href="../footer/buy-guides.php">How to Buy on Beetriv</a></li>
                        <li><a href="../footer/sell-guides.php">How to Sell on Beetriv</a></li>
                        <li><a href="../footer/bid-guides.php">How Bidding Works</a></li>
                        <li><a href="../footer/customer-protection.php">Customer Protection</a></li>
                        <li><a href="../footer/faq.php">FAQ</a></li>
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

        <script src="js/main.js"></script>
    </body>
</html>