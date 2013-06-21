<?php 
function apply_meridiem ($the_hour, $the_meridiem) {
    $new_time = "00";
    if ((int)$the_hour == 12) {
      $new_time = "00";
    }
    else {
      $new_time = $the_hour;
    }
    if ($the_meridiem == "pm") {
      $new_time = ((int)$new_time) + 12;
    }
    return (string) $new_time;
}

function unapply_meridiem($the_hour) {
    $the_meridiem = "am";
    if ((int)$the_hour >= 12) {
      $the_hour = ((int) $the_hour) - 12;
      $the_meridiem = "pm";
    }
    
    if ($the_hour == "00" || $the_hour == 0) {
       $the_hour = "12";  
    }
    $result_array = array ((string)$the_hour, $the_meridiem);
    return $result_array;
}


function apply_my_timezone($timestamp) {
  
  $hour_mod = (($_SESSION["timezoneOffset"] / 60) - 6) * -1;
  $timestamp = $timestamp + (60 * 60 * $hour_mod);
  //echo date("m/d/Y H:i:s", $timestamp) . '******' . $hour_mod . '******' . $_SESSION["timezoneOffset"] . '%%%%%%' . $_SESSION["user_id"];
  return $timestamp;
}


function chat_date ($timestamp) { 

    $date = date('d/m/Y', $timestamp);
    $display_date = date('F j', $timestamp);
    //echo $date . '******' . date('d/m/Y H:i:s');
    if($date == date('d/m/Y', apply_my_timezone(time()))) {
      $display_date = 'Today';
    } else if($date == date('d/m/Y',apply_my_timezone(time() - (24 * 60 * 60)))) {
      $display_date = 'Yesterday';
    }
    return $display_date;
}

function planetForm ($longitude, $eTime, $the_date, $POIID, $method) {
  $the_datePlus = mktime (0, 0, 0, date("m", $the_date), date("d", $the_date)+1, date("Y", $the_date));

  if ($POIID == 10) {
    $newPOIID = 9;
  }
  else {
    $newPOIID = $POIID; 
  }

  $LongAfter = getPOIPosition ($the_datePlus, $newPOIID);
  $LongBefore = getPOIPosition ($the_date, $newPOIID);

  //echo 'Longitude After: ' . $LongAfter . '<br>';
  //echo 'Longitude Before: ' . $LongBefore . '<br>';

  $LongAfterPosition = poiPositionToSignCoord($LongAfter);
  $LongBeforePosition = poiPositionToSignCoord($LongBefore);

  

  $LongAfterSign = get_poiPosition_sign ($LongAfter);
  $LongBeforeSign = get_poiPosition_sign ($LongBefore);

  $POIInterval = coordinate_subtract ($LongAfterPosition, $LongBeforePosition);


  //echo '24-Hour Travel: ' . $POIInterval . '<br>';

  $retrograde = 1;

  if ($LongBeforePosition > $LongAfterPosition) {
      if ($LongBeforeSign != $LongAfterSign) {
        $POIInterval = coordinate_subtract ('300000', $POIInterval);
      }
      else {
        $retrograde = -1;
      }
  }

  //echo 'Retrograde: ' . $retrograde . '<br>';

  $DayInSeconds = time_down_to_seconds ('240000');
  $EphemTimeInSeconds = time_down_to_seconds ($eTime);
 
  $PercentOfInterval = $EphemTimeInSeconds / $DayInSeconds;

  //echo 'Percent of Interval: ' . $PercentOfInterval . '<br>';

  $POIIntervalInSeconds = (float) coord_down_to_seconds ($POIInterval);
 
  $POIPositionOffsetInSeconds = $PercentOfInterval * $POIIntervalInSeconds;

  $POIPositionOffset = up_to_coord ($POIPositionOffsetInSeconds);

  //echo 'POI Position Offset: ' . $POIPositionOffset . '<br>';

  if ($retrograde > 0) {
    $POIPosition = coordinate_add ($LongBeforePosition, $POIPositionOffset);
  }
  else {
    $POIPosition = coordinate_subtract ($LongBeforePosition, $POIPositionOffset);
  }

  //echo 'POI Position Before Ayanamsafy: ' .$POIPosition . '<br>';
  
  $finalSign = $LongBeforeSign;

  $resultPOIArray = Ayanamsafy (date("Y", $the_date), $POIPosition, $finalSign, $method);

  $resultPOIPosition = $resultPOIArray[0];
  $resultPOISign = $resultPOIArray[1];
  
  

  $finalPOIArray = coordinate_sign_reducto ($resultPOIPosition);
  $finalPOIPosition = $finalPOIArray[1];
  $finalPOISign = sign_code_arithmetic ($resultPOISign, $finalPOIArray[0]);
 
  if ($POIID == 10) {  // KETU
     $finalPOISign = sign_code_arithmetic ($finalPOISign, 6);
  }
  

  //echo '<b>' . get_POI_name ($poi_id = $POIID) .  '\'s Exact Position at Birth place/time: ' . $finalPOIPosition . ' ' . $finalPOISign . '</b><br>';
  return array($finalPOIPosition, get_sign_id($finalPOISign));

}

