<?php

require_once "header.php";
?>



<?php

if (isset($_GET['chart_id'])) {
  $chart_id = (int)htmlentities(strip_tags($_GET['chart_id']));
}
else {
  $chart_id = 0;
}

if (get_chart($chart_id)) {
  show_house_chart($chart_id);
}
 
 
?>