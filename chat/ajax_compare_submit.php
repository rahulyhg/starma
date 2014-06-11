<?php
session_start();
require_once ('../include/db_connect.inc.php'); 
require_once ("../include/functions.inc.php"); 
require_once ("../PHPMailer_5.2.1/class.phpmailer.php");
date_default_timezone_set('America/Chicago');
 
$logged_in = login_check_point($type="full");

$results_type = $_POST["results_type"];
$chart_id1 = $_POST["chart_id1"];
$chart_id2 = $_POST["chart_id2"];
$text_type = 1;

//echo json_encode($results_type);


if($results_type == "Major") {

	show_major_connections ($compare_data, $text_type, $goTo = ".", $stage="2", $chart_id1, $chart_id2); /* {


      $connection_type = "rising";
      if ( isset($_POST["connection_type"]) and in_array($_POST["connection_type"], get_cornerstones()) ) {
      
        $connection_type = $_POST["connection_type"];
      }

      //Log the Action
      log_this_action (compare_action_major(), viewed_basic_action(), $chart_id2, $stage, get_poi_id (strtoupper($connection_type)));
  


    echo '<div id="compare">';
      echo'<div id="section">';
 

      echo '<form name="major_connection_browser" action="." method="post">';
      echo '<input type="hidden" name="connection_type"/>';
      echo '<div id="major_connections">'; 
      
             

      //Left Side;
      echo '<div class="chart_tabs left_side stage' . $stage . '"/>';
      echo '<ul>';
      //echo '*' . $connection_type . '*';
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));
          echo '<li class="' . get_selector_name($button_sign_id);
          if ($connection_type == $connection or $stage==2) { 
            echo ' selected';
          }
          echo '"><a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($connection) . '</span></a></li>';  
        
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side
     
      //Right Side
      
      echo '<div class="chart_tabs right_side stage' . $stage . '"/>';
      echo '<ul>';
      
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
          echo '<li class="' . get_selector_name($button_sign_id);
          if ($connection_type == $connection or $stage==2) { 
            echo ' selected';
          }
          echo '"><a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($connection) . '</span></a></li>';  
        
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side
 
      
     
      //if ($stage !="3") {
        //left arrows
        echo '<div class="chart_tabs left_side arrows stage' . $stage . '"/>';
        echo '<ul>';
      
        foreach (get_cornerstones() as $connection) {
          if ($connection_type == $connection or $stage==2) { 
            echo '<li class="left_side_arrow"><a href=""></a></li>';
          }
          else {
            echo '<li class=""><a href=""></a></li>';
          }
      
        }
        echo '</ul>';
        echo '</div>';
        //End left arrows
   
        //right arrows
        echo '<div class="chart_tabs right_side arrows stage' . $stage . '"/>';
        echo '<ul>';
      
        foreach (get_cornerstones() as $connection) {
          if ($connection_type == $connection or $stage==2) { 
            echo '<li class="right_side_arrow"><a href="#"></a></li>';
          }
          else {
            echo '<li class=""><a href=""></a></li>';
          }
      
        }
        echo '</ul>';
        echo '</div>';
        //End right arrows
      //}
      

      if ($stage=="3") {
        if ($connection_type != "none") {
          echo '<div id="blurb">';
            $connection_poi_id = get_poi_id (strtoupper($connection_type));
            $connection_data = $compare_data[$connection_type . '2' . $connection_type];
            $relationship_id = $connection_data["relationship_id"];
            //echo "<span>" . get_poi_dynamic_blurb ($connection_poi_id, $connection_poi_id, $relationship_id) . "</span>";
            show_dynamic_info($connection_poi_id, $connection_poi_id, $relationship_id, $chart_id1, $chart_id2);
            show_poi_dynamic_blurb ($connection_poi_id, $connection_poi_id, $relationship_id, $text_type, $chart_id1, $chart_id2);
          echo '</div>';
        }
        else {
          echo '<div id="blurb">';
            echo "<span>Please select a dynamic</span>";
          echo '</div>';
        }
      } 
      else {
        //Middle Relationships
        echo '<div class="chart_tabs middle"/>';
        echo '<ul>';
      
        foreach (get_cornerstones() as $connection) {
            //$button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
            $relationship_id = $compare_data[$connection . '2' . $connection]["relationship_id"];
            $relationship_name = $compare_data[$connection . '2' . $connection]["relationship_title"];
            echo '<li class="' . get_rela_selector_name($relationship_id);
            echo '"><a href="#" ';
            echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($relationship_name) . '</span></a></li>';  
        
        }
        echo '</ul>';
        echo '</div>';
        //End Middle Relationships

      }
      echo '</div>';
      echo '</form>';
  echo '</div>';   //closing #section
  echo '</div>';  //closing #compare
}
*/
}

