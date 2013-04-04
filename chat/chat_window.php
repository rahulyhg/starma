<?php
  session_start();
  require_once ('../include/db_connect.inc.php'); 
  require_once ("../include/functions.inc.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Chat with <?php echo get_nickname($_GET["receiver_id"])?></title>
    
    <link rel="stylesheet" href="style.css" type="text/css" />
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="chat.js"></script>
    <script type="text/javascript">
    	
        var chat_name = window.name.substring(12);
        var receiver_id = chat_name.substring(chat_name.search("_")+1);
    	var chat = new Chat(receiver_id);
 
       
        
        
    	$(function() {
    	     <?php echo 'var my_id = ' . get_my_user_id() . ';';?>	 
                 
             
    		 // watch textarea for key presses
             $("#sendie").keydown(function(event) {  
             
                 var key = event.which;  
           
                 //all keys including return.  
                 if (key >= 33) {
                   
                     var maxLength = $(this).attr("maxlength");  
                     var length = this.value.length;  
                     
                     // don't allow new content if length is maxed out
                     if (length >= maxLength) {  
                         event.preventDefault();  
                     }  
                  }  
    		 																																																});
    		 // watch textarea for release of key press
    		 $('#sendie').keyup(function(e) {	
    		 					 
    			  if (e.keyCode == 13) { 
    			  
                                var text = $(this).val();
     				var maxLength = $(this).attr("maxlength");  
                                var length = text.length; 
                     
                               // send 
                               if (length <= maxLength + 1) { 
                                 
                        
                                  
    			          chat.send(text, my_id, receiver_id);	
                                  //$('#chat-area').append($("<p><?php echo get_my_nickname();?>: " + text + "</p>"));
                                  //document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
    			          $(this).val("");
    			        
                               } else {
                    
    	    	                  $(this).val(text.substring(0, maxLength));
    		 			
    			       }	
    				
    				
    			  }
                   
                 });
            
    	});
        //alert(window.name());
        //var x = 0;
        
    </script>
    

</head>

<body onload="document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight; document.getElementById('sendie').focus(); setInterval('chat.update()', 2000);" onunload="chat.stopChatting();">

    <div id="page-wrap">
    
        <h2>jQuery/PHP Chat</h2>
        
        <p id="name-area"></p>
        
        <div id="chat-wrap"><div id="chat-area"><?php show_msgs($_GET["receiver_id"]);  ?></div></div>
        
        <form id="send-message-area">
            <p>Your message: </p>
            <textarea id="sendie" maxlength = '100' ></textarea>
        </form>
        
        <!---<input type="button" onclick="chat.stopChatting();" value="Unload Chat"/>
        <input type="button" onclick="chat.update();" value="Start Up Chat Again"/>--->
    </div>

</body>



</html>