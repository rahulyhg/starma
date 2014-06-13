<?php
require_once("ajax_header.php");
 
if (isLoggedIn()) {

  $user_id = $_POST['my_user_id'];
  $other_user_id = $_POST['other_user_id'];  
  $sender_name = get_nickname($user_id);
  $reported_user = get_nickname($other_user_id);
  $message = $sender_name . ' is reporting ' . $reported_user . '.';

/*
  if (sendReportUserEmail($sender_name, $reported_user, $message)) {
    $data = 'User has been reported.';
  }
  else {
    $data = 'There was an error when reporting this user.  Please try again later.';
  }
*/
  $data = $message;
  echo json_encode($data);
}
 
?>