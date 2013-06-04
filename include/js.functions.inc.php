<?php

### js Functions ###

function javascript_submit ($form_name='formx', $action='', $hidden='', $value='', $hidden2='', $value2='', $target='') {
  $form = "document." . $form_name;
  $final = "javascript: ";
  if ($hidden != '') {
    $final = $final . $form . "['" . $hidden . "'].value=" . $value . ";";
  }
  if ($hidden2 != '') {
    $final = $final . $form . "['" . $hidden2 . "'].value=" . $value2 . ";";
  }
  
  $final = $final . $form . ".action='" . $action . "';";
  
  $final = $final . $form . ".target='" . $target . "';";
  return $final . $form . ".submit()";


}

function activate_photo_cropper ($img_id, $img_name, $x1_name, $y1_name, $x2_name, $y2_name, $w_name, $h_name) {
  $image = new SimpleImage();
  $image->load(ORIGINAL_IMAGE_PATH() . $img_name);
  
  if (check_user_agent ( $type = 'mobile' )) {
    $persistent = 'true';
    $resizable = 'false';
    if ($image->getWidth() >= $image->getHeight()) {
      $initStartX = round (($image->getWidth() - $image->getHeight()) / 2);
      $initStartY = 0;
      $initSizeX = $image->getHeight() + $initStartX;
      $initSizeY = $image->getHeight();
    }
    else {
      $initStartX = 0;
      $initStartY = 0;
      $initSizeX = $image->getWidth();
      $initSizeY = $image->getWidth();
    }
  }
  else {
    $initStartX = 0;
    $initStartY = 0;
    $initSizeX = 250;
    $initSizeY = 250;
    $persistent = 'false';
    $resizable = 'true';
  }

  echo '<script type="text/javascript">
 
          function preview(img, selection) {
                 var scaleX = 153 / (selection.width || 1);
                 var scaleY = 153 / (selection.height || 1);
  
                 $(\'img#preview_' . $img_id . '\').css({
                     display: \'block\',
                     width: Math.round(scaleX * ' . $image->getWidth() . ') + \'px\',
                     height: Math.round(scaleY * ' . $image->getHeight() . ') + \'px\',
                     marginLeft: \'-\' + Math.round(scaleX * selection.x1) + \'px\',
                     marginTop: \'-\' + Math.round(scaleY * selection.y1) + \'px\'
                  });
                  $(\'#' . $x1_name . '\').val(selection.x1);
          	  $(\'#' . $y1_name . '\').val(selection.y1);
	  	  $(\'#' . $x2_name . '\').val(selection.x2);
	  	  $(\'#' . $y2_name . '\').val(selection.y2);
	  	  $(\'#' . $w_name . '\').val(selection.width);
	  	  $(\'#' . $h_name . '\').val(selection.height);
          }

          $(document).ready(function () {
            $(\'<div><img id="preview_' . $img_id . '" src="' . ORIGINAL_IMAGE_PATH() . $img_name . '?' . time() . '" style="position: relative; display:none;" /><div>\')
                    .css({
                            top: \'53px\',
                            right: \'10px\',
                            position: \'absolute\',
                            overflow: \'hidden\',
                            width: \'153px\',
                            height: \'153px\'
                         })
                         .insertAfter($(\'img#photo_crop_' . $img_id . '\')); 


            $(\'img#photo_crop_' . $img_id . '\').imgAreaSelect({
                 persistent: ' . $persistent . ', resizable: ' . $resizable . ', aspectRatio: \'1:1\', onInit: preview, onSelectChange: preview, handles:true,x1:' . $initStartX . ',y1:' . $initStartY . ',x2:' . $initSizeX . ',y2:' . $initSizeY . '
                 
            });
          });

          
       </script>';
}

function hide_info_box($flag, $name) {
  echo '<input type="checkbox" name="hide_info_box" id="hide_info_box"/> Don\'t show this again<br><br>';
  echo '<input type="button" value="Continue" onclick="
          $.ajax({
		          type: \'GET\',
                          cache: false,
	                  url: \'' .get_full_domain() . '/chat/process_all.php\',
                          data: {  
		   			\'function\': \'set_pref\',
                                        \'pref_name\':\'' . $name . '\',
					\'pref\': !$(\'#hide_info_box\').is(\':checked\')
                                        
					
				},
	                  dataType: \'json\',
            	          success: function(data){
				$(\'#sheen\').hide();
		          }  
                                                                    
		 });
       "/>';
}

function addJSChatEvents($r_id) {
  echo '<script type="text/javascript">
           
        
    	
    	     	 
    	     
             $("#chat_request_' . $r_id . ' #chat_block_' . $r_id . ' #sendie").keydown(function(event) {  
             
                 var key = event.which;  
           
                 
                 if (key >= 33) {
                   
                     var maxLength = $(this).attr("maxlength");  
                     var length = this.value.length;  
                     
                     
                     if (length >= maxLength) {  
                         event.preventDefault();  
                     }  
                  }  
    	      });
    		 
    		 $("#chat_request_' . $r_id . ' #chat_block_' . $r_id . ' #sendie").keyup(function(e) {	
    		 					 
    			  if (e.keyCode == 13) { 
    			  
                                var text = $(this).val();
     				var maxLength = $(this).attr("maxlength");  
                                var length = text.length; 
                     
                               
                               if (length <= maxLength + 1) { 
                                 
                        
                                  
    			          chat_all.send(text, ' . $r_id . ');	
                                  
    			          $(this).val("");
    			        
                               } else {
                    
    	    	                  $(this).val(text.substring(0, maxLength));
    		 			
    			       }	
    				
    				
    			  }
                   
                  });
            
    
        
        
    </script>';
}

function addJSSearchEvents($input_id, $ftn="filterUsers") {
  echo '<script type="text/javascript">
           
        
    	
    	     	 
    	     
             $("#' . $input_id . '").keyup(function(event) {  
             
                 var filter = $("#' . $input_id . '").val();  
                 
                 $.ajax({
		          type: "GET",
                          cache: false,
	                  url: "' .get_full_domain() . '/chat/process_all.php",
                          data: {  
		   			"function": "' . $ftn . '",
					"filter": filter
                                        
					
				},
	                  dataType: "json",
            	          success: function(data){
				for (var user_id in data.users_in) {
                                    
  				    $(".js_user_" + data.users_in[user_id]).show();
                                    
		      		}
                                for (var user_id in data.users_out) {
                                    
  				    $(".js_user_" + data.users_out[user_id]).hide();
                                    
		      		}
		          }  
                                                                    
		 });

                  
             });
            
    
        
        
  </script>';
}

function zipcode_input ($name="zip", $output_div="zip_test_output") {
  echo '<input maxlength="5" type="text" id="zip" name="' . $name . '" value="" onkeyup="
        var intRegex = /^\d+$/;
        
        if ($(\'#zip\').val().length == 5 && intRegex.test($(\'#zip\').val())) {
          $.ajax({
		          type: \'GET\',
                          cache: false,
	                  url: \'' .get_full_domain() . '/chat/process_all.php\',
                          data: {  
		   			\'function\': \'run_zip\',
                                        
					\'zip\': $(\'#' . $name . '\').val()
                                        
					
				},
	                  dataType: \'json\',
            	          success: function(data){
                                if (data[\'title\']) {                               
    				  $(\'#' . $output_div . '\').html(data[\'title\']);
                                }
                                else {
                                  $(\'#' . $output_div . '\').html(\'<span style=&quot;color:red&quot;>Unknown Zip Code</span>\');  
                                }
		          }  
                                                                    
		 });
         }
         else {
           $(\'#' . $output_div . '\').html(\'\');
         }
       "/>';
}

?>
