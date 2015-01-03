<?php
require ('ajax_header.php');
	
	//echo 'Test';

 	if (isset($_POST['sign_up'])) {
 		//echo 'Test';
 		$data = array();
		$errors = array();

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
    	if (isset($_POST['word_1'])) {
    		$word_1 = trim($_POST['word_1']);
    	}
    	else {
    		$word_1 = '';
    	}
    	if (isset($_POST['word_2'])) {
    		$word_2 = trim($_POST['word_2']);
    	}
    	else {
    		$word_2 = '';
    	}
    	if (isset($_POST['word_3'])) {
    		$word_3 = trim($_POST['word_3']);
    	}
    	else {
    		$word_3 = '';
    	}

    	$word1 = valid_word($word_1);
    	$word2 = valid_word($word_2);
    	$word3 = valid_word($word_3);

	 //-------------GENDER
     	if (!valid_gender($gender)) {
        	$errors['gender'] = 'Please select a gender';
      	}

      	$result = parse_location_string($country_id, $zip, $city);

      	if (isset($result['country_id'])) {
      	  $errors['country_id'] = 'Please select a country';
      	}
      	elseif (isset($result['zip'])) {
      	  $errors['zip'] = 'Please enter a zip code';
      	}
      	elseif (isset($result['city'])) {
      	  $errors['city'] = 'Please enter a city';
      	}
      	elseif (isset($result['geocode_zip'])) {
      	  $errors['geocode_zip'] = 'Please check your zip code';
      	}
      	elseif (isset($result['geocode_city'])) {
      	  $errors['geocode_city'] = 'Please double check your city';
      	}

      	if ($word1 != 'good') {
      		$errors['word1'] = $word1;
      		//echo $errors['word1'];
      	}
      	if ($word2 != 'good') {
      		$errors['word2'] = $word2;
      	}
      	if ($word3 != 'good') {
      		$errors['word3'] = $word3;
      	}

      	/*
		elseif($word_1 == '') {
			$errors['word1'] = 'Please choose a word';
		}
		elseif (contains_illegal_words($word_1)) {
			$errors['word1'] = 'No naughty words please';
		}
		elseif (!preg_match('/^[a-zA-Z-]+$/', $word_1)) {
			$errors['word1'] = 'Letters only please';
		}
		

		elseif($word_2 == '') {
			$errors['word2'] = 'Please choose a word';
		}
		elseif(contains_illegal_words($word_2)) {
			$errors['word2'] = 'No naughty words please';
		}
		elseif (!preg_match('/^[a-zA-Z-]+$/', $word_2)) {
			$errors['word2'] = 'Letters only please';
		}


		elseif($word_3 == '') {
			$errors['word3'] = 'Please choose a word';
		}
		elseif(contains_illegal_words($word_3)) {
			$errors['word3'] = 'No naughty words please';
		}
		elseif (!preg_match('/^[a-zA-Z-]+$/', $word_3)) {
			$errors['word3'] = 'Letters only please';
		}
		*/

		elseif (!get_my_main_photo()) {
			$errors['photo'] = 'Please upload a photo';
		}

		if (isset($_POST['crop_error'])) {
			$errors['photo'] = 'Please upload another photo';
		}

    //--------------ERRORS
		if(!empty($errors)) {
			$data['errors'] = $errors;
			//echo '<br>errors: ';
			//print_r($errors);
		}
		else {
			$data['success'] = true;
			$data['url'] = 'main.php';
			$all_words = array($word_1, $word_2, $word_3);
			update_descriptors ($all_words);
			$location = $result['location'];
        	$state_id = get_state_id_from_code ($result['state_code']);
        	update_my_profile_info($gender, $location);
        	update_my_extended_location($state_id, $country_id);
        	$data['loc'] = $location;
        	$data['state_id'] = $state_id;
        	$data['state'] = get_state($state_id);
          	$data['gender'] = $gender;
		}
		echo json_encode($data);
	}

	

      	//3 WORDS QUICK CHECK--------------------------------------------

	
	if(isset($_POST['word1_q'])) {
		$w1_q = array();
		$word1_q = trim($_POST['word1_q']);
		if($word1_q != '') {
			if(contains_illegal_words($word1_q)) {
				$errors = 'No naughty words please';
			}
			if (!preg_match('/^[a-zA-Z-]+$/', $word1_q)) {
				$errors = 'Letters only please';
				//$word1_quick['fixed1'] = false;
			}
		}
		if (!empty($errors)) {
			$w1_q['errors'] = $errors;
		}

		echo json_encode($w1_q);
	}

	if(isset($_POST['word2_q'])) {
		$w2_q = array();
		$word2_q = trim($_POST['word2_q']);
		if($word2_q != '') {
			if(contains_illegal_words($word2_q)) {
				$errors = 'No naughty words please';
			}
			if (!preg_match('/^[a-zA-Z-]+$/', $word2_q)) {
				$errors = 'Letters only please';
				//$word1_quick['fixed1'] = false;
			}
		}


		if (!empty($errors)) {
			$w2_q['errors'] = $errors;
		}

		echo json_encode($w2_q);
	}

	if(isset($_POST['word3_q'])) {
		$w3_q = array();
		$word3_q = trim($_POST['word3_q']);
		if($word3_q != '') {
			if(contains_illegal_words($word3_q)) {
				$errors = 'No naughty words please';
			}
			if (!preg_match('/^[a-zA-Z-]+$/', $word3_q)) {
				$errors = 'Letters only please';
				//$word1_quick['fixed1'] = false;
			}
		}

		if (!empty($errors)) {
			$w3_q['errors'] = $errors;
		}

		echo json_encode($w3_q);
	}
	

?>