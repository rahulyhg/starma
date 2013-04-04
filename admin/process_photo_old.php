<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

if($_FILES['image']['name']) {
	list($file,$error) = upload('image','img/user','jpeg,gif,png');
	if($error) print $error;
}

header( 'Location: https://www.' . $domain . '/main.php?the_left=nav3&the_page=psel&edit=0');

?> 
