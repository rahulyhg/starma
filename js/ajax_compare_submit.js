$(document).ready(function(){

	$('#connection_browser').submit(function(event){
		
		var input_data = {
			'results_type' : $('input[type=submit][clicked=true]').val(),
			'chart_id1'    : $('input[name=chart_id1]').val(),
          	'chart_id2'    : $('input[name=chart_id2]').val()
		};
		//alert(input_data['chart_id2']);
			$.ajax({
				type     : "POST",
				url      : "chat/ajax_compare_submit.php",
				data     : input_data,
				dataType : "json"
			})

			.done(function(data){
				alert(data);
			});
		
		//alert(input['chart_id1']);
		event.preventDefault();
	});

	$("#connection_browser input[type=submit]").click(function() {
    $("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
    $(this).attr("clicked", "true");
	});
});