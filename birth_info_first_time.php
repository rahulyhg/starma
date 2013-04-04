<?php 

 require_once ("header.php");
   



if (isLoggedIn())
{
    
       
?>

<body>

<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>


<div id="birth_info_first_time">
  
  <?php show_landing_logo();?>
  <div class="title"><?php flare_title ("Congradulations!")?></div>
  <div class="description">You've successfully created your account!<br>In order to read your Starma&#174; chart with more accuracy,<br>we will need your TIME & PLACE of birth.</div>
  <div class="bg" id="enter_info">
    <img src="img/account_info/Starma-Astrology-TimeandPlaceBoxes.png"/>
    <?php if (isset($errors)) {show_birth_info_form($errors = $errors, $sao=1, $title=$title);}else{show_birth_info_form();}?>
  </div>
  
  <?php show_bugaboos();?>
  
</div>


<?php 
  require_once ("landing_footer.php"); 
?>
</body>
<?php 
}
else {
  do_redirect( $url = get_domain() . '/' . get_landing());
} 
?>