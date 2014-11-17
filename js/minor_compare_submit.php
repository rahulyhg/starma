<?php
	require('ajax_header.php');

	$data = array();
	$errors = array();
	if (isset($_POST['mc'])) {
		$mc = trim($_POST['mc']);
		if (!preg_match('%[0-3]{1}%', $mc)) {
			$errors['mc'] = 'Strange input';
		}
		else {
			$data['mc'] = $mc;
		}

		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
	echo json_encode($data);
	}

	/*
	$support_con = array();
    $support_con = get_cornerstones();
    $connection = get_cornerstones();
    $connection = $connection[0];
      //$x = 0;
      //foreach (get_cornerstones() as $connection) {

      //for ($x = 0; $x < 5; $x++) {

        //$connection_type = $support_con[$x];

          //echo '<li>'; 
        echo '<div class="poi_column_wrapper_minor">';
        $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));  //in user functions
        $button_sign_id2 = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
         
          
        //Left Side;
            echo '<div class="left no_hover ' . get_selector_name($button_sign_id) . '_tall';
            echo '"><span class="icon"><span class="minor_poi_title">YOUR</span><span class="poi_title_tall">' . strtoupper($connection) . '</span></span></div>';  //End Left Side
        
        //Right Side
            echo '<div class="right no_hover right_icon_adjust ' . get_selector_name($button_sign_id2) . '_tall';
            echo '"><span class="icon"><span class="minor_poi_title">' . $gender . '</span><span class="poi_title_tall">' . strtoupper($connection) . '</span></span></div>';  //End Right Side

                //Pillars Images

                //Bridge top
                echo '<div class="bridge_top"><div class="bridge_top_title">SUPPORT FOR YOUR ';
                  	echo strtoupper($connection);
                echo ' SIGN CONNECTION</div>';

                //End Bridge top

                //Arrow Test
                echo '<span class="add_arrow_top"><span></span></span>';

                echo '</div>';  //close Bridge Top

                //End Arrow Test

                //Blurb Boxes and Pillars
                //Your Y to their X
                $z = 1;
                for ($y = 0; $y < count(get_cornerstones()); $y++) {
                    //$con_x = $support_con[$x];
                    $con_x = $support_con[0];
                    $con_y = $support_con[$y];
                    if ($con_x != $con_y) {
                      	$button_sign_id3 = get_sign_from_poi ($chart_id1, get_poi_id (strtoupper($con_y)));
                      	$relationship_id2 = $compare_data[$con_y .'2' . $con_x]["relationship_id"];
                    	//echo 'c1: ' . $connection1 . '<br>c2: ' . $connection2;
                    	//echo $connection1 . 'to';
                    	//echo $connection2 . '<br>';
                      	echo '<div class="';
                        if($relationship_id2 < 5) {
                          	echo 'pillar">';
                        }
                        else {
                          	echo 'pillar_broken">';
                        }

                      //echo '">';
                        echo '<div class="pillar_icon_minor L ' . get_selector_name($button_sign_id3) . '_tall';
                        echo '"><span class="icon pointer main to_leg' . $z . '"><span class="minor_poi_title">YOUR</span><span class="poi_title_tall">' . strtoupper($con_y) . '</span></span></div>';                     
                      	echo '</div>'; //close pillar/pillar_broken
                        $z++; 
                    }
                    
                  } //close your Y to their X
                
                //Your X to their Y
                $zz = 4;    
                for ($y = 0; $y < count(get_cornerstones()); $y++) {

                  //$con_x = $support_con[$x];
                  	$con_x = $support_con[0];
                  	$con_y = $support_con[$y];
                  	if ($con_x != $con_y) {
                    	$button_sign_id4 = get_sign_from_poi ($chart_id2, get_poi_id (strtoupper($con_y)));
                    	$relationship_id2 = $compare_data[$con_x .'2' . $con_y]["relationship_id"];
                    	//echo 'c1: ' . $connection1 . '<br>c2: ' . $connection2;
                    	//echo $connection1 . 'to';
                    	//echo $connection2 . '<br>';
                     	echo '<div class="';
                        if($relationship_id2 < 5) {
                          	echo 'pillar">';
                        }
                        else {
                          	echo 'pillar_broken">';
                        }
                    
                        echo '<div class="pillar_icon_minor R ' . get_selector_name($button_sign_id4) . '_tall';
                        echo '"><span class="icon pointer main to_leg' . $zz . '"><span class="minor_poi_title">' . $gender . '</span>';

                        echo '<span class="poi_title_tall">' . strtoupper($con_y) . '</span></span></div>';
                    	//echo 'c1: ' . $connection1 . '<br>c2: ' . $connection2;
                    	//echo $connection1 . 'to';
                    	//echo $connection2 . '<br>';
                        echo '</div>'; //close pillar/pillar_broken
                        $zz++; 
                    }
                    
                  } //close your X to their Y


                echo '<div class="bridge_base"><img src="/img/Starma-Astrology-Pillars-Base.png" /></div>'; //Base

                  //Blurb Boxes for 1-3 (yours to theirs)
                $zzz = 1;    
                for ($y = 0; $y < count(get_cornerstones()); $y++) {
                  //$con_x = $support_con[$x];
                 	 $con_x = $support_con[0];
                 	 $con_y = $support_con[$y];
                    if ($con_x != $con_y) {
                        $relationship_id2 = $compare_data[$con_y .'2' . $con_x]["relationship_id"];
                        $connection_poi_id_A = get_poi_id (strtoupper($con_y));
                        $connection_poi_id_B = get_poi_id (strtoupper($con_x));
                        //echo 'cA: ' . $connection_poi_id_A . 'cB: ' . $connection_poi_id_B . '<br> rID: ' . $relationship_id2;
                        //Blurb box
                        echo "<div class='blurb_supporting text_block leg" . $zzz . "'>";
                        if ($temp_id = get_user_id_from_chart_id($chart_id2)) {
                            echo "<span>" . gender_converter_wrapper (get_gender($temp_id), get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                        }
                        elseif ($alt_gender) {
                            echo "<span>" . gender_converter_wrapper ($alt_gender, get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                        }
                        else {
                            echo "<span>" . get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, $text_type, $chart_id1, $chart_id2) . "</span>";
                        }
                    	echo '</div>'; //close Blurb Box
                       	$zzz++;
                    }
                   
                }

                //Blurb Boxes for 4-6 (theirs to yours)
                $zzzz = 4;    
                for ($y = 0; $y < count(get_cornerstones()); $y++) {
                    //$con_x = $support_con[$x];
                    $con_x = $support_con[0];
                    $con_y = $support_con[$y];
                      if ($con_x != $con_y) {
                        $relationship_id2 = $compare_data[$con_x .'2' . $con_y]["relationship_id"];
                        $connection_poi_id_A = get_poi_id (strtoupper($con_x));
                        $connection_poi_id_B = get_poi_id (strtoupper($con_y));
                        //echo 'cA: ' . $connection_poi_id_A . 'cB: ' . $connection_poi_id_B . '<br> rID: ' . $relationship_id2;
                        echo "<div class='blurb_supporting text_block leg" . $zzzz . "'>";
                        if ($temp_id = get_user_id_from_chart_id($chart_id2)) {
                            echo "<span>" . gender_converter_wrapper (get_gender($temp_id), get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                        }
                        elseif ($alt_gender) {
                            echo "<span>" . gender_converter_wrapper ($alt_gender, get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                        }
                        else {
                            echo "<span>" . get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, $text_type, $chart_id1, $chart_id2) . "</span>";
                        }
                        echo '</div>'; //close Blurb Box 
                        $zzzz++;
                      }
                      
                 }

             	*/


?>