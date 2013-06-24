<?php 

 require_once ("../header.php");
  

 set_time_limit (0);

 $fp = @fopen('states.csv', 'r');
 
 $counter = 0;
 $insert_counter = 0;
 $update_counter = 0;
 $total_counter = 0;
 
 if ($fp) {
   while (($line = fgets($fp)) and $counter < 10000) {
      $pieceArray = explode (',',trim($line));
      
      if (sizeof($pieceArray) != 2) {
          echo 'This line is ignored<br>';
      }
      else {
          //grab each peice and take off the quotation marks
          $title = $pieceArray[0];
          $code = $pieceArray[1];
          //echo $code;
           
          if (!(state_there($code))) { 
                
                $q = 'INSERT INTO state (state_title, state_code)
                      VALUES ("' . $title . '","' . $code . '")' or die(mysql_error());
                mysql_query ($q) or die(mysql_error());
                echo 'INSERTING ' . $code . ' -> ' . $title . '<br>';
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
 
 echo 'States Inserted: ' . $insert_counter . '<br>';
 echo 'States Already There: ' . $update_counter . '<br>';
 echo 'Total Rows Read: ' . $counter;

 function state_there($code) {
   $q = 'SELECT state_code from state WHERE state_code = "' . $code . '"';
   $do_q = mysql_query ($q) or die(mysql_error());
   if (mysql_num_rows($do_q) > 0) {
     return true;
   }
   else {
     return false;
   }
 }
?>