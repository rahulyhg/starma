<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {

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
    echo '<div id="compare_header">';
        flare_title ("Celebrities");
    echo '</div>';
    js_more_link ("js_celebrity_frame", $num_pages, $current_page, $height_inc, $num_celebs);
    echo '<div id="search_bar_div">';
      echo '<div id="search_bar_title">';
        echo 'Search:';
      echo '</div>';
      echo '<div id="search_bar_input">';
        echo '<input type="text" id="js_search_bar">';
      echo '</div>';
    echo '</div>';
    echo '<div id="boundry">';
      echo '<div id="js_celebrity_frame">';
     
        display_all_users($url="?the_page=" . $the_page . "&the_left=nav1&tier=3&stage=2", 2);
        addJSSearchEvents("js_search_bar","filterCelebs");
     echo '</div>';
    echo '</div>';
   
    

  echo '</div>';
  
  
}

?> 
