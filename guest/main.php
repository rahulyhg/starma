<?php
$pageTitle = 'Starma.com - Compatibility Horoscopes Community';
if (isset($_GET['the_page'])) {
  if ($_GET['the_page'] == 'cesel') {
    if (isset($_GET['chart_id2'])) {
      require_once ('../include/db_connect.inc.php'); // include the database connection
      require_once("../include/user.functions.inc.php");
      
      $celeb_user_id = get_user_id_from_chart_id($_GET['chart_id2']);
      $celeb_profile = profile_info($celeb_user_id);
      $pageTitle = $celeb_profile['first_name'] . ' ' . $celeb_profile['last_name'] . ' Birth Chart';
    }
  }
}

require_once ("header.php");
 
// IF YOU ARE ALREADY LOGGED IN, THEN GET KICKED THE FUCK OUT
//Lord_Starmeow is user_id 371
//Lady_Starmeow is user_id 372
if(isLoggedin()) {
  do_redirect (get_domain());
}
else {

$guest_user_id = get_guest_user_id();
//echo $guest_user_id;
if (!isset($_GET["the_page"])) {
  $the_page = "hsel";
}
else {
  $the_page = $_GET["the_page"];
}

 $left_menu = get_left_menu_guest ($the_page = $the_page);

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
}

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

    //GUEST SIGN UP LOGIN--------------------------------------

function sendIDGuest() {
    FB.api('/me', function(response) {
        //console.log('Successful login for: ' + response.name);
        //document.getElementById('status').innerHTML =
        //  'Thanks for logging in, ' + response.name + '!';
        var data = {'fb_id' : response.id};

            $.ajax({
              type      : 'POST',
              url       : '../chat/fb_data.php',
              data      : data,
              dataType  : 'json'
            })
            .done(function(data){
              //alert(data.check);
              //console.log(data.fb_id);
              userExistFBGuest();
            });
      });
  }

  function assignIDGuest() {
    FB.api('/me', function(response) {
        //console.log('Successful login for: ' + response.name);
        //document.getElementById('status').innerHTML =
        //  'Thanks for logging in, ' + response.name + '!';
        var data = {'fb_id' : response.id};

            $.ajax({
              type      : 'POST',
              url       : '../chat/fb_data.php',
              data      : data,
              dataType  : 'json'
            })
            .done(function(data){
              //alert(data.check);
              //console.log(data.fb_id);
              userExistFBGuest();
            });
      });
  }

  function userExistFBGuest() {
    var data = {'exist' : 'exist'};

    $.ajax({
      type: 'POST',
      url: '../chat/fb_data.php',
      data: data,
      dataType: 'json'
    })
    .done(function(data){
      //console.log(data.user);
      if (data.errors) {
        if (data.errors.user_id) {
          console.log(data.errors.user_id);
        }
        if (data.errors.exists) {
          $('#fb_or_email_login_guest').hide();
          $('#create_account_fb').show();
          console.log(data.errors.exists);
        }
      }
      if (data.success) {
        window.location.reload(true);
      }
    });
  }

  function fbSignUpGuest () {
    FB.login(function(response) {
    checkLoginState();
      // handle the response'
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        sendIDGuest();
        $('#fb_or_email_guest').hide();
        $('#create_account_fb').show();
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        setTimeout(checkLoginState(), 1000);
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        setTimeout(checkLoginState(), 1000);
      }
    }, {scope: 'public_profile,email,user_friends'});
  }
  function fbLoginGuest () {
    FB.login(function(response) {
    checkLoginState();
      // handle the response'
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        assignIDGuest();
        //userExistFB();
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        //setTimeout(fbLogin(), 1000);
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        //setTimeout(fbLogin(), 1000);
      }
    }, {scope: 'public_profile,email,user_friends'});
  }

  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      //testAPI();
      //sendID();
    } 
    else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      //document.getElementById('status').innerHTML = 'Please log ' +
      //  'into this app.';
      //setTimeout('checkLoginState()', 1000);
    } 
    else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      //document.getElementById('status').innerHTML = 'Please log ' +
      // 'into Facebook.';
      //setTimeout('checkLoginState()', 1000);
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
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

    </script>
  <!--pop_guest_click-->
    <div id="msg_sheen" class="pop_guest">
      <div id="msg_sheen_screen" class="pop_guest pop_reg"></div>
        <div id="msg_sheen_content_guest" class="pop_guest">
          <?php      
            //show_intro_box_guest();         
            show_sign_up_box_guest();
            show_fb_or_email_box_guest();
            show_registration_box_guest();
            show_fb_registration_box_guest();
          ?>  
        </div> <!--close msg_sheen_content_guest-->
    </div> <!--close msg_sheen-->    
    <!--end pop_guest_click-->


    <!--pop_guest_login-->
    <div id="msg_sheen" class="pop_login">   
      <div id="msg_sheen_screen" class="pop_login pop_log"></div>
        <div id="msg_sheen_content_guest" class="pop_login">
          <?php          
            //show_fb_or_email_login_box_guest();     
            show_login_box_guest();
            show_forgot_password_box_guest();
          ?>  
        </div> <!--close msg_sheen_content_guest-->
    </div> <!--close msg_sheen-->
    <!--end pop_guest_click-->

