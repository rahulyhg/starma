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
										<option value="F" ';
											if($_GET['filter1'] == 'F') {
												echo 'selected="SELECTED"';
											}
										echo '>Female</option>
										<option value="M" ';
											if($_GET['filter1'] == 'M') {
												echo 'selected="SELECTED"';
											}
										echo '>Male</option>
									</select>
									</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Age Range:</td>';
							echo '<td><input name="age_low" type="text" class="age_range" maxlength="3" /><input name="age_high" type="text" class="age_range" maxlength="3" /></td>';
						echo '</tr>';
				echo '</table>';			
			echo '<input type="submit" name="s_vars" id="s_vars_submit" class="s_button" value="Search" />';
		echo '</form>';
		echo '</div>'; //close s_vars

		echo '</div>'; //close searchBarTop

		echo '<div id="s_results">';

			if(isset($_GET['search'])) {
				$gender = $_GET['filter1'];
				$age = explode(",", $_GET['filter2']);
				$age_low = $age[0];
				$age_high = $age[1];
				$age_low = CURRENT_YEAR() - $age_low;
				//$age_low = $age_low . '-00-00';
				$age_high = CURRENT_YEAR() - $age_high;
				//$age_high = $age_high . '-00-00';
				$low_bound = (string)$age_high . '-00-00'; //SWAP TO PUT IN QUERY IN CORRECT ORDER
				$high_bound = (string)$age_low . '-00-00';

				//echo 'age_low: ' .mysql_real_escape_string($age_low) . ', age_high: ' . mysql_real_escape_string($age_high);
				
					$chart_id = get_my_chart_id();
					$user_list = get_user_list_search($gender, $low_bound, $high_bound);
					$user_array = query_to_array($user_list);

					if (count($user_array) > 0) {
						$users_per_page = 24;
						$num_pages = count($user_array) / $users_per_page; // DIVIDED BY THE NUMBER OF USER PROFILES PER PAGE
						$num_pages = ceil($num_pages); //NUMBER OF PAGES
						//echo 'num_pages: ' . $num_pages . '<br>';
						//echo 'number of users: ' . count($user_array) . '<br>';
						$pages = array_chunk($user_array, $users_per_page, true);  //PROFILES SPLIT INTO PAGE ARRAYS

						//print_r($pages);
						
						$x=0;
						foreach ($pages as $page) {		
							echo '<div id="page_' . $x . '">';	
											
							if ($x == 0) {
									$upp = 0;
									foreach ($user_array as $user) {
										
										if ($upp < $users_per_page) {
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
    									else {
    										break;
    									}
    									$upp++; 
    									//echo 'upp: ' . $upp . '<br>';
									}
							}
							else {
								//echo '<div id="page_' . $x . '">';
								echo '<a href="#"></a>';
							}
							echo '</div>'; //close page_
							
	    					$x++;
	    					//echo 'x= ' . $x . '<br>';
    					}
    					
    					
  					}
  					else {
  						echo '<div>We currently have no users matching your search.  Try widening your net...</div>';
  					}
  					unset($x);
  					unset($upp); 
  									
			}
			elseif (isset($_GET['error'])) {
				if($_GET['error'] == 1) {
					echo '<div class="s_err">There was an error with the gender field.  Please select a gender.</div>';
				}
			}

		echo '</div>';  //close s_results





	}
	else {
		do_redirect(get_domain());
	}


?>