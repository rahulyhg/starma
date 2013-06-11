<?php 

   require_once ("header.php");
   //require_once ("db_connect.php");
  
   if (login_check_point($type="partial", $domain=$domain)) { 

   if (isset($_POST["submit"])) {
     if (!$_POST["hour_time"]) {
       $birthtime = "000000";
       $_POST["hour_time"] = "12";
       $_POST["minute_time"] = "00";
       $_POST["second_time"] = "00"; 
       $_POST["meridiem_time"] = "am";
       $_POST["interval"] = "-1";
     }
     $_POST["hour_time"] = apply_meridiem ($_POST["hour_time"], $_POST["meridiem_time"]);
     store_chart_input_vars();
     $sao = $_POST["sao"];
     $errors = array();
     $interval = $_POST["interval"];
     $method = "E"; // EASTERN CHART
     if (!$time_unknown = $_POST["time_unknown"]) {
       $time_unknown = 0;
     }
     
     $longitude = combine_long_pieces ($_POST["c2d"], $_POST["c2m"], $_POST["c2s"]);
     $latitude = combine_pieces ($_POST["c1d"], $_POST["c1m"], $_POST["c1s"]);
     $LoDir = $_POST["LoDir"];
     $LaDir = $_POST["LaDir"];
     $timezone = $_POST["timezone"];
     $daylight = $_POST["daylight"];
     if ((string)$_POST["stage"] == "2" or isset($_SESSION["change_info"]) or permissions_check ($req = 10)) { //IF COMING FROM ENTERING ANOTHER USERS INFO OR CHANGING YOUR OWN OR YOURE AN ADMIN
       
       $birthday = combine_pieces ($_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday']);
       //echo '*' . $birthday . '*<br>';
       $birthday = substr ($birthday, 0, 4) . '-' . substr ($birthday, 4, 2) . '-' . substr ($birthday, 6, 2);
       //echo '*' . $birthday . '*<br>';
       $birthday = strtotime($birthday);
       //print_r ($birthday);
       //die();
     }
     else {
       $birthday = strtotime(get_my_birthday());
       
     }
     //print_r ($birthday);
     //die();
     //echo $POST_["hour_time"] . '<br>';
     
     //else {
     $birthtime = combine_pieces ($_POST["hour_time"], $_POST["minute_time"], $_POST["second_time"]);
     //}
     $title = "Not Typed In";
     if (trim($_POST['address']) != '') {
      
        if ($coords = get_coordinates(exceptionizer ($location_string = $_POST["address"]))) {
          //echo '*' . $lat .'*';
          $lat = reformat_coordinate($coords['lat'], 'lat');
          $lng = reformat_coordinate($coords['lng'], 'lng');
          $title = $coords['title'];
          //echo $title; die();
          $latitude = $lat[1];
          $longitude = $lng[1];
          $LoDir = $lng[0];
          $LaDir = $lat[0];
          $timezone_object = timezone($coords['lat'], $coords['lng']);
          $timezone = abs((float)$timezone_object["offset"]);
          $daylight = DST($timezone_id = $timezone_object["tID"], $date = date("m/d/Y", $birthday));  
          $sao = 0;
        } 
        else {
          
          $error = 'Place of Birth not found.  Please make sure the spelling is correct or enter information manually.';
          $errors[] = $error;
        }
        
     }
     //ERROR CHECKING GOES HERE, ALSO NONE OF THOSE FIELDS ARE PERSISTING
     elseif ($sao == 0){
       
       $error = 'If you leave "Place of Birth" empty, you must manually enter longitude and latitude coordinates.';
       $errors[] = $error;
     }
  
     //echo $latitude . '<br>';
     //echo $longitude . '<br>';
    // echo $timezone . '<br>';
    // echo $title . '<br>';
    // print_r ($birthday);
    // echo date("m/d/Y", $birthday) . '<br>';
     if ($sao == 1) {
       if (trim($_POST["c1d"]) == "" and trim($_POST["c2d"]) == "") {
         $error = 'If you leave "Place of Birth" empty, you must manually enter longitude and latitude coordinates.';
         $errors[] = $error;  
       }
       if (trim($_POST["timezone"]) == "") {
         $error = 'If you leave "Place of Birth" empty, you must enter valid timezone.';
         $errors[] = $error;  
       }
       if (trim($_POST["daylight"]) == "") {
         $error = 'If you leave the address empty, you must specify whether or not daylight savings time was in effect at this date/time';
         $errors[] = $error;  
       }
       if (trim($_POST["LoDir"]) == "") {
         $error = 'If you leave "Place of Birth" empty, you must specify a longitudinal direction.';
         $errors[] = $error;  
       }
       if (trim($_POST["LaDir"]) == "") {
         $error = 'If you leave "Place of Birth" empty, you must specify a latitudinal direction.';
         $errors[] = $error;  
       }
     }
     //if (illegal_latitude($latitude)) {
     //  $error = 'We sorry, but locations that have Latitudes above 60 degrees (North or South) are currently incompatibile with our chart casting program.  Click here for more info.';
     //  $errors[] = $error;
     //} 

     if (sizeof($errors) == 0) {
       if ((string)$interval != '0') {
         $return_vars1 = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "lower", $method); 
         $return_vars2 = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "higher", $method);
         
         //die();
       }
       else {
         $return_vars = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "NA", $method); 
         
         //die();
       }
       if ((string)$_POST["stage"] == "2" or (isAdmin() and isset($_SESSION["proxy_user_id"]))) { //IF COMING FROM ENTERING ANOTHER USERS INFO OR ADMIN CASTING SOMEONE ELSES CHART 
         
         //LOG THE ACTION, SET THE NAME FOR THE CHART, AND SET THE RETURN URL
         if ((string)$_POST["stage"] == "2") { //USER CUSTOM CHART CASTING
           log_this_action (compare_action_custom(), cast_basic_action());
           $chart_to_cast = "Freebie1";
           $user_id = get_my_user_id();
           $url=get_domain() . custom_chart_url() . "&tier=4";
           $url_failed=get_domain() . custom_chart_url() . "&tier=4&consol=failed"; 
         }
         else { //ADMIN CASTING ANOTHER'S CHART
           //log_this_action (compare_action_custom(), cast_basic_action()); //<- MAKE A LOG ACTION FOR AN ADMIN CASTING A CHART
           $chart_to_cast = "Main";
           $user_id = $_SESSION["proxy_user_id"];
           $url=get_domain() . "/admin/edit_profile.php?user_id=" . $user_id;
           $url_failed=get_domain() . "/admin/edit_profile.php?consol=failed&user_id=" . $user_id;
         }
         if ((string)$interval != '0') {
           save_secondary_chart ($return_vars1, $title, $birthtime, $url, false, $the_nickname="lowBound", $interval, $time_unknown, $method);
           save_secondary_chart ($return_vars2, $title, $birthtime, $url, false, $the_nickname="highBound", $interval, $time_unknown, $method);
           if (consolidateCharts ("lowBound","highBound", $user_id, $chart_to_cast,$interval)) {
             //log_this_action (compare_action_custom(), cast_basic_action()); 
             do_redirect ($url);
           }
           else {
             do_redirect ($url_failed);
           }
           
         }
         else {
           
           save_secondary_chart ($return_vars, $title, $birthtime, $url, true, $chart_to_cast, $interval, $time_unknown, $method);
           
           
         }
         
         
       }
       elseif (get_my_chart_id()) { //IF UPDATING YOUR BIRTH INFO
         //Log the Action
         log_this_action (chart_action(), cast_basic_action());
         if ((string)$interval != '0') {
           $_SESSION["return_vars"] = $return_vars1;
           $_SESSION["return_vars2"] = $return_vars2;

           
         }
         else {
           $_SESSION["return_vars"] = $return_vars;
 
          
         }
         $_SESSION["title"] = $title;
         $_SESSION["birthtime"] = $birthtime;
         $_SESSION["interval"] = $interval;
         $_SESSION["time_unknown"] = $time_unknown;
         $_SESSION["method"] = $method;
         do_redirect ($url=get_domain() . "/main.php?the_left=nav5&the_page=csel");
       }
       
       else {
         //Log the Action
         log_this_action (chart_action(), cast_basic_action());
         echo '<div id="initial_confirm_form">';
           if ((string)$interval != '0') {
        
               confirm_form($return_vars1, $title, $birthtime, $return_vars2, $interval, $time_unknown, $method);
           }
           else {
               $return_vars2 = 0;
               
               confirm_form($return_vars, $title, $birthtime, $return_vars2, $interval, $time_unknown, $method);
           }
           
         echo '</div>';
       }
     }
     else {
       if ((string)$_POST["stage"] == "2") { //IF COMING FROM ENTERING ANOTHER USERS INFO
         $_SESSION["errors"] = $errors;
         do_redirect ($url=get_domain() . custom_chart_url());
       }
       elseif (get_my_chart_id()) { //IF UPDATING YOUR BIRTH INFO
         $_SESSION["errors"] = $errors;
         do_redirect ($url=get_domain() . "/main.php?the_left=nav5&the_page=csel");
       }
       elseif (isAdmin()) { //IF ADMIN CASTING ANOTHER CHART
         $_SESSION["errors"] = $errors;
         do_redirect ($url=get_domain() . "/admin/edit_profile.php?user_id=" . $_SESSION["proxy_user_id"]);
       }
       else {
         //require ("birth_info_first_time.php");
         show_birth_info_form($errors = $errors, $sao=1, $title=$title);   
       }
       
     } 
    
   }
   else {
     do_redirect( $url = get_domain() . '/' . get_landing());
    // header( 'Location: http://www.' . $domain . '/' . $landing);
   }
 

   }
  
?>