<?php 
function get_star_rating ($score) {
  $rating = $score * 100;
  if ($rating >= 93.5) 
    return 5.0;
  elseif ($rating >= 89.5)
    return 4.75;
  elseif ($rating >= 86.5)
    return 4.5;
  elseif ($rating >= 83.5)
    return 4.25;
  elseif ($rating >= 81.5)
    return 4.0;
  elseif ($rating >= 79.5)
    return 3.75;
  elseif ($rating >= 77.5)
    return 3.5;
  elseif ($rating >= 75.5)
    return 3.25;
  elseif ($rating >= 73.5)
    return 3.0;
  elseif ($rating >= 71.5)
    return 2.75;
  elseif ($rating >= 69.5)
    return 2.5;
  elseif ($rating >= 67.5)
    return 2.25;
  elseif ($rating >= 65.5)
    return 2.0;
  elseif ($rating >= 63.5)
    return 1.75;
  elseif ($rating >= 61.5)
    return 1.5;
  elseif ($rating >= 59.5)
    return 1.25;
  elseif ($rating >= 57.5)
    return 1.0;
  elseif ($rating >= 54.5)
    return 0.5;
  else
    return 0.0;;
}

function calculate_age ($birthDate) {
  //explode the date to get month, day and year
  //echo $birthDate;
  $birthDate = explode("-", $birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[0]));
  return $age;
}

function apply_time_interval ($dir="lower", $interval, $sTime) {
  
  if ($dir == "lower") {
    if ((string)$interval == '-1') {
      return '000000';
    }
    else {
      if ($interval > $sTime) {
        return '000000';
      }
      else {
        $new_sTime = time_subtract ($sTime, format_whole_time ((string)$interval));
        return $new_sTime;
      }
    }
  }
  else {
    if ((string)$interval == '-1') {
      return '235959';
    }
    else {
      $new_sTime = time_add ($sTime, format_whole_time ((string)$interval));
      $new_sTime_array = time_reducto ($new_sTime);
      
      if ($new_sTime_array[0] != 0) {
        return '235959';
      }
      else {
        return $new_sTime;
      }
    }
  }
}


