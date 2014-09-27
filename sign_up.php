<?php
require_once ("header.php");
?>
  
<body id="bg_stars" style="position:relative;">
	 <!--register_teaser_test-->
    <div id="msg_sheen" class="pop_test">
      <div id="msg_sheen_screen" class="pop_test"></div>
        <div style="position:absolute; z-index:100; top:10%; left:33%;">
          <?php               
            echo '<div id="sign_up_container" class="pop_test">';
              //show_sign_up_box_landing();
              //show_registration_box_landing();
            	if(isset($_GET['1'])) {
            		show_gender_location_box();
            	}
            	elseif (isset($_GET['2'])) {
            		show_3_words_photo_box();
            	}
            	elseif (isset($_GET['2_5'])) {	
            		show_crop_box();
            	}
            	elseif (isset($_GET['3'])) {
            		show_time_and_place_box();
            	}
            echo '</div>';
          ?>  
      </div>
    </div> <!--close msg_sheen-->    
    <!--end pop_guest_click-->
        <script type="text/javascript">
      
      $(document).ready(function(){
       
          $('.pop_test').show();
        
        $('button[name=sign_up_email]').click(function(){
          $('#sign_up_box').hide();
          $('#create_account').show();
          $('#username>input').focus();
        });
  
        $('#cancel_email_sign_up').click(function(){
          $('#sign_up_box').show();
          $('#create_account').hide();
        });
      });

    </script>

<div id="img_preloader">

  

  <img src="/img/Starma-Astrology-SideNav1.png"/>
  <img src="/img/Starma-Astrology-SideNav2.png"/>
  <img src="/img/Starma-Astrology-SideNav3.png"/>
  <img src="/img/Starma-Astrology-SideNav4.png"/>
  <img src="/img/Starma-Astrology-SideNav5.png"/>
  <img src="/img/Starma-Astrology-SideNav6.png"/>

  <img src="/img/Starma-Astrology-SideNav1On.png"/>
  <img src="/img/Starma-Astrology-SideNav2On.png"/>
  <img src="/img/Starma-Astrology-SideNav3On.png"/>
  <img src="/img/Starma-Astrology-SideNav4On.png"/>
  <img src="/img/Starma-Astrology-SideNav5On.png"/>
  <img src="/img/Starma-Astrology-SideNav6On.png"/>

  <img src="/img/sign_buttons/Starma-Astrology-Aries-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Taurus-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Gemini-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Cancer-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Leo-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Virgo-ON.png"/>

  <img src="/img/sign_buttons/Starma-Astrology-Libra-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Scorpio-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Sagittarius-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Capricorn-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Aquarius-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Pisces-ON.png"/>

</div>

