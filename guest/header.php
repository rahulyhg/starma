<?php
ob_start();
//ini_set('memory_limit', '256M');
//  error_reporting(0); // we don't want to see errors on screen - REMOVE THIS WHEN LIVE
error_reporting( error_reporting() & ~E_NOTICE );
//echo "Magic quotes is " . (get_magic_quotes_gpc() ? "ON" : "OFF");
//set_magic_quotes_runtime(1);
//echo "Magic quotes is " . (get_magic_quotes_gpc() ? "ON" : "OFF");
// Start a session
session_start();
require_once ('../include/db_connect.inc.php'); // include the database connection
require_once ("../PHPMailer_5.2.1/class.phpmailer.php");
require_once ("../include/functions.inc.php"); // include all the functions
require_once ("../include/guest.functions.inc.php"); //guest functions
//$seed="0dAfghRqSTgx"; // the seed for the passwords
$domain =  "starma.com"; // the domain name without http://www.
$landing =  "landing.php";
//ini_set('display_errors',1);
//error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('America/Chicago');
//mb_internal_encoding("utf-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $pageTitle; ?></title>
<meta name="description" content="<?php echo $pageDescription; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">   <!-- Matt should we change to charset=utf-8 so json_encode will work?  -->

<!--HI MY NAME IS SLIM SHADY--->
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  <!-- Matt updated jquery -->
<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script> 
<!--<script src="//ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/jquery.mobile.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/jquery.mobile.min.css" />-->
<?php 
  
    echo '
      <LINK REL="StyleSheet" HREF="../css/reset.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="../css/chart.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="../css/site-wide.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="../css/landing.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="../css/main.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="../css/photos.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="../css/chat.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="../css/crop.css" TYPE="text/css"/>
      <link rel="stylesheet" type="text/css" href="../imgSelectArea/css/imgareaselect-default.css" />
      <LINK REL="StyleSheet" HREF="../css/houses.css" TYPE="text/css"/>

      <link rel="icon" type="image/png" href="/img/starmaFavicon.png">
      
      <script type="text/javascript" src="/autoSuggest/jquery.autoSuggest.js"></script>
      <script type="text/javascript" src="imgSelectArea/scripts/jquery.imgareaselect.pack.js"></script>
      <script type="text/javascript" src="/chat/chat_all.js"></script>
      <script type="text/javascript" src="/js/paging_functions.js"></script>
      <script type="text/javascript" src="/js/crop.js"></script>
      <script type="text/javascript" src="/js/jQueryRotate.js"></script>
      <script type="text/javascript" src="js/ajax_register_guest.js"></script>
      <script type="text/javascript" src="js/ajax_login_guest.js"></script>
      <script type="text/javascript" src="js/guest_popup.js"></script>
      <script type="text/javascript" src="js/ajax_forgot_password.js"></script> 
      <script type="text/javascript" src="/js/scroll.js"></script> 
    ';
  
?>


   
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32857790-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- start Mixpanel --><script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
mixpanel.init("c7c1258b631d91c7d29f7b8f9f12bfcb");</script><!-- end Mixpanel -->


</head>