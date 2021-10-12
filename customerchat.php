<?php
session_start();
require_once "connection.php";
$email = $_SESSION['email'];

//set default time to sg, bn not available
date_default_timezone_set('Asia/Singapore');

if(isset($_SESSION['email'])){


    
    $text = $_POST['text'];

   //format for date and text
	$text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A").
    "</span> <b class='user-name'>".$_SESSION['email']."</b> ".
    stripslashes(htmlspecialchars($text))."<br></div>";
    file_put_contents("messagelog/log.html", $text_message, FILE_APPEND | LOCK_EX);
    
}
?>

           
