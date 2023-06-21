<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];


    $to = "ascorencele@gmail.com";

    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $email_subject = "New Contact Form Submission: $subject";
    $email_body = "<h3>You have received a new contact form submission:</h3>";
    $email_body .= "<p><strong>Name:</strong> $name</p>";
    $email_body .= "<p><strong>Email:</strong> $email</p>";
    $email_body .= "<p><strong>Subject:</strong> $subject</p>";
    $email_body .= "<p><strong>Message:</strong> $message</p>";

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

        $mail->setFrom($email, $name);
        $mail->addAddress($to);
        $mail->Subject = $email_subject;
        $mail->Body = $email_body;
        $mail->isHTML(true);

        $mail->send();
        // echo "Thank you! Your message has been sent.";
    } catch (Exception $e) {
        // echo "Sorry, there was an error sending your message. Please try again later.";
        // echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
