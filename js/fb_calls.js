$(document).ready(function(){

//GENERAL CALLS ---------------------------------

 //FIND FRIENDS -------------------------------------------

	$('#sfb_friends').click(function(){
		$(this).prop('disabled', true);
		setTimeout(function(){
			$('#sfb_friends').prop('disabled', false);
		}, 3000);
    	checkLoginStateNTS();    
	});


});