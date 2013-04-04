
var instanse = false;
var flagging = false;
var maxRefresh = 10000;
var internalCounter = 0;
var interval_id;
var blinking_array = new Array();
var docTitleBlinking = false;


function Chat_All (the_partner_id) {
    this.update = updateChat;
    this.send = sendChat;
    this.stopChatting = unloadChat;
    this.startChatting = loadChat;
    this.openChatting = openChat;
    this.flag_as_read = flagMsg;
    this.refresh = refreshChat;   
    this.openFullChat = openFullChatWindow;
    this.refreshTime = getRefreshTime;
}

function blinking_doc_alert() {
  var oldDocTitle = document.title; 
  var newDocTitle = "New Message!";
  var timeoutId;
  var blink = function() { 
     
       if (document.title == newDocTitle) {
         document.title = oldDocTitle;
       }
       else {
         document.title =  newDocTitle; 
       }
       
  };
  var clear = function() {
    clearInterval(timeoutId);
    document.title = oldDocTitle;
    window.onmousemove = null;
    timeoutId = null;
    docTitleBlinking = false;
  };
  
  if (!timeoutId) {
    docTitleBlinking = true;
    timeoutId = setInterval(blink, 1000);
    window.onmousemove = clear;
  }
  
}

function blinking_request_alert(partner_id, partner_name) {
  
  var chat_request = $("#chat_request_" + partner_id)[0]; 
  var chat_request_header = $("#chat_request_" + partner_id + " .chat_header_text")[0];
  var chat_request_header_shut_chat = chat_request = $("#chat_request_" + partner_id + " .chat_header_text .shut_chat");
  var chat_request_header_text = chat_request = $("#chat_request_" + partner_id + " .chat_header_text .text_link");
  var oldMsgTitle = chat_request_header_text.text(); 
  var newMsgTitle = "New Message from " + partner_name + "!";
  var timeoutId;

  var blink = function() { 
     if (chat_request_header_text.text() == newMsgTitle) {
       chat_request_header_text.text(oldMsgTitle);
       //chat_request_header.style.background_color = "#8393CA"; 
     }
     else {
       chat_request_header_text.text(newMsgTitle); 
       //chat_request_header.style.background_color = "#FBF0A4";
     }
       
  };
  var clear = function() {
    handle_chat_notification_click(partner_id);
    clearInterval(timeoutId);
    chat_request_header_text.text(oldMsgTitle);
    chat_request_header_text[0].onclick = function() {handle_chat_notification_click(partner_id);};
    timeoutId = null;
    blinking_array.splice(blinking_array.indexOf(partner_id), 1);
  };

  var clear_if_closing = function () {
    clearInterval(timeoutId);
    chat_request_header_text.text(oldMsgTitle);
    chat_request_header_shut_chat[0].onclick = function() {unloadChat(partner_id);};
    timeoutId = null;
    blinking_array.splice(blinking_array.indexOf(partner_id), 1);
    unloadChat(partner_id);
  }
  
  if (!timeoutId) {
    timeoutId = setInterval(blink, 1000);
    chat_request_header_text[0].onclick = clear;
    chat_request_header_shut_chat[0].onclick = clear_if_closing;
  }
  
}


function create_chat_alert (id, the_class, html) {
   
   var new_alert = document.createElement('li');
   new_alert.setAttribute('id', id);
   new_alert.setAttribute('class', the_class);
   
   if (html) {
       new_alert.innerHTML = html;
   } else {
       new_alert.innerHTML = "nothing";
   }

   document.getElementById("chat_alert_list").appendChild(new_alert);
   return new_alert;
}

function handle_chat_notification_click(partner_id) {
   if (document.getElementById("chat_block_" + partner_id)) {
     //alert("got here");
     if (document.getElementById("chat_block_" + partner_id).style.display != "none") {
       loadChat(partner_id);
       $("#chat_block_" + partner_id).removeClass("chat_open");
       $("#chat_request_" + partner_id + " .chat_header_text").removeClass("chat_open");

       document.getElementById("chat_block_" + partner_id).style.display = "none";
     }
     else {
       openChat(partner_id);
       $("#chat_request_" + partner_id + " .chat_header_text").addClass("chat_open");
       $("#chat_block_" + partner_id).addClass("chat_open");

       document.getElementById("chat_block_" + partner_id).style.display = "block";
       $('#chat_block_' + partner_id).load('https://www.starma.com/chat/load_msgs.php','partner_id=' + partner_id + '&ck=' + (new Date()).getTime(), function(){document.getElementById('chat_area_' + partner_id).scrollTop = document.getElementById('chat_area_' + partner_id).scrollHeight;});
     }
     return true;
   }
   else {
     openChat(partner_id);
     $("#chat_request_" + partner_id + " .chat_header_text").addClass("chat_open");
     var new_chat_block = document.createElement('div');
     new_chat_block.setAttribute('id', 'chat_block_' + partner_id);
     new_chat_block.setAttribute('class', 'chat_block chat_open');
     document.getElementById("chat_request_" + partner_id).appendChild(new_chat_block);
     $('#chat_block_' + partner_id).load('https://www.starma.com/chat/load_msgs.php','partner_id=' + partner_id + '&ck=' + (new Date()).getTime(), function(){document.getElementById('chat_area_' + partner_id).scrollTop = document.getElementById('chat_area_' + partner_id).scrollHeight;});
     return new_chat_block;
  }

}

