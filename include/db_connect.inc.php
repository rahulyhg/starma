<?php
// Database settings
// database hostname or IP. default:localhost
// localhost will be correct for 99% of times
//define("HOST", "starstareast.db.8497701.hostedresource.com");
define("HOST", "starma.com");
// Database user
//define("DBUSER", "starstareast");
define("DBUSER", "admin");
// Database password
//define("PASS", "b!2w4DKt");
define("PASS", "Sm(9)!-5fX0j$#");
// Database name
//define("DB", "starstareast");
define("DB", "starma_db");
 
############## Make the mysql connection ###########
$conn = mysql_connect(HOST, DBUSER, PASS) or  die('Could not connect !<br />Please contact the site\'s administrator.');
 
$db = mysql_select_db(DB) or  die('Could not connect to database !<br />Please contact the site\'s administrator.');
 
$seed="0dAfghRqSTgx";
 
?>