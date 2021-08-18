<?php
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Beetriv - Email Verification</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome to Beetriv!</h1>
                            </div>

                            <div class="text-center">
                                <p class="h4 text-gray-900 mb-4">A 4-digit verification code has been sent to your email for verification. Enter the code below:</p>
                            </div>

                            <form class="user">
                                <div class="form-group row">
                                    
                                </div>
                                
                                <div class="text-center">
                                        <input type="text" class="form-control form-control-user" id="vcode" placeholder="Verification Code" >
                                    </div>
                                
                                <div class="form-group row">
                                    
                                    
                                </div>
                                <input type="submit" class="btn btn-primary btn-user btn-block" name="verify" value="Verify Email">
                                <hr>
                                
                                <div class="text-center">
                                <a class="small" href="forgot-password.html">Didn't work? Send me another code.</a>
                            </div>
                            </form>
                            <hr>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
            $msg = '';
            
            if (isset($_POST['verify']) && !empty($_POST['vcode'])) {
				
               if ($_POST['vcode'] == $vcode)  {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['vcode'] = $vcode;
                  
                  header("location: login.php");
            exit;
               }else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>