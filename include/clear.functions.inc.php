<?php 

function clear_compare_data() {
  unset ($_SESSION["compare_data"]);
  unset ($_SESSION["compare_chart_ids"]);
  unset ($_SESSION["compare_more_info_flag"]);
}

function clear_session_preferences() {
  unset ($_SESSION["compare_more_info_flag"]);
  unset ($_SESSION["chart_more_info_flag"]);
  //unset ($_SESSION["western_chart_more_info_flag"]);
}

function clear_session_first_time_vars() {
  unset ($_SESSION["des_name_1"]);
  unset ($_SESSION["des_name_2"]);
  unset ($_SESSION["des_name_3"]);
  
}

function clear_error() {
  unset ($_SESSION["errors"]);
}

?>
