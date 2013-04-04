<?php 

 require_once ("../header.php");
  

 set_time_limit (0);

 $fp = @fopen('Table_of_Houses_Fin.csv', 'r');
 
 $lat_chart = array();
 $sideReal_array = array();
 $degrees_array = array();
 $placidus_table = array();

 
 if ($fp) {
   while ($line = fgets($fp)) {
      $pieceArray = explode (',',$line);
      $counter = 0; //number of segments;

      for ($i = 1; $i < sizeof($pieceArray); $i = $i+3) {
        if ($pieceArray[0] == 'Sidereal R') {
          $sideReal_hours = substr ($pieceArray[$i], 0, 2);
          $sideReal_minutes = substr ($pieceArray[$i+1], 0, 2);
          $sideReal_seconds = substr ($pieceArray[$i+2], 0, 2);
 
          $LST = combine_pieces ($sideReal_hours, $sideReal_minutes, $sideReal_seconds);
            

          $sideReal_array[$counter] = $LST;
 
          
          
        }
        else if ($pieceArray[0] == 'Degrees R') {
          $sideReal_degrees = substr ($pieceArray[$i], 0, 3);
          $sideReal_minutes = substr ($pieceArray[$i+1], 0, 2);
          $sideReal_seconds = substr ($pieceArray[$i+2], 0, 2);
 
          $degrees = combine_pieces ($sideReal_degrees, $sideReal_minutes, $sideReal_seconds);
 
          $degrees_array[$counter] = $degrees;          

          
          
        }
        else if ($pieceArray[0] != 'Lat Below') {
          $lat_degrees = substr ($pieceArray[$i], 0, 2);
          $lat_minutes = substr ($pieceArray[$i+1], 0, 2);
          $lat_sign =  strtoupper ($pieceArray[$i+2]);
           
          
          
          $risingPlace = format_piece($lat_degrees) . format_piece($lat_minutes) . $lat_sign; 
          
         // echo 'Size of Sidereal Array: ' .sizeof($sideReal_array);

          
          if (array_key_exists ($pieceArray[0], $placidus_table)) {
            $placidus_table[$pieceArray[0]][$sideReal_array[$counter]] = $risingPlace;
              
          }
          else {
              
            $placidus_table[$pieceArray[0]] = array ($sideReal_array[$counter] => $risingPlace);
              
          }
          //echo 'Table of Houses at ' . $pieceArray[0] . ' Latitude, ' . $sideReal_array[$counter] . ' Sidereal Time: ' . $placidus_table[$pieceArray[0]][$sideReal_array[$counter]] . '<br>';
            
          
          
        }
        $counter = $counter + 1;
      }
      
   }
 }
 else {
   echo 'File Not Found';
 }

 fclose ($fp); 

 //echo 'p' . $placidus_table[0]['010400'] . 'p';

 //Xfer the Structure to the database
 
 $num_inserts = 0;
 $num_updates = 0;

 for ($c = 0; $c < sizeof($sideReal_array); $c++) {
    echo $sideReal_array[$c];
    for ($l = 0; $l <= 60; $l = nextLat($l)) {
      if (relationship_there ($l, $sideReal_array[$c])) {
        update_rising ($l, $sideReal_array[$c], $placidus_table[$l][$sideReal_array[$c]]);
        $num_updates++;
      }
      else {
        insert_rising ($l, $sideReal_array[$c], $placidus_table[$l][$sideReal_array[$c]]);
        $num_inserts++;
      }
    }
    
 }

 echo 'Inserts:  ' . $num_inserts . '<br>';
 echo 'Updates:  ' . $num_updates . '<br>';
 
 function nextLat($l) {
    if ($l < 20) {
      return $l + 5;
    }
    else {
      return $l + 1;
    }
 }

 function relationship_there ($lat, $LST) {
   $check = mysql_query ('SELECT * from table_of_houses WHERE latitude = ' . $lat . ' and local_sidereal_time = ' . $LST) or die(mysql_error());
   if (mysql_num_rows($check) > 0) {
     return true; }
   else {
     return false; }
 }

  function insert_rising ($lat, $LST, $rising) {
   //echo 'INSERT into table_of_houses (latitude, local_sidereal_time, rising) VALUES (' . $lat . ',"' . $LST . '","' . $rising . '")';
   $insert = mysql_query ('INSERT into table_of_houses (latitude, local_sidereal_time, rising) VALUES (' . $lat . ',"' . $LST . '","' . $rising . '")') or die(mysql_error());
   if ($insert) {
     return true; }
   else {
     return false; }
 }
  
  function update_rising ($lat, $LST, $rising) {
   $update = mysql_query ('UPDATE table_of_houses set rising = "' . $rising . '" WHERE latitude = ' . $lat . ' and local_sidereal_time = ' . $LST) or die(mysql_error());
   if ($update) {
     return true; }
   else {
     return false; }
 }

?>