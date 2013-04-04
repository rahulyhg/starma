
var instanse = false;
var partner_id;
var blink = false;
var just_sent = false;

function Chat (the_partner_id) {
    this.update = updateChat;
    this.send = sendChat;
    partner_id = the_partner_id;
    this.stopChatting = unloadChat;
        
}


function unloadChat() 
{
     
     $.ajax({
		   type: "GET",
              async: false,
              cache: false,
		   url: "https://www.starma.com/chat/process.php",
		   data: {  
		   			'function': 'setChat',
					'partner_id': partner_id,
                           'chatting': 0
					
				 },
              dataType: "json",
              success: function(data){
				   
		      instanse=false;
		   } 
                                                                    
		});
     //alert('inside function'); 
     //return false;
}


//Updates the chat
function updateChat(){
      //$('#chat-area').append("<p>" + instanse + "</p>");
	 if(!instanse){
		instanse = true;
	     $.ajax({
			   type: "GET",
			   url: "https://www.starma.com/chat/process.php",
                   cache: false,
                   //beforeSend: function() {
                   //  $('#chat-area').append($("<p>ABOUT TO SEND REQUEST</p>"));
                   //},
			   data: {  
			   			'function': 'update',
						'partner_id': partner_id
						},
			   dataType: "json",
			   success: function(data){
				   if(data.text){
					for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                           }								  
                           document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                           if (!blink && !just_sent) {
                             blink = true;
                             var oldTitle = document.title;
                             var msg = "New Message!";
                             var original_title = document.title
                             var timeoutId = setInterval(function() {
                                        document.title = document.title == msg ? original_title : msg;
                             }, 1000);
                             document.onmousemove = function() {
                                clearInterval(timeoutId);
                                document.title = oldTitle;
                                window.onmousemove = null;
                                blink=false;
                             };
                           }
                               
                        }
                        just_sent = false;
				   instanse = false;
			   } 
                   
                   
			});
	 }
	 else {
		 setTimeout(updateChat, 500);
	 }
      return true;
}

//send the message
function sendChat(message, sender_id, receiver_id)
{       
    //updateChat();
     $.ajax({
		   type: "GET",
		   url: "https://www.starma.com/chat/process.php",
              cache: false,
		   data: {  
		   			'function': 'send',
					'message': message,
				     'sender_id': sender_id,
                         	'receiver_id': receiver_id
				 },
		   dataType: "json",
		   success: function(data){
                   just_sent = true;
			   updateChat();
                   instanse=false;
		   },
		});
   return true;
}
