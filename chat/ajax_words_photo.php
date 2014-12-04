<?php
	
	require ('ajax_header.php');


//3 WORDS QUICK CHECK--------------------------------------------

	
	if(isset($_POST['word1_q'])) {
		$w1_q = array();
		$word1_q = trim($_POST['word1_q']);
		if($word1_q != '') {
			if(contains_illegal_words($word1_q)) {
				$errors = 'No naughty words please';
			}
			if (!preg_match('/^[a-zA-Z]+$/', $word1_q)) {
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
			if (!preg_match('/^[a-zA-Z]+$/', $word2_q)) {
				$errors = 'Letters only please';
				//$word1_quick['fixed1'] = false;
			}
		}
		/*
		if(contains_illegal_words($word2_q) || !preg_match('/^[a-zA-Z]+$/', $word2_q)) {
			$word2_quick['fixed2'] = false;
		}
		else {
			$word2_quick['fixed2'] = true;
		}
		*/

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
			if (!preg_match('/^[a-zA-Z]+$/', $word3_q)) {
				$errors = 'Letters only please';
				//$word1_quick['fixed1'] = false;
			}
		}
		/*
		if(contains_illegal_words($word3_q) || !preg_match('/^[a-zA-Z]+$/', $word3_q)) {
			$word3_quick['fixed3'] = false;
		}
		else {
			$word3_quick['fixed3'] = true;
		}
		*/
		if (!empty($errors)) {
			$w3_q['errors'] = $errors;
		}

		echo json_encode($w3_q);
	}
	

//3 WORDS CHECK------------------------------------------

	if (isset($_POST['words'])) {
		$data = array();
		$errors = array();

		if(isset($_POST['word_1'])) {
		//if (isset($_POST['word1_q'])) {
			//$word1_data = array();
			//$word1_error = array();
		//}

			if($_POST['word_1'] == '') {
				$word_1 = '';
				$word1_error = 'Go on, choose something fun';
			}
			else {
				$word_1 = trim($_POST['word_1']);

				if(contains_illegal_words($word_1)) {
					$word1_error = 'No naughty words please';
				}

				if (!preg_match('/^[a-zA-Z]+$/', $word_1)) {
					$word1_error = 'Letters only please';
				}
			}

			if(isset($word1_error)) {
				$errors['word1'] = $word1_error;
			}
		
			//if (isset($_POST['word1_q'])) {
			//	if(!empty($errors)) {
			//		$word1_data['errors'] = $errors;
			//	}
			//	echo json_encode($word1_data);
		}

		if(isset($_POST['word_2'])) {
			//if (isset($_POST['word2_q'])) {
			//	$word2_data = array();
			//	$word2_error = array();
			//}

			if($_POST['word_2'] == '') {
				$word_2 = '';
				$word2_error = 'Go on, choose something fun';
			}
			else {
				$word_2 = trim($_POST['word_2']);

				if(contains_illegal_words($word_2)) {
					$word2_error = 'No naughty words please...';
				}
				if (!preg_match('/^[a-zA-Z]+$/', $word_2)) {
					$word2_error = 'Letters only please';
				}
			}

			if(isset($word2_error)) {
				$errors['word2'] = $word2_error;
			}
		
		//	if (isset($_POST['word2_q'])) {
		//		if(!empty($errors)) {
		//			$word2_data['errors'] = $errors;
		//		}
		//		echo json_encode($word2_data);
		//	}
	}

		if(isset($_POST['word_3'])) {
			//if (isset($_POST['word3_q'])) {
			//	$word1_data = array();
			//	$word3_error = array();
			//}

			if($_POST['word_3'] == '') {
				$word_3 = '';
				$word3_error = 'Go on, choose something fun';
			}
			else {
				$word_3 = trim($_POST['word_3']);

				if(contains_illegal_words($word_3)) {
					$word3_error = 'No naughty words please...';
				}
				if (!preg_match('/^[a-zA-Z]+$/', $word_3)) {
					$word3_error = 'Letters only please';
				}
			}

			if(isset($word3_error)) {
				$errors['word3'] = $word3_error;
			}

			//if (isset($_POST['word3_q'])) {
			//	if(!empty($errors)) {
			//		$word3_data['errors'] = $errors;
			//	}
			//	echo json_encode($word3_data);
			//}
		}

		if (!get_my_main_photo()) {
			$errors['photo'] = 'Please upload a photo';
		}

		if (isset($_POST['crop_error'])) {
			$errors['photo'] = 'Please upload another photo';
		}

		if(!empty($errors)) {
			$data['errors'] = $errors;
			//echo '<br>errors: ';
			//print_r($errors);
		}
		else {
			$data['success'] = true;
			$data['url'] = 'sign_up.php?3';
			//echo '<br>word_1: ' . $word_1;
			//echo '<br>word_2: ' . $word_2;
			//echo '<br>word_3: ' . $word_3;
			$all_words = array($word_1, $word_2, $word_3);
			//echo '<br>all_words print_r: <br>';
			//print_r($all_words);
			//echo '<br>all_words: ' . $all_words;
			update_descriptors ($all_words);
		}
		echo json_encode($data);
	}
	/*
	echo '<br>hello';
	echo '<br>word_1: ' . trim($_POST['word_1']);
	echo '<br>word_2: ' . trim($_POST['word_2']);
	echo '<br>word_3: ' . trim($_POST['word_3']);
	$all_words = array($word_1, $word_2, $word_3);
	echo '<br>all_words print_r: <br>';
	print_r($all_words);
	echo '<br>all_words: ' . $all_words;
	*/

//PHOTO ERRORS--------------------------------------
	//if(!get main photo has a photo associated) { $data['errors'] = need a pic }
	/*
	if (isset($_POST['words'])) {
		if (!get_my_main_photo()) {
			$errors['photo'] = 'Please upload a photo';
		}

		if (isset($_POST['crop_error'])) {
			$errors['photo'] = 'Please upload another photo';
		}

		if(!empty($errors)) {
			$data['errors'] = $errors;
			//echo '<br>errors: ';
			//print_r($errors);
		}
		else {
			$data['success'] = true;
			$data['url'] = 'sign_up.php?3';
			//echo '<br>word_1: ' . $word_1;
			//echo '<br>word_2: ' . $word_2;
			//echo '<br>word_3: ' . $word_3;
			$all_words = array($word_1, $word_2, $word_3);
			//echo '<br>all_words print_r: <br>';
			//print_r($all_words);
			//echo '<br>all_words: ' . $all_words;
			update_descriptors ($all_words);
		}
		echo json_encode($data);
	}
	*/

?>