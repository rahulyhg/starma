<?php
require_once("ajax_header.php");
 
$logged_in = login_check_point($type="full");
//***********---Matt adding in case message is sent from Message button popup
  

    if (trim($_POST["text_body"]) !== "") {
      $msg = true;
      //log_this_action (profile_action_biography(), editted_basic_action());
      if (isset($_POST["other_user_id"])) {
        $user_ids = array ($_POST["other_user_id"]);
      }
      elseif (isset($_POST["as_values_fav_user_id"])) {
        $user_ids = explode(',', substr($_POST["as_values_fav_user_id"], 0, -1));
        //print_r ($user_ids);
        //die();
      }
 
      foreach ($user_ids as $other_user_id) {
        //echo $other_user_id . '<br>';
        if (is_offline($other_user_id)) {
          $is_message = 1;
          
          if (get_preferences ($other_user_id, "chat_emails_flag", 1) == 1) {
            sendNewMessageEmail(get_my_user_id(), $other_user_id, $message);
          }
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
echo json_encode($json);
//echo json_last_error();
//print_r($print);
?>