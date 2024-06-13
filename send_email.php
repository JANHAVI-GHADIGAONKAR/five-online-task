<?php
require 'vendor/autoload.php'; // Ensure this path is correct for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Access-Control-Allow-Origin: *");  // Allow cross-origin requests for debugging
header("Access-Control-Allow-Methods: POST");  // Allow POST requests
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars(nl2br($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';                  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                // Enable SMTP authentication
        $mail->Username   = 'janhavi.ghadi09@gmail.com';            // SMTP username
        $mail->Password   = 'mjnnjsgibdjltnso';                     // SMTP password
        $mail->SMTPSecure = 'tls';                    
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
        $mail->Port       = 587;                                 // TCP port to connect to

        //Recipients
        $mail->setFrom('janhavi.ghadi09@gmail.com', 'Contact Form');
        $mail->addAddress('janhavi.ghadi09@gmail.com');        // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission: ' . $subject;
        $mail->Body    = "<h3>Name: $name</h3><h3>Email: $email</h3><h3>Phone: $phone</h3><h3>Subject: $subject</h3><p>Message: $message</p>";
        $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage: $message";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(405);
    echo "405 Method Not Allowed";
}
?>
