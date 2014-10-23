<?php
require_once ("header.php");

  
login_check_point($type="full");

if (!isset($_GET["the_page"])) {
  $the_page = "hsel";
}
else {
  $the_page = $_GET["the_page"];
}

 $left_menu = get_left_menu ($the_page = $the_page);

 $hsel = "";
 $psel = "";
 $csel = "";
 $cesel = "";
 $cosel = "";
 $isel = "";


 $$the_page = "selected";

if (!isset($_GET["the_left"])) {
  $the_left = "nav1";
}
else {
  $the_left = $_GET["the_left"];
}

if ($the_left=="nav1") {
  clean_session();
}

//if ($the_page == "psel" and !is_my_profile_done()) {
//  $the_left = get_my_profile_step();
//}

 $nav1 = "";
 $nav2 = "";
 $nav3 = "";
 $nav4 = "";
 $nav5 = "";
 $nav6 = "";

 $$the_left = "selected";
 if (isset($_GET["chart_id2"])) {
   $chart_id2_holder = $_GET["chart_id2"];
 }
 elseif (isset($_POST["chart_id2"])) {
   $chart_id2_holder = $_POST["chart_id2"];   
 }
 elseif (isset($_SESSION['compare_chart_ids'])) {
   $chart_id2_holder = $_SESSION['compare_chart_ids'][1];
   
 }
 else {
   $chart_id2_holder = -1;
 }
/*
 if ($chart_id2_holder != -1) {
   
   if (isCeleb(get_user_id_from_chart_id($chart_id2_holder))) {
      
      $$the_left = "";
      $nav3 = "selected";  
   }
 }
*/

?> 

<!-- Include he following conditional to get click-throughs to work with IE -->
    
    <!--[if IE]>
      <style type="text/css">
 
        .circle_hilite {
          filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/img/arrows/RedCircle_chart.png', sizingMethod='scale');
          background:none !important;
        }
 
        </style>
    <![endif]-->
    
<body id="bg_stars">

  <?php
  echo '<div id="msg_sheen" class="pop_invite">';
    echo '<div id="msg_sheen_screen" class="pop_invite pop_close"></div>';
              show_user_invite();
  echo '</div>';

    ?>

<div id="img_preloader">

  <img src="/js/ajax_loader_sign_up.gif" />

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

  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Aquarius-Leo-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Cancer-Capricorn-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Aries-Libra-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Capricorn-Cancer-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Gemini-Sagittarius-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Leo-Aquarius-ON.png"/>

  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Libra-Aries-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Pisces-Virgo-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Sagittarius-Gemini-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Scorpio-Taurus-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Taurus-Scorpio-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Virgo-Pisces-ON.png"/>

  <img src="/img/Starma-Astrology-CelebritiesBoxH.png"/>
  <img src="/img/Starma-Astrology-ProfileBoxH.png"/>
  <img src="/img/Starma-Astrology-ChartBoxH.png"/>
  <img src="/img/Starma-Astrology-CompareBoxH.png"/>   

  <img src="/img/sign_buttons_tall/Starma-Astrology-Aries-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Taurus-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Gemini-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Cancer-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Leo-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Virgo-Tall-ON.png"/>

  <img src="/img/sign_buttons_tall/Starma-Astrology-Libra-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Scorpio-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Sagittarius-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Capricorn-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Aquarius-Tall-ON.png"/>
  <img src="/img/sign_buttons_tall/Starma-Astrology-Pisces-Tall-ON.png"/>

  <img src="/img/sign_buttons_tall/Starma-Astrology-Unknown-Tall-ON.png"/>  
  <img src="/img/sign_buttons_tall/Starma-Astrology-Unknown-Tall-OFF.png"/> 

  <img src="/img/Starma-Astrology-Pillar.png"/> 
  <img src="/img/Starma-Astrology-Pillar-Arrow.png"/> 
  <img src="/img/Starma-Astrology-Pillar-Broken.png"/> 
  <img src="/img/Starma-Astrology-Pillar-Broken-Arrow.png"/> 
  <img src="/img/Starma-Astrology-Pillars-Top.png"/> 
  <img src="/img/Starma-Astrology-Pillars-Base.png"/> 

  <img src="/img/Starma-Astrology-Compare-ButtonON.png"/> 
  <img src="/img/Starma-Astrology-Compare-InviteON.png"/> 

  <img src="/img/Starma-Astrology-Report-UserON.png"/> 

  <img src="/img/profile/Starma-Astrology-Compare.png"/>
  <img src="/img/profile/Starma-Astrology-CompareON.png"/>
  <img src="/img/profile/Starma-Astrology-Message.png"/>
  <img src="/img/profile/Starma-Astrology-MessageON.png"/>
  <img src="/img/profile/Starma-Astrology-Chat.png"/>
  <img src="/img/profile/Starma-Astrology-ChatON.png"/>

  <img src="/img/profile/Starma-Astrology-Favorites.png"/>
  <img src="/img/profile/Starma-Astrology-FavoritesON.png"/>

  <img src="/img/goBug.png"/>
  <img src="/img/goBugON.png"/>


