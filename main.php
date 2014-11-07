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
  <script>
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log(response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        testAPI();
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        //document.getElementById('status').innerHTML = 'Please log ' +
        //  'into this app.';
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        //document.getElementById('status').innerHTML = 'Please log ' +
        // 'into Facebook.';
      }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        console.log('accessToken');
        console.log(response.authResponse.accessToken);
        statusChangeCallback(response);
      });
    }

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '349967198448431',
        xfbml      : true,
        version    : 'v2.1',
        status     : true
      });

      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function testAPI() {
      console.log('Welcome!  Fetching your information.... ');
      FB.api('/me', function(response) {
        console.log('Successful login for: ' + response.name);
        document.getElementById('status').innerHTML =
          'Thanks for logging in, ' + response.name + '!';
      });
    }

  </script>

  <?php
  echo '<div id="msg_sheen" class="pop_invite">';
    echo '<div id="msg_sheen_screen" class="pop_invite pop_close"></div>';
              show_user_invite();
  echo '</div>';


  echo '<script type="text/javascript" src="/js/pop_tuts.js"></script>';
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
<!--
  <img src="/img/Starma-Astrology-CelebritiesBoxH.png"/>
  <img src="/img/Starma-Astrology-ProfileBoxH.png"/>
  <img src="/img/Starma-Astrology-ChartBoxH.png"/>
  <img src="/img/Starma-Astrology-CompareBoxH.png"/>   
  -->

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
  <!--<img src="/img/Starma-Astrology-Compare-InviteON.png"/> -->

  <img src="/img/Starma-Astrology-Report-UserON.png"/> 

  <!--<img src="/img/profile/Starma-Astrology-Compare.png"/>
  <img src="/img/profile/Starma-Astrology-CompareON.png"/>-->
  <img src="/img/profile/Starma-Astrology-Message.png"/>
  <img src="/img/profile/Starma-Astrology-MessageON.png"/>
  <img src="/img/profile/Starma-Astrology-Chat.png"/>
  <img src="/img/profile/Starma-Astrology-ChatON.png"/>

  <img src="/img/profile/Starma-Astrology-Favorites.png"/>
  <img src="/img/profile/Starma-Astrology-FavoritesON.png"/>

  <img src="/img/GoBug.png"/>
  <img src="/img/GoBugON.png"/>

  <img src="/img/hl_nav_icon_1.png"/>
  <img src="/img/hl_nav_icon_1ON.png"/>
  <img src="/img/hl_nav_icon_2.png"/>
  <img src="/img/hl_nav_icon_2ON.png"/>
  <img src="/img/hl_nav_icon_3.png"/>
  <img src="/img/hl_nav_icon_3ON.png"/>
  <img src="/img/hl_nav_icon_4.png"/>
  <img src="/img/hl_nav_icon_4ON.png"/>
  <img src="/img/hl_nav_icon_5.png"/>
  <img src="/img/hl_nav_icon_5ON.png"/>
  <img src="/img/hl_nav_icon_6.png"/>
  <img src="/img/hl_nav_icon_6ON.png"/>
  <img src="/img/hl_nav_icon_7.png"/>
  <img src="/img/hl_nav_icon_7ON.png"/>
  <img src="/img/hl_nav_icon_7.png"/>
  <img src="/img/hl_nav_icon_7ON.png"/>
  <img src="/img/hl_nav_icon_8.png"/>
  <img src="/img/hl_nav_icon_8ON.png"/>
  <img src="/img/hl_nav_icon_9.png"/>
  <img src="/img/hl_nav_icon_9ON.png"/>
  <img src="/img/hl_nav_icon_10.png"/>
  <img src="/img/hl_nav_icon_10ON.png"/>
  <img src="/img/hl_nav_icon_11.png"/>
  <img src="/img/hl_nav_icon_11ON.png"/>
  <img src="/img/hl_nav_icon_12.png"/>
  <img src="/img/hl_nav_icon_12ON.png"/>

  <img src="/img/houseIcon_1.png"/>
  <img src="/img/houseIcon_2.png"/>
  <img src="/img/houseIcon_3.png"/>
  <img src="/img/houseIcon_4.png"/>
  <img src="/img/houseIcon_5.png"/>
  <img src="/img/houseIcon_6.png"/>
  <img src="/img/houseIcon_7.png"/>
  <img src="/img/houseIcon_8.png"/>
  <img src="/img/houseIcon_9.png"/>
  <img src="/img/houseIcon_10.png"/>
  <img src="/img/houseIcon_11.png"/>
  <img src="/img/houseIcon_12.png"/>
  
  <img src="/img/palanquin_1.png" />
  <img src="/img/palanquin_2.png" />
  <img src="/img/palanquin_3.png" />
  <img src="/img/palanquin_4.png" />
  <img src="/img/palanquin_5.png" />
  <img src="/img/palanquin_6.png" />
  <img src="/img/palanquin_7.png" />
  <img src="/img/palanquin_8.png" />
  <img src="/img/palanquin_9.png" />
  <img src="/img/palanquin_10.png" />
  <img src="/img/palanquin_11.png" />
  <img src="/img/palanquin_12.png" />

</div>

<div id="frame">

  <div id="topnav">
    <ul>
      <li class="logo"><a href="?the_page=hsel&the_left=nav1"></a></li>
      <li class="home_link <?php echo $hsel;?>"><a title="Home" href="?the_page=hsel&the_left=nav1"><span>Home</span></a></li>
      <li class="profile_link <?php echo $psel;?>"><a title="Profile" href="?the_page=psel&the_left=nav1"><span>Profile</span></a></li>
      <li class="compare_link <?php echo $cosel;?>"><a title="Community" href="?the_page=cosel&the_left=nav1&tier=1"><span>Community</span></a></li>
      <li class="celeb_link <?php echo $cesel;?>"><a title="Celebrities" href="?the_page=cesel&the_left=nav1&tier=1"><span>Celebrities</span></a></li>
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
<div id="fb-root"></div>
<script type="text/javascript" src="/js/magnific.js"></script>
<script type="text/javascript" src="/js/photos_ui.js"></script>
</body>
</html>
<?php ob_flush(); ?>


