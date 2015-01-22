<?php 

 require_once ("header.php");
 //require_once ("db_connect.php");

  if (!permissions_check ($req = 10)) {
    do_redirect (get_domain() . '/' . get_landing());
    //header( 'Location: https://www.' . get_domain() . '/' . get_landing());
  }  
  else {
    echo '<div class="whole_site">';
    display_my_chart_list();
     
    echo '<a href="admin/edit_blurbs.php">Edit Blurbs</a><br />';
    echo '<a href="admin/send_invite.php">Send an Invite</a><br />';
    echo '<a href="admin/send_test_activation_email.php">Send a Test Activation Email</a><br />';
    echo '<a href="admin/edit_profile.php">Add / Edit Celebrities</a><br />';
    echo '<a href="admin/house_lords.php">House Lords</a><br />';
    echo '<a href="admin/logs.php">Log Report</a><br />';
    echo '<a href="admin/online.php">Online Stats</a><br />';

    echo '<table border="1" cellpadding=10><th colspan=2>Test Form';
    if (isLoggedIn()) {
      echo '<span style="color:red"> - Welcome <b>' . $_SESSION['nickname'] . '!</b></span>';
    }
    echo '</th><tr valign="top">
    <td>';
  
    if (isset($_GET["chart_id"])) {
      $chart_id = $_GET["chart_id"];  
    }
    elseif (isset($_POST["chart_id"])) {
      $chart_id = $_POST["chart_id"];  
    }
    else {
      $chart_id = -1; 
    }
    
    $sao = chart_entry_form($chart_id=$chart_id);
    if (isset($_POST["submit"])) {
      //echo 'stuff goes here';
      $errors = array();
      if ($sao == 1 and (trim($_POST["c1d"]) == "" and trim($_POST["c2d"]) == "")) {
        $error = 'Address was empty or not found.  
                  Please check the spelling of the address for errors<br>
                  OR<br>
                  enter the data above mark with an *';
        $errors[] = $error;  
      }
      if (trim($_POST["d1m"]) == "") {
        $error = 'Please enter a valid date';
        $errors[] = $error;
      }  
      
      if (sizeof($errors) == 0) {
        $return_vars = show_chart($chart_id=-1);
        save_form($return_vars);
      }
      else {
        echo '<br>';
        display_error_list ($errors);
      } 
      
    }
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    if ($chart_id != -1) {
      show_chart($chart_id = $chart_id);
    }
    echo '</div>';
    
  }
  
?>