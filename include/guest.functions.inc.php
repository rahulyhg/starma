<?php

##### Guest Functions #####

function get_guest_user_id() {
	$q = 'SELECT user_id from user where nickname = "Lord_Starmeow"';
		if($result = mysql_query($q)) {
			if ($row = mysql_fetch_array ($result)) {
        		return $row['user_id'];
      		}
      		else {
        		return false;
      		}
    	}
    	else {
      		return false;
    	}
}

function get_guest_chart($user_id) {
  $q = 'SELECT * from chart where user_id = ' . $user_id . ' and personal = 1';
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
}

function get_guest_chart_id($user_id) {
  if ($chart = get_guest_chart($user_id)) {
    return $chart['chart_id'];
  }
}

function get_guest_photos() {
  //if (isLoggedIn()) {
    $user_id = get_guest_user_id();
    $q = "SELECT * from user_picture where user_id = " . $user_id . " and uncropped = 0";
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  //}
  //else {
    //return false;
  //}
}


?>