function calculate_chart ($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, $dir="lower", $method="E") {
      
      

      $sTime = combine_pieces (get_hours($birthtime), get_minutes($birthtime), get_seconds($birthtime));

      //apply interval for non-exact birthtimes and get the correct bound
     
      if ((string)$interval != '0') {
        $sTime = apply_time_interval($dir, $interval, $sTime); 
        //echo 'Chart Type:  ' . $dir . ', interval: ' . $interval . ', sTime: ' . $sTime . '<br>';
      }

      $uTimeResultArray = apply_timezone($timezone, $LoDir, apply_daylight($daylight, $sTime, "false"), "false");
    
      
      
      //echo 'Test Birthday.  THE FOLLOWING IS HARDCODED!  01/01/1901 when put into the PHP date function yields: ' . date("F j, Y", mktime (0, 0, 0, 1, 1, 1901)) . '<br>';
      //$birthdate = mktime (0, 0, 0, (int) $_POST["d1m"], (int) $_POST["d1d"], (int) $_POST["d1y"]);
      $birthdate = $birthday;
  
      //echo 'Born: ' . format_as_time($sTime) . ' on ' . date("F j, Y",$birthdate);
      //echo '<br>';
       
      //$uTimeResultArray = time_reducto ($uTime);
      $uTime = $uTimeResultArray[1];
      $greenwichdate = mktime (0, 0, 0, date("m", $birthdate), date("d", $birthdate)+$uTimeResultArray[0], date("Y", $birthdate) );   
      $greenwichDatetimeRounded = mktime (get_hours($uTime), get_minutes($uTime), round(get_seconds($uTime)/60) * 60, date("m", $greenwichdate), date("d", $greenwichdate), date("Y", $greenwichdate));
      $uTimeRounded = combine_pieces (date("H", $greenwichDatetimeRounded), date("i", $greenwichDatetimeRounded), date("s", $greenwichDatetimeRounded));

      //$tCorrection = combine_pieces ($_POST["t2h"], $_POST["t2m"], $_POST["t2s"]);
      //echo 'Greenwich Date: ' . date("Y", $greenwichdate);
      $tCorrectionQ = deltaT ((string) date("Y", $greenwichDatetimeRounded));
      $tCorrection = format_whole_time (remove_letters ($tCorrectionQ["correction"]));
      $tCorrectionSign = $tCorrectionQ["sign"];

      //echo 'tCorrection: *' . $tCorrection . '*';
      //echo '<br>';
      
      $eTimeDayCorrection = 0;

      if ($tCorrectionSign == -1) {
        $eTime = time_subtract ($uTime, $tCorrection);
        if ($tCorrections > $uTime) {
          $eTime = time_subtract ('240000', $eTime);
          $eTimeDayCorrection = -1;
        }         
      }
      else {
        $eTime = time_add ($uTime, $tCorrection);  
      }
      $eTimeResultArray = time_reducto ($eTime);
      $etime = $eTimeResultArray[1];
      $eTimeResultArray[0] = $eTimeResultArray[0] + $eTimeDayCorrection;
      //echo date ("F j, Y", mktime (0, 0, 0, 11, 15, 1952));

      
    
      //echo 'Universal Time: ' . format_as_time($uTime)  . ' on ' . date("F j, Y",$greenwichdate);
      //echo '<br>';
      //echo 'Universal Greenwich Rounded Time: ' . format_as_time($uTimeRounded)  . ' on ' . date("F j, Y", $greenwichDatetimeRounded);
      //echo '<br>';     

      $ephemdate = mktime (0, 0, 0, date("m", $birthdate), date("d", $birthdate)+$eTimeResultArray[0]+$uTimeResultArray[0], date("Y", $birthdate));
   
      //echo 'Ephemeris Time: ' . format_as_time($eTime)  . ' on ' . date("F j, Y",$ephemdate);
      //echo '<br>';

      //$gsTime00 = combine_pieces ($_POST["t3h"], $_POST["t3m"], $_POST["t3s"]);

      $gsTime00Q = gsTime ($greenwichdate);
      $gsTime00 = format_whole_time (remove_letters ($gsTime00Q["greenwich_sidereal_time"]));
      
      //echo 'Greenwich Sidereel Time 00h: ' . format_as_time($gsTime00);
      //echo '<br>';

      //$ssCorrection = combine_pieces ($_POST["t4h"], $_POST["t4m"], $_POST["t4s"]);
      
      $ssCorrectionQ = ssCorrection ($uTimeRounded);
      $ssCorrection = format_whole_time (remove_letters ($ssCorrectionQ["correction"]));
      
      //echo 'Solar-Sidereal Correction: ' . $ssCorrection; 
      //echo '<br>';

      $piece = time_add ($uTime, $gsTime00);
      $gsTime = time_add ($piece, $ssCorrection);

      if ($LaDir == 'South') {
        $gsTime = time_add ($gsTime, '120000');
      }

      
 

      $lcDegrees = combine_pieces ((string) floor(get_long_degrees ($longitude) / 15), (string) (4*(get_long_degrees ($longitude) % 15)), "00");
      $minutes = get_long_minutes (coordinate_long_round ($longitude));
      $lcMinutes = combine_pieces ("00", (string) floor($minutes / 15), (string) (4*($minutes % 15)));
      
      //echo 'Longitude Correction Degrees: ' . $lcDegrees;
      //echo '<br>';
      //echo 'Longitude Correction Minutes: ' . $lcMinutes;
      //echo '<br>';
      
      $lCorrection = time_add ($lcDegrees, $lcMinutes);      
      
      $lsTimeResultArray = correct_longitude ($lCorrection, $LoDir, $gsTime);
      $lsTime = $lsTimeResultArray[1];

   
      //echo 'Greenwich Sidereel Time: ' . format_as_time($gsTime);
      //echo '<br>';           

      $lsdate = mktime (0, 0, 0, date("m", $greenwichdate), date("d", $greenwichdate)+$lsTimeResultArray[0], date("Y", $greenwichdate) );
   
      //echo 'Local Sidereel Time: ' . format_as_time($lsTime)  . ' on ' . date("F j, Y",$lsdate); 
      //echo '<br>'; 
  
      $eLST = getLSTChunk ($lsTime, "earlier");    
      $lLST = getLSTchunk ($lsTime, "later");
      $LSTInc = time_subtract ($lsTime, $eLST);

      $lowerLat = get_sign_degrees($latitude);
      if ($lowerLat < 20) {
        while ($lowerLat % 5 != 0) {
          $lowerLat = $lowerLat - 1;
        }
        $higherLat = $lowerLat + 5;
      }
      else {
        if (get_sign_minutes ($latitude) == 0 and get_sign_seconds ($latitude) == 0) {
          $higherLat = $lowerLat;
        }
        else {
          $higherLat = $lowerLat + 1; 
        }
      }

      $latInc = coordinate_subtract ($latitude, $lowerLat);

      

      //echo 'Earlier LST: ' . $eLST . '<br>';
      //echo 'Later LST: ' . $lLST . '<br>';
      //echo 'LST Increment: ' . $LSTInc . '<br>';
      //echo '<br>';
      //echo 'Lower Latitude: ' . $lowerLat . '<br>';
      //echo 'Higher Latitude: ' . $higherLat . '<br>';
      //echo 'Latitude Increment: ' . $latInc . '<br>';

      $timeInc = (float) time_down_to_seconds ('000400');
      $LSTIncSeconds = (float) time_down_to_seconds ($LSTInc);
     

      //echo $timeInc . '<br>';
      //echo $LSTIncSeconds . '<br>';   
     
      $percentOfTimeInc = $LSTIncSeconds / $timeInc;

      // GET ASCENDANT'S POSITION AT THE *LOWER* LATITUDE

      $lowerLatAscLater = getAscPosition ($lowerLat, $lLST); 
      $lowerLatAscEarlier = getAscPosition ($lowerLat, $eLST);
      
      // echo '<br>**' . poiPositionToSignCoord($lowerLatAscLater) . ' - ' . poiPositionToSignCoord($lowerLatAscEarlier) . '**';  
 
      $lowerCuspInterval = coordinate_subtract (poiPositionToSignCoord($lowerLatAscLater), poiPositionToSignCoord($lowerLatAscEarlier));

      if (poiPositionToSignCoord($lowerLatAscEarlier) > poiPositionToSignCoord($lowerLatAscLater)) {
        $lowerCuspInterval = coordinate_subtract ('300000', $lowerCuspInterval);
      }
  
      $lowerAscOffsetInSeconds = $percentOfTimeInc * (float) coord_down_to_seconds ($lowerCuspInterval);
      $lowerAscOffset = up_to_coord ($lowerAscOffsetInSeconds);
      $lowerAscPosition = coordinate_add (poiPositionToSignCoord($lowerLatAscEarlier), $lowerAscOffset);

      $lowerAscSign = get_poiPosition_sign ($lowerLatAscEarlier);

      //echo 'LOWER LATITUDE ASCENDANT POSITION<br>';
 
      //echo 'House Cusp at Later LST: ' . $lowerLatAscLater . '<br>';
      //echo 'House Cusp at Earlier LST: ' . $lowerLatAscEarlier . '<br>';
      //echo 'House Cusp Interval: ' . $lowerCuspInterval . '<br>';

      //echo 'Percent of Time Increment: ' . $percentOfTimeInc . '<br>';
      //echo 'Distance Ascendant Traveled during the Interval: ' . $lowerAscOffset . '<br>';
      //echo '<b>Ascendant\'s Position at the Lower Latitude: ' . $lowerAscPosition . ' ' . $lowerAscSign . '</b><br>';
      //echo '<br>';

      // GET ASCENDANT'S POSITION AT THE *HIGHER* LATITUDE

     

      $higherLatAscLater = getAscPosition ($higherLat, $lLST); 
      $higherLatAscEarlier = getAscPosition ($higherLat, $eLST);
      $higherCuspInterval = coordinate_subtract (poiPositionToSignCoord($higherLatAscLater), poiPositionToSignCoord($higherLatAscEarlier));

      if (poiPositionToSignCoord($higherLatAscEarlier) > poiPositionToSignCoord($higherLatAscLater)) {
        $higherCuspInterval = coordinate_subtract ('300000', $higherCuspInterval);
      }

      $higherAscOffsetInSeconds = $percentOfTimeInc * (float) coord_down_to_seconds ($higherCuspInterval);
      // $higherAscOffsetArray = up_to_coord ($higherAscOffsetInSeconds);
      // $higherAscOffset = $higherAscOffsetArray[1];
      $higherAscOffset = up_to_coord ($higherAscOffsetInSeconds);
      $higherAscPosition = coordinate_add (poiPositionToSignCoord($higherLatAscEarlier), $higherAscOffset);

      $higherAscSign = get_poiPosition_sign ($higherLatAscEarlier);
   
      //echo 'HIGHER LATITUDE ASCENDANT POSITION<br>';

      //echo 'House Cusp at Later LST: ' . $higherLatAscLater . '<br>';
      //echo 'House Cusp at Earlier LST: ' . $higherLatAscEarlier . '<br>';
      //echo 'House Cusp Interval: ' . $higherCuspInterval . '<br>';

      //echo 'Percent of Time Increment: ' . $percentOfTimeInc . '<br>';
      //echo 'Distance Ascendant Traveled during the Interval: ' . $higherAscOffset . '<br>';
      //echo '<b>Ascendant\'s Position at the Higher Latitude: ' . $higherAscPosition . ' ' . $higherAscSign . '</b><br><br>';


    
      //USE ASCENDANT'S POSITION AT HIGHER AND LOWER LATITUDES TO DETERMINE *EXACT* ASCENDANT'S POSITION AT PLACE/TIME OF BIRTH
      if (get_sign_degrees($latitude) < 20) {
        $CoordInc = (float) coord_down_to_seconds ('050000');
      }
      else { 
        $CoordInc = (float) coord_down_to_seconds ('010000');
      }
      $LatIncInSeconds = (float) coord_down_to_seconds ($latInc);

      
      $percentOfCoordInc = $LatIncInSeconds / $CoordInc;


      $CoordInterval = coordinate_subtract ($higherAscPosition, $lowerAscPosition);  

      $retrograde = 1;

      if ($lowerAscPosition > $higherAscPosition) {
        if ($lowerAscSign != $higherAscSign) {
          $CoordInterval = coordinate_subtract ('300000', $CoordInterval);
          
        }
        else {
          $retrograde = -1;
        }
      }


      $CoordIntervalInSeconds = (float) coord_down_to_seconds ($CoordInterval);

      $AscOffsetInSeconds = $percentOfCoordInc * $CoordIntervalInSeconds;
      // $AscOffsetArray = up_to_coord ($AscOffsetInSeconds);
      // $AscOffset = $AscOffsetArray[1];
      $AscOffset = up_to_coord ($AscOffsetInSeconds);
      
      if ($retrograde > 0) {      
        $AscPosition = coordinate_add ($lowerAscPosition, $AscOffset);
      }
      else {
        $AscPosition = coordinate_subtract ($lowerAscPosition, $AscOffset); 
      }
      $AscSign = $lowerAscSign;
     
      $resultAscArray = Ayanamsafy (date("Y", $greenwichdate), $AscPosition, $AscSign, $method);

      $resultAsc = $resultAscArray[0];
      $AscSign = $resultAscArray[1];
      
      $finalAscArray = coordinate_sign_reducto ($resultAsc);
      $finalAsc = $finalAscArray[1];
      $finalSign = sign_code_arithmetic ($AscSign, $finalAscArray[0]);
      
      if ($LaDir == 'South') {
        $finalSign = sign_code_arithmetic ($AscSign, 6);
      }

      //echo 'Ascendant Position at Higher Lat: ' . $higherAscPosition . ' ' . $higherAscSign . '</b><br>';
      //echo 'Ascendant Position at Lower Lat:' . $lowerAscPosition . ' ' . $lowerAscSign . '</b><br>';
      //echo 'Ascendant Interval: ' . $CoordInterval . '<br>';
      //echo 'Percent of Latitude Increment: ' . $percentOfCoordInc . '<br>';
      //echo 'Distance Ascendant Traveled during the Interval: ' . $AscOffset . '<br>';
      //echo 'Ascentants\' Position Before Ayanamsa: ' . $AscPosition . '<br>';
      //echo 'Ayanamsa: ' . ayanamsa (date("Y", $greenwichdate)) . '<br>';
      //echo '<b>Ascendant\'s Exact Position at Birth place/time: ' . $finalAsc . ' ' . $finalSign . '</b><br>';

      //echo $timeInc . '<br>';
      //echo $LSTIncSeconds . '<br>';        

      
     
      return array($longitude, $latitude, $LaDir, $LoDir, $daylight, $timezone, $finalAsc, get_sign_id($finalSign), $eTime, $greenwichdate); 

}


