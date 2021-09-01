<?php
ob_start();
session_start();
require_once "connection.php";

    //fetch email entered by user on forgot-pwd.php 
    $email = $_SESSION['email'];
    //echo $email;

    if(isset($_POST['create-new-password'])){

        $newpwd = $_POST['newpwd'];
        $repeatpwd = $_POST['repeatpwd'];
                                        
        if ($newpwd === $repeatpwd){

        //select all from users based from the email user entered
        $check_code = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $run = $conn->prepare($check_code);
        $run->fetch(PDO::FETCH_ASSOC);
                                        
        if($run){
        
        //update user password based from the selection
        $pdoQuery = "UPDATE users SET password='$newpwd' WHERE email='$email' ";
        $pdoQuery_run = $conn->prepare($pdoQuery);
        // $pdoQuery_run->bindParam(':password', $newpwd);
        // $pdoQuery_run->bindParam(':email', $email);
        $pdoQuery_run->execute();
        header('location: login.php');
        exit();

        } else {
        echo 'Error';
        }
    }
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

    <title>Beetriv - Create New Password</title>

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
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Create New Password</h1>
                                    </div>
                                    <form action="create-new-password.php" method="post" class="user">

                                    <!-- Enter new password -->
                                        <div class="form-group">
                                            <input type="password" name="newpwd" class="form-control form-control-user"
                                                id="newpwd"
                                                placeholder="Enter New Password..." required/>

                                                <!-- repeat new password -->
                                                <div class="form-group">
                                                <input type="password" name="repeatpwd" class="form-control form-control-user"
                                                id="repeatpwd" 
                                                placeholder="Repeat New Password..." required/>
                                                <!-- <input type="disable" name='email' value="<?php echo ($_GET['resetcode']); ?>"> -->
                                    
                                        </div>
                                        
                                        <input type="submit" class="btn btn-secondary btn-user btn-block" name="create-new-password" value="Create New Password">

                                        <?php
                                        ?>
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