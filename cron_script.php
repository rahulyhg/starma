<?php
require_once ("header.php");

  
$users_to_check = get_user_list();

while ($user = mysql_fetch_array($users_to_check)) {
  
  if ($user["user_id"] == 53 or $user["user_id"] == 12) {

  $last_action_made = $user["last_action_made"];
  $threshold = date('YmdHis', mktime(date("H"), date("i"), date("s"), date("m"), date("d")-14, date("Y")));
  //echo $row["last_action_made"] . ' **** ' . $threshold;
  //die();
  $num_times_compared = num_times_compared($user["user_id"], $threshold);
  
  if ($num_times_compared >= 3) {
    //echo $user["nickname"] . ' is getting an email, he/she has been compared ' . $num_times_compared . ' time(s) since ' . $threshold . '<br>';
    sendComparedAlertEmail($user["user_id"], $num_times_compared);
  }
  }  
  //if $last_action_made >= $threshold;
}

  


?> 
