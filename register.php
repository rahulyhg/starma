<?php
require_once "header.php"; 
?>
<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>
<?php
$validated = false;
$output = array();
if (isset($_POST['register'])){

        
        if (isset($_POST["agreement"])) {
          $agreement = 'plegalblot7';
        }
        else {
          $agreement = 'frizz';
        }
        $output = validate_registration($_POST['nickname'], $_POST['password'], $_POST['password'], $_POST['email'], $_POST['email2'], $_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday'], $agreement);
      
        if (sizeof($output) <= 1)        
        {
                //include ("agreement.php");        
                $validated = true;

                
	}
        //else {
                
	//	show_registration_form($output); 
	//}
 
} 
//elseif (isset ($_POST['agreed'])){
if ($validated) {
  //if ($_POST['agreed'] == 'Accept') {
    $output = registerNewUser($_POST['nickname'], $_POST['password'], $_POST['password'], $_POST['email'], $_POST['email2'], $_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday'], $agreement);
    if (sizeof($output) <= 1)        
    {
          log_this_action (account_action_user(), registered_basic_action(), -1, -1, -1, $output[0]);
          $user = get_profile($user_id=$output[0]);
          loginUser($user_id = $user['user_id'], $email=$user['email'], $nickname=$user['nickname'], $permissions_id=$user['permissions_id']);
          do_redirect( $url = get_domain() . '/' . get_landing());
          //echo "Thank you for registering with Starma.com!  We have sent you an email with a verification link.  Please follow this link to activate your account.";        
          
    }
    else {
        //print_r ($output);
        //echo $_POST["year_birthday"] . '-' . $_POST["month_birthday"] . '-' . $_POST["day_birthday"];
	show_registration_form($output); 
    }
    
  //}
  //else {
  //  do_redirect (get_domain() . '/' . get_landing());
  //}
}
else {
	show_registration_form($output);	
}
 

?> 