elseif ($results_type == "Minor") {


	show_minor_connections ($compare_data, $text_type, $goTo = ".", $stage="2", $chart_id1, $chart_id2); /*{


      
      $connection_type = "rising";
      if ( isset($_POST["connection_type"]) and in_array($_POST["connection_type"], get_cornerstones()) ) {
        $connection_type = $_POST["connection_type"];
      }
      
      //Log the Action
      log_this_action (compare_action_minor(), viewed_basic_action(), $chart_id2, $stage, get_poi_id (strtoupper($connection_type)));

      echo '<form name="minor_connection_browser" action="." method="post">';
      echo '<input type="hidden" name="connection_type"/>';
      echo '<div id="minor_connections">'; 
      
             

      //Left Side;
      echo '<div class="chart_tabs left_side stage' . $stage . '"/>';
      echo '<ul>';
      //echo '*' . $connection_type . '*';
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));
          echo '<li class="' . get_selector_name($button_sign_id);
          if ($connection_type == $connection) { 
            echo ' selected';
          }
          echo '"><a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="minor_connection_browser", $action=$goTo . "&stage=" . $stage, $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($connection) . '</span></a></li>';  
        
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side
     
      //Right Side
      
      echo '<div class="chart_tabs right_side stage' . $stage . '"/>';
      echo '<ul>';
      
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
          echo '<li class="' . get_selector_name($button_sign_id);
          if ($connection_type != $connection) { 
            echo ' selected';
          }
          else {
            echo ' no_hover';
          }
          echo '"><a href="#"/><span>' . ucfirst($connection) . '</span></a></li>';  
        
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side

      
      //left arrows
        echo '<div class="chart_tabs left_side ' . $connection_type . ' arrows stage' . $stage . '"/>';
        
        echo '</div>';
      //End left arrows
   
      //right arrows
        echo '<div class="chart_tabs right_side ' . $connection_type . ' arrows stage' . $stage . '"/>';
        if ($stage == 2) {
          echo '<ul>';
      
          foreach (get_cornerstones() as $connection) {
            if ($connection_type != $connection) { 
              echo '<li class="right_side_arrow"><a href="#"></a></li>';
            }
            else {
              echo '<li class=""><a href=""></a></li>';
            }
      
          }
          echo '</ul>';
        }
        echo '</div>';
      //End right arrows
      
      //Middle Relationships
      if ($stage=="3") {
        echo '<div id="multi_blurb">';
        $counter = 0;
        foreach (get_cornerstones() as $connection) {
            if ($connection != $connection_type) {
            
              $relationship_id = $compare_data[$connection_type . '2' . $connection]["relationship_id"];
              $relationship_name = $compare_data[$connection_type . '2' . $connection]["relationship_title"];
              $connection_poi_id_A = get_poi_id (strtoupper($connection_type));
              $connection_poi_id_B = get_poi_id (strtoupper($connection));
              echo "<div id='blurb" . $counter . "'>";
                if ($temp_id = get_user_id_from_chart_id($chart_id2)) {
                  echo "<span>" . gender_converter_wrapper (get_gender($temp_id), get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id, 1, $chart_id1, $chart_id2)) . "</span>";
                }
                else {
                  echo "<span>" . get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id, $text_type, $chart_id1, $chart_id2) . "</span>";
                }
              
              echo "</div>";
              $counter++;
            }
        
        }
        echo '</div>';
      } 
      else {
        //Middle Relationships
        echo '<div class="chart_tabs middle"/>';
        echo '<ul>';
      
        foreach (get_cornerstones() as $connection) {
            
            //$button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
            $relationship_id = $compare_data[$connection_type . '2' . $connection]["relationship_id"];
            $relationship_name = $compare_data[$connection_type . '2' . $connection]["relationship_title"];
            echo '<li class="' . get_rela_selector_name($relationship_id);
            if ($connection_type == $connection) { 
              echo ' hidden';
            }
            
            echo '"><a href="#" ';
            echo 'onclick="' . javascript_submit ($form_name="minor_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection_type . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($relationship_name) . '</span></a></li>';  
            
        
        }
        echo '</ul>';
        echo '</div>';
      }
      
      //End Middle Relationships
     
      echo '</div>';
      echo '</form>';
  
	}
	*/
}

