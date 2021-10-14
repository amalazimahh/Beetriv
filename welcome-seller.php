<?php
ob_start();
session_start();
require_once "connection.php";

$email = $_SESSION['email'];

//notify when time expired
date_default_timezone_set('Asia/Brunei');
$time_register = date('Y-m-d H:i:s');

$updte = $conn->query("UPDATE users SET type='seller', seller_register='$time_register', seller_period='active' WHERE email='$email'");
header ('location: subscription.php');

?>