<?php
	require ('header.php');
	
//GUEST VIEW ----------------------------------------------

		$western = $_GET['western'];
		
    	if ($western == 0) {
            echo '<div id="birth_chart_type" class="pointer"><a class="later_on" href="?the_page=' . $the_page .'&the_left=' . $the_left . '&western=1&section=astrologers_view_selected">See Western Chart</a></div>';
        }
        else {
            echo '<div id="birth_chart_type" class="pointer"><a class="later_on" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=astrologers_view_selected">See Vedic Chart</a></div>';
        }
    			
		show_astrologers_view();


?>