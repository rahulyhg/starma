<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  if (isset($_GET["chart_id2"])) {
    $chart_id2 = $_GET["chart_id2"];
  
    //Log the Action
    if (!isset($_POST["poi_id"])) {
      $log_poi_id = 1;
    }
    else {
      $log_poi_id = $_POST["poi_id"];
    }
    
    show_others_chart($goTo="?the_page=" . $the_page . "&the_left=" . $the_left . '&tier=4', $chart_id2);

    // If Freebie Chart //////////////////
    if (is_freebie_chart($chart_id2)) {
      echo '<div class="profile_button custom_compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2">Compare Yourself to this Person</a></div>';
      log_this_action (compare_action_custom(), viewed_basic_action(), $log_poi_id, $chart_id2);
    }
    //////////////////////////////////////
    else {
       log_this_action (compare_action_chart(), viewed_basic_action(), $log_poi_id, $chart_id2);
    }
  }
  else {
    echo 'No Chart Found';
  }
}

  


?> 
