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
            
            if (isAdmin()) {
              //header( 'Location: http://www.' . $domain . '/index.php');
              do_redirect( $url = get_domain() . '/index.php');
            }
            else if (!sign_up_process_done()) {
              if (get_my_location() == "") {
                
                require ("gender_location_first_time.php");
              }
              else if (!my_descriptors_loaded() or !get_my_main_photo()) {
                
                require ("desc_photo_first_time.php");
              
              }
              else if (!get_my_chart()) {
                
                require ("birth_info_first_time.php");
              
              }
            }
            else {
              do_redirect( $url = get_domain() . '/' . get_landing());
              //echo "Logged in"; 
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
            if (isAdmin()) {
              //header( 'Location: http://www.' . $domain . '/index.php');
              do_redirect( $url = get_domain() . '/index.php');
            }
            else if (!sign_up_process_done()) {
              if (get_my_location() == "") {
                //show_gender_location_form(); 
                require ("gender_location_first_time.php");
              }
              else if (!my_descriptors_loaded() or !get_my_main_photo()) {
                
                require ("desc_photo_first_time.php");
              
              }
              else if (!get_my_chart()) {
                //show_birth_info_form(); 
                require ("birth_info_first_time.php");
              
              }
            }
            else {
              do_redirect( $url = get_domain() . '/' . get_landing());
              //echo "Logged in"; 
            }
}
?> 
