<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {



if (isset($_GET["tier"])) {
  $tier=$_GET["tier"];
}
else {
  $tier = "1"; 
}

if ($tier == "1") {
  clear_compare_data();
  //Log the Action
  log_this_action (compare_action_all(), viewed_basic_action());
  echo '<div id="all_users">';
    echo '<div id="compare_header">';
      flare_title ("All Users");
    echo '</div>';
    display_all_users($url="?the_page=" . $the_page . "&the_left=" . $the_left . "&tier=3&stage=2");
  echo '</div>';
  //display_my_chart_list();
}
elseif ($tier == "2") {
  
    if ((string) $_GET["stage"] == "2" or (string) $_GET["stage"] == "3") {
      if (isset($_GET["results_type"])) {
        $results_type = $_GET["results_type"];
      }
      else { 
        $results_type = "major";
      }
      $gotothe = "?the_page=" . $the_page . "&the_left=" . $the_left . "&results_type=" . $results_type . "&tier=2";
      if (!isset($_SESSION['compare_data'])) {
        generate_compare_data ($_GET["chart_id1"], $chart_id2 = $_GET["chart_id2"]);
        //Log the Action
        log_this_action (compare_action_chart(), compare_basic_action(), $_GET["chart_id2"], get_user_id_from_chart_id($_GET["chart_id2"]));
      }
      if (cornerstones_all_there ($_SESSION['compare_chart_ids'][0]) && cornerstones_all_there($_SESSION['compare_chart_ids'][1])) {
        $total_score = compare_charts ($compare_results = $_SESSION["compare_data"], $error_check = false);
      }
      else {
        $total_score = -1;
      }
      //echo $total_score;
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
      //compare_charts_old($chart_id1 = $_GET["chart_id1"], $chart_id2 = $_GET["chart_id2"]); 
    } 
    $flag = get_my_preferences("compare_more_info_flag", 1);
    if ($flag == 1) {
      show_sheen($flag);
    }

}
elseif ($tier == "3") {
  require("non_chart_profile_others.php");
}
elseif ($tier == "4") {
  require("chart_others.php");
}

}
?> 
