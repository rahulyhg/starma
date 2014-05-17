<?php
require_once("ajax_header.php");
 
$logged_in = login_check_point($type="full");

	$data = array();
	//$errors = array();
	if(!contains_illegal_words($_POST['value'])) {

		if(isset($_POST["user_des_id"])) {
			if(preg_match('%^[0-9]+$%', $_POST["user_des_id"])) {
				$data["user_des_id"] = $_POST["user_des_id"];
				$user_des_id = $_POST["user_des_id"];
			}
		}
		

		if(isset($_POST["value"])) {
			if(preg_match('%^[A-Za-z-\.]{1,15}$%', $_POST["value"])) {
				$data["value"] = $_POST["value"];
				$value = mysql_real_escape_string(trim($_POST["value"]));
				$value = strip_tags($value);
				update_my_single_descriptor ($user_des_id, $value);
				echo json_encode($data, true);
			}
			else {
				$data["errors"] = 'Letters only please';
				echo json_encode($data, true);
			}
		}
		
	

		else {
			$data["errors"] = 'That post was invalid';
			echo json_encode($data, true);
		}
	}
	else {
		$data["errors"] = 'No naughty words please!';
		echo json_encode($data, true);
	}
	
	//$data = 'hello';
	//echo json_encode($data, true);

?>