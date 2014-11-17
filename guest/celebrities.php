<?php
require_once ("header.php");

  
//if (login_check_point($type="full")) {

if (isset($_GET["tier"])) {
  $tier=$_GET["tier"];
}
else {
  $tier = "1"; 
}

if ($tier == "1") {
/*
  $celebs = get_celebrity_user_list();
  $num_celebs = mysql_num_rows($celebs);
  $celebs_per_page = grab_var('celebs_per_page', 16);
  $current_page = grab_var('current_page', 1);
  $num_pages = ceil((float)($num_celebs/$celebs_per_page));
  $height_inc = ceil((float)($celebs_per_page/USER_BLOCK_PER_ROW())) * (int)(USER_BLOCK_COMPARE_HEIGHT());
  //echo '*' . $num_celebs . '*<br>';
*/
  clear_compare_data();
   echo '<div id="celebrities">';
        echo '<div id="s_top_bar">';      
          echo '<div class="pop_guest_click" style="display:inline-block; margin-bottom: 10px;"><input type="text" id="cue_search" placeholder="Search by Celebrity Name" disabled><div class="later_on pointer" id="cue_button">Go!</div></div>';
          echo '<div id="hide_s" class="later_on pointer"><- Back</div>';
        echo '</div>'; //close s_top_bar

          echo '<div id="users_found"></div>';
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

  echo '<div id="s_loading" class="later_on"><div style="width:120px; margin:auto;"><img src="../img/loading.gif" /></div></div>';
}
elseif ($tier == "2") {
  echo '<div id="img_preloader">
  <img src="/img/sign_buttons_tall/Starma-Astrology-Aries-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Taurus-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Gemini-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Cancer-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Leo-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Virgo-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Libra-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Scorpio-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Sagittarius-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Capricorn-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Aquarius-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Pisces-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Unknown-Tall-ON.png"/>  
  <img src="/img/sign_buttons_tall/Starma-Astrology-Unknown-Tall-OFF.png"/> 
  <img src="/img/Starma-Astrology-Pillar.png"/> 
  <img src="/img/Starma-Astrology-Pillar-Arrow.png"/> 
  <img src="/img/Starma-Astrology-Pillar-Broken.png"/> 
  <img src="/img/Starma-Astrology-Pillar-Broken-Arrow.png"/> 
  <img src="/img/Starma-Astrology-Pillars-Top.png"/> 
  <img src="/img/Starma-Astrology-Pillars-Base.png"/> 
  </div>';
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
  require("limited_profile.php");
}
//elseif ($tier == "4") {
//  require("chart_others.php");
//}

echo '<script type="text/javascript" src="/js/celebs_ui.js"></script>';
  
//}

?> 
