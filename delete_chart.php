<?php

 require_once ("header.php");

if (isLoggedIn()) {
  if (isset($_POST['chart_id']))
  {
    $chart_id = $_POST['chart_id'];
    delete_chart ($chart_id=$chart_id);
    header( 'Location: http://www.' . $domain . '/index.php');

  }
  else
  {
      header( 'Location: http://www.' . $domain . '/index.php');
  }
 
} else
{
    // The user is already loggedin, so we show the userbox.
    //show_userbox();
    header( 'Location: http://www.' . $domain . '/index.php');
    //header( 'Location: http://' . $domain . '/index.php');

}
?> 