function get_country ($country_id) {
  $q = 'SELECT * from country WHERE country_id = ' . (int)$country_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  $result = mysql_fetch_array($do_q);
  return $result;
}

function DST ($timezone_id, $date) {
    $timezone = new DateTimeZone($timezone_id);
      
    $transitions = $timezone->getTransitions();
    //print_r(array_slice($transitions, 0));

    $loopDate = new DateTime($transitions[0]["time"]);
    $birthDate = new DateTime ($date);
    $counter = 1;
    while ($loopDate < $birthDate and $counter < sizeof($transitions)) {
      $loopDate = new DateTime($transitions[$counter]["time"]);
      $counter++;
    }
    if ($loopDate < $birthDate) {
      $found_transition_DST = $loopDate = $transitions[$counter-1]["isdst"];
    }
    else {
      if ($counter == 1) {
        $found_transition_DST = 0;
      }
      else {
        $found_transition_DST = $loopDate = $transitions[$counter-2]["isdst"];
      }
    }
    if ($found_transition_DST != 1) {
      $DST = 0;
    }
    else {
      $DST = 1;
    }
    return $DST;
}

function timezone($lat, $lng) {     

   
  $url = "http://ws.geonames.net/timezone?lat=" . $lat . "&lng=" . $lng . "&username=starma&token=mydoghasfleas";

  //echo $url;
  
  $timezone = array('offset' => 0, 'tID' => '');
  $delay = 0; 
  
  $timezone_pending = true; 
  $counter = 0;
 
  while($counter < 20 and $timezone_pending) 
  { 
    try 
    { 
      $xml_feed_url = $url;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $xml_feed_url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $prexml = curl_exec($ch);
      //echo '*' . $prexml . '*';
      if ($xml = produce_XML_object_tree($prexml)) {
        $timezone_pending = false;
        
      }
      // handle timeout responses and delay re-execution of finding the timezone
      else
      { 
        $timezone_pending = true;
        $delay += 100000;  
      }
      //echo '*' . $xml . '*';
      curl_close($ch);
      //$xml = simplexml_load_file($url); 
    } 
    catch(Exception $e) 
    { 
    // return an empty array for a file request exception
      echo $e; 
      return array(); 
    } 
    
    //get response status 

    
    
    $timezone["offset"] = $xml->timezone->rawOffset;  
    $timezone["tID"] = $xml->timezone->timezoneId;
     
    
    usleep($delay); 
    $counter = $counter + 1;
  } 
  return $timezone;   

} 
 
function geocode($address, $type) 
{ 
  $address = urlencode($address); 
  $url = "http://ws.geonames.net/$type=$address&username=starma&token=mydoghasfleas&maxRows=10"; 
  //echo $url;
  $coords = array('lat' => 0, 'lng' => 0, 'title' => ''); 
  $delay = 0; 
  
  $geocode_pending = true; 
  $counter = 0;
  
  // load file from url 
  while($counter < 20 and $geocode_pending) 
  { 
    try 
    { 
      $xml_feed_url = $url;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $xml_feed_url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $prexml = curl_exec($ch);
      //echo '*' . $prexml . '*';
      if ($xml = produce_XML_object_tree($prexml)) {
        $geocode_pending = false;
        
      }
      // handle timeout responses and delay re-execution of finding the timezone
      else
      { 
        $geocode_pending = true;
        $delay += 100000;  
      }
      //echo '*' . $xml . '*';
      curl_close($ch);
      //$xml = simplexml_load_file($url); 
    } 
    catch(Exception $e) 
    { 
    // return an empty array for a file request exception
      echo $e; 
      return array(); 
    } 
    
    //get response status 

    //echo $url;
    if ($type=='wikipediaSearch?q') {
      $empty_list = !isset($xml->entry);
      $entry_list = $xml->entry;
    }
    else { //use postalCodeSearch
      $empty_list = !isset($xml->code);
      $entry_list = $xml->code;
      //echo $empty_list;
    }
    if (!$empty_list) {
      $field_counter = 0;
      $coords['lat'] = $entry_list[0]->lat;  
      $coords['lng'] = $entry_list[0]->lng;
      if ($type=='wikipediaSearch?q') {
        $title = $entry_list[0]->title . ', ' . $entry_list[0]->countryCode;
      }
      else {
        $title = $entry_list[0]->name . ', ' . $entry_list[0]->adminCode1;
        
      }
      $country = $entry_list[0]->countryCode;
      $coords['title'] = $title;  
      $coords['country'] = $country;
      //while (strtolower (substr($title,0,1)) != strtolower (substr($address,0,1)) and $field_counter < sizeof($xml->entry)) {
        //echo '*' . strtolower (substr ($title,0,1)) . '*';
        //$coords['lat'] = $entry_list[$field_counter]->lat;  
        //$coords['lng'] = $entry_list[$field_counter]->lng;
        //if ($type=='wikipediaSearch?q') {
        //  $title = $entry_list[0]->title . ', ' . entry_list[0]->countryCode;
        // }
        //else {
        //  $title = $entry_list[0]->name . ', ' . $entry_list[0]->adminCode1;
        //}
        //$coords['title'] = $title;
      //  $field_counter = $field_counter + 1;
      //}
    }
    else {
      return false;
    }
    
     
    
    usleep($delay); 
    $counter = $counter + 1;
  } 
  return $coords;   
} 

