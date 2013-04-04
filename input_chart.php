<?php 

 require_once ("header.php");
 //require_once ("db_connect.php");

  if (!permissions_check ($req = 10)) {
    header( 'Location: https://www.' . $domain . '/underconstruction.php');
  }  
  else {

    display_my_chart_list();
    date_default_timezone_set('America/Chicago'); 

    echo '<table border="1" cellpadding=10><th colspan=2>Test Form';
    if (isLoggedIn()) {
      echo '<span style="color:red"> - Welcome <b>' . $_SESSION['username'] . '!</b></span>';
    }
    echo '</th><tr valign="top">
    <td>';
  
    if (isset($_POST["chart_id"])) {
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

  }
  
?>