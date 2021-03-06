<?php 

 require_once ("../header.php");
 //require_once ("db_connect.php");

 if (!permissions_check ($req = 10)) {
  header( 'Location: http://www.' . $domain . '/underconstruction.php');
 }  
 else {
  
  

  echo '<body>';
  //INIT VARS
  if (isset($_GET["user_id"])) {
    $user_id = (string) $_GET["user_id"];
      
  }
  else if (isset($_POST["user_id"])) {
    $user_id = (string) $_POST["user_id"]; 
    //echo 'USER ID POSTED' . $user_id;
  }
  else if (isset($_SESSION["proxy_user_id"])) {
    $user_id = $_SESSION["proxy_user_id"];
  }
  else { 
    $user_id = '-1';
     
  }
  $unc_photos = uncropped_celeb_photos();
  if ($photo_to_crop = mysql_fetch_array($unc_photos)) {
      echo '<div style="position:relative; top:3px">';
        flare_title ("Crop Your Photo");
      echo '</div>';
      
      echo '<div id="photo_cropper">';
        echo '<form action="crop_photo_admin.php" method="post" name="crop_photo_form">';
          show_photo_cropper($photo_to_crop);
          echo '<input type="hidden" name="imgName" value="' . $photo_to_crop["picture"] . '"/>';
          echo '<input type="hidden" name="imgID" value="' . $photo_to_crop["user_pic_id"] . '"/>';
          echo '<input type="hidden" name="user_id" value="' . $photo_to_crop["user_id"] . '"/>';
          
        echo '</div>';
      echo '</div>';
     
  }
  else {
 
    // IF COMING FROM A SUbMIT
    if (isset($_POST["submit"])) {
       if ($user_id == '-1') {
         $errors = modifyUser_no_register($_POST["nickname"], $_POST["first_name"], $_POST["last_name"], $_POST["gender"], $_POST["about_me"], PERMISSIONS_CELEB(), $user_id);
       }
       else {
         $info = profile_info($user_id);
         $errors = modifyUser_no_register($info["nickname"], $_POST["first_name"], $_POST["last_name"], $_POST["gender"], $_POST["about_me"], PERMISSIONS_CELEB(), $user_id);
       }
       if ( sizeof($errors) <= 1 ) {
                  
         $user_id = $errors[0];
         //echo $new_user_id;
       }
       else {
         print_r($errors);
       }
       
       //else update the user
    }
   

    if ($user_id != -1) {
      $_SESSION["proxy_user_id"] = $user_id;
      if ($celeb_chart = get_celeb_chart_by_name('main',$user_id)) {
        $celeb_chart_id = $celeb_chart["chart_id"];
        echo $celeb_chart_id;
        if (!chart_already_there("Alternate",$user_id)) {
          $chart_to_cast_from = get_chart($celeb_chart_id);
          if (!single_click_cast ("Alternate", $chart_to_cast_from["birthday"], substr($chart_to_cast_from["latitude"], 0, 6), substr($chart_to_cast_from["longitude"], 0, 7), substr($chart_to_cast_from["latitude"], -1), substr($chart_to_cast_from["longitude"], -1), $chart_to_cast_from["timezone"], $chart_to_cast_from["DST"], $chart_to_cast_from["location"], $chart_to_cast_from["interval_time"], $chart_to_cast_from["time_unknown"], "W")) {
             echo 'Error Obtaining Western Chart';
          }
          echo 'WESTERN WASNT THERE, SO I CAST IT';
        }
        else {
          echo 'WESTERN IS THERE';
        }
      }
      else { 
         echo 'Failed to get celeb chart';
      }
    }
    else {
      if (isset($_SESSION["proxy_user_id"])) {
        unset ($_SESSION["proxy_user_id"]);  
      }
    }

    echo 'Proxy User ID: ' . $_SESSION["proxy_user_id"] . '<Br>';
    echo 'User ID: ' . $user_id . '<Br>';
    
    // MAIN PAGE BODY    
    echo '<div id="admin_frame">';
    echo '<div id="admin_page_title">Edit Celebrity Profiles</div>';
    echo '<br>';
    echo '<table class="admin_table">';
    echo '<tr>';
    echo '<td id="admin_table_left_column">';
      echo '<div class="admin_page_header">CELEBRITIES</div>'; 
      echo '<div class="admin_user_list">'; 
        $celeb_list = get_celeb_list();
        while ($row = mysql_fetch_array($celeb_list)) {
          echo '<a href="?user_id=' . $row["user_id"] . '"/>' . $row["nickname"] . '</a><br>';
        }
        echo '<br>';
        echo '<a href="?user_id=-1"/>Add New Celebrity</a><br>';
      echo '</div>';
    echo '</td>';
    echo '<td id="admin_table_middle_column">';
      echo '<div class="admin_page_header">PROFILE</div>';
      edit_profile_form($user_id); 
      echo '<br>';
      if (get_chart_by_name ("Main", $user_id)) {
        echo '<div id="admin_photo_upload">';
        upload_photo_form_admin($user_id);     
        if (isset($_GET["error"])) {
          echo '<div id="photo_error">';
          if ($_GET["error"] == 1) {
            echo "Error Deleting Photo.  Please contact Starma.com Administration.";
          }
          elseif ($_GET["error"] == 2) {
            echo "You have reached the " . max_photos() . " maximum allowed profile photos.";
          }
          echo '</div>';
        }
        echo '</div>';
      }
    echo '</td>';
    echo '<td id="admin_table_right_column">';
      echo '<div class="admin_page_header">CHART INFO</div>';
      if ($user_id != '-1') {
        if (isset($_SESSION["errors"])) {
          $errors = $_SESSION["errors"];
          unset ($_SESSION["errors"]);
          show_birth_info_form($errors=$errors, $sao=1, $title="", $action="../cast_chart.php");
        }
        else {
          show_birth_info_form($errors=array(), $sao=0, $title="", $action="../cast_chart.php");
        }   
        unset($_SESSION["chart_input_vars"]);
      }
      else {
        echo 'No Selected User or selected User has no chart';
      }
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    if ($chart = get_chart_by_name("Main",$user_id)) {
      echo '<div id="chart_area">';
        
        show_chart($chart["chart_id"], 'edit_profile.php');
      echo '</div>';
    }

    echo '<br><br>';
    echo '<a href="../">Go Back To Chart Management</a>';
    echo '</div>';
    echo '</body>';
  }
 }
   require_once ("../footer.php");
  
?>