function produce_XML_object_tree($raw_XML) {
    libxml_use_internal_errors(true);
    try {
        $xmlTree = new SimpleXMLElement($raw_XML);
    } catch (Exception $e) {
        // Something went wrong.
        $error_message = 'SimpleXMLElement threw an exception.';
        foreach(libxml_get_errors() as $error_line) {
            $error_message .= "\t" . $error_line->message;
        }
        trigger_error($e);
        return false;
    }
    return $xmlTree;
}

function get_coordinates ($address) {
  $found = false;
  if ($coords = geocode ($address,$type='postalCodeSearch?placename')) {
    $found = true;
  }
  
  if ($coords["country"] <> 'US') {
    $found = false;}
  if (!($found)) {
    if ($coords = geocode ($address, $type='wikipediaSearch?q')) {
      $found = true;}
  }
  if ($found) {
    return $coords;
  }
  else {
    return false;
  }
}


function poiPositionToSignCoord ($pp) {
  return format_piece (get_sign_degrees($pp)) . format_piece (get_minutes($pp)) . '00';
}

function get_poiPosition_sign ($pp) {
  $sign_code = substr ($pp, 4, 2);
  return $sign_code;
}

  
function get_month_id ($month_name) {
  $q = 'SELECT month_id from month WHERE month_name = "' . $month_name . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["month_id"];
  }
  else {
    return false;
  }
}

function get_month_name ($month_id) {
  $q = 'SELECT month_name from month WHERE month_id = ' . $month_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["month_name"];
  }
  else {
    return false;
  }
}


function get_day_of_week_id ($day_of_week_name) {
  $q = 'SELECT day_of_week_id from day_of_week WHERE day_of_week_name = "' . $day_of_week_name . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["day_of_week_id"];
  }
  else {
    return false;
  }
}

function get_day_of_week ($day_of_week_id) {
  $q = 'SELECT day_of_week_name from day_of_week_name WHERE day_of_week_id = ' . $day_of_week_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["day_of_week_name"];
  }
  else {
    return false;
  }
}

function get_hours ($time) {
  if ($hours = (int) substr ($time, 0, 2)) {
    return $hours;
  }
  else {
     
    return false;
  }
  
}

function get_minutes ($time) {
  if ($mins = (int) substr ($time, 2, 2)) {
    return $mins;
  }
  else {
     return false;
  }
  
}

function get_seconds ($time) {
  if ($secs = (int) substr ($time, 4, 2)) {
    return $secs;
  }
  else {
     return false;
  }
  
}


function get_sign_degrees ($time) {
  if ($hours = (int) substr ($time, 0, 2)) {
    return $hours;
  }
  else {
     return false;
  }
  
}

function get_sign_minutes ($time) {
  if ($mins = (int) substr ($time, 2, 2)) {
    return $mins;
  }
  else {
     return false;
  }
  
}

function get_sign_seconds ($time) {
  if ($secs = (int) substr ($time, 4, 2)) {
    return $secs;
  }
  else {
     return false;
  }
  
}

function get_long_degrees ($coord) {
  if ($degrees = (int) substr ($coord, 0, 3)) {
    return $degrees;
  }
  else {
     return false;
  }
  
}

function get_long_minutes ($coord) {
  if ($mins = (int) substr ($coord, 3, 2)) {
    return $mins;
  }
  else {
     return false;
  }
  
}

function get_long_seconds ($coord) {
  if ($secs = (int) substr ($coord, 5, 2)) {
    return $secs;
  }
  else {
     return false;
  }
  
}

function get_country_list () {
  $q = 'SELECT * from country';
  $do_q = mysql_query ($q) or die(mysql_error());
  return $do_q;  
}



function remove_letters ($target) {
  $target = str_replace ("h", "", $target);
  $target = str_replace ("m", "", $target);
  $target = str_replace ("s", "", $target);
  $target = str_replace ("d", "", $target);
  return $target;
}

function exceptionizer ($location_string) {
  if (strtoupper($location_string) == "MEXICO CITY, MX" or $location_string == "MEXICO CITY, MEXICO" or $location_string == "MEXICO CITY MEXICO") {
    $location_string = "Ciudad de Mexico, MX";
  }
  return $location_string;
}
?>
