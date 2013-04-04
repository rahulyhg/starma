<?php
require_once "header.php"; 
?>
<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>
<?php
if (isset($_POST['register'])){

        //$output = registerNewUser($_POST['nickname'], $_POST['password'], $_POST['password2'], $_POST['email'], $_POST['email2'], $_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday'], $_POST['token']);
        $output = validate_registration($_POST['nickname'], $_POST['password'], $_POST['password'], $_POST['email'], $_POST['email2'], $_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday'], $_POST['token']);
      
        if (sizeof($output) <= 1)        
        {
                include ("agreement.php");        
	}
        else {
                
		show_registration_form($output); 
	}
 
} 
elseif (isset ($_POST['agreed'])){
  if ($_POST['agreed'] == 'Accept') {
    $output = registerNewUser($_POST['nickname'], $_POST['password'], $_POST['password2'], $_POST['email'], $_POST['email2'], $_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday'], $_POST['token']);
    if (sizeof($output) <= 1)        
    {
          log_this_action (account_action_user(), registered_basic_action(), -1, -1, -1, $output[0]);
          echo "Thank you for registering with Starma.com!  We have sent you an email with a verification link.  Please follow this link to activate your account.
	  
	  ";        
    }
    else {
        //print_r ($output);
        //echo $_POST["year_birthday"] . '-' . $_POST["month_birthday"] . '-' . $_POST["day_birthday"];
	show_registration_form($output); 
    }
    
  }
  else {
    do_redirect (get_domain() . '/' . get_landing());
  }
}
else {
// has not pressed the register button
	show_registration_form();	
}
 

?> 