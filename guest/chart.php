<?php
require_once ("header.php");

  
//if (login_check_point($type="full", $domain=$domain)) {
$guest_user_id = get_guest_user_id();
$guest_chart_id = get_guest_chart_id($guest_user_id);
  if (!isset($_POST["poi_id"])) {
    $log_poi_id = 1;
    //clear_session_preferences();
  }
  else {
    $log_poi_id = $_POST["poi_id"];
  }

  if (!isset($_GET["western"])) {
    $western = 0;
  }
  else {
    $western = $_GET["western"];
  }

    $section = $_GET["section"];
  

    show_guest_chart($the_page, $the_left, $guest_user_id, $western);
  //show_guest_chart($goTo="?the_page=" . $the_page . "&the_left=" . $the_left . "&western=" . $western . "&section=" . $section, $guest_user_id, $western);

  
    
  
  
//}

  


?> 
