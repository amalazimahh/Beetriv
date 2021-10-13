<?php
ob_start();
session_start();
require_once "connection.php";
$email = $_SESSION['email'];

$payId = $_GET['pay'];

    //cara install phpmailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';
//echo $email
// $id = $_GET['product'];
$result = $conn->query("SELECT * FROM product");
$row = $result->fetch(PDO::FETCH_ASSOC);

$result1 = $conn->query("SELECT * FROM users WHERE email = '$email'");
$row1 = $result1->fetch(PDO::FETCH_ASSOC);


// $result3 = $conn->query("SELECT * FROM order_details");
// $row3 = $result->fetch(PDO::FETCH_ASSOC);
// $
// $userid = $row1['user_id'];
// echo $row1['username'];
// $select = "SELECT * From PRODUCT WHERE 1";
// $orderID = $conn->lastInsertId();



$status = "pending";
$paymentStat ="paid";
$payment_mthd ="Paypal";
$payment_type = "test";


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
              'payment_stat' => $paymentStat,
              'payId' => $payId
               ];
            // $test1 = [
            //     'user_id' => $row1['user_id']
            //    ];
               
            $sqlDetails = 'insert into order_details (request_id,prd_id, prd_name, prd_price, prd_qty, user_id, email, username, stat, contact_no, payment_mthd, payment_stat, payId) 
            values(:order_id,:product_id,:product_name,:product_price,:qty,:user_id,:email,:username,:stat,:contact_no,:payment_mthd,:payment_stat, :payId) ';

            $orderDetailStmt = $conn->prepare($sqlDetails);
            
            $orderDetailStmt->execute($paramOrderDetails);
          }
          $select = "SELECT * FROM order_details WHERE email = '$email' AND request_id='$orderID' ";
          // $row2=$select->fetch(PDO::FETCH_ASSOC);
          $statement = $conn->prepare($select);
          $statement->execute();
          $row2 = $statement->fetchAll(PDO::FETCH_ASSOC);
                  
            unset($_SESSION['cart_items']);
                    }
                    //email user that payment accepted.
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = 0;                                   //Enable verbose debug output
                        $mail->isSMTP();                                        //Send using SMTP
                        $mail->Host       = "smtp.gmail.com";                   //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                               //Enable SMTP authentication
                        $mail->Username   = 'ayamketupat02@gmail.com';          //SMTP username
                        $mail->Password   = 'k4k5dpkk';                         //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     //Enable implicit TLS encryption
                        $mail->Port       = 587;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                        
                
                        //Recipients
                        $mail->setFrom('ayamketupat02@gmail.com', 'beetriv.com');
                        $mail->addAddress($email);                              //Add a recipient 
                    
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Beetriv[Online Receipt]';
                        $mail->Body    = '<h1> Thanks for shopping with us! </h1>'.
                        '<table style="width:90%; height: 100px;border-collapse:collapse;">
                          <tr>
                          
                          <th style="border-bottom: 1px solid black; text-align:left; padding:10px;">Item ID </th>
                          <th style="border-bottom: 1px solid black; text-align:left; padding:10px;">Item Name</th>
                          <th style="border-bottom: 1px solid black; text-align:left; padding:10px;">Item Price</th>
                          <th style="border-bottom: 1px solid black; text-align:left; padding:10px;">Item Quantity</th>
                          </tr>';
                          
                          foreach($row2 as $items){
                          $mail->Body .= 
                          '<tr>'.
                          '<td style="border: 1px solid black; padding:15px;">' .$items['prd_id']. '</td>'.
                          '<td style="border: 1px solid black; padding:15px;">' .$items['prd_name']. '</td>'.
                          '<td style="border: 1px solid black; padding:15px;">'."$" .$items['prd_price']. '</td>'.
                          '<td style="border: 1px solid black; padding:15px;">' .$items['prd_qty']. '</td>'.
                          '</tr>'
                          ;
                    }
                                      
                        
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                  
                  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Checkout - Payment Succesful</title>
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
                    <ul class="nav justify-content-end">
                    <a class="nav-item nav-link" style='color:black' aria-current="page" href="wishlist.php">
                    <i class="bi bi-heart" style='color:black'><?php echo (isset($_SESSION['wish_items']) && count($_SESSION['wish_items'])) > 0 ? count($_SESSION['wish_items']):''; ?></i>
                    <a class="nav-item nav-link" style='color:black' aria-current="page" href="cart.php">
                    <i class="bi bi-cart4" style='color:black'><?php echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):''; ?></i>
                    <a class="nav-item nav-link" style='color:black' aria-current="page" href="user-profile.php"><i class="bi-person-circle"></i></a>
                    <a class="nav-item nav-link" style='color:black' aria-current="page" href="login.php"><i class="bi bi-box-arrow-right"></i></a>
                    </a>
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