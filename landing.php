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

<body>

<div id="img_preloader">
  <img src="/img/account_info/Starma-Astrology-Space-BugHover.png"/>  
</div>


<div id="landing">
  
  <?php show_landing_logo();?>
  <div class="bg" id="sign_in">
    <div class="title">sign in</div>
    <!---<img src="img/account_info/Starma-Astrology-Sign-In-Boxes.png"/>--->
    <div id="login_form">
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
            <div id="login_button_div"><input type="submit" id="bug_button" name="Login" value=""/></div>
          </form>
      
     </div>
  </div>
  <div id="create_account">
    Not a member?<br>
    <?php flare_title ('<a style="color:black;" href="register.php">Create a FREE account!</a>');?>
  </div>
  <div id="forgot_password">
    <a style="color:black;" href="lostpassword.php">forgot your password?</a>
  </div>
  
  
  
  
  <?php show_bugaboos();?>
  <?php 
         if (isset($_GET["error"])) {
           echo '<div class="landing_error">incorrect username or password</div>';
         }
   ?>
</div>


<?php 
  require_once ("landing_footer.php"); 
?>
</body>
