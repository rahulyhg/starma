<?php
	require_once('ajax_header.php');

	if(isset($_POST['cfc'])) {
		$data = array();
		$errors = array();
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
		echo json_encode($data);
	}









?>