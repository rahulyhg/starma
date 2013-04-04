<?php
function my_next_chat_order() {
  if (isLoggedIn()) {
    $q = "SELECT max(order_by) as my_max_order from chat_status where user_id_A = " . get_my_user_id();
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    if ($row = mysql_fetch_array($result)) {
      return $row["my_max_order"];
    }
    else {
      return 0;
    }
     
  }
  else {
    return 0;
  }
}

function reorder_my_chats($order_by) {
  if (isLoggedIn()) {
    $q = "SELECT chat_status_id, order_by from chat_status where user_id_A = " . get_my_user_id() . " and order_by > " . $order_by;
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    while ($row = mysql_fetch_array($result)) {
      $q2 = "UPDATE chat_status set order_by = " . ($row['order_by'] - 1) . " where chat_status_id = " . $row['chat_status_id'];
    
      $result2 = mysql_query($q2) or die(mysql_error());
    
    }
    return true;
     
  }
  else {
    return false;
  }
}
 
function insert_msg_line ($sender_id, $receiver_id, $date_time, $message, $sender_has_seen=0, $receiver_has_seen=0) {
  if (isLoggedIn()) {
    $q = sprintf ("INSERT INTO msg_line (sender_id, receiver_id, date_time, text_body, sender_has_seen, receiver_has_seen) VALUES (%d,%d,'%s','%s',%d,%d)", $sender_id, $receiver_id, $date_time, mysql_real_escape_string($message), $sender_has_seen, $receiver_has_seen);
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
}



function chat_status ($user_id_1, $user_id_2) {
  if (isLoggedIn()) {
    $q = "SELECT * from chat_status where (user_id_A = " . $user_id_1 . " and user_id_B = " . $user_id_2 . ")";
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    if ($row = mysql_fetch_array($result)) {
      return $row;
    }
    else {
      return false;
    }
     
  }
  else {
    return false;
  }
}

function insert_chat_status ($user_id_1, $user_id_2, $chatting) {
  if (isLoggedIn()) {
    $q = sprintf ("INSERT INTO chat_status (user_id_A, user_id_B, chatting) VALUES (%d,%d,%d)", $user_id_1, $user_id_2, $chatting);
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
}

function update_chat_status ($chat_status_id, $chatting, $order) {
  if (isLoggedIn()) {
    $q = sprintf ("UPDATE chat_status set chatting = %d, order_by = %d where chat_status_id = %d", $chatting, $order, $chat_status_id);
    //echo $q; die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
}

function isChatting ($partner_id) {
  
                 if ($chat_status_result = chat_status(get_my_user_id(), $partner_id)) {
         
        	   $chat_status = ($chat_status_result["chatting"] == 1);
              	 
        	 }
        	 else{
                   $chat_status = false;
                         
        	 }
        	 return $chat_status;
}
?>
