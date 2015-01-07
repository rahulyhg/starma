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

function UNDERAGE_ERROR() {
  return 8;
}

function NOT_WORDS_ERROR() {
  return 9;
}

function PHOTO_ERROR() {
  return 10;
}

function ILLEGAL_WORDS_ERROR() {
  return 11;
}
    
### End Error Constants ###

/* USER-AGENTS ================================================== */
function check_user_agent ( $type = NULL ) {
        $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
        if ( $type == 'bot' ) {
                // matches popular bots
                if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                        return true;
                        // watchmouse|pingdom\.com are "uptime services"
                }
        } else if ( $type == 'browser' ) {
                // matches core browser types
                if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                        return true;
                }
        } else if ( $type == 'mobile' ) {
                // matches popular mobile devices that have small screens and/or touch inputs
                // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
                // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
                if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                        // these are the most common
                        return true;
                } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                        // these are less common, and might not be worth checking
                        return true;
                }
        }
        return false;
}
/* END USER AGENTS ================================================== */

function valid_chart_view($chart_id) {
  // everyone right now can see everyones's chart
  return true;
}


function valid_photo($photo_id, $user_id) {
  $q = "SELECT picture from user_picture where user_id = " . $user_id . " and user_pic_id = " . $photo_id;
  $result = mysql_query($q) or die(mysql_error());
  return mysql_num_rows($result) >= 1;
}

/*
function get_email_domain() {
  return 'starma.com';
}


function get_domain_sign_up ($n) {
  return 'starma.com/sign_up.php?' . $n;
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
*/

/**********************BEGIN STAGING SERVER DOMAIN AND REDIRECT FUNCTIONS************************************/

function get_email_domain() {
  return 'starma.com';
}


function get_domain_sign_up ($n) {
  return 'starma.com/sign_up.php?' . $n;
}

function get_domain () {
  return 'starma.com';
}

function get_landing () {
  return 'landing.php';
}

function get_full_domain () {
  return 'http://dev.' . get_domain();
}

function do_redirect ($url) {
  header( 'Location: http://dev.' . $url);
}

/**********************END STAGING SERVER DOMAIN AND REDIRECT FUNCTIONS************************************/

/**********************BEGIN LOCAL DEV SERVER DOMAIN AND REDIRECT FUNCTIONS************************************/

/*
function get_domain () {
  return '127.0.0.1:8080';
  //return '192.168.1.141:8080';
}

function get_domain_sign_up () {
  return '127.0.0.1:8080/sign_up.php';
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

/**********************END LOCAL DEV SERVER DOMAIN AND REDIRECT FUNCTIONS************************************/


//UPDATED BY MATT FOR AJAX CLEAN SIGN UP
function validate_registration ($nickname, $password, $password2, $email, $year, $month, $day) {
    $errors = array();
    
    //the first entry in the error array is reserved for a returned ID of a successful registration
    $errors[] = -1;
 
    
    if (!valid_nickname($nickname)) {
      //$errors[] = USERNAME_ERROR();
      $errors['username'] = 'Please enter a valid username';
    }


    if (!valid_password($password) || $password != $password2) {  
      //$errors[] = PASSWORD_ERROR();
      $errors['password'] = 'Please enter a valid password';
    }


 
    if (!valid_email($email)) {
      //$errors[] = EMAIL_ERROR();
      $errors['email'] = 'Please enter a valid email';
    }

    //if ($email != $email2) {
      //$errors[] = EMAIL_NO_MATCH_ERROR();
      //$errors['email2'] = 'Emails must match';
    //}

    if (user_exists($email, $nickname)) {
      //$errors[] = USER_EXISTS_ERROR();
      $errors['user_exists'] = 'This user already exists';
    }

    $birthday = $year . "-" . $month . "-" . $day;    

    if (!(strtotime($birthday))) {
      //$errors[] = DATE_ERROR();
      $errors['strtotime'] = 'There was an error storing your birthday.  Please try again later';
    }
    elseif ((int)(calculate_age(substr((string)$birthday, 0, 10))) < 18) {
      
      
        //echo substr((string)$birthday, 0, 10) . '<br>';
        //echo (int)(calculate_age(substr((string)$birthday, 0, 10)));
        //die();
        //$errors[] = UNDERAGE_ERROR();
        $errors['underage'] = 'You must be at least 18 to join Starma.com';
    }
  
    return $errors;
    
}


//FACEBOOK VALIDATE USER

