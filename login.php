<?php
if (!isLoggedIn())
{
    // user is not logged in.
    if (isset($_POST['cmdlogin']))
    {
        // retrieve the username and password sent from login form & check the login.
        if (checkLogin($_POST['nickname'], $_POST['password']))
        {
            //show_userbox();
            header( 'Location: http://www.' . $domain . '/index.php');
            //header( 'Location: http://www.' . $domain . '/index.php');
        } else
        {
            echo "Incorrect Login information !";
            show_loginform();
        }
    } else
    {
        // User is not logged in and has not pressed the login button
        // so we show him the loginform
        show_loginform();
    }
 
} else
{
    // The user is already loggedin, so we show the userbox.
    //show_userbox();
    if (get_my_chart() or permissions_check($req = 10)) {
      header( 'Location: http://www.' . $domain . '/index.php');
      //echo "Logged in";
    }
    else {
      show_birth_info_form(); 
    }
    //header( 'Location: http://' . $domain . '/index.php');

}
?> 
