$(document).ready(function(){

	$('.name_area').on('mouseenter', function(){
		$('.location_edit').show();
	});

	$('.name_area').on('mouseleave', function(){
		$('.location_edit').hide();
	});

	$('.location_edit').click(function(){
		$('.location_pop').slideFadeToggle();
	});

	$('.location_cancel').click(function(){
		$('.location_pop').slideFadeToggle(function() {
			$('.location_error_area').removeClass('location_error').hide().text('');
			$('#zip').val('');
			$('input[name=title]').val('');
		});
	});

	$('.location_send').click(function(event){

		var data = {
			'country_id' : $('#country_id').val(),
			'title'      : $('input[name=title]').val(),
			'zip'        : $('#zip').val()
		};

		$.ajax({
            type      : 'POST',
            url       : 'chat/ajax_update_current_location.php',
            data      :  data,
            dataType  : 'json',

        })
        .done(function(data){
        	
        	if(data.errors) {
        		$('.location_error_area').addClass('location_error').show().text(data.message);
        	}
        	if(data.success) {
        		//alert(data.message);
        		$('.location_error_area').removeClass('location_error').hide().text('');
        		$('#location').html(' ' + data.new_location);
        		$('.location_pop').slideFadeToggle();
        	}
        });

		event.preventDefault();
	});

	jQuery.fn.slideFadeToggle = function(easing, callback) {
    	return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};
});