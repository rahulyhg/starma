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
  echo '<script type="text/javascript">
 
          function preview(img, selection) {
                 var scaleX = 153 / (selection.width || 1);
                 var scaleY = 153 / (selection.height || 1);
  
                 $(\'img#preview_' . $img_id . '\').css({
                     display: \'block\',
                     width: Math.round(scaleX * 114) + \'px\',
                     height: Math.round(scaleY * 153) + \'px\',
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
            $(\'<div><img id="preview_' . $img_id . '" src="img/user/' . $img_name . '" style="position: relative; display:none;" /><div>\')
                    .css({
                            top: \'50px\',
                            position: \'relative\',
                            overflow: \'hidden\',
                            width: \'153px\',
                            height: \'153px\'
                         })
                         .insertAfter($(\'img#photo_crop_' . $img_id . '\')); 


            $(\'img#photo_crop_' . $img_id . '\').imgAreaSelect({
                 aspectRatio: \'1:1\', onSelectChange: preview
                 
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
/*
function include_skin_ajax () {
 echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>  

   <script type="text/javascript">  

     function add_handlers_to_skins () {
       $(function() {  

       $(".skin_confirm").click(function() {  
         
         var bp_sk_string    =  $(this).parent().attr("class"); 
 
         var bp_id               =  bp_sk_string.substring(2, bp_sk_string.indexOf("sk"));  
        
         var sk_id              =  bp_sk_string.substring(bp_sk_string.indexOf("sk")+2);

         var pic_src            =  $(this).children("img:first").attr("src");

         // forming the queryString  
         
         //body_part_name = "head";

         switch (bp_id) {
             case "1":  body_part_name="head"; break;  
             case "2":  body_part_name="body"; break;
             case "3":  body_part_name="rarm"; break;
             case "4":  body_part_name="larm"; break;
             case "5":  body_part_name="legs"; break;
             case "6":  body_part_name="feet"; break;
         }
         
         var data            = "body_part_id=" + bp_id + "&skin_id=" + sk_id;         
  
         if (sk_id == 0) {
             pic_src = "images/skins/" + body_part_name + "_blank.png";
         }         

             // ajax call  

             $.ajax({  

                 type: "POST",  

                 url: "set_skin.php",  

                 data: data,  

                 

                success: function(html){ // this happens after we get results  

                     $("#" + body_part_name).append(html);

                     $("#" + body_part_name).children("a:first").children("img:first").attr("src", pic_src);                    

                     $("#skin_select").hide();  

                       

               }  

             });  

           

         //return false;  

     });  

 });
}

    
$(function() {  

    

     $(".skin_click").click(function() {  
         
         var body_part_name    =  $(this).parent().attr("id"); 
 
         var top               =  $(this).parent().position().top - 5;  
        
         var left              =  $(this).parent().position().left + 60;

         // forming the queryString  
         
         //var body_part_id = 1;

         switch (body_part_name) {
             case "head":  body_part_id=1; break;  
             case "body":  body_part_id=2; break;
             case "rarm":  body_part_id=3; break;
             case "larm":  body_part_id=4; break;
             case "legs":  body_part_id=5; break;
             case "feet":  body_part_id=6; break;
         }
         
         var data            = "body_part_id=" + body_part_id;         
         
         

         // if searchString is not empty  
           

             // ajax call  

             $.ajax({  

                 type: "POST",  

                 url: "get_skins.php",  

                 data: data,  

                 beforeSend: function(html) { // this happens before actual call  

                       $("#skin_list").html("");
    
                       $("#skin_select").css({left: left, top: top});

                       $(".skin_confirm").unbind();
                       
                          

                 },  

                success: function(html){ // this happens after we get results  

                     $("#skin_list").append(html);
 
                     add_handlers_to_skins();                    

                     $("#skin_select").show();  

                       

               }  

             });  

           

         //return false;  

     });  


 });  

 </script>';



}
*/

?>
