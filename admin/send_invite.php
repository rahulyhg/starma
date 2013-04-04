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
      if (send_invite ($_POST["invite_email"], $_POST["to_line"], create_token($_POST["to_line"]))) {
        echo '<span style="color:red">Invite Sent!</span>';
      }
      else { 
        echo '<span style="color:red">ERROR Sending Invite!</span>'; 
      }
    }
    echo '<div class="page_title">Send Invite</div>';
    echo '<br><hr><br>';
    
    echo '<form name="send_form" method="post" action="send_invite.php">';
    echo 'Name of recipient: <input type="text" name="to_line" value=""/><br>';
    echo 'Email Address: <input type="text" name="invite_email" value=""/><br>';
    echo '<input type="submit" name="submit" value="Send"/>';
    echo '</form>';

    echo '<br><br>';
    echo '<a href="../">Go Back To Chart Management</a>';
    echo '</body>';
  }

   require_once ("../footer.php");
  
?>