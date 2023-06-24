<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $email = $_POST["email"];

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    $token = bin2hex(random_bytes(32));

    $smtp_host = "smtp.gmail.com";
    $smtp_port = 587;
    $smtp_username = "ascorencele@gmail.com";  
    $smtp_password = "ubyuocoynaptsgqn";  
    $smtp_secure = 'tls';
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->Port = $smtp_port;
        $mail->SMTPSecure = $smtp_secure;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;

        $mail->setFrom('ascorencele@gmail.com');
        $mail->addAddress($email);

        $mail->Subject = 'Password Reset';
        $mail->Body    = "Click the link below to reset your password:\n\n";
        $mail->Body   .= "http://localhost/TW/FrontEnd/HTML_Pages/ResetPassword.html?";

        $mail->send();

        echo "Password reset email sent to: " . $email;
    } catch (Exception $e) {
        echo "Error sending email: " . $mail->ErrorInfo;
    }
} else {
    
    exit;
}
?>
