<?php 

 require_once ("../header.php");
  

 set_time_limit (0);

 $fp = @fopen('EPHEMERIDES_updated.txt', 'r');
 
 $counter = 0;
 $update_counter = 0;
 $insert_counter = 0;
 $total_counter = 0;
 
 if ($fp) {
   while (($line = fgets($fp)) and $counter < 10000) {
      $pieceArray = explode (' ',trim($line));
      
      if ($pieceArray[0] == 'JANUARY' or $pieceArray[0] == 'FEBRUARY' or 
          $pieceArray[0] == 'MARCH' or $pieceArray[0] == 'APRIL' or $pieceArray[0] == 'MAY' or
          $pieceArray[0] == 'JUNE' or $pieceArray[0] == 'JULY' or $pieceArray[0] == 'AUGUST' or
          $pieceArray[0] == 'SEPTEMBER' or $pieceArray[0] == 'OCTOBER' or $pieceArray[0] == 'NOVEMBER' or
          $pieceArray[0] == 'DECEMBER') {
          $month = $pieceArray[0];
          $year = $pieceArray[1];
          echo $month . ' ' . $year . '<br>';
      }
      else if ($pieceArray[0] == 'DATE') {
          echo 'This line is ignored<br>';
      }
      else if (sizeOf($pieceArray) == 14) {
          if ($pieceArray[0] == "Mo") {
             $day_of_week = "MONDAY";}
          else if ($pieceArray[0] == "Tu") {
             $day_of_week = "TUESDAY";}
          else if ($pieceArray[0] == "We") {
             $day_of_week = "WEDNESDAY";}
          else if ($pieceArray[0] == "Th") {
             $day_of_week = "THURSDAY";}
          else if ($pieceArray[0] == "Fr") {
             $day_of_week = "FRIDAY";}
          else if ($pieceArray[0] == "Sa") {
             $day_of_week = "SATURDAY";}
          else if ($pieceArray[0] == "Su") {
             $day_of_week = "SUNDAY";}
          $day_date = $pieceArray[1];
          $GST = substr($pieceArray[2], 0, 2) . substr($pieceArray[2], 3, 2) . substr($pieceArray[2], 6, 2);
          $sun = substr($pieceArray[3], 0, 2) . substr($pieceArray[3], 4, 2) . substr($pieceArray[3], 2, 2);
          $moon = substr($pieceArray[4], 0, 2) . substr($pieceArray[4], 4, 2) . substr($pieceArray[4], 2, 2);
          $mercury = substr($pieceArray[5], 0, 2) . substr($pieceArray[5], 4, 2) . substr($pieceArray[5], 2, 2);
          $venus = substr($pieceArray[6], 0, 2) . substr($pieceArray[6], 4, 2) . substr($pieceArray[6], 2, 2);
          $mars = substr($pieceArray[7], 0, 2) . substr($pieceArray[7], 4, 2) . substr($pieceArray[7], 2, 2);
          $jupiter = substr($pieceArray[8], 0, 2) . substr($pieceArray[8], 4, 2) . substr($pieceArray[8], 2, 2);
          $saturn = substr($pieceArray[9], 0, 2) . substr($pieceArray[9], 4, 2) . substr($pieceArray[9], 2, 2);
          $uranus = substr($pieceArray[10], 0, 2) . substr($pieceArray[10], 4, 2) . substr($pieceArray[10], 2, 2);
          $neptune = substr($pieceArray[11], 0, 2) . substr($pieceArray[11], 4, 2) . substr($pieceArray[11], 2, 2);
          $pluto = substr($pieceArray[12], 0, 2) . substr($pieceArray[12], 4, 2) . substr($pieceArray[12], 2, 2);
          $rahu = substr($pieceArray[13], 0, 2) . substr($pieceArray[13], 4, 2) . substr($pieceArray[13], 2, 2);

          //echo $day_of_week . ' the ' . $day_date . ':  Greenwich Sidereal Time (00h) was ' . $GST . '; Sun was at ' . $sun . '<br>'; 

          for ($p = 2; $p < 14; $p++) {
            if ($p != 10) {
              if (!(poi_position_there(get_month_id($month), $year, $day_date, $p))) { 
                $poi_name = strtolower (get_poi_name($p));
                $q = 'INSERT INTO ephemeris (month_id, year, day_of_week_id, day_date, greenwich_sidereal_time, poi_id, poi_position)
                      VALUES (' . get_month_id($month) . ',' . $year . ',' . get_day_of_week_id($day_of_week) . ',' . $day_date . ',"' . $GST . '",' . $p . ',"' . $$poi_name . '")' or die(mysql_error());
                mysql_query ($q) or die(mysql_error());
                echo $q . '<br>';
                $insert_counter++;
              }
              else {
                echo 'Already There';
                $update_counter++;
              }
            }
          }
          $total_counter++;
          
      }
      $counter++;
      
   }
 }
 else {
   echo 'File Not Found';
 }

 fclose ($fp); 
 
 echo 'Positions Inserted: ' . $insert_counter . '<br>';
 echo 'Positions Updated: ' . $update_counter . '<br>';
 echo 'Total Rows Read: ' . $total_counter;

 function poi_position_there($month_id, $year, $day_date, $poi_id) {
   $q = 'SELECT poi_position from ephemeris WHERE month_id = ' . $month_id . ' AND year = ' . $year . ' AND day_date = ' . $day_date . ' AND poi_id = ' . $poi_id;
   $do_q = mysql_query ($q) or die(mysql_error());
   if (mysql_num_rows($do_q) > 0) {
     return true;
   }
   else {
     return false;
   }
 }
?>