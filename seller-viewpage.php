<?php
ob_start();
session_start();
require_once "connection.php";

//make sure login first, so that can fetch email, echo email to see if you logged in
$email = $_SESSION['email'];
// $displayname = $_GET['id'];
$profile = $_GET['profile'];
//echo $email;

$select = "SELECT * FROM users WHERE username = '$profile' LIMIT 1";
$statement = $conn->prepare($select);
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);

// Fetch seller_review 
// $rateQuery = $conn->prepare("SELECT * FROM seller_review LEFT JOIN users ON users.user_id=seller_review.user_id WHERE email = '$email' ");
$rateQuery = $conn->prepare("SELECT * FROM seller_review LEFT JOIN product ON product.prd_id=seller_review.prd_id LEFT JOIN users ON users.user_id=product.prd_id WHERE username = '$profile' ");
$rateQuery->execute();
$rates = $rateQuery->fetchAll(PDO::FETCH_ASSOC);

// display item sell
$selectproduct = "SELECT * FROM product WHERE username = '$profile'";

$result = $conn->query($selectproduct);

// disable seller features
$sellers = $conn->query("SELECT * FROM users WHERE email = '$email'");
$seller = $sellers->fetch(PDO::FETCH_ASSOC);
$time_register = $seller['seller_register'];
$seller_period = date('Y-m-d H:i:s', strtotime("$time_register +1 month"));
// echo $seller_period;
//echo $seller_period;

date_default_timezone_set('Asia/Brunei');
$dateTime = new DateTime();

