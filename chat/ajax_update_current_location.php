<?php
require_once("ajax_header.php");

if(isLoggedIn()) {
	$data = array();
	if(isset($_POST['country_id'])) {
		if($_POST['country_id'] == 236) {

			$country_id = $_POST['country_id'];
			$zip = $_POST['zip'];
			if(strlen($zip) < 5 || !preg_match('%^[0-9]{5}$%', $zip)){
				$data['errors'] = true;
				$data['message'] = 'Please enter a zip code';
			}
			else {
				$location_string = trim($_POST["zip"]) . ' US';
				$type="postalCodeSearch?placename";
			}
			

		}
		else {
			$country_id = $_POST['country_id'];
			
			if(trim($_POST["title"]) == "") {
				$data['errors'] = true;
				$data['message'] = 'Please enter a city';
			}
			else {
				$title = $_POST['title'];
				$country = get_country($country_id = $country_id);
          		$location_string = exceptionizer($location_string = trim($title) . ', ' . $country["country_title"]);  
          		$type="wikipediaSearch?q";
			}
		}
		if (!isset($data['errors'])) {
			if (!$result = geocode($location_string, $type)) {
        		$data['errors'] = true;
        		$data['message'] = 'There was an error, please try again';
        	}
      	}

		if(isset($data['errors'])) {
			$data['success'] = false;
		}
		else {
      		$user = my_profile_info();
			$gender = get_my_gender();
			$location = $result["location"];
        	$state_id = get_state_id_from_code ($result["state_code"]);
        	update_my_profile_info($user["first_name"], $user["last_name"], $gender, $location);
        	update_my_extended_location($state_id, $country_id);
        	$updated_user = my_profile_info();
        	if ($updated_user["country_id"] == 236) {  // UNITED STATES
      			$state = get_state ($updated_user["state_id"]);
      			$location = $updated_user["location"] . ', ' . strtoupper($state["state_code"]);
    		}
    		else {
      			$country = get_country ($updated_user["country_id"]);
      			$location = $location . '<br>' . format_country_name ($country["country_title"]);
    		}
      		$data['success'] = true;
      		$data['new_location'] = $location;
		}

		echo json_encode($data);
	}
}


?>