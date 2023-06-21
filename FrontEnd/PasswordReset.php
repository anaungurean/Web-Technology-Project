<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'path/to/PHPMailer/Exception.php';
// require 'path/to/PHPMailer/PHPMailer.php';
// require 'path/to/PHPMailer/SMTP.php';

require '../vendor/autoload.php';


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email address from the form
    $email = $_POST["email"];

    // Validate the email address (you can add additional validation if needed)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Generate a random password reset token
    $token = bin2hex(random_bytes(32));

    // TODO: Save the token and associated email address in the database
    // This step may involve updating your database schema and implementing the necessary database queries.

    // Send the password reset email
    $smtp_host = "smtp.gmail.com";
    $smtp_port = 587;
    $smtp_username = "ascorencele@gmail.com";  
    $smtp_password = "ubyuocoynaptsgqn";  
    $smtp_secure = 'tls';
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->Port = $smtp_port;
        $mail->SMTPSecure = $smtp_secure;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;

        // Recipient
        $mail->setFrom('ascorencele@gmail.com');
        $mail->addAddress($email);

        // Email content
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
