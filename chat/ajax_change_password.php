<?php
require_once("ajax_header.php");
 
if (isLoggedIn() == true) {
    
    $data = array();
    $errors = array();
    
    if (!strlen($_POST['password']) < 6) {
      
        if (validate_current_password(get_my_email(), $_POST['oldpassword'])) {
            changePassword(get_my_email(), $_POST['oldpassword'], $_POST['password'], $_POST['password2']);
            $data['pass'] = true; 
            //echo "Your password has been changed ! <br /> <a href='./index.php'>Return to homepage</a>";
        } 
        else {
           //do_redirect ($url=get_domain() . "/main.php?the_left=nav1&the_page=ssel&error=1"); 
           $errors['oldpass'] = 'Your current password is incorrect'; 
        }
  
      }
      else {
        $errors['pass_length'] = 'Your password must be at least 6 characters long';
      }

      if (!empty($errors)) {
          $data['errors'] = $errors;
          $data['success'] = false;
      }
      else {
          $data['success'] = true;
      }

      echo json_encode($data);
 
    } 
    //else {
      //  show_changepassword_form(); 
    //}
  
else {
	// user is not loggedin
    show_loginform();
}
 

 
?> 