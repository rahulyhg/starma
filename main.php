<?php
$pageTitle = 'Starma - Compatibility Horoscopes Community';
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
  
    function revokeFB() {
      FB.api(
      'me/permissions',
      'DELETE',
      function (response) {
        if (response && !response.error) {
            //console.log('delete');
            //console.log(response);
            var data = {'revokeFB' : 'revokeFB'};
            $.ajax({
              type : 'POST',
              url : '/chat/fb_data.php',
              data : data,
              dataType : 'json'
            })
            .done(function(data){
              console.log(data);
            });
          }
      });
    }
    function revokeFBSettings() {
      FB.api(
      'me/permissions',
      'DELETE',
      function (response) {
        //console.log('response: ');
        //console.log(response);
        if (response && !response.error) {
            console.log('delete');
            console.log(response);
            var data = {'revokeFB' : 'revokeFB'};
            $.ajax({
              type : 'POST',
              url : '/chat/fb_data.php',
              data : data,
              dataType : 'json'
            })
            .done(function(data){
              window.location.reload(true);
              console.log(data);
            });
          }
      });
    }

function sendDialogue () {
  FB.ui({
    method: 'send',
    link: 'https://www.starma.com',
  });
}

function statusChangeCallbackNTS(response) {
      //console.log('statusChangeCallback');
      //console.log(response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        var data = {'fb_friends' : true};

        $.ajax({
          type : 'POST',
          url : '/chat/fb_data.php',
          data : data,
          dataType : 'json'
        })
        .done(function(data){
          //console.log('data: ');
          //console.log(data);
          var fb_f = 0;
          //alert(data.fb_ids.length);
          //console.log('fb_ids: ');
          //console.log(data.fb_ids);
          var x = 0;
          var done = 0;
          for (i = 0; i < data.fb_ids.length; i++) {
            //console.log('data.fb_friends' + i + ': ');
            //console.log(data.fb_friends[i]);
        
            FB.api(
              '/me/friends/' + data.fb_ids[i].fb_id,
              function (response) {
                //console.log('full response: ');
                //console.log(response);
                  if (response != '' && !response.error) {
                    console.log('response: ');
                    console.log(response);
                    if (x == data.fb_ids.length) {
                      done = 1;
                    }
                    if (response['data'].length > 0) {
                      //console.log('response id: '); 
                      //console.log(response['data'][0].id);
                      $('#ajax_loader').remove();
                      var send_id = {'fb_f_loop_id' : response['data'][0].id};
                      $.ajax({
                        type: 'POST',
                        url: '/chat/fb_data.php',
                        data: send_id,
                        dataType: 'json',
                      })
                      .done(function(r){
                        $('#users_found').append(r.fb_friend);
                        fb_f++;
                        if (done == 1) {
                          if (fb_f > 0) {
                            $('#fb_f_invite').show().html('To invite more Facebook friends to join Starma, <span class="pointer" style="text-decoration: underline;" onClick="sendDialogue();">click here.</span>');
                          }
                        }
                        //$('#fb_f_empty').hide();
                      });
                      //id = response['data'][0].id;
                      //fb_f.push('hello');
                      //$('#s_results').append(data.fb_friends[i]);
                      //fb_f.push(data.fb_friends[i]);
                      //fb_f.push(response['data'][0].id);
                    }
                    else {
                      if (done == 1) {
                        if (fb_f == 0) {
                          $('#ajax_loader').remove();
                          $('#fb_f_invite').show().html('You currently have no Facebook friends on Starma.  To invite your Facebook friends, <span class="pointer" style="text-decoration: underline;" onClick="sendDialogue();">click here.</span>');
                        }
                      }
                    }                   
                  }
              }
            );
            x++;
          }        
        }); //close done function
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        //document.getElementById('status').innerHTML = 'Please log ' +
        //  'into this app.';
        fbLoginMain();
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        //document.getElementById('status').innerHTML = 'Please log ' +
        // 'into Facebook.';
      }
    }

/*

  function userExistFB() {
    var data = {'exist' : 'exist'};

    $.ajax({
      type: 'POST',
      url: '/chat/fb_data.php',
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
          $('#sign_up_box').hide();
          $('#create_account_fb').show();
          console.log(data.errors.exists);
        }
      }
      if (data.success) {
        window.location.reload(true);
      }
    });
  }
  */

  function assignIDSettings() {
    FB.api('/me', function(response) {
        //console.log('Successful login for: ' + response.name);
        //document.getElementById('status').innerHTML =
        //  'Thanks for logging in, ' + response.name + '!';
        var data = {'fb_id_settings' : response.id,
                    'reconnect_fb'   : 'reconnect_fb'
                  };

            $.ajax({
              type      : 'POST',
              url       : '/chat/fb_data.php',
              data      : data,
              dataType  : 'json'
            })
            .done(function(data){
              if (data.errors) {
                if (data.errors.set) {
                  console.log(data.errors.set);
                }
                if (data.errors.update_fb_id) {
                  console.log(data.errors.update_fb_id);
                }
              }
              if (data.success) {
                console.log(data.success);
                window.location.reload(true);
              }
              //alert(data.check);
              //console.log(data.fb_id);
              //userExistFB();
            });
      });
    }

    function fbLoginMain () {
    FB.login(function(response) {
    checkLoginState();
      // handle the response'
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        assignIDSettings();
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

    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
      //console.log('statusChangeCallback');
      //console.log(response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        FB.api(
          '/me/permissions',
          function (response) {
            if (response && !response.error) {
              //console.log('permissions');
              //console.log(response);
            }
        });
        //testAPI();
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

    function checkLoginStateNTS() {
      FB.getLoginStatus(function(response) {
        //console.log('accessToken');
        //console.log(response.authResponse.accessToken);
        statusChangeCallbackNTS(response);
      });
    }

    function fbLogout () {
      FB.logout();
    }

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '349967198448431',
        xfbml      : true,
        version    : 'v2.1',
        status     : true
      });

      //FB.getLoginStatus(function(response) {
      //  statusChangeCallback(response);
      //});
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

  </script>
  <script type="text/javascript" src="/js/fb_calls.js"></script>

  <?php
  echo '<div id="msg_sheen" class="pop_invite">';
    echo '<div id="msg_sheen_screen" class="pop_invite pop_close"></div>';
              show_user_invite();
  echo '</div>';
  ?>

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
  <img src="/img/Starma-Astrology-Profile-Pic-Small-Frame.png"/>
  

  <img src="/img/GoBug.png"/>
  <img src="/img/GoBugON.png"/>

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
      <li class="mail_area"><?php show_donate_button()?></li>
    </ul>
     <div class="later_on" id="pop_invite_top">Invite a Friend</div>
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


