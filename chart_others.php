<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  
  if (isset($_GET["chart_id2"])) {
    $chart_id2 = $_GET["chart_id2"];
    //Log the Action

    $can_view = can_view_section($chart_id2);
    if (!$can_view[0]) {
      
      echo $can_view[1];
    }     
    else {
      
      if (!isset($_POST["poi_id"])) {
        $log_poi_id = 1;
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
   
      if (is_freebie_chart($chart_id2)) {  
        if ($western == 1) {
        
          $chart_id2 = chart_already_there("Alternate_Freebie1",get_my_user_id());
        }
        else {
          $chart_id2 = chart_already_there("Freebie1",get_my_user_id());
        }

      $section = $_GET["section"];
      }

   

  /*// OLD LINKS FOR CUSTOM CHART
      $show_links = false;
      if (is_freebie_chart($chart_id2)) {
        //if ( !chart_already_there("Alternate",get_user_id_from_chart_id($chart_id2)) ) {
          $show_links = true;
        //}
      }
      if ($show_links) {
        if ($western == 0) {
          echo '<div id="chart_direction_link_west">';
            echo '<a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&tier=4&chart_id2=' . $chart_id2 . '&western=1&section=' . $section . '">Starma Western Chart --></a>';
          echo '</div>';
        }
        else {
          echo '<div id="chart_direction_link_east">';
            echo '<a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&tier=4&chart_id2=' . $chart_id2 . '&western=0section=' . $section . '"><-- Starma Eastern Chart</a>';
          echo '</div>';
        }
      }
  */ 

    
    
    
      
    
  
      if (!is_freebie_chart($chart_id2)) {
        $goTo="?the_page=" . $the_page . "&the_left=" . $the_left . "&tier=3&western=" . $western . "&section=" . $section; 
      }
      else {
        $goTo="?the_page=" . $the_page . "&the_left=" . $the_left . "&tier=4&western=" . $western . "&section=" . $section; 
      }
      show_others_chart($the_page, $the_left, $chart_id2, $western);
      // If Freebie Chart //////////////////
      if (is_freebie_chart($chart_id2)) { 
        //if ($western == 0) {
        //  echo '<div class="profile_button custom_compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2">Compare Yourself to this Person</a></div>';
        //}
        log_this_action (compare_action_custom(), viewed_basic_action(), $log_poi_id, $chart_id2, $western);
      }
      //////////////////////////////////////
      else {
         log_this_action (compare_action_chart(), viewed_basic_action(), $log_poi_id, $chart_id2, $western, get_user_id_from_chart_id($chart_id2));
      }
    } 
    
  }
   
  else {
    echo 'No Chart Found';
  }
}

  


?> 
