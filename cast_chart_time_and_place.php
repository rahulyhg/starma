<?php
	require_once ("header.php");

	//if(isset($_POST['submit'])) {
  if(isLoggedIn()) {
    //echo 'hello';
		$error = 0;

		//$country_id = $_POST['country_id'];
    //$_SESSION['country_id'] = $_POST['country_id'];
    if ($_POST['country_id'] == 0) {
      $error = 1;
      unset($_SESSION['country_id']);
      //do_redirect( get_domain() . '/sign_up.php?3&error=1');
    }
    else{
      $country_id = $_POST['country_id'];
      $c = get_country($country_id);
      $country_code = $c['country_code'];
      echo 'country_code: ' . $country_code . '<br>';
    }
    if ($_POST['city'] == '') {
      $error = 2;
      unset($_SESSION['city']);
      //do_redirect( get_domain() . '/sign_up.php?3&error=2');
    }
		else{
			$city = trim($_POST['city']);
      $_SESSION['city'] = $_POST['city'];
		}

		if (isset($_POST['zip'])) {
			$zip = trim($_POST['zip']);
      $_SESSION['zip'] = $_POST['zip'];
		}
    else {
    	$zip = '';
  	}	

    if ($country_id !== 236) {
      $location = $city . ', ' . $country_code;
    }
    else {
      $location = $city;
    }

    //if ($address == '') {
    //  $error = 4;
      //do_redirect( get_domain() . '/sign_up.php?3&error=4');
    //}


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
     	//$sao = $_POST["sao"];   //????
     	$interval = $_POST["interval"];
     	$_SESSION['alternate_chart_gender'] = $_POST["gender"];
     	$method = "E"; // EASTERN CHART
      $personal = 1;
      $time_unknown = $_POST['time_unknown'];

     	//if (!$time_unknown = $_POST["time_unknown"]) {
      // 		$time_unknown = 0;
      //}

       echo 'country_id: ' . $country_id . '<br>zip: ' . $zip . '<br>city: ' . $city . '<br>session city: ' . $_SESSION['city'] . '<br>address: ' . $address . '<br>personal: ' . $personal . '<br>interval: ' . $interval . '<br>time_unknown: ' . $time_unknown;

     	if (isset($_POST['manual'])) {
     		$longitude = combine_long_pieces ($_POST["c2d"], $_POST["c2m"], $_POST["c2s"]);
     		$latitude = combine_pieces ($_POST["c1d"], $_POST["c1m"], $_POST["c1s"]);
     		$LoDir = $_POST["LoDir"];
     		$LaDir = $_POST["LaDir"];
     		$timezone = $_POST["timezone"];
     		$daylight = $_POST["daylight"];
     	}
      /*
      $from = 'tp';
     	if ($coords = parse_location_string($country_id, $zip, $city, $from)) {
        
        if(isset($coords['country_id'])) {
          $error = 1;
        }
        //elseif (isset($coords['zip'])) {
        //  $error = 2;
        //}
        elseif (isset($coords['city'])) {
          $error = 2;
        }
        //elseif (isset($coords['geocode_zip'])) {
        //  $error = 4;
        //}
        elseif (isset($coords['geocode_city'])) {
          $error = 3;
        }
        */
        if (!$coords = get_coordinates(exceptionizer ($location))) {
          $error = 3;
          //do_redirect( get_domain() . '/sign_up.php?3&error=3');
        }
        else {
          //print_r($coords);
     		  $lat = reformat_coordinate($coords['lat'], 'lat');
          $lng = reformat_coordinate($coords['lng'], 'lng');
          $title = $coords['title'];
          //echo $title; die();
          $latitude = $lat[1];
          $longitude = $lng[1];
          $LoDir = $lng[0];
          $LaDir = $lat[0];
          $birthday = get_my_birthday();
          $birthdate = combine_pieces (substr ($birthday, 0, 4), substr ($birthday, 5, 2), substr ($birthday, 8, 2));
          $birthtime = combine_pieces ($_POST["hour_time"], $_POST["minute_time"], $_POST["second_time"]);
          $birthdatetime = substr ($birthdate, 0, 4) . '-' . substr ($birthdate, 4, 2) . '-' . substr ($birthdate, 6, 2) . ' ' . format_piece (get_hours ($birthtime)) . ':' . format_piece (get_minutes($birthtime)) . ':' . format_piece (get_seconds ($birthtime));
          $strtotimebirthday = strtotime(get_my_birthday());
          $timezone_object = timezone($coords['lat'], $coords['lng']);
          $timezone = abs((float)$timezone_object["offset"]);
          $daylight = DST($timezone_id = $timezone_object["tID"], $date = date("m/d/Y", $strtotimebirthday));
     	  }
      
      echo '<br><br>birthday: ' . $birthday . '<br>birthtime: ' . $birthtime . '<br>time_unknown: ' . $time_unknown . '<br>longitude: ' . $longitude . '<br>latitude: ' . $latitude . '<br>LaDir: ' . $LaDir . '<br>LoDir: ' .  $LoDir . '<br>timezone: ' . $timezone . '<br>daylight: ' . $daylight;

      echo '<br><br>error: ' .  $error;

      if ($error !== 0) {
        do_redirect( get_domain() . '/sign_up.php?3&error=' . $error);
      }
      
      else {
        log_this_action (chart_action(), cast_basic_action());

        if ((string)$interval != '0') {
            $birthday = strtotime(get_my_birthday());
            $return_vars1 = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "lower", $method); 
            $return_vars2 = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "higher", $method);         
            //die();

            //echo '<br><br>return_vars1:<br><br>';
            //print_r($return_vars1);

            //echo '<br><br>return_vars2:<br><br>';
            //print_r($return_vars2);

            if ($return_vars1[2] == 'South') {
              $LaDirAdd = 'S';
            }
            else {
              $LaDirAdd = 'N';
            }

            if ($return_vars1[3] == 'West') {
              $LoDirAdd = 'W';
            }
            else {
              $LoDirAdd = 'E';
            }

            //echo '<br>' . $LaDirAdd . '<br>' .  $LoDirAdd;

            $pos_var_name_array = array();
            $sign_var_name_array = array();
            $pos_var_name_array2 = array();
            $sign_var_name_array2 = array();

            for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
            //echo '<br>';
              $planetArray = PlanetForm ($return_vars1[0], $return_vars1[8], $return_vars1[9], $poi_id, $method);
              $pos_var_name = 'planet_' . $poi_id . '_position';
              $sign_var_name = 'planet_' . $poi_id . '_sign';
              $pos_var_name_array[$poi_id] = $planetArray[0];
              $sign_var_name_array[$poi_id] = $planetArray[1];
            } 
            for ($poi_id2 = 2; $poi_id2 <= 10; $poi_id2++) {
              //echo '<br>';
              $planetArray2 = PlanetForm ($return_vars2[0], $return_vars2[8], $return_vars2[9], $poi_id2, $method);
              $pos_var_name2 = 'planet_' . $poi_id2 . '_position2';
              $sign_var_name2 = 'planet_' . $poi_id2 . '_sign2';
              $pos_var_name_array2[$poi_id2] = $planetArray2[0];
              $sign_var_name_array2[$poi_id2] = $planetArray2[1];
            }

            //echo '<br><br>pos_var_name_array<br><br>';
            //print_r($pos_var_name_array);

            //echo '<br><br>sign_var_name_array<br><br>';
            //print_r($sign_var_name_array);

            //echo '<br><br>pos_var_name_array2<br><br>';
            //print_r($pos_var_name_array2);

            //echo '<br><br>sign_var_name_array2<br><br>';
            //print_r($sign_var_name_array2);

            $longitude = $return_vars1[0] . $LoDirAdd; 
            $latitude = $return_vars1[1] . $LaDirAdd; 
            $DST = $return_vars1[4]; 
            $timezone = $return_vars1[5];    
            $asc_coord = $return_vars1[6];
            $asc_sign_id = $return_vars1[7];
            $asc_coord2 = $return_vars2[6];
            $asc_sign_id2 = $return_vars2[7];
            $location = $title; 

            //echo '<br><br><br>longitude: ' . $longitude . '<br>latitude: ' . $latitude . '<br>DST: ' . $DST . '<br>timezone: ' . $timezone . '<br>asc_coord: ' . $asc_coord . '<br>asc_sign_id: ' . $asc_sign_id . '<br>asc_coord2: ' . $asc_coord2 . '<br>asc_sign_id2: ' . $asc_sign_id2 . '<br>address: ' . $address;

            $poi_array = array();
            for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
              $pos_var_name = 'planet_' . $poi_id . '_position';
              $sign_var_name = 'planet_' . $poi_id . '_sign';
          
              $poi_stats = array($pos_var_name_array[$poi_id], $sign_var_name_array[$poi_id]);
          
              $poi_array[$poi_id] = $poi_stats;
  
            } 
            $poi_array2 = array();
            for ($poi_id2 = 2; $poi_id2 <= 10; $poi_id2++) {
              $pos_var_name2 = 'planet_' . $poi_id2 . '_position2';
              $sign_var_name2 = 'planet_' . $poi_id2 . '_sign2';
            
              $poi_stats2 = array($pos_var_name_array2[$poi_id2], $sign_var_name_array2[$poi_id2]);
           
              $poi_array2[$poi_id2] = $poi_stats2;
  
            }

            //echo '<br> poi_array<br>';

            //print_r($poi_array);

            //echo '<br><br> poi_array2<br><br>';

            //print_r($poi_array2);
  

          //SAVE CHART------------------------
            store_chart_by_sign("lowBound", $birthdatetime, $longitude, $latitude, $DST, $timezone, $asc_coord, $asc_sign_id, $location, $poi_array, 0, $interval, $time_unknown, "E");               
            store_chart_by_sign("highBound", $birthdatetime, $longitude, $latitude, $DST, $timezone, $asc_coord2, $asc_sign_id2, $location, $poi_array2, 0, $interval, $time_unknown, "E");
            consolidateCharts ("lowBound","highBound", get_my_user_id(), "Main", $interval);
            //echo 'Double Chart Stored';
        }
  //IF NO INTERVAL------------------------  
        else {
          $birthday = strtotime(get_my_birthday());
            $return_vars = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "NA", $method);          
            //die();

            //echo '<br><br>return_vars<br><br>';
            //print_r($return_vars);

            if ($return_vars[2] == 'South') {
              $LaDirAdd = 'S';
            }
            else {
              $LaDirAdd = 'N';
            }

            if ($return_vars[3] == 'West') {
              $LoDirAdd = 'W';
            }
            else {
              $LoDirAdd = 'E';
            }

            //echo '<br>' . $LaDirAdd . '<br>' .  $LoDirAdd;

            $pos_var_name_array = array();
            $sign_var_name_array = array();
            for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
            //echo '<br>';
              $planetArray = PlanetForm ($return_vars[0], $return_vars[8], $return_vars[9], $poi_id, $method);
              $pos_var_name = 'planet_' . $poi_id . '_position';
              $sign_var_name = 'planet_' . $poi_id . '_sign';
              $pos_var_name_array[$poi_id] = $planetArray[0];
              $sign_var_name_array[$poi_id] = $planetArray[1];
            } 

            //echo '<br><br>pos_var_name_array<br><br>';
            //print_r($pos_var_name_array);

            //echo '<br><br>sign_var_name_array<br><br>';
            //print_r($sign_var_name_array);

            $nickname = 'Main';
            $longitude = $return_vars[0] . $LoDirAdd; 
            $latitude = $return_vars[1] . $LaDirAdd; 
            $DST = $return_vars[4]; 
            $timezone = $return_vars[5];    
            $asc_coord = $return_vars[6];
            $asc_sign_id = $return_vars[7];
            $location = $title; 

            //echo '<br><br>' . 'nickname: ' . $nickname . '<br>longitude: ' . $longitude . '<br>latitude: ' . $latitude . '<br>DST: ' . $DST . '<br>timezone: ' . $timezone . '<br>asc_coord: ' . $asc_coord . '<br>asc_sign_id: ' . $asc_sign_id . '<br>address: ' . $address;

            $poi_array = array();
            for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
              $pos_var_name = 'planet_' . $poi_id . '_position';
              $sign_var_name = 'planet_' . $poi_id . '_sign';
          
              $poi_stats = array($pos_var_name_array[$poi_id], $sign_var_name_array[$poi_id]);
          
              $poi_array[$poi_id] = $poi_stats;
  
            } 

            //echo '<br><br>poi_array one chart<br><br>';
            //print_r($poi_array);

        //SAVE CHART--------------------------  
            store_chart_by_sign($nickname, $birthdatetime, $longitude, $latitude, $DST, $timezone, $asc_coord, $asc_sign_id, $location, $poi_array, $personal, $interval, $time_unknown, "E");
            //echo 'Single Chart Stored';
        }
    //WESTERN CHART-----------------------
      
      single_click_cast ("Alternate", $birthdatetime, substr($latitude, 0, 6), substr($longitude, 0, 7), substr($latitude, -1), substr($longitude, -1), $timezone, $DST, $location, $interval, $time_unknown, "W");
      
      //echo '<br>birthdatetime' . $birthdatetime . '<br><br>';

      //echo 'Western Chart Success';
      do_redirect( get_domain() . '/' . get_landing());
      //echo get_domain() . '/' . get_landing();
      }

	}
//IF SOMEHOW THIS PAGE IS REACHED WITHOUT SUBMITTING FORM
	else {
		do_redirect( get_domain() . '/sign_up.php?3');
	}

?>