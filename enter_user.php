<?php
require_once ("header.php");

if (login_check_point($type="full")) {

unset($_SESSION["change_info"]);

if (isset($_GET["tier"])) {
  $tier=$_GET["tier"];
}
else {
  $tier = "1"; 
}

echo '<div id="custom_chart">';

if ($tier == "1") {
  //Log the Action
  log_this_action (compare_action_custom(), viewed_basic_action());
  clear_compare_data();
  
    flare_title ("Custom Chart");
    echo '<div id="header_desc">';
      echo 'Use the form below to enter the birth information of a friend or family member who\'s chart you would like to see.  You can even check compatibility between the two of you!';
    echo '</div>';
  
  if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
    unset ($_SESSION["errors"]);
    show_birth_info_form($errors=$errors, $sao=1, $title="", $action="cast_chart.php", $stage=2);
  }
  else {
    show_birth_info_form($errors=array(), $sao=0, $title="", $action="cast_chart.php", $stage=2);
  }
  //display_my_chart_list();
}
elseif ($tier == "2") {
  if (isset($_GET["results_type"])) {
    $results_type = $_GET["results_type"];
  }
  else { 
    $results_type = "major";
  }
  $gotothe = "?the_page=" . $the_page . "&the_left=" . $the_left . "&results_type=" . $results_type . "&tier=2";

  if ((string) $_GET["stage"] == "2" or (string) $_GET["stage"] == "3") {
    if ($chart = get_chart_by_name("Freebie1")) {
      if (!isset($_SESSION['compare_data'])) {
        generate_compare_data ($chart_id1 = get_my_chart_id(), $chart_id2 = $chart["chart_id"]);
        //Log the Action
        log_this_action (compare_action_custom(), compare_basic_action(), $chart["chart_id"]);
      
      }
      if (cornerstones_all_there (get_my_chart_id()) && cornerstones_all_there ($chart["chart_id"])) {
        $total_score = compare_charts ($compare_results = $_SESSION["compare_data"], $error_check = false);
      }
      else {
        $total_score = -1;
      }
      show_compare_results ($score = $total_score, $goto=$gotothe, $results_type=$results_type, $stage = $_GET["stage"]);
      switch ($results_type) {
      case "major": 
        show_major_connections ($compare_data=$_SESSION["compare_data"], $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        break;
      case "minor": 
        show_minor_connections ($compare_data=$_SESSION["compare_data"], $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        break;
      case "bonus": 
        show_bonus_connections ($compare_data=$_SESSION["compare_data"], $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        break;            
      }    
      // If we're comparing to a Freebie Chart ////
      if (is_freebie_chart($chart["chart_id"])) {
        echo '<div class="profile_button custom_chart_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&tier=4&chart_id2=' . $chart["chart_id"] . '">View This Person\'s Chart</a></div>';
      }
      /////////////////////////////////////////////
    }
    else {
      show_birth_info_form($errors=array("Failed to Retrieve User Entered Chart"), $sao=0, $title="", $action="cast_chart.php", $stage=2);
    }
   
  }

}
elseif ($tier == "4") {
  if (!isset($_GET["chart_id2"])) {
    if ($chart = get_chart_by_name ("Freebie1")) {
      $_GET["chart_id2"] = $chart["chart_id"];
      
    }
  }
  require("chart_others.php");
}

echo '</div>';

}    
            
                           
            
 

?> 
