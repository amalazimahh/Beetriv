<?php
ob_start();
session_start();
require_once 'connection.php';
?>

<?php
//PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
?>


<?php

if(isset($_POST['reset-password-submit'])){
    
        $emailTo = $_POST['email'];
    
        $resetcode = uniqid(true);                                 // generate a unique 
        // $insert_code = 'INSERT INTO users resetcode VALUES :resetcode';
        // $insertStmt = $conn->prepare($insert_code);
        // $insertStmt->execute();

        $update_code = "UPDATE users SET resetcode = '$resetcode' where email = '$emailTo' ";
        $statement = $conn->prepare($update_code);
        $statement->execute();

        $check_email = "SELECT * FROM users WHERE email = '$emailTo' ";
        $run = $conn->prepare($check_email);
        $run->execute(); 
        
        $count = $run->rowCount();

        if($count > 0){
            $update_code = "UPDATE users SET resetcode = '$resetcode' where email = '$emailTo' ";
            $statement = $conn->prepare($update_code);
            $statement->execute();
        } else {
            echo "Failed";
        }
        // if(!$sql) {
        //     exit("Error");
        // }
    
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
            $mail->addAddress("$emailTo");                                             //Add a recipient 
        
            //Content
            $url = "http://" . $_SERVER ["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/create-new-password.php?email=$emailTo"; //array containing info such as headers,paths and script locations, to create the link for specific email
            $mail->isHTML(true);                                                       //Set email format to  HTML
            $mail->Subject = 'Reset your password';
            $mail->Body    = "Need to reset your password? No problem ! Just click the link below and you are set to create new password for your account. <br>
                             <a href='$url'>Click on this link to reset your password</a>";
            
            
            $mail->send();
            echo '<script>alert("Reset Password link sent to your email")</script>';

        // header("Location: login.php");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    
        exit();
    //}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Beetriv - Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-warning">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="form-group">
                                        <!-- <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1> -->
                                        <p class="mb-4">Please enter your email address below and an email will be sent to reset your password.</p>
                                    </div>
                                    <form method="post" action="forgot-password.php" class="user">
                                            <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                                
                                                </div>
                                                
                                        
                                        <!-- Submit button -->
                                        <input type="submit" class="btn btn-secondary btn-user btn-block" name="reset-password-submit" value="SEND">
                                        </form>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>