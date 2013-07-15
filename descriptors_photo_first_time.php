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
  $init_des_names[$counter] = $desc;
  $counter++;
}

if (isset($_GET['des_name_1'])) {
    $des_names[1]= $_GET['des_name_1'];
}
else {
    $des_names[1] = $init_des_name[0];
}

if (isset($_GET['des_name_2'])) {
    $des_names[2] = $_GET['des_name_2'];
}
else {
    $des_names[2] = $init_des_name[1];
}

if (isset($_GET['des_name_3'])) {
    $des_names[3] = $_GET['des_name_3'];
}
else {
    $des_names[3] = $init_des_name[2];
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


<div id="descriptor_photo_first_time">
  
  <?php show_landing_logo();?>
  <div class="title"><?php flare_title ("Create an Account")?></div>
  <div class="description">You're almost there ...</div>
  <div class="bg" id="enter_info">

    <?php if (isset($errors)) {show_desc_photo_form($errors, $des_names);}else{show_desc_photo_form(array(), $des_names);}?>
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