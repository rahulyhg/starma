<?php
require_once("ajax_header.php");
if (!isLoggedIn()) {
	$data = array();
	$errors = array();

	if (isset($_POST['email'])) {

		$e = $_POST['email'];

		if(!email_there($e)) {
			$errors['email'] = 'Invalid email';
		}
		if(!valid_email($e)) {
			$errors['email'] = 'Invalid email';
		}

	}
	else {
		$errors['email'] = 'Please enter your email';
	}

	if (isset($_POST['password'])) {
		$p = $_POST['password'];
		if(!valid_password($p)) {
			$errors['password'] = 'Invalid Password';
		}
	}
	else {
		$errors['password'] = 'Please enter your password';
	}
	if(!empty($errors)) {
		$data['errors'] = $errors;
		//$data['success'] = false;
		echo json_encode($data);
	}
	else {
		if(checkLogin($e, $p)) {
			if ($_POST["stay_logged_in"] == "on") {
              	setcookie("email", $_POST['email'], time()+60*60*24*30, '/', get_domain(), true, true);
              	setcookie("password", $_POST['password'], time()+60*60*24*30, '/', get_domain(), true, true);
        	}
        	if (isAdmin()) {
              //header( 'Location: http://www.' . $domain . '/index.php');
              do_redirect( $url = get_domain() . '/index.php');
            }
            else if (!sign_up_process_done()) {
              if (get_my_location() == "") {
                
                require ("gender_location_first_time.php");
              }
              else if (!my_descriptors_loaded() or !get_my_main_photo()) {
                
                require ("desc_photo_first_time.php");
              
              }
              else if (!get_my_chart()) {
                
                require ("birth_info_first_time.php");
              
              }
            }
            else {
              do_redirect( $url = get_domain() . '/' . get_landing());
              //echo "Logged in"; 
            }
        }
        else {
        	$errors['login'] = 'There was an error loggin you in.  Please try again later.';
        	$data['errors'] = $errors;
        	echo json_encode($data);
        }

	}
}
else {
	if (isAdmin()) {
        //header( 'Location: http://www.' . $domain . '/index.php');
        do_redirect( $url = get_domain() . '/index.php');
    }
    elseif (!sign_up_process_done()) {
        if (get_my_location() == "") {
            //show_gender_location_form(); 
            require ("gender_location_first_time.php");
        }
        elseif (!my_descriptors_loaded() or !get_my_main_photo()) {
			require ("desc_photo_first_time.php");
 		}
        elseif (!get_my_chart()) {
            //show_birth_info_form(); 
            require ("birth_info_first_time.php");
              
        }
    }
    else {
        do_redirect( $url = get_domain() . '/' . get_landing());
         //echo "Logged in"; 
    }
}





?>