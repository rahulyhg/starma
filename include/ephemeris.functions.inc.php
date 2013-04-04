<?php 
function get_poi_coordinates ($chart_id, $poi_id) {
  $q = 'SELECT * 
FROM `chart` inner join chart_x_house on chart.chart_id = chart_x_house.chart_id inner join chart_x_house_x_poi on chart_x_house.chart_x_house_id = chart_x_house_x_poi.chart_x_house_id where chart.chart_id = ' . $chart_id . ' and poi_id = ' . $poi_id;
  echo $q;
  if ($r = mysql_query($q) or die(mysql_error())) {
    $row = mysql_fetch_array($r);
    return $row["coordinates"];
  }
  else {
    return false;
  }
}

function get_chart_x_house_id ($chart_id, $house_id) {
  $q = 'SELECT chart_x_house_id from chart_x_house where chart_id = ' . $chart_id . ' and house_id = ' . $house_id;
  if ($r = mysql_query($q) or die(mysql_error())) {
    $row = mysql_fetch_array($r);
    return $row["chart_x_house_id"];
  }
}

function get_chart_x_house_id_from_sign_id ($chart_id, $sign_id) {
  $q = 'SELECT chart_x_house_id from chart_x_house where chart_id = ' . $chart_id . ' and sign_id = ' . $sign_id;
  if ($r = mysql_query($q) or die(mysql_error())) {
    $row = mysql_fetch_array($r);
    return $row["chart_x_house_id"];
  }
}

function get_chart_x_house_x_poi_id ($chart_id, $poi_id) {
  $q = 'SELECT *
FROM `chart` inner join chart_x_house on chart.chart_id = chart_x_house.chart_id inner join chart_x_house_x_poi on chart_x_house.chart_x_house_id = chart_x_house_x_poi.chart_x_house_id where chart.chart_id = ' . $chart_id . ' and poi_id = ' . $poi_id;
  echo $q;
  if ($r = mysql_query($q) or die(mysql_error())) {
    $row = mysql_fetch_array($r);
    return $row["chart_x_house_x_poi_id"];
  }
  else {
    return false;
  }
}


function ayanamsa ($year) {
  $year = (int) $year;
  $difference = $year - 1920;
  $result = '224500';
  $seconds_add = round (50.26 * (float) $difference);
  $result = coordinate_add ($result, up_to_coord ($seconds_add));
  return $result;
  
  
}

function deltaT ($year) {
  $q = 'SELECT * from deltaT WHERE year = "' . $year . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if (mysql_num_rows($do_q) > 0) {
    //echo "returning true" . mysql_num_rows($do_q);
    return mysql_fetch_array($do_q);
  }
  else {
    //echo "returning false";
    return false;
  }
}


function gsTime ($date) {
  $year = date("Y", $date);
  $month = date("n", $date);
  $day = date("j", $date);
  //echo $year . '^' .  $month . '^' . $day;
  $q = 'SELECT * from ephemeris WHERE year = ' . $year . ' and month_id = ' . $month . ' and day_date = ' . $day;
  $do_q = mysql_query ($q) or die(mysql_error());
  if (mysql_num_rows($do_q) > 0) {
    //echo "returning true" . mysql_num_rows($do_q);
    return mysql_fetch_array($do_q);
  }
  else {
    //echo "returning false";
    return false;
  }
}

function getPOIPosition ($date, $POIID) {
  $year = date("Y", $date);
  $month = date("n", $date);
  $day = date("j", $date);
  //echo $year . '^' .  $month . '^' . $day;
  $q = 'SELECT * from ephemeris WHERE year = ' . $year . ' and month_id = ' . $month . ' and day_date = ' . $day . ' and poi_id = ' . $POIID;
  $do_q = mysql_query ($q) or die(mysql_error());
  if (mysql_num_rows($do_q) > 0) {
    //echo "returning true" . mysql_num_rows($do_q);
    $result = mysql_fetch_array($do_q);
    return $result["poi_position"];
  }
  else {
    //echo "returning false";
    return false;
  }
}

function ssCorrection ($time) {
  $hours = format_piece (get_hours($time));
  $mins = format_piece (get_minutes($time));
  //echo $time . '<br>';
  //echo $hours . '^' .  $mins;
  
  $q = 'SELECT * from solarsiderealcorrection WHERE hours = "' . $hours . '" and minutes = "' . $mins . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if (mysql_num_rows($do_q) > 0) {
    //echo "returning true" . mysql_num_rows($do_q);
    return mysql_fetch_array($do_q);
  }
  else {
    //echo "returning false";
    return false;
  }
}

function getAscPosition ($degrees, $LST) {
  $q = 'SELECT * from table_of_houses WHERE latitude = ' . $degrees . ' and local_sidereal_time = "' . $LST . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if (mysql_num_rows($do_q) > 0) {
    //echo "returning true" . mysql_num_rows($do_q);
    $result = mysql_fetch_array($do_q);
    return $result["rising"];
  }
  else {
    //echo "returning false";
    return false;
  }
}

?>
