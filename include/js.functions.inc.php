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

function addBackToTopHandler () {
  echo '<script type="text/javascript">
  
           $(window).on(\'scroll\',function() {
             
             var vPos = $(window).scrollTop();
                 
             if ($("#js_back_to_top").is(":visible")) {
               $("#js_back_to_top").fadeTo(0, parseFloat(vPos) / 700.00);
             }
           });
  </script>';
}


function js_edit_framework($jquery_edit_object, $jquery_display_object, $type, $row_id_to_update, $desc_value) {
  if ($type=="user_descriptor") {
    echo '
      <input type="text" class="js_edit_input_object" name="' . $jquery_edit_object . '" id="' . $jquery_edit_object . '" />    
    ';
    echo '<script type="text/javascript">
             $(\'#' . $jquery_edit_object . '\').keypress(function (e) {
                   if (e.which == 13) {
                     $.ajax({
		          type: \'GET\',
                          cache: false,
	                  url: \'' .get_full_domain() . '/chat/process_all.php\',
                          data: {  
		   			\'function\': \'update_desc\',
                                        \'user_des_id\':\'' . $row_id_to_update . '\',
					\'value\': $(\'#' . $jquery_edit_object . '\').val()
                                        
					
				},
	                  dataType: \'json\',
            	          success: function(data){
				$(\'#' . $jquery_display_object . '\').text($(\'#' . $jquery_edit_object . '\').val());

                                $(\'#' . $jquery_display_object . '\').show();
                                $(\'#' . $jquery_edit_object . '\').hide();
                                $(\'#pencil_' . $row_id_to_update . '\').addClass(\'edit_icon\');
                                $(\'#pencil_' . $row_id_to_update . '\').removeClass(\'edit_icon_hidden\');
		          }  
                                                                    
		     });
                     return false;
                   }
                   else {
                     return true;
                   }
                   
                   
             });
         </script>
    ';
  }
  echo '<a id="pencil_' . $row_id_to_update . '" class="edit_icon" href="" onclick="
           $(\'#' . $jquery_display_object . '\').hide();
           $(\'#' . $jquery_edit_object . '\').show();
           $(\'#' . $jquery_edit_object . '\').focus();
           $(\'#' . $jquery_edit_object . '\').val($(\'#' . $jquery_display_object . '\').text());           
           $(this).addClass(\'edit_icon_hidden\')
           $(this).removeClass(\'edit_icon\');
           return false;
       "></a>';
 
  
  
}

function js_more_link ($div_name, $num_pages, $current_page, $height_inc, $num_users) {
    
  echo '<div id="js_more_link">';
   
   /*
   if ($num_pages > 1) {
     echo '<div id="paging_links">';  
     echo '<a onclick="change_page( parseInt($(\'#current_page\').val())-1 ); animate_page_turn(\'' . $div_name . '\'); return false;" href="">Prev Page</a>';
     
     
     
     
     if ($current_page >= 4) {
       echo '<a id="left_end" onclick="change_page(1); animate_page_turn(\'' . $div_name . '\'); return false;" href="">1</a>';   
       if ($current_page >= 5) {
         echo '<a id="left_elip" onclick="return false;">...</a>';
       }
     }
  
     

     // LINK BEHIND
       
     if ($current_page > 1) {
       if ($current_page == $num_pages and $num_pages >= 3) {
         echo '<a id="link_way_behind" onclick="change_page(' . (int)($current_page-2) . '); animate_page_turn(\'' . $div_name . '\'); return false;" href="">' . (int)($current_page-2) . '</a>';
       }
       echo '<a id="link_behind" onclick="change_page(' . (int)($current_page-1) . '); animate_page_turn(\'' . $div_name . '\'); return false;" href="">' . (int)($current_page-1) . '</a>';
       
     }
   
     // LINK CURRENT
     echo '<a id="link_current" onclick="change_page(' . (int)($current_page) . '); animate_page_turn(\'' . $div_name . '\'); return false;" href="">' . (int)($current_page) . '</a>';

     // LINK AHEAD
     if ($current_page < $num_pages) {   
       echo '<a id="link_ahead" onclick="change_page(' . (int)($current_page+1) . '); animate_page_turn(\'' . $div_name . '\'); return false;" href="">' . (int)($current_page+1) . '</a>';
       if ($current_page == 1 and $num_pages >= 3) {
         echo '<a id="link_way_ahead" onclick="change_page(' . (int)($current_page+2) . '); animate_page_turn(\'' . $div_name . '\'); return false;" href="">' . (int)($current_page+2) . '</a>';
       }
     }
     
      
     if ($current_page <= $num_pages - 3) {
       if ($current_page <= $num_pages - 2) {
         echo '<a id="right_elip" onclick="return false;">...</a>';
       }
       echo '<a id="right_end" onclick="change_page(' . (int)($num_pages) . '); animate_page_turn(\'' . $div_name . '\'); return false;" href="">' . (int)($num_pages) . '</a>';
     }
  
     echo '<a onclick="change_page(parseInt($(\'#current_page\').val())+1); animate_page_turn(\'' . $div_name . '\'); return false;" href="">Next Page</a>';
    
     //for ($i=0; $i<$num_pages; $i++) {
       //echo $i;
       //echo '<a onclick="
       //                       $(\'#'. $div_name . '\').animate({\'margin-top\':' . (int)((-1) * $height_inc * $i) . ' +\'px\'}); 
       //                       $(\'#current_page\').val(' . (int)($i+1) . '); 
       //                       return false;
       //                 " href="">' . (int)($i+1) . '</a>';       
       
     //}
     echo '</div>';
   }
   */

     
   
     echo '<div id="paging_links">';  

       

       echo '<a onclick="change_page( parseInt(1)); animate_page_turn(\'' . $div_name . '\'); return false;" href="">|<</a>';

       echo '<a onclick="change_page( parseInt($(\'#current_page\').val())-1 ); animate_page_turn(\'' . $div_name . '\'); return false;" href=""><<</a>';
     
     
     
     
     
       echo '<a id="left_end" onclick="change_page(1); animate_page_turn(\'' . $div_name . '\'); return false;" href="">1</a>';   
       
       echo '<a id="left_elip" onclick="return false;" href="">...</a>';
      
  
     

       // LINK BEHIND
       
     
       echo '<a id="link_way_behind" href=""></a>';
       
       echo '<a id="link_behind" href=""></a>';
       
     
   
       // LINK CURRENT
       echo '<a id="link_current" href=""></a>';

       // LINK AHEAD
      
       echo '<a id="link_ahead" href=""></a>';
       
       echo '<a id="link_way_ahead" href=""></a>';
       
     
      
     
       echo '<a id="right_elip" onclick="return false;" href="">...</a>';
       
       echo '<a id="right_end" href="">' . $num_pages . '</a>';
     
  
     echo '<a onclick="change_page(parseInt($(\'#current_page\').val())+1); animate_page_turn(\'' . $div_name . '\'); return false;" href="">>></a>';

     echo '<a id="right_end_most" onclick="change_page( parseInt(' . $num_pages . '); animate_page_turn(\'' . $div_name . '\'); return false;" href="">>|</a>';
    
     //for ($i=0; $i<$num_pages; $i++) {
       //echo $i;
       //echo '<a onclick="
       //                       $(\'#'. $div_name . '\').animate({\'margin-top\':' . (int)((-1) * $height_inc * $i) . ' +\'px\'}); 
       //                       $(\'#current_page\').val(' . (int)($i+1) . '); 
       //                       return false;
       //                 " href="">' . (int)($i+1) . '</a>';       
       
     //}
     echo '</div>';
   
     echo '<div id="view_select">';
         echo '<a id="view_all" onclick="change_height_inc(maxHeight_inc(' . $num_users . ')); change_num_pages (' .  $num_users . '); change_page( parseInt(1)); animate_page_turn(\'' . $div_name . '\'); $(\'#view_pages\').show(); $(\'#view_all\').hide(); $(\'#js_back_to_top\').fadeTo(200,0); $(\'#js_back_to_top\').show(); return false;" href="">View All</a>';
         echo '<a style="display:none; margin-left: 87px;" id="view_pages" onclick="change_height_inc(792); change_num_pages (' .  $num_users . '); change_page( parseInt(1)); animate_page_turn(\'' . $div_name . '\'); $(\'#view_all\').show(); $(\'#view_pages\').hide(); $(\'#js_back_to_top\').fadeTo(200,0); $(\'#js_back_to_top\').hide(); return false;" href="">View Pages</a>';
     echo '</div>';

     echo '<div id="js_back_to_top">';
       echo '<a onclick="$(\'html,body\').animate({ scrollTop: 0 }, \'slow\'); return false;" href="">^<br>Back<br>To Top</a>';
     echo '</div>';
     addBackToTopHandler();
     echo '<input type="hidden" value="' . $current_page . '" name="current_page" id="current_page"/>';
     echo '<input type="hidden" value="' . $num_pages . '" name="num_pages" id="num_pages"/>';
     echo '<input type="hidden" value="' . $height_inc . '" name="height_inc" id="height_inc"/>';

     echo '<script type="text/javascript">
       $(document).ready(function() {
          rebigulate_paging_links("' . $div_name . '",' . $num_pages . ',' . $current_page . ',' . $height_inc . ');
          
       });
     </script>';
     
 echo '</div>';   
}

function activate_photo_cropper_old ($img_id, $img_name, $x1_name, $y1_name, $x2_name, $y2_name, $w_name, $h_name) {
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
            $(\'<div id="preview_div"><img id="preview_' . $img_id . '" src="' . ORIGINAL_IMAGE_PATH() . $img_name . '?' . time() . '" style="position: relative; display:none;" /><div>\')
                         .insertAfter($(\'img#photo_crop_' . $img_id . '\')); 


            $(\'img#photo_crop_' . $img_id . '\').imgAreaSelect({
                 persistent:true, persistent: ' . $persistent . ', resizable: ' . $resizable . ', aspectRatio: \'1:1\', onInit: preview, onSelectChange: preview, handles:true,x1:' . $initStartX . ',y1:' . $initStartY . ',x2:' . $initSizeX . ',y2:' . $initSizeY . '
                 
            });
          });

          
       </script>';
}

function activate_photo_cropper ($img_id, $img_name) {
  //$image = new SimpleImage();
  //$image->load(ORIGINAL_IMAGE_PATH() . $img_name);

  echo '<script type="text/javascript">
 
   	  var foo = new CROP(\'\');
	  foo.init(\'.photo_cropper_content\');
	  foo.loadImg("' . ORIGINAL_IMAGE_PATH() . $img_name . '?m=' . filemtime(ORIGINAL_IMAGE_PATH() . $img_name) . '");
 
	  $(document).on(\'click\', \'button\', function() {
                
		$.ajax({
			type: "post",
			dataType: "json",
			url: "' .get_full_domain() . '/chat/ajax_crop_photo.php",
			data: $.param(coordinates(foo)) + \'&imgName=' . $img_name . '&imgID=' . $img_id . '\'
		})
		.done(function(data) {
                        window.location.replace("' . get_full_domain () . '/main.php?the_page=psel&the_left=nav1&western=0&section=photos_selected");
 
		});  return false;
 
	  });

          $(\'.crop-img\').rotate(360);
 
        </script>
  ';
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
                                div_name = $("#boundry div:first-child").attr("id");
                                num_users = data.users_in.length;
                                height_inc = $("#boundry").height();
                                if ($("#view_pages").is(":visible")) {
                                  
                                  height_inc = maxHeight_inc(num_users);
                                  change_height_inc (height_inc);
                                  
                                }
                                
                                $("#view_all").attr("onClick","change_height_inc(maxHeight_inc(" + num_users + ")); change_num_pages (" + num_users + "); change_page( parseInt(1)); animate_page_turn(\'" + div_name + "\'); $(\'#view_pages\').show(); $(\'#view_all\').hide(); return false;");
                                $("#view_pages").attr("onClick","change_height_inc(792); change_num_pages (" + num_users + "); change_page( parseInt(1)); animate_page_turn(\'" + div_name + "\'); $(\'#view_all\').show(); $(\'#view_pages\').hide(); return false;");
                                change_num_pages (num_users);  
                                change_page(1);
                                animate_page_turn(div_name);
                                

                                
                                //alert("num_users: " + num_users + ", users_per_page: " + users_per_page + ", num_pages: " + num_pages);
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
