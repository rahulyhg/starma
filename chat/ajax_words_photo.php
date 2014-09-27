<?php
	
	require ('ajax_header.php');

//3 WORDS QUICK CHECK--------------------------------------------

	
	if(isset($_POST['word1_q'])) {
		$word1_quick = array();
		$word1_q = trim($_POST['word1_q']);

		if(contains_illegal_words($word1_q) || !preg_match('/^[a-zA-Z]+$/', $word1_q)) {
			$word1_quick['fixed1'] = false;
		}
		else {
			$word1_quick['fixed1'] = true;
		}
		echo json_encode($word1_quick);
	}
	if(isset($_POST['word2_q'])) {
		$word2_quick = array();
		$word2_q = trim($_POST['word2_q']);

		if(contains_illegal_words($word2_q) || !preg_match('/^[a-zA-Z]+$/', $word2_q)) {
			$word2_quick['fixed2'] = false;
		}
		else {
			$word2_quick['fixed2'] = true;
		}
		echo json_encode($word2_quick);
	}

	if(isset($_POST['word3_q'])) {
		$word3_quick = array();
		$word3_q = trim($_POST['word3_q']);

		if(contains_illegal_words($word3_q) || !preg_match('/^[a-zA-Z]+$/', $word3_q)) {
			$word3_quick['fixed3'] = false;
		}
		else {
			$word3_quick['fixed3'] = true;
		}
		echo json_encode($word3_quick);
	}

//3 WORDS CHECK------------------------------------------

	$data = array();
	$errors = array();

	if(isset($_POST['word_1'])) {
		//$word1_data = array();
		//$word1_error = array();

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
		
		//echo json_encode($word1_data);
	}

	if(isset($_POST['word_2'])) {
		//$word2_data = array();
		//$word2_error = array();

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
		//echo json_encode($word2_data);
	}

	if(isset($_POST['word_3'])) {
		//$word1_data = array();
		//$word3_error = array();

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
		//echo json_encode($word3_data);
	}

	//if(!get main photo has a photo associated) { $data['errors'] = need a pic }

	if(!empty($errors)) {
		$data['errors'] = $errors;
	}
	else {
		$data['success'] = true;
		$data['url'] = 'sign_up.php?3';
		//update_descriptors (array($des_name_1, $des_name_2, $des_name_3));
	}

	if (isset($_POST['words'])) {
		echo json_encode($data);
	}

?>