<?php 

 require_once ("header.php");


if (isLoggedIn())
{

// IF COMING FROM THE GENDER LOCATION MANDATORY PAGE
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
          $location_string = exceptionizer($location_string = trim($_POST["title"]) . ', ' . $country["country_title"]);  
          //echo '*' . $location_string . '*'; die();
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
        $location = $result["location"];
        $state_id = get_state_id_from_code ($result["state_code"]);
        update_my_profile_info($user["first_name"], $user["last_name"], $gender, $location);
        update_my_extended_location($state_id, $country_id);
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


$init_des_names = array("","","");
$des_names = array("","","");

$descs = get_my_descriptors();
$counter = 0;
while ($desc = mysql_fetch_array($descs)) {
  $init_des_names[$counter] = $desc["descriptor"];
  $counter++;
}



$des_names[0]= grab_var('des_name_1', $init_des_names[0]);
$des_names[1]= grab_var('des_name_2', $init_des_names[1]);
$des_names[2]= grab_var('des_name_3', $init_des_names[2]);



//print_r($des_names);


if (isset($_SESSION['errors'])) {
  $errors = $_SESSION['errors'];
   unset ($_SESSION["errors"]);
}
       
?>

<body>


<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>




   <?php
   $unc_photos = uncropped_photos(get_my_user_id());
   if ($photo_to_crop = mysql_fetch_array($unc_photos)) {
       echo '<div id="desc_photo_first_time" class="crop">';
  
       show_landing_logo();


       echo '<div class="title">';
         flare_title ("Crop Your Photo");
       echo '</div>';
       
       echo '<div id="photo_cropper">';
         echo '<form action="crop_photo.php" method="post" name="crop_photo_form">';
           show_photo_cropper($photo_to_crop);
           echo '<input type="hidden" name="imgName" value="' . $photo_to_crop["picture"] . '"/>';
           echo '<input type="hidden" name="imgID" value="' . $photo_to_crop["user_pic_id"] . '"/>';
           echo '<input type="hidden" name="firsttime" value="1"/>';
         echo '</div>';
       echo '</div>';
     
   }
   else {
     clear_session_first_time_vars();
   ?>
  <div id="desc_photo_first_time">
  
  <?php show_landing_logo();?>

  <div class="title"><?php flare_title ("About You")?></div>
  <div class="description">2/3</div>
  <div class="bg" id="enter_info">

    <?php if (isset($errors)) {show_desc_photo_form($errors, $des_names);}else{show_desc_photo_form(array(), $des_names);}?>
  </div>
  
  <?php } ?>

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