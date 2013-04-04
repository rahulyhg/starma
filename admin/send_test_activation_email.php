<?php 

 require_once ("../header.php");
 //require_once ("db_connect.php");

  if (!isAdmin()) {
    header( 'Location: http://www.' . get_domain() . '/' . get_landing());
  }  
  else {
    echo '<body>';
    if (isset($_POST["submit"])) {
       //echo '*' . $_POST["invite_email"] . '*';
      if (sendActivationEmail($_POST["invite_email"], 'Tester', 'Dummy', 123456, 123456)) {
        echo '<span style="color:red">Test Activation Email Sent!</span>';
      }
      else { 
        echo '<span style="color:red">ERROR Sending Invite!</span>'; 
      }
    }
    echo '<div class="page_title">Send Test Activation Email</div>';
    echo '<br><hr><br>';
    
    echo '<form name="send_form" method="post" action="send_test_activation_email.php">';
    echo 'Email Address: <input type="text" name="invite_email" value=""/><br>';
    echo '<input type="submit" name="submit" value="Send"/>';
    echo '</form>';

    echo '<br><br>';
    echo '<a href="../">Go Back To Chart Management</a>';
    echo '</body>';
  }

   require_once ("../footer.php");
  
?>