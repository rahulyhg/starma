<?php
    session_start();
    require_once ('include/db_connect.inc.php'); 
    require_once ("include/functions.inc.php"); 
    //fwrite(fopen('debug.txt', 'a'), 'Begin Process..\r\n');
    //echo '*'. get_my_nickname() . '*';
    //print_r ($_SESSION);
    //die();
    $user_id = $_GET['user_id'];
    
    set_online_status($user_id, 0);
?>