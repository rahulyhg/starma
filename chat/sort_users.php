<?php
	require_once('ajax_header.php');

	
	if (isset($_POST['sort_by_sign'])) {
		$data = array();
		$errors = array();
		$sign_id = $_POST['sign_id'];
		if (!preg_match('%^[0-9]$%', $sign_id)) {
			$errors['valid'] = 'something is wrong with this sign...';
		}
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$users_per_page = 24;
			//$data['sign'] = get_sign_name($sign_id);
			//$data['sign'] = $sign_id
			$user_list = get_user_list_from_sign(1, $sign_id, 0, 24);
			$user_array = query_to_array($user_list);
			$users_found = array();
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
                    array_push($users_found, $u3);  
                } 
                else {
                    break;
                }
                $upp++;

            }
            
           	$data['users_found'] = $users_found;
		}
		
		//$data = get_sign_name(4);
		echo json_encode($data);
	}



?>