<?php
    session_start();
    require_once('connection.php');
    $id = $_GET['id'];
    //select single data
    //select email

        //cara install phpmailer
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
    //Load Composer's autoloader
    require 'vendor/autoload.php';

    if(isset($_POST['submit1'])){
        header('Location: esignature.php?id='.$row1['id']);
    }


    //Selecting user
    $result1 = $conn->query("SELECT * FROM order_details WHERE id ='$id'");
    $row1 = $result1->fetch(PDO::FETCH_ASSOC);
    $de=$row1['id'];
    $name = $row1['stat'];
    $name2 = $row1['email'];
    $email = $row1['email'];

    if(isset($_POST['submit1'])){
        header('Location: esignature.php?id='.$row1['id']);
    }
    // $orderID = $row1['request_id'];
    // $date_expired = $_POST['date_expired'];
 
    // $select = "SELECT * FROM order_details WHERE email = '$email' AND payment_stat ='paid' ";
    // $statement = $conn->prepare($select);
    // $statement->execute();
    // $row2 = $statement->fetchAll(PDO::FETCH_ASSOC);

    $today = date('Y-m-d');
    if(isset($_POST['submit'])){
        $date_expired = $_POST['date_expired'];
        // $snow=$_SESSION['date_expired'];
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                               //Enable verbose debug output
            $mail->isSMTP();                                    //Send using SMTP
            $mail->Host       = 'mail.beetriv.com';             //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                           //Enable SMTP authentication
            $mail->Username   = 'admin@beetriv.com';            //SMTP username
            $mail->Password   = '4bx~~ZJ8HJyq';                 //SMTP password
            $mail->SMTPSecure = 'ssl';                          //Enable implicit SSL encryption
            $mail->Port       = '290';                          //TCP port to connect to 290 as provided 
            
            //Recipients
            $mail->setFrom('admin@beetriv.com','Admin Beetriv');
            $mail->addAddress($name2);                              //Add a recipient 
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'A Runner Accepted your Delivery request!';
            $mail->Body    = '<h1> Thanks for shopping with us! </h1>'. '<h2> Your Item below will be delivered on: '  . $date_expired . '</h2>' .
            '<table style="width:90%; height: 100px;border-collapse:collapse;">
              <tr>
              
              <th style="border-bottom: 1px solid black; text-align:left; padding:10px;">Item ID </th>
              <th style="border-bottom: 1px solid black; text-align:left; padding:10px;">Item Name</th>
              <th style="border-bottom: 1px solid black; text-align:left; padding:10px;">Item Price</th>
              <th style="border-bottom: 1px solid black; text-align:left; padding:10px;">Item Quantity</th>
              </tr>';
              
              
              $mail->Body .= 
              '<tr>'.
              '<td style="border: 1px solid black; padding:15px;">' .$row1['prd_id']. '</td>'.
              '<td style="border: 1px solid black; padding:15px;">' .$row1['prd_name']. '</td>'.
              '<td style="border: 1px solid black; padding:15px;">'."$" .$row1['prd_price']. '</td>'.
              '<td style="border: 1px solid black; padding:15px;">' .$row1['prd_qty']. '</td>'.
              '</tr>'
              ;
        
                          
            
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    

    
    //echo $name2;
 


    
    //add code to update receipt table

    //fetch product details based from the order id
    $result = "SELECT * FROM product WHERE 1 AND prd_id IN (SELECT prd_id FROM order_details WHERE id = '$id') ";
    $handle = $conn->prepare($result);
    $handle->execute();
    $row = $handle->fetchAll(PDO::FETCH_ASSOC);

    //add code to delete data form order_details
    // $result = "DELETE FROM order_details where id='$id'";
    // $statement = $conn->prepare($result);
    // $statement->execute();
    // $row = $statement->fetchAll(PDO::FETCH_ASSOC);  

    //$email = $_SESSION['email'];
    // echo $email;

    //add code to save signature as PNG and upload to database 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
    <link type="text/css" href="jquerysignature/css/jquery.signature.css" rel="stylesheet"> 
    <script type="text/javascript" src="jquerysignature/js/jquery.signature.js"></script>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/user-profile.css">
    <title>Digital Signature for Deliveries</title>

    <style>
        @media (max-width: 800px) {
            .prd-flex-2{
                flex-direction: column;
            }
            .prd-flex{
                flex-direction: column;
            }
            .prd-grid{
                flex-direction: column;
            }
        }
        .prd-grid{
        display: flex;
        /* width: 60%; */
        margin: 20px 30px;
        }
        .prd-flex{
        -webkit-flex: 1 0 0;
        flex: 1 0 0;
        padding: 0 50px;
        }
        .prd-flex-2{
        -webkit-flex: 3 0 0;
        flex: 3 0 0;
        padding: 0 50px;
        }

        .kbw-signature { width: 400px; height: 200px;}
        #sigCust canvas{
            width: 100% !important;
            height: auto;
        }
        #sigRun canvas{
            width: 100% !important;
            height: auto;
        }

        .submitBtn{
            text-align: center;
            margin: auto;
            width: 50%;
            padding: 10px;
        }

        /* For additional notes textarea style */

        .wrap-input100 {
        width: 100%;
        position: relative;
        border: 1px solid #e6e6e6;
        border-radius: 13px;
        padding: 10px 30px 9px 22px;
        margin-bottom: 20px;
        }

        .label-input100 {
        font-family: Roboto,Helvetica,Arial,sans-serif;
        font-size: 12px;
        color: #393939;
        line-height: 1.5;
        text-transform: uppercase;
        }

        .input100 {
        display: block;
        width: 100%;
        background: transparent;
        font-family: Roboto,Helvetica,Arial,sans-serif;
        font-size: 18px;
        color: #555555;
        line-height: 1.2;
        padding-right: 15px;
        }


        /*---------------------------------------------*/
        input.input100 {
        height: 20px;
        }


        textarea.input100 {
        min-height: 90px;
        padding-top: 9px;
        padding-bottom: 13px;
        border: none;
        outline: none;
        }


        .input100:focus + .focus-input100::before {
        width: 100%;
        }

        .has-val.input100 + .focus-input100::before {
        width: 100%;
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

        <div class="container">
  
            <form method="POST" action="">

                <h2>Select date for item Delivery</h2>

                <!-- Add some code here to display cod items with details -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Shop</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach($row as $product){?>
                            <td>
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product['prd_img']); ?>" class="img-thumbnail" style="width:90px;">
                                <?php echo $product['prd_name'];?>         
                            </td>
                            <td>
                                <?php echo $product['display_name']; ?>
                            </td>
                            <td>
                                $<?php echo $product['prd_price'];?>
                            </td>
                            <td>
                                <?php echo $row1['prd_qty']; ?>
                            </td>
                            <td>
                                $<?php $totalSum = $product['prd_price'] * $row1['prd_qty']; 
                                    echo $totalSum; ?>
                            </td>
                            <!-- <td><a href="esignature.php?id=<?php echo $row1['id'];?>"> -->
                            <td>
                            <button class="btn btn-warning btn-lg float-right" placeholder="button" value="Sign Here!!" type='submit' name='submit1' <?php if(!isset ($date_expired)){ ?> disabled  <?php } ?>> Sign Here!!
				            <!-- </a></td> -->
                                    </button>
                            </td>
                           
                            
                    
                            <?php }?>
                        </tr>
                        
                    </tbody>
                </table>

                <!-- Hidden input type to sotre data inside database -->
                <input type="hidden" name="product_id" value="<?php echo $row1['prd_id']?>">
                <input type="hidden" name="product_name" value="<?php echo $row1['prd_name']?>">
                <input type="hidden" name="product_qty" value="<?php echo $row1['prd_qty']?>">
                <input type="hidden" name="product_price" value="<?php echo $row1['prd_price']?>">
                <input type="hidden" name="product_mthd" value="<?php echo $row1['payment_mthd']?>">
                
                <input type="hidden" name="product_stat" value="Completed">
                <!-- Enter code for Runner to Select the Date -->
                    <form method='POST' action="">


                            <div class="col-25" id="bid_details">
                            <label for="bid_date">Choose Date to Deliveer this item.</label>
                            </div>

                            <div class="col-75">
                            <input type="date" name="date_expired" id="date_expired">
                            
                            <button type='submit' name='submit'>Select Date</button>
                            <div class="p-2 flex-fill bd-highlight">
                            <div class="flex-column" >
                            <h9 class="lead" style="text-align:right;"><?php if (isset($date_expired) ){
                            //Exists
                            echo $date_expired;
                            }else{
                            //Doesn't exists
                            echo "No Date Selected";
                            }?> </h9>
                            </div>
                        </div>
                        </form> <br> <br>
                <!-- Retrieve customer's signature -->
 
                

            <!-- Add a textbox/input for runner or customer to fill in such as the change amount -->

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
<?php

?>
</html>