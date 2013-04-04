<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);




?> 

<form name="logout_form" method="post" action="logout.php">
  
    <div style="margin-left:auto; margin-right:auto; padding-top:30px; width:100px;"><input style="border:2px solid #4444444; padding:10px; font-size:1.2em; font-weight:bold; border-radius: 15px" type="submit" name="Log Out" value="Log Out"></div>
  
</form>
