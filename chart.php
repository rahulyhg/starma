<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  
  if (!get_my_chart()) {
    echo 'Enter your birth info to get your birth chart';
  }
  else {
    if (!isset($_POST["poi_id"])) {
      $log_poi_id = 1;
      clear_session_preferences();
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
  


    //Log the Action
    log_this_action (chart_action(), viewed_basic_action(), $log_poi_id, $western);

    //if ($western == 1) {
      if (!chart_already_there("Alternate",get_my_user_id())) {
        $chart_to_cast_from = get_my_chart();
        if (!single_click_cast ("Alternate", $chart_to_cast_from["birthday"], substr($chart_to_cast_from["latitude"], 0, 6), substr($chart_to_cast_from["longitude"], 0, 7), substr($chart_to_cast_from["latitude"], -1), substr($chart_to_cast_from["longitude"], -1), $chart_to_cast_from["timezone"], $chart_to_cast_from["DST"], $chart_to_cast_from["location"], $chart_to_cast_from["interval_time"], $chart_to_cast_from["time_unknown"], "W")) {
            echo 'Error Obtaining Western Chart';
        }
      }
    //}
    /*
      if ($western == 0) {
        echo '<div id="chart_direction_link_west">';
          echo '<a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=1">Starma Western Chart --></a>';
        echo '</div>';
      }
      else {
        echo '<div id="chart_direction_link_east">';
          echo '<a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0"><-- Starma Eastern Chart</a>';
        echo '</div>';
      }
    */
      //show_my_chart($goTo="?the_page=" . $the_page . "&the_left=" . $the_left . "&western=" . $western . "&section=" . $section, $western);

    show_my_chart($the_page, $the_left, $western);

    if ($western == 0) {
      if (isset($_SESSION["chart_more_info_flag"])) {
        $flag = $_SESSION["chart_more_info_flag"];
      }
      else {
        $flag = get_my_preferences("chart_more_info_flag", 1);
      }
      /*
      if ($flag == 1) {
        show_sheen($flag, 'chart_info_form');
      }
      */
    }
  }
  
  
  
    
  
  
}

  


?> 
