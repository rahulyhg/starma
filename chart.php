<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  //Log the Action
  if (!isset($_POST["poi_id"])) {
    $log_poi_id = 1;
  }
  else {
    $log_poi_id = $_POST["poi_id"];
  }
  log_this_action (chart_action(), viewed_basic_action(), $log_poi_id);
  show_my_chart($goTo="?the_page=" . $the_page . "&the_left=" . $the_left);
}

  


?> 
