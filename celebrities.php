<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {



  clear_compare_data();
  //Log the Action
  //log_this_action (compare_action_all(), viewed_basic_action());
  echo '<div id="all_users">';
    echo '<div id="compare_header">';
        flare_title ("Celebrities");
    echo '</div>';
    echo '<div id="search_bar_div">';
      echo '<div id="search_bar_title">';
        echo 'Search:';
      echo '</div>';
      echo '<div id="search_bar_input">';
        echo '<input type="text" id="js_search_bar">';
      echo '</div>';
    echo '</div>';
    echo '<div id="js_celebrity_frame">';
      display_all_users($url="?the_page=" . $the_page . "&the_left=nav1&tier=3&stage=2", 2);
      addJSSearchEvents("js_search_bar","filterCelebs");
    echo '</div>';
    echo '<div id="js_more_link">';
     echo '<a onclick="$(\'#js_celebrity_frame\').animate({height:198+$(\'#js_celebrity_frame\').height()+\'px\'}); return false;" href="">VV More VV</a>';
    echo '</div>';
  echo '</div>';
  
  
}

?> 