function reformat_coordinate ($raw_coor, $type) {
  if ($raw_coor < 0) {
    if ($type == 'lat') {
      $dir = 'South';
    }
    else {
      $dir = 'West';
    }
    $raw_coor = (float) $raw_coor * -1;
  } 
  else {
    if ($type == 'lat') { 
      $dir = 'North';
    }
    else {
      $dir = 'East';
    }
  }
  
  $part_1 = floor($raw_coor);
  $dec_piece = (float)$raw_coor - $part_1;
  $part_2_dec = $dec_piece * 60;
  
  //echo $raw_coor . '<br>';
  //echo $part_1 . '<br>';
  //echo $dec_piece . '<br>';
  //echo $part_2_dec . '<br>';

  $part_2 = floor($part_2_dec);
  $dec_piece = $part_2_dec - $part_2;
  $part_3_dec = $dec_piece * 60;

  $part_3 = floor($part_3_dec);

  if ($type == 'lng') {
     $part_1 = format_piece_long_degrees ($part_1);
  }
  else {
     $part_1 = format_piece ($part_1);
  }

  
  //echo $part_2_dec . '<br>';
  //echo $part_3_dec . '<br>';

  $part_2 = format_piece ($part_2);
  $part_3 = format_piece ($part_2);

  $final = $part_1 . $part_2 . $part_3;
  return array ($dir, $final);
  
}

