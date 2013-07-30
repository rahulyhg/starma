<?php 



function get_poi_sign_blurb ($poi_id, $sign_id, $other_chart_id=-1) {
  $q = 'SELECT blurb from poi_sign_blurb WHERE poi_id = ' . $poi_id . ' and sign_id = ' . $sign_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["blurb"];
  }
  else {
    $poi_name = ucfirst(strtolower(get_poi_name($poi_id)));
    if ($other_chart_id == -1) { 
      return "Oh no!  We can't tell you about your " . $poi_name . " sign with your current birth information.  To find your " . $poi_name . " sign, please enter a more precise <a href='main.php?the_left=nav5&the_page=csel'>time of birth.</a>";
    }
    else {
      if ($other_user_id = get_user_id_from_chart_id($other_chart_id)) {
        $other_username = get_nickname($other_user_id);
        return gender_converter_wrapper (get_gender($other_user_id),"Oh no!  " . $other_username . " needs to enter a more accurate time of birth to determine his/her " . $poi_name . " sign.  Please encourage " . $other_username . " to enter a more precise time of birth.");
      }
      else {
        return "Oh no!  We can't tell you about the " . $poi_name . " sign for this Custom Chart without a more accurate <a href='" . custom_chart_url() . "'>time of birth</a>.";
      }
    
    }
  }
}

function edit_poi_sign_blurb ($poi_id, $sign_id, $blurb) {
  $q = 'SELECT * from poi_sign_blurb WHERE poi_id = ' . $poi_id . ' and sign_id = ' . $sign_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if (mysql_num_rows($do_q) == 0) {
    $q = 'INSERT INTO poi_sign_blurb (poi_id, sign_id, blurb) VALUES (' . $poi_id . ',' . $sign_id . ',"' . mysql_real_escape_string($blurb) . '")';    
  }
  else {
    $q = 'UPDATE poi_sign_blurb SET blurb="' . mysql_real_escape_string($blurb) . '" WHERE poi_id = ' . $poi_id . ' and sign_id = ' . $sign_id; 
  }
  $do_q = mysql_query ($q) or die(mysql_error());
}

function get_poi_dynamic_blurb ($poi_id_A, $poi_id_B, $dynamic_id, $section_id=1, $chart_id1=-2, $chart_id2=-2) {
  //A value of -1 in either of the two poi_id parameters means we're looking for ruling planet blurbs
  //A value of -1 in the dynamic_id means at least one of the ruling planets is unknown
  $q = 'SELECT blurb from poi_dynamic_blurb WHERE poi_id_A = ' . $poi_id_A . ' and poi_id_B = ' . $poi_id_B . ' and dynamic_id = ' . $dynamic_id . ' and section_id = ' . $section_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["blurb"];
  }
  else {
    if ($user_id2 = get_user_id_from_chart_id ($chart_id2)) {
      $username2 = get_nickname ($user_id2);
      if ($poi_id_A == $poi_id_B && ($poi_id_A != -1 || $poi_id_B != -1)) {
        //non-custom compare major
        $poi_name = ucfirst(strtolower(get_poi_name($poi_id_A))); //both poi ids are the same in this case, so it doesnt matter which one we use
        return "On no!  We can't tell you about the dynamic between your " . $poi_name . " signs.  To see your " . $poi_name . " sign compatibility, please enter a more precise <a href='main.php?the_left=nav5&the_page=csel'>time of birth.</a>  If your birth information is already exact, please encourage " . $username2 . " to enter a more precise time of birth.";
      }
      else {
        //non-custom compare minor
        return "On no!  We can't tell you about this dynamic.  Please enter a more precise <a href='main.php?the_left=nav5&the_page=csel'>time of birth.</a>  If your birth information is already exact, please encourage " . $username2 . " to enter a more precise time of birth.";
      }
    }
    else {
      if ($poi_id_A == $poi_id_B && ($poi_id_A != -1 || $poi_id_B != -1)) {
        //custom compare major
        $poi_name = ucfirst(strtolower(get_poi_name($poi_id_A))); //both poi ids are the same in this case, so it doesnt matter which one we use
        return "On no!  We can't tell you about the dynamic between your " . $poi_name . " signs because either <a href='main.php?the_left=nav5&the_page=csel'>your birth info</a> or the <a href='" . custom_chart_url() . "'>custom birth info</a> is not accurate enough.";
      }
      else {
        //custom compare minor
        return "On no!  We can't tell you about this dynamic because either <a href='main.php?the_left=nav5&the_page=csel'>your birth info</a> or the <a href='" . custom_chart_url() . "'>custom birth info</a> is not accurate enough.";
      }
    }
  }
}

function get_poi_dynamic_blurb_for_admins ($poi_id_A, $poi_id_B, $dynamic_id, $section_id=1) {
  //A value of -1 in either of the two poi_id parameters means we're looking for ruling planet blurbs
  //A value of -1 in the dynamic_id means at least one of the ruling planets is unknown
  $q = 'SELECT blurb from poi_dynamic_blurb WHERE poi_id_A = ' . $poi_id_A . ' and poi_id_B = ' . $poi_id_B . ' and dynamic_id = ' . $dynamic_id . ' and section_id = ' . $section_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["blurb"];
  }
  else {
    return "";
  }
}

function edit_poi_dynamic_blurb ($poi_id_A, $poi_id_B, $dynamic_id, $section_id, $blurb) {
  $q = 'SELECT * from poi_dynamic_blurb WHERE poi_id_A = ' . $poi_id_A . ' and poi_id_B = ' . $poi_id_B . ' and dynamic_id = ' . $dynamic_id . ' and section_id = ' . $section_id;
  $do_q = mysql_query ($q) or die(mysql_error());
  if (mysql_num_rows($do_q) == 0) {
    $q = 'INSERT INTO poi_dynamic_blurb (poi_id_A, poi_id_B, dynamic_id, section_id, blurb) VALUES (' . $poi_id_A . ',' . $poi_id_B . ',' . $dynamic_id . ',' . $section_id . ',"' . mysql_real_escape_string($blurb) . '")';    
  }
  else {
    $q = 'UPDATE poi_dynamic_blurb SET blurb="' . mysql_real_escape_string($blurb) . '" WHERE poi_id_A = ' . $poi_id_A . ' and poi_id_B = ' . $poi_id_B . ' and dynamic_id = ' . $dynamic_id . ' and section_id = ' . $section_id; 
  }
  $do_q = mysql_query ($q) or die(mysql_error());
}

function get_dynamic_blurb ($poi_id1, $poi_id2) {
  $q = 'SELECT * from dynamic_blurb WHERE poi_id_A = ' . $poi_id1 . ' and poi_id_B = ' . $poi_id2;
  $do_q = mysql_query ($q) or die(mysql_error());
  if ($results = mysql_fetch_array($do_q)) {
    return $results["dynamic_blurb"];
  }
  else {
    return false;
  }  
}

?>
