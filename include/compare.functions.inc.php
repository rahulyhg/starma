<?php
function quicksort_users($user_array, $asc=0){
	$loe = $gt = array();
	if(count($user_array) < 2){
		return $user_array;
	}
	$pivot_key = key($user_array);
	$pivot = array_shift($user_array);
	foreach($user_array as $val){
           if ($asc == 1) {
		if($val["score"] <= $pivot["score"]){
			$loe[] = $val;
		}elseif ($val["score"] > $pivot["score"]){
			$gt[] = $val;
		}
           }
           else {
                if($val["score"] > $pivot["score"]){
			$loe[] = $val;
		}elseif ($val["score"] <= $pivot["score"]){
			$gt[] = $val;
		}
           }
	}
	return array_merge(quicksort_users($loe, $asc),array($pivot_key=>$pivot),quicksort_users($gt, $asc));
}
 

function add_scores($user_list) {
  $user_array = query_to_array($user_list);
  $counter = 0;
  foreach ($user_array as $user) {
    $score = compare_charts (generate_compare_data (get_my_chart_id(), $user["chart_id"], $store=0), $error_check=false);
    $user_array[$counter]["score"] = $score;
    $counter = $counter + 1;
  }
  return $user_array;
}


function query_to_array($query) {
  while( $row = mysql_fetch_assoc( $query)) {
    $new_array[] = $row;
  }
  return $new_array;
}

function num_times_compared($user_id, $threshold) {
  $date = (int)substr($threshold, 0, 8);
  $time = (int)substr($threshold, 8, 6);
  //echo $date . '<br>' . $time . '<br>';
  $q = 'SELECT COUNT(*) as num_compares from user_action_log 
        WHERE log_action_id = ' . compare_action_chart() . ' and log_basic_action_id = ' . compare_basic_action() . ' and data_2 = ' . $user_id . ' and date >= ' . $date . ' and time >= ' . $time;
  //echo $q;
  $result = mysql_query($q) or die(mysql_error());
  if ($info = mysql_fetch_array($result)) {
    return $info["num_compares"];
  }
  else {
    return false;
  }
}

