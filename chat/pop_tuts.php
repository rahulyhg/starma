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

	if (isset($_POST['compare_flag'])) {
		$compare_flag = $_POST['compare_flag'];
		if (!set_my_compare_flag($compare_flag)) {
			$errors['compare_flag'] = 'There was an error turning off the tutorial.  Please refresh the page and try again.';
		}
		else {
			$data['compare_flag'] = 'Success!';
		}
	}




	echo json_encode($data);



?>