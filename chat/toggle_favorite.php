<?php
require_once ("ajax_header.php");

  
$logged_in = login_check_point($type="full"); // took out $domain=$domain
	
	$data = array();

	//$favorite = (int) $_POST["toggle"];
	$favorite_user_id = (int) $_POST["other_user_id"];

	if (is_my_favorite($favorite_user_id)) {
		$toggle = 0;
	}
	else {
		$toggle = 1;
	}

	log_this_action (profile_action_favorite(), editted_basic_action(), $favorite_user_id, $toggle);
    toggle_my_favorite ($favorite_user_id, $toggle);

	if ($toggle == 1) {
		$data["remove"] = "Remove from Favorites";
	}
	else {
		$data["add"] = "Add to Favorites";
	}

	echo json_encode($data);

/*//OLD WAY
if (isset($_GET["favorite"]) && isset($_GET["favorite_user_id"])) {
  $favorite = (int) $_GET["favorite"];
  $favorite_user_id = (int) $_GET["favorite_user_id"];  
  
    log_this_action (profile_action_favorite(), editted_basic_action(), $favorite_user_id, $favorite);
    toggle_my_favorite ($favorite_user_id, $favorite);
    //echo $favorite_user_id. '<br>';
    //echo '*' . get_any_user_id_from_chart_id($favorite_user_id) . '*<br>';
    do_redirect( $url = get_domain() . '/main.php?the_page=cosel&the_left=nav1&tier=3&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . chart_already_there("Main", $favorite_user_id));   
  
}


else {
  do_redirect( $url = get_domain() . '/' . get_landing());

}
*/
?> 
