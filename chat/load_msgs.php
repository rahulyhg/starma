<?php
   session_start();
  require_once ('../include/db_connect.inc.php'); 
  require_once ("../include/functions.inc.php"); 
  date_default_timezone_set('America/Chicago');
  //echo "*" . $_GET["partner_id"] . "*" . $_POST["partner_id"];
  //die();
  //echo $_SESSION["timezoneOffset"];
  show_msg_area ($_GET["partner_id"]);
 
?> 
