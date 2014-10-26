<?php
	require_once('../header.php');

	if (isset($_POST['s_vars'])) {
		//if ($_POST['gender'] !== 'none') {
		//	if ($_POST['gender'] == 'M' || $_POST['gender'] == 'F') {
				$gender = $_POST['gender'];
				$age_low = $_POST['age_low'];
				$age_high = $_POST['age_high'];
				do_redirect (get_domain() . '/main.php?the_left=nav4&the_page=cosel&search=true&filter1=' . $gender . '&filter2=0');
		//	}
		//	else {
		//		$error = 1;
		//		do_redirect (get_domain() . '/main.php?the_left=nav4&the_page=cosel&error=' . $error);
		//	}
		//}
	}
	
?>