<?php
require_once ("header.php");

if (login_check_point($type="full")) {

    $section = grab_var('section','chart_selected');
    
    $chart_selected = '';
    $houses_selected = '';
    $western_selected = '';

    $$section = 'selected';
  /*
    if($_GET["section"] = "chart_selected"){
        $chart_selected = 'selected';
    }
    elseif($_GET["section"] = "houses_selected"){
        $houses_selected = 'selected';
    }
    elseif($_GET["section"] = "western_selected"){
        $western_selected = 'selected';
    }
  */

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
  
    //flare_title ("Custom Chart");
    echo '<div id="header_desc">';
      echo 'Use the form below to enter the birth information of a friend or family member who\'s chart you would like to see.  You can even check compatibility between the two of you!';
    echo '</div>';
  
  if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
    unset ($_SESSION["errors"]);
    show_birth_info_form_custom($errors=$errors, $sao=1, $title="", $action="cast_chart.php", $stage=2);  //changed to _custom so I could style Custom Page
  }
  else {
    show_birth_info_form_custom($errors=array(), $sao=0, $title="", $action="cast_chart.php", $stage=2); //changed to _custom so I could style Custom Page
  }
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

    if (isset($_GET["text_type"])) {
      $text_type = $_GET["text_type"];
    }
    else { 
      $text_type = "2";
    }  
  
    $gotothe = "?the_page=" . $the_page . "&the_left=" . $the_left . "&results_type=" . $results_type . "&text_type=" . $text_type . "&tier=2";

  
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
      show_compare_results ($score = $total_score, $goto=$gotothe, $results_type=$results_type, $text_type=$text_type, $stage = $_GET["stage"]);
      switch ($results_type) {
      case "major": 
        show_major_connections ($compare_data=$_SESSION["compare_data"], $text_type=$text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        break;
      case "minor": 
        show_minor_connections ($compare_data=$_SESSION["compare_data"], $text_type=$text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        break;
      case "bonus": 
        show_bonus_connections ($compare_data=$_SESSION["compare_data"], $text_type=$text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
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
      $chart_id2 = $chart["chart_id"];
      $chart_to_cast_from = $chart;
      if (!single_click_cast ("Alternate_Freebie1", $chart_to_cast_from["birthday"], substr($chart_to_cast_from["latitude"], 0, 6), substr($chart_to_cast_from["longitude"], 0, 7), substr($chart_to_cast_from["latitude"], -1), substr($chart_to_cast_from["longitude"], -1), $chart_to_cast_from["timezone"], $chart_to_cast_from["DST"], $chart_to_cast_from["location"], $chart_to_cast_from["interval_time"], $chart_to_cast_from["time_unknown"], "W")) {
         echo 'Error Obtaining Western Chart';
      }
    }
  }
  else {
    $chart_id2 = $_GET["chart_id2"];
  }
  echo '<div id="profile_photo_and_info_custom">
        <div id="custom_nickname">Custom Chart</div>
          <div id="main_photo_box">
            <div id="border_wrapper">
              <div id="main_photo">
                <div class="fitter">
                  <img src="/img/Starma-Astrology-Large-Default-Pic-Female.png">
                </div>
              </div>
            </div>
          </div>
          </div>';

          //echo '<div class="profile_button_custom compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2">Compare<span class="div_link"></span></a></div>';

          //REDESIGN
          echo '<div class="profile_button compare_button">
              <select onchange="location = this.options[this.selectedIndex].value;">
                <option value="">Choose Compatiblity Test</option>
                <option value="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Romance</option>
                <option value="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=2&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Friends</option>
              </select>
            </div>';

          //************---Matt adding jquery popup from Message button
        echo '<div class="profile_button_custom invite_button"><a href="#" id="msg_pop">Invite This Person<span class="div_link"></span></a></div>';
        echo '<div id="msg_sheen" class="pop">';
    
          echo '<div id="msg_sheen_screen" class="pop">';
    
            echo '</div>';
              echo '<div id="msg_sheen_content_custom" class="pop">';
                echo '<div id="msg_type_area">';
                  echo '<form id="send-message-area" action="invite_new_user.php" method="POST">
                          <label for="email" id="email_label">Email Address</label>
                          <input type="text" value="" id="email_invite" name="email" />
                          <label for="msg_sendie" id="msg_label">New Message</label>
                          <textarea id="msg_sendie" name="text_body" maxlength = "500" >Hi there!' . PHP_EOL;  
                          echo get_my_nickname() . ' would like to invite you to join Starma.com.  Starma is a...</textarea>
                          <input type="submit" name="submit" value="Send" class="msg_send"/>
                          <button type="button" name="cancel" class="msg_cancel_invite">Cancel</button>
                          <input type="hidden" value=' . get_my_user_id() . ' name="other_user_id"/>                         
                        </form>';
                      echo '<span id="msg_sent"></span>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
        //***********---endMatt Stuff

          echo '<div id="profile_nav">
          <ul>
            <li><a class="' . $chart_selected . '" href="?the_left=nav3&the_page=cosel&tier=4&western=0&section=chart_selected">Birth Chart</a></li>';
            echo '<li><a class="' . $houses_selected . '" href="?the_page=cosel&the_left=nav3&tier=4&western=0&section=houses_selected">Houses</a></li>';   
            echo '<li class="end"><a class="' . $western_selected . '" href="?the_page=cosel&the_left=nav3&tier=4&chart_id2=' . $chart_id2 . '&western=1&section=western_selected">Western View</a></li>';
          echo '</ul>
        </div>';

          echo '<div id="profile_sections_custom">';
      
        echo '<div id="section">';
          if ($section == 'chart_selected') {
            require('chart_others.php');
          }
          elseif ($section == 'houses_selected') {
            require('houses_others.php');
          }
          elseif ($section == 'western_selected') {
            require('chart_others.php');
          }
        echo '</div>';
      echo '</div>';
  //require("chart_others.php");
}

echo '</div>';
echo "<script type='text/javascript' src='js/ajax_chart_submit.js'></script>";
echo "<script type='text/javascript' src='js/ajax_invite_new_user.js'></script>";
echo "<script type='text/javascript' src='js/msg_popup.js'></script>";

}    
            
                           
            
 

?> 