function Ayanamsafy ($year, $position, $sign, $method="E") {
      if ($method == "W"){
        $Ayanamsa = '000000';
      }
      else {
        $Ayanamsa = ayanamsa ($year);
      }
      //echo $Ayanamsa;
      $result = coordinate_subtract ($position, $Ayanamsa);
      //echo $Ayanamsa . '<br>';
      //echo $resultAsc . '<br>';

      if ($Ayanamsa > $position) {
        $result = coordinate_subtract ('300000', $result);
        $sign = sign_code_arithmetic ($sign, -1);
      }
      return array ($result, $sign);
}

function coord_down_to_seconds ($coord) {
  $degrees = get_sign_degrees ($coord);
  $minutes = get_sign_minutes ($coord);
  $seconds = get_sign_seconds ($coord);
  return ((($degrees*60)+$minutes)*60)+$seconds;
}

function time_down_to_seconds ($time) {
  $hours = get_hours ($time);
  $minutes = get_minutes ($time);
  $seconds = get_seconds ($time);
  return ((($hours*60)+$minutes)*60)+$seconds;
}

function up_to_coord ($total_seconds) {
  
  $seconds = round ($total_seconds % 60);
  $total_minutes = ($total_seconds / 60);
  $minutes = $total_minutes % 60;
  $total_degrees = ($total_minutes / 60);
  $degrees = ($total_degrees % 60);
  
  // return coordinate_sign_reducto (combine_pieces (format_piece ($degrees), format_piece ($minutes), format_piece ($seconds) ));
  return combine_pieces (format_piece ($degrees), format_piece ($minutes), format_piece ($seconds) );
}

