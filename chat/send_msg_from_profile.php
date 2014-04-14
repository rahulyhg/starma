<?php
    //require_once ("/include/functions.inc.php"); 
    //require_once ("../PHPMailer_5.2.1/class.phpmailer.php");
    //date_default_timezone_set('America/Chicago');
//require_once ("header.php");
//header("Content-type: application/json");
//if I comment out the header I get 'falure: [object Object]' and msg doesn't send
//with header and login I get 'failure: undefined' msg sends
//with header but no login I get 'falure: [object Object]' and msg sends

//$data['message'] = "Hello";
    //require_once ('../include/db_connect.inc.php'); 
    //require_once ("../PHPMailer_5.2.1/class.phpmailer.php");   
session_start();
    require_once ('../include/db_connect.inc.php'); 
    require_once ("../include/functions.inc.php"); 
    require_once ("../PHPMailer_5.2.1/class.phpmailer.php");
    date_default_timezone_set('America/Chicago');
 
$logged_in = login_check_point($type="full");
//***********---Matt adding in case message is sent from Message button popup
  

    if (trim($_POST["text_body"]) != "") {
      $msg = true;
      //log_this_action (profile_action_biography(), editted_basic_action());
      if (isset($_POST["other_user_id"])) {
        $user_ids = array ($_POST["other_user_id"]);
      }
      //elseif (isset($_POST["as_values_fav_user_id"])) {
      //  $user_ids = explode(',', substr($_POST["as_values_fav_user_id"], 0, -1));
        //print_r ($user_ids);
        //die();
      //}
 
      foreach ($user_ids as $other_user_id) {
        //echo $other_user_id . '<br>';
        if (is_offline($other_user_id)) {
          $is_message = 1;
          /************---Matt had to take this out for local server---ADD WHEN LIVE!!
          if (get_preferences ($other_user_id, "chat_emails_flag", 1) == 1) {
          sendNewMessageEmail(get_my_user_id(), $other_user_id, $message);
          }**************/ 
        }

        insert_msg_line (get_my_user_id(), $other_user_id, date("Y-m-d H:i:s"), $_POST["text_body"], 1, 0, $is_message=1);
      }

    }
    else {
      $msg = false;
    }
    if($msg) {
      $json = 'Message Sent!';
    }
    else {
      $json = 'Empty';
    }
    //$print = json_encode($json, true);
echo json_encode($json, true);
//echo json_last_error();
//print_r($print);
?>