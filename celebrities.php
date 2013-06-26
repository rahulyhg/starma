<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {

  $celebs = get_celebrity_user_list();
  $num_celebs = mysql_num_rows($celebs);
  //echo '*' . $num_celebs . '*<br>';
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
    echo '<div id="boundry">';
      echo '<div id="js_celebrity_frame">';
     
        display_all_users($url="?the_page=" . $the_page . "&the_left=nav1&tier=3&stage=2", 2);
        addJSSearchEvents("js_search_bar","filterCelebs");
     echo '</div>';
    echo '</div>';
    echo '<div id="js_more_link">';
     echo '<a onclick="$(\'#js_celebrity_frame\').animate({\'margin-top\': (-790 * ($(\'#current_page\').val() - 2))+\'px\'}); $(\'#current_page\').val(parseInt($(\'#current_page\').val())-parseInt(1)); return false;" href="">Prev Page</a>';
     for ($i=0; $i<ceil((float)($num_celebs/16)); $i++) {
       //echo $i;
       echo '<a onclick="
                              $(\'#js_celebrity_frame\').animate({\'margin-top\':' . (int)(-790 * $i) . ' +\'px\'}); 
                              $(\'#current_page\').val(' . (int)($i+1) . '); 
                              return false;
                        " href="">' . (int)($i+1) . '</a>';       
       
     }
     echo '<a onclick="$(\'#js_celebrity_frame\').animate({\'margin-top\':-790 * $(\'#current_page\').val()+\'px\'}); $(\'#current_page\').val(parseInt($(\'#current_page\').val())+parseInt(1)); return false;" href="">Next Page</a>';
     echo '<input type="hidden" value="1" name="current_page" id="current_page"/>';
    echo '</div>';
  echo '</div>';
  
  
}

?> 
