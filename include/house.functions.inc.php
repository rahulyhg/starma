<?php 
function unknown_house_name() {
  return "Unknown";
}


function get_house_id ($house_name) {
  $q = 'SELECT house_id from house WHERE house_name = "' . $house_name . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["house_id"];
  }
  else {
    return false;
  }
}

function get_house_name ($house_id) {
  if ((string)$sign_id == "-1") {
    //echo "Got Here"; die();
    return unknown_house_name();
  }
  else {
    $q = 'SELECT house_name from house WHERE house_id = ' . $house_id;
    $do_q = mysql_query ($q) or die(mysql_error());
    if ($results = mysql_fetch_array($do_q)) {
      return $results["house_name"];
    }
    else {
      return false;
    }
  }
}

function get_house_description ($house_id) {
  $q = 'SELECT house_description from house WHERE house_id = ' . $house_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["house_description"];
  }
  else {
    return false;
  }
}

function get_house_list () {
  $q = 'SELECT * from house';
  $do_q = mysql_query ($q) or die(mysql_error());
  return $do_q;  
}

?>
