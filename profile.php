<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

echo '<div id="profile_div">';
  show_chart($chart_id = get_my_chart_id(), $goTo="profile.php");
echo '</div>';

?> 