elseif ($results_type == "Bonus") {


	show_bonus_connections ($compare_data, $text_type, $goTo = ".", $stage="2", $chart_id1, $chart_id2); /*{

      $bonus_connections = array('ruling');
      $connection_type = "ruling";
      if ( isset($_POST["connection_type"]) and in_array($_POST["connection_type"], $bonus_connections) ) {
        $connection_type = $_POST["connection_type"];
         
      }
      $rp_id1 = get_ruling_planet($chart_id1);
      $rp_id2 = get_ruling_planet($chart_id2);

      //Log the Action
      log_this_action (compare_action_bonus(), viewed_basic_action(), $chart_id2, $stage, -2);

      echo '<form name="major_connection_browser" action="." method="post">';
      echo '<input type="hidden" name="connection_type"/>';
      echo '<div id="major_connections">'; 
      
             

      //Left Side;
      echo '<div class="chart_tabs left_side stage' . $stage . '"/>';
      echo '<ul>';
      //echo '*' . $connection_type . '*';
      foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
            if ($connection == 'ruling') {
              $button_sign_id = get_sign_from_poi ($chart_id1, $rp_id1);
              //echo $rp_id1;
              if (!$poi_name = get_poi_name ($rp_id1)) {
                 $poi_name = "Unknown";
              }
            } 
            else {
              $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));
              $poi_name = $connection;
            }
            echo '<li class="' . get_selector_name($button_sign_id);
            if ($connection_type == $connection or $stage==2) { 
              echo ' selected';
            }
            echo '"><a href="#" ';
            echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($poi_name) . '</span></a></li>';  
          }
        
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side
     
      //Right Side
    
      echo '<div class="chart_tabs right_side stage' . $stage . '"/>';
      echo '<ul>';
      
      foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
            if ($connection == 'ruling') {
              $button_sign_id = get_sign_from_poi ($chart_id2, $rp_id2); 
              
              if (!$poi_name = get_poi_name ($rp_id2)) {
                 $poi_name = "Unknown";
              }
            }
            else {
              $button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
              $poi_name = $connection;
            }
            echo '<li class="' . get_selector_name($button_sign_id);
            if ($connection_type == $connection or $stage==2) { 
             echo ' selected';
            }
            echo '"><a href="#" ';
            echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($poi_name) . '</span></a></li>';  
          }
        
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side

      //left arrows
        echo '<div class="chart_tabs left_side arrows stage' . $stage . '"/>';
        echo '<ul>';
      
        foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
            if ($connection_type == $connection or $stage==2) { 
              echo '<li class="left_side_arrow"><a href=""></a></li>';
            }
            else {
              echo '<li class=""><a href=""></a></li>';
            }
           }
      
        }
        echo '</ul>';
        echo '</div>';
        //End left arrows
   
        //right arrows
        echo '<div class="chart_tabs right_side arrows stage' . $stage . '"/>';
        echo '<ul>';
      
        foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
            if ($connection_type == $connection or $stage==2) { 
              echo '<li class="right_side_arrow"><a href="#"></a></li>';
            }
            else {
              echo '<li class=""><a href=""></a></li>';
            }
          }
      
        }
        echo '</ul>';
        echo '</div>';
      //End right arrows

      if ($stage=="3") {
        if ($connection_type != "none") {
          echo '<div id="blurb">';
            $relationship_id = $compare_data[$connection_type . '2' . $connection_type]["relationship_id"];
            show_dynamic_info(-1, -1, $relationship_id, $chart_id1, $chart_id2);
            
            show_poi_dynamic_blurb (-1, -1, $relationship_id, $text_type, $chart_id1, $chart_id2);
          echo '</div>';
        }
        else {
          echo '<div id="blurb">';
            echo "<span>Please select a dynamic</span>";
          echo '</div>';
        }
      } 
      else {
        //Middle Relationships
        echo '<div class="chart_tabs middle"/>';
        echo '<ul>';
      
        foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
              //$button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
              $relationship_id = $compare_data[$connection . '2' . $connection]["relationship_id"];
              $relationship_name = $compare_data[$connection . '2' . $connection]["relationship_title"];
              echo '<li class="' . get_rela_selector_name($relationship_id);
              echo '"><a href="#" ';
              echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($relationship_name) . '</span></a></li>';  
          }
        
        }
        echo '</ul>';
        echo '</div>';
        //End Middle Relationships
      }
      echo '</div>';
      echo '</form>';
  
}
*/
}

echo json_encode($results_type);



?>