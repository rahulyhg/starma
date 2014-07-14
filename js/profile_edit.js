$(document).ready(function(){

	$('.name_area').on('mouseenter', function(){
		$('.location_edit').show();
	});

	$('.name_area').on('mouseleave', function(){
		$('.location_edit').hide();
	});

	$('.location_edit').click(function(){

	});

	jQuery.fn.slideFadeToggle = function(easing, callback) {
    	return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};
});