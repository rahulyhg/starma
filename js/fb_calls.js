$(document).ready(function(){

//GENERAL CALLS ---------------------------------

 //FIND FRIENDS -------------------------------------------

	$('#sfb_friends').click(function(){
    $('#s_results').hide();
    $('#hide_s').show();
		$('#users_found').show().html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
    checkLoginStateNTS();    
	});


});