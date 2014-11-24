<?php
	require_once('ajax_header.php');

	$data = array();
	$errors = array();

	if (isset($_POST['fb_id'])) {
		$_SESSION['fb_id'] = $_POST['fb_id'];
		$data['fb_id'] = $_SESSION['fb_id'];
		$data['check'] = 'got through';
	}

	if (isset($_POST['exist'])) {
		if (!$user_id = get_user_id_from_fb_id($_SESSION['fb_id'])) {
			$errors['user_id'] = 'Could not obtain user id';
			
		}
		else {
			if (!$user = user_exists_from_id($user_id)) {
				$errors['exists'] = 'does not exist';
			}
			//else {
			//	$data['user'] = $user;
			//}
		}
		//if (!loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id'], $_SESSION['fb_id'])) {
		//	$errors['login'] = 'error at login';
		//}
		
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$data['success'] = true;
			loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id'], $_SESSION['fb_id']);
			set_my_preference('fb_connected', 1);
		}

	}

	if (isset($_POST['reconnect_fb'])) {
		if(!set_my_preference('fb_connected', 1)) {
			$errors['set'] = 'Unable to set preference';
		}
		else {
			$data['success'] = true;
		}
	}


//FIND FB FRIENDS--------------------------------


	/*
	if (isset($_POST['fb_friends'])) {
		if (!$user_list = get_fb_users()) {
			$errors['fb_friends'] = 'There was a problem accessing your Facebook friends';
		}
		else {
			$user_array = query_to_array($user_list);
			$url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
			$fb_friends = array();
			$fb_ids = array();
			foreach ($user_array as $user) {
			
				$u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
                
                $u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                  
                $u2 = $u1 . $u_pic . '</div></div>'; 
                          	
                $u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
                $u3 = $u2 . $u_gen . '</div>';  
				
				$id = $user['fb_id'];

				array_push($fb_friends, $u3); 
				array_push($fb_ids, $id); 
            } 
			
			$data['fb_friends'] = $fb_friends;
			$data['fb_ids'] = $fb_ids;
		}
	}
	*/

	if (isset($_POST['fb_friends'])) {
		if (!$fb_id_list = get_fb_ids()) {
			$errors['fb_friends'] = 'There was a problem accessing your Facebook friends';
		}
		else {
			$fb_ids = query_to_array($fb_id_list);
			$data['fb_ids'] = $fb_ids;
		}
		
	}

	if (isset($_POST['fb_f_ids'])) {
		$data['fb_f_ids'] = $_POST['fb_f_ids'];
		$data['test'] = 'hello';
	}

	if (isset($_POST['fb_f_loop_id'])){
		$fb_id = $_POST['fb_f_loop_id'];
		if (!$user_q = get_single_fb_user($fb_id)) {
			$errors['fb_friends'] = 'There was a problem accessing your Facebook friends';
		}
		else {
			$user = query_to_array($user_q);
			$url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
			
				$u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
                
                $u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                  
                $u2 = $u1 . $u_pic . '</div></div>'; 
                          	
                $u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
                $u3 = $u2 . $u_gen . '</div>';  
				
				//$id = $user['fb_id'];
			
			$data['fb_friend'] = $u3;
			//$data['fb_ids'] = $fb_ids;
		}
		//$data['fb_f_loop_id'] = $_POST['fb_f_loop_id'];
	}


	echo json_encode($data);

?>