<?php
require_once ("header.php");

  
if (isset($_GET["tier"])) {
  $tier=$_GET["tier"];
}
else {
  $tier = "1"; 
}

if ($tier == "1") {
  
  $users = get_user_list ();;
  $num_users = mysql_num_rows($users);
  $users_per_page = grab_var('users_per_page', 16);
  $current_page = grab_var('current_page', 1);
  $num_pages = ceil((float)($num_users/$users_per_page));
  $height_inc = ceil((float)($users_per_page/USER_BLOCK_PER_ROW())) * (int)(USER_BLOCK_COMPARE_HEIGHT());

  //Log the Action
  //LOGTAG - FRONT_END log_this_action (compare_action_all(), viewed_basic_action());

  echo '<div id="all_users">';
    
    js_more_link ("js_user_frame", $num_pages, $current_page, $height_inc, $num_users);
    echo '<div id="search_bar_div">';
      
      echo '<div id="search_bar_input">';
        echo '<input type="text" id="js_search_bar" value="Search">';
      echo '</div>';
    echo '</div>';
    echo '<div id="boundry">';
      echo '<div id="js_user_frame">';
        display_all_users($url="?the_page=" . $the_page . "&the_left=" . $the_left . "&tier=3&stage=2");
        addJSSearchEvents("js_search_bar","filterAllUsers");
      echo '</div>';
    echo '</div>';
  echo '</div>';
  //display_my_chart_list();
}
/*
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
*/
elseif ($tier == "3") {
  require("limited_profile.php");
}


echo '<script type="text/javascript" src="/js/all_users_ui.js"></script>';

?> 
