<?php
require_once("ajax_header.php");
 
if (isLoggedIn()) {

  $user_id = $_POST['my_user_id'];
  $other_user_id = $_POST['other_user_id'];  
  $sender_name = get_nickname($user_id);
  $reported_user = get_nickname($other_user_id);
  $message = $sender_name . ' user id: ' . $user_id .', is reporting ' . $reported_user . ' user id: ' . $other_user_id . '.';

/*
  if (sendReportUserEmail($sender_name, $reported_user, $message)) {
    $data = 'Your report has been sent.';
    $data['success'] = true;
  }
  else {
    $data = 'There was an error when reporting this user.  Please try again later or contact Starma directly.';
    $data['errors'] = true;
  }
*/
  $data = array();
  $data['success'] = true;
  $data['message'] = $message;
  echo json_encode($data);
}
 
?>