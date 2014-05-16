<?php 

 require_once ("../header.php");
  

 set_time_limit (0);

 $fp = @fopen('banned_words.txt', 'r');
 
 $counter = 0;
 $insert_counter = 0;
 $update_counter = 0;
 $total_counter = 0;
 
 if ($fp) {
   while (($line = fgets($fp)) and $counter < 10000) {
      $pieceArray = explode (',',trim($line));
      //print_r ($pieceArray);
      
      if (sizeof($pieceArray) < 1) {
          echo 'This line is ignored<br>';
      }
      else {
          

            $word = $pieceArray[0];
            echo '*' . $word . '*<br>';
            
            if (!(word_there($word))) { 
                
                $q = 'INSERT INTO banned_words (word)
                      VALUES ("' . $word . '")' or die(mysql_error());
                mysql_query ($q) or die(mysql_error());
                echo 'INSERTING ' . $word . '<br>';
                $insert_counter++;
            }
            else {
              echo 'Already There';
              $update_counter++;
            }
            $counter++;
            
      }         
      
   }
   
 }
 else {
   echo 'File Not Found';
 }

 fclose ($fp); 
 
 echo 'Words Inserted: ' . $insert_counter . '<br>';
 echo 'Words Already There: ' . $update_counter . '<br>';
 echo 'Total Rows Read: ' . $counter;

 function word_there($word) {
   $q = 'SELECT word from banned_words WHERE word = "' . $word . '"';
   $do_q = mysql_query ($q) or die(mysql_error());
   if (mysql_num_rows($do_q) > 0) {
     return true;
   }
   else {
     return false;
   }
 }
?>