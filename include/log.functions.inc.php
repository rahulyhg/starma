<?php 

function log_this_action ($log_action_id, $log_basic_action_id, $data_1=-1, $data_2=-1, $data_3=-1, $manual_user_id=-2) {
  if (!($user_id = get_my_user_id())) {
    if ($log_action_id == account_action_user() and $log_basic_action_id == registered_basic_action()) {
      $user_id = $manual_user_id;
    }
    else {
      $user_id = -1;
    }
    
  }
  //$date_time = $mysqldate = date( 'Y-m-d H:i:s' );
  $date = date('Y') . date('m') . date('d');
  $time = date('H') . date('i') . date('s');
  $user_ip = $_SERVER["REMOTE_ADDR"];
  $log_query = 'INSERT INTO user_action_log (user_id, date, time, user_ip, log_action_id, log_basic_action_id, data_1, data_2, data_3) VALUES
               (' . $user_id . ',"' . $date . '","' . $time . '","' . $user_ip . '",' . $log_action_id . ',' . $log_basic_action_id . ',' . $data_1 . ',' . $data_2 . ',' . $data_3 . ')';
  //echo $log_query;
  //die();
  update_my_last_action_made ($date . $time);
  $do_q = mysql_query($log_query) or die(mysql_error());
  return true;
}

function log_user_invite ($inviting_user_id, $receiving_user_email, $text_body) {
    $log_query = sprintf('INSERT INTO user_invite_log (inviting_user_id, receiving_user_email, text_body) VALUES
                 (%d,"%s","%s")', $inviting_user_id, mysql_real_escape_string($receiving_user_email), mysql_real_escape_string($text_body));
    if (mysql_query($log_query)) {
      return mysql_insert_id();
    }
    else {
      return -1;
    }
}

/// LOG ACTIONS
function login_action () {
  return 1;
}

function chart_action () {
  return 2;
}

function compare_action_all () {
  return 3;
}

function compare_action_major () {
  return 4;
}

function compare_action_minor () {
  return 5;
}

function compare_action_bonus () {
  return 6;
}

function compare_action_custom () {
  return 7;
}

function compare_action_chart () {
  return 8;
}

function profile_action_profile () {
  return 9;
}

function profile_action_general () {
  return 10;
}

function profile_action_three_words () {
  return 11;
}

function profile_action_photos () {
  return 12;
}

function profile_action_interests () {
  return 13;
}

function account_action_user () {
  return 14;
}

function account_action_email () {
  return 15;
}

function profile_action_biography () {
  return 16;
}

function profile_action_favorite () {
  return 17;
}

function blogosphere_action_user () {
  return 18;
}

/// LOG BASIC ACTIONS
function login_basic_action() {
  return 1;
}

function logout_basic_action() {
  return 2;
}

function viewed_basic_action() {
  return 3;
}

function cast_basic_action() {
  return 4;
}

function compare_basic_action() {
  return 5;
}

function confirm_basic_action() {
  return 6;
}

function uploaded_basic_action() {
  return 7;
}

function editted_basic_action() {
  return 8;
}

function registered_basic_action() {
  return 9;
}

function deleted_basic_action() {
  return 10;
}

function error_basic_action() {
  return 11;
}

function invited_basic_action () {
  return 12;
}


// LOG REPORT QUERIES

function get_logs ($start_date, $end_date, $user_id=0) { // MORE FILTERS EVENTUALLY NEEDED
  if (isAdmin()) {
    $log_query = 'SELECT user_action_log.*, log_basic_action.log_basic_action, log_action.log_action, log_action.log_sub_action FROM user_action_log INNER JOIN
                         log_action on log_action.log_action_id = user_action_log.log_action_id INNER JOIN
                         log_basic_action on log_basic_action.log_basic_action_id = user_action_log.log_basic_action_id
                         WHERE date >= ' . $start_date . ' AND date <= ' . $end_date;
    if ($user_id <> 0) {
      $log_query = $log_query . ' AND user_id=' . $user_id;
    }
    //echo $log_query;
    //die(); 
    $log_query = $log_query . ' ORDER BY user_action_log.date ASC, user_action_log.time ASC';
    $do_q = mysql_query($log_query) or die(mysql_error());
    return $do_q;
  }
  else { 
    return false;
  }
} 
?>
