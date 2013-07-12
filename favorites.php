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
  //log_this_action (compare_action_all(), viewed_basic_action());
  echo '<div id="all_users">';
    echo '<div id="compare_header">';
        flare_title ("Favorites");
    echo '</div>';
    echo '<div id="search_bar_div">';
      echo '<div id="search_bar_title">';
        echo 'Search:';
      echo '</div>';
      echo '<div id="search_bar_input">';
        echo '<input type="text" id="js_search_bar">';
      echo '</div>';
    echo '</div>';
    display_all_users($url="?the_page=" . $the_page . "&the_left=nav2&tier=3&stage=2", 1);
    addJSSearchEvents("js_search_bar");
  echo '</div>';
}
elseif ($tier == "2") {
    if (isset($_GET["results_type"])) {
       $results_type = $_GET["results_type"];
    }
    else { 
      $results_type = "major";
    }
    if (isset($_GET["text_type"])) {
      $text_type = $_GET["text_type"];
    }
    else { 
      $text_type = "2";
    }  
    if ((string) $_GET["stage"] == "2" or (string) $_GET["stage"] == "3") {
       $gotothe = "?the_page=" . $the_page . "&the_left=" . $the_left . "&results_type=" . $results_type . "&text_type=" . $text_type . "&tier=2";
       compare_tier_2 ($gotothe, $results_type, $text_type);
    } 
    if (isset($_SESSION["compare_more_info_flag"])) {
      $flag = $_SESSION["compare_more_info_flag"];
    }
    else {
      $flag = get_my_preferences("compare_more_info_flag", 1);
    }
    if ($flag == 1) {
      show_sheen($flag, 'compare_info_form');
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
