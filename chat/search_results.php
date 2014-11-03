<?php
	require_once('../header.php');

	if (isset($_POST['s_vars'])) {
		$errors = array();
		//if ($_POST['gender'] !== 'none') {
		//	if ($_POST['gender'] == 'M' || $_POST['gender'] == 'F') {
				$gender = $_POST['gender'];

				if (!preg_match('%^[0-9]{1,3}$%', $_POST['low_bound'])) {
					$low_bound = 18;
				}
				elseif ($_POST['low_bound'] < 18) {
					$low_bound = 18;
				} 
				else {
					$low_bound = trim($_POST['low_bound']);
				}

				if (!preg_match('%^[0-9]{1,3}$%', $_POST['high_bound'])) {
					$high_bound = 110;
				}				
				elseif ($_POST['high_bound'] > 110) {
					$high_bound = 110;
				}
				else {
					$high_bound = trim($_POST['high_bound']);
				}
				
				if (!empty($errors)) {
					do_redirect (get_domain() . '/main.php?the_left=nav4&the_page=cosel&errors=' . $errors);
				}
				else {
					do_redirect (get_domain() . '/main.php?the_left=nav4&the_page=cosel&search=true&filter1=' . $gender . '&filter2=' . $low_bound . ',' . $high_bound);
				}
		//}

		//	else {
		//		$error = 1;
		//		do_redirect (get_domain() . '/main.php?the_left=nav4&the_page=cosel&error=' . $error);
		//	}
		//}
	}
	
?>