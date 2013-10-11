<?php
//require_once "Mail.php";


 
##### Mail functions #####
function email_profile_block ($user_id) {
  $block = '
  <div style="position:relative; display:block; margin:auto; width: 71px; padding-bottom:20px;">
  <div style="background: url(\'/img/Starma-Astrology-Profile-Pic-Small-Frame.png\') no-repeat scroll 0 0 #D3DBF6;
              border-spacing: 4px 4px;
              display: table-cell;
              height: 71px;
              width: 71px;
              z-index: 1;">
    <div style="background-color: #000000;
	        border-spacing: 0;
		display: table-cell;
	        height: 63px;
		overflow: hidden;
	        text-align: center;
	        vertical-align: middle;
                width: 63px;">
       <a style="display: block; width: 63px; border-spacing: 0; text-align:center" href="' . get_full_domain () . '/main.php?the_page=cosel&the_left=nav1&tier=3&stage=2&chart_id1=' . get_my_user_id() . '&chart_id2=' . chart_already_there("Main", $user_id) . '">
         <img src="/img/user/thumbnail/thumb_' . get_main_photo($user_id) . '">
       </a>
    </div>
  </div>
  </div>';
  return $block;
}

function email_suggestions_block () {
  $my_info = my_profile_info();
  $age = calculate_age(substr((string)$my_info['birthday'], 0, 10));
  $user_list = get_weighted_user_list ($age-5, $age+5);
  $user_array = add_scores ($user_list);
  $user_array = quicksort_users($user_array);
  $old_user_array = array();
  foreach ($user_array as $user) {
    if ($user["score"] >= 0.82) {
      $old_user_array[] = $user;
    }
  }
  $new_user_array = array();
  //pick 3 random ones
  $same_gender_added = 0;
  while (sizeof($new_user_array) < 3 and sizeof($old_user_array) > 0) {
    $random_index = array_rand($old_user_array);
    $new_item_array = array_splice($old_user_array, $random_index, 1);
    
    if (get_my_gender() != get_gender($new_item_array[0]["user_id"]) or $same_gender_added == 0) {
      $new_user_array[] = $new_item_array[0];
      if (get_my_gender() == get_gender($new_item_array[0]["user_id"])) {
        $same_gender_added = $same_gender_added + 1;
      }
    }
    
   
  }  


  echo '
  <div bgcolor="#8393CA" style="margin:0;padding:0;border:0">
    <div style="background:#D3DBF6;margin:0 auto;width: 455px; text-align:center;" align="center" bgcolor="#D3DBF6" border="0">
      <div>Suggested Matches For You</div> 
      <ul style="list-style: none outside none; padding: 0;">';
         foreach ($new_user_array as $user) {
           echo '<li style="display:block">' . email_profile_block($user["user_id"]) .'</li>';
         }
  echo'
        
      </ul>
    </div>
  </div>
  ';
}

function send_invite ($email, $to_line, $token)
{
 
    
    $message = '
Dear Friends and Family,<br>
<br>
We are very excited to invite you to participate in the test launch of our labor of love, Starma.com!  As many of you know, we have been working on this project for over a year and a half, and we are thrilled to be at the stage of development where we are finally ready to share it with you.  We ask that, at this stage, you simply play with the site and let us know if you find any broken links, error messages, pictures that don\'t load properly, and so on.  As the site moves towards completion, we will be asking for more detailed feedback, including your thoughts on user experience, interface, layout, etc.  Until then, check out the "what we\'re up to" tab on our home page.  
<br><br>
Here are the instructions for creating your account:<br>
1. Go to https://www.starma.com<br> 
2. Click on "Create a FREE account"<br>
3. Enter your personal information and token: ' . $token . '<br>
4. Verify your account.  (note: the verification email is likely to land in your Junk Mail)<br>
5. Log in and enjoy!<br>
<br>
We deeply appreciate your participation and support, and we warmly welcome you to the ground level of a brand new community!';


    if (sendMail($email, "Starma Alpha Test Invite", $message, "contact@starma.com"))
    {
        return true;
    } else
    {
        return false;
    }
 
 
}


function sendLostPasswordEmail($email, $newpassword)
{
 
    global $domain;
    $message = "
You have requested a new password on http://www.$domain/,<br>
<br> 
Your new password information:<br>
<br> 
username:  $email<br>
password:  $newpassword<br>";
 
    if (sendMail($email, "Your password has been reset.", $message, "no-reply@$domain"))
    {
        return true;
    } else
    {
        return false;
    }
 
 
}