function compare_tier_2 ($gotothe, $results_type, $text_type) {
          
      
 
      if (!isset($_SESSION['compare_data'])) {
        generate_compare_data ($_GET["chart_id1"], $chart_id2 = $_GET["chart_id2"]);
        //Log the Action
        log_this_action (compare_action_chart(), compare_basic_action(), $_GET["chart_id2"], get_user_id_from_chart_id($_GET["chart_id2"]));
      }
      if (cornerstones_all_there ($_SESSION['compare_chart_ids'][0]) && cornerstones_all_there($_SESSION['compare_chart_ids'][1])) {
        $total_score = compare_charts ($compare_results = $_SESSION["compare_data"], $error_check = false);
      }
      else {
        $total_score = -1;
      }
      //echo $total_score;
      show_compare_results ($score = $total_score, $goto=$gotothe, $results_type=$results_type, $text_type=$text_type, $stage = $_GET["stage"]);
      switch ($results_type) {
        case "major": 
          show_major_connections ($compare_data=$_SESSION["compare_data"], $text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
          break;
        case "minor": 
          show_minor_connections ($compare_data=$_SESSION["compare_data"], $text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
          break;            
        case "bonus": 
          show_bonus_connections ($compare_data=$_SESSION["compare_data"], $text_type, $goTo = $gotothe, $stage=$_GET["stage"], $chart_id1=$_SESSION['compare_chart_ids'][0], $chart_id2=$_SESSION['compare_chart_ids'][1]);
          break;
      }
      //compare_charts_old($chart_id1 = $_GET["chart_id1"], $chart_id2 = $_GET["chart_id2"]);
}


function get_rela_selector_name ($relationship_id) {
  if ((string)$relationship_id == '-1') {
    return "my_unknown_button";
  }
  else {
    return "my_" . $relationship_id . "_button";
  }
}


function cornerstones_all_there ($chart_id) {
  $all_there = true;
  $cs_array = get_cornerstones(6);
  $cs_sign_id_array = get_corner_stones ($chart_id);
  foreach ($cs_array as $cs) {
    if ((string)$cs_sign_id_array[$cs] == '-1') {
      $all_there = false;
    }
  }
  //echo $all_there;
  //die();
  return $all_there;
}


function get_cornerstones ($depth=4) {
  $cornerstones = array('rising','sun','moon','venus','ruling','jupiter');
  $return_array = array();
  for ($x=0; $x<$depth; $x++) {
    $return_array[] = $cornerstones[$x];
  }
  return $return_array;
}

function get_section_list () {
  $q = 'SELECT * from section';
  $do_q = mysql_query ($q) or die(mysql_error());
  return $do_q;  
}

function get_relationship_list () {
  $q = 'SELECT * from relationship';
  $do_q = mysql_query ($q) or die(mysql_error());
  return $do_q;  
}


function generate_compare_data ($chart_id1, $chart_id2, $store=1) {
  

  $chart1 = get_corner_stones ($chart_id1);
  $chart2 = get_corner_stones ($chart_id2);

  $cornerstones = get_cornerstones($depth=6);

  //echo "Left Chart Rising: " . $chart1['rising'];

  $r2rInfo = get_connection ($chart1['rising'], $chart2['rising']);
  $s2sInfo = get_connection ($chart1['sun'], $chart2['sun']);
  $m2mInfo = get_connection ($chart1['moon'], $chart2['moon']);
  $v2vInfo = get_connection ($chart1['venus'], $chart2['venus']);
  $ru2ruInfo = get_connection ($chart1['ruling'], $chart2['ruling']);

  $compare_results = array("rising2rising" => $r2rInfo, "sun2sun" => $s2sInfo, "moon2moon" => $m2mInfo, "venus2venus" => $v2vInfo, "ruling2ruling" => $ru2ruInfo);

  
  foreach ($cornerstones as $name1) {
    foreach ($cornerstones as $name2) {
      if ($name1 != $name2) {
        //echo $chart1[$cornerstones[$place1]] . ' to ' . $chart2[$cornerstones[$place2]] . '<br>';

        $sign1 = $chart1[$name1];    
        $sign2 = $chart2[$name2];
        $score =  get_connection ($sign1, $sign2);
        $compare_results[$name1 . '2' . $name2] = $score;
      }
      
    }
  }
 
  //echo "*";
  //print_r ($compare_results);
  //echo "*";
  if ($store == 1) {
    $_SESSION['compare_data'] = $compare_results;
    $_SESSION['compare_chart_ids'] = array($chart_id1, $chart_id2);
  }
  else {
    return $compare_results;
  }

}


function compare_charts ($compare_results, $error_check=true) {
  //WEIGHTED SCORE CONSTANTS

  $rising = 0.15;
  $prim = 0.36;
  $sec = 0.42;
  $ruling = 0.07;
  $mut = 0.01;
  $jup = 0.005;

  $r2rScore = $compare_results["rising2rising"]["relationship_score"];
  $s2sScore = $compare_results["sun2sun"]["relationship_score"];
  $m2mScore = $compare_results["moon2moon"]["relationship_score"];
  $v2vScore = $compare_results["venus2venus"]["relationship_score"];
  $ru2ruScore = $compare_results["ruling2ruling"]["relationship_score"];

  if ($error_check) {
    echo '<i>';
    echo 'r2rScore: ' . $r2rScore . '<br>';
    echo 's2sScore: ' . $s2sScore . '<br>';
    echo 'm2mScore: ' . $m2mScore . '<br>';
    echo 'v2vScore: ' . $v2vScore . '<br>';
    echo '</i>';
    echo '<br>';
  }

  $rising_score = ($r2rScore * $rising);

  $other_prim_score = (($s2sScore + $m2mScore + $v2vScore) / 3) * $prim;
  
  if ($error_check) {
    echo 'Rising Connection: ' . $rising_score . '<br>';
 
    echo 'Other 3 Primary Connections: ' . $other_prim_score . '<br>';
  }

  $primary_score = $rising_score + $other_prim_score;

  $secondary_score = (float) 0.0;

  $cornerstones_only = get_cornerstones ($depth=4);
  $cornerstones_plus_ruling = get_cornerstones ($depth=5);


  foreach (get_cornerstones ($depth=4) as $name1) {
    foreach (get_cornerstones ($depth=4) as $name2) {
      if ($name1 != $name2) {
        
        $secondary_score = $secondary_score + (float) $compare_results[$name1 . "2" . $name2]["relationship_score"];
      }
      
    }
  }
  
  $secondary_score = ($secondary_score / 12) * $sec;

  if ($error_check) {
    echo 'Secondary Connections: ' . $secondary_score . '<br>';
  }

  $secondary_score = $secondary_score + ($ru2ruScore * $ruling);

  if ($error_check) {
    echo 'Ruling Planet Connection: ' . ($ru2ruScore * $ruling) . '<br>';
  }

  $mutual_score = 0.0;

  for ($place1 = 0; $place1 <= 3; $place1++) {
    for ($place2 = $place1 + 1; $place2 <= 3; $place2++) {
      $name1 = $cornerstones_only[$place1];
      $name2 = $cornerstones_only[$place2];
      if ($compare_results[$name1 . "2" . $name2]['relationship_score'] >= 0.85 and $compare_results[$name2 . "2" . $name1]['relationship_score'] >= 0.85)
        $mutual_score = $mutual_score + $mut;
      
    }
  }

  if ($error_check) { 
    echo 'Mutual Bonus Connection: ' . $mutual_score . '<br>';
  }

  $secondary_score = $secondary_score + ($mutual_score);

  $jup_score = 0.0;
  
  foreach (get_cornerstones ($depth=5) as $name1) {  
    
    if ($compare_results[$name1 . "2jupiter"]['relationship_score'] >= 0.95) {
      $jup_score = $jup_score + $jup; }
    if ($compare_results["jupiter2" . $name1]['relationship_score'] >= 0.95) {
      $jup_score = $jup_score + $jup; }
      
   
  }
 
  if ($error_check) { 
    echo 'Jupiter Bonus Connection: ' . $jup_score . '<br>';
  }

  $secondary_score = $secondary_score + ($jup_score);
  

  $total_score = $primary_score + $secondary_score;
  if ($error_check) {
    echo '<br>';
    echo '<b>Primary Score: ' . $primary_score . '</b><br>';

    echo '<b>Secondary Score: ' . $secondary_score . '</b><br>';
    echo '<br>';
    echo '<b><i>Total Score: ' . $total_score . '</i></b><br>';
  }
  return $total_score;

}

  
function compare_charts_old ($chart_id1, $chart_id2) {
  //WEIGHTED SCORE CONSTANTS

  $rising = 0.15;
  $prim = 0.36;
  $sec = 0.42;
  $ruling = 0.07;
  $mut = 0.01;
  $jup = 0.005;

  $chart1 = get_corner_stones ($chart_id1);
  $chart2 = get_corner_stones ($chart_id2);

  $cornerstones = array('rising','sun','moon','venus','ruling','jupiter');

  $r2rInfo = get_connection ($chart1['rising'], $chart2['rising']);
  $s2sInfo = get_connection ($chart1['sun'], $chart2['sun']);
  $m2mInfo = get_connection ($chart1['moon'], $chart2['moon']);
  $v2vInfo = get_connection ($chart1['venus'], $chart2['venus']);
  $ru2ruInfo = get_connection ($chart1['ruling'], $chart2['ruling']);

  $r2rScore = $r2rInfo['relationship_score'];
  $s2sScore = $s2sInfo['relationship_score'];
  $m2mScore = $m2mInfo['relationship_score'];
  $v2vScore = $v2vInfo['relationship_score'];
  $ru2ruScore = $ru2ruInfo['relationship_score'];


 

  echo '<i>';
  echo 'r2rScore: ' . $r2rScore . '<br>';
  echo 's2sScore: ' . $s2sScore . '<br>';
  echo 'm2mScore: ' . $m2mScore . '<br>';
  echo 'v2vScore: ' . $v2vScore . '<br>';
  echo '</i>';
  echo '<br>';

  $rising_score = ($r2rScore * $rising);

  $other_prim_score = (($s2sScore + $m2mScore + $v2vScore) / 3) * $prim;
  
  echo 'Rising Connection: ' . $rising_score . '<br>';
 
  echo 'Other 3 Primary Connections: ' . $other_prim_score . '<br>';

  $primary_score = $rising_score + $other_prim_score;

  $secondary_score = (float) 0.0;
  for ($place1 = 0; $place1 <= 3; $place1++) {
    for ($place2 = 0; $place2 <= 3; $place2++) {
      if ($place1 != $place2) {
        //echo $chart1[$cornerstones[$place1]] . ' to ' . $chart2[$cornerstones[$place2]] . '<br>';
        $sign1 = $chart1[$cornerstones[$place1]];    
        $sign2 = $chart2[$cornerstones[$place2]];
        $score =  get_connection ($sign1, $sign2);
        $secondary_score = $secondary_score + (float) $score["relationship_score"];
      }
      
    }
  }
  
  $secondary_score = ($secondary_score / 12) * $sec;

  echo 'Secondary Connections: ' . $secondary_score . '<br>';

  $secondary_score = $secondary_score + ($ru2ruScore * $ruling);

  echo 'Ruling Planet Connection: ' . ($ru2ruScore * $ruling) . '<br>';

  $mutual_score = 0.0;

  for ($place1 = 0; $place1 <= 3; $place1++) {
    for ($place2 = $place1 + 1; $place2 <= 3; $place2++) {
      
      $connection1 = get_connection ($chart1[$cornerstones[$place1]], $chart2[$cornerstones[$place2]]);
      $connection2 = get_connection ($chart2[$cornerstones[$place1]], $chart1[$cornerstones[$place2]]);
      if ($connection1['relationship_score'] >= 0.85 and $connection2['relationship_score'] >= 0.85)
        $mutual_score = $mutual_score + $mut;
      
    }
  }

  echo 'Mutual Bonus Connection: ' . $mutual_score . '<br>';

  $secondary_score = $secondary_score + ($mutual_score);

  $jup_score = 0.0;
  
  for ($place1 = 0; $place1 <= 4; $place1++) {
    
      
    $connection1 = get_connection ($chart1[$cornerstones[$place1]], $chart2['jupiter']);
    $connection2 = get_connection ($chart2[$cornerstones[$place1]], $chart1['jupiter']);
    if ($connection1['relationship_score'] >= 0.95) {
      $jup_score = $jup_score + $jup; }
    if ($connection2['relationship_score'] >= 0.95) {
      $jup_score = $jup_score + $jup; }
      
   
  }
 
  echo 'Jupiter Bonus Connection: ' . $jup_score . '<br>';

  $secondary_score = $secondary_score + ($jup_score);
  

  $total_score = $primary_score + $secondary_score;
  echo '<br>';
  echo '<b>Primary Score: ' . $primary_score . '</b><br>';

  echo '<b>Secondary Score: ' . $secondary_score . '</b><br>';
  echo '<br>';
  echo '<b><i>Total Score: ' . $total_score . '</i></b><br>';
  

}

function get_corner_stones ($chart_id) {
  $cs_array = array();
  $cs_array['rising'] = get_sign_from_poi ($chart_id = $chart_id, $poi_id = 1);
  $cs_array['sun'] = get_sign_from_poi ($chart_id = $chart_id, $poi_id = 2);
  $cs_array['moon'] = get_sign_from_poi ($chart_id = $chart_id, $poi_id = 3);
  $cs_array['venus'] = get_sign_from_poi ($chart_id = $chart_id, $poi_id = 7);
  $cs_array['ruling'] = get_sign_from_poi ($chart_id = $chart_id, $poi_id = get_ruling_planet($chart_id));
  $cs_array['jupiter'] = get_sign_from_poi ($chart_id = $chart_id, $poi_id = 6);
  
  return $cs_array; 
}



function get_connection ($sign_id1, $sign_id2) {
  if ((string)$sign_id1 == '-1' || (string)$sign_id2 == '-1') {
    return array("relationship_id" => -1, "relationship_title" => "Unknown");
  }
  else {
    $interval1 = $sign_id1 - $sign_id2 + 1;
    $interval2 = $sign_id2 - $sign_id1 + 1;
  
    if ($interval1 <= 0) {
      $interval1 = $interval1 + 12;
    }
    if ($interval2 <= 0) {
      $interval2 = $interval2 + 12;
    }
    //echo $interval1 . '-' . $interval2 . '<br>';
    $total_interval = $interval1 - $interval2;
    if ($total_interval < 0) {
      $total_interval = $total_interval * -1;
    }
    //echo $total_interval . '<br>';
    $pp = '';
    if ($total_interval == 0) {
      if ($interval1 == 1) {
        $pp = ' and relationship_id = 1';
      }  
      else {
        $pp = ' and relationship_id = 2';
      }
    }
    $q = 'SELECT * FROM relationship where relationship_interval = ' . $total_interval . $pp;
    $result = mysql_query($q) or die (mysql_error());
    $info = mysql_fetch_array ($result);
    return $info;
  }
}



?>
