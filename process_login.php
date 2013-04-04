<?php
require_once ("header.php");

if (!isLoggedIn())
{
    // user is not logged in.
    if (isset($_POST['Login']))
    {
        // retrieve the username and password sent from login form & check the login.
        if (checkLogin($_POST['email'], $_POST['password']))
        {
            if ($_POST["stay_logged_in"] == "on") {
              setcookie("email", $_POST['email'], time()+60*60*24*30, '/', get_domain(), true, true);
              setcookie("password", $_POST['password'], time()+60*60*24*30, '/', get_domain(), true, true);
            }
            if (get_my_chart() or permissions_check($req = 10)) {
              do_redirect( $url = get_domain() . '/' . get_landing());
              //echo "Logged in";
            }
            else {
              //show_birth_info_form(); 
              require ("birth_info_first_time.php");
            }
            
        } else
        {
            do_redirect( $url = get_domain() . '/' . get_landing() . '?error=1&email=' . $_POST["email"]);
        }
    } else
    {
        do_redirect( $url = get_domain() . '/' . get_landing());
    }
 
} else
{
    // The user is already loggedin, so we show the userbox.
    //show_userbox();
    if (get_my_chart() or permissions_check($req = 10)) {
      do_redirect( $url = get_domain() . '/' . get_landing());
      //echo "Logged in";
    }
    else {
      //show_birth_info_form(); 
      require ("birth_info_first_time.php");
    }
    //header( 'Location: http://' . $domain . '/index.php');

}
?> 
