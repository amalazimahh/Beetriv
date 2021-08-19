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

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                   //Enable verbose debug output
        $mail->isSMTP();                                        //Send using SMTP
        $mail->Host       = "smtp.gmail.com";                   //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                               //Enable SMTP authentication
        $mail->Username   = 'ayamketupat02@gmail.com';          //SMTP username
        $mail->Password   = 'k4k5dpkk';                         //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     //Enable implicit TLS encryption
        $mail->Port       = 587;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('ayamketupat02@gmail.com', 'beetriv.com');
        $mail->addAddress($email);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the Link to reset password';
        $mail->Body    = 'This is your link to reset your password on beetriv website <b>Click the link to reset your password</b>' . $url;
        
    
        $mail->send();
        echo 'Message has been sent';
	header("Location: login.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}else{
    header("Location: login.php");
}