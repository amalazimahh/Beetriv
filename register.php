<?php
ob_start();
session_start();
require_once "connection.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Beetriv - Sign Up</title>

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
                                <h1 class="h4 text-gray-900 mb-4">Sign Up to Beetriv</h1>
                            </div>
                            <form class="user" method="POST">
                            <div class="form-group">
                                <!-- Email -->
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email"
                                        placeholder="Email Address" required/>
                                </div>
                                <div class="form-group">
                                <!-- Username -->
                                    <input type="text" class="form-control form-control-user" id="username" name="username" pattern="[a-zA-Z]{1,}"
                                        placeholder="Username" required/>
                                </div>
                                <!-- IC Number -->
                                <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="ic" name="ic" 
                                        placeholder="IC Number" required/> 
                                </div>
                                <!-- IC Colour -->
                                <div class="col-sm-6 " >
                                        <input type="text" class="form-control form-control-user" name="ic2" list="ic2"
                                             placeholder="IC Colour" required/>
                                            <datalist id="ic2">
                                                <option value = "Yellow">
                                                <option value = "Purple">
                                                <option value = "Green">
                                            </datalist>
                                    </div>
                                    </div>
                                <!-- Phone number -->
                                <div class="form-group">
                                    <input type="tel" class="form-control form-control-user" id="phone" name="phone" 
                                    placeholder= "Phone Number" required/>
                                </div>
                                <!-- Create Password -->
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" pattern=".{8,25}" title="Required atleast 8 to 25 characters"
                                    placeholder= "Create Password" required/>
                                </div>
                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="rpassword" name="rpassword" 
                                    placeholder= "Confirm Password" required/>
                                </div>
                                <div class="form-group">
                                <!-- Register Account -->
                                <input type="submit" class="btn btn-primary btn-user btn-block" name="submit" value="Register Account">
                                   
                                
                                <!-- <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a> -->
                            </form>
                            <hr>
                            <!-- <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div> -->
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <?php
        //select from which database table
        $select = "SELECT * FROM USER WHERE 1";

        //variable to be insert into database
        if(isset($_POST['submit'])){
            $email           = ($_POST['email']);
            $username        = ($_POST['username']);
            $ic              = ($_POST['ic']);
            $ic2             = ($_POST['ic2']);
            $phone           = ($_POST['phone']);
            $password        = ($_POST['password']);
            $rpassword       = ($_POST['rpassword']);
            
            $sql = $conn->query ("INSERT INTO user (Email, Username, Ic_no, Ic_color, Phone_Number, Password) VALUES ('$email','$username','$ic','$ic2','$phone','$password')");

            
            
    }
    
?>

<?php

if(isset($_POST['submit'])){

     $email = $_POST["email"];
    // $url = "http:localhost/Beetriv/create-new-password.php?email=" . $email;

     $to = $email;

     $subject = "Verification Code";

     $vcode=substr(str_shuffle("0123456789"), 0, 4);
     //$vcode=substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 4);

     $message = '<p> Verification code is' . $vcode;

    // $message .= 'Here is your password link: ';

    // $message .=  $url ;


     $headers = "From: beetriv.com <haziqzulhazmi@gmail.com> \r\n";

     $headers .= "Reply-to: haziqzulhazmi@gmail.com\r\n";

     $headers .= "Content-type: text/html; \r\n";

    mail($to, $subject, $message, $headers);
    
    


    if ($password == $rpassword){
        header("location: emailverification.php");
    exit;
    }else{
        echo '<script>alert("Password does not match")</script>';
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