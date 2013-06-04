<?php 

 require_once ("../header.php");
  

 set_time_limit (0);

 $fp = @fopen('countryCodes.csv', 'r');
 
 $counter = 0;
 $insert_counter = 0;
 $update_counter = 0;
 $total_counter = 0;
 
 if ($fp) {
   while (($line = fgets($fp)) and $counter < 10000) {
      $pieceArray = explode (';',trim($line));
      
      if (sizeof($pieceArray) != 2) {
          echo 'This line is ignored<br>';
      }
      else {
          //grab each peice and take off the quotation marks
          $title = substr($pieceArray[0], 1);
          $code = substr($pieceArray[1], 0, -1);
          //echo $code;
           
          if (!(country_there($code))) { 
                
                $q = 'INSERT INTO country (country_title, country_code)
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
 
 echo 'Countries Inserted: ' . $insert_counter . '<br>';
 echo 'Countries Already There: ' . $update_counter . '<br>';
 echo 'Total Rows Read: ' . $counter;

 function country_there($code) {
   $q = 'SELECT country_code from country WHERE country_code = "' . $code . '"';
   $do_q = mysql_query ($q) or die(mysql_error());
   if (mysql_num_rows($do_q) > 0) {
     return true;
   }
   else {
     return false;
   }
 }
?>