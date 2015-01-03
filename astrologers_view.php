<?php
	require ('header.php');
if (isLoggedIn()) {
  if (!get_my_chart()) {
    echo 'Enter your birth info to get your birth chart';
  }
  else {
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
    
    $can_view = can_view_section($chart_id);
    if ($_GET['the_page'] == 'psel') { //MY PROFILE
      //if ($western == 0) {
      echo '<div id="av_type" class="later_on">';
      echo '<a class="later_on" ';
      if ($western == 0) {
        echo 'style="text-decoration:underline;"';
      }
      echo ' href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=astrologers_view_selected">Vedic</a>  |  <span id="w_astro_view">Western</span><span style="position:absolute; padding-left:10px;" id="w_coming_soon"></span>';
                
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
 
      if (!$can_view[0]) { 
        echo $can_view[1];
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
      
    if ($can_view[0]) {   
      show_astrologers_view();
    }
  }   
		
}

	

?>