if ( $seller_period < $dateTime->format('Y-m-d H:i:s') ) {
    //$updte = $conn->query("UPDATE users SET type='customer', seller_period='expired' WHERE email='$email'");
    $pdoQuery = ("UPDATE users SET type='customer', seller_period='expired' WHERE email='$email'");
    $pdoQuery_run = $conn->prepare($pdoQuery);
    $pdoQuery_run->execute();

    //Mail Set up
    $mail= new PHPMailer(true);

    try {
        
        //Enable debug output
        $mail->SMTPDebug = 0;

        //Send using SMTP
        $mail->isSMTP();

        //Set the SMTP server 
        $mail->Host = 'mail.beetriv.com';

        //Enable SMTP authentication
        $mail->SMTPAuth = true;

        //SMTP username
        $mail->Username = 'admin@beetriv.com';

        //SMTP password
        $mail->Password = '4bx~~ZJ8HJyq';

        //SMTP username
        $mail->SMTPSecure = 'ssl';

        //SMTP PORT
        $mail->Port = '290';

        //Recipients
        $mail->setFrom('admin@beetriv.com','Admin Beetriv');

        //add recipient
        $mail->addAddress($email,$username);

        //Set email format to HTML
        $mail->isHTML(true);

        //converting text to html
        // $mail .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $mail->Subject = 'Seller Account Expired';
        $mail->Body    = '<p>We are sorry to inform that your Seller account has expired but worry not, you may retrieve back your Seller account by upgrading your account. </p><p>Thank you for trusting us!</p>';
        //<a href="http://localhost/Email%20Authentication/registration.php">Reset your password</a> 

        $mail->send();

        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

        //mysql_query($conn, $sql);
        // $result = $stmtinsert->execute([$username,$password,$email,$vcode]);

        // if($result){
        //     echo 'Success';
        // }else{
        //     echo 'Error';
        // }

    }catch (Exception $e){
        echo "Message cannot send, Error Mail: {$mail->ErrorInfo}";

    

    }

    
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Profile</title>
    <link rel="stylesheet" href="css/profile.css">
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
    <link rel="stylesheet" href="css/feedback-form.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');

      body {
        font-family: 'Open Sans', sans-serif
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

      .search{
        top: 6px;
        left: 10px
      }

      .form-control{
        border: none;
        padding-left: 32px
      }

      .form-control:focus {
        border: none;
        box-shadow: none
      }

      .green {
        color: green
      }

      /* For stars */
      .rate2:not(:checked) > input {
        position:absolute;
        top:-9999px; 
      } 
      .rate2:not(:checked) > label {
        float:center;
        width:30px;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
      }
      .rate2:not(:checked) > label:before {
        content: '★ ';
      }
      .rate2 > input:checked ~ label {
        color: #ffc700;    
      }
      .rate2:not(:checked) > label:hover,
      .rate2:not(:checked) > label:hover ~ label {
        color: #deb217;  
      }
      .rate2 > input:checked + label:hover,
      .rate2 > input:checked + label:hover ~ label,
      .rate2 > input:checked ~ label:hover,
      .rate2 > input:checked ~ label:hover ~ label,
      .rate2 > label:hover ~ input:checked ~ label {
        color: #c59b08;
      }

      h2.centerh2 {
        text-align: center;
      }

      .rate-star{
        width: 120px; 
        height: 24px;
        background: url(img/rate-stars.png) no-repeat;
        background-size: cover;
        position: absolute;
      }
      .rate-bg{
        height: 15px;
        background-color: #ffbe10;
      }
          
      .checked {
        color: orange;
      }

      ul, li {
          display:inline
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
        width: 19%;
        margin: 15px;
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
    </style>
</head>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        <div class="main-content">
          <div class="container mt-7 p-5">
            <!-- Table -->
            <?php foreach($row as $seller){ ?>
        <input type="hidden" name="product" value="<?php echo $id; ?>">
            <div class="row">
              <div class="col-xl-10 m-auto order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                  <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                      <div class="card-profile-image">
                        <a href="#">
                          <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($seller['img']);?>" class="rounded-circle">
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                    </div>
                  </div>
                  <div class="card-body pt-0 pt-md-4">
                    
                    <div class="text-center pt-5">
                      
                      <h3>Hi
                        <?php echo $seller['fname'];?> <?php echo $seller['lname'];?><span class="font-weight-light">, @<?php echo $seller['username'];?></span>
                      </h3>
                      <div class="h5 font-weight-300">
                        <i class="ni location_pin mr-2"></i><?php echo $seller['email'];?>
                      </div>
                      <div class="h5 mt-4">
                        <i class="ni business_briefcase-24 mr-2"></i><strong>Personal Information</strong>
                      </div>
                        <i class="ni education_hat mr-2"></i><strong>Phone Number</strong> <?php echo $seller['phone_number'];?>
                        <i class="ni education_hat mr-2"></i><strong>IC Number</strong> <?php echo $seller['ic_number'];?>
                        <i class="ni education_hat mr-2"></i><strong>IC Colour</strong> <?php echo $seller['ic_color'];?>
                        
                        <p class="text-align-center"><b>Disclaimer</b> <br> <?php echo $seller['disclaimer']; ?></p>
                        <p class="text-align-center"><b>Policies</b> <br> <?php echo $seller['policies']; ?></p>
                        <p class="text-align-center"><b>Shipping</b> <br> <?php echo $seller['shipping']; ?></p>
                      
                    
                      <hr class="my-4">
                    </div>
                    <!-- feedback -->
                    <h2 class="centerh2">Feedbacks</h2>
                          <?php foreach($rates as $review){ ?>
                              <div class="wrap-input100" style="margin-top: 10px">
                                  <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($review['img']); ?>" class="rounded" style="width:40px; height:40px; float:left;">
                                  <div class="result-container">
                                      <?php $reviewAvgCalc = $review['prd_quality'] + $review['seller_service'];
                                              $reviewAvg = ($reviewAvgCalc/2)*10; ?>
                                  <p> <?php echo $review['feedback']; ?></p>
                                  <p>by <?php echo $review['username']; ?></p>
                                      <div class="fa fa-star checked" 
                                      <?php 
                                      //counting stars
                                      for( $x = 0; $x < 4; $x++ )
                                      {
                                          if( floor( $review['seller_service'] )-$x >= 2 )
                                          { echo '<li><i class="fa fa-star checked"></i></li>'; }
                                          elseif( $review['seller_service']-$x > 1 )
                                          { echo '<li><i class="fa fa-star-half-o"></i></li>'; }
                                          else
                                          { echo '<li><i class="fa fa-star-o"></i></li>'; }
                                      }
                                      
                                      ;?>
                                      </div>
                                      
                                  </div>  
                                  <div class="rate-star">
                              </div>
                          <?php }?>
                  </div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
      <?php } ?>   
                                    </div>
                
      <!-- Selling Item -->
      <div class="container mt-3 px-2 pb-5">
        <h4 class="pb-3"><strong>Sell Item</strong></h4>
        <div class="product">
          <?php foreach($result as $product){ 
              if (empty($product['bid_expiry'])) { ?>
                <div class="content">
                  <form method="POST"></form>
                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product['prd_img']); ?>">
                    <input type="hidden" name="ide" value=<?php echo $product['prd_id'];?> >
                    <h4><?php echo $product['prd_name']; ?></h4>
                    <h6>$<?php echo $product['prd_price']; ?></h6>
                    <a class="text-warning" href="product-details.php?product=<?php echo $product['prd_id'];?>">View</a>
                  </form>  
                </div>        
          <?php } }?>
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

<script>
    var Tooltip = (function() {
    // Variables

    var $tooltip = $('[data-toggle="tooltip"]');

    unction init() {
    $tooltip.tooltip();
    }


    // Events
    // Methods

    if ($tooltip.leng th) {
      init()
      f;
    }

})();

</script>