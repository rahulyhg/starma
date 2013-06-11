<?php 

 require_once ("header.php");
   


if (isLoggedIn())
{
  if (get_my_location() == "") {
    if (isset($_POST["location_gender_submit"]) and $user = my_profile_info()) {
      $country_id = $_POST["js_country_id"];
      $errors = array();
      if ($country_id == 236) {
        if (trim($_POST["zip"]) == "") {
          $errors[] = "Geocode Error";
        }
        else {
          $location_string = trim($_POST["zip"]) . ' US';
          $type="postalCodeSearch?placename";
        }
      }
      else {
        if (trim($_POST["title"]) == "") {
          $errors[] = "Geocode Error";
        }
        else {
          $country = get_country($country_id = $country_id);
          $location_string = exceptionizer($location_string = trim($_POST["title"]) . ', ' . $country["country_code"]);  
          $type="wikipediaSearch?q";
        }
      }
      if (!$result = geocode($location_string, $type)) {
        $errors[] = "Geocode Error";
      }
      if (!valid_gender($gender = trim($_POST["gender"]))) {
        $errors[] = "Gender Error";
      }
      if (sizeof($errors) == 0) {
        $location = $result["title"];
        update_my_profile_info($user["first_name"], $user["last_name"], $gender, $location);
        do_redirect( $url = get_domain() . '/process_login.php');
      }
      else {
        $_SESSION["errors"] = $errors;
        do_redirect( $url = get_domain() . '/gender_location_first_time.php?gender=' . $gender . '&title=' . trim($_POST["title"]) . '&country_id=' . $country_id);
      }
    }
    else {
      do_redirect( $url = get_domain() . '/gender_location_first_time.php');
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