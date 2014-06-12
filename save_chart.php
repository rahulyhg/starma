<?php

 require_once ("header.php");

if (isLoggedIn())
{
  
    if (isset($_POST['submit']))
    {
      if ($_POST['submit'] == "My Place of Birth is Incorrect") {
        if (get_my_chart_id()) { // IF UPDATING YOUR BIRTH INFO
          do_redirect ($url=get_domain() . "/main.php?the_left=nav4&the_page=psel");
        }
        else {
          //show_birth_info_form();
          require ("birth_info_first_time.php");
        }
      }
      else {
        // FORMAT ALL THE VARIABLES
        $nickname = $_POST["chart_name"];
        $birthdate = $_POST["birthdate"];
        $birthtime = $_POST["birthtime"];
        $longitude = $_POST["longitude"];
        $latitude = $_POST["latitude"];
        $DST = $_POST["DST"];
        $timezone = $_POST["timezone"];
        $asc_coord = $_POST["asc_coord"];
        $asc_sign_id = $_POST["asc_sign_id"];
        $location = $_POST["address"];
        if (isset($_POST["personal"])) {
          $personal = $_POST["personal"];
        }
        else {
          $personal = 0;
        }

        

        //debug vars
        echo $birthdate . '<br>';
        echo $birthtime . '<br>';

        $birthdatetime = substr ($birthdate, 0, 4) . '-' . substr ($birthdate, 4, 2) . '-' . substr ($birthdate, 6, 2) . ' ' . format_piece (get_hours ($birthtime)) . ':' . format_piece (get_minutes($birthtime)) . ':' . format_piece (get_seconds ($birthtime));

        echo $birthdatetime . '<br>';
        
        $poi_array = array();
        for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
          $pos_var_name = 'planet_' . $poi_id . '_position';
          $sign_var_name = 'planet_' . $poi_id . '_sign';
          
          $poi_stats = array($_POST[$pos_var_name], $_POST[$sign_var_name]);
          
          $poi_array[$poi_id] = $poi_stats;
  
        } 

        // get the variables for the 2nd chart if we're consolidating, and do so
        if ((string)$_POST["interval"] != '0') {
          $asc_coord2 = $_POST["asc_coord2"];
          $asc_sign_id2 = $_POST["asc_sign_id2"];
          $poi_array2 = array();
          for ($poi_id2 = 2; $poi_id2 <= 10; $poi_id2++) {
            $pos_var_name2 = 'planet_' . $poi_id2 . '_position2';
            $sign_var_name2 = 'planet_' . $poi_id2 . '_sign2';
            
            $poi_stats2 = array($_POST[$pos_var_name2], $_POST[$sign_var_name2]);
           
            $poi_array2[$poi_id2] = $poi_stats2;
  
          }
          //echo 'asc_sign_id - lower:' . $asc_sign_id . '<br>' . ' *** asc_sign_id - higher:' . $asc_sign_id2;
          //die();
          //print_r ($poi_array2); die();
          store_chart_by_sign("lowBound", $birthdatetime, $longitude, $latitude, $DST, $timezone, $asc_coord, $asc_sign_id, $location, $poi_array, 0, $_POST["interval"], $_POST["time_unknown"], "E");               
          store_chart_by_sign("highBound", $birthdatetime, $longitude, $latitude, $DST, $timezone, $asc_coord2, $asc_sign_id2, $location, $poi_array2, 0, $_POST["interval"], $_POST["time_unknown"], "E");
          consolidateCharts ("lowBound","highBound", get_my_user_id(), "Main", $_POST["interval"]);
        }
        // otherwise just store the chart as normal
        else {
   

          if (store_chart_by_sign($nickname, $birthdatetime, $longitude, $latitude, $DST, $timezone, $asc_coord, $asc_sign_id, $location, $poi_array, $personal, $_POST["interval"], $_POST["time_unknown"], "E")) {
            //echo date('Y-m-d H:i:s', $birthdatetime);
            //Log the Action
            log_this_action (chart_action(), confirm_basic_action());
            echo 'Storage Successful!';
          }
          else {
            echo 'Storage Failed!';
          }
                    
        }
        echo "<br>end";
        unset($_SESSION["change_info"]);
        echo 'User ID: *' . $_SESSION["user_id"] . '*';

        single_click_cast ("Alternate", $birthdatetime, substr($latitude, 0, 6), substr($longitude, 0, 7), substr($latitude, -1), substr($longitude, -1), $timezone, $DST, $location, $_POST["interval"], $_POST["time_unknown"], "W");

        do_redirect( $url = get_domain() . '/' . get_landing());
      }
      
        
    } else
    {
        // User is not logged in and has not pressed the login button
        // so we show him the loginform
        show_loginform();
    }
 
} else
{
    // The user is already loggedin, so we show the userbox.
    //show_userbox();
    do_redirect( $url = get_domain() . '/' . get_landing());
    //header( 'Location: http://' . $domain . '/index.php');

}
?> 
