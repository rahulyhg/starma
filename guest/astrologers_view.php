<?php
	require ('header.php');
	
//GUEST VIEW ----------------------------------------------
        
		$western = $_GET['western'];
		
    	echo '<div id="av_type" class="later_on">';
            echo '<a class="later_on" ';
              if ($western == 0) {
                echo 'style="text-decoration:underline;"';
              }
            echo ' href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=astrologers_view_selected">Vedic</a>  |  <span>Western (Coming Soon)</span>';
             
                /*//IMPLEMENT AFTER WESTERN VIEW EXISTS
                echo '<a class="later_on" ';
                if ($western == 1) {
                  echo 'style="text-decoration:underline;"';
                }
                echo ' href="?the_page=' . $the_page .'&the_left=' . $the_left . '&western=1&section=astrologers_view_selected">Western</a>';
                */
        
        echo '</div>';
    			
		show_astrologers_view();
        

?>