<?php
  require_once "header.php"; 
 $actcode = $_GET["actcode"];
 $email = $_GET["email"];
 $user_id = user_id_from_actcode_and_email ($email, $actcode);
 unsubscribe ($user_id);
 echo '<div id="welcome">
 	<br>
    <div style="font-size:2.2em" class="later_on">You have been unscribed from New Message emails!</div>
    <div class="text_block" style="width: 500px;">
    	<a href="' . get_full_domain() . '">Back To Starma.com</a>
    </div>
';
echo '</div>';
?>