<div id="img_preloader">
  
  <img src="/js/ajax_loader_sign_up.gif" />
<!--
  <img src="/img/Starma-Astrology-SideNav1.png"/>
  <img src="/img/Starma-Astrology-SideNav2.png"/>
  <img src="/img/Starma-Astrology-SideNav3.png"/>
  <img src="/img/Starma-Astrology-SideNav4.png"/>
  <img src="/img/Starma-Astrology-SideNav5.png"/>
  <img src="/img/Starma-Astrology-SideNav6.png"/>
-->
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

  <img src="/img/sign_buttons/Starma-Astrology-Blur-OFF" />
  <img src="/img/sign_buttons/Starma-Astrology-Blur-ON" />

  <img src="/img/Starma-Astrology-CelebritiesBoxH.png"/>
  <img src="/img/Starma-Astrology-ProfileBoxH.png"/>
  <img src="/img/Starma-Astrology-ChartBoxH.png"/>
  <img src="/img/Starma-Astrology-CompareBoxH.png"/>   

  <img src="/img/GoBug.png"/>
  <img src="/img/GoBugON.png"/>
   
</div>


<div id="frame">

  <div id="topnav">
    <ul>
      <li class="logo"><a href="../landing.php"></a></li>
      <li class="home_link <?php echo $hsel;?>"><a title="Home" href="?the_page=hsel&the_left=nav1"><span>Home</span></a></li>
      <li class="profile_link <?php echo $psel;?>"><a title="Profile" href="?the_page=psel&the_left=nav1"><span>Profile</span></a></li>
      <li class="compare_link <?php echo $cosel;?>"><a title="Community" href="?the_page=cosel&the_left=nav1&tier=1"><span>Community</span></a></li>
      <li class="celeb_link <?php echo $cesel;?>"><a title="Celebrities" href="?the_page=cesel&the_left=nav1&tier=1"><span>Celebrities</span></a></li>
      <li class="inbox_link <?php echo $isel;?>"><a title="Inbox" href="?the_page=isel&the_left=nav1"><span>Inbox</span></a></li>
      <!--<li class="mail_area"><img src="/img/Starma-Astrology-Search.png"/></li>-->
    </ul>
    <div id="register_top">Sign Up</div><div id="login_top" class="pop_guest_login">Log In</div>
  </div>

  <div id="sidenav">
    <ul>
      
      <li class="sidenav1 <?php echo $nav1;?> <?php echo menu_status($left_menu['nav1'][1]);?>"><a class="<?php echo $left_menu['nav1'][2];?>" href="?the_left=nav1&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav1'][0];?></a></li>
      <li class="sidenav2 <?php echo $nav2;?> <?php echo menu_status($left_menu['nav2'][1]);?>"><a class="<?php echo $left_menu['nav2'][2];?>" href="?the_left=nav2&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav2'][0];?></a></li>
      <li class="sidenav3 <?php echo $nav3;?> <?php echo menu_status($left_menu['nav3'][1]);?>"><a class="<?php echo $left_menu['nav3'][2];?>" href="?the_left=nav3&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav3'][0];?></a></li>
      <li class="sidenav4 <?php echo $nav4;?> <?php echo menu_status($left_menu['nav4'][1]);?>"><a class="<?php echo $left_menu['nav4'][2];?>" href="?the_left=nav4&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav4'][0];?></a></li>
      <li class="sidenav5 <?php echo $nav5;?> <?php echo menu_status($left_menu['nav5'][1]);?>"><a class="<?php echo $left_menu['nav5'][2];?>" href="?the_left=nav5&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav5'][0];?></a></li>
      <li class="sidenav6 <?php echo $nav6;?> <?php echo menu_status($left_menu['nav6'][1]);?>"><a class="<?php echo $left_menu['nav6'][2];?>" href="?the_left=nav6&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav6'][0];?></a></li>
 
      <li class="bar_line"><img src="/img/Starma-Astrology-SideNav7.png"/></li>
    </ul>
    <div id="register_side"><img src="/img/create-an-account.png" title="Create an Account" /></div>
    <!--<div id="login_side" class="pop_guest_login">Log In</div>-->
  </div>
 
 
  <div id="page_body">
    <?php
      if ($left_menu[$the_left][1] != '#' && $left_menu[$the_left][1] != '') {
         require($left_menu[$the_left][1]);
      }
      
    ?>
  </div>
  
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
</body>
</html>
<?php ob_flush(); ?>


