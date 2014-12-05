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
    		//if ($western == 0) {
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

    	}
    	else { //ANOTHER PROFILE
           $pref = get_preferences(get_user_id_from_chart_id($chart_id), 'chart_private', 0);
           $my_pref = get_my_preferences('chart_private', 0);
           if ($pref == 1 && !isCeleb(get_user_id_from_chart_id($chart_id))) {
             $username = get_nickname(get_user_id_from_chart_id($chart_id));
             echo '<div class="later_on" style="font-size:1.5em; text-align:center; margin-bottom:260px;">' . $username . ' has chosen to keep this section private.</div>';
           }
           elseif ($my_pref == 1 && !isCeleb(get_user_id_from_chart_id($chart_id))) {
              echo '<div class="later_on" style="font-size:1.5em; text-align:center; margin-bottom:260px;">You cannot view this section of another person\'s profile while your chart info is set as private.  <a href="/main.php?the_page=ssel&the_left=nav1&the_tier=1">View My Privacy Settings</a></div>';
           }
           else {
              echo '<div id="av_type" class="later_on">';
    		if (!$western_there) {
    			if ($isCeleb) {
              $user_info = profile_info(get_user_id_from_chart_id($chart_id));
              $username = $user_info['first_name'] . ' ' . $user_info['last_name'];
               }
    			else {
					  $username = get_nickname(get_user_id_from_chart_id($chart_id));
    			}
            echo '<a class="later_on" style="text-decoration:underline;" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $chart_id . '&tier=' . $tier . '&western=0&section=astrologers_view_selected">Vedic</a>  |  ';
            echo '<span>' . $username . ' only has a Vedic Birth Chart</span>';
    		}
    		else {  
            echo '<a class="later_on" ';
              if ($western == 0) {
                echo 'style="text-decoration:underline;"';
              }
            echo ' href="?the_page=' . $the_page .'&the_left=' . $the_left . '&chart_id2=' . $chart_id . '&tier=' . $tier . '&western=0&section=astrologers_view_selected">Vedic</a>  |  <span>Western (Coming Soon)</span>';
          
            /*//IMPLEMENT WHEN WESTERN VIEW EXISTS
            echo '<a class="later_on"';  
              if ($western == 1) {
                echo 'style="text-decoration:underline;"';
              }
            echo ' href="?the_page=' . $the_page .'&the_left=' . $the_left . '&chart_id2=' . $chart_id . '&tier=' . $tier . '&western=1&section=astrologers_view_selected">Western (Coming Soon)</a>';
            */
           }
        }        
        echo '</div>';
    	}
    	
	if ($pref == 0 && $my_pref == 0 && !isCeleb(get_user_id_from_chart_id($chart_id))) {		
		show_astrologers_view();
        }
		
}

	

?>