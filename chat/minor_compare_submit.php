<?php
	require('ajax_header.php');

	$data = array();
	$errors = array();
	if (isset($_POST['mc'])) {
		$mc = trim($_POST['mc']);
    $chart_id1 = trim($_POST['chart_id1']);
    $chart_id2 = trim($_POST['chart_id2']);
		if (!preg_match('%[0-9]{1}%', $mc)) {
			$errors['mc'] = 'Strange mc';
		}
		else {
			$data['mc'] = $mc;
		}
    if (!preg_match('%[0-9]+%', $chart_id1)) {
      $errors['chart_id1'] = 'Strange chart_id1';
    }
    if (!preg_match('%[0-9]+%', $chart_id2)) {
      $errors['chart_id2'] = 'Strange chart_id2';
    }
    if($temp_id = get_user_id_from_chart_id($chart_id2)) {
      $g_for_wrapper = get_gender($temp_id);
              if (get_gender($temp_id) == "M") { 
                  $gender = 'HIS';
              }
              elseif (get_gender($temp_id) == "F") {
                 $gender = 'HER';
              }
              else {
                  $gender = '';
              }
      }
      else {
        $errors['gender'] = 'Couldn\'t get gender';
      }

    if (!empty($errors)) {
      $data['errors'] = $errors;
    }
	  else { 
      $compare_data=$_SESSION["compare_data"];  //COULD THIS BE A PROBLEM IF MULTIPLE CHARTS ARE BEING VIEWED?
	    $support_con = array();
      $support_con = get_cornerstones();
      $connection = $support_con[$mc];
      $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));  //in user functions
      $button_sign_id2 = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));

      //$x = 0;
      //foreach (get_cornerstones() as $connection) {

      //for ($x = 0; $x < 5; $x++) {

        //$connection_type = $support_con[$x];

          //echo '<li>'; 
        $str1 = '<div class="poi_column_wrapper_minor"><div class="left no_hover ' . get_selector_name($button_sign_id) . '_tall"><span class="icon"><span class="minor_poi_title">YOUR</span><span class="poi_title_tall">' . strtoupper($connection) . '</span></span></div><div class="right no_hover right_icon_adjust ' . get_selector_name($button_sign_id2) . '_tall"><span class="icon"><span class="minor_poi_title">' . $gender . '</span><span class="poi_title_tall">' . strtoupper($connection) . '</span></span></div><div class="bridge_top"><div class="bridge_top_title">SUPPORT FOR YOUR ' . strtoupper($connection) . ' SIGN CONNECTION</div><span class="add_arrow_top"><span></span></span></div>';  //close Bridge Top


                //Your Y to their X
                $left_pillars = '';
                $z = 1;
                for ($y = 0; $y < count(get_cornerstones()); $y++) {
                    //$con_x = $support_con[$x];
                    $con_x = $support_con[$mc];
                    $con_y = $support_con[$y];
                    if ($con_x != $con_y) {
                      	$button_sign_id3 = get_sign_from_poi ($chart_id1, get_poi_id (strtoupper($con_y)));
                      	$relationship_id2 = $compare_data[$con_y .'2' . $con_x]["relationship_id"];
                    	//echo 'c1: ' . $connection1 . '<br>c2: ' . $connection2;
                    	//echo $connection1 . 'to';
                    	//echo $connection2 . '<br>';
                      	$str2 = '<div class="';
                        if($relationship_id2 < 5) {
                          	$str3 = $str2 . 'pillar">';
                        }
                        else {
                          	$str3 = $str2 . 'pillar_broken">';
                        }

                      //echo '">';
                        $str4 = $str3 . '<div class="pillar_icon_minor L ' . get_selector_name($button_sign_id3) . '_tall"><span class="icon pointer main to_leg' . $z . '"><span class="minor_poi_title">YOUR</span><span class="poi_title_tall">' . strtoupper($con_y) . '</span></span></div></div>'; //close pillar/pillar_broken
                        $z++; 
                        $left_pillars = $left_pillars . $str4;
                    }
                    
                  } //close your Y to their X
                
                //Your X to their Y
                $right_pillars = '';
                $zz = 4;    
                for ($y = 0; $y < count(get_cornerstones()); $y++) {

                  //$con_x = $support_con[$x];
                  	$con_x = $support_con[$mc];
                  	$con_y = $support_con[$y];
                  	if ($con_x != $con_y) {
                    	$button_sign_id4 = get_sign_from_poi ($chart_id2, get_poi_id (strtoupper($con_y)));
                    	$relationship_id2 = $compare_data[$con_x .'2' . $con_y]["relationship_id"];
                    	//echo 'c1: ' . $connection1 . '<br>c2: ' . $connection2;
                    	//echo $connection1 . 'to';
                    	//echo $connection2 . '<br>';
                     	$str5 = '<div class="';
                        if($relationship_id2 < 5) {
                          	$str6 = $str5 . 'pillar">';
                        }
                        else {
                          	$str6 = $str5 . 'pillar_broken">';
                        }
                    
                        $str7 = $str6 . '<div class="pillar_icon_minor R ' . get_selector_name($button_sign_id4) . '_tall"><span class="icon pointer main to_leg' . $zz . '"><span class="minor_poi_title">' . $gender . '</span><span class="poi_title_tall">' . strtoupper($con_y) . '</span></span></div></div>'; //close pillar/pillar_broken
                        $zz++; 
                      $right_pillars = $right_pillars . $str7;
                    }
                    
                  } //close your X to their Y

                $str1 = $str1 . $left_pillars . $right_pillars . '<div class="bridge_base"><img src="/img/Starma-Astrology-Pillars-Base.png" /></div>'; //Base


                //TESTING
                /*
                $data['con_x'] = $support_con[$mc];
                $data['con_y'] = $support_con[0];
                $data['poi_id_a'] = get_poi_id (strtoupper($data['con_y']));
                $data['poi_id_b'] = get_poi_id (strtoupper($data['con_x']));
                $data['relationship_id2'] = $compare_data[$data['con_y'] . '2' . $data['con_x']]["relationship_id"];
                $data['chart_id1'] = $chart_id1;
                $data['chart_id2'] = $chart_id2;
                $data['blurb'] = gender_converter_wrapper ($g_for_wrapper, get_poi_dynamic_blurb ($data['poi_id_a'], $data['poi_id_b'], $data['relationship_id2'], 1, $chart_id1, $chart_id2));
                */
                //END TESTING
                
                
                //Blurb Boxes for 1-3 (yours to theirs)
                $left_blurbs = '';
                $zzz = 1;    
                for ($y = 0; $y < count(get_cornerstones()); $y++) {
                  //$con_x = $support_con[$x];
                 	 $con_x = $support_con[$mc];
                 	 $con_y = $support_con[$y];
                    if ($con_x != $con_y) {
                        $relationship_id2 = $compare_data[$con_y . '2' . $con_x]["relationship_id"];
                        $connection_poi_id_A = get_poi_id (strtoupper($con_y));
                        $connection_poi_id_B = get_poi_id (strtoupper($con_x));
                        //echo 'cA: ' . $connection_poi_id_A . 'cB: ' . $connection_poi_id_B . '<br> rID: ' . $relationship_id2;
                        //Blurb box
                        $str8 = "<div class='blurb_supporting text_block leg" . $zzz . "'>";
                        //if ($temp_id = get_user_id_from_chart_id($chart_id2)) {
                            $str9 = $str8 . "<span>" . gender_converter_wrapper ($g_for_wrapper, get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                        //}
                        
                        //elseif ($alt_gender) {
                          //  $str9 = $str8 . "<span>" . gender_converter_wrapper ($alt_gender, get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                        //}
                        //else {
                          //  $str9 = $str8 . "<span>" . get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, $text_type, $chart_id1, $chart_id2) . "</span>";
                        //}
                        
                    	$str10 = $str9 . '</div>'; //close Blurb Box
                      $zzz++;
                      $left_blurbs = $left_blurbs . $str10;
                    }
                   
                }

                $str1 = $str1 . $left_blurbs;


                
                //Blurb Boxes for 4-6 (theirs to yours)
                $right_blurbs = '';
                $zzzz = 4;    
                for ($y = 0; $y < count(get_cornerstones()); $y++) {
                    //$con_x = $support_con[$x];
                    $con_x = $support_con[$mc];
                    $con_y = $support_con[$y];
                      if ($con_x != $con_y) {
                        $relationship_id2 = $compare_data[$con_x .'2' . $con_y]["relationship_id"];
                        $connection_poi_id_A = get_poi_id (strtoupper($con_x));
                        $connection_poi_id_B = get_poi_id (strtoupper($con_y));
                        //echo 'cA: ' . $connection_poi_id_A . 'cB: ' . $connection_poi_id_B . '<br> rID: ' . $relationship_id2;
                        $str11 = "<div class='blurb_supporting text_block leg" . $zzzz . "'>";
                        //if ($temp_id = get_user_id_from_chart_id($chart_id2)) {
                            $str12 = $str11 . "<span>" . gender_converter_wrapper ($g_for_wrapper, get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                        //}
                        
                        //elseif ($alt_gender) {
                          //  $str12 = $str11 . "<span>" . gender_converter_wrapper ($alt_gender, get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                        //}
                        //else {
                          //  $str12 = $str11 . "<span>" . get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, $text_type, $chart_id1, $chart_id2) . "</span>";
                        //}
                        
                        $str13 = $str12 . '</div>'; //close Blurb Box 
                        $zzzz++;
                      $right_blurbs = $right_blurbs . $str13;
                      }
                       
                }
            $str1 = $str1 . $right_blurbs;
            
            

        $data['results'] = $str1;

      }
    echo json_encode($data);
  }     	


?>