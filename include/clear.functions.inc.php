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

?>
