

function Chat_Monitor () {
        this.monitor = monitorChat;
	   this.nowChatting = setChat;
        
}


function setChat(partner_id, chatting) 
{
     $.ajax({
		   type: "GET",
              cache: false,
		   url: "https://www.starma.com/chat/process.php",
		   data: {  
		   			'function': 'setChat',
					'partner_id': partner_id,
                           'chatting': chatting
					
				 },
		   dataType: "json",
              success: function(data) {
                if(data.text){
                   if (document.getElementById("chat_request_" + partner_id)) {
    			     document.getElementById("chat_request_" + partner_id).style.display="none";
                   }						  
                }

                
              }
              
		   
		});
}


function monitorChat()
{       
     $.ajax({
		   type: "GET",
              cache: false,
		   url: "https://www.starma.com/chat/process.php",
		   data: {  
		   			'function': 'monitor'
					
					
				 },
		   dataType: "json",
              success: function(data) {
                if(data.text){
			     for (var sender_id in data.text) {
                         if (!$('#chat_request_' + sender_id).length) {
                           new_div = create_chat_alert("chat_request_" + sender_id, "chat_request", "<a onclick='chat_monitor.nowChatting(" + sender_id + ", 1);window.open(\"chat/chat_window.php?receiver_id=" + sender_id + "\",\"starma_chat_" + sender_id + "\",\"height=560px,width=540px\");' href='#'>Message From " + data.text[sender_id] + "!</a>");
                         }
                         else {
                           document.getElementById("chat_request_" + sender_id).style.display='inline';
                         }
                     }								  
                }

                
              }
              
		   
		});
}