function up_to_time ($total_seconds) {
  
  $seconds = round ($total_seconds % 60);
  $total_minutes = ($total_seconds / 60);
  $minutes = $total_minutes % 60;
  $total_hours = ($total_minutes / 60);
  $hours = ($total_hours % 60);
  
  // return coordinate_sign_reducto (combine_pieces (format_piece ($degrees), format_piece ($minutes), format_piece ($seconds) ));
  return combine_pieces (format_piece ($hours), format_piece ($minutes), format_piece ($seconds) );
}

function house_arithmetic ($house_id, $change) {
  
  $new_house_id = $house_id + $change;
  if ($new_house_id > 12) {
    $new_house_id = $new_house_id - 12;
  }
  elseif ($new_house_id <= 0) {
    $new_house_id = $new_house_id + 12; 
  }
  return $new_house_id;
}

function sign_code_arithmetic ($code, $change) {
  
  $new_sign_id = get_sign_id($code) + $change;
  if ($new_sign_id > 12) {
    $new_sign_id = $new_sign_id - 12;
  }
  elseif ($new_sign_id <= 0) {
    $new_sign_id = $new_sign_id + 12; 
  }
  return get_sign_code ($new_sign_id);
}

function coordinate_long_round ($c) {
  // ROUNDS TO NEAREST LOCATIONAL (LONG) MINUTE
  $degrees = (int) get_long_degrees ($c);
  $minutes = (int) get_long_minutes ($c);
  $seconds = (int) get_long_seconds ($c);
  if ($degrees != 180) {
    
    if ($seconds >= 30) {
      $minutes++;
      if ($minutes >= 59) {
       
         $minutes = $minutes - 60;
         $degrees++;
      }
    }
    $seconds == 0;
    
  }
  else {
    $seconds = 0;
    $minutes = 0;  
  }

  $seconds = (string) $seconds;
  $minutes = (string) $minutes;
  $degrees = (string) $degrees;
  
  $returnCoor = combine_long_pieces ($degrees, $minutes, $seconds);

  return $returnCoor;
}