</div>

<div id="frame">

  <!--register_teaser_test
    <div id="msg_sheen" class="pop_test">
      <div id="msg_sheen_screen" class="pop_test pop_reg"></div>
        <div style="position:absolute; z-index:100; top:30%; left:45%;">
          <?php               
            //echo '<div id="landing_sign_up_box" class="pop_test">';
              show_sign_up_box_landing();
              show_registration_box_landing();
            //echo '</div>';
          ?>  
      </div>
    </div> close msg_sheen   
    <script type="text/javascript" src="/js/ajax_register.js"></script>
    end pop_guest_click-->
   
    
    <!--
    <script type="text/javascript">
      
      $(document).ready(function(){
        $('#pop_test').click(function(){
          $('.pop_test').show();
        });
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
  -->

  <div id="topnav">
    <ul>
      <li class="logo"><a href="?the_page=hsel&the_left=nav1"></a></li>
      <li class="home_link <?php echo $hsel;?>"><a title="Home" href="?the_page=hsel&the_left=nav1"><span>Home</span></a></li>
      <li class="profile_link <?php echo $psel;?>"><a title="Profile" href="?the_page=psel&the_left=nav1"><span>Profile</span></a></li>
      <li class="compare_link <?php echo $cosel;?>"><a title="Community" href="?the_page=cosel&the_left=nav1&the_tier=1"><span>Community</span></a></li>
      <li class="celeb_link <?php echo $cesel;?>"><a title="Celebrities" href="?the_page=cesel&the_left=nav1"><span>Celebrities</span></a></li>
      <li class="inbox_link <?php echo $isel;?>"><a title="Inbox" href="?the_page=isel&the_left=nav1"><span>Inbox</span></a></li>
      <li class="mail_area"></li>
    </ul>
     <div id="pop_invite_top">Invite a Friend</div>
  </div>

  <!--<img src="/img/top_nav_shorter/Starma-Astrology-SearchBar.png"/>-->

  <div id="sidenav">
    <ul>
      
      <li class="sidenav1 <?php echo $nav1;?> <?php echo menu_status($left_menu['nav1'][1]);?>"><a href="?the_left=nav1&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav1'][0];?></a></li>
      <li class="sidenav2 <?php echo $nav2;?> <?php echo menu_status($left_menu['nav2'][1]);?>"><a href="?the_left=nav2&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav2'][0];?></a></li>
      <li class="sidenav3 <?php echo $nav3;?> <?php echo menu_status($left_menu['nav3'][1]);?>"><a href="?the_left=nav3&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav3'][0];?></a></li>
      <li class="sidenav4 <?php echo $nav4;?> <?php echo menu_status($left_menu['nav4'][1]);?>"><a href="?the_left=nav4&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav4'][0];?></a></li>
      <li class="sidenav5 <?php echo $nav5;?> <?php echo menu_status($left_menu['nav5'][1]);?>"><a href="?the_left=nav5&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav5'][0];?></a></li>
      <li class="sidenav6 <?php echo $nav6;?> <?php echo menu_status($left_menu['nav6'][1]);?>"><a href="?the_left=nav6&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav6'][0];?></a></li>
 
    <li class="bar_line"><img src="/img/Starma-Astrology-SideNav7.png"/></li> 
    </ul>
    <!--<div id="pop_test">Reg Test</div>-->
  </div>
 
  <div id="logout_link">
    <!--<a href="/logout.php">Logout</a>-->
    <?php show_account_menu()?>
  </div>
 
  <div id="page_body">
    <?php
      if ($left_menu[$the_left][1] != '#') {
         require($left_menu[$the_left][1]);
      }
      
    ?>
  </div>
  <?php
  //echo '<div id="msg_sheen" class="pop_invite">';
    //echo '<div id="msg_sheen_screen" class="pop_invite"></div>';
      //        show_user_invite();
  //echo '</div>';

    ?>

  <div id="clear"></div>

    
  </div>

  <!-- Footer -->
   <div id="footer">
    <div class="footer_links">
      <ul>
        <li>Starma<span class="small_symbol">&reg;</span> LLC 2014</li>
        <li><a href="docs/privacyPolicy.htm" target="_blank">Privacy Policy</a></li>
        <li><a href="docs/termsOfUse.htm" target="_blank">Terms Of Use</a></li>
        <li><a href="mailto:contact@starma.com">Contact</a></li>
      </ul>  
    </div>
  </div>
  
  <!-- End Footer -->

<!--<script type="text/javascript">
  
  $(document).ready(function(){
    $('select').addClass('styled_select');
  });

</script>-->

<?php
 require_once "footer.php";
?> 

<script type="text/javascript" src="/js/magnific.js"></script>
<script type="text/javascript" src="/js/photos_ui.js"></script>
</body>
</html>
<?php ob_flush(); ?>


