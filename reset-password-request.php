<?php

if(isset($_POST['reset-password-submit'])){

    $email = $_POST["email"];
    $url = "http://localhost/Beetriv/create-new-password.php?email=" . $email;

    require 'connection.php';


    $to = $email;

    $subject = "Reset your Password";

    $message = '<p> The link to reset your password is below.';

    $message .= 'Here is your password link: ';

    $message .=  $url ;


    $headers = "From: beetrive.com <yusnadi247@gmail.com> \r\n";

    $headers .= "Reply-to: yusnadi247@gmail.com\r\n";

    $headers .= "Content-type: text/html; \r\n";

    mail($to, $subject, $message, $headers);

    header("Location: forgot-password.php?reset=success");


}else {
    header("Location: login.php");
}
