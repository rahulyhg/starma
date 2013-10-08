<?php
    session_start();
    require_once ('../include/db_connect.inc.php'); 
    require_once ("../include/functions.inc.php"); 
    require_once ("PHPMailer_5.2.1/class.phpmailer.php");
    date_default_timezone_set('America/Chicago');
    //fwrite(fopen('debug.txt', 'a'), 'Begin Process..\r\n');
    //echo '*'. get_my_nickname() . '*';
    //print_r ($_SESSION);
    //die();
    $function = $_GET['function'];
    
    $log = array();
    
    switch($function) {
         case('run_zip'):
                 $zip = $_GET['zip'];
                 if (!$log = geocode($zip . ' US', 'postalCodeSearch?placename')) {
                    $log['title'] = ""; 
                 }
                 break;
         case('set_pref'):
                 $pref = $_GET['pref'];
                 $pref_name = $_GET['pref_name'];
                 if ($pref == "true") {
                   $pref = 1;
                 }
                 elseif ($pref == "false") {
                   $pref = 0;
                 }
                 $_SESSION[$pref_name] = 0;
                 set_my_preference ($pref_name, $pref);
                 break;
         case('search_favs'):
                 $filter = $_GET['q'];
                 $included_users = get_filtered_user_list_no_celeb ($filter, $type="include", $_GET["limit"]); // THIS WILL CHANGE TO THE FAV ONLY QUERY EVENTUALLY
                 while ($row = mysql_fetch_array($included_users)) {
                   $json = array();
                   $json['value'] = $row['user_id'];
                   $json['name'] = $row['nickname'];
                   $log[] = $json;
                   //header("Content-type: application/json");
                 }
                 break;
         case('filterAllUsers'):
                 $filter = $_GET['filter'];
                 $included_users = get_filtered_user_list_no_celeb ($filter, "include", 100);
                 $excluded_users = get_filtered_user_list_no_celeb ($filter, "exclude", 100);
                 while ($row = mysql_fetch_array($included_users)) {
                   $log["users_in"][] = $row["user_id"]; 
                 }
                 while ($row = mysql_fetch_array($excluded_users)) {
                   $log["users_out"][] = $row["user_id"]; 
                 }
                 break;
        
         case('filterUsers'):
                 $filter = $_GET['filter'];
                 $included_users = get_filtered_user_list ($filter, "include");
                 $excluded_users = get_filtered_user_list ($filter, "exclude");
                 while ($row = mysql_fetch_array($included_users)) {
                   $log["users_in"][] = $row["user_id"]; 
                 }
                 while ($row = mysql_fetch_array($excluded_users)) {
                   $log["users_out"][] = $row["user_id"]; 
                 }
                 break;
         case('filterCelebs'):
                 $filter = $_GET['filter'];
                 $included_users = get_filtered_celebrity_user_list ($filter, "include");
                 $excluded_users = get_filtered_celebrity_user_list ($filter, "exclude");
                 while ($row = mysql_fetch_array($included_users)) {
                   $log["users_in"][] = $row["user_id"]; 
                 }
                 while ($row = mysql_fetch_array($excluded_users)) {
                   $log["users_out"][] = $row["user_id"]; 
                 }
                 break;
         case('setTimeZone'):
                 $_SESSION["timezoneOffset"] = $_GET["timezoneOffset"];
                 $log[] = $_SESSION["timezoneOffset"];
                 break;
         case('refreshChat'):
        	
                 $text = array();
                 $my_chattings = get_my_chat_status();
        	 while ($chat_status = mysql_fetch_array($my_chattings)) { 
                    $text[] = $chat_status;    
                 }
                 
        	 $log['text'] = $text;
                 break;
         case('getChat'):
        	
                
        	 
                 $chat_status = $chat_status = chat_status(get_my_user_id(), $_GET["partner_id"]);
        	 $log['text'] = $chat_status["chatting"];
                 break;
        	 
         case('setChat'):
        	
                
        	 
                 if ($chat_status = chat_status(get_my_user_id(), $_GET["partner_id"])) {
                   //echo '*' . $chat_status["chat_status_id"] . '*';
                   //if wasnt chatting before, but is now chatting
                   $order = $chat_status["order_by"];
                   if ($chat_status["chatting"] == 0 and ($_GET["chatting"] != 0 and $_GET["chatting"] != '0')) {
                     $order = my_next_chat_order() + 1;  
                   }
                   else if ($_GET["chatting"] == 0 or $_GET["chatting"] == '0') {
                     reorder_my_chats ($chat_status["order_by"]);
                     $order = 0;
                     
                   }
        	   update_chat_status($chat_status["chat_status_id"], $_GET["chatting"], $order);
              	   
        	 }
        	 else{
                   insert_chat_status(get_my_user_id(), $_GET["partner_id"], $_GET["chatting"]); 
                         
        	 }
        	 $log['text'] = true;
                 break;

         case('flag_as_read'):
        	
                
        	 //echo '*' . $_GET["partner_id"] . '*';
                 flag_as_read_my_msg($_GET["msg_line_id"], $_GET["which_partner"]);
        	  
                 break;
    
    	 
    	 case('update'):
        	
                
        	 //echo '*' . $_GET["partner_id"] . '*';
                 $my_msgs = get_my_new_msgs();
        
        	 if(mysql_num_rows($my_msgs) == 0){
        		 
        		 $log['text'] = false;
                         //fwrite(fopen('debug.txt', 'a'), time() . ': no new messages\r\n');
        		 
        	 }
        	 else{ 
                         //fwrite(fopen('debug.txt', 'a'), time() . ': NEW MESSAGES\r\n');
        		 $text = array();
                                    
                   
        		 while ($msg = mysql_fetch_array($my_msgs))
                         { 
                           
                           if ($msg["sender_id"] == get_my_user_id()) {
                             $which_partner = "sender";
                             $my_partner_id = $msg["receiver_id"];
                             $my_partner = get_nickname($msg["receiver_id"]);
                           }
                           else {
                             $which_partner = "receiver";
                             $my_partner_id = $msg["sender_id"];
                             $my_partner = get_nickname($msg["sender_id"]);
                           }
                           $local_date_time = apply_my_timezone(strtotime($msg["date_time"]));
                           $chat_block = array($which_partner, $my_partner, $msg["msg_line_id"], '<p class="chat_time">' . date('g:i A', $local_date_time) . '</p><p>' . get_nickname($msg["sender_id"]) . ': ' . $msg["text_body"] . '</p>', $msg["is_message"]);
                           $text[$my_partner_id][] = $chat_block;
                           
                           //fwrite(fopen('debug.txt', 'a'), get_nickname($msg["sender_id"]) . ': ' . $msg["text_body"] . '\n');

                           
    
                         }
                         
        		 $log['text'] = $text; 
                         
        	 }
        	  
                 break;
    	 
    	 case('send'):
		  $sender_id = get_my_user_id();
                  $receiver_id = $_GET["receiver_id"];
			 $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			  $message = htmlentities(strip_tags($_GET['message']));
		 if(($message) != "\n"){
        	
			if(preg_match($reg_exUrl, $message, $url)) {
       		        	 $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
			} 
			if (is_offline($receiver_id)) {
                          $is_message = 1;
                          //if (get_preferences ($receiver_id, "chat_emails", 1) == 1) {
                          sendNewMessageEmail($sender_id, $receiver_id, $message);
                          sendNewMessageEmail($receiver_id, $sender_id, $message);
                          //}
                        }
                        else {
                          $is_message = 0;
                        } 
        	        insert_msg_line($sender_id, $receiver_id, date("Y-m-d H:i:s"), $message, $sender_has_seen=0, $receiver_has_seen=0, $is_message);
        	        
		 }
        	 break;
    	
    }
    //fwrite(fopen('debug.txt', 'a'), 'Returning to AJAX after ' . $_GET["function"] . '\r\n');
    echo json_encode($log);
    //fwrite(fopen('debug.txt', 'a'), 'Returned\r\n');
?>