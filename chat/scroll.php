<?php
	require_once('ajax_header.php');

	if (isLoggedIn()) {
    	$chart_id = get_my_chart_id();
  	}
  	else {
    	$chart_id = get_guest_chart_id(get_guest_user_id());
  	}

	if(isset($_POST['search'])) {	//SEARCH PAGE OR MATCHES
		$data = array();
		$errors = array();
		if(!preg_match('%[\d]+%', $_POST['page'])) {
			$errors['page'] = 'the page request must be a number...';
		}
		else {
			$users_per_page = ($_POST['limit'] - 1);
			$one_above_limit = $_POST['limit'];
			$page = $_POST['page'];
			$begin = ($page - 1) * $users_per_page;
			$limit = $page * $users_per_page;
			$data['page'] = $page;
			$data['begin'] = $begin;
			$data['limit'] = $limit;
		}
		if (!$_POST['gender'] == 'none' || !$_POST['gender'] == 'M' || !$_POST['gender'] == 'F') {
			$errors['gender'] = 'There was an error with your gender selection.  Please try again';
		}
		else {
			$gender = trim($_POST['gender']);
			$data['gender'] = $gender;
		}
		if (!preg_match('%^[0-9]{1,3}$%', $_POST['low_bound'])) {
			$low_bound = 18;
			$data['low_bound'] = $low_bound;
		}
		elseif (trim($_POST['low_bound']) < 18) {
			$low_bound = 18;
			$data['low_bound'] = $low_bound;
		}
		else {
			$low_bound = trim($_POST['low_bound']);
			$data['low_bound'] = $low_bound;
		}
		if (!preg_match('%^[0-9]{1,3}$%', $_POST['high_bound'])) {
			$high_bound = 110;
			$data['high_bound'] = $high_bound;
		}
		elseif (trim($_POST['high_bound']) > 110) {
			$high_bound = 110;
			$data['high_bound'] = $high_bound;
		}
		else {
			$high_bound = trim($_POST['high_bound']);
			$data['high_bound'] = $high_bound;
		}

		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$age_low = CURRENT_YEAR() - $low_bound;
			$age_high = CURRENT_YEAR() - $high_bound;
			$low_bound = (string)$age_high . '-00-00'; //SWAP TO PUT IN QUERY IN CORRECT ORDER
			$high_bound = (string)$age_low . '-00-00';
			//$chart_id = get_my_chart_id();

			$user_list = get_user_list_search($gender, $low_bound, $high_bound, $begin, $one_above_limit);
			$user_array = query_to_array($user_list);
			if (count($user_array) > 24) {
				$data['next_page'] = $page + 1;
			}
			else {
				$data['end'] = true;
			}

			$new_users = array();
			$url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
			$upp = 0;
			foreach ($user_array as $user) {
				if ($upp < $users_per_page) {
                        $u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
                                //$u_pic = show_user_compare_picture($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                        		$u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                                //echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';   
                        $u2 = $u1 . $u_pic . '</div></div>'; 
                          	//$u_gen = show_general_info($user["chart_id"]);
                        $u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
                        $u3 = $u2 . $u_gen . '</div>';  
                    array_push($new_users, $u3);  
                } 
                else {
                    break;
                }
                $upp++;

            }
            
           	$data['new_users'] = $new_users;
           	//$data['user_array'] = $user_array;
		}

	}
	elseif (isset($_POST['nts'])) {	//NEW TO STARMA
		$data = array();
		$errors = array();
		if(!preg_match('%[\d]+%', $_POST['page'])) {
			$errors['page'] = 'the page request must be a number...';
		}
		else {
			$users_per_page = ($_POST['limit'] - 1);
			$one_above_limit = $_POST['limit'];
			$page = $_POST['page'];
			$begin = ($page - 1) * $users_per_page;
			$limit = $page * $users_per_page;
			$data['page'] = $page;
			$data['begin'] = $begin;
			$data['limit'] = $limit;
		}
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$user_list = get_user_list($begin, $one_above_limit);
			$user_array = query_to_array($user_list);
			if (count($user_array) > 24) {
				$data['next_page'] = $page + 1;
			}
			else {
				$data['end'] = true;
			}
			$new_users = array();
			$url = $_POST['url'];
			$upp = 0;
			foreach ($user_array as $user) {
				if ($upp < $users_per_page) {
                        $u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
                                //$u_pic = show_user_compare_picture($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                        		$u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                                //echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';   
                        $u2 = $u1 . $u_pic . '</div></div>'; 
                          	//$u_gen = show_general_info($user["chart_id"]);
                        $u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
                        $u3 = $u2 . $u_gen . '</div>';  
                    array_push($new_users, $u3);  
                } 
                else {
                    break;
                }
                $upp++;
			}
			$data['new_users'] = $new_users;
           	//$data['user_array'] = $user_array;
		}	
	}
	elseif (isset($_POST['celeb'])) {	//CELEBRITY SCROLL
		$data = array();
		$errors = array();
		
		if(!preg_match('%[\d]+%', $_POST['page'])) {
			$errors['page'] = 'the page request must be a number...';
		}
		else {
			$users_per_page = ($_POST['limit'] - 1);
			$one_above_limit = $_POST['limit'];
			$page = $_POST['page'];
			$begin = ($page - 1) * $users_per_page;
			$limit = $page * $users_per_page;
			$data['page'] = $page;
			$data['begin'] = $begin;
			$data['limit'] = $limit;
		}
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}

		else {
			$user_list = get_celebrity_user_list($begin, $one_above_limit);
			$user_array = query_to_array($user_list);
			if (count($user_array) > 24) {
				$data['next_page'] = $page + 1;
			}
			else {
				$data['end'] = true;
			}
			$new_users = array();
			$url = $_POST['url'];
	
			$upp = 0;
			foreach ($user_array as $user) {
				if ($upp < $users_per_page) {
					//$u3 = 'Hello' . $upp;
					
                        $u1 = '<div class="user_block js_user_' . $user["user_id"] . '"><div class="photo_border_wrapper_compare"><div class="compare_photo">';
                                //$u_pic = show_user_compare_picture($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                        		$u_pic = user_compare_picture_for_scroll ($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                                //echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';   
                        $u2 = $u1 . $u_pic . '</div></div>'; 
                          	//$u_gen = show_general_info($user["chart_id"]);
                        $u_gen = general_info_for_scroll($user["chart_id"], $user["user_id"]);
                        $u3 = $u2 . $u_gen . '</div>';  
                    
                    array_push($new_users, $u3);  
                } 
                else {
                    break;
                }
                $upp++;
			}
			
			//$data['new_users'] = 'celebrity';
			//$data['user_number'] = count($user_array);
			$data['new_users'] = $new_users;
           	
		}	
	}
	else {
		$data = 'Hello';
		
	}
	echo json_encode($data);

?>