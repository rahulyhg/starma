<?php
	require_once('ajax_header.php');

	$data = array();
	$errors = array();
	if (isLoggedIn()) {
    	$chart_id = get_my_chart_id();
  	}
  	else {
    	$chart_id = get_guest_chart_id(get_guest_user_id());
  	}


//EMAIL SEARCH-----------------------------

	if (isset($_POST['email'])) {
		$e = trim($_POST['email']);
		if (!valid_email($e)) {
			$errors['email'] = 'Sorry!  We couldn\'t find a user with that email.  Maybe you should invite them...';
		}
		elseif (!email_exists($e)) {
			$errors['email'] = 'Sorry!  We couldn\'t find a user with that email.  Maybe you should invite them...';
		}
		else {
			$e = mysql_real_escape_string($e);
		}
		if (!$user = get_user_from_email($e)) {
			$errors['user'] = 'Sorry!  We couldn\'t find a user with that email.  Maybe you should invite them...';
		}

		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
			
			$u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
            $u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user['chart_id'], $user["user_id"]);   
            $u2 = $u1 . $u_pic . '</div></div>'; 
            $u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
            $u3 = $u2 . $u_gen . '</div>';  

            $data['user'] = $u3;
            //$data['user'] = true;
            //$data['user_id'] = $user['user_id'];
            //$data['chart_id'] = $chart_id2;
		}
	}


//USERNAME SEARCH-----------------------------

	if (isset($_POST['username'])) {
		$u = trim($_POST['username']);
		if (!valid_username($u) == 'good') {
			$errors['username'] = 'Sorry!  We couldn\'t find a user with that name.  Maybe you should invite them...';
		}
		else {
			$u = mysql_real_escape_string($u);
			if (!$user_array = get_user_from_username($u)) {
				$errors['user'] = 'Sorry!  We couldn\'t find a user with that name.  Maybe you should invite them...';
			}
		}
		
		//elseif (!username_exists($u)) {
		//	$errors['username'] = 'Sorry!  We couldn\'t find a user with that name.  Maybe you should invite them...';
		//}
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$users = query_to_array($user_array);
			$url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
			$users_found = array();

			foreach ($users as $user) {
				$u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
            	$u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);   
            	$u2 = $u1 . $u_pic . '</div></div>'; 
            	$u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
            	$u3 = $u2 . $u_gen . '</div>'; 

            	array_push($users_found, $u3);
			}
			
            $data['users_found'] = $users_found;
        }
	}


//CELEB SEARCH-----------------------------	

	if (isset($_POST['celebname'])) {
		$c = trim($_POST['celebname']);
		if (preg_match('%[^a-zA-Z\'-\s]%', $c)) {
			$errors['celebname'] = 'That name can\'t be right...';
		}
		//elseif (!celeb_exists($c)) {
		//	$errors['celebname'] = 'Sorry!  We couldn\'t find a celebrity with that name. If you would like us to try to add a celebrity, please <a href="mailto:contact@starma.com">contact us</a>';
		//}
		else {
			$c = mysql_real_escape_string(str_replace(' ', '', $c));
			if (!$user_array = get_celeb_from_celebname($c)) {
				$errors['celeb'] = 'Sorry!  We couldn\'t find a celebrity with that name. If you would like us to try to add a celebrity, please <a href="mailto:contact@starma.com">contact us</a>';
			}
		}
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$celebs = query_to_array($user_array);
			$url = '?the_page=cesel&the_left=nav1&tier=3&stage=2';
			$users_found = array();

			foreach ($celebs as $celeb) {
				$u1 = '<div class="user_block js_user_' . $celeb["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
            	$u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $celeb["chart_id"], $celeb["user_id"]);   
            	$u2 = $u1 . $u_pic . '</div></div>'; 
            	$u_gen = general_info_for_scroll($celeb["chart_id"], $celeb["user_id"]);
            	$u3 = $u2 . $u_gen . '</div>'; 

            	array_push($users_found, $u3);
			}
			
            $data['users_found'] = $users_found;
        }
	}

	echo json_encode($data);

?>