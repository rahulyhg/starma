<?php 

 require_once ("header.php");
 //require_once ("db_connect.php");

  if (!permissions_check ($req = 10)) {
    header( 'Location: http://www.' . $domain . '/underconstruction.php');
  }  
  else {

  display_my_chart_list();
  date_default_timezone_set('America/Chicago'); 

  echo '<table border="1" cellpadding=10><th colspan=2>Test Form';
  if (isLoggedIn()) {
    echo '<span style="color:red"> - Welcome <b>' . $_SESSION['username'] . '!</b></span>';
  }
  echo '</th><tr valign="top">
  <td>';
  
  cast_chart();
  if (isset($_POST["submit"])) {

      if (trim($_POST['address']) != '') {
        $found = true;
        if (!($coords = geocode ($_POST["address"],$type='postalCodeSearch?placename'))) {
          if (!($coords = geocode ($_POST["address"], $type='wikipediaSearch?q'))) {
            $found = false;
          }
          else {
            echo 'Using Wikipedia lookup... ' . '<br>';
          }
        }
        else {
          echo 'Using postal code lookup... ' . '<br>';
        }
        if ($found) {
          $lat = reformat_coordinate($coords['lat'], 'lat');
          $lng = reformat_coordinate($coords['lng'], 'lng');
          $latitude = $lat[1];
          $longitude = $lng[1];
          $LoDir = $lng[0];
          $LaDir = $lat[0];
        }
        else { // this implementation is redundant (See same code within the parent "IF statement), BUT it saves on Geoname requests by not having to query the server for blank requests
          echo 'Invalid Location String Entered.  Defaulting to Coordinates Entered..<Br>';
          $longitude = combine_long_pieces ($_POST["c2d"], $_POST["c2m"], $_POST["c2s"]);
          $latitude = combine_pieces ($_POST["c1d"], $_POST["c1m"], $_POST["c1s"]);
          $LoDir = $_POST["LoDir"];
          $LaDir = $_POST["LaDir"];
        }
      }
      else {
        $longitude = combine_long_pieces ($_POST["c2d"], $_POST["c2m"], $_POST["c2s"]);
        $latitude = combine_pieces ($_POST["c1d"], $_POST["c1m"], $_POST["c1s"]);
        $LoDir = $_POST["LoDir"];
        $LaDir = $_POST["LaDir"];
      }

      $sTime = combine_pieces ($_POST["t1h"], $_POST["t1m"], $_POST["t1s"]);
      $uTimeResultArray = apply_timezone($_POST["timezone"], $LoDir, apply_daylight($_POST["daylight"], $sTime, "false"), "false");
    
      
      
      //echo 'Test Birthday.  THE FOLLOWING IS HARDCODED!  01/01/1901 when put into the PHP date function yields: ' . date("F j, Y", mktime (0, 0, 0, 1, 1, 1901)) . '<br>';
      $birthdate = mktime (0, 0, 0, (int) $_POST["d1m"], (int) $_POST["d1d"], (int) $_POST["d1y"]);
  
      echo 'Born: ' . format_as_time($sTime) . ' on ' . date("F j, Y",$birthdate);
      echo '<br>';
       
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

      echo 'tCorrection: *' . $tCorrection . '*';
      echo '<br>';
      
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

      
    
      echo 'Universal Time: ' . format_as_time($uTime)  . ' on ' . date("F j, Y",$greenwichdate);
      echo '<br>';
      echo 'Universal Greenwich Rounded Time: ' . format_as_time($uTimeRounded)  . ' on ' . date("F j, Y", $greenwichDatetimeRounded);
      echo '<br>';     

      $ephemdate = mktime (0, 0, 0, date("m", $birthdate), date("d", $birthdate)+$eTimeResultArray[0]+$uTimeResultArray[0], date("Y", $birthdate));
   
      echo 'Ephemeris Time: ' . format_as_time($eTime)  . ' on ' . date("F j, Y",$ephemdate);
      echo '<br>';

      //$gsTime00 = combine_pieces ($_POST["t3h"], $_POST["t3m"], $_POST["t3s"]);

      $gsTime00Q = gsTime ($greenwichdate);
      $gsTime00 = format_whole_time (remove_letters ($gsTime00Q["greenwich_sidereal_time"]));
      
      echo 'Greenwich Sidereel Time 00h: ' . format_as_time($gsTime00);
      echo '<br>';

      //$ssCorrection = combine_pieces ($_POST["t4h"], $_POST["t4m"], $_POST["t4s"]);
      
      $ssCorrectionQ = ssCorrection ($uTimeRounded);
      $ssCorrection = format_whole_time (remove_letters ($ssCorrectionQ["correction"]));
      
      echo 'Solar-Sidereal Correction: ' . $ssCorrection; 
      echo '<br>';

      $piece = time_add ($uTime, $gsTime00);
      $gsTime = time_add ($piece, $ssCorrection);

      if ($LaDir == 'South') {
        $gsTime = time_add ($gsTime, '120000');
      }

      
 

      $lcDegrees = combine_pieces ((string) floor(get_long_degrees ($longitude) / 15), (string) (4*(get_long_degrees ($longitude) % 15)), "00");
      $minutes = get_long_minutes (coordinate_long_round ($longitude));
      $lcMinutes = combine_pieces ("00", (string) floor($minutes / 15), (string) (4*($minutes % 15)));
      
      echo 'Longitude Correction Degrees: ' . $lcDegrees;
      echo '<br>';
      echo 'Longitude Correction Minutes: ' . $lcMinutes;
      echo '<br>';
      
      $lCorrection = time_add ($lcDegrees, $lcMinutes);      
      
      $lsTimeResultArray = correct_longitude ($lCorrection, $LoDir, $gsTime);
      $lsTime = $lsTimeResultArray[1];

   
      echo 'Greenwich Sidereel Time: ' . format_as_time($gsTime);
      echo '<br>';           

      $lsdate = mktime (0, 0, 0, date("m", $greenwichdate), date("d", $greenwichdate)+$lsTimeResultArray[0], date("Y", $greenwichdate) );
   
      echo 'Local Sidereel Time: ' . format_as_time($lsTime)  . ' on ' . date("F j, Y",$lsdate); 
      echo '<br>'; 
  
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

      

      echo 'Earlier LST: ' . $eLST . '<br>';
      echo 'Later LST: ' . $lLST . '<br>';
      echo 'LST Increment: ' . $LSTInc . '<br>';
      echo '<br>';
      echo 'Lower Latitude: ' . $lowerLat . '<br>';
      echo 'Higher Latitude: ' . $higherLat . '<br>';
      echo 'Latitude Increment: ' . $latInc . '<br>';

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

      echo 'LOWER LATITUDE ASCENDANT POSITION<br>';
 
      echo 'House Cusp at Later LST: ' . $lowerLatAscLater . '<br>';
      echo 'House Cusp at Earlier LST: ' . $lowerLatAscEarlier . '<br>';
      echo 'House Cusp Interval: ' . $lowerCuspInterval . '<br>';

      echo 'Percent of Time Increment: ' . $percentOfTimeInc . '<br>';
      echo 'Distance Ascendant Traveled during the Interval: ' . $lowerAscOffset . '<br>';
      echo '<b>Ascendant\'s Position at the Lower Latitude: ' . $lowerAscPosition . ' ' . $lowerAscSign . '</b><br>';
      echo '<br>';

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
   
      echo 'HIGHER LATITUDE ASCENDANT POSITION<br>';

      echo 'House Cusp at Later LST: ' . $higherLatAscLater . '<br>';
      echo 'House Cusp at Earlier LST: ' . $higherLatAscEarlier . '<br>';
      echo 'House Cusp Interval: ' . $higherCuspInterval . '<br>';

      echo 'Percent of Time Increment: ' . $percentOfTimeInc . '<br>';
      echo 'Distance Ascendant Traveled during the Interval: ' . $higherAscOffset . '<br>';
      echo '<b>Ascendant\'s Position at the Higher Latitude: ' . $higherAscPosition . ' ' . $higherAscSign . '</b><br><br>';


    
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
     
      $resultAscArray = Ayanamsafy (date("Y", $greenwichdate), $AscPosition, $AscSign);

      $resultAsc = $resultAscArray[0];
      $AscSign = $resultAscArray[1];
      
      $finalAscArray = coordinate_sign_reducto ($resultAsc);
      $finalAsc = $finalAscArray[1];
      $finalSign = sign_code_arithmetic ($AscSign, $finalAscArray[0]);
      
      if ($LaDir == 'South') {
        $finalSign = sign_code_arithmetic ($AscSign, 6);
      }

      echo 'Ascendant Position at Higher Lat: ' . $higherAscPosition . ' ' . $higherAscSign . '</b><br>';
      echo 'Ascendant Position at Lower Lat:' . $lowerAscPosition . ' ' . $lowerAscSign . '</b><br>';
      echo 'Ascendant Interval: ' . $CoordInterval . '<br>';
      echo 'Percent of Latitude Increment: ' . $percentOfCoordInc . '<br>';
      echo 'Distance Ascendant Traveled during the Interval: ' . $AscOffset . '<br>';
      echo 'Ascentants\' Position Before Ayanamsa: ' . $AscPosition . '<br>';
      echo 'Ayanamsa: ' . ayanamsa (date("Y", $greenwichdate)) . '<br>';
      echo '<b>Ascendant\'s Exact Position at Birth place/time: ' . $finalAsc . ' ' . $finalSign . '</b><br>';

      //echo $timeInc . '<br>';
      //echo $LSTIncSeconds . '<br>';        

      for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
        echo '<br>';
        $planetArray = PlanetForm ($longitude, $eTime, $greenwichdate, $poi_id);
        $pos_var_name = 'planet_' . $poi_id . '_position';
        $sign_var_name = 'planet_' . $poi_id . '_sign';
        $$pos_var_name = $planetArray[0];
        $$sign_var_name = $planetArray[1];
      }
       

      echo '<form name="formx" action="save_chart.php" method="post">';
      // A MILLION FORM VARIABLES GO HERE TO STORE CHART
      //echo '*' . (int) $_POST["t1h"] . '*';

      if ($LaDir == 'South') {
        $LaDirAdd = 'S';
      }
      else {
        $LaDirAdd = 'N';
      }

      if ($LoDir == 'West') {
        $LoDirAdd = 'W';
      }
      else {
        $LoDirAdd = 'E';
      }
 
      echo '<input type="hidden" name="birthdate" value="' . combine_pieces ($_POST["d1y"], $_POST["d1m"], $_POST["d1d"]) . '"/>'; 
      echo '<input type="hidden" name="birthtime" value="' . combine_pieces ($_POST["t1h"], $_POST["t1m"], $_POST["t1s"]) . '"/>'; 
      echo '<input type="hidden" name="longitude" value="' . $longitude . $LoDirAdd . '"/>'; 
      echo '<input type="hidden" name="latitude" value="'. $latitude . $LaDirAdd . '"/>'; 
      echo '<input type="hidden" name="DST" value="' . $_POST["daylight"] . '"/>'; 
      echo '<input type="hidden" name="timezone" value="' . $_POST["timezone"] . '"/>';    

      echo '<input type="hidden" name="asc_coord" value="' . $finalAsc . '"/>';
      echo '<input type="hidden" name="asc_sign_id" value="' . get_sign_id($finalSign) . '"/>';
   
      for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
        
        
          $pos_var_name = 'planet_' . $poi_id . '_position';
          $sign_var_name = 'planet_' . $poi_id . '_sign';
        
  
          echo '<input type="hidden" name="' . $pos_var_name . '" value="' . $$pos_var_name . '"/>'; 
          echo '<input type="hidden" name="' . $sign_var_name . '" value="' . $$sign_var_name . '"/>'; 
      } 
    
      echo '<input type="text" name="chart_name" value=""/>';
      echo '<input type="submit" name="submit" value="Save This Chart"/>';
      echo '</form>';
  }
  
   
  echo '</td>
  </tr></table>';
  
  
}

require_once ("footer.php");
?>