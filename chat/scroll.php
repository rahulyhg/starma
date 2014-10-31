<?php
	require_once('ajax_header.php');

	if(isset($_POST['page'])) {
		$data = array();
		$errors = array();
		if(!preg_match('%[\d]+%', $_POST['page'])) {
			$errors['page'] = 'the page request must be a number...';
		}
		else {
			$limit = $_POST['limit'];
			$page = $_POST['page'];
			$begin = ($page - 1) * $limit;
			$data['page'] = $page;
			$data['begin'] = $begin;
			$data['limit'] = $limit;
		}

		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			get_user_list_search($gender, $low_bound, $high_bound, $begin, $limit);
		}

		echo json_encode($data);

	}


?>