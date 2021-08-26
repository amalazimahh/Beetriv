<?php
ob_start();
session_start();
require_once "connection.php";

    // $resetcode = $_SESSION['resetcode'];
    //$email = $_SESSION['email'];

    //$result = $conn->query("SELECT * FROM users WHERE resetcode = '$resetcode' ");
    //$row = $result->fetch(PDO::FETCH_ASSOC);

    // if(isset($_POST['create-new-password'])){

    //     $newpwd = $_POST['newpwd'];
    //     $repeatpwd = $_POST['repeatpwd'];

    //     // $pdoQuery = "UPDATE users SET password = '$newpwd' WHERE resetcode = '$resetcode' ";
    //     // $pdoQuery_run = $conn->prepare($pdoQuery);
    //     // $pdoQuery_run->execute();

    //     if ($newpwd === $repeatpwd){

    //         $check_code = "SELECT * FROM users WHERE resetcode = '$resetcode' LIMIT 1";
    //         $run = $conn->prepare($check_code);
    //         $run->fetch(PDO::FETCH_ASSOC);

    //         $emailTo = $_SESSION['emailTo'];
    //         $id = $_SESSION['user_id'];

    //         if($run){

    //             $pdoQuery = "UPDATE users SET password='$newpwd' WHERE user_id='$id' AND resetcode='$resetcode' ";
    //             $pdoQuery_run = $conn->prepare($pdoQuery);
    //             $pdoQuery_run->bindParam(':password', $newpwd);
    //             $pdoQuery_run->bindParam(':resetcode', $resetcode);
    //             $pdoQuery_run->execute();
    //             header('location: login.php');
    //             exit();

                // try
                // {
                //     $pdoQuery_run = $conn->prepare($pdoQuery);
                //     $pdoQuery_run->bindParam(':password', $newpwd);
                //     $pdoQuery_run->bindParam(':resetcode', $resetcode);
                //     $pdoQuery_run->execute();
                //     header('location: login.php');
                //     exit();
    
                //     // if($pdoQuery_exec){
                //     //     header('location: login.php');
                //     //     exit();
                //     // }
                //     // else {
                //     //     echo "Password does not update successfully.";
                //     // }
                // }
                // catch(PDOException $e){
                //     echo $e->getMessage();
                // }
    //         } else {
    //             echo 'Error';
    //         }
    //     }
    // }



        // if (!isset($_SESSION['resetcode'])){
        //     exit("Ooops! Looks like you are not a registered member. Please complete registration process.");
        // } 
        // else{
        //     // $newpwd = $_POST['newpwd'];
        //     // $repeatpwd = $_POST['repeatpwd'];
        //     //$email = $_POST['email'];  

        //     if ($newpwd == $repeatpwd){

        //         // $update_pwd = "UPDATE users SET password = '$newpwd' WHERE resetcode = '$resetcode' ";
        //         // $stmt = $conn->prepare($update_pwd);
        //         // $stmt->execute(array(
        //         //         ':password' => $newpwd,
        //         //         ':resetcode' => $resetcode
        //         // )); 

        //         $select = $conn->prepare("SELECT password FROM users WHERE resetcode = '$resetcode'");
        //         $select->bindParam(':resetcode', $resetcode);
        //         $select->execute();

        //         $count = $select->rowCount();

        //             if($select > 0){
        //                 $update_pwd = "UPDATE users SET password = '$newpwd' WHERE resetcode = '$resetcode' ";
        //                 $stmt = $conn->prepare($update_pwd);
        //                 $stmt->execute();
        //                 header('location: login.php');
        //                 exit();
        //             }
        //         } 
        //         else{
        //             echo '<script>alert("Password does not match")</script>';
        //         }
        // }
    
    
        //$getEmail = "SELECT email FROM users where resetcode = '$resetcode' ";                     
        // $statement = $conn->prepare($getEmail);
        // $statement->execute();
        //$params = [':email' => $email,':resetcode' => $resetcode];
        //$params = [':email' => $email,];
        //$statement->execute($params);
    
        //$sql = $conn->query ("UPDATE users SET password='$newpassword' WHERE email = '$email");

        // if(!$sql) {
        //     exit("Error");
        // }
    
        // $conn= null;
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

<body class="bg-gradient-primary">

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
                                        
                                        <input type="submit" class="btn btn-primary btn-user btn-block" name="create-new-password" value="Create New Password">\

                                        <?php
                                            $resetcode = $_SESSION['resetcode']; 

                                            if(isset($_POST['create-new-password'])){

                                                $newpwd = $_POST['newpwd'];
                                                $repeatpwd = $_POST['repeatpwd'];
                                        
                                                // $pdoQuery = "UPDATE users SET password = '$newpwd' WHERE resetcode = '$resetcode' ";
                                                // $pdoQuery_run = $conn->prepare($pdoQuery);
                                                // $pdoQuery_run->execute();
                                        
                                                if ($newpwd === $repeatpwd){
                                        
                                                    $check_code = "SELECT * FROM users WHERE resetcode = '$resetcode' LIMIT 1";
                                                    $run = $conn->prepare($check_code);
                                                    $run->fetch(PDO::FETCH_ASSOC);
                                        
                                                    $emailTo = $_SESSION['emailTo'];
                                                    $id = $_SESSION['user_id'];
                                        
                                                    if($run){
                                        
                                                        $pdoQuery = "UPDATE users SET password='$newpwd' WHERE user_id='$id' AND resetcode='$resetcode' ";
                                                        $pdoQuery_run = $conn->prepare($pdoQuery);
                                                        $pdoQuery_run->bindParam(':password', $newpwd);
                                                        $pdoQuery_run->bindParam(':resetcode', $resetcode);
                                                        $pdoQuery_run->execute();
                                                        header('location: login.php');
                                                        exit();

                                                    } else {
                                                        echo 'Error';
                                                    }
                                                }
                                            }
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
    <?php
    // if (!isset($_GET['resetcode'])){
//     exit("Page not found");
// }






// // if ($getEmail->rowCount()) {
// //     exit("Cant find page");
// // }

// if(isset($_POST["create-new-password"])){
//     $newpassword = $_POST["pwd"];
//     $newpasswordr = $_POST['pwd-repeat'];

//     $getEmail ="SELECT email FROM resetpassword WHERE resetcode = :resetcode LIMIT 1";
//     //$row = $getEmail->fetch();
//     $email = $row["email"];

//     $sql=$conn->query("UPDATE users SET password='$_POST[pwd]' WHERE email = '{$_SESSION['email']}'");

//     if ($newpassword == $newpasswordr){
//             header('location: login.php');
//             echo '<script>alert("Password Updated")</script>';
//             } else{
//                 echo '<script>alert("Password does not match")</script>';
//             }
//         }                
                    // if(isset($_POST['create-new-password'])){
                    //     $newpassword = $_POST['pwd'] ?? "";
                    //     $newpasswordr = $_POST['pwd-repeat'] ?? "";
                    //     $email = $_POST['email'] ;
                    //     $sql = "SELECT * FROM users WHERE email = :email";

                    //     $params = [':email' => $email];
                    //     $statement = $conn->prepare($sql);
                    //     $params = [':email' => $email,];
                    //     $statement->execute($params);

                    //     $sql=$conn->query("UPDATE users SET password='$_POST[pwd]' WHERE email = '{$_SESSION['email']}'");

                    //     if ($newpassword == $newpasswordr){
                    //     header('location: login.php');
                    //     } else{
                    //         echo '<script>alert("Password does not match")</script>';
                    //     }
                    // }
                    //     $conn= null;

                    
                     
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