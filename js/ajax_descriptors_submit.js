$(document).ready(function(){

	$('.edit_icon').click(function(){
	 	var text = $(this).siblings('.word').text();
        var desc_input = $(this).parent().siblings('.desc_input');
        $(this).parent().hide();
        $(this).parent().siblings('.title').hide();
        $(this).parent().siblings('input').show().focus();
        $(desc_input).val(text);           
        $(this).addClass('edit_icon_hidden')
        $(this).removeClass('edit_icon');
    })

	$('.desc_input').on({
						blur: function(){
							if($(this).is(':visible')) {
								var data = {
									'value'	      : $(this).val(),
									'user_des_id' : $(this).siblings('input[name=user_des_id]').val()
									};
								
								$.ajax({
            						type      : 'POST',
            						url       : 'chat/save_descriptors.php',
            						data      :  data,
            						dataType  : 'json',

        						})
          						.done(function(data){
            						console.log(data);
            						//alert('sucess, id: ' + data.user_des_id + ', value: ' + data.post_value);           						
            					})

          						.fail(function(data){
            					  	console.log(data);
              						alert('failure ' + data);
          						});

								$(this).hide();
								$(this).siblings('div').show();
								$(this).siblings('.value').children('.pencil').removeClass('edit_icon_hidden');
        						$(this).siblings('.value').children('.pencil').addClass('edit_icon');	
        						$(this).siblings('.value').children('.word').text(data['value']);
                                $(this).siblings('.value').children('.saved').show().fadeOut(1000);
        						//$('#hello').toggle();
        					}
						}, keypress: function(event) {
							if($(this).is(':visible')) {
								if(event.which == 13) {
									var data = {
										'value'	      : $(this).val(),
										'user_des_id' : $(this).siblings('input[name=user_des_id]').val()
									};
									
									$.ajax({
            							type      : 'POST',
            							url       : 'chat/save_descriptors.php',
            							data      :  data,
            							dataType  : 'json',

        							})
          							.done(function(data){
            							console.log(data);
            							//alert('sucess, id: ' + data.user_des_id + ', value: ' + data.post_value);           							
            						})

          							.fail(function(data){
            					  		console.log(data);
              							//alert('failure ' + data);
          							});
									$(this).hide();
									$(this).siblings('div').show();
									$(this).siblings('.value').children('.pencil').removeClass('edit_icon_hidden');
        							$(this).siblings('.value').children('.pencil').addClass('edit_icon');
        							$(this).siblings('.value').children('.word').text(data['value']);
                                    $(this).siblings('.value').children('.saved').show().fadeOut(1000);
        							//$('#hello').toggle();
									}
								}
							}
			
			
				});
    	
});