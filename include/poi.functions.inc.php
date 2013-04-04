<?php 

function poi_left_side () {
  //return array(1,2,3,6,7);
  return array(1,2,3,7,4);
}

function poi_right_side () {
  //return array(4,5,8,9);
  return array(5,6,8,9);
}

function get_poi_id ($poi_name) {
  $q = 'SELECT poi_id from poi WHERE poi_name = "' . $poi_name . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["poi_id"];
  }
  else {
    return false;
  }
}

function get_poi_name ($poi_id) {
  $q = 'SELECT poi_name from poi WHERE poi_id = ' . $poi_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["poi_name"];
  }
  else {
    return false;
  }
}

function get_poi_list () {
  $q = 'SELECT * from poi where disabled=0 ORDER BY poi_order';
  $do_q = mysql_query ($q) or die(mysql_error());
  return $do_q;  
}

function get_poi_blurb ($poi_id) {
  $q = 'SELECT * from poi WHERE disabled = 0 and poi_id = ' . $poi_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["poi_blurb"];
  }
  else {
    return false;
  }  
}



?>
