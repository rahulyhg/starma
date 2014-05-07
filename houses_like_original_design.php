<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {

	//$poi_test = get_poi_in_house(2);
	//mysql_fetch_array($poi_test);
	//$house_poi = array();
	//while($row = mysql_fetch_array($poi_test)) {
	//	array_push($house_poi, $row["poi_id"]);
	//}
	//print_r($house_poi);




	echo '<ul>';
		for($i = 1; $i <= 12; $i++) {
			echo '<li>';
				echo '<div class="house h' . $i .'">House ' . $i . '</div>';
				echo '<div class="blurb_area_wrapper">';
					echo '<div class="subnav">';
						echo '<ul>';
						$poi_list = get_poi_in_house($i);
						if($poi_list){
							while($row = mysql_fetch_array($poi_list)) {
								echo '<li><div class="poi_tab"><a href="#" class="' 
								. ucfirst(strtolower(get_poi_name($row["poi_id"]))) . '">' 
								. ucfirst(strtolower(get_poi_name($row["poi_id"]))) . '</a></div></li>';
							}
						}
							
						echo '</ul>';
					echo '</div>'; //close subnav
					echo '<div class="blurb_section">';
						echo '<div class="blurb"></div>';
					echo '</div>'; //close blurb_section
				echo '</div>'; //close blurb_area_wrapper
			echo '</li>';
		}

	echo '</ul>';


	echo '<script type="text/javascript" src="js/houses_ui.js"></script>';

}

?> 