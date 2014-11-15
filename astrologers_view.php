<?php
	require ('header.php');
	if (isLoggedIn()) {
		if ($_GET['the_page'] == 'psel') {
			show_astrologers_view(get_my_chart_id());
		}
		else {
			$chart_id2 = $_GET['chart_id2'];
			show_astrologers_view($chart_id2);
		}
	}
	

?>