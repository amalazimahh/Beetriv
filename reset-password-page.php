<?php
require 'connection.php';

$email = $_GET['email'];

$select ="SELECT * FROM REGISTRATION WHERE email=$email";
    //  $stmt = mysqli_stmt_init($conn);
    //  mysqli_stmt_execute($stmt);

if(isset($_POST["reset-new-password-sumbit"])){

    $password = $_POST['pwd'];
    $passwordRepeat = $_POST["pwd-repeat"];

    if(empty($password) || ($passwordRepeat)) {
        header("Location: create-new-password.php?pwd=empty");
        exit();
    } else if($password != $passwordRepeat) {
        header("Location: create-new-password.php?pwd=pwdnotsame");
        exit();
    } 


     $sql ="UPDATE REGISTRATION SET password=$password WHERE email=$email";
     $stmt = mysqli_stmt_init($conn);
     mysqli_stmt_execute($stmt);
    
        //add excute statement

}else {
    header("Location: login.php");
    
}

?>

