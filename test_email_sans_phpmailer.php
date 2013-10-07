<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

$to = $_GET['to'];
$from = $_GET['from'];
$message = $_GET['message'];
$subject = $_GET['subject'];


if (testMailSansPHPMailer ($to, $subject, $message, $from)) {
  echo "Mail Sent";
}
else {
  echo "Mail Fail";
}
?> 
