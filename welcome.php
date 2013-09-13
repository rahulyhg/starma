<?php
require_once "header.php"; 
?>



 <div id="welcome">
    <?php flare_title("Welcome");?>
    <div id="header">
      Welcome to Starma.com. We're so glad you've joined our community!  Our site is still in development, so please <a href="mailto:contact@starma.com">contact us</a> if you encounter any problems.  Below are some of the ways you can get started.
    </div>
 
    <div id="profile_box_link" class="homepage_div">
      <span>Profile</span>
      <a class="box_link" href="main.php?the_page=psel&the_left=nav1"></a>
      <div id="homepage_profile_button_info">
        <div class="user_block">
          <div class="photo_border_wrapper_compare"><div class="compare_photo">
      
            <?php show_user_compare_picture ('', get_my_user_id()); ?>
            
          </div></div>
        </div>
        <?php show_descriptors_info(get_my_chart_id()); ?>
      </div>
    </div>
    <div id="community_box_link" class="homepage_div">
      <span>Community</span>
      <a class="box_link" href="main.php?the_page=cosel&the_left=nav1&the_tier=1"></a>
      <div id="homepage_thumbnails">
        <?php
          display_welcome_page_thumbnails($celebs=0);
        ?>
      </div>
    </div>
    <div id="horoscope_box_link" class="homepage_div">
      <a class="box_link" href="main.php?the_page=psel&the_left=nav1"></a>
    </div>
    <div id="celebrities_box_link" class="homepage_div">
      <span>Celebrities</span>
      <a class="box_link" href="main.php?the_page=cesel&the_left=nav1"></a>
      <div id="homepage_thumbnails">
        <?php
          display_welcome_page_thumbnails(1);
        ?>
      </div>
    </div>
 </div> 

