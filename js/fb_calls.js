$(document).ready(function(){

//GENERAL CALLS ---------------------------------

 //FIND FRIENDS -------------------------------------------

	$('#sfb_friends').click(function(){
		$(this).prop('disabled', true).css('color', 'gray');
		setTimeout(function(){
			$('#sfb_friends').prop('disabled', false).css('color', 'black');
		}, 3000);
    	checkLoginStateNTS();    
	});


});