function coordinate_lat_round ($c) {
  // ROUNDS TO NEAREST LOCATIONAL (LAT) MINUTE
  $degrees = (int) get_long_degrees ($c);
  $minutes = (int) get_long_minutes ($c);
  $seconds = (int) get_long_seconds ($c);
  if ($degrees != 60) {
    
    if ($seconds >= 30) {
      $minutes++;
      if ($minutes >= 59) {
       
         $minutes = $minutes - 60;
         $degrees++;
      }
    }
    $seconds == 0;
    
  }
  else {
    $seconds = 0;
    $minutes = 0;  
  }

  $seconds = (string) $seconds;
  $minutes = (string) $minutes;
  $degrees = (string) $degrees;
  
  $returnCoor = combine_pieces ($degrees, $minutes, $seconds);

  return $returnCoor;
}

function coordinate_sign_reducto ($c) {
  $degreesResult = get_sign_degrees($c);
  $signChange = 0;
  while ($degreesResult > 30) {
    $degreesResult -= 30;
    $signChange++;
  }

  while ($degreesResult < 0) {
    $degreesResult += 30;
    $signChange--;
  }

  $degreesResult = format_piece ($degreesResult);
  
  return array ($signChange, $degreesResult . substr ($c, 2, 4));
}


function coordinate_long_reducto ($c) {
  $degreesResult = get_long_degrees ($c);
  $signChange = 0;
  while ($degreesResult > 180) {
    $degreesResult = 360 - $degreeResult;
    $signChange++;
  }

  while ($degreesResult < 0) {
    $degreesResult = $degreeResult * -1;
    $signChange--;
  }

  $degreesResult = format_piece ($degreesResult);
  
  return array ($signChange, $degreesResult . substr ($c, 3, 4));
}

function coordinate_lat_reducto ($c) {
  $degreesResult = get_degrees ($c);
  $signChange = 0;
  if (!valid_lat($c)) {
    return false;
  }

  while ($degreesResult < 0) {
    $degreesResult = $degreeResult * -1;
    $signChange--;
  }

  $degreesResult = format_piece ($degreesResult);
  
  return array ($signChange, $degreesResult . substr ($c, 2, 4));
}

function valid_lat ($c) {
  $degreesResult = get_sign_degrees ($c);
  
  if ($degreesResult > 60) {
     return false;
  }

    
  return true;
}

function time_reducto ($t) {
  $hoursResult = substr ($t, 0, 2);
  $dayChange = 0;
  while ($hoursResult >= 24) {
    $hoursResult -= 24;
    $dayChange++;
  }

  while ($hoursResult < 0) {
    $hoursResult += 24;
    $dayChange--;
  }

  $hoursResult = format_piece ($hoursResult);

  return array ($dayChange, $hoursResult . substr ($t, 2, 4));
}

function coordinate_add ($c1, $c2) {
  // accepts 2 strings only!

  $degrees1 = (int) substr ($c1, 0, 2);
  $minutes1 = (int) substr ($c1, 2, 2);
  $seconds1 = (int) substr ($c1, 4, 2);
  
  $degrees2 = (int) substr ($c2, 0, 2);
  $minutes2 = (int) substr ($c2, 2, 2);
  $seconds2 = (int) substr ($c2, 4, 2);

  //add seconds

  $secondsResult = $seconds1 + $seconds2;
  while ($secondsResult >= 60) {
    $secondsResult -= 60;
    $minutes1++;
  }

  //add minutes

  $minutesResult = $minutes1 + $minutes2;
  while ($minutesResult >= 60) {
    $minutesResult -= 60;
    $degrees1++;
  }

  // add degrees

  $degreesResult = $degrees1 + $degrees2; // no reducing
  
  $secondsResult = (string) $secondsResult;
  $minutesResult = (string) $minutesResult;
  $degreesResult = (string) $degreesResult;   
 
  $returnCoor = combine_pieces ($degreesResult, $minutesResult, $secondsResult);

  return $returnCoor;
  
}

function coordinate_subtract ($c1, $c2) {
  // accepts 2 strings only!  Always subrtracts the smaller from the bigger

  if ((int) $c1 < (int) $c2) {  //if C2 is bigger, swap em
    $temp = $c1;
    $c1 = $c2;
    $c2 = $temp;
  }

  $degrees1 = (int) substr ($c1, 0, 2);
  $minutes1 = (int) substr ($c1, 2, 2);
  $seconds1 = (int) substr ($c1, 4, 2);
  
  $degrees2 = (int) substr ($c2, 0, 2);
  $minutes2 = (int) substr ($c2, 2, 2);
  $seconds2 = (int) substr ($c2, 4, 2);

  //subtract seconds

  $secondsResult = $seconds1 - $seconds2;
  while ($secondsResult < 0) {
    $secondsResult += 60;
    $minutes1--;
  }

  //subtract minutes

  $minutesResult = $minutes1 - $minutes2;
  while ($minutesResult < 0) {
    $minutesResult += 60;
    $degrees1--;
  }

  // subtract degrees

  $degreesResult = $degrees1 - $degrees2;
  
  $secondsResult = (string) $secondsResult;
  $minutesResult = (string) $minutesResult;
  $degreesResult = (string) $degreesResult;
  
 
  $returnCoor = combine_pieces ($degreesResult, $minutesResult, $secondsResult);
  
  return $returnCoor;
  
}

