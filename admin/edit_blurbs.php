<?php 

 require_once ("../header.php");
 //require_once ("db_connect.php");

  if (!permissions_check ($req = 10)) {
    header( 'Location: http://www.' . $domain . '/underconstruction.php');
  }  
  else {
    echo '<body>';
    if (isset($_POST["Update"])) {
      if ($_POST["blurb_type"] == 'poi_sign') {
        edit_poi_sign_blurb ($_POST["poi_id"], $_POST["sign_id"], $_POST["blurb"]);
      }
      elseif ($_POST["blurb_type"] == 'poi_dynamic') {
        edit_poi_dynamic_blurb ($_POST["poi_id_A"], $_POST["poi_id_B"], $_POST["dynamic_id"], $_POST["section_id"], $_POST["blurb"]);
      }
    }
    echo '<div class="page_title">Edit Blurbs</div>';
    echo '<br>';
    echo '<a href="?blurb_type=poi_sign"/>Edit Poi:Sign Blurbs</a><br>';
    echo '<a href="?blurb_type=poi_dynamic"/>Edit Poi:Dynamic Blurbs</a>';
    echo '<br><hr><br>';
    if (isset($_GET["blurb_type"])) {
      $blurb_type = $_GET["blurb_type"];
      blurb_form($blurb_type);      
    }
    elseif (isset($_POST["blurb_type"])) {
      $blurb_type = $_POST["blurb_type"];
      if ($_POST["blurb_type"] == 'poi_sign') {
        blurb_form($blurb_type, $the_value1=$_POST["poi_id"], $the_value2=$_POST["sign_id"]);      
      }
      elseif ($_POST["blurb_type"] == 'poi_dynamic') {
        blurb_form($blurb_type, $the_value1=$_POST["poi_id_A"], $the_value2=$_POST["poi_id_B"], $the_value3=$_POST["dynamic_id"], $the_value4=$_POST["section_id"]);
      }
    }
    else {
      echo 'Please Click on a section above';
    }

    echo '<br><br>';
    echo '<a href="../">Go Back To Chart Management</a>';
    echo '</body>';
  }

   require_once ("../footer.php");
  
?>