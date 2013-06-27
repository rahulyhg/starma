   

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

         function animate_page_turn(div_name) {
           current_page = parseInt($("#current_page").val());
           num_pages = parseInt($("#num_pages").val());
           height_inc = parseInt($("#height_inc").val());
           
           $("#" + div_name).animate({"margin-top":((-1) * height_inc * (current_page-1)) +"px"});
           rebigulate_paging_links(div_name, num_pages, current_page, height_inc);
           
         }

         function rebigulate_paging_links(div_name, num_pages, current_page, height_inc) {
           //alert("got here");
           

           if (num_pages <= 1) {
             $("#paging_links").hide();
           }
           else {
                                  
             $("#paging_links").show();
             //LEFT END
             if (current_page >= 3 && num_pages > 3) {
               $("#left_end").show();
                         
               if (current_page >= 4) {
                 $("#left_elip").show();
               }
               else {
                 $("#left_elip").hide();
               }
             }
             else {
               $("#left_end").hide();
               $("#left_elip").hide();
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
             if (current_page <= (num_pages - 2) && num_pages > 3) {
               if (current_page <= (num_pages - 3)) {
                 $("#right_elip").show(); 
               }
               else {
                 $("#right_elip").hide(); 
               }
               $("#right_end").attr("onClick","change_page(" + parseInt(num_pages) + "); animate_page_turn('" + div_name + "'); return false;");
               $("#right_end").text(num_pages);
               $("#right_end").show(); 
             }
             else {
               $("#right_end").hide();
               $("#right_elip").hide(); 
             }
     

           }

         }
      
