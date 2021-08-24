<!-- <?php
session_start();
require 'connection.php';

$email = $_GET['email'];

$stmt =$pdo->prepare("SELECT * FROM REGISTRATION WHERE email=$email");
$stmt->execute();


$password = $_POST['pwd'];
$passwordRepeat = $_POST["pwd-repeat"];

// mysql_connect('localhost','root','');
// mysql_select_db('beetriv_test');



    //  $stmt = mysqli_stmt_init($conn);
    //  mysqli_stmt_execute($stmt);

    // if(isset($_POST["reset-new-password-sumbit"])){
    if(empty($password) || ($passwordRepeat)) {
            header("Location: create-new-password.php?pwd=empty");
              exit();
          } 
    else if($password != $passwordRepeat) {
             header("Location: create-new-password.php?pwd=pwdnotsame");
              exit();
          } 
    
        $sql=$conn->query("UPDATE registration set password='$password' WHERE email='$email'");
        // mysqli_query($dbconfig,"UPDATE REGISTRATION set password='$password' where email='$email'");
        // $sql =("UPDATE REGISTRATION SET password=$password WHERE email=$email");
        // $pdo->prepare($sql)->execute([$password, $email]);

// }else {
    header("Location: login.php");
    
// }

?> -->

