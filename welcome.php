<?php
require_once "header.php"; 
?>



 <div id="welcome">
 <?php
 //echo my_compare_flag();
  /*
    echo '<script>
      $(document).ready(function(){
        $("#tfb").click(function(event){
          event.preventDefault();
          var data = {"test" : "test"};
          $.ajax({
            type: "POST",
            url: "/chat/test_fb_insert.php",
            data: data,
            dataType: "json"
          })
          .done(function(data){
            if (data.errors) {
              if (data.errors.update) {
                console.log(data.errors.update);
              }
              if (data.errors.get) {
                console.log(data.errors.get);
              }
            }
            if (data.fb_id) {
              console.log(data.fb_id);
            }            
          });
        });
      });
    </script>';
     echo '<div id="tfb">fb test</div>';
     echo $_SESSION['fb_id'];
    */
     
 ?>
    <!--<?php flare_title();?>-->
    <div class="later_on welcome_text">
      Welcome to Starma!  Our site is still in development, so please <a href="mailto:contact@starma.com">contact us</a> if you encounter any problems.  Below are some of the ways you can get started.
    </div>
 
    <div id="profile_box_link" class="homepage_div">
      <span class="header">Complete Your Profile</span>
      <a class="box_link" href="main.php?the_page=psel&the_left=nav1&western=0&section=about_selected"></a>
      <div id="homepage_profile_button_info">
        <!--<div id="user_block">
           <div class="about_photo_wrapper"> 
            <div class="grid_photo_wrapper">
              <div class="grid_photo_border_wrapper profile_tiny">
                <div class="grid_photo">-->
         <div class="photo_border_wrapper_compare">
          <div class="compare_photo">
      
                  <?php show_user_compare_picture ('', get_my_user_id()); 
                    //show_tiny_photo(get_my_user_id());
                  ?>
                <!--</div>
              </div>
            </div>
          </div>
        </div>--> 
        </div>
        
        <?php //show_descriptors_info(get_my_chart_id()); 
                show_my_descriptors_info_home();
        ?>   
      </div>  
      <div id="p_box_blurb"><p class="hsel_box_blurb">Let others get to know your interests...</p></div>
    </div>
    </div>
    <div id="community_box_link" class="homepage_div">
      <span class="header">Explore the Community</span>
      <a class="box_link" href="main.php?the_page=cosel&the_left=nav1&tier=1"></a>
      <div id="homepage_thumbnails">
        <?php
          display_welcome_page_thumbnails($celebs=0);
        ?>
      </div>
      <div id="co_box_blurb"><p class="hsel_box_blurb">Make connections and test compatability...</p></div>
    </div>
    <div id="horoscope_box_link" class="homepage_div">
      <span class="header">Read Your Birth Chart</span>
      
        <?php
        echo '<a class="box_link ';
          if (!get_my_chart()) {
            echo 'no_chart" href="#"';
          }
          else {
            echo '" href="main.php?the_page=psel&the_left=nav1"';
          }
        echo '></a>
                <div id="homepage_chart_button_info">';
          if (!get_my_chart()) {
            echo 'Enter your birth time to get your birth chart';
          }
          else {
            $button_sign_id = get_sign_from_poi (get_my_chart_id(), 1);
            echo '<ul>';
            echo '  <li class="' . get_selector_name($button_sign_id) . ' selected"><span class="icon"><div class="poi_title">' . get_poi_name(1) . '</div></span></li>';
            echo '</ul>';
            echo '<div id="blurb">';
              show_poi_sign_blurb_abbr (1, $button_sign_id);
            echo '</div>';
          }
          
        ?>
        <div id="h_box_blurb"><p class="hsel_box_blurb">Learn details about your Sun Sign and more...</p></div>
      </div>
    </div>
    <div id="celebrities_box_link" class="homepage_div">
      <span class="header">Browse Celebrities</span>
      <a class="box_link" href="main.php?the_page=cesel&the_left=nav1&tier=1"></a>
      <div id="homepage_thumbnails">
        <?php
          display_welcome_page_thumbnails(1);
        ?>
      </div>
      <div id="ce_box_blurb"><p class="hsel_box_blurb">See what you have in common with the stars...</p></div>
    </div>
 </div> 

