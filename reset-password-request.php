<!-- <?php
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
    
    // $selector = bin2hex(random_bytes(8));
    // $token = random_bytes(32);

    $email = $_POST["email"];
    //$url = "http://localhost/Beetriv/create-new-password.php?email=" . $email;
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                               //Enable verbose debug output
        $mail->isSMTP();                                    //Send using SMTP
        $mail->Host       = 'mail.beetriv.com';             //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                           //Enable SMTP authentication
        $mail->Username   = 'admin@beetriv.com';            //SMTP username
        $mail->Password   = '4bx~~ZJ8HJyq';                 //SMTP password
        $mail->SMTPSecure = 'ssl';                          //Enable implicit SSL encryption
        $mail->Port       = '290';                          //TCP port to connect to 290 as provided 
        

        //Recipients
        $mail->setFrom('admin@beetriv.com','Admin Beetriv');
        $mail->addAddress($email);                              //Add a recipient 
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the Link to reset password';
        $mail->Body    = 'This link is to reset your password on Beetriv website <a href="http://localhost/Beetriv/create-new-password.php">Click here to reset your password</a>' . $email;
        
        
        global $dir;
        $data=getData('users',$email);
        $link=getDataby('email', 'password', $email['email']);
        $body='SOME TEXT <p>YOU CAN USE HTML TAG TO <a href="'.$dir.'login/changepassword?SESSION_ID='.$link['link'].'&&SESSION_VALID='.md5(rand(0,100)).'">LINK TO CLICK</a><p>END OF HTML TAG</p>';
        return $body;
        
        $mail->send();
        echo 'Message has been sent';
	header("Location: login.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}else{
    header("Location: login.php");
}
?>

 -->
