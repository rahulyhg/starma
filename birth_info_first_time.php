<?php 

 require_once ("header.php");
   


if (isLoggedIn())
{
  // IF COMING FROM THE DECRIPTORS/PHOTO MANDATORY PAGE
  if (!my_descriptors_loaded() or !get_my_main_photo()) {
    if (isset($_POST["desc_photo_submit"]) and $user = my_profile_info()) {
      
      $error = array();
      //VALIDATE INPUT GOES HERE
      if (!get_my_main_photo()){
        $error[] = PHOTO_ERROR(); 
      }

      $des_name_1 = trim($_POST["des_name_1"]);
      $des_name_2 = trim($_POST["des_name_2"]);
      $des_name_3 = trim($_POST["des_name_3"]);

      if (!isWord($des_name_1) || !isWord($des_name_2) || !isWord($des_name_3)) {
        $error[] = NOT_WORDS_ERROR();
      }

      if (contains_illegal_words($des_name_1) || contains_illegal_words($des_name_2) ||  contains_illegal_words($des_name_3)) {
        $error[] = ILLEGAL_WORDS_ERROR();
      }

      
      
      if (sizeof($error) == 0) {
        // UPDATE AND MOVE ALONG
        update_descriptors (array($des_name_1, $des_name_2, $des_name_3));
        do_redirect( $url = get_domain() . '/process_login.php');
      }
      else {
        // ERRORS ARE PRESENT
        $_SESSION["errors"] = $error;
        
        do_redirect( $url = get_domain() . '/desc_photo_first_time.php?des_name_1=' . $des_name_1 . '&des_name_2=' . $des_name_2 . '&des_name_3=' . $des_name_3);
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
  <div class="title"><?php flare_title ("Time and Place of Birth")?></div>
  <!---<div class="description">You've successfully created your account!<br>In order to read your Starma&#174; chart with more accuracy,<br>we will need your TIME & PLACE of birth.</div>--->
  <div class="description">3/3</div>
  <div class="bg" id="enter_info">
    <!---<img src="img/account_info/Starma-Astrology-TimeandPlaceBoxes.png"/>--->
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