function validate_registration_fb ($nickname_fb, $email_fb, $year_fb, $month_fb, $day_fb) {
    $errors = array();
    
    //the first entry in the error array is reserved for a returned ID of a successful registration
    $errors[] = -1;
 
    
    if (!valid_nickname($nickname_fb)) {
      //$errors[] = USERNAME_ERROR();
      $errors['username'] = 'Please enter a valid username';
    }

    if (!valid_email($email_fb)) {
      //$errors[] = EMAIL_ERROR();
      $errors['email'] = 'Please enter a valid email';
    }

    //if ($email != $email2) {
      //$errors[] = EMAIL_NO_MATCH_ERROR();
      //$errors['email2'] = 'Emails must match';
    //}

    if (user_exists($email_fb, $nickname_fb)) {
      //$errors[] = USER_EXISTS_ERROR();
      $errors['user_exists'] = 'This user already exists';
    }

    $birthday_fb = $year_fb . "-" . $month_fb . "-" . $day_fb;    

    if (!(strtotime($birthday_fb))) {
      //$errors[] = DATE_ERROR();
      $errors['strtotime'] = 'There was an error storing your birthday.  Please try again later';
    }
    elseif ((int)(calculate_age(substr((string)$birthday_fb, 0, 10))) < 18) {
      
      
        //echo substr((string)$birthday, 0, 10) . '<br>';
        //echo (int)(calculate_age(substr((string)$birthday, 0, 10)));
        //die();
        //$errors[] = UNDERAGE_ERROR();
        $errors['underage'] = 'You must be at least 18 to join Starma.com';
    }
    
    return $errors;
    
}