function chatNotification (partner_id, partner_name, new_msg) {
  if (!document.getElementById("chat_request_" + partner_id) && document.getElementById("chat_block_" + partner_id)) {
    loadChat(partner_id);
  }
  if (!document.getElementById("chat_request_" + partner_id)) {
    new_div = create_chat_alert("chat_request_" + partner_id, "chat_request", "<div class='chat_header_text'><a class='text_link' onclick='handle_chat_notification_click(" + partner_id + "); return false;' href='#'>Chat with " + partner_name + "</a><a class='shut_chat' style='color:red; float:right' href='#' onclick='unloadChat(" + partner_id + "); return false;'>X</a></div>");
  }
  else { 
    $("#chat_request_" + partner_id + " .chat_header_text").removeClass("chat_open");
    document.getElementById("chat_request_" + partner_id).style.display = "block";
    
  }
  
  if (new_msg && blinking_array.indexOf(partner_id) == -1) {
    blinking_request_alert(partner_id, partner_name);
    blinking_array.push(partner_id);
    
  }                   
                   
  
}

function openFullChatWindow(partner_id, partner_name, chat_status) {
   $chat_notification = true;
   $handle_click = true;
   if (document.getElementById("chat_request_" + partner_id)) {
     if (document.getElementById("chat_request_" + partner_id).style.display == "block") {
       $chat_notification = false;
     }
   }
   if (document.getElementById("chat_block_" + partner_id)) {
     if (document.getElementById("chat_block_" + partner_id).style.display == "block") {
       $handle_click = false;
     }
   }
   if ($chat_notification) {
     chatNotification (partner_id, partner_name, false);
   }
   if ($handle_click) {
     if (chat_status == "2" || chat_status == 2) {
       handle_chat_notification_click(partner_id);
     }
   }
}

function getRefreshTime() {
  return maxRefresh;
}

function flagMsg(which_partner, msg_line_id) {
    flagging = true;
    $.ajax({
		   type: "GET",
              cache: false,
		   url: "https://www.starma.com/chat/process_all.php",
		   data: {  
		   			'function': 'flag_as_read',
					'msg_line_id': msg_line_id,
                           'which_partner': which_partner
					
				 },
              dataType: "json",
              success: function(data){
				   
		      flagging=false;
		   } 
                                                                    
		});

}

function refreshChat() 
{
     
     $.ajax({
		   type: "GET",
              
              cache: false,
		   url: "https://www.starma.com/chat/process_all.php",
		   data: {  
		   			'function': 'refreshChat',
										
				 },
              dataType: "json",
              success: function(data){
			 for (var i=0; i < data.text.length; i++)	{
                   partner_id = data.text[i]["user_id_B"];
                   partner_name = data.text[i]["nickname"];
 
                   chat_status = data.text[i]["chatting"];
                   
                   openFullChatWindow(partner_id, partner_name, chat_status)
                   

                 }   
		      
		   } 
                                                                    
		});
     
}

function openChat(partner_id) 
{
     //instanse = true;
     $.ajax({
		   type: "GET",
              
              cache: false,
		   url: "https://www.starma.com/chat/process_all.php",
		   data: {  
		   			'function': 'setChat',
					'partner_id': partner_id,
                           'chatting': 2
					
				 },
              dataType: "json"
              //success: function(data){
	   
		   //   instanse=false;
		   //} 
                                                                    
		});
     
}

function loadChat(partner_id) 
{
     //if (!instanse){
       $.ajax({
		   type: "GET",
              
              cache: false,
		   url: "https://www.starma.com/chat/process_all.php",
		   data: {  
		   			'function': 'setChat',
					'partner_id': partner_id,
                           'chatting': 1
					
				 },
              dataType: "json"
              //success: function(data){
				   
		   //   instanse=false;
		   //} 
                                                                    
		});
      //}
     
}

