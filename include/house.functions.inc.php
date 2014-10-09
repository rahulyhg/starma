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


function get_sign_in_house_id ($chart_id, $house_id) {
  //$chart_id = get_my_chart_id();
  $q = 'SELECT sign_id from chart_x_house WHERE chart_id = ' . $chart_id . ' and house_id = ' . $house_id;
  $do_q = mysql_query($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["sign_id"];
  }
  else {
    return false;
  }
}



//MATT

function get_ruler_of_sign ($sign_id) {
  $q = 'SELECT ruling_poi_id from sign WHERE sign_id = ' . $sign_id;
  $do_q = mysql_query($q) or die(mysql_error());
  if(mysql_num_rows($do_q) > 0) {
    return $do_q;
  }
  else {
    return false;
  }
}

/*
function get_lord_of_the_11th_in_the ($chart_id) {
  $ROS = get_ruler_of_sign(get_sign_in_house_id($chart_id, 11));
    return $ROS['ruling_poi_id'];
    
    if($ROS) {
      $poi_in_sign = get_sign_from_poi($chart_id, $ROS['ruling_poi_id']);
      if ($poi_in_sign) {

      }
      else {
        return 'failed to get poi_in_sign';
      }
    }
    else {
      return 'failed to get ROS';
    }
    
}
*/

//MATT OLD WAY FOR ORIGINAL DESIGN
// get_chart_x_house_id exists in ephemeris functions


function get_poi_in_house ($house_id) {
  $chart_x_house_id = get_chart_x_house_id($house_id);
  $q = 'SELECT poi_id from chart_x_house_x_poi where chart_x_house_id = ' . $chart_x_house_id;
  $do_q = mysql_query($q) or die(mysql_error());
  if (mysql_num_rows($do_q) > 0) {
    return $do_q;
  }
  else {
    return false;
  }
}

//END OLD WAY

?>
