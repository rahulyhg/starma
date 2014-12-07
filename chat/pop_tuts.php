<?php
	require_once('ajax_header.php');

	$data = array();
	$errors = array();

	if(isset($_POST['cfc'])) {
		
		$cfc = $_POST['cfc'];
		
		if(!set_my_chart_flag($cfc)) {
			$errors['set'] = 'Could not set the flag.';
		}
		else {
			$cfv = my_chart_flag(); //VAL AFTER SETTING TO NEW VAL
		}
		if(!empty($errors)){
			$data['errors'] = $errors;
		}
		else {
			$data['success'] = true;
			$data['cfv'] = $cfv;
		}
		
	}

	if (isset($_POST['chart_flag'])) {
		$chart_flag = $_POST['chart_flag'];
		if (!set_my_chart_flag($chart_flag)) {
			$errors['chart_flag'] = 'There was an error turning off the tutorial.  Please refresh the page and try again.';
		}
		else {
			$data['chart_flag'] = 'Success!';
		}
	}

	if(isset($_POST['cofc'])) {
		
		$cofc = $_POST['cofc'];
		
		if(!set_my_chart_flag($cofc)) {
			$errors['set'] = 'Could not set the flag.';
		}
		else {
			$cofv = my_chart_flag(); //VAL AFTER SETTING TO NEW VAL
		}
		if(!empty($errors)){
			$data['errors'] = $errors;
		}
		else {
			$data['success'] = true;
			$data['cofv'] = $cofv;
		}
		
	}

	if (isset($_POST['major_compare_flag'])) {
		if (!preg_match('%[0-9]{1}%', $_POST['major_compare_flag'])) {
			$errors['invalid'] = 'Something funny going on here...';
		}
		else {
			$compare_flag = $_POST['major_compare_flag'];
		}
		if (!set_my_compare_major_flag($compare_flag)) {
			$errors['major_set'] = 'There was an error turning off the tutorial (major).  Please refresh the page and try again.';
		}
		else {
			$data['major_compare_flag'] = 'Success!';
		}
	}

	if (isset($_POST['minor_compare_flag'])) {
		if (!preg_match('%[0-9]{1}%', $_POST['minor_compare_flag'])) {
			$errors['invalid'] = 'Something funny going on here...';
		}
		else {
			$compare_flag = $_POST['minor_compare_flag'];
		}
		if (!set_my_compare_minor_flag($compare_flag)) {
			$errors['minor_set'] = 'There was an error turning off the tutorial (minor).  Please refresh the page and try again.';
		}
		else {
			$data['minor_compare_flag'] = 'Success!';
		}
	}



	echo json_encode($data);



?>