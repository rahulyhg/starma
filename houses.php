<?php
require_once ("header.php");

  
//if (login_check_point($type="full")) {
	if (!get_my_chart()) {
    	echo 'Enter your birth info to get your birth chart';
  	}
	else {
		show_house_lords();
	}
	/*

$chart_id = get_my_chart_id();
$rising_sign_id = get_sign_from_poi ($chart_id, 1); //in user functions

echo '<div id="house_column">';
	echo '<ul>';
		for($i = 0; $i <= 11; $i++) {
			$sign_id = $rising_sign_id + $i;
				if($sign_id > 12) {
					$sign_id = $sign_id - 12;
				}
			echo '<li>';
				echo '<div class="house_column_wrapper">';
					echo '<div class="ruled_house"><p>H' . ($i + 1) . ' contains: ';
					echo get_sign_name($sign_id) .' LoH' . ($i +1) . ': ';
				
					$results = get_ruler_of_sign($sign_id);
					while($row = mysql_fetch_array($results)) {
						$ruler_of_sign_id = $row["ruling_poi_id"];
						$ruler_of_sign = strtolower(ucfirst(get_poi_name($row["ruling_poi_id"])));
						echo $ruler_of_sign;
					}
				
				
					$sign_of_residence = get_sign_from_poi($chart_id, $ruler_of_sign_id);

					$house_of_residence = $sign_of_residence - $rising_sign_id;
						if ($house_of_residence < 0) {
							$house_of_residence = $house_of_residence + 12;
						}
					$house_of_residence = $house_of_residence + 1;

					//echo ' in H: ' . $house_of_residence;

					echo '</p></div>';
					echo '<div class="house_blurb"><span>';
						echo get_house_ruler_blurb($rising_sign_id, ($i+1), $house_of_residence);

					echo '</span></div>';
					echo '<div class="house_residence">';
						//echo get_sign_name($sign_id) .' LoH' . ($i +1) . ': ';
						echo 'Residing in H: ' . $house_of_residence;
					echo '</div>';

				echo '</div>'; //close house_column_wrapper
			echo '</li>';

		}

	echo '</ul>';
echo '</div>';  //close house column1

/*
echo '<div id="house_column2">';
$chart_id = get_my_chart_id();
$rising_sign_id = get_sign_from_poi ($chart_id, 1);
//echo get_sign_name($rising_sign_id);
	echo '<ul>';
	for($i = 1; $i <= 12; $i++) {
		$results = get_poi_in_house($i);
		$poi_list = array();
		echo '<li>';
		if($results) {
			while($row = mysql_fetch_array($results)) {
				array_push($poi_list, $row["poi_id"]);
			}
				echo 'house ' . $i . ' : ';
				print_r($poi_list);
			//for($p = 2; $p <= 8; $p++) {

			//}
			
		}
		else {
			echo 'house ' . $i . ' : no poi here';
		}
		echo '</li>';
	}
	echo '</ul>';
echo '</div>';	//close house column2

*/

	//echo '<script type="text/javascript" src="js/ajax_hl_submit.js"></script>';

//}

?> 