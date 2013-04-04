<?php 

function delete_chart ($chart_id) {
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

function create_token ($to_line) {
  $token = generate_code(20);
  while (token_there($token)) {
    $token = generate_code(20);
  }
  $q = 'INSERT INTO token (token, created_for) VALUES ("' . $token . '","' . $to_line . '")';
  $do_q = mysql_query ($q) or die(mysql_error());
  return $token;
}

function token_there ($token) {
  $q = 'SELECT * from token where token = "' . $token . '"';
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($row = mysql_fetch_array($do_q)) {
    
    return true;
  }
  else {
    return false;
  }
}




?>
