<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {

	if (isset($_GET["tier"])) {
  		$tier=$_GET["tier"];
	}
	else {
  		$tier = "1"; 
	}

	if ($tier == "1") {
  	/*
  		$users = get_user_list ();;
  		$num_users = mysql_num_rows($users);
  		$users_per_page = grab_var('users_per_page', 16);
  		$current_page = grab_var('current_page', 1);
 		$num_pages = ceil((float)($num_users/$users_per_page));
 		$height_inc = ceil((float)($users_per_page/USER_BLOCK_PER_ROW())) * (int)(USER_BLOCK_COMPARE_HEIGHT());
	*/
  		clear_compare_data();
  
  		//Log the Action
  		log_this_action (compare_action_all(), viewed_basic_action());
  		echo '<div id="new_to_starma">';

    		//js_more_link ("js_user_frame", $num_pages, $current_page, $height_inc, $num_users);

       			echo '<div><input type="text" class="input_style" id="ue_search" placeholder="Search by Username or Email"><span class="later_on pointer" id="ues_button">Search!</span></div>';
      			echo '<button id="sfb_friends" class="s_button">Find My Facebook Friends</button>';
   			//echo '</div>';
      		echo '<div id="single_u"></div>';
    		echo '<div id="s_results">';
      			//echo '<div id="js_user_frame">';
      				//$chart_id = get_my_chart_id();
					//$user_list = get_user_list($limit=25);
					//$user_array = query_to_array($user_list);
					//$users_per_page = 24;
					show_users($url="?the_page=" . $the_page . "&the_left=" . $the_left . "&tier=3&stage=2", $limit=25);

        			//display_all_users($url="?the_page=" . $the_page . "&the_left=" . $the_left . "&tier=3&stage=2");
        			//addJSSearchEvents("js_search_bar","filterAllUsers");
      			//echo '</div>';
    		echo '</div>';
    		echo '<div id="js_back_to_top">';
       			echo '<a onclick="$(\'html,body\').animate({ scrollTop: 0 }, \'fast\'); return false;" href="">^<br>Back<br>To Top</a>';
     		echo '</div>';
     		addBackToTopHandler();

    		echo '<input type="hidden" id="nts" value="true" />';
    		echo '<input type="hidden" id="url" value="?the_page=' . $the_page . '&the_left=' . $the_left . '&tier=3&stage=2" />';
  		echo '</div>';

  		echo '<div id="s_loading" class="later_on">Loading...</div>';
  		//display_my_chart_list();
	}
	elseif ($tier == "2") {
   		//if(isset($_GET['from_profile'])) {    // in compare_tier_2 now
      	//clear_compare_data();
    	//}
    	if (isset($_GET["results_type"])) {
       		$results_type = $_GET["results_type"];
    	}
    	else { 
     	 	$results_type = "major";
    	}
    	if (isset($_GET["text_type"])) {
      		$text_type = $_GET["text_type"];
    	}
    	else { 
      		$text_type = "2";
    	}  
    	if ((string) $_GET["stage"] == "2" or (string) $_GET["stage"] == "3") {
       		$gotothe = "?the_page=" . $the_page . "&the_left=" . $the_left . "&results_type=" . $results_type . "&text_type=" . $text_type . "&tier=2";
       		compare_tier_2 ($gotothe, $results_type, $text_type);
    	} 

    	/*
    	if (isset($_SESSION["compare_more_info_flag"])) {
      		$flag = $_SESSION["compare_more_info_flag"];
    	}
    	else {
      		$flag = get_my_preferences("compare_more_info_flag", 1);
    	}
    	if ($flag == 1) {
      		show_sheen($flag, 'compare_info_form');
    	}
    	*/

	}
	elseif ($tier == "3") {
  		require("non_chart_profile_others.php");
	}
	elseif ($tier == "4") {
  		require("chart_others.php");
	}
	echo '<script type="text/javascript" src="/js/new_to_starma_ui.js"></script>';

}

?>