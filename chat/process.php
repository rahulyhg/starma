<?php
    session_start();
    require_once ('../include/db_connect.inc.php'); 
    require_once ("../include/functions.inc.php"); 
    //fwrite(fopen('debug.txt', 'a'), 'Begin Process..\r\n');
    //echo '*'. get_my_nickname() . '*';
    //print_r ($_SESSION);
    //die();
    $function = $_GET['function'];
    
    $log = array();
    
    switch($function) {
        	
        	 
         case('setChat'):
        	
                
        	 
                 if ($chat_status = chat_status(get_my_user_id(), $_GET["partner_id"])) {
                   //echo '*' . $chat_status["chat_status_id"] . '*';
        	   update_chat_status($chat_status["chat_status_id"], $_GET["chatting"]);
              	   
        	 }
        	 else{
                   insert_chat_status(get_my_user_id(), $_GET["partner_id"], $_GET["chatting"]); 
                         
        	 }
        	 $log['text'] = true;
                 break;
         case('monitor'):
        	
                
        	 //echo '*' . $_GET["partner_id"] . '*';
                 $senders = get_my_new_msg_senders();
        
        	 if(mysql_num_rows($senders) == 0){
        		 
        		 $log['text'] = false;
        		 
        	 }
        	 else{
        		 $text = array();
                                    
                   
        		 while ($sender = mysql_fetch_array($senders))
                         { 
                           
                           if (!isChatting($sender["sender_id"])) {
                             $text[$sender["sender_id"]] = $sender["nickname"];
                           }
                           
    
                         }
                         
        		 $log['text'] = $text; 
                         
        	 }
        	  
                 break;
    
    	 
    	 case('update'):
        	
                
        	 //echo '*' . $_GET["partner_id"] . '*';
                 $my_msgs = get_my_new_msgs_with($_GET["partner_id"]);
        
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
                             //$my_name = get_nickname($msg["sender_id"]);
                           }
                           else {
                             $which_partner = "receiver";
                             //$my_name = get_nickname($msg["receiver_id"]);
                           }
                           $text[] = get_nickname($msg["sender_id"]) . ': ' . stripslashes($msg["text_body"]);
                           
                           //fwrite(fopen('debug.txt', 'a'), get_nickname($msg["sender_id"]) . ': ' . stripslashes($msg["text_body"]) . '\n');

                           flag_as_read_my_msg($msg["msg_line_id"], $which_partner);
    
                         }
                         
        		 $log['text'] = $text; 
                         
        	 }
        	  
                 break;
    	 
    	 case('send'):
		  $sender_id = $_GET["sender_id"];
                  $receiver_id = $_GET["receiver_id"];
			 $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			  $message = htmlentities(strip_tags($_GET['message']));
		 if(($message) != "\n"){
        	
			if(preg_match($reg_exUrl, $message, $url)) {
       		        	 $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
			} 
			 
        	        insert_msg_line($sender_id, $receiver_id, date("Y-m-d H:i:s"), $message);
        	        
		 }
        	 break;
    	
    }
    //fwrite(fopen('debug.txt', 'a'), 'Returning to AJAX after ' . $_GET["function"] . '\r\n');
    echo json_encode($log);
    //fwrite(fopen('debug.txt', 'a'), 'Returned\r\n');
?>