<?php 

 require_once ("header.php");
   



if (isLoggedIn())
{

if (isset($_GET['gender'])) {
  $gender = $_GET['gender'];
}
else {
  if (!$gender = get_my_gender()) {
    $gender = "M";
  }
}

if (isset($_GET['country_id'])) {
  $country_id = $_GET['country_id'];
}

if (isset($_GET['title'])) {
  $title = $_GET['title'];
}

if (isset($_SESSION['errors'])) {
  $errors = $_SESSION['errors'];
   unset ($_SESSION["errors"]);
}
       
?>

<body>

<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>


<div id="gender_location_first_time">
  
  <?php show_landing_logo();?>
  <div class="title"><?php flare_title ("Create an Account")?></div>
  <div class="description">You're almost there ...</div>
  <div class="bg" id="enter_info">

    <?php if (isset($errors)) {show_gender_location_form($errors = $errors, $title=$title, $county_id=$country_id, $gender=$gender);}else{show_gender_location_form($errors=array(), $title="", $country_id = 236, $gender=$gender);}?>
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