<?php 

 require_once ("../header.php");
  

 set_time_limit (0);

 $fp = @fopen('deltaT.csv', 'r');
 
 $counter = 0;
 $insert_counter = 0;
 $update_counter = 0;
 $total_counter = 0;
 
 if ($fp) {
   while (($line = fgets($fp)) and $counter < 10000) {
      $pieceArray = explode (',',trim($line));
      
      if ($pieceArray[0] == '' or $pieceArray[0] == 'ear') {
          echo 'This line is ignored<br>';
      }
      else {
          $year = $pieceArray[0];
          $correction = $pieceArray[1];
          $sign = 1;
          if ($correction[0] == '-') {
              $sign = -1;
              $correction = ltrim ($correction, "-");
          }
 
           
          if (!(correction_there($year))) { 
                
                $q = 'INSERT INTO deltaT (year, correction, sign)
                      VALUES ("' . $year . '","' . $correction . '",' . $sign . ')' or die(mysql_error());
                mysql_query ($q) or die(mysql_error());
                echo 'INSERTING ' . $sign . ' -> ' . $correction . ' for ' . $year . '<br>';
                $insert_counter++;
          }
          else {
            echo 'Already There';
            $update_counter++;
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

 function correction_there($year) {
   $q = 'SELECT correction from deltaT WHERE year = "' . $year . '"';
   $do_q = mysql_query ($q) or die(mysql_error());
   if (mysql_num_rows($do_q) > 0) {
     return true;
   }
   else {
     return false;
   }
 }
?>