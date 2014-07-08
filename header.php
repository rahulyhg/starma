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
require_once ('include/db_connect.inc.php'); // include the database connection
require_once ("PHPMailer_5.2.1/class.phpmailer.php");
require_once ("include/functions.inc.php"); // include all the functions
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
<title>Starma.com - </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">   <!-- Matt should we change to charset=utf-8 so json_encode will work?  -->


<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  <!-- Matt updated jquery -->
<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script> 

<?php 
  if (isAdmin()) {
    echo '<LINK REL="StyleSheet" HREF="../css/reset.css" TYPE="text/css"/>';
    echo '<LINK REL="StyleSheet" HREF="../css/landing.css" TYPE="text/css"/>';
    echo '<LINK REL="StyleSheet" HREF="../css/admin.css" TYPE="text/css"/>';
    echo '<LINK REL="StyleSheet" HREF="../css/site-wide.css" TYPE="text/css"/>';
    echo '<LINK REL="StyleSheet" HREF="../css/chart.css" TYPE="text/css"/>';
    echo '<LINK REL="StyleSheet" HREF="../css/main.css" TYPE="text/css"/>';
    echo '<LINK REL="StyleSheet" HREF="../css/photos.css" TYPE="text/css"/>';
    echo '<LINK REL="StyleSheet" HREF="../css/crop.css" TYPE="text/css"/>';
    //echo '<LINK REL="StyleSheet" HREF="../autoSuggest/autoSuggest.css" TYPE="text/css"/>';
    echo '<link rel="stylesheet" type="text/css" href="../imgSelectArea/css/imgareaselect-default.css" />';
    echo '
      
      <script type="text/javascript" src="../autoSuggest/jquery.autoSuggest.js"></script>
      <script type="text/javascript" src="../imgSelectArea/scripts/jquery.imgareaselect.pack.js"></script>
      <script type="text/javascript" src="../js/paging_functions.js"></script>
      <script type="text/javascript" src="../js/crop.js"></script>
      
    ';
  }
  //Removed autoSuggest.css to restyle New Message area
  else {
    echo '
      <LINK REL="StyleSheet" HREF="css/reset.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="css/chart.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="css/site-wide.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="css/landing.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="css/main.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="css/photos.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="css/chat.css" TYPE="text/css"/>
      <LINK REL="StyleSheet" HREF="css/crop.css" TYPE="text/css"/>
      <link rel="stylesheet" type="text/css" href="imgSelectArea/css/imgareaselect-default.css" />
      
      <script type="text/javascript" src="/autoSuggest/jquery.autoSuggest.js"></script>
      <script type="text/javascript" src="imgSelectArea/scripts/jquery.imgareaselect.pack.js"></script>
      <script type="text/javascript" src="/chat/chat_all.js"></script>
      <script type="text/javascript" src="/js/paging_functions.js"></script>
      <script type="text/javascript" src="/js/crop.js"></script>
    ';
  }
?>


    
    

<script type="text/javascript">
    
        //get the user's timezone offset
    	
        
    	
        $(document).ready(function() {
          theDate = new Date();

          DST = 0;

          Date.prototype.stdTimezoneOffset = function() {
    		var jan = new Date(this.getFullYear(), 0, 1);
    		var jul = new Date(this.getFullYear(), 6, 1);
    		return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
	  }

	  Date.prototype.dst = function() {
		return this.getTimezoneOffset() < this.stdTimezoneOffset();
          }
          if (theDate.dst()) { DST = 60; }
          //http://127.0.0.1:8080/chat/process_all.php
          
          $.ajax({
		   type: "GET",
                   cache: false,
		   url: "https://www.starma.com/chat/process_all.php",
		   data: {  
		   	  'function': 'setTimeZone',
                          'timezoneOffset': theDate.getTimezoneOffset() + DST									
		         },
                   dataType: "json"                                                                    
		});    
        });

        //Hack for IE10
       if (/*@cc_on!@*/false) {
         var headHTML = document.getElementsByTagName('head')[0].innerHTML;
         headHTML    += '<link type="text/css" rel="stylesheet" href="css/ie10.css">';
         document.getElementsByTagName('head')[0].innerHTML = headHTML;
        }

        // Popup window function
	function basicPopup(url, title, specs) {
          popupWindow = window.open(url,title,specs);
	}
</script>


<?php if (!strpos($_SERVER['PHP_SELF'], get_landing())) { ?>
<script type="text/javascript">
    
      
    	// kick off chat
        var chat_all =  new Chat_All();
    	
        $(document).ready(function() {
            chat_all.refresh();            
            chat_all.update();
            setTimeout('chat_all.update()', chat_all.refreshTime());
        });
</script>
<?php } ?>
    


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


</head>