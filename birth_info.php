<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  $_SESSION["change_info"] = true;
  if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
    unset ($_SESSION["errors"]);
    show_birth_info_form($errors=$errors, $sao=1, $title="", $action="cast_chart.php");
  }
  elseif (isset($_SESSION["return_vars"])) {
    $return_vars = $_SESSION["return_vars"];
    $title = $_SESSION["title"];
    $birthtime = $_SESSION["birthtime"];
    $interval = $_SESSION["interval"];
    $time_unknown = $_SESSION["time_unknown"];
    if ((string)$interval != '0') {
      $return_vars2 = $_SESSION["return_vars2"];
      unset ($_SESSION["return_vars2"]);
    }
    else {
      $return_vars2 = 0;
    }
    //print_r ($return_vars);
    //die();
    unset ($_SESSION["return_vars"]);
    unset ($_SESSION["title"]);
    unset ($_SESSION["birthtime"]);
    unset ($_SESSION["interval"]);
    unset ($_SESSION["time_unknown"]);
    confirm_form($return_vars, $title, $birthtime, $return_vars2, $interval, $time_unknown);
    
  }
  else {
    show_birth_info_form();
  }
  //show_birth_info_form();
}

  


?> 
