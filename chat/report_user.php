<?php
require_once("ajax_header.php");
 
if (isLoggedIn()) {

  $user_id = $_POST['my_user_id'];
  $other_user_id = $_POST['other_user_id'];  
  if (!trim($_POST['additional_comments']) == "") {
    $additional_comments = $_POST['additional_comments'];
  }
  else {
    $additional_comments = "User did not have additional comments.";
  }
  $sender_name = get_nickname($user_id);
  $reported_user = get_nickname($other_user_id);
  $message = $sender_name . ' user id: ' . $user_id .', is reporting ' . $reported_user . ' user id: ' . $other_user_id . '.  ' . $additional_comments;
  $data = array();

  if (sendReportUserEmail($sender_name, $reported_user, $message)) {
    $data['message'] = 'Your report has been sent.  We will contact you soon if we have any further questions.  Thank you for helping to keep our community safe for everyone.';
    $data['success'] = true;
    $data['sender'] = $sender_name;
    $data['reported'] = $reported_user;
  }
  else {
    $data['message'] = 'There was an error reporting this user.  Please try again later or <a href="mailto:contact@starma.com">contact</a> Starma directly.';
    $data['errors'] = true;
  }

  //$data['errors'] = true;
  //$data['message'] = sendReportUserEmail($sender_name, $reported_user, $message);

  
  //$data['success'] = true;
  //$data['message'] = $message;
  echo json_encode($data);
}
 
?>