function coordinate_long_add ($c1, $c2) {
  // accepts 2 strings only!

  $degrees1 = (int) get_long_degrees ($c1);
  $minutes1 = (int) get_long_minutes ($c1);
  $seconds1 = (int) get_long_seconds ($c1);
  
  $degrees2 = (int) get_long_degrees ($c2);
  $minutes2 = (int) get_long_minutes ($c2);
  $seconds2 = (int) get_long_seconds ($c2);

  //add seconds

  $secondsResult = $seconds1 + $seconds2;
  while ($secondsResult >= 60) {
    $secondsResult -= 60;
    $minutes1++;
  }

  //add minutes

  $minutesResult = $minutes1 + $minutes2;
  while ($minutesResult >= 60) {
    $minutesResult -= 60;
    $degrees1++;
  }

  // add degrees

  $degreesResult = $degrees1 + $degrees2; // no reducing
  
  $secondsResult = (string) $secondsResult;
  $minutesResult = (string) $minutesResult;
  $degreesResult = (string) $degreesResult;   
 
  $returnCoor = combine_pieces ($degreesResult, $minutesResult, $secondsResult);

  return $returnCoor;
  
}

function coordinate_long_subtract ($c1, $c2) {
  // accepts 2 strings only!

  $degrees1 = (int) get_long_degrees ($c1);
  $minutes1 = (int) get_long_minutes ($c1);
  $seconds1 = (int) get_long_seconds ($c1);
  
  $degrees2 = (int) get_long_degrees ($c2);
  $minutes2 = (int) get_long_minutes ($c2);
  $seconds2 = (int) get_long_seconds ($c2);

  //subtract seconds

  $secondsResult = $seconds1 - $seconds2;
  while ($secondsResult < 0) {
    $secondsResult += 60;
    $minutes1--;
  }

  //subtract minutes

  $minutesResult = $minutes1 - $minutes2;
  while ($minutesResult < 0) {
    $minutesResult += 60;
    $degrees1--;
  }

  // subtract degrees

  $degreesResult = $degrees1 - $degrees2;
  
  $secondsResult = (string) $secondsResult;
  $minutesResult = (string) $minutesResult;
  $degreesResult = (string) $degreesResult;
  
 
  $returnCoor = combine_pieces ($degreesResult, $minutesResult, $secondsResult);
  
  return $returnCoor;
  
}

function time_add ($t1, $t2) {
  // accepts 2 strings only!

  $hours1 = (int) substr ($t1, 0, 2);
  $minutes1 = (int) substr ($t1, 2, 2);
  $seconds1 = (int) substr ($t1, 4, 2);
  
  $hours2 = (int) substr ($t2, 0, 2);
  $minutes2 = (int) substr ($t2, 2, 2);
  $seconds2 = (int) substr ($t2, 4, 2);


  //add seconds

  $secondsResult = $seconds1 + $seconds2;
  while ($secondsResult >= 60) {
    $secondsResult -= 60;
    $minutes1++;
  }

  //add minutes

  $minutesResult = $minutes1 + $minutes2;
  while ($minutesResult >= 60) {
    $minutesResult -= 60;
    $hours1++;
  }

  // add degrees

  $hoursResult = $hours1 + $hours2;
  
  
  $secondsResult = (string) $secondsResult;
  $minutesResult = (string) $minutesResult;
  $hoursResult = (string) $hoursResult;
  

  $returnTime = combine_pieces ($hoursResult, $minutesResult, $secondsResult);

  return $returnTime;
  
}

