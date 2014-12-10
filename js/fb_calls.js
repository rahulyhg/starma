$(document).ready(function(){

//GENERAL CALLS ---------------------------------

 //FIND FRIENDS -------------------------------------------

	$('#sfb_friends').click(function(){
		$(this).prop('disabled', true);
    	checkLoginStateNTS();    
	});


});