<?php 
/*////////////////////////////////// PERMISSIONS ID CONSTANTS //////////////////////////////////*/
function PERMISSIONS_CELEB() {
   return -1;
}

function PERMISSIONS_ADMIN() {
   return 10;
}
/*/////////////////////////////// END PERMISSIONS ID CONSTANTS /////////////////////////////////*/

/*////////////////////////////////// LAYOUT CONSTANTS //////////////////////////////////*/
function USER_BLOCK_COMPARE_HEIGHT() {
   return 200;
}

function USER_BLOCK_PER_ROW() {
   return 4;
}

/*/////////////////////////////// END LAYOUT CONSTANTS /////////////////////////////////*/
function custom_chart_url() {
  return '/main.php?the_left=nav3&the_page=cosel';
}


function grab_var($var_name, $initial_value=-1) {
  if (isset($_SESSION[$var_name])) {
    return $_SESSION[$var_name];
  }
  elseif (isset($_POST[$var_name])) {
    return $_POST[$var_name];
  }
  elseif (isset($_GET[$var_name])) {
    return $_GET[$var_name];
  }
  else {
    return $initial_value;
  }
}


function store_chart_input_vars() {
  // CALL THIS FUNCTION RIGHT AFTER A CHART SUBMITTEAL FORM POST
  $chart_vars = array();

  $chart_vars["address"] = $_POST["address"];

  $chart_vars["c2d"] = $_POST["c2d"];
  $chart_vars["c2m"] = $_POST["c2m"];
  $chart_vars["c2s"] = $_POST["c2s"];

  $chart_vars["c1d"] = $_POST["c1d"];
  $chart_vars["c1m"] = $_POST["c1m"];
  $chart_vars["c1s"] = $_POST["c1s"];

  $chart_vars["LoDir"] = $_POST["LoDir"];
  $chart_vars["LaDir"] = $_POST["LaDir"];
  $chart_vars["timezone"] = $_POST["timezone"];
  $chart_vars["daylight"] = $_POST["daylight"];

  $chart_vars["hour_time"] = $_POST["hour_time"];
  $chart_vars["minute_time"] = $_POST["minute_time"];
  $chart_vars["second_time"] = $_POST["second_time"];  

  $chart_vars["interval"] = $_POST["interval"];

  $chart_vars["meridiem_time"] = $_POST["meridiem_time"];
 
  $chart_vars["time_unknown"] = $_POST["time_unknown"];

  if ((string)$_POST["stage"] == "2" or isset($_SESSION["change_info"]) or (isAdmin() and isset($_SESSION["proxy_user_id"]))) { //IF COMING FROM ENTERING ANOTHER USERS INFO, AS AN ADMIN OR OTHERWISE     
     $chart_vars["year_birthday"] = $_POST["year_birthday"];
     $chart_vars["month_birthday"] = $_POST["month_birthday"];
     $chart_vars["day_birthday"] = $_POST["day_birthday"];
  }
  $_SESSION["chart_input_vars"] = $chart_vars;
}

function var_map($var_name) {
  $result = $var_name;
  switch ($var_name) {
    case ('location'):  
      $result = "address";
      break;
    
  }
  return $result;
}

function get_inputed_var ($var_name, $default_value="", $type="default") {
  $post_name = var_map($var_name);
  if (isset($_POST[$post_name])) {
    $result = $_POST[$post_name];
  }
  elseif (isset($_SESSION["chart_input_vars"])) {
    $result = $_SESSION["chart_input_vars"][$post_name];
  }
  else {
    if ($type=="mine" || $type=="freebie" || is_numeric($type)) {
      if ($type=="freebie") {
        $my_chart = get_chart_by_name("Freebie1"); 
      }
      elseif (is_numeric($type)) {
        $my_chart = get_chart_by_name("Main",$type);
      }
      else {
        $my_chart = get_my_chart();
      }
      if ($var_name == 'interval') {
        $var_name = "interval_time";
        if ($my_chart[$var_name] != '-1') {
          $result = format_whole_time ($my_chart[$var_name]);
        }
        else {
          $result = $my_chart[$var_name];
        }
      }
      else {
        $result = $my_chart[$var_name];
      }
    }  
    else {
      $result = $default_value;
    }
  }
  
  return $result;
}

function get_inputed_date ($type="default") {
  if (isset($_SESSION["chart_input_vars"])) {
    $result = strtotime($_SESSION["chart_input_vars"]["year_birthday"] . '-' . $_SESSION["chart_input_vars"]["month_birthday"] . '-' . $_SESSION["chart_input_vars"]["day_birthday"]);
  }
  elseif (isset($_POST["year_birthday"])) {
    $result = strtotime($_POST["year_birthday"] . '-' . $_POST["month_birthday"] . '-' . $_POST["day_birthday"]);
  }
  else {
    if ($type=="mine" || $type=="freebie" || is_numeric($type)) {
      if ($type=="freebie") {
        $my_chart = get_chart_by_name("Freebie1"); 
      }
      elseif (is_numeric($type)) {
        $my_chart = get_chart_by_name("Main",$type);
      }
      else {
        if (!get_my_chart()) {
          $my_chart = get_my_birthday();
        }
        else {
          $my_chart = get_my_chart();
        }
      }
      $result = strtotime($my_chart["birthday"]); 
    }
    else {
      $result = time();
    }
  }
  return $result;
}

function get_inputed_time ($type="default") {
  if (isset($_SESSION["chart_input_vars"])) {
    $result = strtotime($_SESSION["chart_input_vars"]["hour_time"] . ':' . $_SESSION["chart_input_vars"]["minute_time"] . ':' . $_SESSION["chart_input_vars"]["second_time"]);
  }
  else {
    if ($type=="mine" || $type=="freebie" || is_numeric($type)) {
      if ($type=="freebie") {
        $my_chart = get_chart_by_name("Freebie1"); 
      }
      elseif (is_numeric($type)) {
        $my_chart = get_chart_by_name("Main",$type);
      }
      else {
        $my_chart = get_my_chart();
      }
      $result = strtotime($my_chart["birthday"]); 
    }
    else {
      $result = strtotime('00:00:00');
    }
  }
  return $result;
}


function clean_session() {
  unset($_SESSION["change_info"]);
  unset($_SESSION["chart_input_vars"]);
  
}


?>