function sendNewMessageEmail($sender_id, $receiver_id, $message)
{
 
    $sender = basic_user_data($sender_id);
    $receiver = basic_user_data($receiver_id);
    $message = $receiver["nickname"] . ' - <Br><Br>' . $sender["nickname"] . ' has sent you a personal message on Starma.com.  <a href="' . get_full_domain () . '/main.php?the_page=isel&the_left=nav1&other_user_id=' . $sender_id . '">Click Here</> to view it!';
 
    if (sendMail($receiver["email"], "You have received a new message from " . $sender["nickname"] . "!" , $message, "no-reply@" . get_domain()))
    {
        return true;
    } else
    {
        return false;
    }
 
 
}

function sendComparedAlertEmail($user_id, $number)
{
 
    $sender = basic_user_data($user_id);
    $message = 'Hello ' . $sender["nickname"] . ',<br><br>' . $number . ' new people have compared themselves to you this week. <a href="' . get_full_domain() . '/main.php?the_page=cosel&the_left=nav1&the_tier=1">Login</a> to see who you\'re compatible with.';
 
    if (sendMail($sender["email"], $number . " people have compared themselves to you this week!" , $message, "no-reply@" . get_domain()))
    {
        return true;
    } else
    {
        return false;
    }
}


 
function testSendingMail ($to, $subject, $message, $from) {
  echo "Attempting to send mail: <br><br>";
  echo "To: " . $to . '<br>';
  echo "From: " . $from . '<br>';
  echo "Subject: " . $subject . '<br>';
  echo "Message: " . $message . '<br><br>';
  //return mail($to, $subject, $message, 'From: ' . $from);
  return sendMail($to, $subject, $message, $from);
}

function sendMail($to, $subject, $message, $from)
{
    
    $mail = new PHPMailer(); 
   
    $mail->IsSMTP(); // send via SMTP

    $mail->SMTPAuth   = false;
    $mail->Host = 'relay-hosting.secureserver.net';
    $mail->SMTPDebug = 1;
//    $mail->exceptions = false;

//GMAIL SETTINGS//
//    $mail->SMTPDebug = 1;
//    $mail->SMTPAuth   = true;    
//    $mail->Host = 'ssl://smtp.gmail.com';
//    $mail->Port = 465;
    //$mail->SMTPSecure = "tls";    
//    $mail->Username = "teamstarma@gmail.com"; // SMTP username
//    $mail->Password = "squirreltime"; // SMTP password
//////////////////

    $webmaster_email = $from; //Reply to this email ID
    $email=$to; // Recipients email ID
    
    $mail->From = $webmaster_email;
    $mail->FromName = "Starma";
    $mail->AddAddress($email);
    $mail->AddReplyTo($webmaster_email);
    $mail->WordWrap = 50; // set word wrap
    $mail->IsHTML(true); // send as HTML
    $mail->Subject = $subject;
    $mail->Body = $message . '<br><br>Sincerely,<br>The Starma Team'; //HTML Body
    $mail->AltBody = $message; //Text Body
    $mail->AddBCC("teamstarma@gmail.com");
    
    //$mail->Send();
   
    //return true;
   
    if($mail->Send())
    {
       return true;
    }
    else
    {
       log_this_action (account_action_email(), error_basic_action());
       //echo "Mailer Error: " . $mail->ErrorInfo;
       return false;
    }
    
    return false;
}

 
function sendActivationEmail($email, $nickname, $password, $uid, $actcode)
{
    global $domain;
    //$link = "http://www.$domain/activate.php?uid=$uid&actcode=$actcode";
    $link = "https://www." . get_domain() . "/activate.php?uid=$uid&actcode=$actcode";
    $message = "
Thank you for registering on https://www.$domain/,
<br><br> 
Your account information:
<br><br> 
username:  $email<br>
password:  $password<br>
<br><br>
Please click the link below to activate your account.
<br><br> 
$link";
 
    if (sendMail($email, "Please activate your account.", $message, "contact@starma.com"))
    {
        return true;
    } else
    {
        return false;
    }
}

/*

function sendMail($to, $subject, $message, $from)
{
  
 
 
 $host = "relay-hosting.secureserver.net";
 //$host = "mail.mycer.com";
 $username = "contact@matthewticciati";
 $password = "1through9";
 
 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $mailer = new Mail();
 $smtp = $mailer->factory('smtp',
   array ('host' => $host,
     'auth' => true,
     'SMTPAuth' => false,
     'username' => $username,
     'password' => $password,
     'port' => '25'));
 
 $mail = $smtp->send($to, $headers, $message);
 
 $pear = new PEAR();
 
 if ($pear->isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");

   return false;
  } else {
   //echo("<p>Message successfully sent!</p>");
   return true;
  }
}
*/
 
?>