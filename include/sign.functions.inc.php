<?php 
function unknown_sign_name() {
  return "Unknown";
}


function get_sign_id_from_name ($sign_name) {
  $q = 'SELECT sign_id from sign WHERE sign_name = "' . $sign_name . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["sign_id"];
  }
  else {
    return false;
  }
}

function get_sign_id ($code) {
  $q = 'SELECT sign_id from sign WHERE sign_code = "' . strtoupper($code) . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["sign_id"];
  }
  else {
    return false;
  }
}

function get_sign_code ($sign_id) {
  $q = 'SELECT sign_code from sign WHERE sign_id = ' . $sign_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["sign_code"];
  }
  else {
    return false;
  }
}

function get_sign_name ($sign_id) {
  if ((string)$sign_id == "-1") {
    //echo "Got Here"; die();
    return unknown_sign_name();
  }
  else {
    $q = 'SELECT sign_name from sign WHERE sign_id = ' . $sign_id;
    $do_q = mysql_query ($q) or die(mysql_error());
    if ($results = mysql_fetch_array($do_q)) {
      return $results["sign_name"];
    }
    else {
      return false;
    }
  }
}

function get_sign_list () {
  $q = 'SELECT * from sign';
  $do_q = mysql_query ($q) or die(mysql_error());
  return $do_q;  
}

function get_selector_name ($sign_id, $sign_id2=-2) {
  if ($sign_id == -1) {
    //echo "Got Here"; die();
    if ($sign_id2 == -2) {
      $the_name = "Unknown_button";
    }
    else {
      $the_name = "Unknown_button rahuketu";
    
    }
  }
  else {
    if ($sign_id2 == -2) {
      $the_name = get_sign_name ($sign_id) . "_button";
    }
    else {
      $the_name = get_sign_name ($sign_id) . '_' . get_sign_name ($sign_id2) . '_button rahuketu';
    
    }
    
  }
  return $the_name;
}


?>
