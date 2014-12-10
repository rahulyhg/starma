<?php
 
#### Login Functions #####

function cookieSet () {
  return (isset($_COOKIE['email']) && isset($_COOKIE['password']));
} 

function cookieValid () {
  if (cookieSet ()) {
    return (checkLogin($_COOKIE['email'], $_COOKIE['password']));
  }
  else {
    return false;
  }
  
  
}


function isLoggedIn()
{
    //echo '*' . $_SESSION['user_id'] . '*';
    if (isset($_SESSION['user_id']) && isset($_SESSION['nickname']))
    {
        return true; // the user is loged in
    } 
    elseif (cookieValid()) {
        
        return true; //cookie is available, log in that way
    }
    else
    {
        return false; // not logged in
    }
 
    return false;
 
}


//checkLogin is DEPRECATED---
 
function checkLogin($u, $p)
{
global $seed; // global because $seed is declared in the header.php file
 

    //if (!email_there($u) || !valid_password($p))
    //{
    //    return false; // the name was not valid, or the password, or the username did not exist
    //}
    

    //Now let us look for the user in the database.
    $query = sprintf("
		SELECT user_id, permissions_id, email, nickname 
		FROM user
		WHERE 
		email = '%s' AND password = '%s' 
		AND disabled = 0 AND activated = 1 
		LIMIT 1;", mysql_real_escape_string($u), mysql_real_escape_string(sha1($p . $seed)));
    
    $result = mysql_query($query);
    // If the database returns a 0 as result we know the login information is incorrect.
    // If the database returns a 1 as result we know  the login was correct and we proceed.
    // If the database returns a result > 1 there are multple users
    // with the same username and password, so the login will fail.
    if (mysql_num_rows($result) != 1)
    {
        return false;
    } else
    {
        // Log the User In
        $row = mysql_fetch_array($result);
        loginUser($row['user_id'], $row['email'], $row['nickname'], $row['permissions_id']);
        return true;
    }
    return false;
}



function loginUser($user_id, $email, $nickname, $permissions_id) {
        // Save the user ID for use later
        $_SESSION['user_id'] = $user_id;
        // Save the email for use later
        $_SESSION['email'] = $email;
        // Save the username for use later
        $_SESSION['nickname'] = $nickname;
        //save the permissions id
        $_SESSION['permissions_id'] = $permissions_id;
        //save Facebook ID
        if ($fb_id = get_fb_id($user_id)) {
            $_SESSION['fb_id'] = $fb_id;
        }
        //Log the Login
        log_this_action (login_action(), login_basic_action());
}
 
?>