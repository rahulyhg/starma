<?php
	require_once('../header.php');

	if (isset($_POST['s_vars'])) {
		if ($_POST['gender'] !== 'none') {
			$gender = $_POST['gender'];
			do_redirect (get_domain() . '/main.php?the_left=nav4&the_page=cosel&search=true&filter1=' . $gender);
		}
	}
	
?>