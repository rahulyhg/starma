<?php
require_once "header.php"; 
?>

<script type="text/javascript">
    
      
    	// kick off chat
        var chat_monitor =  new Chat_Monitor();
    	
    </script>

<script type="text/javascript">
  var chat_daemon_id;  
</script>


<body>
  <textarea id="chat-area" name="chat-area"></textarea>
  <input type="button" value="Join Chat" onclick="chat_daemon_id = setInterval('chat_monitor.monitor()', 10000); return false;"/>
  <input type="button" value="Leave Chat" onclick="clearInterval(chat_daemon_id); return false;"/>
  <br><br>

  <?php 

    echo '<a href="#" onclick="chat_monitor.nowChatting(53, 1); window.open(\'chat/chat_window.php?receiver_id=53\',\'starma_chat_53\',\'height=560px,width=540px\');">Open a Chat With Matt</a><br><br>';
    echo '<a href="#" onclick="chat_monitor.nowChatting(12, 1); window.open(\'chat/chat_window.php?receiver_id=12\',\'starma_chat_12\',\'height=560px,width=540px\');">Open a Chat With Josh</a><br><br>';
    echo '<a href="#" onclick="chat_monitor.nowChatting(13, 1); window.open(\'chat/chat_window.php?receiver_id=13\',\'starma_chat_13\',\'height=560px,width=540px\');">Open a Chat With Ariana</a>';
  ?>
  
  
</body>

<?php
 require_once "footer.php";
?> 