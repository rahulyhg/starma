<?php 

 require_once ("header.php");
   


if (isLoggedIn())
{
  // IF COMING FROM THE DECRIPTORS/PHOTO MANDATORY PAGE
  if (!my_descriptors_loaded() or !get_my_main_photo()) {
    if (isset($_POST["desc_photo_submit"]) and $user = my_profile_info()) {
      
      $errors = array();
      //VALIDATE INPUT GOES HERE
      //   
      //
      if (sizeof($errors) == 0) {
        // UPDATE AND MOVE ALONG
        do_redirect( $url = get_domain() . '/process_login.php');
      }
      else {
        // ERRORS ARE PRESENT
        $_SESSION["errors"] = $errors;
        do_redirect( $url = get_domain() . '/desc_photo_first_ime.php?des_name_1=' . $_GET['des_name_1'] . '&des_name_2=' . $_GET['des_name_2'] . '&des_name_3=' . $_GET['des_name_3']);
      }
    }
    else {
      do_redirect( $url = get_domain() . '/desc_photo_first_time.php');
    }
  }    
       
?>

<body>

<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>


<div id="birth_info_first_time">
  
  <?php show_landing_logo();?>
  <div class="title"><?php flare_title ("Congratulations!")?></div>
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