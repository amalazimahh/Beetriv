<?php
ob_start();
session_start();
require_once 'connection.php';
?>

<?php
//PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
?>


<?php
if(isset($_POST['reset-password-submit'])){
    require 'connection.php';

    $email = $_POST["email"];
    $url = "http://localhost/Beetriv/create-new-password.php?email=" . $email;

    $mail = new PHPMailer(true);

    try{


      //Enable debug output
      $mail->SMTPDebug = 0;

      //Send using SMTP
       $mail->isSMTP();

      //Set the SMTP server 
       $mail->Host = 'smtp.gmail.com';

       //Enable SMTP authentication
       $mail->SMTPAuth = true;

       //SMTP username
       $mail->Username = 'ayamketupat02@gmail.com';

       //SMTP password
       $mail->Password = 'k4k5dpkk';

       //SMTP username
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //SMTP PORT
         $mail->Port = 587;

        //Recipients
         $mail->setFrom('ayamketupat02@gmail.com','beetriv.com');

        //add recipient
         $mail->addAddress($email);

        //Set email format to HTML
         $mail->isHTML(true);



    $mail->Subject = "Reset your Password";

    $message = '<p> The link to reset your password is below.';

    $message .= 'Here is your password link: ';

    $message .=  $url ;


    $headers = "From: beetrive.com <yusnadi247@gmail.com> \r\n";

    $headers .= "Reply-to: yusnadi247@gmail.com\r\n";

    $headers .= "Content-type: text/html; \r\n";

    mail->send();
    
    header("Location: forgot-password.php?reset=success");


    header("Location: login.php");


    }catch(Exception $e){
        echo "Message cannot send, error mail: {mail->ErrorInfo}";
    }
}
