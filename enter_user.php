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

  if(isset($_SESSION['alternate_chart_gender'])) {
    $alt_gender = $_SESSION['alternate_chart_gender'];
    if ($alt_gender == "M") {
      $gender = "Male";
    }
    else {
      $gender = "Female";
    }
  }
  else {
    $gender = "Female";
  }

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
    echo '<div class="later_on" style="font-size: 1.3em; line-height:1.3; padding: 20px 100px; text-align: center;">';
      echo 'Enter the birth information of a friend or family member to view their Birth Chart and see your compatibility.';
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
    if(isset($_GET['from_profile'])) {
      clear_compare_data();
    }
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
      //switch ($results_type) {
      //case "major": 
    echo '<div id="section>">';
      echo '<div id="compare">'; 
        show_major_connections ($compare_data=$_SESSION["compare_data"], $text_type=$text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        //break;
      //case "minor": 
        show_minor_connections ($compare_data=$_SESSION["compare_data"], $text_type=$text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        //break;
      //case "ruler": 
        show_rp_connections ($compare_data=$_SESSION["compare_data"], $text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        //break;
      //case "bonus": 
        show_bonus_connections ($compare_data=$_SESSION["compare_data"], $text_type=$text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
        //break; 
    echo '</div>'; //close #compare
  echo '</div>'; //close #section           
      //}    
      // If we're comparing to a Freebie Chart ////
      //if (is_freebie_chart($chart["chart_id"])) {
        //echo '<div class="profile_button custom_chart_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&tier=4&chart_id2=' . $chart["chart_id"] . '">View This Person\'s Chart</a></div>';
      //}
      /////////////////////////////////////////////
    }
    else {
      show_birth_info_form_custom($errors=array("Failed to Retrieve User Entered Chart"), $sao=0, $title="", $action="cast_chart.php", $stage=2);
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

  echo '<div id="img_preloader">
  <img src="/img/Starma-Astrology-Compare-ButtonON.png"/> 
  <img src="/img/hl_nav_icon_1ON.png"/>
  <img src="/img/hl_nav_icon_2ON.png"/>
  <img src="/img/hl_nav_icon_3ON.png"/>
  <img src="/img/hl_nav_icon_4ON.png"/>
  <img src="/img/hl_nav_icon_5ON.png"/>
  <img src="/img/hl_nav_icon_6ON.png"/>
  <img src="/img/hl_nav_icon_7ON.png"/>
  <img src="/img/hl_nav_icon_8ON.png"/>
  <img src="/img/hl_nav_icon_9ON.png"/>
  <img src="/img/hl_nav_icon_10ON.png"/>
  <img src="/img/hl_nav_icon_11ON.png"/>
  <img src="/img/hl_nav_icon_12ON.png"/>

  <img src="/img/houseIcon_1.png"/>
  <img src="/img/houseIcon_2.png"/>
  <img src="/img/houseIcon_3.png"/>
  <img src="/img/houseIcon_4.png"/>
  <img src="/img/houseIcon_5.png"/>
  <img src="/img/houseIcon_6.png"/>
  <img src="/img/houseIcon_7.png"/>
  <img src="/img/houseIcon_8.png"/>
  <img src="/img/houseIcon_9.png"/>
  <img src="/img/houseIcon_10.png"/>
  <img src="/img/houseIcon_11.png"/>
  <img src="/img/houseIcon_12.png"/>
  
  <img src="/img/palanquin_1.png" />
  <img src="/img/palanquin_2.png" />
  <img src="/img/palanquin_3.png" />
  <img src="/img/palanquin_4.png" />
  <img src="/img/palanquin_5.png" />
  <img src="/img/palanquin_6.png" />
  <img src="/img/palanquin_7.png" />
  <img src="/img/palanquin_8.png" />
  <img src="/img/palanquin_9.png" />
  <img src="/img/palanquin_10.png" />
  <img src="/img/palanquin_11.png" />
  <img src="/img/palanquin_12.png" />
  </div>';

echo '<div id="profile_top_bar">';
  echo '<div id="profile_photo_and_info_custom">
        <div id="custom_nickname">Custom Chart</div>
          <div id="main_photo_box">
            <div id="border_wrapper">
              <div id="main_photo">
                <div class="fitter">
                  <img src="/img/Starma-Astrology-Large-Default-Pic-' . $gender . '.png">
                </div>
              </div>
            </div>
          </div>
          </div>';

          //echo '<div class="profile_button_custom compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2">Compare<span class="div_link"></span></a></div>';

          //REDESIGN
          echo '<div class="profile_button compare_button">';
            echo '<div style="position:relative; top:32px; left:5px; text-align:center;">';
              if (!get_my_chart()) {
                echo '<a href="#" title="Compare" class="no_chart">Compare<span class="div_link"></span></a>';
              }
              else {
                echo '<a href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $chart_id2 . '&from_profile=true">Compare<span class="div_link"></span></a>';
              }
            echo '</div>';
            /*
            echo '<div id="compare_menu"><a href="">Compare</a>';
              echo '<div class="dropdown">';
                echo '<ul>';
                  echo '<li><a href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=2&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $chart_id2 . '&from_profile=true">As Friends</a></li>';
                  echo '<li><a style="border-bottom:1px solid black;" href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $chart_id2 . '&from_profile=true">Romantically</a></li>';
                echo '</ul>';
              echo '</div>';
            echo '</div>';
            */
           echo '</div>'; //close compare button

          //************---Matt adding jquery popup from Message button
        echo '<div class="profile_button_custom invite_button"><a href="#" id="pop_invite">Invite to Starma<span class="div_link"></span></a></div>';
        


        echo '</div>';  //close profile_top_bar
        //***********---endMatt Stuff

          echo '<div id="profile_nav">
          <ul>
            <li><a class="' . $chart_selected . '" href="?the_left=nav3&the_page=cosel&tier=4&western=0&section=chart_selected">Birth Chart</a></li>';
            echo '<li><a class="' . $houses_selected . '" href="?the_page=cosel&the_left=nav3&tier=4&western=0&section=houses_selected">House Lords</a></li>';   
            echo '<li class="end"><a class="' . $astrologers_view_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left .'&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=4&section=astrologers_view_selected">Astrologers View</a></li>';
            //echo '<li class="end"><a class="' . $western_selected . '" href="?the_page=cosel&the_left=nav3&tier=4&chart_id2=' . $chart_id2 . '&western=1&section=western_selected">Western View</a></li>';
          echo '</ul>
        </div>';

          echo '<div id="profile_sections_custom">';
      
        echo '<div id="section">';
          if ($section == 'chart_selected') {
            require('chart_others.php');
          }
          elseif ($section == 'houses_selected') {
            require('houses.php');
            //echo '<div style="height:300px;">Coming Soon...</div>';
          }
          elseif ($section == 'astrologers_view_selected') {
            require ('astrologers_view.php');
          }
          //elseif ($section == 'western_selected') {
          //  require('chart_others.php');
          //}
        echo '</div>';
      echo '</div>';
  //require("chart_others.php");
}

echo '</div>';
echo "<script type='text/javascript' src='js/ajax_chart_submit.js'></script>";
echo '<script type="text/javascript" src="js/ajax_hl_submit.js"></script>';

}    
            
                           
            
 

?> 
