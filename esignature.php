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



    //Selecting user
    $result1 = $conn->query("SELECT * FROM order_details WHERE id ='$id'");
    $row1 = $result1->fetch(PDO::FETCH_ASSOC);
    $name = $row1['stat'];
    $name2 = $row1['email'];
    $email = $row1['email'];
    // $orderID = $row1['request_id'];

 
    // $select = "SELECT * FROM order_details WHERE email = '$email' AND payment_stat ='paid' ";
    // $statement = $conn->prepare($select);
    // $statement->execute();
    // $row2 = $statement->fetchAll(PDO::FETCH_ASSOC);

    $today = date('Y-m-d');

    echo $name2;
    if(($name) == 'pending'){
    //add code to save details to receipt table
        if(isset($_POST['submit'])){
            $prdID          =$_POST['product_id'];
            $prdName        =$_POST['product_name'];
            $prdQty         =$_POST['product_qty'];
            $prdPrice       =$_POST['product_price'];
            $prdStat        =$_POST['product_stat'];
            $paymentMthd    =$_POST['payment_mthd'];

            // $folderPath     = "img/esignature/";
            // For customer signature
            $image_parts1    =explode(";base64", $_POST['custSigned']);
            $image_type_aux1  =explode("image/", $image_parts1[0]);
            $image_type1 = $image_type_aux1[1];
            $image_base64_1 = base64_decode($image_parts1[1]);
            // $file1 = $folderPath . uniqid() .'.'.$image_type1;
            // file_put_contents($file1, $image_base64_1);

            // For runner signature
            $image_parts2    =explode(";base64", $_POST['runnerSigned']);   
            $image_type_aux2  =explode("image/", $image_parts2[0]);
            $image_type2 = $image_type_aux2[1];
            $image_base64_2 = base64_decode($image_parts2[1]);
            // $file2 = $folderPath . uniqid() .'.'.$image_type2;
            // file_put_contents($file2, $image_base64_2);

            //insert into receipt table
            $insert =$conn->query("INSERT INTO receipts (prd_id,prd_name,prd_qty,prd_price,prd_stats,payment_mthd,custSigned,runSigned,sales_date)
            VALUE ('$prdID','$prdName','$prdQty','$prdPrice','$prdStat','$paymentMthd','$image_type1','$image_type2','$today')");
            //update order_details table
            $update = "UPDATE order_details SET stat='completed' WHERE id='$id'";
            $runUpdate = $conn->prepare($update);
            $runUpdate->execute();

            $update1 = "UPDATE order_details SET payment_stat='paid' WHERE id='$id'";
            $runUpdate1 = $conn->prepare($update1);
            $runUpdate1->execute();

            // $result = "DELETE FROM order_details where id='$id'";
            // $statement = $conn->prepare($result);
            // $statement->execute();

            // $binde = [
            //     'user_id' => $row1['user_id'],
            //   ];
            //   $testting = 'insert into user_test(user_id) values (:user_id)';
            //   $statement1 = $conn->prepare($testting);
            //   $statement1->execute($binde);
              
            //   if($statement1->rowCount() == 1)
            //       {    
            // $orderID = $conn->lastInsertId();
            $select = "SELECT * FROM order_details WHERE email = '$email' AND  payment_stat ='paid' AND payment_mthd='Cash'  ";
            $statement = $conn->prepare($select);
            $statement->execute();
            $row2 = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            //enter phpmailer here?
            
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
                        $mail->addAddress($name2);                              //Add a recipient 
                    
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
            header('location: runner-order.php');
        }
    }else{
        header('location: runner-order.php');
    }


    
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

                <h2>Cash on Delivery E-Signature</h2>

                <!-- Add some code here to display cod items with details -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Shop</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach($row as $product){?>
                            <td>
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product['prd_img']); ?>" class="rounded img-thumbnail mr-2" style="width:40px;">
                                <?php echo $product['prd_name'];?>         
                            </td>
                            <td>
                                [Seller Name]
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
                            <?php }?>
                        </tr>
                        <tr class="border-top border-bottom">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <strong>
                                </strong>
                            </td>
                            <td><strong>$<?php echo $totalSum; ?></strong></td>
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

            <!-- Retrieve customer's signature -->
            <div class="prd-grid">
            <div class="prd-flex">
                <label class="" for="">Customer Signature:</label>
                <br/>
                <div id="sigCust" ></div>
                <br/>
                <button id="erase">Clear Signature</button>
                <textarea id="signature65" name="custSigned" style="display: none"></textarea>
            </div>

            <!-- Retrieve runner's signature -->
            <div class="prd-flex-2">
                <label class="" for="">Runner Signature:</label>
                <br/>
                <div id="sigRun" ></div>
                <br/>
                <button id="erase">Clear Signature</button>
                <textarea id="signature64" name="runnerSigned" style="display: none"></textarea>
            </div>
            </div>
            <br>
            <button name="submit">Submit</button>
        </form>

        </div>

            <script type="text/javascript">
                // for customer
                var sig = $('#sigCust').signature({
                    syncField: '#signature65', 
                    syncFormat: 'PNG'
                });
                $('#erase').click(function(e) {
                    e.preventDefault();
                    sig.signature('clear');
                    $("#signature65").val('');
                });

                //for runner
                var sigRun = $('#sigRun').signature({
                    syncField: '#signature64', 
                    syncFormat: 'PNG'
                });
                $('#erase').click(function(e) {
                    e.preventDefault();
                    sigRun.signature('clear');
                    $("#signature64").val('');
                });
            </script>

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
</html>