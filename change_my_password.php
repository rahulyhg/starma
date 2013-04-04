<?php
 
require_once "header.php";
 
if (isLoggedIn() == true)
{
 
    if (isset($_POST['change']))
    {
 
        if (changePassword(get_my_email(), $_POST['oldpassword'], $_POST['password'],
            $_POST['password2']))
        {
            echo "Your password has been changed ! <br /> <a href='./index.php'>Return to homepage</a>";
 
        } else
        {
           do_redirect ($url=get_domain() . "/main.php?the_left=nav1&the_page=ssel&error=1"); 
            
        }
 
    } else
    {
        show_changepassword_form(); 
    }
 
} else {
	// user is not loggedin
    show_loginform();
}
 

 
?> 