<?php 

 require_once ("header.php");
   



if (isLoggedIn())
{
       
?>

<body>

<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>


<div id="gender_location_first_time">
  
  <?php show_landing_logo();?>
  <div class="title"><?php flare_title ("Congratulations!")?></div>
  <div class="description">You've successfully created your account!<br>In a few short moments, you will be able to browse you Starma Chart and connect with your friends!<br>To assist in this, please tell us a little more about you.</div>
  <div class="bg" id="enter_info">

    <?php if (isset($errors)) {show_gender_location_form($errors = $errors, $title=$title, $county_id=$country_id);}else{show_gender_location_form($errors=array(), $title="", $country_id = 236);}?>
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