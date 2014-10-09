<?php
require_once "header.php"; 
//$guest_user_id = get_guest_user_id();
$guest_user_id = get_guest_user_id();
$guest_chart_id = get_guest_chart_id($guest_user_id);
?>
 <div id="welcome">
    <!--<?php flare_title();?>-->
    <div id="header"> 
      Welcome to Starma.com. We're so glad you've joined our community! �Our site is still in development, so please <a href="#" class="pop_guest_click">contact us</a> if you encounter any problems.  Below are some of the ways you can get started.
    </div>
 
    <div id="horoscope_box_link_guest" class="homepage_div">
      <span class="header">Birth Chart Example</span>
      <a class="box_link" href="main.php?the_page=psel&the_left=nav1"></a>
      <div id="homepage_chart_button_info">
        <?php
         
          $button_sign_id = get_sign_from_poi ($guest_chart_id, 1);
          echo '<ul>';
          echo '  <li class="' . get_selector_name($button_sign_id) . ' selected"><span class="icon"><div class="poi_title">' . get_poi_name(1) . '</div></span></li>';
          echo '<div id="blurb">';
            show_poi_sign_blurb_abbr (1, $button_sign_id);
          echo '</div>';
          
          ?>

      <div id="h_box_blurb_guest"><p class="hsel_box_blurb">Learn details about your Sun Sign and more...</p></div>
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

    <div id="compatibility_sample_link" class="homepage_div">
      <span class="header">Compatibility Example</span>
      <a class="box_link" href="<?php echo '?the_page=cosel&the_left=nav1&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=861&from_profile=true'; ?>"></a>
      <div id="homepage_compare_sample">
        <div id="sample_compare_results">
        <div style="margin:auto; width:273px;">
        <div id="homepage_compare_thumb_left">
          <div class="grid_photo_border_wrapper">
            <div class="grid_photo">
                <?php
                  show_user_inbox_picture('', $guest_user_id);
                ?>
              </div>
            </div>
        </div>

        <div id="sample_compare_stars">
          <img src="../img/Starma-Astrology-Compare-Star-Small.png" />
          <img src="../img/Starma-Astrology-Compare-Star-Small.png" />
          <img src="../img/Starma-Astrology-Compare-Star-Small.png" />
          <img src="../img/Starma-Astrology-Compare-Star-Small.png" />
          <img src="../img/Starma-Astrology-Compare-Star-Small.png" />
        </div>

        <div id="homepage_compare_thumb_right">
          <div class="grid_photo_border_wrapper">
            <div class="grid_photo">
              <?php
                show_user_inbox_picture('', 372);
              ?>
            </div>
          </div>
        </div>
      </div>
      </div>  <!--Close sample_compare_results-->

      <!--sample compare text-->
      <div id="sample_compare_text">The Compatibility Chart is based on a combination of many factors, and if you want a clear picture it is important to...</div>

        <div id="co_box_blurb_guest"><p class="hsel_box_blurb">See a sample compatibility test...</p></div>
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
