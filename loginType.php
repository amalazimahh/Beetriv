<?php
ob_start();
session_start();
$email = $_SESSION['email'];
require_once "connection.php";

$result1 = $conn->query("SELECT * FROM users WHERE email='$email'");
$row1 = $result1->fetch(PDO::FETCH_ASSOC);
$type = $row1['type'];

if(($type) == 'seller'){
    header('location: seller-dashboard.php');
}
else if(($type) == 'runner'){
    header('location: runner-order.php');
}
else if(($type) == 'customer'){
    header('location: store.php');
}
else{
    echo '<script>alert("Unexpected error")</script>';
}

?>