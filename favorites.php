<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {



  clear_compare_data();
  //Log the Action
  log_this_action (compare_action_all(), viewed_basic_action());
  echo '<div id="all_users">';
    echo '<div id="compare_header">';
        flare_title ("Favorites");
    echo '</div>';
    echo '<div id="search_bar_div">';
      echo '<input type="text" id="search_bar">';
    echo '</div>';
    display_all_users($url="?the_page=" . $the_page . "&the_left=nav1&tier=3&stage=2", 1);
    addJSSearchEvents("search_bar");
  echo '</div>';
  
  
}

?> 