function unloadChat(partner_id) 
{
     
     $.ajax({
		   type: "GET",
              
              cache: false,
		   url: "https://www.starma.com/chat/process_all.php",
		   data: {  
		   			'function': 'setChat',
					'partner_id': partner_id,
                           'chatting': 0
					
				 },
              dataType: "json",
              success: function(data){
				   
		      //instanse=false;
                 if (document.getElementById("chat_request_" + partner_id).style.display != "none") {
                   document.getElementById("chat_request_" + partner_id).style.display = "none";
                 }
                 if (document.getElementById("chat_block_" + partner_id).style.display != "none") {
                   document.getElementById("chat_block_" + partner_id).style.display = "none";
                 }

		   } 
                                                                    
		});
     
}


//Updates the chat
function updateChat(){
      //$('#chat-area').append("<p>" + instanse + "</p>");
	 if(!instanse && !flagging){
		instanse = true;
	     $.ajax({
			   type: "GET",
			   url: "https://www.starma.com/chat/process_all.php",
                   cache: false,
                   //beforeSend: function() {
                   //  $('#chat-area').append($("<p>ABOUT TO SEND REQUEST</p>"));
                   //},
			   data: {  
			   			'function': 'update',
						
						},
			   dataType: "json",
			   success: function(data){
                        var allSentByMe = true;
				   if(data.text){
                           for (var partner_id in data.text) {
                             chat_block = data.text[partner_id];
                             //if chat_block exists on screen
                             if (document.getElementById("chat_block_" + partner_id)) {
                                // and if its open
                                if (document.getElementById("chat_block_" + partner_id).style.display != "none") {
                                  //update the text
                                  for (var i = 0; i < chat_block.length; i++) {
                                    $('#chat_area_' + partner_id).append($(chat_block[i][3]));
                                    document.getElementById('chat_area_' + partner_id).scrollTop = document.getElementById('chat_area_' + partner_id).scrollHeight;
                                    flagMsg(chat_block[i][0], chat_block[i][2]);
                                    if (chat_block[i][0] == "receiver") {allSentByMe = false;}
                                  } 
                                }
                                else if (document.getElementById("chat_request_" + partner_id).style.display != "none") {
                                  chatNotification (partner_id, chat_block[0][1], true); 
                                  allSentByMe = false;
                                }
                                else {
                                  openFullChatWindow(partner_id, chat_block[0][1], 2);
                                  allSentByMe = false;
                                }
                             }
                             // else if chat notifcation DOES NOT exist
                             else {
                               openFullChatWindow(partner_id, chat_block[0][1], 2);
                               allSentByMe = false;
                               //chatNotification (partner_id, chat_block[0][1], true); 
                               //alert (chat_block[0][0]);
                               //loadChat(partner_id);
                               //new_div = create_chat_alert("chat_request_" + partner_id, "chat_request", "<a class='text_link' onclick='handle_chat_notification_click(" + partner_id + "); return false;' href='#'>Chat with " + chat_block[0][1] + "</a>&nbsp;&nbsp;&nbsp;<a style='color:red' href='#' onclick='unloadChat(" + partner_id + ")'>X</a>");
                             
                             }
                           }
					 							  
                           
                           maxRefresh = 2000;
                           internalCounter = 10000;
                           //alert(allSentByMe);
                           if (!docTitleBlinking && !allSentByMe){
                             
                             blinking_doc_alert();
                           }
                        }
                        else {
                          internalCounter = internalCounter - 1000;
                          if (internalCounter <= 0) {
                            internalCounter = 0;
                            maxRefresh = 10000;
                          }
                        }
                       
				   instanse = false;
                        clearTimeout(interval_id);
                        interval_id = setTimeout(updateChat, maxRefresh);
			   } 
                   
                   
			});
	 }
	 else {
		 setTimeout(updateChat, 500);
	 }
      return true;
}

//send the message
function sendChat(message, receiver_id)
{       
    //updateChat();
     $.ajax({
		   type: "GET",
		   url: "https://www.starma.com/chat/process_all.php",
              cache: false,
		   data: {  
		   			'function': 'send',
					'message': message,
                         	'receiver_id': receiver_id
				 },
		   dataType: "json",
		   success: function(data){
                   
			   updateChat();
                   //instanse=false;
		   },
		});
   return true;
}