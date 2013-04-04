<?php
require_once "header.php"; 
?>
<!-- Include he following conditional to get click-throughs to work with IE -->
    
    <!--[if IE]>
      <style type="text/css">
 
        .circle_hilite {
          filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/img/arrows/RedCircle.png', sizingMethod='scale');
          background:none !important;
        }
 
        </style>
    <![endif]-->


 <div id="welcome">
    <span style="font-size:2em">Welcome Friends and Family!</span>
    <br><br>
    We are very proud to present Starma.com in its prototype state, and to kick off the long awaited and very exciting trial launch! What we're hoping to accomplish through this trial is the eradication of bugs, glitches, typos, or things that just don't seem right, so we'd greatly appreciate it if you let us know when you come across something funky.  We also intend to monitor your usage (ie, what pages you spend the most time on, what features are used most, etc.), so the more you play on our site, the better!  Because we are still in the early stages of development, we are not yet looking for detailed feedback about design, interface and features, but if you have strong feelings about something fundamental to the site, please let us know.  All feedback can be sent to <a href="mailto:contact@starma.com">contact@starma.com</a>.
    <br><br>
    Please note that throughout the trial, we will be adding a number of new functions and design features, so if the site is temporarily down, please have patience, as it will likely be up and running in a matter of minutes! 
    <br><br>
    Thank you very much for your participation, and we hope you have a wonderful time playing around on Starma.com! 
    <br><br>
    Sincerely,<br>
    The Starma Team
    <?php 
    if (my_welcome_flag() == 1) {
       show_circle_and_arrow_hilite();
      
    }
    ?>
 </div> 

<?php
 
 
 if (my_welcome_flag() == 1) {
       sleep(1);
       set_my_welcome_flag(0);
      
 }
?> 