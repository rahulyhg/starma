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
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
			$user = get_user_from_email($e);

			
			$u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
            $u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);   
            $u2 = $u1 . $u_pic . '</div></div>'; 
            $u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
            $u3 = $u2 . $u_gen . '</div>';  

            $data['user'] = $u3;
		}
	}

	if (isset($_POST['username'])) {
		$u = trim($_POST['username']);
		if (!valid_username($u) == 'good') {
			$errors['username'] = 'Sorry!  We couldn\'t find a user with that name.  Maybe you should invite them...';
		}
		elseif (!username_exists($u)) {
			$errors['username'] = 'Sorry!  We couldn\'t find a user with that name.  Maybe you should invite them...';
		}
		else {
			$u = mysql_real_escape_string($u);
		}

		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
			$user = get_user_from_username($u);
             
            $u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
            $u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);   
            $u2 = $u1 . $u_pic . '</div></div>'; 
            $u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
            $u3 = $u2 . $u_gen . '</div>';  

            $data['user'] = $u3;
        }
	}

	echo json_encode($data);

?>