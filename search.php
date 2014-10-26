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

				echo 'gender:' . $gender;
			}

		echo '</div>';  //close s_results





	}
	else {
		do_redirect(get_domain());
	}


?>