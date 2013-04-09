<?php
 
#### Validation functions ####

#### Error Constants ####

function USERNAME_ERROR() {
  return 0;
}

function DATE_ERROR() {
  return 1;
}

function EMAIL_ERROR() {
  return 2;
}

function PASSWORD_ERROR() {
  return 3;
}

function TOKEN_ERROR() {
  return 4;
}

function TERMS_ERROR() {
  return 5;
}

function USER_EXISTS_ERROR() {
  return 6;
}

function EMAIL_NO_MATCH_ERROR() {
  return 7;
}
    
### End Error Constants ###

function valid_chart_view($chart_id) {
  // everyone right now can see everyones's chart
  return true;
}


function valid_photo($photo_id, $user_id) {
  $q = "SELECT picture from user_picture where user_id = " . $user_id . " and user_pic_id = " . $photo_id;
  $result = mysql_query($q) or die(mysql_error());
  return mysql_num_rows($result) >= 1;
}


function get_domain () {
  return 'starma.com';
}

function get_landing () {
  return 'landing.php';
}

function get_full_domain () {
  return 'https://www.' . get_domain();
}

function do_redirect ($url) {
  header( 'Location: https://www.' . $url);
}


/**********************BEGIN DEV SERVER DOMAIN AND REDIRECT FUNCTIONS************************************/

/*
function get_domain () {
  return '127.0.0.1:8080';
}

function get_landing () {
  return 'landing.php';
}

function get_full_domain () {
  return 'http://' . get_domain();
}

function do_redirect ($url) {
  header( 'Location: http://' . $url);
}
*/
/**********************END DEV SERVER DOMAIN AND REDIRECT FUNCTIONS************************************/

function validate_registration ($nickname, $password, $password2, $email, $email2, $year, $month, $day, $token) {
    $errors = array();
    
    //the first entry in the error array is reserved for a returned ID of a successful registration
    $errors[] = -1;
 
    
    if (!valid_nickname($nickname)) {
      $errors[] = USERNAME_ERROR();
    }


    if (!valid_password($password) || $password != $password2) {  
      $errors[] = PASSWORD_ERROR();
    
    }


 
    if (!valid_email($email)) {
      $errors[] = EMAIL_ERROR();
    }

    if ($email != $email2) {
      $errors[] = EMAIL_NO_MATCH_ERROR();
    }

    if (user_exists($email, $nickname)) {
      $errors[] = USER_EXISTS_ERROR();
    }



    if (!($birthday = strtotime($year . "-" . $month . "-" . $day))) {
      $errors[] = DATE_ERROR();
    }
  
    if (!($token_id = token_valid($token))) {
      $errors[] = TOKEN_ERROR();
    }
    //echo $year . "-" . $month . "-" . $day;
    //echo date("m-d-Y",$birthday);
    //die();

    
    return $errors;
    
}

function login_check_point($type="partial") {
  if (!isLoggedIn())
  {
    
    do_redirect( $url = get_domain() . '/' . get_landing());
    return false;
  }
  elseif ($type=="full") {
    if (!(get_my_chart() or permissions_check($req = 10))) {
      do_redirect( $url = get_domain() . '/process_login.php');
      //header( 'Location: http://www.' . $domain . '/process_login.php');   
      return false;
    }
    else {
           //set_my_online_status(1); 
           return true;
    }
    
  } 
  else {
    //set online status to "on"
    //set_my_online_status(1);
    return true;
  }
  
}

function token_valid ($token) {
  $q = 'SELECT * from token where token = "' . $token . '" and user_id = -1';
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($row = mysql_fetch_array($do_q)) {
    
    return $row["token_id"];
  }
  else {
    return false;
  }
}


function use_token ($token_id, $user_id) {
  $q = 'UPDATE token set user_id = ' . $user_id . ' WHERE token_id = ' . $token_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  return true;
}

function valid_email($email)
{
 
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
    {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++)
    {
        if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
            $local_array[$i]))
        {
            return false;
        }
    }
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
    { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2)
        {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++)
        {
            if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
            {
                return false;
            }
        }
    }
    return true;
}

 
function valid_nickname($nickname, $minlength = 3, $maxlength = 30)
{
 
    $nickname = trim($nickname);
 
    if (empty($nickname))
    {
        return false; // it was empty
    }
    if (strlen($nickname) > $maxlength)
    {
        return false; // to long
    }
    if (strlen($nickname) < $minlength)
    {
 
        return false; //toshort
    }
    //return true;
    $result = ereg("^[A-Za-z0-9_-]+$", $nickname); //only A-Z, a-z and 0-9 are allowed
 
    if ($result)
    {
        return true; // ok no invalid chars
    } else
    {
        return false; //invalid chars found
    }
 
    return false;
 
}
 
function valid_password($pass, $minlength = 6, $maxlength = 15)
{
    $pass = trim($pass);
 
    if (empty($pass))
    {
        return false;
    }
 
    if (strlen($pass) < $minlength)
    {
        return false;
    }
 
    if (strlen($pass) > $maxlength)
    {
        return false;
    }
 
    $result = ereg("^[A-Za-z0-9_\-]+$", $pass);
 
    if ($result)
    {
        return true;
    } else
    {
        return false;
    }
 
    return false;
 
}

function permissions_check ($req) {
  if (isset($_SESSION["permissions_id"])) {
    $my_permissions = $_SESSION["permissions_id"];
    if ($my_permissions >= $req) {
      return true;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}
 
?>