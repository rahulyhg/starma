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
    });

	$('.desc_input').each(function(){
        
        $(this).on('blur', function(event){
                        var default_value = $(this).siblings('.value').children('.word').text();
                            var $text = default_value;
							if($(this).is(':visible')) {
                                var $clicked = $(this);
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
                                    if(!data.errors) {
                                        $clicked.hide();
                                        $clicked.siblings('div').show();
                                        $clicked.siblings('.value').children('.pencil').removeClass('edit_icon_hidden');
                                        $clicked.siblings('.value').children('.pencil').addClass('edit_icon');   
                                        $clicked.siblings('.value').children('.word').text(data['value']);
                                        $clicked.siblings('.value').children('.saved').text('Saved!').show().fadeOut(1000);
            						    //alert('sucess, id: ' + data.user_des_id + ', value: ' + data.post_value);  
                                    }
                                    else {
                                        var text = $text;
                                        $clicked.hide();
                                        $clicked.siblings('div').show();
                                        $clicked.siblings('.value').children('.pencil').removeClass('edit_icon_hidden');
                                        $clicked.siblings('.value').children('.pencil').addClass('edit_icon');   
                                        $clicked.siblings('.value').children('.word').text(text);
                                        $clicked.siblings('.value').children('.saved').text(data.errors).show().fadeOut(1500);
                                    }         						
            					})

          						.fail(function(data){
            					  	console.log(data);
              						//alert('failure ' + data.errors);
          						});
        					}
						}); 
        $(this).on('keypress', function(event) {
                    var default_value = $(this).siblings('.value').children('.word').text();
                        var $text = default_value;
							if($(this).is(':visible')) {
								if(event.which == 13) {
                                    var $clicked = $(this);
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
                                        if(!data.errors) {
                                            $clicked.hide();
                                            $clicked.siblings('div').show();
                                            $clicked.siblings('.value').children('.pencil').removeClass('edit_icon_hidden');
                                            $clicked.siblings('.value').children('.pencil').addClass('edit_icon');   
                                            $clicked.siblings('.value').children('.word').text(data['value']);
                                            $clicked.siblings('.value').children('.saved').text('Saved!').show().fadeOut(1000);
                                        }
                                        else {
                                            var text = $text;
                                            $clicked.hide();
                                            $clicked.siblings('div').show();
                                            $clicked.siblings('.value').children('.pencil').removeClass('edit_icon_hidden');
                                            $clicked.siblings('.value').children('.pencil').addClass('edit_icon');   
                                            $clicked.siblings('.value').children('.word').text(text);
                                            $clicked.siblings('.value').children('.saved').text(data.errors).show().fadeOut(1500);
                                        }
            							//alert('sucess, id: ' + data.user_des_id + ', value: ' + data.post_value);           							
            						})

          							.fail(function(data){
            					  		console.log(data);
              							//alert('failure ' + data);
          							});
									}
								}
							
				    });
        });
    	
});