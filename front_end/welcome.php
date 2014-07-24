<?php
require_once "header.php"; 
//$guest_user_id = get_guest_user_id();
?>
 <div id="welcome">
    <!--<?php flare_title();?>-->
    <div id="header"> 
      Welcome to Starma.com. We're so glad you've joined our community!  Our site is still in development, so please <a href="mailto:contact@starma.com">contact us</a> if you encounter any problems.  Below are some of the ways you can get started.
    </div>
 
    <div id="horoscope_box_link_guest" class="homepage_div">
      <span class="header">Birth Chart Example</span>
      <a class="box_link" href="main.php?the_page=psel&the_left=nav1"></a>
      <div id="homepage_chart_button_info">
        <?php
         
          $button_sign_id = get_sign_from_poi (get_guest_chart_id($guest_user_id), 1);
          echo '<ul>';
          echo '  <li class="' . get_selector_name($button_sign_id) . ' selected"><span class="icon"><div class="poi_title">' . get_poi_name(1) . '</div></span></li>';
          echo '<div id="blurb">';
            show_poi_sign_blurb_abbr (1, $button_sign_id);
          echo '</div>';
          
          ?>
       
        <!--<div id="user_block">
           <div class="about_photo_wrapper"> 
            <div class="grid_photo_wrapper">
              <div class="grid_photo_border_wrapper profile_tiny">
                <div class="grid_photo">
         <div class="photo_border_wrapper_compare">
          <div class="compare_photo">
      
                  <?php show_user_compare_picture ('', get_my_user_id()); 
                    //show_tiny_photo(get_my_user_id());
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div> 
        </div>
        
        <?php //show_descriptors_info(get_my_chart_id()); 
                show_my_descriptors_info_home();
        ?>   
      </div> -->

      <div id="h_box_blurb"><p class="hsel_box_blurb">Learn details about your Sun Sign and more...</p></div>
    </div>
    </div>
    <div id="community_box_link" class="homepage_div">
      <span class="header">Explore the Community</span>
      <a class="box_link" href="main.php?the_page=cosel&the_left=nav1&the_tier=1"></a>
      <div id="homepage_thumbnails">
        <?php
          display_welcome_page_thumbnails(0, 1);
        ?>
      <div id="co_box_blurb"><p class="hsel_box_blurb">Make connections and test compatability...</p></div>
      </div>
    </div>

    <div id="horoscope_box_link" class="homepage_div">
      <span class="header">Compatibility Example</span>
      <a class="box_link" href="main.php?the_page=psel&the_left=nav1"></a>
      <div id="homepage_chart_button_info">
        <?php
         
        ?>
        <div id="h_box_blurb"><p class="hsel_box_blurb">See your compatibility with ...</p></div>
      </div>
    </div>

    <div id="celebrities_box_link" class="homepage_div">
      <span class="header">Browse Celebrities</span>
      <a class="box_link" href="main.php?the_page=cesel&the_left=nav1"></a>
      <div id="homepage_thumbnails">
        <?php
          display_welcome_page_thumbnails(1, 1);
        ?>
        <div id="ce_box_blurb"><p class="hsel_box_blurb">See what you have in common with the stars...</p></div>
      </div>
    </div>
 </div> 

