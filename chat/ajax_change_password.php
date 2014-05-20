<?php
require_once("ajax_header.php");
 
if (isLoggedIn() == true) {
    
    $data = array();
    $errors = array();
    $pass_length = trim(strlen($_POST['password']));
  if (!validate_current_password(get_my_email(), $_POST['oldpassword'])) {
    $errors['oldpass'] = 'Your current password is incorrect'; 
  }

  elseif (($pass_length <= 6) or ($pass_length >= 15)) {
    $errors['pass_length'] = 'Your new password must be between 6 and 15 characters long';
  }  

  elseif ($_POST['password'] != $_POST['password2']) {
    $errors['mismatch'] = "Your new passwords didn't match";
  }
  
  else {
    changePassword(get_my_email(), $_POST['oldpassword'], $_POST['password'], $_POST['password2']);
    $data['pass'] = true; 
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