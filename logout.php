<?php 
require_once ("header.php");
//Log the Logout
log_this_action (login_action(), logout_basic_action());
//set_my_online_status(0);
// Nuke the cookies
setcookie("email", $_POST['email'], time()-60*60*24*30, '/', get_domain(), true, true);
setcookie("password", $_POST['password'], time()-60*60*24*30, '/', get_domain(), true, true);
if( session_unregister('user_id') == true && session_unregister('username')==true && session_unregister('permissions_id') == true && session_unregister('email')==true ) {
    session_destroy();
	header('Location: index.php');
  } else {
   
   unset($_SESSION['user_id']);
   unset($_SESSION['nickname']);
   unset($_SESSION['email']);
   unset($_SESSION['permissions_id']);
   session_destroy();
   header('Location: index.php');
}
?> 