function login_check_point($type="partial") {
  
  if (!isLoggedIn())
  {
    $path = $_SERVER['REQUEST_URI'];
    if ($path != "/landing.php") {
       $_SESSION["post_login_path"] = $path;
    }
    do_redirect( $url = get_domain() . '/' . get_landing());
    return false;
  }
  else if (isAdmin()) {
    return true;
  }
  else if ($type=="full") {
    if (!sign_up_process_done()) {
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

function parse_location_string ($country_id, $zip, $city) {

  $errors = array();
  //$errors[] = 0;
  //if ($from == 'gl') {
    if ($country_id == 0) {
      $errors['country_id'] = true;
      //$errors['country_id'] = 'Please select a country';
      return $errors;
    }
    else {
      if ($country_id == 236) {
        if ($zip == '') {
          //$errors['zip'] = 'Please enter a zip code';
          //$location_string = '';
          $errors['zip'] = true;
          return $errors;
        }
        elseif (!preg_match('%\d{5}%', $zip)) {
          //$errors['zip'] = 'Please enter a zip code';
          $location_string = '';
          $errors['zip'] = true;
          return $errors;
        }
        else {
          $location_string = $zip . ' US';
          $type='postalCodeSearch?placename';
        }
      }
      else {
        if ($city == '') {
          //$errors['city'] = 'Please enter a city';
          $location_string = '';
          $errors['city'] = true;
          return $errors;
        }
        else {
          $country = get_country($country_id);
          //$data['country'] = $country;
          $location_string = exceptionizer($city . ', ' . $country["country_title"]);  
          //echo '*' . $location_string . '*'; die();
          $type="wikipediaSearch?q";
        }
      }

  //------------GEOCODE_GL
      if ($location_string !== '') {
        if (!$result = geocode($location_string, $type)) {
          //$errors['geocode'] = 'Please check your zip code';
          //$errors['test'] = $location_string;
          if ($type == 'postalCodeSearch?placename') {
            $errors['geocode_zip'] = true;
          }
          if ($type == "wikipediaSearch?q") {
            $errors['geocode_city'] = true;
          }
          return $errors;
        }
        else {
          return $result;
        }

      }
    }
  //} 
}

function valid_word($word) {
  if ($word == '') {
    return 'Please choose a word';
  }
  elseif (contains_illegal_words($word)) {
    return 'No naughty words please';
  }
  elseif (!preg_match('/^[a-zA-Z-]+$/', $word)) {
    return 'Letters only please';
  }
  else {
    return 'good';
  }
}

function contains_illegal_words($nickname) {
  $q = 'SELECT * from banned_words WHERE disabled = 0';
  $do_q = mysql_query ($q) or die(mysql_error());
  //echo mysql_num_rows($do_q);
  while ($row = mysql_fetch_array($do_q)) {
    //echo $row["word"] . ' ---> ';
    //echo strpos(strtolower($nickname), $row["word"]);
    //echo '<br>';
    if (strpos(strtolower($nickname), $row["word"]) !== false) {
      return true;
    }
  }
  //die();
  return false;
}

function sanitize_input ($input) {
  $input = strip_tags($input);
  return $input;
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

function valid_gender ($gender) {
  if ($gender == "M" or $gender == "F") {
    return true;
  }
  else {
    return false;
  }
}

function valid_email($email)
{
 
    // First, we check that there's one @ symbol, and that the lengths are right
  
    //if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
    if (!preg_match("/[^@]{1,64}@[^@]{1,255}/", $email))
    {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++)
    {
        //if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
        if (!preg_match("/^(([A-Za-z0-9!#$%&#038;'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i]))
        {
            return false;
        }
    }
    //if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1]))
    { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2)
        {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++)
        {
            //if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i]))  
            {
                return false;
            }
        }
    }
    else { echo 'matched';}
    return true;
}

//************* Matt Added for Ajax Sign Up ******************//

function valid_username($username)
{
    $maxlength = 20;
    $minlength = 3;
    $username = trim($username);
 
    if (empty($username)) {
        return false; // it was empty
    }
    if (strlen($username) > $maxlength) {
        return 'long'; // to long
    }
    if (strlen($username) < $minlength) {
 
        return 'short'; //toshort
    }
    if (contains_illegal_words($username)) {
      return 'naughty';
    }

    if(username_exists($username)) {
      return 'taken';
    }
 
    //return true;
    $result = preg_match("/^[A-Za-z0-9_-]+$/", $username); //only A-Z, a-z and 0-9 are allowed (and _ and - )
    //$result = preg_match("/^[A-Za-z]+([A-Za-z0-9]*[_|-]?)*[A-Za-z0-9]+$/", $nickname); //only A-Z, a-z and 0-9 are allowed (and _ and - )
    if ($result) {
      return 'good'; // ok no invalid chars
    } 
    else {
      return 'characters'; //invalid chars found
    }

    
    return false;
 
}

function username_exists($username) {
  $q = sprintf("SELECT user_id FROM user WHERE nickname = '%s' LIMIT 1",
        mysql_real_escape_string($username));
 
    $result = mysql_query($q) or die();
 
    if (mysql_num_rows($result) > 0) {
        return true;
    } 
    else {
        return false;
    }
 
    return false;
}

function valid_pass($pass, $minlength = 6, $maxlength = 15)
{
    $pass = trim($pass);
 
    if (empty($pass))
    {
        return 'empty';
    }
 
    if (strlen($pass) < $minlength)
    {
        return 'short';
    }
 
    if (strlen($pass) > $maxlength)
    {
        return 'long';
    }
 
    $result = preg_match("/^[A-Za-z0-9_\-@!]+$/", $pass);
 
    if ($result)
    {
        return 'good';
    } else
    {
        return 'characters';
    }
 
    return false;
 
}


function valid_nickname($nickname, $minlength = 3, $maxlength = 30)
{
    return valid_username($nickname);
    /*
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
    if (contains_illegal_words($nickname)) {
      return false;
    }
 
    //return true;
    $result = preg_match("/^[A-Za-z0-9_-]+$/", $nickname); //only A-Z, a-z and 0-9 are allowed (and _ and - )
    //$result = preg_match("/^[A-Za-z]+([A-Za-z0-9]*[_|-]?)*[A-Za-z0-9]+$/", $nickname); //only A-Z, a-z and 0-9 are allowed (and _ and - )
    if ($result)
    {
        return true; // ok no invalid chars
    } else
    {
        return false; //invalid chars found
    }

    
    return false;
   */
 
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
 
    $result = preg_match("%^[A-Za-z0-9_\-@!]+$%", $pass);
 
    if ($result)
    {
        return true;
    } else
    {
        return false;
    }
 
    return false;
 
}

function is_pass_there () {
  if (isLoggedIn()) {
    $q = 'SELECT password from user where user_id = ' . $_SESSION['user_id'];
    $row = mysql_query($q);
    $result = mysql_fetch_array($row);
    if ($result['password'] == '') {
      return false;
    }
    else {
      return true;
    }
  } 
  else {
    return false;
  }
}


function permissions_check ($req) {
  if (isLoggedIn() and isset($_SESSION["permissions_id"])) {
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

function can_view_section ($chart_id) {
      $can_view = true;
      $msg = '';
      $user_id = get_user_id_from_chart_id($chart_id);
      if (!is_freebie_chart($chart_id) && !isCeleb($user_id) && !($user_id == get_my_user_id())) {
        $pref = get_preferences($user_id, 'chart_private', 0);
        $my_pref = get_my_preferences('chart_private', 0);
        $username = get_nickname($user_id);
        if ($pref == 1) {
          $can_view = false;
          $msg = '<div class="later_on" style="font-size:1.4em; text-align:center; margin-bottom:260px; padding: 0 35px;">' . $username . ' has chosen to keep this section private.</div>';
        }
        if ($my_pref == 1) {
          $can_view = false;
          $msg = '<div class="later_on" style="font-size:1.4em; text-align:center; margin-bottom:260px; padding: 0 35px;">You cannot view this section of another person\'s profile while your chart info is set as private.  <a class="later_on" style="text-decoration:underline;" href="/main.php?the_page=ssel&the_left=nav1&the_tier=1">View My Privacy Settings</a></div>';
        }
      }
      return array($can_view,$msg); 
}
 
?>