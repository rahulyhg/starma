$(document).ready(function(){

//alert('hello');

	$('#add_to_favorites').click(function(){
		$('#add_to_favorites span').text('Saving...');
		var favs_data = {
			'other_user_id' : $('input[name=other_user_id]').val(),
			//'toggle'        : $('input[name=toggle]').val()
			};
		//alert(toggle);
	
		$.ajax ({
			type: 'POST',
			url: 'chat/toggle_favorite.php',
			data: favs_data,
			dataType: 'json',
		})
		.done(function(data){
			//$('#add_to_favorites span').removeAttr('id', 'ajax_loader').html('');
			if(data.add) {
				//alert(data.add);
				$('#add_to_favorites').removeClass('remove_favorite_button');
				$('#add_to_favorites').addClass('add_favorite_button');
				$('#add_to_favorites span').text(data.add);
			}
			else {
				//alert(data.remove);
				$('#add_to_favorites').removeClass('add_favorite_button');
				$('#add_to_favorites').addClass('remove_favorite_button');
				$('#add_to_favorites span').text(data.remove);
			}
		});

	//alert(other_user_id);
	});

});