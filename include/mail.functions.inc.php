<?php

## CONSTANTS ##
function CONTACT_US() { return 'contact@starma.com'; }
function CURRENT_YEAR() { return date('Y'); }

##### Mail functions #####
function email_profile_block ($user_id) {
  $block = '
  <div style="position:relative; display:block; margin:auto; width: 71px; padding-bottom:20px;">
  <div style="background: url(\'' . get_full_domain () . '/img/Starma-Astrology-Profile-Pic-Small-Frame.png\') no-repeat scroll 0 0 #D3DBF6;
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
         <img src="' . get_full_domain () . '/img/user/thumbnail/thumb_' . get_main_photo($user_id) . '">
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


  $returnString = '
  <div bgcolor="#8393CA" style="margin:0;padding:0;border:0">
    <div style="background:#D3DBF6;margin:0 auto;width: 455px; text-align:center;" align="center" bgcolor="#D3DBF6" border="0">
      <div>Suggestions For You</div> 
      <ul style="list-style: none outside none; padding: 0;">';
         foreach ($new_user_array as $user) {
           $returnString = $returnString . '<li style="display:block">' . email_profile_block($user["user_id"]) .'</li>';
         }
  $returnString = $returnString . '
        
      </ul>
    </div>
  </div>
  ';

  return $returnString;
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

//MATT INVITE USER
/*
function send_invite_user ($first_name, $last_name, $their_name, $email, $personal_message, $sender_id) {
  global $domain;


  $full_name = get_my_full_name();
  if(!($full_name) || trim($full_name) == ""){
    update_my_full_name($first_name, $last_name);
    $full_name = get_my_full_name();
    
  }
  
  $gender = get_my_gender();
  if($gender == 'M') {
    $gender = 'him';
  }
  elseif($gender == 'H') {
    $gender = 'her';
  }
  else {
    $gender = 'them';
  }

  $message = 'Dear ' . $their_name . ',
  <br/><br/> 

  ' . $full_name . ' has invited you to join ' . $gender . ' on <a href="https://www.starma.com" title="www.starma.com">Starma</a>, a free astrology site that is easy to use and understand. Read about your Birth Chart, and see your compatibility with friends, family, lovers, and colleagues...even celebrities. <br /><br />';

  if($personal_message != '') {
    $message = $message . ' ' . $personal_message;
  }

  $footer = '<br /><br /><div style="font-size: .75em;">You received this message because ' . $full_name . ' invited ' . $email . ' to join Starma. </div>';

  if(sendMail($email, $full_name . " invited you to join Starma", $message, "no-reply@" . get_email_domain(), $footer)) {
    $data_1 = log_user_invite($sender_id, $email, $message);
    log_this_action (blogosphere_action_user(), invited_basic_action(), $data_1);
    return true;
  }
  else {
    return false;
  }

}

*/

/*
function sendLostPasswordEmail($email, $newpassword)
{
 
    
    $message = "
You have requested a new password on http://www." . get_domain() . "/,<br>
<br> 
Your new password information:<br>
<br> 
username:  $email<br>
password:  $newpassword<br>";
 
    if (sendMail($email, "Your password has been reset.", $message, "no-reply@" . get_email_domain()))
    {
        return true;
    } else
    {
        return false;
    }
 
 
}
*/

/*
function sendReportUserEmail($sender, $reported_user, $message) {
  $send_to = 'mticciati@gmail.com';
  //$content = array(
    //              'reciever' => 'Matthew',
      //            'link' => '<a href="' . get_full_domain () . '/main.php?the_page=isel&the_left=nav1&other_user_id=53">Click Here</a>'
        //        );
  if (sendMail($send_to, 'User ' . $sender . ' is reporting ' . $reported_user, $message, 'no-reply@' . get_email_domain())) {
  //if (
   //$result = sendTemplateMessage($send_to, 'report test template mandrill', $content, "no-reply@" . get_email_domain());
    return true;
  }
  else {
    return false;
  }
}
*/

//MANDRILL DYNAMIC CONTENT TEMPLATE ----------------------

function sendReportUserEmail($sender, $reported_user, $message) {
  $send_to = 'mticciati@gmail.com';
  $content = $message;
  
  if (sendTemplateReport($send_to, 'Reported User', $content, "no-reply@" . get_email_domain())) {
    return true;
  }
  else {
    return false;
  }
}

function sendNewMessageEmail($sender_id, $receiver_id, $message) {
 
    $sender = basic_user_data($sender_id);
    $receiver = basic_user_data($receiver_id);
    $content = array(
                  'receiver' => $receiver['nickname'],
                  'link' => '<a href="' . get_full_domain () . '/main.php?the_page=isel&the_left=nav1&other_user_id=' . $receiver_id . '">Click Here</a>',
                  'sender' => $sender["nickname"]
                );
    //$message = $receiver["nickname"] . ' - <Br><Br>' . $sender["nickname"] . ' has sent you a personal message on Starma.com.  <a href="' . get_full_domain () . '/main.php?the_page=isel&the_left=nav1&other_user_id=' . $sender_id . '">Click Here</a> to view it!';
     
    if(sendTemplateMessage($receiver["email"], $sender["nickname"] . " sent you a message on Starma!" , $content, "no-reply@" . get_email_domain())) {
    
        return true;
    } 
    else {
        return false;
    }
  
}

function send_invite_user ($first_name, $last_name, $their_name, $email, $personal_message, $sender_id) {
  global $domain;


  $full_name = get_my_full_name();
  if(!($full_name) || trim($full_name) == ""){
    update_my_full_name($first_name, $last_name);
    $full_name = get_my_full_name();
    
  }
  
  $gender = get_my_gender();
  if($gender == 'M') {
    $gender = 'him';
  }
  elseif($gender == 'H') {
    $gender = 'her';
  }
  else {
    $gender = 'them';
  }

  $message = 'Hi ' . $their_name . ',
  <br/><br/> 

  ' . $full_name . ' has invited you to join ' . $gender . ' on <a href="https://www.starma.com" title="www.starma.com">Starma</a>, a free astrology site that is easy to use and understand. Read about your Birth Chart, and see your compatibility with friends, family, lovers, and colleagues...even celebrities. <br /><br />';

  if($personal_message !== '') {
    list($their_first_name, $their_last_name) = split(' ', $their_name);
    $message = $message . ' ' . $first_name . ' says: ' . $personal_message;
  }

  $footer = '<br /><br /><div style="font-size: .75em;">You received this message because ' . $full_name . ' invited ' . $email . ' to join Starma. </div>';

  if(sendTemplateInvite($email, $full_name . " invited you to join Starma", $message, "no-reply@" . get_email_domain(), $footer)) {
    $data_1 = log_user_invite($sender_id, $email, $message);
    log_this_action (blogosphere_action_user(), invited_basic_action(), $data_1);
    return true;
  }
  else {
    return false;
  }

}

function sendWelcomeEmail($username, $email) {
  $message = 'Hi ' . $username . ', <br>
    Welcome to Starma!  We\'re so glad you joined our community.  Starma is still in development so please <a href="mailto:'. CONTACT_US() . '">contact us</a> if you encounter any problems. Enjoy!<br><br>Sincerely,<br>The Starma Team<br><a href="https://www.starma.com" title="Starma.com">www.starma.com</a>';
    if (sendTemplateWelcome($email, 'Welcome to Starma', $message, "no-reply@" . get_email_domain())) {
      return true;
    }
    else {
      return false;
    }
}


function sendLostPasswordEmail($email, $newpassword) {

    $message = "You have requested a new password on " . get_full_domain() . ",<br><br> Your new information:<br><br> username:  $email<br>password:  $newpassword<br>";
 
    if (sendTemplatePassword($email, 'Your password has been reset.', $message, "no-reply@" . get_email_domain())) {
      return true;
    } 
    else {
      return false;
    } 
}


//END MANDRILL DYNAMIC CONTENT

/*
function sendNewMessageEmail($sender_id, $receiver_id, $message)
{
 
    $sender = basic_user_data($sender_id);
    $receiver = basic_user_data($receiver_id);
    //$message = array(
      //            'reciever' => $reciever['nickname'],
        //          'link' => '<a href="' . get_full_domain () . '/main.php?the_page=isel&the_left=nav1&other_user_id=' . $sender_id . '">Click Here</a>'
          //      );
    $message = $receiver["nickname"] . ' - <Br><Br>' . $sender["nickname"] . ' has sent you a personal message on Starma.com.  <a href="' . get_full_domain () . '/main.php?the_page=isel&the_left=nav1&other_user_id=' . $sender_id . '">Click Here</a> to view it!';
 
    if (sendMail($receiver["email"], "You have received a new message from " . $sender["nickname"] . "!" , $message, "no-reply@" . get_email_domain()))
    { 
    //if(sendTemplateMessage($receiver["email"], "You have received a new message from " . $sender["nickname"] . "!" , $message, "no-reply@" . get_email_domain()))
    
        return true;
    } else
    {
        return false;
    }
 
 
}
*/

function sendComparedAlertEmail($user_id, $number)
{
 
    $sender = basic_user_data($user_id);
    $message = 'Hello ' . $sender["nickname"] . ',<br><br>' . $number . ' new people have compared themselves to you this week. <a href="' . get_full_domain() . '/main.php?the_page=cosel&the_left=nav1&the_tier=1">Login</a> to see who you\'re compatible with.<br><br>' . email_suggestions_block();
 
    if (sendMail($sender["email"], $number . " people have compared themselves to you this week!" , $message, "no-reply@" . get_email_domain()))
    {
        return true;
    } else
    {
        return false;
    }
}


 
function testSendingMail ($to, $subject, $message, $from, $footer) {
  echo "Attempting to send mail: <br><br>";
  echo "To: " . $to . '<br>';
  echo "From: " . $from . '<br>';
  echo "Subject: " . $subject . '<br>';
  echo "Message: " . $message . '<br><br>';

  return sendMail ($to, $subject, $message, $from, $footer);
}


function testSendingMail_Mandrill_API ($to, $subject, $message, $from, $footer) {

  echo "Attempting to send mail: <br><br>";
  echo "To: " . $to . '<br>';
  echo "From: " . $from . '<br>';
  echo "Subject: " . $subject . '<br>';
  echo "Message: " . $message . '<br><br>';

  return sendMail($to, $subject, $message, $from, $footer);

}

function sendMail_old ($to, $subject, $message, $from, $footer="")
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
    $mail->Body = $message . '<br><br>Sincerely,<br>The Starma Team<br><a href="https://www.starma.com">www.starma.com</a>' . $footer; //HTML Body
    $mail->AltBody = $message; //Text Body
    //$mail->AddBCC("teamstarma@gmail.com");
    
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

function sendMail_Mandrill($to, $subject, $message, $from, $footer="")
{
    
    $mail = new PHPMailer(); 
   
    $mail->IsSMTP(); // send via SMTP

    $mail->SMTPAuth   = true;
    $mail->Host = 'smtp.mandrillapp.com';
    $mail->SMTPDebug = 1;
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";    
    $mail->Username = "starma"; // SMTP username
    $mail->Password = "yz5APugrFIuJW-iZlKYrIg"; // SMTP password
    $webmaster_email = $from; //Reply to this email ID
    $email=$to; // Recipients email ID
    $mail->From = $webmaster_email;
    $mail->FromName = "Starma";
    $mail->AddAddress($email);
    $mail->AddReplyTo($webmaster_email);
    $mail->WordWrap = 50; // set word wrap
    $mail->IsHTML(true); // send as HTML
    $mail->Subject = $subject;
    $mail->Body = $message . '<br><br>Sincerely,<br>The Starma Team<br><a href="https://www.starma.com">www.starma.com</a>' . $footer; //HTML Body
    $mail->AltBody = $message; //Text Body
    //$mail->AddBCC("teamstarma@gmail.com");
    
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

function sendMail($to, $subject, $message, $from, $footer="")
{
    

    try {
      $mandrill = new Mandrill('yz5APugrFIuJW-iZlKYrIg');
      $message = array(
        'html' => $message . '<br><br>Sincerely,<br>The Starma Team<br><a href="https://www.starma.com">www.starma.com</a>' . $footer,
        //'text' => 'Example text content',
        'subject' => $subject,
        'from_email' => $from,
        'from_name' => 'Starma Account Administration',
        'to' => array(
            array(
                'email' => $to,
                //'name' => 'Recipient Name',
                //'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $from),
        'important' => false,
        'track_opens' => true,
        'track_clicks' => true,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => '',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array('Test_Emails'),
        //'subaccount' => 'customer-123',
        'google_analytics_domains' => array(),
        'google_analytics_campaign' => '',
        'metadata' => array('website' => ''),
        'recipient_metadata' => array(),
        'attachments' => array(),
        'images' => array(
        )
      );
      $async = false;
      $ip_pool = '';
      //$send_at = date('Y-m-d H:i:s');
      //$result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
      $result = $mandrill->messages->send($message, $async, $ip_pool);
      //print_r($result);
      return true;
    } catch(Mandrill_Error $e) {
      // Mandrill errors are thrown as exceptions
      echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
      // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
      log_this_action (account_action_email(), error_basic_action());
      throw $e;
      return false;    
    }
  
  return false;  
    
    
   
}

//SENDING A TEMPLATE FROM MANDRILL---------------------------------

//REPORT USER
function sendTemplateReport ($to, $subject, $content, $from) {
  try {
    $mandrill = new Mandrill('yz5APugrFIuJW-iZlKYrIg');
    $template_name = 'report user';
    $template_content = array(
        array(
            'name' => 'report_user_msg',
            'content' => $content
        ),
        array (
            'name' => 'contact_us',
            'content' => CONTACT_US()
        ),
        array (
            'name' => 'current_year',
            'content' => CURRENT_YEAR()
        )                       
    );
    $message = array(
        'html' => '',
        'text' => '',
        'subject' => $subject,
        'from_email' => $from,
        'from_name' => 'Starma',
        'to' => array(
            array(
                'email' => $to,
                //'name' => 'Recipient Name',
                //'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $from),
        'important' => false,
        'track_opens' => true,
        'track_clicks' => true,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => '',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array('report user'),
        //'subaccount' => 'customer-123',
        'google_analytics_domains' => array(),
        'google_analytics_campaign' => '',
        'metadata' => array('website' => ''),
        'recipient_metadata' => array(),
        'attachments' => array(),
        'images' => array()
    );
    $async = false;
    $ip_pool = '';
    //$send_at = '';
    //$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
    $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
    return true;
  }
  catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
    return false;
  }
  return false;
  //return 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
}

//PERSONAL MESSAGE
function sendTemplateMessage ($to, $subject, $content, $from) {
  
  try {
    $mandrill = new Mandrill('yz5APugrFIuJW-iZlKYrIg');
    $template_name = 'personal msg';
    $template_content = array(
        array(
            'name' => 'receiver',
            'content' => $content['receiver']
        ),
        array(
            'name' => 'sender',
            'content' => $content['sender']
        ),
        array (
            'name' => 'link',
            'content' => $content['link']
        ), 
        array (
            'name' => 'current_year',
            'content' => CURRENT_YEAR()
        ),
        array (
            'name' => 'contact_us',
            'content' => CONTACT_US()
        ),
        array (
            'name' => 'unsubscribe',
            'content' => '<a href="' . get_full_domain() . '/unsub.php?email=' . $to . '&actcode=' . get_actcode_from_email ($to) . '">Unsubscribe</a>'
        )                   
    );
    $message = array(
        'html' => '',
        'text' => '',
        'subject' => $subject,
        'from_email' => $from,
        'from_name' => 'Starma',
        'to' => array(
            array(
                'email' => $to,
                //'name' => 'Recipient Name',
                //'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $from),
        'important' => false,
        'track_opens' => true,
        'track_clicks' => true,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => '',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array('personal msg'),
        //'subaccount' => 'customer-123',
        'google_analytics_domains' => array(),
        'google_analytics_campaign' => '',
        'metadata' => array('website' => ''),
        'recipient_metadata' => array(),
        'attachments' => array(),
        'images' => array()
    );
    $async = false;
    $ip_pool = '';
    //$send_at = '';
    //$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
    $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
    return true;
  }
  catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
    return false;
  }
  return false;
  //return 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
}

//INVITE
function sendTemplateInvite ($to, $subject, $body, $from, $footer) {
  try {
    $mandrill = new Mandrill('yz5APugrFIuJW-iZlKYrIg');
    $template_name = 'invite user';
    $template_content = array(
        array(
            'name' => 'body',
            'content' => $body
        ),
        array(
            'name' => 'footer',
            'content' => $footer
        ),
        array (
            'name' => 'current_year',
            'content' => CURRENT_YEAR()
        ),
        array (
            'name' => 'contact_us',
            'content' => CONTACT_US()
        )                      
    );
    $message = array(
        'html' => '',
        'text' => '',
        'subject' => $subject,
        'from_email' => $from,
        'from_name' => 'Starma',
        'to' => array(
            array(
                'email' => $to,
                //'name' => 'Recipient Name',
                //'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $from),
        'important' => false,
        'track_opens' => true,
        'track_clicks' => true,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => '',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array('invite user'),
        //'subaccount' => 'customer-123',
        'google_analytics_domains' => array(),
        'google_analytics_campaign' => '',
        'metadata' => array('website' => ''),
        'recipient_metadata' => array(),
        'attachments' => array(),
        'images' => array()
    );
    $async = false;
    $ip_pool = '';
    //$send_at = '';
    //$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
    $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
    return true;
  }
  catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
    return false;
  }
  return false;
  //return 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
}

//WELCOME
function sendTemplateWelcome ($to, $subject, $body, $from) {
  try {
    $mandrill = new Mandrill('yz5APugrFIuJW-iZlKYrIg');
    $template_name = 'welcome';
    $template_content = array(
        array(
            'name' => 'body',
            'content' => $body
        ),
        array (
            'name' => 'current_year',
            'content' => CURRENT_YEAR()
        ),
        array (
            'name' => 'contact_us',
            'content' => CONTACT_US()
        )                      
    );
    $message = array(
        'html' => '',
        'text' => '',
        'subject' => $subject,
        'from_email' => $from,
        'from_name' => 'Starma',
        'to' => array(
            array(
                'email' => $to,
                //'name' => 'Recipient Name',
                //'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $from),
        'important' => false,
        'track_opens' => true,
        'track_clicks' => true,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => '',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array('welcome'),
        //'subaccount' => 'customer-123',
        'google_analytics_domains' => array(),
        'google_analytics_campaign' => '',
        'metadata' => array('website' => ''),
        'recipient_metadata' => array(),
        'attachments' => array(),
        'images' => array()
    );
    $async = false;
    $ip_pool = '';
    //$send_at = '';
    //$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
    $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
    return true;
  }
  catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
    return false;
  }
  return false;
  //return 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
}

//FORGET PASSWORD
function sendTemplatePassword ($to, $subject, $content, $from) {
  try {
    $mandrill = new Mandrill('yz5APugrFIuJW-iZlKYrIg');
    $template_name = 'forgot_pass';
    $template_content = array(
        array(
            'name' => 'body',
            'content' => $content
        ),
        array (
            'name' => 'contact_us',
            'content' => CONTACT_US()
        ),
        array (
            'name' => 'current_year',
            'content' => CURRENT_YEAR()
        )                       
    );
    $message = array(
        'html' => '',
        'text' => '',
        'subject' => $subject,
        'from_email' => $from,
        'from_name' => 'Starma',
        'to' => array(
            array(
                'email' => $to,
                //'name' => 'Recipient Name',
                //'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $from),
        'important' => false,
        'track_opens' => true,
        'track_clicks' => true,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => '',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array('report user'),
        //'subaccount' => 'customer-123',
        'google_analytics_domains' => array(),
        'google_analytics_campaign' => '',
        'metadata' => array('website' => ''),
        'recipient_metadata' => array(),
        'attachments' => array(),
        'images' => array()
    );
    $async = false;
    $ip_pool = '';
    //$send_at = '';
    //$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
    $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
    return true;
  }
  catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
    return false;
  }
  return false;
  //return 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
}

//END TEMPLATES---------------------------------------


 
function sendActivationEmail($email, $nickname, $password, $uid, $actcode)
{
    
    //$link = "http://www." . get_email_domain() "/activate.php?uid=$uid&actcode=$actcode";
    $link = "https://www." . get_email_domain() . "/activate.php?uid=$uid&actcode=$actcode";
    $message = "
Thank you for registering on https://www." . get_email_domain() . "/,
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