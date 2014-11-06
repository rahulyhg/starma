<?php
require_once('ajax_header.php');

$errors = array();
$data = array();
$chart_id = $_POST['chart_id'];
if (isset($_POST['rising_sign_id'])) {
	if(preg_match('%\d{1,2}%', $_POST['rising_sign_id'])) {
		$rising_sign_id = $_POST['rising_sign_id'];
	}
	else {
		$errors['rising_sign_id'] = 'There was an error with your Rising sign.  Please try again.';
	}
}

if (isset($_POST['house_id'])) {
	if(preg_match('%\d{1,2}%', $_POST['house_id'])) {
		$house_id = $_POST['house_id'];
		$hl_desc1 = get_hl_desc($house_id);
		if ($house_id == 1) {
			$h1 = (string)$house_id .'st';
		}
		elseif ($house_id == 2) {
			$h1 = (string)$house_id .'nd';
		}
		elseif ($house_id == 3) {
			$h1 = (string)$house_id .'rd';
		}
		else {
			$h1 = (string)$house_id .'th';
		}
	}
	else {
		$errors['house_id'] = 'There was an error with your house selection.  Please try again.';
	}
}


if (isset($_POST['house_of_res'])) {
	if(preg_match('%\d{1,2}%', $_POST['house_of_res'])) {
		$house_of_res = $_POST['house_of_res'];
		if ($house_id == $house_of_res) {
			$hl_desc2 = '';
		}
		else {
			$hl_desc2 = get_hl_desc($house_of_res);	
		}
		if ($house_of_res == 1) {
			$h2 = (string)$house_of_res .'st';
		}
		elseif ($house_of_res == 2) {
			$h2 = (string)$house_of_res .'nd';
		}
		elseif ($house_of_res == 3) {
			$h2 = (string)$house_of_res .'rd';
		}
		else {
			$h2 = (string)$house_of_res .'th';
		}
	}
	else {
		$errors['house_of_res'] = 'There was an error with your house selection.  Please try again.';
	}
}	
	
if(!empty($errors)) {
	$data['errors'] = $errors;
}
else {
	if (isLoggedIn()) {
		if ($chart_id == get_my_chart_id()) {
			$blurb = get_house_ruler_blurb($rising_sign_id, $house_id, $house_of_res);			
		}
		else {
			$blurb = get_house_ruler_blurb($rising_sign_id, $house_id, $house_of_res, $chart_id);				
			//$data['ohno'] = "Oh no!  Since your birth time is not currently accurate enough to find your Rising sign, we can't tell you about your house lords.  To see your house lords, please enter a more precise <a href='main.php?the_left=nav4&the_page=psel'>time of birth.</a>";
		}
	}
	else {
		$blurb = get_house_ruler_blurb($rising_sign_id, $house_id, $house_of_res, $chart_id);
	}

	$data['hl_desc'] = $hl_desc1 . '<br>' . $hl_desc2;	
	$data['blurb_start'] = 'Lord of the ' . $h1 . ' in the ' . $h2 . ': ';
	$data['blurb'] = $blurb;
	$data['house_id'] = $house_id;
	$data['house_of_res'] = $house_of_res;
}

echo json_encode($data);


?>