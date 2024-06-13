<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars(nl2br($_POST['message']));

    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'janhavi.ghadi09@gmail.com';
    $mail->Password   = 'mjnnjsgibdjltnso';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Email settings
    $mail->setFrom('janhavi.ghadi09@gmail.com', 'Contact Form');
    $mail->addAddress('janhavi.ghadi09@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission: ' . $subject;
    $mail->Body    = "<h3>Name: $name</h3><h3>Email: $email</h3><h3>Phone: $phone</h3><h3>Subject: $subject</h3><p>Message: $message</p>";
    $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage: $message";

    // Send email
    if ($mail->send()) {
        // Email sent successfully
        echo '<script>alert("Message has been sent");</script>';
    } else {
        // Email sending failed
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    }
} else {
    http_response_code(405);
    echo "405 Method Not Allowed";
}
?>
