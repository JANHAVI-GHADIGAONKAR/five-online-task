
   
<?php

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/mail.config.php';

ini_set('display_errors', 'Off');
session_start();

class Mail
{
   
    public function sendContactMailToAdmin($name, $email, $phone, $subject, $message)
    {
        try {

            //Create a new PHPMailer instance
            $mail = new PHPMailer();
            // $mail->isSMTP();
            // $mail->Host = 'smtp.gmail.com';
            // $mail->SMTPAuth = true;
            // $mail->Port = 465;
            // $mail->Username = 'abdulsiddiquei.tg@gmail.com';
            // $mail->Password = 'sobeyeitnpivedvn';
            // $mail->SMTPSecure = $mail::ENCRYPTION_SMTPS;

            //Tell PHPMailer to use SMTP
            $mail->isSMTP();

            //Enable SMTP debugging
            // SMTP::DEBUG_OFF = off (for production use)
            // SMTP::DEBUG_CLIENT = client messages
            // SMTP::DEBUG_SERVER = client and server messages
            // $mail->SMTPDebug = 1;
            //Set the hostname of the mail server
            $mail->Host = MAIL_HOST;
            //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
            //if your network does not support SMTP over IPv6,
            //though this may cause issues with TLS

            //Set the SMTP port number:
            // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
            // - 587 for SMTP+STARTTLS
            $mail->Port = MAIL_PORT;

            //Set the encryption mechanism to use:
            // - SMTPS (implicit TLS on port 465) or
            // - STARTTLS (explicit TLS on port 587)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = MAIL_USER;

            //Password to use for SMTP authentication
            $mail->Password = MAIL_PASSWORD;

            //Set who the message is to be sent from
            //Note that with gmail you can only use your account address (same as `Username`)
            //or predefined aliases that you have configured within your account.
            //Do not use user-submitted addresses in here
            $mail->setFrom(MAIL_FROM_ID, MAIL_FROM_NAME);

            //Set an alternative reply-to address
            //This is a good place to put user-submitted addresses
            // $mail->addReplyTo('replyto@example.com', 'First Last');

            //Set who the message is to be sent to
            $mail->addAddress(MAIL_TO, ' ');

            //Set the subject line
            $mail->Subject = 'Contact from website - ' . $subject;

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $admin_message = str_replace(['[name]', '[email]', '[phone]', '[subject]', '[message]'],[$name, $email, $phone, $subject, $message],file_get_contents('contact-us-email-template.php'));
            $mail->Body = $admin_message;

            //Replace the plain text body with one created manually
            $mail->AltBody = $name . ' is trying to contact you.';

            

            //send the message, check for errors
            if (!$mail->send()) {
                // return 'Mailer Error: ' . $mail->ErrorInfo;
                var_dump($mail->ErrorInfo);exit;
            } else {
                return 'Message sent!';
                //Section 2: IMAP
                //Uncomment these to save your message in the 'Sent Mail' folder.
                #if (save_mail($mail)) {
                #    echo "Message saved!";
                #}
            }


        } catch (Exception $e) {
            var_dump($e->getMessage());exit;

            return false;
        } 
    }


}


//Section 2: IMAP 
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
// function save_mail($mail)
// {
//     //You can change 'Sent Mail' to any other folder or tag
//     $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

//     //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
//     $imapStream = imap_open($path, $mail->Username, $mail->Password);

//     $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
//     imap_close($imapStream);

//     return $result;
// }