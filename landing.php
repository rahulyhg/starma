<?php 

 require_once ("header.php");
 //if (!permissions_check ($req = 10)) {
 //   header( 'Location: http://www.' . $domain . '/underconstruction.php');
 //}  

if (isLoggedIn())
{
    
    // The user is already loggedin, so we check to see how much he's done
    if (isAdmin()) {
      //header( 'Location: http://www.' . $domain . '/index.php');
      do_redirect( $url = get_domain() . '/index.php'); 
    }
    else if (sign_up_process_done()) {
      //header( 'Location: http://www.' . $domain . '/index.php');
      if (isset($_SESSION["post_login_path"])) {
        $path = $_SESSION["post_login_path"];
        unset($_SESSION["post_login_path"]);
        do_redirect( $url = get_domain() . $path);
      }
      else {
        do_redirect( $url = get_domain() . '/main.php');
      }
    }
    else {
      //header( 'Location: http://www.' . $domain . '/process_login.php'); 
      do_redirect( $url = get_domain() . '/process_login.php');
    }
    //header( 'Location: http://' . $domain . '/index.php');

}

   
?>

<body id="body_landing">
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
      console.log('accessToken');
      console.log(response.authResponse.accessToken);
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
      //console.log('accessToken');
      //console.log(response.authResponse.accessToken);
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

  function fblogin () {
    FB.login(function(response) {
      // handle the response'
      if (response.status === 'connected') {
        //console.log('accessToken');
        //console.log(response.authResponse.accessToken);
        // Logged into your app and Facebook.
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
      }
    }, {scope: 'public_profile,email,user_friends'});
  }

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
      //document.getElementById('status').innerHTML =
      //  'Thanks for logging in, ' + response.name + '!';
    });
  }
    </script>
<script type="text/javascript" src="/js/browser_detect.js"></script>
<script type="text/javascript" src="/js/ajax_register.js"></script>
<script type="text/javascript" src="js/ajax_login.js"></script>
<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>


<div id="landing">

  <!--pop_landing_click-->
    <div id="msg_sheen" class="pop_landing">
      <div id="msg_sheen_screen_landing" class="pop_landing_click"></div>
        <div id="msg_sheen_content_landing" class="pop_landing">
          <?php 
            //show_registration_box_landing(); 
            show_forgot_password_box();
          ?>
        </div>
    </div>
  
  <?php //show_landing_logo();

  echo '<div id="logo_test">';
    echo '<div id="logo_test_img">';
      //echo '<img src="img/Logotest.png" height="240px" />';
      //echo '<!--[if lte IE 8]><img src="/img/Logotest.png" style="width:300px;" /><![endif]-->';
      //echo '<!--[if gt IE 8]><img src="/img/LogoTest2.svg" style="width:300px;" /><![endif]-->';
      //echo '<!--[if !IE]> --><img src="/img/LogoTest2.svg" style="width:300px;" /><!-- <![endif]-->';
    echo '</div>';
    echo '<div id="tagline"></div>';
    echo '<div id="landing_login_box">';
      show_login_box_landing();
    echo '</div>';
  echo '</div>'; //Close logo_test

  //echo '<div style="width:100%; min-width:900px;">';  //<!-- main page container -->
  
  //echo '<div style="position:absolute; width:100%;">';
  //echo '<div id="globe_and_footer">';
    echo '<div id="globe_landing">';
      echo '<div id="landing_sign_up_box">';
        show_sign_up_box_landing();
        show_registration_box_landing();
      echo '</div>';

    echo '</div>'; //close globe_landing

    echo '<div id="landing_footer">
          <div id="footer_links">
            <ul>
              <li><a class="padding_right">Starma LLC 2014</a></li>
              <li><a class="padding_right" title="Coming soon...">About Starma</a></li>
              <li><a class="padding_right" href="docs/privacyPolicy.htm" target="_blank">Privacy</a></li>
              <li><a class="padding_right" href="docs/termsOfUse.htm" target="_blank">Terms</a></li>
              <li><a href="mailto:contact@starma.com" title="contact@starma.com">Contact</a></li>
            </ul>
          </div>
          </div>';

  //echo '</div>'; // <!-- Close globe_and_footer -->

  //echo '</div>'; // Close wierd div



  //echo '<div id="explore_container">
    //      <div id="feet_bug"><a href="/guest/main.php"><span class="div_link"></span></a></div>
      //    <div id="explore"><a href="/guest/main.php" title="Explore Starma">Explore Starma</a></div>
        //</div>';

  echo '<script type="text/javascript" src="/js/landing_popup.js"></script>';
  echo '<script type="text/javascript" src="/js/ajax_forgot_password.js"></script>';

  echo '<div id="explore_container">
              <div id="feet_bug"><a href="/guest/main.php"><span class="div_link"></span></a></div>
              <div id="explore"><a href="/guest/main.php" title="Explore Starma">Explore Starma</a></div>
            </div>';
  

  echo '<div id="planet"><img src="/img/planet.png" /></div>';


  //echo '<div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>';

  echo '</div>'; //close main container

  
  //show_bugaboos();

?>
  <!--<div class="bg" id="sign_in">
    <div class="title">sign in</div>-->
    <!--<img src="img/account_info/Starma-Astrology-Sign-In-Boxes.png"/>-->
    <!--<div id="login_form">
          <form name="login" method="post" action="./process_login.php">
            <table>
              <tr>
                <td class="align_right">email</td><td><input type="text" name="email" value="<?php echo $_GET['email'];?>"/></td>
              </tr>
              <tr>
                <td class="align_right">password</td><td><input type="password" name="password"/></td>
              </tr>
              <tr>
                <td class="align_right"><input type="checkbox" name="stay_logged_in"></td><td class="info_font">keep me signed in</td>
              </tr>
              
              
            </table>
            <div id="login_button_div"><div id="go_bug_path"></div><input type="submit" id="bug_button" name="Login" value=""/></div>
            <div id="forgot_password">
              <a style="color:black;" href="lostpassword.php">forgot your password?</a>
            </div>
          </form>
      
     </div>
  </div>
  <div id="create_account_old">
    Not a member?<br>
    <?php flare_title ('<a style="color:black;" href="register.php">Create a FREE account!</a>');?>
    
  </div>
  -->
  <!--
  <div id="landing_footer">
   <div id="footer_links">
    <ul>
      <li><a>Starma LLC 2014</a></li>
      <li><a title="Coming soon...">About Starma</a></li>
      <li><a href="docs/privacyPolicy.htm" target="_blank">Privacy</a></li>
      <li><a href="docs/termsOfUse.htm" target="_blank">Terms</a></li>
      <li><a href="mailto:contact@starma.com" title="contact@starma.com">Contact</a></li>
    </ul>
   </div>
  </div>


</div> --> <!-- Close main page container -->

</div>  <!-- Close main landing -->
<div id="fb-root"></div>
  
<?php 
  //require_once ("landing_footer.php"); 
?>
  
  <?php //show_bugaboos();?>
  <?php 
         if (isset($_GET["error"])) {
           echo '<div class="landing_error">incorrect username or password</div>';
         }
   ?>
</div>

  

</body>
