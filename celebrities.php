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

  echo '<div id="celebrities">';
        echo '<div id="s_top_bar">';      
          echo '<div style="display:inline-block;"><input type="text" id="cue_search" placeholder="Search by Celebrity Name"><div class="later_on pointer" id="cue_button">Go!</div></div>';
        echo '</div>'; //close s_top_bar

          echo '<div id="single_u"></div>';
        echo '<div id="s_results">';
          show_profiles($url="?the_page=" . $the_page . "&the_left=" . $the_left . "&tier=3&stage=2", $limit=25, $filter=2);
        echo '</div>';

        echo '<div id="js_back_to_top">';
            echo '<a onclick="$(\'html,body\').animate({ scrollTop: 0 }, \'fast\'); return false;" href="">^<br>Back<br>To Top</a>';
        echo '</div>';
        addBackToTopHandler();

        //echo '<input type="hidden" id="nts" value="true" />';
        echo '<input type="hidden" id="url" value="?the_page=' . $the_page . '&the_left=' . $the_left . '&tier=3&stage=2" />';
        echo '<input type="hidden" id="from" value="celeb" />';
  
  echo '</div>'; //close celebrities

  echo '<div id="s_loading" class="later_on"><div style="width:120px; margin:auto;"><img src="img/loading.gif" /></div></div>';

/*
  $celebs = get_celebrity_user_list();
  $num_celebs = mysql_num_rows($celebs);
  $celebs_per_page = grab_var('celebs_per_page', 16);
  $current_page = grab_var('current_page', 1);
  $num_pages = ceil((float)($num_celebs/$celebs_per_page));
  $height_inc = ceil((float)($celebs_per_page/USER_BLOCK_PER_ROW())) * (int)(USER_BLOCK_COMPARE_HEIGHT());
  //echo '*' . $num_celebs . '*<br>';
  clear_compare_data();
  //Log the Action
  //log_this_action (compare_action_all(), viewed_basic_action());
  echo '<div id="all_users">';
    //echo '<div id="compare_header">';
    //    flare_title ("Celebrities");
    //echo '</div>';
    js_more_link ("js_celebrity_frame", $num_pages, $current_page, $height_inc, $num_celebs);
    echo '<div id="search_bar_div">';
      //echo '<div id="search_bar_title">';
        //echo 'Search:';
      //echo '</div>';
      echo '<div id="search_bar_input">';
        echo '<input type="text" class="input_style" id="js_search_bar" value="Search">';
      echo '</div>';
    echo '</div>';
    echo '<div id="boundry">';
      echo '<div id="js_celebrity_frame">';
     
        display_all_users($url="?the_page=" . $the_page . "&the_left=nav1&tier=3&stage=2", 2);
        addJSSearchEvents("js_search_bar","filterCelebs");
     echo '</div>';
    echo '</div>';
  echo '</div>';
  */

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
    /*
    if (isset($_SESSION["compare_more_info_flag"])) {
      $flag = $_SESSION["compare_more_info_flag"];
    }
    else {
      $flag = get_my_preferences("compare_more_info_flag", 1);
    }
    if ($flag == 1) {
      show_sheen($flag, 'compare_info_form');
    }
    */

}
elseif ($tier == "3") {
  require("non_chart_profile_others.php");
}
//elseif ($tier == "4") {
//  require("chart_others.php");
//}

echo '<script type="text/javascript" src="/js/celebs_ui.js"></script>';
  
}

?> 
