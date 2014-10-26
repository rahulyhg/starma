<?php
	require_once ("header.php");

	if(isLoggedIn()) {
		echo '<script type="text/javascript" src="/js/search.js"></script>'; //MOVE WHEN DONE

		echo '<div id="s_top_bar">';

			echo '<div id="s_inputs">';
				echo '<div id="sfb_friends" class="s_button">Find My FB Friends</div>';
				echo  '<input type="text" class="input_style" placeholder="Enter username or email" />';
			echo '</div>';

		
			echo '<div id="s_vars">';
			echo '<form name="s_vars_f" method="POST" action="/chat/search_results.php">';
				echo '<table>';
						echo '<tr>';
							echo '<th colspan="2" class="later_on" style="font-size:1.4em;">Make New Friends</th>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Gender</td>';
							echo '<td><select id="gender_select" name="gender">
										<option value="none">Select a gender</option>
										<option value="F">Female</option>
										<option value="M">Male</option>
									</select>
									</td>';
						echo '</tr>';
				echo '</table>';			
			echo '<input type="submit" name="s_vars" id="s_vars_submit" class="s_button" value="Search" />';
		echo '</form>';
		echo '</div>'; //close s_vars

		echo '</div>'; //close searchBarTop

		echo '<div id="s_results">';

			if(isset($_GET['search'])) {
				$gender = $_GET['filter1'];
				switch ($gender) {
					case 'M':
						//echo 'gender:' . $gender;
						$chart_id = get_my_chart_id();
						$user_list = get_user_list_search($gender);
						$user_array = query_to_array($user_list);


						if (count($user_array) > 0) {

	    					foreach ($user_array as $user) {
 			
    			  				echo '<div class="user_block js_user_' . $user["user_id"] . '">';
        							echo '<div class="photo_border_wrapper_compare">';
          								echo '<div class="compare_photo">';
            								show_user_compare_picture($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
            								//echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';
         			
          								echo '</div>';
        							echo '</div>'; 
        							show_general_info($user["chart_id"]);
        							//echo '<div class="user_info">' . $user["nickname"] . '</div>';      
			        				//echo '*' . $user["score"] . '*';
    			  				echo '</div>';        
    						}
  						}
  						else {
    						echo '<div>We currently have no users matching your search.  Try widening your net...</div>';
  						}
  						break;
  					case 'F':
						//echo 'gender:' . $gender;
						$chart_id = get_my_chart_id();
						$user_list = get_user_list_search($gender);
						$user_array = query_to_array($user_list);


						if (count($user_array) > 0) {

	    					foreach ($user_array as $user) {
 			
    			  				echo '<div class="user_block js_user_' . $user["user_id"] . '">';
        							echo '<div class="photo_border_wrapper_compare">';
          								echo '<div class="compare_photo">';
            								show_user_compare_picture($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
            								//echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';
         			
          								echo '</div>';
        							echo '</div>'; 
        							show_general_info($user["chart_id"]);
        							//echo '<div class="user_info">' . $user["nickname"] . '</div>';      
			        				//echo '*' . $user["score"] . '*';
    			  				echo '</div>';        
    						}
  						}
  						else {
    						echo '<div>We currently have no users matching your search.  Try widening your net...</div>';
  						}
  						break;
  				}
			}

		echo '</div>';  //close s_results





	}
	else {
		do_redirect(get_domain());
	}


?>