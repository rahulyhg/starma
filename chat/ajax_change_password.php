<?php
require_once("ajax_header.php");
 
if (isLoggedIn() == true) {
    
    $data = array();
    $errors = array();

    if (isset($_POST['oldpassword'])) {
      $pass_length = trim(strlen($_POST['password']));
      
      if (!validate_current_password(get_my_email(), $_POST['oldpassword'])) {
        $errors['oldpass'] = 'Your current password is incorrect'; 
      }
      elseif (($pass_length < 6) or ($pass_length > 15)) {
        $errors['pass_length'] = 'Your new password must be between 6 and 15 characters long';
      }  
      elseif ($_POST['password'] != $_POST['password2']) {
        $errors['mismatch'] = "Your new passwords didn't match";
      }
      elseif (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])) {
        $errors['characters'] = "Letters and numbers only please";
      }
      
      if (!empty($errors)) {
        $data['errors'] = $errors;
        $data['success'] = false;
      }
      else {
        $data['success'] = true;
        $oldpassword = trim(strip_tags($_POST['oldpassword']));
        $newpassword = trim(strip_tags($_POST['password']));
        $newpassword2 = trim(strip_tags($_POST['password2']));
        changePassword(get_my_email(), $oldpassword, $newpassword, $newpassword2);
      }

    }

    if (isset($_POST['create_pass'])) {
      $pass_length = trim(strlen($_POST['password']));

      if (($pass_length < 6) or ($pass_length > 15)) {
        $errors['pass_length'] = 'Your new password must be between 6 and 15 characters long';
      }  
      elseif ($_POST['password'] != $_POST['password2']) {
        $errors['mismatch'] = "Your new passwords didn't match";
      }
      elseif (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])) {
        $errors['characters'] = "Letters and numbers only please";
      }
      
      if (!empty($errors)) {
        $data['errors'] = $errors;
        $data['success'] = false;
      }
      else {
        $data['success'] = true;
        $newpassword = trim(strip_tags($_POST['password']));
        $newpassword2 = trim(strip_tags($_POST['password2']));
        //createPassword(get_my_email(), $newpassword, $newpassword2);
      }
    }
    

    echo json_encode($data);
 
} 
  
else {
	// user is not loggedin
    show_loginform();
}
 

 
?> 