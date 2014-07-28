<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

$to = "josh@mycer.com"; 
$from = "contact@starma.com"; 
$message = "Yah it worked! Mandrill worked!";
$subject = "Wu Tang";
$footer = "Footer Goes Here";


if (testSendingMail ($to, $subject, $message, $from, $footer)) {
  echo "Mail Sent";
}
else {
  echo "Mail Fail";
}
?> 
