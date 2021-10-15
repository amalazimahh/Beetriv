<?php 
    session_start();
    require_once "connection.php";
    $email = $_SESSION['email'];
    $id = $_GET['product'];
    // echo $email;

    // logout
    $session=$_SESSION['email'];

    //Selecting different type of users
    $selectprofile = $conn->query("SELECT * FROM users WHERE email='$email'");
    $row1 = $selectprofile->fetch(PDO::FETCH_ASSOC);

    $type = $row1['type'];
    if (isset($_POST['profile'])){
    if(($type) == 'seller'){
        header('location: seller-profile.php');
    }
    else if(($type) == 'customer'){
        header('location: user-profile.php');
    }
    else if(($type) == 'runner'){
        header('location: runner-order.php');
    }

}
if (isset($_POST['cart'])){
    header('location: cart.php');
}
if (isset($_POST['wishlist'])){
    header('location: wishlist.php');
}

    //cara install phpmailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';
        
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

    $result = $conn->query("SELECT * FROM product WHERE prd_id = '$id'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $prod_qty = $row['prd_qty'];

    // Fetch seller_review 
    $rateQuery = $conn->prepare("SELECT * FROM seller_review LEFT JOIN users ON users.user_id=seller_review.user_id WHERE prd_id = '$id' ");
    $rateQuery->execute();
    $rates = $rateQuery->fetchAll(PDO::FETCH_ASSOC);

    // Update bid
    // if(isset($_POST['place_bid'])){
    //     $current_bid = $_POST['current_bid'];
    //     $pdoQuery = ("UPDATE product SET current_bid = '$current_bid', current_bidder = '$email' WHERE prd_id = '$id' ");
    //     $pdoQuery_run = $conn->prepare($pdoQuery);
    //     $pdoQuery_run->execute();
    //     echo "<meta http-equiv='refresh' content='0'>";
    // }


    if(isset($_POST['add_to_cart']) && $_POST['add_to_cart'] == 'add to cart')
    {
        $productID = intval($_POST['product_id']);
        $productQty = intval($_POST['product_qty']);
        
        $result = $conn->query("SELECT * FROM product WHERE prd_id = '$id'");
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $calculateTotalPrice = number_format($productQty * $row['prd_price'],2);
        
        $cartArray = [
            'product_id'    =>$productID,
            'qty'           => $productQty,
            'product_name'  =>$row['prd_name'],
            'product_price' => $row['prd_price'],
            'total_price'   => $calculateTotalPrice,
            'product_img'   =>$row['prd_img'],
            'username'      =>$row['username']
        ];
        
        if(isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items']))
        {
            $productIDs = [];
            foreach($_SESSION['cart_items'] as $cartKey => $cartItem)
            {
                $productIDs[] = $cartItem['product_id'];
                if($cartItem['product_id'] == $productID)
                {
                    $_SESSION['cart_items'][$cartKey]['qty'] = $productQty;
                    $_SESSION['cart_items'][$cartKey]['total_price'] = $calculateTotalPrice;
                    break;
                }
            }

            if(!in_array($productID,$productIDs))
            {
                $_SESSION['cart_items'][]= $cartArray;
            }

            $successMsg = true;
            
        }
        else
        {
            $_SESSION['cart_items'][]= $cartArray;
            $successMsg = true;
        }

    }

else
    if(isset($_POST['add_to_wishlist']) && $_POST['add_to_wishlist'] == 'add to wishlist')
    {
        $productID = intval($_POST['product_id']);
        
        $result = $conn->query("SELECT * FROM product WHERE prd_id = '$id'");
        $row = $result->fetch(PDO::FETCH_ASSOC);

        
        $cartArray = [
            'product_id'    =>$productID,
            'product_name'  =>$row['prd_name'],
            'product_price' =>$row['prd_price'],
            'product_img'   =>$row['prd_img']
        ];
        
        if(isset($_SESSION['wish_items']) && !empty($_SESSION['wish_items']))
        {
            $productIDs = [];
            foreach($_SESSION['wish_items'] as $cartKey => $cartItem)
            {
                $productIDs[] = $cartItem['product_id'];
                if($cartItem['product_id'] == $productID)
                {
                    // $_SESSION['wish_items'][$cartKey]['qty'] = $productQty;
                    // $_SESSION['wish_items'][$cartKey]['total_price'] = $calculateTotalPrice;
                    // break;
                }
            }

            if(!in_array($productID,$productIDs))
            {
                $_SESSION['wish_items'][]= $cartArray;
            }

            $successMsgW = true;
            
        }
        else
        {
            $_SESSION['wish_items'][]= $cartArray;
            $successMsgW = true;
        }

    }
    //Inquiry chat service
        if(isset($_POST['contact'])){
            $productID = intval($_POST['product_id']);
            
            $result = $conn->query("SELECT * FROM product WHERE prd_id = '$id'");
            $row = $result->fetch(PDO::FETCH_ASSOC);
    
            
            $cartArray = [
                'product_id'    =>$productID,
                'product_name'  =>$row['prd_name'],
                'product_price' =>$row['prd_price'],
                'product_img'   =>$row['prd_img']
                
            ];
    
            header("Location: chat.php?product=" . $row['prd_id']);
            exit;
        }
    
    // fetching bidding data
    $stmt = $conn->query("SELECT * FROM product_bid WHERE prd_id = '$id'");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    //$count = $stmt->fetchColumn();

    // fetching paypal details
    $statement = $conn->query("SELECT * FROM paypal_details WHERE user_paypal = '$email'");
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // add into product_bid
    if(isset($_POST['placebid'])){
        // fetching item seller
    $display_name = $row['display_name'];
    $sellers = $conn->query("SELECT * FROM users WHERE email = '$display_name'");
    $seller = $sellers->fetch(PDO::FETCH_ASSOC);
        // if ($count) {
            $seller = $row['display_name'];
            $current_bid   = $_POST['current_bid'];
            if ( $current_bid <= $row['starting_bid'] || $current_bid < (isset($res['current_bid']) + $row['bid_increment']) || $current_bid <= isset($res['current_bid']) ) {
                 echo '<script>alert("Bid needs to be higher!")</script>';
                 echo "<meta http-equiv='refresh' content='0'>";
                 
                //echo "<script>Qual.error('Unsuccessful Bid','Bid needs to be higher.')</script>";
                
            } else {
            if ( isset($res['prd_id']) ) {
                    //$seller = $row['display_name'];
                // Update bid
                    $prd_id         = ($_POST['prd_id']);
                    // $current_bid   = $_POST['current_bid'];
                    $paypal_email    = ($_POST['paypal_email']);
                    $paypal_psw    = ($_POST['paypal_psw']);
                    $current_bidder    = ($_POST['current_bidder']);
                    $pdoQuery = ("UPDATE product_bid SET current_bid = '$current_bid', current_bidder = '$email', prev_bidder = '$current_bidder' WHERE prd_id = '$prd_id' ");
                    $pdoQuery_run = $conn->prepare($pdoQuery);
                    $pdoQuery_run->execute();
                    
                
                    //Mail Set up
            $mail= new PHPMailer(true);

            try {

                //Send mail to highest bidder
                
                //Enable debug output
                $mail->SMTPDebug = 0;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server 
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'ayamketupat02@gmail.com';

                //SMTP password
                $mail->Password = 'k4k5dpkk';

                //SMTP username
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //SMTP PORT
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('haziqzulhazmi@gmail.com','beetriv.com');

                //add recipient
                $mail->addAddress($email,$username);

                //Set email format to HTML
                $mail->isHTML(true);

                //converting text to html
                // $mail .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $url = "http://" . $_SERVER ["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/product-details.php?product=$id";
                $mail->Subject = 'Successful Bid Place';
                $mail->Body    = '<p>Congratulations! </p>'.'<p>You have successfully placed a bid and currently the highest on item <b>'.$row['prd_name'].'</b>. Click link below to see your item:</p><br>'.$url;
                //<a href="http://localhost/Email%20Authentication/registration.php">Reset your password</a> 

                $mail->send();

                $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

                if (empty($result)) {
                    $select1 = "SELECT * FROM paypal_details WHERE 1";
                    $insert1 = $conn->query ("INSERT INTO paypal_details (user_paypal, paypal_email, paypal_psw) VALUES ('$email','$paypal_email','$paypal_psw')");
                    }
                    echo "<meta http-equiv='refresh' content='0'>";


            }catch (Exception $e){
                echo "Message cannot send, Error Mail: {$mail->ErrorInfo}";

            }
                try {

                    //Send mail to prev bidder
                    
                    //Enable debug output
                    $mail->SMTPDebug = 0;
    
                    //Send using SMTP
                    $mail->isSMTP();
    
                    //Set the SMTP server 
                    $mail->Host = 'smtp.gmail.com';
    
                    //Enable SMTP authentication
                    $mail->SMTPAuth = true;
    
                    //SMTP username
                    $mail->Username = 'ayamketupat02@gmail.com';
    
                    //SMTP password
                    $mail->Password = 'k4k5dpkk';
    
                    //SMTP username
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
                    //SMTP PORT
                    $mail->Port = 587;
    
                    //Recipients
                    $mail->setFrom('haziqzulhazmi@gmail.com','beetriv.com');
    
                    //add recipient
                    $mail->addAddress($current_bidder,$username);
    
                    //Set email format to HTML
                    $mail->isHTML(true);
    
                    //converting text to html
                    // $mail .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $url = "http://" . $_SERVER ["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/product-details.php?product=$id";
                    $mail->Subject = 'Oh no!';
                    $mail->Body    = '<p>There is a new highest bid placed on your item <b>'.$row['prd_name'].'</b> and your bid on item <b>'.$row['prd_name'].'</b> has been outbid. Click link below to see the item:</p><br>'.$url;
                    //<a href="http://localhost/Email%20Authentication/registration.php">Reset your password</a> 
    
                    $mail->send();
    
                    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
    
    
                }catch (Exception $e){
                    echo "Message cannot send, Error Mail: {$mail->ErrorInfo}";
                }
                
                if (isset($res['current_bidder']) ){
                try {

                    //Mail Set up
                    $mail= new PHPMailer(true);
                    
                    //Enable debug output
                    $mail->SMTPDebug = 0;
    
                    //Send using SMTP
                    $mail->isSMTP();
    
                    //Set the SMTP server 
                    $mail->Host = 'smtp.gmail.com';
    
                    //Enable SMTP authentication
                    $mail->SMTPAuth = true;
    
                    //SMTP username
                    $mail->Username = 'ayamketupat02@gmail.com';
    
                    //SMTP password
                    $mail->Password = 'k4k5dpkk';
    
                    //SMTP username
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
                    //SMTP PORT
                    $mail->Port = 587;
    
                    //Recipients
                    $mail->setFrom('haziqzulhazmi@gmail.com','beetriv.com');
    
                    //add recipient
                    $mail->addAddress($seller,$username);
    
                    //Set email format to HTML
                    $mail->isHTML(true);
    
                    //converting text to html
                    // $mail .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $url = "http://" . $_SERVER ["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/product-details.php?product=$id";
                    $mail->Subject = 'New bid on your item!';
                    $mail->Body    = '<p>Someone bid on your item!</p><br><p><b>'.$res['current_bidder'].'</b> is currently the highest bid on your item <b>'.$row['prd_name'].'</b> with a bid of BND'.$current_bid;
                    //<a href="http://localhost/Email%20Authentication/registration.php">Reset your password</a> 
    
                    $mail->send();
    
                    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
    
                }catch (Exception $e){
                    echo "Message cannot send, Error Mail: {$mail->ErrorInfo}";
                }
            }

                    } else {
                        $prd_id         = ($_POST['prd_id']);
            // $current_bidder = ($_POST['email']);
            // $current_bid    = ($_POST['current_bid']);
            // $seller = $row['display_name'];
            $paypal_email    = ($_POST['paypal_email']);
            $paypal_psw    = ($_POST['paypal_psw']);

            $select = "SELECT * FROM product_bid WHERE 1";

                $insert = $conn->query ("INSERT INTO product_bid (prd_id,current_bidder, current_bid) VALUES ('$prd_id','$email','$current_bid')");

                if (empty($result)) {
                    $select1 = "SELECT * FROM paypal_details WHERE 1";
                    $insert1 = $conn->query ("INSERT INTO paypal_details (user_paypal, paypal_email, paypal_psw) VALUES ('$email','$paypal_email','$paypal_psw')");
                    }

            //Mail Set up
            $mail= new PHPMailer(true);

            try {
                
                //Enable debug output
                $mail->SMTPDebug = 0;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server 
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'ayamketupat02@gmail.com';

                //SMTP password
                $mail->Password = 'k4k5dpkk';

                //SMTP username
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //SMTP PORT
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('haziqzulhazmi@gmail.com','beetriv.com');

                //add recipient
                $mail->addAddress($email,$username);

                //Set email format to HTML
                $mail->isHTML(true);

                //converting text to html
                // $mail .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $url = "http://" . $_SERVER ["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/product-details.php?product=$id";
                $mail->Subject = 'Successful Bid Place';
                $mail->Body    = '<p>Congratulations! </p>'.'<p>You have successfully placed a bid and currently the highest on item <b>'.$row['prd_name'].'</b>. Click link below to see your item:</p><br>'.$url;
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

            if (isset($res['current_bidder']) ){
            try {

                //Mail Set up
                $mail= new PHPMailer(true);
                
                //Enable debug output
                $mail->SMTPDebug = 0;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server 
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'ayamketupat02@gmail.com';

                //SMTP password
                $mail->Password = 'k4k5dpkk';

                //SMTP username
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //SMTP PORT
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('haziqzulhazmi@gmail.com','beetriv.com');

                //add recipient
                $mail->addAddress($seller,$username);

                //Set email format to HTML
                $mail->isHTML(true);

                //converting text to html
                // $mail .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $url = "http://" . $_SERVER ["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/product-details.php?product=$id";
                $mail->Subject = 'New bid on your item!';
                $mail->Body    = '<p>Someone bid on your item!</p><br><p><b>'.$res['current_bidder'].'</b> is currently the highest bid on your item <b>'.$row['prd_name'].'</b> with a bid of BND'.$current_bid;
                //<a href="http://localhost/Email%20Authentication/registration.php">Reset your password</a> 

                $mail->send();

                $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

            }catch (Exception $e){
                echo "Message cannot send, Error Mail: {$mail->ErrorInfo}";
            }
        }


                    }
                            }
                    // } else {
                    // echo 'Error: '.mysql_error();
                    //         }           

    }

    //notify when time expired
    date_default_timezone_set('Asia/Brunei');
    $expireday = $row['date_expired']; //from database
    $expiretime = $row['time_expired'];
    $dateTime = new DateTime();
    // echo $dateTime->format('Y-m-d H:i:s');
    $combinedDT = date('Y-m-d H:i:s', strtotime("$expireday $expiretime"));
    // echo $combinedDT;
    if ( $row['bid_status'] == "yes" && $combinedDT < $dateTime->format('Y-m-d H:i:s')) {
        $seller = $row['display_name'];
        $current_bidder = $res['current_bidder'];
        $expired = 'expired';
        // $pdoQuery = ("UPDATE product_bid SET bid_result = '$current_bidder', bid_time = '$expired' WHERE prd_id = '$id' ");
        //             $pdoQuery_run = $conn->prepare($pdoQuery);
        //             $pdoQuery_run->execute();
        $pdoQuery = ("UPDATE product SET bid_expiry = '$expired' WHERE prd_id = '$id' ");
                    $pdoQuery_run = $conn->prepare($pdoQuery);
                    $pdoQuery_run->execute();
        
        if (empty($res['bid_result'])) {         
            try {

                //Mail Set up
                $mail= new PHPMailer(true);
                
                //Enable debug output
                $mail->SMTPDebug = 0;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server 
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'ayamketupat02@gmail.com';

                //SMTP password
                $mail->Password = 'k4k5dpkk';

                //SMTP username
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //SMTP PORT
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('haziqzulhazmi@gmail.com','beetriv.com');

                //add recipient
                $mail->addAddress($current_bidder,$username);

                //Set email format to HTML
                $mail->isHTML(true);

                //converting text to html
                // $mail .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $url = "http://" . $_SERVER ["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/product-details.php?product=$id";
                $mail->Subject = 'Bid time has ran out!';
                $mail->Body    = '<p>Congratulation!</p><br><p>You are the highest bid on item <b>'.$row['prd_name'].'</b> and you can claim your item <b>'.$row['prd_name'].'</b> at link below:</p><br>'.$url;
                //<a href="http://localhost/Email%20Authentication/registration.php">Reset your password</a> 

                $mail->send();

                $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

                $pdoQuery = ("UPDATE product_bid SET bid_result = '$current_bidder', bid_time = '$expired' WHERE prd_id = '$id' ");
                    $pdoQuery_run = $conn->prepare($pdoQuery);
                    $pdoQuery_run->execute();

            }catch (Exception $e){
                echo "Message cannot send, Error Mail: {$mail->ErrorInfo}";
            }

            try {

                //Mail Set up
                $mail= new PHPMailer(true);
                
                //Enable debug output
                $mail->SMTPDebug = 0;

                //Send using SMTP
                $mail->isSMTP();

                //Set the SMTP server 
                $mail->Host = 'smtp.gmail.com';

                //Enable SMTP authentication
                $mail->SMTPAuth = true;

                //SMTP username
                $mail->Username = 'ayamketupat02@gmail.com';

                //SMTP password
                $mail->Password = 'k4k5dpkk';

                //SMTP username
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //SMTP PORT
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('haziqzulhazmi@gmail.com','beetriv.com');

                //add recipient
                $mail->addAddress($seller,$username);

                //Set email format to HTML
                $mail->isHTML(true);

                //converting text to html
                // $mail .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $url = "http://" . $_SERVER ["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/product-details.php?product=$id";
                $mail->Subject = 'Your bid time is over!';
                $mail->Body    = '<p>Congratulation!</p><br><p>Highest bid on your item <b>'.$row['prd_name'].'</b> is won by <b>'.$res['current_bidder'].'</b> with a bid of '.$current_bid.'You will be notified again!';
                //<a href="http://localhost/Email%20Authentication/registration.php">Reset your password</a> 

                $mail->send();

                $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

            }catch (Exception $e){
                echo "Message cannot send, Error Mail: {$mail->ErrorInfo}";
            }
            
        }
    }

    // fetching item from seller
    $display_name = $row['display_name'];
    $sellers = $conn->query("SELECT * FROM users WHERE email = '$display_name'");
    $seller = $sellers->fetch(PDO::FETCH_ASSOC);

    $ending = date('Y-m-d H:i:s', strtotime("$expireday $expiretime -1 day"));
    if ($row['bid_status'] == "yes" && $dateTime->format('Y-m-d H:i:s') > $ending && $combinedDT > $dateTime->format('Y-m-d H:i:s')) {
        $ending = 'ending soon';

        $pdoQuery1 = ("UPDATE product SET bid_expiry = '$ending' WHERE prd_id = '$id' ");
        $pdoQuery_run1 = $conn->prepare($pdoQuery1);
        $pdoQuery_run1->execute();

        $pdoQuery = ("UPDATE product_bid SET bid_time = '$ending' WHERE prd_id = '$id' ");
        $pdoQuery_run = $conn->prepare($pdoQuery);
        $pdoQuery_run->execute();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Beetriv - Product Details</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/user-profile.css">
        <!-- alert -->
        <script src="https://cdn.jsdelivr.net/gh/cosmogicofficial/quantumalert@latest/minfile/quantumalert.js" charset="utf-8"></script>
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

        /* ul{
        list-style-type: none;
        display: flex;
        /* justify-content: center; */
        /* align-items: center; */
        /* padding: 0px; */
        /* } */
        li{
        padding: 3px;
        }
            .prd_img img{
                width: 470px; 
                height: 530px;
                text-align: center;
            }
            .wrap-input100 {
            width: 100%;
            position: relative;
            border: 1px solid #e6e6e6;
            border-radius: 13px;
            padding: 10px 30px 9px 22px;
            margin-bottom: 20px;
            }

            .rs1-wrap-input100 {
            width: calc((100% - 30px) / 2);
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

            /* Rate Star CSS */
            .result-container{
                width: 120px; 
                height: 24px;
                background-color: #ccc;
                vertical-align: middle;
                display: inline-block;
                position: relative;
                top: -4px;
            }
            .rate-stars{
                width: 120px; 
                height: 24px;
                background: url(img/rate-stars.png) no-repeat;
                background-size: cover;
                position: absolute;
            }
            .rate-bg{
                height: 24px;
                background-color: #ffbe10;
                position: absolute;
            }

            /* Display Rate Count */
            .reviewCount, .reviewScore {
                font-size: 14px; 
                color: #666666; 
                margin-left: 5px;
            }
            .reviewScore {
                font-weight: 600;
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
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
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
                            <li><a class="dropdown-item" href="bid-store.php">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="bid-store.php">Active Bid</a></li>
                                <li><a class="dropdown-item" href="bid-ending.php">Ending Soon</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- <ul class="nav justify-content-end"> -->
                   
                    <!-- <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="user-profile.php"><i class="bi-person-circle"></i></a></li> -->
                    <!-- <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="login.php"><i class="bi bi-box-arrow-right" name="logout" method="post"></i></a></li> -->
                    <!-- <form action = "store.php" method ="POST">
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" ><i class="bi bi-box-arrow-right" name="logout"></i></a></li>
                   </form> -->
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
        <!-- to cart -->
        <?php if(isset($successMsg) && $successMsg == true){?>
            <div class="row mt-3">
                <div class="col-md-12" >
                    <div class="alert alert-success alert-dismissible" style="background-color: #99d98c;">
                         <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['prd_img']); ?>" class="rounded img-thumbnail mr-2" style="width:40px;"><?php echo $row['prd_name']?> is added to cart.
                    </div>
                </div>
            </div>
         <?php }?>
            <!-- wishlist msg -->
            <?php if(isset($successMsgW) && $successMsgW == true){?>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible">
                         <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <prd_img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['prd_img']); ?>" class="rounded prd_img-thumbnail mr-2" style="width:40px;"><?php echo $row['prd_name']?> is added to wishlist. <a href="wishlist.php" class="alert-link">View Wishlist</a>
                    </div>
                </div>
            </div>
         <?php }?>

        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6 prd_img"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['prd_img']); ?>"></div>
                    <div class="col-md-6">
                        <div class="small mb-1"><?php echo $row['prd_category']?></div>
                        <h1 class="display-5 fw-bolder"><?php echo $row['prd_name']?></h1>
                        <div class="fs-5 mb-5">
                        <span class="text-muted text-decoration-line-through"><?php echo $row['old_price']?></span><br><span>BND$<?php echo $row['prd_price']?></span><br>

                            <h10 class="lead"><?php echo $seller['username'];?></h10>
                        </div>
                        <div class="pb-5">
                        <textarea class="lead" style="width:700px;height:200px;background-color:transparent;border:0px;" disabled><?php echo $row['prd_desc']?></textarea>
                        </div>
                        <?php // if( empty($row['bid_expiry']) ): ?>
                        <form method="POST">
                        <div class="d-flex pb-4" >
                            <div class="large col-2">Quantity</div>
                                <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 5rem" name="product_qty" id="productQty" class="form-control" placeholder="Quantity" min="1" max="1000" />
                        </div>    
                            <div class="d-flex pb-4" >
                                <input type="hidden" name="product_id" value="<?php echo $row['prd_id']?>">
                                <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="add_to_cart" value="add to cart" <?php if ($prod_qty == '0'){ ?> disabled placeholder="outofstock"; <?php   } ?> onclick="addtocart(<?php echo $row['prd_id']?>)" >
                                <!-- <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="add_to_cart" value="add to cart"> -->
                                <?php if ($prod_qty == '0'){ ?>
                                    <i class="bi-cart-fill me-1"></i>
                                    Out of Stock
                                    <?php }else{ ?> 

                                    <i class="bi-cart-fill me-1"></i>
                                    Add to cart
                                    <?php } ?>
                                    
                                </button>
                                <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="add_to_wishlist" value="add to wishlist">
                                    <i class="bi-bookmark-heart-fill"></i>
                                    Wishlist
                                </button>
                                <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="contact" value="">
                                    <i class="bi-chat-fill"></i>
                                    <?php echo $row['phone_number']?>
                                </button>
                            </div>
                        </form>
                        <?php // endif; ?>

                        <?php if( $row['bid_status'] == "yes" && empty($row['bid_expiry']) || $row['bid_expiry'] == 'ending' ): ?>
                        <!-- bidding -->
                        <div class="d-flex pb-4" >
                        <div class="p-2 flex-fill bd-highlight">
                            <div class="flex-column">
                        <p>Remaining Bid Time:</p>
                        <h9 class="lead" id="timer_value"></h9>
                        <p class="text-danger" id="timer_ending"></p>
                             </div>
                        </div>
                        <script type="text/javascript">
                            var timer_date='<?php echo $row['date_expired']?>';
                            var timer_time='<?php echo $row['time_expired']?>';

                            //arrange values in date-time format 
                            var date_time=timer_date+" "+timer_time;
                            var end = new Date(date_time).getTime();

                            //update countdown every 1 second
                            var x = setInterval(function(){
                                //get today's date and time
                                var current = new Date().getTime();
                                //to get the difference between current and expiry datetime
                                var remain = end - current;
                                // console.log(remain);
                                //time calculations for day, hours, minutes and second
                                var days = Math.floor(remain/(1000 * 60 * 60 * 24));
                                var hours = Math.floor((remain%(1000*60*60*24))/(1000*60*60));
                                var minutes = Math.floor((remain%(1000*60*60))/(1000*60));
                                var seconds = Math.floor((remain%(1000*60))/1000);
                                //Output the results in an element with id="timer_value"
                                document.getElementById("timer_value").style.color = "#4bb543";
                                document.getElementById("timer_value").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                                //if countdown is over 0
                                if(remain<0){
                                    clearInterval(x);
                                    document.getElementById("timer_value").style.color = "#ff0000";
                                    document.getElementById("timer_value").innerHTML = "Bid Expired!";
                                }

                                if(remain < 86400000){
                                    clearInterval(x);
                                    document.getElementById("timer_value").style.color = "#ff0000";
                                    document.getElementById("timer_ending").innerHTML = "Bid is ending soon!";
                                }
                                
                            },1000);
                        
                        </script>
                   
                        <div class="p-2 flex-fill bd-highlight">
                            <div class="flex-column">
                        <p>Starting Bid:</p>
                        <h9 class="lead">BND$<?php echo $row['starting_bid'] ?></h9>

                             </div>
                        </div>
                        <div class="p-2 flex-fill bd-highlight">
                        <div class="flex-column">
                        <p>Current Bid:</p>
                        <h9 class="lead"><?php if (isset($res['current_bid']) ){
                            //Exists
                            echo "BND$".$res['current_bid'];
                        }else{
                            //Doesn't exists
                            echo "No bid yet";
                        }?></h9>
                             </div>
                        </div>
                    </div>

                    <form method="POST">
                    <div class="d-flex flex-row bd-highlight">
                    <div class="d-flex p-2 bd-highlight">
                    <span class="input-group-text">BND$</span>
                    <input type="hidden" name="prd_id" value="<?php echo $row['prd_id']?>">
                    <input type="hidden" name="current_bidder" value="<?php if (isset($res['current_bidder']) ){
                                                    //Exists
                                                    echo $res['current_bidder'];
                                                } ?>">
                    <input type="number" class="form-control" name="current_bid" step="any" id="current_bid"> 
                    <script>
                    // function verifyBid() {
                    //     var current_bid = document.getElementById("current_bid").value;
                    //     var starting_bid='';
                    //     if(current_bid <= starting_bid) {
                    //         document.getElementById("bid_msg").innerHTML = "**Bid is less than starting bid.";
                    //         return false;
                    //     }
                    // }
                    </script>  
                    </div>
                    <div class="d-grid">
                    <button class="btn btn-warning text-uppercase" name= "placebid" data-bs-toggle="modal" data-bs-target="#modalForm">Place Bid</button>
                    </div>
                    </div>
                    <div class="col-auto">
                    <span id="bid_msg" >
                        
                        </span>
                        <span class="current_bid" >
                        <?php if (isset($row['bid_increment']) ){
                            //Exists
                            echo  "Minimum bid increment is BND$".$row['bid_increment'];
                        }else{
                            //Doesn't exists
                            echo "Minimum bid increment is BND$0.01";
                        }?>
                        </span>
                    </div>
                    </div>
                
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script>
                        $(document).ready(function(){
                        $("input[name=current_bid]").keyup(function(){
                        var bid=$("input[name=current_bid]").val();
                        if (bid <= <?php echo $res['current_bid'] ?>) {
                            $('span.current_bid').css("color", "red");
                            $('span.current_bid').text("Your bid needs to be higher.");
                            }
                        if  (bid > <?php echo $res['current_bid'] ?>) {
                            $('span.current_bid').css("color", "grey");
                            $('span.current_bid').text("Minimum bid increment is $0.01");
                            }
                        });
                        });
                        </script>
                    <!-- end bidding -->
                </div>
            </div>
            <?php endif; ?>

                        <!-- show for winning bid -->
            <?php if( $row['bid_status'] == "yes" && $row['bid_expiry'] == 'expired' && $res['current_bidder'] == $email ): ?>
                <div class="d-grid gap-2">
                    <button class="btn btn-success" onclick="location.href = 'paybid.php';"  type="button">Get Bid Item Here</button>
                </div>
                <?php endif; ?>

                <!-- Credit cards Modal -->
            <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">PayPal Details Required</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    
                                    <div class="card">
                                        <div class="card-header p-0">
                                            <h2 class="mb-0"> <button class="btn btn-light btn-block text-left p-3 rounded-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <div class="d-flex align-items-center justify-content-between"> <span>PayPal</span>
                                                        <div class="icon"> <img src="https://i.imgur.com/7kQEsHU.png" width="30"></div>
                                                    </div>
                                                </button> </h2>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body payment-card-body"> 
                                                <div class="d-flex bd-highlight pb-4"><input type="text" name="paypal_email" class="form-control" value="<?php if (isset($result['user_paypal']) ){
                                                    //Exists
                                                    echo  $result['paypal_email'];
                                                }?>" placeholder="PayPal Email" required> </div>
                                                <div class="d-flex bd-highlight"><input type="password" name="paypal_psw" class="form-control" value="<?php if (isset($result['paypal_psw']) ){
                                                    //Exists
                                                    echo  $result['paypal_psw'];
                                                }?>" placeholder="PayPal Password" required> </div>
                                                  
                                        <div class="pt-4 justify-content-center form-check">
                                            <input type="checkbox" class="form-check-input" id="check" required/>
                                            <label class="form-check-label" for="check">I have read, understood and agreed with <a class="text-warning" href="#">Beetriv Terms and Conditions</a>.</label>
                                        </div>
                                                    
                                                </div> <div class="p-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="text-center pb-3">
                                        <span class="certificate-text text-danger"> <i class="bi bi-exclamation-circle"></i> You are not allowed to cancel your bid once submitted.</span>
                                    </div>

                                <div class="modal-footer d-block">
                                    <button type="submit" id="submit" name="placebid" class="btn btn-warning float-end">Submit</button>
                                </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h2>Reviews</h2>
                    <?php foreach($rates as $review){ ?>
                        <div class="wrap-input100" style="margin-top: 10px">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($review['img']); ?>" class="rounded" style="width:40px;">
                            <div class="result-container">
                                <?php $reviewAvgCalc = $review['prd_quality'] + $review['seller_service'];
                                        $reviewAvg = ($reviewAvgCalc/2)*10; ?>
                                <div class="rate-bg" style="width:<?php echo $reviewAvg; ?>%"></div>
                                <div class="rate-stars"></div>
                            </div>  
                            <p><?php echo $review['feedback']; ?></p>
                            <p>by <?php echo $review['username']; ?></p>
                        </div>
                    <?php }?>

        </section>
        <!-- Related items section-->
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Fancy Product</h5>
                                    <!-- Product price-->
                                    $40.00 - $80.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Special Item</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$20.00</span>
                                    $18.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Sale Item</h5>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$50.00</span>
                                    $25.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Popular Item</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    $40.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
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
        <script>
            if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
        </script>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
