<?php

require_once("mail.functions.inc.php");
require_once("user.functions.inc.php");
require_once("display.functions.inc.php");
require_once("login.functions.inc.php");
require_once("validation.functions.inc.php");
require_once("server.functions.inc.php");
require_once("math.functions.inc.php");
require_once("poi.functions.inc.php");
require_once("house.functions.inc.php");
require_once("sign.functions.inc.php");
require_once("ephemeris.functions.inc.php");
require_once("datetimelocation.functions.inc.php");
require_once("compare.functions.inc.php");
require_once("blurb.functions.inc.php");
require_once("js.functions.inc.php");
require_once("widgets.functions.inc.php");
require_once("clear.functions.inc.php");
require_once("upload.functions.inc.php");
require_once("log.functions.inc.php");
require_once("vars.functions.inc.php");
require_once("chat.functions.inc.php");
require_once("security.functions.inc.php");
require_once("guest.functions.inc.php"); //guest functions

if (permissions_check ($req = 10)) {
  
  require_once("admin.functions.inc.php");  
}

 
function generate_code($length = 10)
{
 
    if ($length <= 0)
    {
        return false;
    }
 
    $code = "";
    $chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    srand((double)microtime() * 1000000);
    for ($i = 0; $i < $length; $i++)
    {
        $code = $code . substr($chars, rand() % strlen($chars), 1);
    }
    return $code;
 
}
 
?>