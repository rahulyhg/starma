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

    echo '<div id="msg_sheen" class="chartcb_confirm_box">';
        echo '<div id="msg_sheen_screen" class="chartcb_confirm_box"></div>';
            echo '<div id="msg_sheen_content_chartcb" class="chartcb_confirm_box">';
                echo '<div id="chartcb_confirm_box">';
                    echo '<div id="chartcb_confirm_text" class="later_on">By choosing to keep your birth chart private your personal Birth Chart, House Lords, and Astrologers View will be invisible to other users.  However, other users\' Birth Charts, House Lords and Astrologers View will be invisible to you.  Because of this you won\'t be able to test your compatibility with other users and they won\'t be able to test their compatibility with you.  Ar you sure you want to choose this option?</div>';
                    echo '<div style="margin-top:10px;">';
                        echo '<div class="later_on pointer" id="chartcb_cancel">Cancel</div>';
                        echo '<div class="later_on pointer" id="chartcb_confirm">Confirm</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
    echo '</div>';

    echo '<div id="msg_sheen" class="change_username_box">';
        echo '<div id="msg_sheen_screen" class="change_username_box"></div>';
            echo '<div id="msg_sheen_content_chartcb" class="change_username_box">';
                echo '<div id="change_username_box">';
                    echo '<div id="change_username_text" class="later_on">You may choose any username that is not currently in use.  If you want more anonymity on Starma, choose a username that none of your friends or family will recognize.</div>';
                    echo '<div id="u_err_exp"></div>';
                    echo '<input id="username" maxlength="14" class="input_style" type="text" placeholder="New Username" />';
                    echo '<div style="margin-top:10px;">';
                        echo '<div class="later_on pointer" id="username_cancel">Cancel</div>';
                        echo '<div class="later_on pointer" id="username_confirm">Confirm</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
    echo '</div>';

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