function time_subtract ($t1, $t2) {
  // accepts 2 strings only!  Always subtracts the smaller from the bigger

  if ((int) $t1 < (int) $t2) {  //if t2 is bigger, swap em
    $temp = $t1;
    $t1 = $t2;
    $t2 = $temp;
  }
  //echo 't1: ' . $t1 . '<br>';
  //echo 't2: ' . $t2 . '<br>';

/*
  $hours1 = (int) substr ($t1, 0, 2);
  $minutes1 = (int) substr ($t1, 2, 2);
  $seconds1 = (int) substr ($t1, 4, 2);

  
  $hours2 = (int) substr ($t2, 0, 2);
  $minutes2 = (int) substr ($t2, 2, 2);
  $seconds2 = (int) substr ($t2, 4, 2);


  //subtract seconds

  $secondsResult = $seconds1 - $seconds2;
  while ($secondsResult < 0) {
    $secondsResult += 60;
    $secondsResult = $secondsResult * -1;
    $minutes1--;
  }

  //subtract minutes

  $minutesResult = $minutes1 - $minutes2;
  while ($minutesResult < 0) {
    $minutesResult += 60;
    $minutesResult = $minutesResult * -1; 
    $hours1--;
  }

  // subtract hours

  $hoursResult = $hours1 - $hours2;
  
  $secondsResult = (string) $secondsResult;
  $minutesResult = (string) $minutesResult;
  $hoursResult = (string) $hoursResult;
  
  $returnTime = combine_pieces ($hoursResult, $minutesResult, $secondsResult);
*/
  $t1seconds = time_down_to_seconds ($t1);
  $t2seconds = time_down_to_seconds ($t2);

  //echo 't1seconds: ' . $t1seconds . ', t2seconds: ' . $t2seconds . '<br>';

  $resultseconds = $t1seconds - $t2seconds;
  
  $returnTime = up_to_time($resultseconds);
  
  //echo 'resultseconds: ' . $resultseconds . ', returnTime: ' . $returnTime . '<br>';  

  return $returnTime;
  
}

function apply_daylight ($dHours, $sTime) {
  $dHoursFormat = combine_pieces ($dHours, "00", "00");
  //echo 'Daylight: ' . $dHoursFormat . ', sTime: ' . $sTime . '<br>';
  $result = time_subtract ($sTime, $dHoursFormat);
  //echo "Result of that subtraction: " . $result . '<br>';
  $dSavingsDayCorrection = 0;
  if ($dHoursFormat > $sTime) {
    $finalsTime = time_subtract ($result, '240000');
    $dSavingsDayCorrection = -1;
  }
  else {
    $finalsTime = $result;
  }
  
  //echo 'Result of Daylight Subtraction: ' . $finalsTime . ' with a day-change of ' . $dSavingsDayCorrection . '<br>';
  return array($dSavingsDayCorrection, $finalsTime); 
}

function apply_timezone ($dHours, $LoDir, $sTimeArray, $reduce) {
  $sTime = $sTimeArray[1];
  $dSavingsDayCorrection = $sTimeArray[0];
  if (strpos ($dHours, '.')) {
    $dHoursFormat = combine_pieces ((string)floor($dHours), "30", "00"); 
  }
  else {
    $dHoursFormat = combine_pieces ($dHours, "00", "00");
  }
  $day = 0;
  if ($LoDir == "East") {
    $finalTime = time_subtract ($sTime, $dHoursFormat, $reduce);
    if ($dHoursFormat > $sTime) {
      $finalTime = time_subtract ('240000', $finalTime);
      $day = $day - 1;
    } 
  }
  else {
    $finalTime = time_add ($sTime, $dHoursFormat, $reduce); 
  }
  $resultTime = time_reducto($finalTime);
  $resultTime[0] = $resultTime[0] + $day + $dSavingsDayCorrection;
  return $resultTime;
}

function correct_longitude ($lCorrection, $LoDir, $gsTime) {
  $day = 0;
  if ($LoDir == "East") {
    $finalTime = time_add ($gsTime, $lCorrection);
  }
  else {
    $finalTime = time_subtract ($gsTime, $lCorrection); 
    if ($lCorrection > $gsTime) {
      $finalTime = time_subtract ('240000', $finalTime);
      $day = $day - 1;
    }
  }
  //echo $finalTime . '<br>';
  $resultTime = time_reducto($finalTime);
  //echo $resultTime[1] . '<br>';
  $resultTime[0] = $resultTime[0] + $day;
  return $resultTime;
}

function getLSTChunk ($time, $el) {
  if ($el == 'earlier') {
    while ( (get_minutes($time) % 4) != 0 or get_seconds($time) != 0 ) {
      $time = time_subtract ($time, '000001');
    }
  }
  else {
    while ( (get_minutes($time) % 4) != 0 or get_seconds($time) != 0) {
      $time = time_add ($time, '000001');
    }
  }
  return $time;
}

?>
