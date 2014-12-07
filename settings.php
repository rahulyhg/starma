<?php
 
require_once ("header.php");
 
if (isLoggedIn() == true)
{
 
 /*   if (isset($_POST['change_pass'])) {
 
        if (changePassword(get_my_email(), $_POST['oldpassword'], $_POST['password'],
            $_POST['password2']))
        {
            echo "Your password has been changed ! <br /> <a href='./index.php'>Return to homepage</a>";
 
        } else
        {
           do_redirect ($url=get_domain() . "/main.php?the_left=nav1&the_page=ssel&error=1"); 
            
        }
 
    }*/ 
    //else {

    echo '<div id="settings">';
        echo '<div id="settings_forms">';
            echo '<div id="password">';
                show_changepassword_form(); 
            echo '</div>';

            echo '<div id="privacy">';
                show_privacy_form();
            echo '</div>';

            echo '<div id="tutorials">';
                show_tutorials_form();
            echo '</div>';
        echo '</div>';
    echo '</div>';
    //}
 echo '<script type="text/javascript" src="/js/settings_ui.js"></script>';
} 
else {
	// user is not loggedin
    show_loginform();
}
 

 
?> 