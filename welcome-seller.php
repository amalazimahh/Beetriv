<?php
ob_start();
session_start();
require_once "connection.php";

$email = $_SESSION['email'];


$updte = $conn->query("UPDATE users SET type='seller' WHERE email='$email'");
header ('location: subscription.php');

?>