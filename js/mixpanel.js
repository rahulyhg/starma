$(document).ready(function(){

	
//TOPNAV

	$('.home_link').click(function(){
		mixpanel.track('Home TopNav');
	});

	$('.profile_link').click(function(){
		mixpanel.track('Profile TopNav');
	});
	
	$('.compare_link').click(function(){
		mixpanel.track('Community TopNav');
	});

	$('.celeb_link').click(function(){
		mixpanel.track('Celebs TopNav');
	});

	$('.inbox_link').click(function(){
		mixpanel.track('Inbox TopNav');
	});

	$('#pop_invite_top').click(function(){
		mixpanel.track('Invite User TopNav');
	});


//4 SQUARE HOMEPAGE

	$('#profile_box_link').click(function(){
		mixpanel.track('Profile Box Homepage');
	});

	$('#community_box_link').click(function(){
		mixpanel.track('Community Box Homepage');
	});

	$('#horoscope_box_link').click(function(){
		mixpanel.track('Birth Chart Box Homepage');
	});

	$('#celebrities_box_link').click(function(){
		mixpanel.track('Celebrities Box Homepage');
	});

//COMMUNITY PAGE
	
	$('#sfb_friends').click(function(){
		mixpanel.track('Find FB Friends When Connected');
	});

	$('#cue_search').on('keyup', function(e){
		if (e.which == 13) {
			mixpanel.track('Email or Username Search');
		}		
	});

	$('#cue_button').click(function(){
		mixpanel.track('Email or Username Search');		
	});

	$('.user_block').click(function(){
		mixpanel.track('User Selected',{
			'General Info' : $(this).children('.profile_info_area').children('.name_area').text()
		});
	});

	$('#add_to_favorites').click(function(){
		mixpanel.track('Add to Favs');		
	});

	$('.message_button').click(function(){
		mixpanel.track('Messaged User From Their Profile');		
	});

	$('.chat_button').click(function(){
		mixpanel.track('Chat with User');		
	});

	$('.compare_button').click(function(){
		mixpanel.track('Compared to User');		
	});

//CUSTOM CHART
	
	$('#submit_div_custom').click(function(){
		mixpanel.track('Cast Custom Chart');		
	});

	$('.invite_user').click(function(){
		mixpanel.track('Invite User from Custom Chart');		
	});

});