<?php
require 'vendor/autoload.php'; // Path to PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars(nl2br($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                         // Send using SMTP
        $mail->Host       = 'smtp.example.com';                  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                // Enable SMTP authentication
        $mail->Username   = 'janhavi.ghadi09@gmail.com';            // SMTP username
        $mail->Password   = 'mjnn jsgi bdjl tnso';                     // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
        $mail->Port       = 587;                                 // TCP port to connect to

        //Recipients
        $mail->setFrom('janhavi.ghadi09@gmail.com', 'Contact Form');
        $mail->addAddress('janhavi.ghadi09@gmail.com');        // Add a recipient

        // Content
        $mail->isHTML(true);                                     // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "<h3>Name: $name</h3><h3>Email: $email</h3><p>Message: $message</p>";
        $mail->AltBody = "Name: $name\nEmail: $email\nMessage: $message";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