<div id="frame">

  <div id="topnav">
    <ul>
      <li class="logo"><a href="#"></a></li>
      <li class="home_link selected"><a title="Home" href="#"><span>home</span></a></li>
      <li class="profile_link"><a title="Profile" href="#"><span>profile</span></a></li>
      <li class="compare_link"><a title="Community" href="#"><span>community</span></a></li>
      <li class="celeb_link"><a title="Celebrities" href="#"><span>celebrities</span></a></li>
      <li class="inbox_link"><a title="Inbox" href="#"><span>inbox</span></a></li>
      <li class="mail_area"><img src="/img/Starma-Astrology-Search.png"/></li>
    </ul>
     <div id="fake_invite">Invite a Friend</div>
  </div>

  <!--<img src="/img/top_nav_shorter/Starma-Astrology-SearchBar.png"/>-->

  <div id="sidenav">
    <ul>
      
      <li class="sidenav1 selected active"><a href="#">Welcome</a></li>
      <li class="sidenav2"><a href="#">About Astrology</a></li>
      <li class="sidenav3"><a href="#"></a></li>
      <li class="sidenav4"><a href="#"></a></li>
      <li class="sidenav5"><a href="#"></a></li>
      <li class="sidenav6"><a href="#"></a></li>
 
      <li class="bar_line"><img src="/img/Starma-Astrology-SideNav7.png"/></li>
    </ul>
  </div>
 
  <div id="logout_link">
    <!--<a href="/logout.php">Logout</a>-->
    <?php show_account_menu()?>
  </div>
 
  <div id="page_body">


 <div id="welcome">
    <!--<?php flare_title();?>-->
    <div id="header">
      Welcome to Starma.com. We're so glad you've joined our community!  Our site is still in development, so please <a href="#">contact us</a> if you encounter any problems.  Below are some of the ways you can get started.
    </div>
 
    <div id="profile_box_link" class="homepage_div">
      <span class="header">Complete Your Profile</span>
      <a class="box_link" href="#"></a>
      <div id="homepage_profile_button_info">
        <!--<div id="user_block">
           <div class="about_photo_wrapper"> 
            <div class="grid_photo_wrapper">
              <div class="grid_photo_border_wrapper profile_tiny">
                <div class="grid_photo">-->
         <div class="photo_border_wrapper_compare">
          <div class="compare_photo">
      
                  <?php //show_user_compare_picture ('', get_my_user_id()); 
                    //show_tiny_photo(get_my_user_id());
                  ?>
                <!--</div>
              </div>
            </div>
          </div>
        </div>--> 
        </div>
        
        <?php 
            //show_my_descriptors_info_home();
        ?>   
      </div>  
      <div id="p_box_blurb"><p class="hsel_box_blurb">Let others get to know your interests...</p></div>
    </div>
    </div>
    <div id="community_box_link" class="homepage_div">
      <span class="header">Explore the Community</span>
      <a class="box_link" href="#"></a>
      <div id="homepage_thumbnails">
        <?php
          //display_welcome_page_thumbnails($celebs=0);
        ?>
      <div id="co_box_blurb"><p class="hsel_box_blurb">Make connections and test compatability...</p></div>
      </div>
    </div>
    <div id="horoscope_box_link" class="homepage_div">
      <span class="header">Read Your Birth Chart</span>
      <a class="box_link" href="#"></a>
      <div id="homepage_chart_button_info">
        <?php
        /*
          $button_sign_id = get_sign_from_poi (get_my_chart_id(), 1);
          echo '<ul>';
          echo '  <li class="' . get_selector_name($button_sign_id) . ' selected"><span class="icon"><div class="poi_title">' . get_poi_name(1) . '</div></span></li>';
          echo '</ul>';
          echo '<div id="blurb">';
            show_poi_sign_blurb_abbr (1, $button_sign_id);
          echo '</div>';
          */
        ?>
        <div id="h_box_blurb"><p class="hsel_box_blurb">Learn details about your Sun Sign and more...</p></div>
      </div>
    </div>
    <div id="celebrities_box_link" class="homepage_div">
      <span class="header">Browse Celebrities</span>
      <a class="box_link" href="#"></a>
      <div id="homepage_thumbnails">
        <?php
          //display_welcome_page_thumbnails(1);
        ?>
        <div id="ce_box_blurb"><p class="hsel_box_blurb">See what you have in common with the stars...</p></div>
      </div>
    </div>
 </div> 



    
  </div>
  <?php
  //echo '<div id="msg_sheen" class="pop_invite">';
    //echo '<div id="msg_sheen_screen" class="pop_invite"></div>';
              //show_user_invite_top();
    //echo '<div style="width:100%; text-align:center; font-size:1.5em;"><strong>Invite A Friend</strong></div><br />';
  //echo '</div>';

    ?>

  <div id="clear"></div>

    
  </div>

  <!-- Footer -->
   <div id="footer">
    <div class="footer_links">
      <ul>
        <li>Starma<span class="small_symbol">&reg;</span> LLC 2014</li>
        <li><a href="#" target="_blank">Privacy Policy</a></li>
        <li><a href="#" target="_blank">Terms Of Use</a></li>
        <li><a href="#">Contact</a></li>
      </ul>  
    </div>
  </div>
  
  <!-- End Footer -->
 
</body>
</html>