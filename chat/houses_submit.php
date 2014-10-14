<?php
require_once('ajax_header.php');

$errors = array();
$data = array();
if (isset($_POST['rising_sign_id'])) {
	if(preg_match('%\d{1,2}%', $_POST['rising_sign_id'])) {
		$rising_sign_id = $_POST['rising_sign_id'];
	}
	else {
		$errors['rising_sign_id'] = 'There was an error with your Rising sign.  Please try again.';
	}
}

if (isset($_POST['hl_id'])) {
	if(preg_match('%\d{1,2}%', $_POST['hl_id'])) {
		$hl_id = $_POST['hl_id'];
	}
	else {
		$errors['hl_id'] = 'There was an error with your house selection.  Please try again.';
	}
}


if (isset($_POST['house_of_res'])) {
	if(preg_match('%\d{1,2}%', $_POST['house_of_res'])) {
		$house_of_res = $_POST['house_of_res'];
	}
	else {
		$errors['house_of_res'] = 'There was an error with your house selection.  Please try again.';
	}
}	
	
if(!empty($errors)) {
	$data['errors'] = $errors;
}
else {
	$blurb = get_house_ruler_blurb($rising_sign_id, $hl_id, $house_of_res);
	$data['blurb'] = $blurb;
}

echo json_encode($data);


?>