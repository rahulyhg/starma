<?php
 
require_once "header.php";
?>

<div id="landing_outer">
<div id="landing_content">

<?php

echo '<input type="text" id="zip" name="zip" value="" onkeyup="
        var intRegex = /^\d+$/;
        
        if ($(\'#zip\').val().length >= 5 && intRegex.test($(\'#zip\').val())) {
          $.ajax({
		          type: \'GET\',
                          cache: false,
	                  url: \'' .get_full_domain() . '/chat/process_all.php\',
                          data: {  
		   			\'function\': \'run_zip\',
                                        
					\'zip\': $(\'#zip\').val()
                                        
					
				},
	                  dataType: \'json\',
            	          success: function(data){                                
				$(\'#zip_test_output\').html(data[\'title\']);
		          }  
                                                                    
		 });
         }
         else {
           $(\'#zip_test_output\').html(\'\');
         }
       "/><br><br>
<div id="zip_test_output">
</div>';
 
?>
</div></div>