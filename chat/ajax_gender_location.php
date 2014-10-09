<?php

require ('ajax_header.php');

	//if(isLoggedIn()) {

	//--------------------POST VAIRABLES
		$gender = $_POST['gender'];
		$country_id = $_POST['country_id'];
		if (isset($_POST['city'])) {
			$city = trim($_POST['city']);
		}
    else {
      $city = '';
    }
		if (isset($_POST['zip'])) {
			$zip = trim($_POST['zip']);
		}
    else {
      $zip = '';
    }
		
		$data = array();
		$errors = array();


	 //-------------GENDER
     	if (!valid_gender($gender)) {
        	$errors['gender'] = 'Please select a gender';
      	}
/*
	//---------------COUNTRY 
		if ($country_id == 0) {
			$errors['country_id'] = 'Please select a country';
		}
		else {
			    if ($country_id == 236) {
        		if ($zip == '') {
          			$errors['zip'] = 'Please enter a zip code';
          			$location_string = '';
        		}
        		elseif (!preg_match('%\d{5}%', $zip)) {
        			$errors['zip'] = 'Please enter a zip code';
          			$location_string = '';
        		}
        		else {
        			$location_string = $zip . ' US';
          			$type='postalCodeSearch?placename';
          			//$z = true;
          			//$c = false;
        		}
      		}
      		else {
        		if ($city == '') {
          			$errors['city'] = 'Please enter a city';
          			$location_string = '';
        		}
        		else {
          			$country = get_country($country_id);
          			//$data['country'] = $country;
          			$location_string = exceptionizer($city . ', ' . $country["country_title"]);  
          			//echo '*' . $location_string . '*'; die();
          			$type="wikipediaSearch?q";
          			//$c = true;
          			//$z = false;
        		}
      		}

      	//------------GEOCODE
      		if ($location_string !== '') {
      			if (!$result = geocode($location_string, $type)) {
        			$errors['geocode'] = 'Please check your zip code';
              //$errors['test'] = $location_string;
     			}
     		}
    }
*/
    //$from = 'gl';
    $result = parse_location_string($country_id, $zip, $city);

    //if ($result !== 0) {
      if(isset($result['country_id'])) {
        $errors['country_id'] = 'Please select a country';
      }
      elseif (isset($result['zip'])) {
        $errors['zip'] = 'Please enter a zip code';
      }
      //elseif ($result['zip']) {
      //  $errors['zip'] = 'Please enter a zip code';
      //}
      elseif (isset($result['city'])) {
        $errors['city'] = 'Please enter a city';
      }
      elseif (isset($result['geocode_zip'])) {
        $errors['geocode_zip'] = 'Please check your zip code';
      }
      elseif (isset($result['geocode_city'])) {
        $errors['geocode_city'] = 'Please double check your city';
      }
    //}

    //--------------ERRORS
      	if (!empty($errors)) {
        	$data['errors'] = $errors;
      	}	

    //---------------SUCCESS
      	else {
      		$data['success'] = true;
        	$location = $result['location'];
        	$state_id = get_state_id_from_code ($result['state_code']);
        	update_my_profile_info($gender, $location);
        	update_my_extended_location($state_id, $country_id);
        	$data['url'] = 'sign_up.php?2';
        	$data['loc'] = $location;
        	$data['state_id'] = $state_id;
      	}


		echo json_encode($data);

	//}    //isLoggedIn
	//else {
	//	do_redirect(get_domain());
	//}

?>