<?php
require 'class.mail.php';

$mail = new Mail();

unset($_SESSION['validation_errors']);

$validation_errors = array();
foreach ($_POST as $key => $value) {


	if (trim($_POST[$key]) != '' && ($key == "name") || ($key == "name")) {

		if (ctype_alpha(str_replace(' ', '', $_POST[$key])) === false) {

			$validation_errors[$key] = "Please provide name.";
		}
	}

    if (trim($_POST[$key]) != '' && ($key == "subject") || ($key == "subject")) {

		if (ctype_alpha(str_replace(' ', '', $_POST[$key])) === false) {

			$validation_errors[$key] = "Please provide subject.";
		}
	}


	if (trim($_POST[$key]) != '' && ($key == "email") || ($key == "email")) {

		if (!filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === true) {

			$validation_errors[$key] = "Please provide appropriate email id.";

		}
	}

	if (trim($_POST[$key]) != '' && ($key == "phone") || ($key == "phone")) {
		if (!preg_match('/^[0-9]{10}+$/', $_POST[$key]) === true) {
			$validation_errors[$key] = "Please provide appropriate 10 digits phone number.";

		}
	}

	if (trim($_POST[$key]) != '' && ($key == "message") || ($key == "message")) {

		if (ctype_alpha(str_replace(' ', '', $_POST[$key])) === false) {

			$validation_errors[$key] = "Please provide message.";
		}
	}

}

if(!empty($validation_errors)){
	// var_dump($validation_errors);
	http_response_code(422);
	echo json_encode($validation_errors);
	exit;
}

$_SESSION["fields"] = $_POST;

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$mailSent = $mail->sendContactMailToAdmin($name, $email, $phone, $subject, $message);

if ($mailSent) {
	$_SESSION['success'] = 1;
	echo json_encode(array('message' => 'Success'));
	exit;
} else {
	$_SESSION['success'] = 0;
	echo json_encode(array('message' => 'There was some error!'));
	exit;
}


?>