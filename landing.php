<?php 

 require_once ("header.php");
 //if (!permissions_check ($req = 10)) {
 //   header( 'Location: http://www.' . $domain . '/underconstruction.php');
 //}  

 echo '<script type="text/javascript">

            $(document).ready(function(){
              $("input[name=email]").focus();
            });

          </script>';

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
<script type="text/javascript" src="/js/browser_detect.js"></script>
<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>


<div id="landing">

  <!--pop_landing_click-->
    <div id="msg_sheen" class="pop_landing">
      <div id="msg_sheen_screen" class="pop_landing_click"></div>
        <div id="msg_sheen_content_guest" class="pop_landing">
          <?php 
            show_registration_box_landing(); 
            show_forgot_password_box();
          ?>
        </div>
    </div>
  
  <?php //show_landing_logo();

  echo '<div id="logo_test">';
    echo '<div id="logo_test_img">';
      //echo '<img src="img/Logotest.png" height="240px" />';
      echo '<!--[if lte IE 8]><img src="/img/Logotest.png" /><![endif]-->
            <!--[if gt IE 8]><img src="/img/LogoTest.svg" /><![endif]-->
            <!--[if !IE]> --><img src="/img/LogoTest.svg" /><!-- <![endif]-->';
    echo '</div>';
    echo '<div id="tagline">Compatibility - Horoscopes - Community</div>';
    echo '<div id="landing_login_box">';
      show_login_box_landing();
    echo '</div>';
  echo '</div>'; //Close logo_test

  echo '<div style="width:100%; min-width:1150px;">';  //<!-- Close main page container -->

  echo '<div id="landing_sign_up_box">';
    show_sign_up_box_landing();
    //show_registration_box_landing();
  echo '</div>';

  echo '<div id="explore"><a href="/guest/main.php" title="Explore Starma">Explore Starma</a></div>';

  echo '<script type="text/javascript" src="/js/landing_popup.js"></script>';
  echo '<script type="text/javascript" src="/js/ajax_forgot_password.js"></script>';


  echo '<div id="landing_footer">
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


</div> <!-- Close main page container -->';

  
  show_bugaboos();

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
