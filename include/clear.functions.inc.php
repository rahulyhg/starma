<?php 

function clear_compare_data() {
  unset ($_SESSION["compare_data"]);
  unset ($_SESSION["compare_chart_ids"]);
}

?>
