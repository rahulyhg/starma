<?php
 
##### User Functions #####
function max_msgs() {
  return 30;
}

function max_descriptors() {
  return 3;
}

function max_photos() {
  return 6;
}

function isCeleb($user_id) {
  $info = profile_info($user_id);
  return $info["permissions_id"] == PERMISSIONS_CELEB();
}

function update_my_last_action_made ($datetime) {
  if (isLoggedIn()) {
    $q = "UPDATE user set last_action_made = " . $datetime . " where user_id = " . get_my_user_id();
    $result = mysql_query($q) or die(mysql_error());
    return true; 
  }
  else {
    return false;
  }
}

function is_online($user_id) {
  if (isLoggedIn()) {
    $q = "SELECT last_action_made from user where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    if ($row = mysql_fetch_array($result)) { 
      $last_action_made = $row["last_action_made"];
      $threshold = date('YmdHis', mktime(date("H"), date("i")-5, date("s"), date("m"), date("d"), date("Y")));
      //echo $row["last_action_made"] . ' **** ' . $threshold;
      //die();
      return $last_action_made >= $threshold;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function is_away($user_id) {
  if (isLoggedIn()) {
    $q = "SELECT last_action_made from user where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    if ($row = mysql_fetch_array($result)) { 
      $last_action_made = $row["last_action_made"];
      $threshold = date('YmdHis', mktime(date("H")-2, date("i"), date("s"), date("m"), date("d"), date("Y")));
      return $last_action_made >= $threshold;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function is_offline($user_id) {
  return !(is_away($user_id)); //or is_online($user_id)); //MAY NOT NEED THE IS_ONLINE CHECK.  IS_AWAY INCLUDES IT
}

function num_new_msgs_with ($r_id) {
  $r = get_my_new_msgs_with ($r_id);
  return mysql_num_rows($r);
  
}

function num_new_non_chats () {
  $r = get_my_new_non_chats ();
  return mysql_num_rows($r);
  
}

function get_my_new_non_chats() {
  if (isLoggedIn()) {
    $q = "SELECT * from msg_line where receiver_id = " . get_my_user_id() . " and receiver_has_seen = 0 and is_message = 1 ORDER BY date_time, msg_line_id";
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
}

function get_my_chat_status () {
  if (isLoggedIn()) {
    $q = "SELECT chat_status.*, nickname from chat_status inner join user on user.user_id = chat_status.user_id_B where (user_id_A = " . get_my_user_id() . " and chatting <> 0) order by order_by";
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
}

function get_my_new_msgs () {
  if (isLoggedIn()) {
    $q = "SELECT * from msg_line where (sender_id = " . get_my_user_id() . " and sender_has_seen = 0) or (receiver_id = " . get_my_user_id() . " and receiver_has_seen = 0 and is_message = 0) ORDER BY date_time, msg_line_id";
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
  
}

function get_my_new_msg_senders () {
  if (isLoggedIn()) {
    $q = "SELECT DISTINCT sender_id, nickname from msg_line inner join user on user.user_id = msg_line.sender_id where receiver_id = " . get_my_user_id() . " and receiver_has_seen = 0 and is_message = 0 ORDER BY date_time, msg_line_id, sender_id";
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
  
}


function get_my_new_msgs_with ($r_id) {
  if (isLoggedIn()) {
    $q = "SELECT * from msg_line where (sender_id = " . get_my_user_id() . " and receiver_id = " . $r_id . " and sender_has_seen = 0) or (sender_id = " . $r_id . " and receiver_id = " . get_my_user_id() . " and receiver_has_seen = 0) ORDER BY date_time, msg_line_id";
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
  
}


function get_my_msgs_with ($r_id) {
  if (isLoggedIn()) {
    $q = "SELECT * from (
             SELECT * from msg_line where (sender_id = " . get_my_user_id() . " and receiver_id = " . $r_id . ") or (sender_id = " . $r_id . " and receiver_id = " . get_my_user_id() . ") ORDER BY date_time DESC, msg_line_id DESC LIMIT " . (int)((int)num_new_msgs_with($r_id) + (int)max_msgs()) .
          ") q1 ORDER BY date_time ASC, msg_line_id ASC";
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
  
}

function get_my_msgs () {
  if (isLoggedIn()) {
    $q = "SELECT * from msg_line where sender_id = " . get_my_user_id() . " or receiver_id = " . get_my_user_id() . " ORDER BY date_time DESC, msg_line_id DESC";
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
  
}


function flag_as_read_my_msg ($msg_line_id, $which_partner) {
  if (isLoggedIn()) {
    if ($which_partner == "receiver") {
      $q = "UPDATE msg_line set " . $which_partner . "_has_seen = 1, is_message = 0 where msg_line_id = " . $msg_line_id;  
    }
    else {
      $q = "UPDATE msg_line set " . $which_partner . "_has_seen = 1 where msg_line_id = " . $msg_line_id;
    }
   
    //echo $q;
    //die();
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
  
}




function my_welcome_flag() {
  return welcome_flag($_SESSION["user_id"]);
}

function my_chart_flag() {
  return chart_flag($_SESSION["user_id"]);
}

function welcome_flag ($user_id) {
  if (isLoggedIn()) {
    $q = "SELECT welcome_flag from user where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($result);
    return $row["welcome_flag"];
     
  }
  else {
    return false;
  }
}

function chart_flag ($user_id) {
  if (isLoggedIn()) {
    $q = "SELECT chart_flag from user where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($result);
    return $row["chart_flag"];
     
  }
  else {
    return false;
  }
}

function set_my_welcome_flag ($flag=1) {
  set_welcome_flag($flag,$_SESSION["user_id"]);
}

function set_my_chart_flag ($flag=1) {
  set_chart_flag($flag,$_SESSION["user_id"]);
}

function set_welcome_flag ($flag=1, $user_id) {
  if (isLoggedIn()) {
    $q = "UPDATE user set welcome_flag = " . $flag . " where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    return true; 
  }
  else {
    return false;
  }
}

function set_chart_flag ($flag=1, $user_id) {
  if (isLoggedIn()) {
    $q = "UPDATE user set chart_flag = " . $flag . " where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    return true; 
  }
  else {
    return false;
  }
}

/*
function is_online($user_id) {
  if (isLoggedIn()) {
    $q = "SELECT online from user  where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    if ($row = mysql_fetch_array($result)) { 
      return $row["online"] == 1;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}
*/

function set_my_online_status ($online=1) {
  if (isLoggedIn()) {
    $q = "UPDATE user set online = " . $online . " where user_id = " . get_my_user_id();
    $result = mysql_query($q) or die(mysql_error());
    return true; 
  }
  else {
    return false;
  }
}

function set_online_status ($user_id, $online=1) {
  if (isLoggedIn()) {
    $q = "UPDATE user set online = " . $online . " where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    return true; 
  }
  else {
    return false;
  }
}

function is_freebie_chart($chart_id) {
  if (isLoggedIn()) {
    $q = "SELECT * from chart where chart_id = " . $chart_id;
    $result = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($result);
    return $row["nickname"] == 'Freebie1' or $row["nickname"] == "Alternate_Freebie1";
     
  }
  else {
    return false;
  }
}

function is_preference_there ($pref_name, $user_id) {
  
  if (isLoggedIn()) {
    $q = "SELECT * from user_preferences where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    if ($row = mysql_fetch_array($result)) {
      return $row[$pref_name];
    }
    else {
      return false;
    }
     
  }
  else {
    return false;
  }
}

function set_my_preference ($pref_name, $value) {
  
  if (isLoggedIn()) {
    $user_id = get_my_user_id();
    if (is_preference_there ($pref_name, $user_id)) {
      $q = "UPDATE user_preferences set " . $pref_name . " = " . $value . " where user_id = " . $user_id;
      $result = mysql_query($q) or die(mysql_error());
    }
    else {
      $q = "INSERT INTO user_preferences (" . $pref_name . ", user_id) VALUES (" . $value . ", " . $user_id . ")";
      $result = mysql_query($q) or die(mysql_error());
    }
    
    return $result;
     
  }
  else {
    return false;
  }
}

function get_my_preferences ($pref_name, $default) {
  
  if (isLoggedIn()) {
    $q = "SELECT * from user_preferences where user_id = " . $_SESSION["user_id"];
    $result = mysql_query($q) or die(mysql_error());
    if ($row = mysql_fetch_array($result)) {
      return $row[$pref_name];
    }
    else {
      return $default;
    }
     
  }
  else {
    return false;
  }
}

function get_my_gender () {
  return get_gender(get_my_user_id());  
}

function get_gender($user_id) {
   if ($info = profile_info($user_id)) {
     $g = strtoupper ($info["gender"]);
     if ($g == 'M' or $g == 'MALE') {
       return "M";
     }
     elseif ($g == 'F' or $g == 'FEMALE') {
       return "F";
     }
     else { 
       return "U";
     }
   }
   else {
     return "U";
   }
}

function is_male($user_id) {
   if ($info = profile_info($user_id)) {
     $g = get_gender($user_id);
     if ($g == 'M' or $g == 'MALE') {
       return true;
     }
     else { 
       return false;
     }
   }
   else {
     return;
   }
}

function is_female($user_id) {
   if ($info = profile_info($user_id)) {
     $g = get_gender($user_id);
     if ($g == 'F' or $g == 'FEMALE') {
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

function get_my_descriptors () {
  
  if (isLoggedIn()) {
    $q = "SELECT * from user_descriptor where user_id = " . $_SESSION["user_id"];
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
}

function get_descriptors ($user_id) {
  
  if (isLoggedIn()) {
    $q = "SELECT * from user_descriptor where user_id = " . $user_id;
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
}

function update_descriptors ($descriptors) {
  if (isLoggedIn()) {
    $words = get_my_descriptors ();
    $counter = 0;
    while ($word = mysql_fetch_array($words)) {
      $q = sprintf("UPDATE user_descriptor set descriptor = '%s' WHERE user_des_id = %d",
          mysql_real_escape_string($descriptors[$counter]), $word["user_des_id"]);
      $result = mysql_query($q) or die(mysql_error());
      $counter = $counter+1;
    }
    while ($counter < max_descriptors()) {
      $q = sprintf("INSERT into user_descriptor (user_id, descriptor) VALUES (%d,'%s')", 
          get_my_user_id(), mysql_real_escape_string($descriptors[$counter]));
      $result = mysql_query($q) or die(mysql_error());
      $counter = $counter+1; 
    }
    return true;
  }
  else {
    return false;
  }
}

function get_my_main_photo() {
  if (isLoggedIn()) {
    $q = "SELECT picture from user_picture where user_id = " . $_SESSION["user_id"] . " and main = 1 and uncropped = 0";
    $result = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($result);
    return $row["picture"];
     
  }
  else {
    return false;
  }
}

function get_main_photo($user_id) {
  if (isLoggedIn()) {
    $q = "SELECT picture from user_picture where user_id = " . $user_id . " and main = 1 and uncropped = 0";
    $result = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($result);
    return $row["picture"];
     
  }
  else {
    return false;
  }
}

function get_photo ($photo_id, $user_id) {
  if (isLoggedIn()) {
    $q = "SELECT picture from user_picture where user_id = " . $user_id . " and user_pic_id = " . $photo_id . " and uncropped = 0";
    $result = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($result);
    return $row["picture"];
     
  }
  else {
    return false;
  }
}

function delete_photo ($photo_id, $user_id) {
  if (isLoggedIn()) {
    $file_name = get_photo($photo_id, $user_id);
    $q = "Delete from user_picture where user_id = " . $user_id . " and user_pic_id = " . $photo_id;
    if ($result = mysql_query($q) or die(mysql_error())) {
      unlink('img/user/' . $file_name);
      unlink('img/user/thumbnail/thumb_' . $file_name);
      unlink('img/user/compare/compare_' . $file_name);
      unlink('img/user/original/original_' . $file_name);
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

function change_my_profile_pic ($photo_id) {
  change_profile_pic ($photo_id, get_my_user_id());
}

function change_profile_pic ($photo_id, $user_id) {
  if (isLoggedIn()) {
    $q = sprintf("update user_picture set main = 0 where user_id = %d and user_pic_id <> %d",
        $user_id, $photo_id);
    
    $result = mysql_query($q) or die(mysql_error());
    $q = sprintf("update user_picture set main = 1 where user_id = %d and user_pic_id = %d and uncropped = 0",
        $user_id, $photo_id);
    
    $result = mysql_query($q) or die(mysql_error());
    return true;
     
  }
  else {
    return false;
  }
}

function get_my_photos() {
  return get_photos($_SESSION["user_id"]);
  /*if (isLoggedIn()) {
    $q = "SELECT * from user_picture where user_id = " . get_my_user_id() . " and uncropped = 0";
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }*/
}

function get_photos($user_id) {
  if (isLoggedIn()) {
    $q = "SELECT * from user_picture where user_id = " . $user_id . " and uncropped = 0";
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  }
  else {
    return false;
  }
}

function num_my_photos() { 
  return num_photos(get_my_user_id());
}

function num_photos($user_id) { 
  if (isLoggedIn()) {
    $q = "SELECT count(picture) as num_pics from user_picture where user_id = " . $user_id . " and uncropped = 0";
    $result = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($result);
    return $row["num_pics"];
     
  }
  else {
    return false;
  }
}

function associate_photo_with_me($pic_name) {
  return associate_photo_with_user($pic_name, get_my_user_id());
}

function associate_photo_with_user($pic_name, $user_id) {
  if (isLoggedIn()) {
    if (num_photos($user_id) < max_photos()) {
      if ((int)num_photos($user_id) == 0) {
        $main = 1;
      }
      else {
        $main = 0;
      }
      $q = sprintf("INSERT into user_picture (user_id, picture, main, uncropped) VALUES (%d, '%s', %d, 1)", $user_id, mysql_real_escape_string($pic_name), $main);
      $result = mysql_query($q) or die(mysql_error());
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

function uncropped_photos($user_id) {
  if (isLoggedIn()) {
    $q = "SELECT * from user_picture where user_id = " . $user_id . " and uncropped = 1";
    $result = mysql_query($q) or die(mysql_error());
    return $result;    
  }
  else {
    return false;
  }
}

function set_photo_cropped_status($user_pic_id, $user_id, $uncropped) {
  if (isLoggedIn()) {
    $q = "UPDATE user_picture set uncropped = " . $uncropped . " where user_id = " . $user_id . " and user_pic_id = " . $user_pic_id;
    $result = mysql_query($q) or die(mysql_error());
    return $result;    
  }
  else {
    return false;
  }
}

function update_my_profile_step ($step) { 
  if (isLoggedIn()) {
    $q = sprintf("update user set profile_step = '%s' where user_id = %d",
        mysql_real_escape_string($step),$_SESSION["user_id"]);
    $result = mysql_query($q) or die(mysql_error());
    return true;
     
  }
  else {
    return false;
  }
}

function update_my_profile_info($first_name, $last_name, $gender, $location) {
  if (isLoggedIn()) {
    
    $q = sprintf("update user set first_name = '%s', last_name = '%s', gender = '%s', location = '%s' where user_id = %d",
        mysql_real_escape_string($first_name), mysql_real_escape_string($last_name), mysql_real_escape_string($gender), mysql_real_escape_string($location), $_SESSION["user_id"]);
    $result = mysql_query($q) or die(mysql_error());
    return true;
     
  }
  else {
    return false;
  }
}

function update_my_interests($activities, $music, $books, $FandT, $RandS, $political, $figures) {
  if (isLoggedIn()) {
    
    $q = sprintf("update user set activities = '%s', music = '%s', books = '%s', film_television = '%s', spiritual = '%s', political = '%s', inspirational_figures = '%s' where user_id = %d",
        mysql_real_escape_string($activities), mysql_real_escape_string($music), mysql_real_escape_string($books), mysql_real_escape_string($FandT), 
        mysql_real_escape_string($RandS), mysql_real_escape_string($political), mysql_real_escape_string($figures), $_SESSION["user_id"]);
    $result = mysql_query($q) or die(mysql_error());
    return true;
     
  }
  else {
    return false;
  }
}

function update_my_biography($about_me) {
  if (isLoggedIn()) {
    
    $q = sprintf("update user set about_me = '%s'where user_id = %d",
        mysql_real_escape_string($about_me), $_SESSION["user_id"]);
    $result = mysql_query($q) or die(mysql_error());
    return true;
     
  }
  else {
    return false;
  }
}

function my_profile_info() {
  if (isLoggedIn()) {
    $q = 'SELECT * from user where user_id = ' . $_SESSION["user_id"];
    $result = mysql_query($q) or die(mysql_error());
    $user = mysql_fetch_array($result);
    return $user; 
  }
  else {
    return false;
  }
}

function profile_info($user_id) {
  if (isLoggedIn()) {
    $q = 'SELECT * from user where user_id = ' . $user_id;
    //echo $q . '<br>';
    if ($result = mysql_query($q)) {
      $user = mysql_fetch_array($result);
      return $user; 
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function is_my_profile_done() {
  if (isLoggedIn()) {
    $q = 'SELECT * from user where user_id = ' . $_SESSION["user_id"];
    $result = mysql_query($q) or die(mysql_error());
    $user = mysql_fetch_array($result);
    if ($user["profile_done"] == 1)
      return true;
    else
      return false; 
  }
  else {
    return false;
  }
}

function get_my_profile_step() {
  if (isLoggedIn()) {
    $q = 'SELECT * from user where user_id = ' . $_SESSION["user_id"];
    $result = mysql_query($q) or die(mysql_error());
    $user = mysql_fetch_array($result);
    return $user["profile_step"]; 
  }
  else {
    return false;
  }
}

function get_my_picture() {
  
  if (isLoggedIn()) {
    $q = 'SELECT picture from user where user_id = ' . $_SESSION["user_id"];
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row["picture"];
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }

}

function get_sign_from_poi ($chart_id, $poi_id) {
  
  $q = 'SELECT * from chart inner join chart_x_house on chart.chart_id = chart_x_house.chart_id inner join chart_x_house_x_poi on chart_x_house_x_poi.chart_x_house_id = chart_x_house.chart_x_house_id
        WHERE chart.chart_id = ' . $chart_id . /*' and user_id = ' . $_SESSION['user_id'] . */' and poi_id = ' . $poi_id;
  //echo $q;
  $result = mysql_query($q) or die(mysql_error());
  if ($info = mysql_fetch_array($result)) {
    return $info["sign_id"];
  }
  else {
    return -1;
  }
}

function get_house_from_poi ($chart_id, $poi_id) {
  
  $q = 'SELECT * from chart inner join chart_x_house on chart.chart_id = chart_x_house.chart_id inner join chart_x_house_x_poi on chart_x_house_x_poi.chart_x_house_id = chart_x_house.chart_x_house_id inner join house on house.house_id = chart_x_house.house_id
        WHERE chart.chart_id = ' . $chart_id . /*' and user_id = ' . $_SESSION['user_id'] . */' and poi_id = ' . $poi_id;
  //echo $q;
  $result = mysql_query($q) or die(mysql_error());
  if ($info = mysql_fetch_array($result)) {
    return $info["house_id"];
  }
  else {
    return -1;
  }
}

function get_ruling_planet($chart_id) {
  $rising_sign_id = get_sign_from_poi ($chart_id = $chart_id, $poi_id = 1);
  if ($rising_sign_id == -1) {
    return -1;
  }
  else {
    $q = 'SELECT * from sign where sign_id = ' . $rising_sign_id;
    $result = mysql_query($q) or die(mysql_error());
    $info = mysql_fetch_array($result);
    return $info["ruling_poi_id"];
  }
}

function get_user_list () {
  
  if (isLoggedIn()) {
    $q = 'SELECT user.*, chart.chart_id from user inner join chart on user.user_id = chart.user_id where chart.nickname="main" and permissions_id <> -1 ORDER BY user_id desc'; // where user_id = ' . $_SESSION["user_id"];
    
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_favorties_user_list () {
  if (isLoggedIn()) {
    $q = 'SELECT user.*, chart.chart_id from user inner join chart on user.user_id = chart.user_id inner join favorite on favorite.favorite_user_id = user.user_id where chart.nickname="main" AND favorite.user_id = ' . get_my_user_id() . ' ORDER BY nickname'; // where user_id = ' . $_SESSION["user_id"];
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}


function get_filtered_user_list ($filter, $type="include") { //FOR FAVORITES ONLY
  if (isLoggedIn()) {
    $q = 'SELECT user.*, chart.chart_id from user inner join chart on user.user_id = chart.user_id inner join favorite on favorite.favorite_user_id = user.user_id where chart.nickname="main" AND favorite.user_id = ' . get_my_user_id() . ' AND ';
    if ($type=="exclude") {
      $q = $q . 'NOT '; 
    }
    $q = $q . sprintf('user.nickname like "%%%s%%" ORDER BY nickname', mysql_real_escape_string($filter));
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_filtered_user_list_no_celeb ($filter, $type, $limit) {
  if (isLoggedIn()) {
    $q = 'SELECT user.*, chart.chart_id from user inner join chart on user.user_id = chart.user_id where permissions_id != ' . PERMISSIONS_CELEB() . ' AND chart.nickname="main" AND ';
    if ($type=="exclude") {
      $q = $q . 'NOT '; 
    }
    $q = $q . sprintf('user.nickname like "%%%s%%" ORDER BY user_id desc LIMIT %s', mysql_real_escape_string($filter), $limit);
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_celebrity_user_list () {
  if (isLoggedIn()) {
    $q = 'SELECT user.*, chart.chart_id from user inner join chart on user.user_id = chart.user_id where chart.nickname="main" AND permissions_id = ' . PERMISSIONS_CELEB() . ' AND NOT user.nickname like "testceleb%" ORDER BY nickname'; 
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_filtered_celebrity_user_list ($filter, $type="include") {
  if (isLoggedIn()) {
    $q = 'SELECT user.*, chart.chart_id from user inner join chart on user.user_id = chart.user_id where chart.nickname="main" AND permissions_id = ' . PERMISSIONS_CELEB() . ' AND NOT user.nickname like "testceleb%" AND ';
    if ($type=="exclude") {
      $q = $q . 'NOT '; 
    }
    $q = $q . sprintf('user.nickname like "%%%s%%" ORDER BY nickname', mysql_real_escape_string($filter));
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}


function get_celeb_list() {  // THIS FUNCTION FOR ADMINS ONLY, TO MANAGE CELEBRITIES
  if (isLoggedIn()) {
    $q = 'SELECT user.* from user WHERE permissions_id = -1 ORDER BY nickname';
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function is_my_favorite ($favorite_user_id) {
  if (isLoggedIn()) {
    $q = 'SELECT * from favorite where user_id = ' . get_my_user_id() . ' AND favorite_user_id = ' . $favorite_user_id;
    $result = mysql_query($q);
    return mysql_num_rows($result) > 0;
  }
  else {
    return false;
  }
}

function toggle_my_favorite ($favorite_user_id, $favorite) { 
  if ((string) $favorite == '0') {
    $q = 'DELETE from favorite where user_id = ' . get_my_user_id() . ' AND favorite_user_id = ' . $favorite_user_id;
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    if (!is_my_favorite ($favorite_user_id)) {
      $q = 'INSERT INTO favorite (user_id, favorite_user_id) VALUES (' . get_my_user_id() . ',' . $favorite_user_id . ')';
    }
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  
}


function get_chart_list () {
  if (isLoggedIn()) {
    $q = 'SELECT * from chart'; // where user_id = ' . $_SESSION["user_id"];
    if ($result = mysql_query($q)) {
      return $result;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_chart ($chart_id) {
  if (isLoggedIn()) {
    $q = 'SELECT * from chart where chart_id = ' . (int) $chart_id; // . ' and user_id = ' . $_SESSION["user_id"];
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_my_chart_id () {
  if (isLoggedIn()) {
    if ($chart = get_my_chart()) {
      return $chart["chart_id"];
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_my_user_id() {
  if (isLoggedIn()) {
    return $_SESSION["user_id"];
  }
  else {
    return false;
  }
}

function get_my_chart () {
  if (isLoggedIn()) {
    $q = 'SELECT * from chart where user_id = ' . $_SESSION["user_id"] . ' and personal = 1';
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}


function get_my_birthday () {
  if (isLoggedIn()) {
    $q = 'SELECT birthday from user where user_id = ' . $_SESSION["user_id"];
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row["birthday"];
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}


function get_my_nickname () {
  if (isLoggedIn()) {
    $q = 'SELECT nickname from user where user_id = ' . $_SESSION["user_id"];
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row["nickname"];
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}


function get_my_email () {
  if (isLoggedIn()) {
    $q = 'SELECT email from user where user_id = ' . $_SESSION["user_id"];
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row["email"];
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_nickname ($user_id) {
  if (isLoggedIn()) {
    $q = 'SELECT nickname from user where user_id = ' . $user_id;
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row["nickname"];
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function delete_my_chart_by_name ($chart_name) {
  if ($chart = get_chart_by_name($chart_name)) {
    $chart_id = $chart["chart_id"];
    $q = 'SELECT * from chart_x_house where chart_id = ' . $chart_id;
    //echo $q;
    $result = mysql_query($q) or die(mysql_error());
    //$chart_x_house_array = array();
    while ($row = mysql_fetch_array($result)) {
      $chart_x_house_array[] = $row['chart_x_house_id'];
    }
    // nuke the chart_x_house_x_poi rows
    print_r ($chart_x_house_array);
    //echo '<br>';
    for ($x=0;$x<sizeof($chart_x_house_array);$x++) {
      $d = 'DELETE from chart_x_house_x_poi where chart_x_house_id = ' . $chart_x_house_array[$x];
      //echo $d . '<Br>';
      $result = mysql_query($d) or die(mysql_error());
    }
    // nuke the chart_x_house rows
    //echo 'chart_id marked for deletion: ' . $chart_id . '<br>';
    $d = 'DELETE from chart_x_house where chart_id = ' . $chart_id;
    $result = mysql_query($d) or die(mysql_error());
    // nuke the chart
    $d = 'DELETE from chart where chart_id = ' . $chart_id;
    $result = mysql_query($d) or die(mysql_error());
  }
  else {
    return false;
  }

}


function alter_poi_sign ($chart_id, $poi_id, $sign_id) {

  $chart_x_house_id = get_chart_x_house_id_from_sign_id ($chart_id, $sign_id);
  if ($chart_x_house_x_poi_id = get_chart_x_house_x_poi_id ($chart_id, $poi_id)) {
    if ((string)$sign_id == '-1') {
      //delete
      //echo 'delete' . '<br>';
      $q = 'DELETE FROM chart_x_house_x_poi WHERE chart_x_house_x_poi_id = ' . $chart_x_house_x_poi_id;
    }
    else {
      //update
      //echo 'update' . '<br>';
      $q = 'UPDATE chart_x_house_x_poi set coordinates="' . get_poi_coordinates($chart_id_low, $poi_id) . '", chart_x_house_id = ' . $chart_x_house_id . ' WHERE chart_x_house_x_poi_id = ' . $chart_x_house_x_poi_id;
    }
    mysql_query ($q) or die(mysql_error());
  }
  else if ((string)$sign_id != '-1') {
    //insert 
    //echo 'insert' . '<br>';
    $q = 'INSERT INTO chart_x_house_x_poi (chart_x_house_id, poi_id, coordinates) VALUES (' . $chart_x_house_id . ',' . $poi_id . ',"' . get_poi_coordinates($chart_id_low, $poi_id) . '")';
    mysql_query ($q) or die(mysql_error()); 
  }
  //echo 'not any of those' . '<br>';
  
}

function consolidateCharts ($chart_name_low,$chart_name_high,$user_id,$chart_name_to_replace,$interval) {
  if (($chart_id_low = chart_already_there($chart_name_low, $user_id)) && ($chart_id_high = chart_already_there($chart_name_high, $user_id))) {
    //compare the 2 charts
    //echo 'chart_id_low: ' . $chart_id_low . ', chart_id_high: ' . $chart_id_high . '<br>';
    $poi_list = get_poi_list();
    while ($poi = mysql_fetch_array($poi_list)) {
      
      $sign_id_low = get_sign_from_poi($chart_id_low, $poi["poi_id"]);
      $sign_id_high = get_sign_from_poi($chart_id_high, $poi["poi_id"]);
      if ($sign_id_low != $sign_id_high || ($poi["poi_id"] == 1 && (string)$interval == '-1')) {
        alter_poi_sign ($chart_id_low, $poi["poi_id"], -1); 
        if ((string)$poi["poi_id"] == '1') { // if we're nuking the rising sign 
           //nuke house ids
            
           $q = 'UPDATE chart_x_house set house_id=-1 WHERE chart_id = ' . $chart_id_low;
           mysql_query ($q) or die(mysql_error());
            
        }
      }
      
    }

    
    if ($chart_name_to_replace == "Main") {
      $personal = 1;
    }
    else {
      $personal = 0;
    }

    //echo "Done consolidating, ready to change names..."; 

    if ($old_chart_id = chart_already_there($chart_name_to_replace, $user_id)) {
      $q = 'UPDATE chart set nickname="' . $chart_name_low . '", personal=0 WHERE chart_id = ' . $old_chart_id;
      mysql_query ($q) or die(mysql_error());     
      

    }

    $q = 'UPDATE chart set nickname="' . $chart_name_to_replace . '", personal=' . $personal . ' WHERE chart_id = ' . $chart_id_low;
    mysql_query ($q) or die(mysql_error());
    
    
    
    
    return true;
  }
  else {
    return false;
  }
}

function chart_already_there($nickname, $user_id) {
  if (isLoggedIn()) {
    $q = 'SELECT * from chart where user_id = ' . $user_id . ' and nickname = "' . $nickname . '"';
    $result = mysql_query($q) or die(mysql_error());
    if ($row = mysql_fetch_array($result)) {
      
      return $row["chart_id"];
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}


function store_chart_by_sign ($nickname, $birthdatetime, $longitude, $latitude, $DST, $timezone, $asc_coord, $asc_sign_id, $location, $poi_array, $personal, $interval, $time_unknown, $method) {
  
  if (isLoggedIn()) {
    if (isset($_SESSION["proxy_user_id"]) and isAdmin()) { // IF YOURE AN ADMIN CASTING ANOTHER USER'S CHART
      $user_id = $_SESSION["proxy_user_id"];
    }
    else {
      $user_id = $_SESSION["user_id"];
    }
    if (!$existing_chart_id = chart_already_there($nickname, $user_id)) {
      $q = 'INSERT INTO chart (nickname, user_id, latitude, longitude, birthday, DST, timezone, location, personal, interval_time, time_unknown, method) VALUES ("' . $nickname . '",' . $user_id . ',"' . $latitude . '","' . $longitude . '","' . $birthdatetime . '",' . $DST . ',' . $timezone . ',"' . $location . '",' . $personal . ',' . $interval . ',' . $time_unknown . ',"' . $method . '")';
    
      //echo $q;
      mysql_query ($q) or die(mysql_error());
      if (!$chart = get_chart_by_name($nickname, $user_id)) {
        return false;
      }
    
      for ($sign_id = 1; $sign_id <= 12; $sign_id++) {
          if ((string)$asc_sign_id == -1) {
            $house_id = -1;
          }
          else {
            $house_id = house_arithmetic ($sign_id - $asc_sign_id, 1);
          }
          $q = 'INSERT INTO chart_x_house (chart_id, house_id, sign_id) VALUES (' . $chart["chart_id"] . ',' . $house_id . ',' . $sign_id . ')';
          mysql_query ($q) or die(mysql_error());  
          $chart_x_house_id = get_chart_x_house_id_from_sign_id ($chart["chart_id"], $sign_id);

          if ($house_id == 1 && (string)asc_sign_id != '-1') {   //if we're on the first sign, insert the values for the Ascendant
            $q = 'INSERT INTO chart_x_house_x_poi (chart_x_house_id, poi_id, coordinates) VALUES (' . $chart_x_house_id . ', 1, "' . $asc_coord . '")';
            mysql_query ($q) or die(mysql_error());
          }
  
          for ($poi_id = 2; $poi_id <= 10; $poi_id++) {  //the rest of the Grahas
            if ($poi_array[$poi_id][1] == $sign_id) {
              $q = 'INSERT INTO chart_x_house_x_poi (chart_x_house_id, poi_id, coordinates) VALUES (' . $chart_x_house_id . ',' . $poi_id . ',"' . $poi_array[$poi_id][0] . '")';
              mysql_query ($q) or die(mysql_error());
            }
          }
      } 
    }
    else {
      
      $q = 'UPDATE chart set nickname="' . $nickname . '", latitude="' . $latitude . '", longitude="' . $longitude . '", birthday="' . $birthdatetime . '", DST=' . $DST . ', timezone=' . $timezone . ', location="' . $location . '", personal=' . $personal . ', interval_time=' . $interval .', time_unknown=' . $time_unknown .', method="' . $method . '" WHERE chart_id = ' . $existing_chart_id;
      
      //echo $q;
      //echo $q;
      //die();
      mysql_query ($q) or die(mysql_error());
      
    
      for ($sign_id = 1; $sign_id <= 12; $sign_id++) {
          if ((string)$asc_sign_id == -1) {
            $house_id = -1;
          }
          else {
            $house_id = house_arithmetic ($sign_id - $asc_sign_id, 1);
          }
           

          $q = 'UPDATE chart_x_house set house_id=' . $house_id . ' WHERE chart_id = ' . $existing_chart_id . ' and sign_id= ' . $sign_id;
          mysql_query ($q) or die(mysql_error());  
 

          $chart_x_house_id = get_chart_x_house_id_from_sign_id ($existing_chart_id, $sign_id);

          if ($house_id == 1 && (string)$asc_sign_id != '-1') {   //if we're on the first sign, update the values for the Ascendant
            
            if ($chart_x_house_x_poi_id = get_chart_x_house_x_poi_id ($existing_chart_id, 1)) {
              $q = 'UPDATE chart_x_house_x_poi set coordinates="' . $asc_coord . '", chart_x_house_id = ' . $chart_x_house_id . ' WHERE chart_x_house_x_poi_id = ' . $chart_x_house_x_poi_id;
            }
            else {
              $q = 'INSERT INTO chart_x_house_x_poi (chart_x_house_id, poi_id, coordinates) VALUES (' . $chart_x_house_id . ', 1 ,"' . $asc_coord . '")';
            }
   
            
            mysql_query ($q) or die(mysql_error());
            
          }
  
          for ($poi_id = 2; $poi_id <= 10; $poi_id++) {  //the rest of the Grahas
            $chart_x_house_x_poi_id = get_chart_x_house_x_poi_id ($existing_chart_id, $poi_id);
            //echo $chart_x_house_x_poi_id . '<br>';
            if ($poi_array[$poi_id][1] == $sign_id) {
              if ($chart_x_house_x_poi_id) {
                $q = 'UPDATE chart_x_house_x_poi set coordinates="' . $poi_array[$poi_id][0] . '", chart_x_house_id = ' . $chart_x_house_id . ' WHERE chart_x_house_x_poi_id = ' . $chart_x_house_x_poi_id;
              }
              else {
                $q = 'INSERT INTO chart_x_house_x_poi (chart_x_house_id, poi_id, coordinates) VALUES (' . $chart_x_house_id . ',' . $poi_id . ',"' . $poi_array[$poi_id][0] . '")';
              }
              mysql_query ($q) or die(mysql_error());
            }
          }

          //update birthday if changing my own info
          
          if (isset($_SESSION["change_info"])) {
            $birthday = date("Y-m-d",strtotime($birthdatetime));
            update_my_birthday($birthday);
             
          }
          
      }
      //check for new uncertainties and delete them from the chart_x_house_x_poi table
      for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
         //echo $chart_x_house_x_poi_id . '<br>';
         if ((string)$poi_array[$poi_id][1] == '-1') {
           if ($chart_x_house_x_poi_id = get_chart_x_house_x_poi_id ($existing_chart_id, $poi_id)) {
             $q = 'DELETE FROM chart_x_house_x_poi WHERE chart_x_house_x_poi_id = ' . $chart_x_house_x_poi_id;
             mysql_query ($q) or die(mysql_error());
           }
           
           
         }
      }
      
      
    }
    return true;
    
  }
  else {
    return false;
  }
}

function update_my_birthday($birthday) {
  if (isLoggedIn()) {
    $q = 'UPDATE user set birthday = "' . $birthday . '" WHERE user_id = ' . $_SESSION["user_id"];
    $r = mysql_query ($q) or die (mysql_error());
    return true;
  }
  else {
    return false;
  }
}

function get_newest_chart() {
  if (isLoggedIn()) {
    $q = 'SELECT * from chart WHERE user_id = ' . $_SESSION["user_id"] . ' ORDER BY chart_id desc';
    $r = mysql_query ($q) or die (mysql_error());
    $chart = mysql_fetch_array($r);
    return $chart;
  }
  else {
    return false;
  }
}

function get_chart_by_name ($nickname="Main", $user_id=-1) {
  if (isLoggedIn()) {
    if ((string)$user_id == '-1') {
      $user_id = $_SESSION["user_id"];
    }
    $q = 'SELECT * from chart WHERE user_id = ' . $user_id . ' and nickname = "' . $nickname . '" ORDER BY chart_id desc';
    $r = mysql_query ($q) or die (mysql_error());
    $chart = mysql_fetch_array($r);
    return $chart;
  }
  else {
    return false;
  }
}


function get_user_id_from_email ($email) {
  $user_q = 'SELECT * from user where email = ' . $email;
  
  if ($do_q = mysql_query (user_q)) {
    if ($user = mysql_fetch_array ($do_q)) {
      return $user["user_id"];
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_user_id_from_chart_id ($chart_id) {
  if (isLoggedIn()) {
    $q = 'SELECT user.user_id from user inner join chart on user.user_id = chart.user_id where chart.nickname = "main" and chart.chart_id = ' . $chart_id;
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row["user_id"];
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_any_user_id_from_chart_id ($chart_id) {
  if (isLoggedIn()) {
    $q = 'SELECT user.user_id from user inner join chart on user.user_id = chart.user_id where chart.chart_id = ' . $chart_id;
    //echo $q . '<br>';
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row["user_id"];
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_user_email_from_nickname ($nickname) {
  $user_q = sprintf("SELECT * FROM user WHERE nickname = '%s' LIMIT 1", mysql_real_escape_string($nickname));
  if ($do_q = mysql_query ($user_q)) {
    if ($user = mysql_fetch_array ($do_q)) {
      return $user["email"];
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function get_user_nickname_from_email ($email) {
  $user_q = sprintf("SELECT * FROM user WHERE email = '%s' LIMIT 1", mysql_real_escape_string($email));
  if ($do_q = mysql_query ($user_q)) {
    if ($user = mysql_fetch_array ($do_q)) {
      return $user["nickname"];
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function changePassword($email,$currentpassword,$newpassword,$newpassword2){
global $seed;	
	if (!valid_email($email) || !user_exists($email,get_user_nickname_from_email ($email)))
    {
        //echo "invalid email or user doesnt exist: *" . get_user_nickname_from_email ($email) . "*";
        //die();
        return false;
    }
    if (! valid_password($newpassword) || ($newpassword != $newpassword2)){
                //echo "invaid password or passwords dont match";
                //die();
 
		return false;
	}
 
	// we get the current password from the database
    $query = sprintf("SELECT password FROM user WHERE email = '%s' LIMIT 1",
        mysql_real_escape_string($email));
 
    $result = mysql_query($query);
	$row= mysql_fetch_row($result);
 
	// compare it with the password the user entered, if they don't match, we return false, he needs to enter the correct password.
	if ($row[0] != sha1($currentpassword.$seed)){
 
		return false;	
	}
 
	// now we update the password in the database
    $query = sprintf("update user set password = '%s' where email = '%s'",
        mysql_real_escape_string(sha1($newpassword.$seed)), mysql_real_escape_string($email));
 
    if (mysql_query($query))
    {
		return true;
	}else {return false;}
	return false;
}
 
 
function user_exists($email,$nickname)
{
    if (!valid_nickname($nickname))
    {
        return false;
    }
 
    $query = sprintf("SELECT user_id FROM user WHERE nickname = '%s' or email = '%s' LIMIT 1",
        mysql_real_escape_string($nickname),mysql_real_escape_string($email));
 
    $result = mysql_query($query) or die();
 
    if (mysql_num_rows($result) > 0)
    {
        return true;
    } else
    {
        return false;
    }
 
    return false;
 
}
 
function email_there($email)
{
    if (!valid_email($email))
    {
        return false;
    }
 
    $query = sprintf("SELECT user_id FROM user WHERE email = '%s' LIMIT 1",
        mysql_real_escape_string($email));
 
    $result = mysql_query($query);
 
    if (mysql_num_rows($result) > 0)
    {
        return true;
    } else
    {
        return false;
    }
 
    return false;
 
}

function nickname_there($nickname)
{
    if (!valid_nickname($nickname))
    {
        return false;
    }
 
    $query = sprintf("SELECT user_id FROM user WHERE nickname = '%s' LIMIT 1",
        mysql_real_escape_string($nickname));
 
    $result = mysql_query($query);
 
    if (mysql_num_rows($result) > 0)
    {
        return true;
    } else
    {
        return false;
    }
 
    return false;
 
}

function activateUser($uid, $actcode)
{
 
    $query = sprintf("select activated from user where user_id = '%s' and actcode = '%s' and activated = 0 limit 1",
        mysql_real_escape_string($uid), mysql_real_escape_string($actcode));
 
    $result = mysql_query($query);
 
    if (mysql_num_rows($result) == 1)
    {
 
        $sql = sprintf("update user set activated = '1' where user_id = '%s' and actcode = '%s'",
            mysql_real_escape_string($uid), mysql_real_escape_string($actcode));
 
        if (mysql_query($sql))
        {
            return true;
        } else
        {
            return false;
        }
 
    } else
    {
 
        return false;
 
    }
 
}
 

function registerNewUser($nickname, $password, $password2, $email, $email2, $year, $month, $day, $agreement)
{
 
    global $seed;
        
    
    $errors = validate_registration($nickname, $password, $password2, $email, $email2, $year, $month, $day, $agreement);

    if (sizeof($errors) > 1)
    {
        //echo 'Invalid';
        //die();
        return $errors;
    }

    $birthday = strtotime($year . "-" . $month . "-" . $day);
    
    //$token_id = token_valid($token);   

    $errors = array(); 
    
    $code = generate_code(20);
    $sql = sprintf("insert into user (nickname,email,password,actcode,birthday) value ('%s','%s','%s','%s','%s')",
        mysql_real_escape_string($nickname), mysql_real_escape_string($email), mysql_real_escape_string(sha1($password . $seed))
		, mysql_real_escape_string($code),date("Y-m-d",$birthday));
 
 
    if (mysql_query($sql))
    {
        $id = mysql_insert_id();
        //use_token ($token_id, $id); 

        $errors[] = $id;
        if (sendActivationEmail($email, $nickname, $password, $id, $code))
        {
 
            return $errors;
        } else
        {
            $errors[] = "User Inserted, but Email Failed";
        }
 
    } else
    {
        $errors[] = -1;
        $errors[] = "User Inserted Query Failed";
    }
    return $errors;
 
}

function modifyUser_no_register($nickname, $first_name, $last_name, $gender, $about_me, $permissions_id, $user_id=-1, $year="1980", $month="01", $day="01") {
    global $seed;
        
    $errors[] = -1;
    //echo $user_id;
    if ($user_id == '-1' AND !valid_nickname($nickname)) { 
      
      $errors[] = USERNAME_ERROR();
    }

    if ($user_id == '-1' AND user_exists($nickname, $nickname)) {
      $errors[] = USER_EXISTS_ERROR();
    }
   
    if (sizeof($errors) > 1)
    {
        //echo 'Invalid';
        //die();
        return $errors;
    }

    $birthday = strtotime($year . "-" . $month . "-" . $day);
      

    $errors = array(); 
    
    $code = generate_code(20);

    if ($user_id == "-1") {  
   
      $sql = sprintf("insert into user (nickname,email,first_name,last_name,gender,about_me,permissions_id,password,actcode,birthday) value ('%s','%s','%s','%s','%s','%s',%d,'%s','%s','%s')",
          mysql_real_escape_string($nickname), mysql_real_escape_string($nickname), mysql_real_escape_string($first_name), mysql_real_escape_string($last_name), mysql_real_escape_string($gender),
          mysql_real_escape_string($about_me), $permissions_id,
          mysql_real_escape_string(sha1('Celeb4' . $seed)), 
          mysql_real_escape_string($code), date("Y-m-d",$birthday));
      
    }
    else {  

      $sql = sprintf("UPDATE user set nickname='%s',email='%s',first_name='%s',last_name='%s',gender='%s',about_me='%s',permissions_id=%d,birthday='%s' WHERE user_id = %d",
          mysql_real_escape_string($nickname), mysql_real_escape_string($nickname), mysql_real_escape_string($first_name), mysql_real_escape_string($last_name), mysql_real_escape_string($gender),
          mysql_real_escape_string($about_me), $permissions_id,
          date("Y-m-d",$birthday), $user_id);
    }
    
    
 
    //echo $sql;
    //die();
    if (mysql_query($sql))
    {
        if ($user_id == '-1') {
          $id = mysql_insert_id();
        }
        else {
          $id = $user_id;
        }
        $errors[] = $id;
        
        return $errors;
        
 
    } else
    {
        $errors[] = -1;
        $errors[] = "User Inserted Query Failed";
    }
    return $errors;
}


 
function lostPassword($nickname, $email)
{
 
	global $seed;

    if (!valid_nickname($nickname) || !user_exists($email, $nickname) || !valid_email($email))
    {
 
        return false;
    }
    
    $query = sprintf("select user_id from user where email = '%s' and nickname = '%s' limit 1",
        mysql_real_escape_string($email),mysql_real_escape_string($nickname));
 
    $result = mysql_query($query);
 
    if (mysql_num_rows($result) != 1)
    {
 
        return false;
    }
    
 
    $newpass = generate_code(8);
 
    $query = sprintf("update user set password = '%s' where email = '%s' and nickname = '%s'",
        mysql_real_escape_string(sha1($newpass.$seed)), mysql_real_escape_string($email), mysql_real_escape_string($nickname));
 
    if (mysql_query($query))
    {
 
            if (sendLostPasswordEmail($email, $nickname, $newpass))
        {
            return true;
        } else
        {
            return false;
        }      
 
    } else
    {
        return false;
    }
 
    return false;
 
}

function isAdmin() {
  if (permissions_check ($req = 10)) {
    return true;
  }
  else {
    return false;
  }
}
 
function single_click_cast ($chart_to_cast, $birthdate, $latitude, $longitude, $LaDir, $LoDir, $timezone, $daylight, $title, $interval, $time_unknown, $method="E") {
     
     if ($LaDir == "N") {
       $LaDir = "North";
     }
     elseif ($LaDir == "S") {
       $LaDir = "South";
     }
     
     if ($LoDir == "W") {
       $LoDir = "West";
     }
     elseif ($LoDir == "E") {
       $LoDir = "East";
     }     

     $birthday = strtotime (substr ($birthdate, 0, 10));
     $birthtime = substr ($birthdate, 11, 2) . substr ($birthdate, 14, 2) . substr ($birthdate, 17, 2);
     
     //echo $latitude . $LaDir . '<br>';
     //echo $longitude . $LoDir . '<br>';
     //echo $timezone . '<br>';
     //echo $daylight . '<br>';
     //echo $title . '<br>';
     //echo $interval . '<br>';
     //echo $time_unknown . '<br>';
     //echo 'Whole BirthDate: ' . $birthdate;
     //print_r ($birthdate);
     //echo '<br>';
     //echo 'BirthDay: ' . date("m/d/Y", $birthday) . '<br>';
     //echo 'BirthTime: ' . $birthtime . '<br>';    
     //die();
     if (isset($_SESSION["proxy_user_id"]) and isAdmin()) {
       $user_id = $_SESSION["proxy_user_id"];
     }
     else {
       $user_id = get_my_user_id();
     }
 
     $url = ""; //THIS IS ONLY NEEDED TO FIX THE SPACE FOR THE ARGUMENT.  THIS FUNCTION IS NOT INTENDED TO REDIRECT.     

     if ((string)$interval != '0') {
       $return_vars1 = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "lower", $method); 
       $return_vars2 = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "higher", $method);
       save_secondary_chart ($return_vars1, $title, $birthdate, $url, false, $the_nickname="lowBound", $interval, $time_unknown, $method);
       save_secondary_chart ($return_vars2, $title, $birthdate, $url, false, $the_nickname="highBound", $interval, $time_unknown, $method);
       return consolidateCharts ("lowBound","highBound", $user_id, $chart_to_cast,$interval);
       
     }
     else {
       $return_vars = calculate_chart($birthday, $birthtime, $latitude, $longitude, $LoDir, $LaDir, $timezone, $daylight, $interval, "NA", $method); 
       return save_secondary_chart ($return_vars, $title, $birthdate, $url, false, $chart_to_cast, $interval, $time_unknown, $method);  
       
       
     }
       
    
}


?>