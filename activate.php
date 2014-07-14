<?php

require_once "header.php";
?>

<div id="landing_outer">
<div id="landing_content">

<?php

$uid = (int)htmlentities(strip_tags($_GET['uid']));
$actcode = htmlentities(strip_tags($_GET['actcode']));
 
if (activateUser($uid, $actcode) == true)
{
    echo "Thank you for activating your account, You can now login.
		<a href='./" . get_landing() . "'>Click here to login.</a>";
} else
{
    echo "Activation failed! Please try again.";
    echo "If problem presists please contact the webmaster.";
}
 
?>
</div</div>