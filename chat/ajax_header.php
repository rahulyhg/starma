<?php

	session_start();
    require_once ('../include/db_connect.inc.php'); 
    require_once ("../include/functions.inc.php"); 
    require_once ("../PHPMailer_5.2.1/class.phpmailer.php");
    require_once ("../mandrill-api-php/src/Mandrill.php");
    date_default_timezone_set('America/Chicago');


?>