<?php
	require ('header.php');
	if (isLoggedIn()) {

		$western = $_GET['western'];

		if (isset($_GET['chart_id2'])) {  //ANOTHER PROFILE
			$chart_id = $_GET['chart_id2'];
			$isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($chart_id)));
			if (!is_freebie_chart($chart_id)) {
      			$tier = 3;
      			$western_there = grab_var('western_there',chart_already_there("Alternate",get_user_id_from_chart_id($chart_id)));
    		}
    		else {  //FREEBIE
    			$western_there = true;
      			$tier = 4;
    		}
		}
		else {  //MY PROFILE
			$chart_id = get_my_chart_id();
		}
		
    	if ($_GET['the_page'] == 'psel') { //MY PROFILE
    		if ($western == 0) {
            	echo '<div id="birth_chart_type" class="pointer"><a class="later_on" href="?the_page=' . $the_page .'&the_left=' . $the_left . '&western=1&section=astrologers_view_selected">See Western Chart</a></div>';
          	}
          	else {
            	echo '<div id="birth_chart_type" class="pointer"><a class="later_on" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=astrologers_view_selected">See Vedic Chart</a></div>';
          	}
    	}
    	else { //ANOTHER PROFILE
    		if (!$western_there) {
    			if ($isCeleb) {
    				echo '<div class="later_on" style="font-size:1.3em;">Vedic Birth Chart (No western Birth Chart available yet)</div>';
    			}
    			else {
					$username = get_nickname(get_user_id_from_chart_id($chart_id));
    				echo '<div class="later_on" style="font-size:1.3em;">' . $username . ' only has a Vedic Birth Chart</div>';
    			}
    		}
    		elseif ($western == 0) {
      			echo '<div id="birth_chart_type" class="pointer"><a class="later_on" href="?the_page=' . $the_page .'&the_left=' . $the_left . '&chart_id2=' . $chart_id . '&tier=' . $tier . '&western=1&section=astrologers_view_selected">See Western Chart</a></div>';
    		}	
    		else {
      			echo '<div id="birth_chart_type" class="pointer"><a class="later_on" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $chart_id . '&tier=' . $tier . '&western=0&section=astrologers_view_selected">See Vedic Chart</a></div>';
    		}
    	}
    	
			
		show_astrologers_view();
		
	}

	

?>