<?php 

require_once ("../header.php");


	if (!permissions_check ($req = 10)) {
  		header( 'Location: http://www.' . $domain . '/underconstruction.php');
	}  
	else {

		for($x = 1; $x < 13; $x++) {

			echo '<div style="margin:30px auto auto;">Lord of the 12th in house' . $x . '</div><br/><br/>';

			for($i = 1; $i < 875; $i++) {
				$rising_sign_id = get_sign_from_poi ($i, 1);
				$sign_in_nth  = $rising_sign_id + 11;
					if ($sign_in_nth > 12) {
						$sign_in_nth = $sign_in_nth - 12;
					}
				$ruler = get_ruler_of_sign($sign_in_nth);
				while($row = mysql_fetch_array($ruler)) {
						$ruler_of_sign_id = $row["ruling_poi_id"];
						//$ruler_of_sign = strtolower(ucfirst(get_poi_name($row["ruling_poi_id"])));
						//echo 'The ruler of ' . $sign_name . ' is ' . $ruler_of_sign;
					}
				$sign_of_residence = get_sign_from_poi($i, $ruler_of_sign_id);

					$house_of_residence = $sign_of_residence - $rising_sign_id;
						if ($house_of_residence < 0) {
							$house_of_residence = $house_of_residence + 12;
						}
					$house_of_residence = $house_of_residence + 1;
						if ($house_of_residence == $x) {
							$user_id = get_user_id_from_chart_id($i);
							$username = get_nickname($user_id);
							if ($username) {
								echo $username . ', ';
							}						
						
					}
					
			}
		}



		/*
		$rising_sign_id = get_sign_from_poi (176, 1);
		$sign_in_11th  = $rising_sign_id + 10;
			if ($sign_in_11th > 12) {
				$sign_in_11th = $sign_in_11th - 12;
			}
		$sign_name = get_sign_name($sign_in_11th);
		echo 'The 11th house has sign: ' . $sign_name;
		echo '<br/><br/>';

		$ruler = get_ruler_of_sign($sign_in_11th);
		while($row = mysql_fetch_array($ruler)) {
					$ruler_of_sign_id = $row["ruling_poi_id"];
					$ruler_of_sign = strtolower(ucfirst(get_poi_name($row["ruling_poi_id"])));
					echo 'The ruler of ' . $sign_name . ' is ' . $ruler_of_sign;
				}
		echo '<br/><br/>';

		$sign_of_residence = get_sign_from_poi(176, $ruler_of_sign_id);

				$house_of_residence = $sign_of_residence - $rising_sign_id;
					if ($house_of_residence < 0) {
						$house_of_residence = $house_of_residence + 12;
					}
				$house_of_residence = $house_of_residence + 1;

		echo $sign_name . ' resides in ' . $house_of_residence;

		*/
	}


?>