<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);
//***********---Matt adding in case message is sent from Message button popup
  
  $chart_id1 = $_POST["chart_id1"];
  $chart_id2 = $_POST["chart_id2"];

  if (isset($_POST["submit"])) {
    if (trim($_POST["text_body"]) != "") {
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
    
      //echo $chart_id1 . "  " . $chart_id2;

    //die();
    do_redirect( $url = get_domain() . 'main.php?the_page=cosel&the_left=nav1&tier=3&stage=2&chart_id1=' . $chart_id1 . '&chart_id2=' . $chart_id2);
    }
    else {
      do_redirect( $url = get_domain() . 'main.php?the_page=cosel&the_left=nav1&tier=3&stage=2&chart_id1=' . $chart_id1 . '&chart_id2=' . $chart_id2);
    }
  }

  ?>