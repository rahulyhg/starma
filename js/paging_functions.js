         


         function change_page(page_number) {
           current_page = parseInt($("#current_page").val());
           num_pages = parseInt($("#num_pages").val());
           if (page_number < 1) {
              page_number = 1;
           }
           if (page_number > num_pages) {
              page_number = num_pages;
           }
           $("#current_page").val(page_number);
           
         } 

         function maxHeight_inc (num_users) {
           return (Math.ceil(num_users / 4)) * 198;
         }      

         function change_height_inc (height_inc) {
           
           if (height_inc < 198) {
              page_number = 198;
           }
           $("#height_inc").val(height_inc);
           $("#boundry").animate({"height":height_inc + "px"});
         }

         function change_num_pages (num_users) {
           height_inc = $("#height_inc").val();
           users_per_page = Math.ceil(height_inc / 198) * 4; // CONSTANTS HERE
           num_pages = Math.ceil(num_users/users_per_page);
           $("#num_pages").val(num_pages);
         }

         function animate_page_turn(div_name) {
           current_page = parseInt($("#current_page").val());
           num_pages = parseInt($("#num_pages").val());
           height_inc = parseInt($("#height_inc").val());
           
           $("#" + div_name).animate({"margin-top":((-1) * height_inc * (current_page-1)) +"px"}); //TURN TO THE RIGHT PAGE AND SET THE RIGHT HEIGHT
                     
 
           rebigulate_paging_links(div_name, num_pages, current_page, height_inc);
           
         }

         function rebigulate_paging_links(div_name, num_pages, current_page, height_inc) {
           //alert("got here");
           

           if (num_pages <= 1) {
             $("#paging_links").hide();
           }
           else {
                                  
             $("#paging_links").show();

             $("#right_end_most").attr("onClick","change_page(" + parseInt(num_pages) + "); animate_page_turn('" + div_name + "'); return false;");

             //HIDE EVERYTHING
             $("#left_end").hide();
             $("#left_elip").hide();
             $("#right_end").hide();
             $("#right_elip").hide();

             
             //LEFT END
             if (num_pages == 5 || num_pages == 4) {
               if (current_page == 5 || current_page == 4) { 
                 

                 $("#left_end").attr("onClick","change_page(" + parseInt(1) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#left_end").text(1);             
                 $("#left_end").show(); 
                 if (num_pages == 5) {
                   $("#left_elip").attr("onClick","change_page(" + parseInt(2) + "); animate_page_turn('" + div_name + "'); return false;");
                   $("#left_elip").text(2);
                   $("#left_elip").show();   
                 }
               }

               else if (current_page == 3) { 
                 

                 $("#left_elip").attr("onClick","change_page(" + parseInt(1) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#left_elip").text(1);             
                 $("#left_elip").show(); 
                 if (num_pages == 5) {
                   $("#right_elip").attr("onClick","change_page(" + parseInt(5) + "); animate_page_turn('" + div_name + "'); return false;");
                   $("#right_elip").text(5);
                   $("#right_elip").show();   
                 }
               }
 
               else if (current_page == 2 || current_page == 1) { 
                 $("#right_elip").attr("onClick","change_page(" + parseInt(4) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#right_elip").text(4);             
                 $("#right_elip").show(); 
                 if (num_pages == 5) {
                   $("#right_end").attr("onClick","change_page(" + parseInt(5) + "); animate_page_turn('" + div_name + "'); return false;");
                   $("#right_end").text(5);             
                   $("#right_end").show(); 
                 }
  
                 
                   
               }

               

             }
             else if (num_pages == 4) {
                $("#right_end").attr("onClick","change_page(" + parseInt(4) + "); animate_page_turn('" + div_name + "'); return false;");
                $("#right_end").text(4);             
                $("#right_end").show();
             }
             
           
  
             //LINK BEHIND
             if (current_page > 1) {
               if (current_page == num_pages && num_pages >= 3) {
                 $("#link_way_behind").attr("onClick","change_page(" + parseInt(current_page-2) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#link_way_behind").text(current_page-2);
                 $("#link_way_behind").show();

               }
               else {
                 $("#link_way_behind").hide();
               }
               $("#link_behind").attr("onClick","change_page(" + parseInt(current_page-1) + "); animate_page_turn('" + div_name + "'); return false;");
               $("#link_behind").text(current_page-1);
               $("#link_behind").show();
             }
             else {
               $("#link_behind").hide();
               $("#link_way_behind").hide();
             }
          
             // LINK CURRENT
             $("#link_current").attr("onClick","change_page(" + parseInt(current_page) + "); animate_page_turn('" + div_name + "'); return false;");
             $("#link_current").text(current_page);

             // LINK AHEAD
             if (current_page < num_pages) {   
               $("#link_ahead").attr("onClick","change_page(" + parseInt(current_page+1) + "); animate_page_turn('" + div_name + "'); return false;");
               $("#link_ahead").text(current_page+1);
               $("#link_ahead").show();
               if (current_page == 1 && num_pages >= 3) {
                 $("#link_way_ahead").attr("onClick","change_page(" + parseInt(current_page+2) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#link_way_ahead").text(current_page+2);
                 $("#link_way_ahead").show();
               }
               else {
                 $("#link_way_ahead").hide();
               }
             }
             else {
               $("#link_ahead").hide();
               $("#link_way_ahead").hide();
             }
          
             //RIGHT END
             
             if (current_page <= (num_pages - 4) && num_pages > 5) {

               $("#right_elip").attr("onClick","return false;");
               $("#right_elip").text('...');             
               $("#right_elip").show(); 
  
               $("#right_end").attr("onClick","change_page(" + parseInt(num_pages) + "); animate_page_turn('" + div_name + "'); return false;");
               $("#right_end").text(num_pages);
               $("#right_end").show(); 
             }
             else if (num_pages > 5) {
               if (current_page == num_pages - 3) { 
                 

                 $("#right_elip").attr("onClick","change_page(" + parseInt(num_pages-1) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#right_elip").text(num_pages-1);             
                 $("#right_elip").show(); 
  
                 $("#right_end").attr("onClick","change_page(" + parseInt(num_pages) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#right_end").text(num_pages);
                 $("#right_end").show();   
               }

               else if (current_page == num_pages - 2) { 
                 

                 $("#left_elip").attr("onClick","change_page(" + parseInt(num_pages-4) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#left_elip").text(num_pages-4);             
                 $("#left_elip").show(); 
  
                 $("#right_end").attr("onClick","change_page(" + parseInt(num_pages) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#right_end").text(num_pages);
                 $("#right_end").show();   
               }
 
               else if (current_page == num_pages - 1 || current_page == num_pages) { 
                 $("#left_end").attr("onClick","change_page(" + parseInt(num_pages-4) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#left_end").text(num_pages-4);             
                 $("#left_end").show(); 

                 $("#left_elip").attr("onClick","change_page(" + parseInt(num_pages-3) + "); animate_page_turn('" + div_name + "'); return false;");
                 $("#left_elip").text(num_pages-3);             
                 $("#left_elip").show(); 
  
                 
                 $("#right_end").hide();   
               }

               

             } 
             

           }

         }
      
