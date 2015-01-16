<?php 
function get_server_type () {
  // 0 = Live
  // 1 = Dev
  // 2 = Local
  $SERVER_TYPE = 2;
  return $SERVER_TYPE;
}

function get_email_domain() {
  $SERVER_TYPE = get_server_type();
  if ($SERVER_TYPE == 1) {
    $result = 'starma.com';
  }
  elseif ($SERVER_TYPE == 2) {
    $result = 'starma.com';
  }
  else {
    $result = 'starma.com';
  }
  return $result;
}


function get_domain_sign_up ($n) {
  $SERVER_TYPE = get_server_type();
  if ($SERVER_TYPE == 1) {
    $result = 'starma.com/sign_up.php?' . $n;
  }
  elseif ($SERVER_TYPE == 2) {
    $result = '127.0.0.1:8080/sign_up.php';
  }
  else {
    $result = 'starma.com/sign_up.php?' . $n;
  }
  return $result;

}

function get_domain () {
  $SERVER_TYPE = get_server_type();
  if ($SERVER_TYPE == 1) {
    $result = 'starma.com';
  }
  elseif ($SERVER_TYPE == 2) {
    $result = '127.0.0.1:8080';
  }
  else {
    $result = 'starma.com';
  }
  return $result;
}

function get_landing () {
  $SERVER_TYPE = get_server_type();
  if ($SERVER_TYPE == 1) {
    $result = 'landing.php';
  }
  elseif ($SERVER_TYPE == 2) {
    $result = 'landing.php';
  }
  else {
    $result = 'landing.php';
  }
  return $result;
  
}

function get_full_domain () {
  $SERVER_TYPE = get_server_type();
  if ($SERVER_TYPE == 1) {
    $result = 'http://dev.' . get_domain();
  }
  elseif ($SERVER_TYPE == 2) {
    $result = 'http://' . get_domain();
  }
  else {
    $result = 'https://www.' . get_domain();
  }
  return $result; 
}

function do_redirect ($url) {
  $SERVER_TYPE = get_server_type();
  if ($SERVER_TYPE == 1) {
    header( 'Location: http://dev.' . $url);
  }
  elseif ($SERVER_TYPE == 2) {
    header( 'Location: http://' . $url);
  }
  else {
    header( 'Location: https://www.' . $url);
  }
  
  
}




?>
