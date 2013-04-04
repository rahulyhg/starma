<?php 

 require_once ("../header.php");
  

 set_time_limit (0);

 $fp = @fopen('solarsiderealcorrection.csv', 'r');
 
 $counter = 0;
 $insert_counter = 0;
 $update_counter = 0;
 $total_counter = 0;
 
 if ($fp) {
   while (($line = fgets($fp)) and $counter < 10000) {
      $pieceArray = explode (',',trim($line));
      
      if ($pieceArray[0] == '' or $pieceArray[0] == 'MIN') {
          echo 'This line is ignored<br>';
      }
      else {
          $minutes = substr($pieceArray[0], 0, 2);
          for ($p = 0; $p < 24; $p++) {
            $hours = (string) $p;
            if (strlen($p) == 1){ 
              $hours = '0' . $hours;
            }
            $place_minutes = ($p*2)+1;
            $place_seconds = ($p*2)+2;
            $correction = $pieceArray[$place_minutes] . $pieceArray[$place_seconds];
            if (!(correction_there($hours, $minutes))) { 
                
                $q = 'INSERT INTO solarsiderealcorrection (hours, minutes, correction)
                      VALUES ("' . $hours . '","' . $minutes . '","' . $correction . '")' or die(mysql_error());
                mysql_query ($q) or die(mysql_error());
                echo 'INSERTING ' . $correction . ' at ' . $hours . 'h' .  $minutes . 'm<br>';
                $insert_counter++;
            }
            else {
              echo 'Already There';
              $update_counter++;
            }
          }
         
          
      }
      $counter++;
      
   }
 }
 else {
   echo 'File Not Found';
 }

 fclose ($fp); 
 
 echo 'Corrections Inserted: ' . $insert_counter . '<br>';
 echo 'Corrections Already There: ' . $update_counter . '<br>';
 echo 'Total Rows Read: ' . $counter;

 function correction_there($hours, $minutes) {
   $q = 'SELECT correction from solarsiderealcorrection WHERE hours = "' . $hours . '" AND minutes = "' . $minutes . '"';
   $do_q = mysql_query ($q) or die(mysql_error());
   if (mysql_num_rows($do_q) > 0) {
     return true;
   }
   else {
     return false;
   }
 }
?>