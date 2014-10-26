<?php
	require_once('../header.php');

	if (isset($_POST['s_vars'])) {
		//if ($_POST['gender'] !== 'none') {
		//	if ($_POST['gender'] == 'M' || $_POST['gender'] == 'F') {
				$gender = $_POST['gender'];

				if ($_POST['age_low'] < 18 || $_POST['age_low'] == '') {
					$age_low = 18;
				}
				else {
					$age_low = $_POST['age_low'];
				}
				if ($_POST['age_high'] > 110 || $_POST['age_high'] == '') {
					$age_high = 110;
				}
				else {
					$age_high = $_POST['age_high'];
				}
				
				do_redirect (get_domain() . '/main.php?the_left=nav4&the_page=cosel&search=true&filter1=' . $gender . '&filter2=' . $age_low . ',' . $age_high);
		//	}
		//	else {
		//		$error = 1;
		//		do_redirect (get_domain() . '/main.php?the_left=nav4&the_page=cosel&error=' . $error);
		//	}
		//}
	}
	
?>