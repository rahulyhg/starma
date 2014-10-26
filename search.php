<?php
	require_once ("header.php");

	if(isLoggedIn()) {

		echo '<div id="s_top_bar">';

			echo '<div id="s_inputs">';
				echo '<div id="sfb_friends">Find My FB Friends</div>';
				echo  '<input type="text" class="input_style" placeholder="Enter username or email" />';
			echo '</div>';

			echo '<div id="s_vars">';
				echo '<table>';
					echo '<tbody>';
						echo '<tr>';
							echo '<th colspace="2" class="later_on">Make New Friends</th>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Gender</td>';
							echo '<td>' . gender_select('') . '</td>';
						echo '</tr>';
					echo '</tbody>';
				echo '</table>';
			echo '</div>';

		echo '</div>'; //close searchBarTop





	}
	else {
		do_redirect(get_domain());
	}


?>