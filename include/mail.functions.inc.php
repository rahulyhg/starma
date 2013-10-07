<?php
//require_once "Mail.php";


 
##### Mail functions #####

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
We deeply appreciate your participation and support, and we warmly welcome you to the ground level of a brand new community!<br>
<br>
Sincerely,<br>
The Starma Team
';


    if (sendMail($email, "Starma Alpha Test Invite", $message, "contact@starma.com"))
    {
        return true;
    } else
    {
        return false;
    }
 
 
}


function sendLostPasswordEmail($email, $nickname, $newpassword)
{
 
    global $domain;
    $message = "
You have requested a new password on http://www.$domain/,<br>
<br> 
Your new password information:<br>
<br> 
username:  $email<br>
password:  $newpassword<br>
<Br>
<br>
Regards<br>
$domain Administration
";
 
    if (sendMail($email, "Your password has been reset.", $message, "no-reply@$domain"))
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
 
function testMailSansPHPMailer ($to, $subject, $message, $from) {
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

    //$mail->SMTPAuth   = false;
    //$mail->Host = 'relay-hosting.secureserver.net';
    //$mail->exceptions = false;

//GMAIL SETTINGS//
    $mail->SMTPAuth   = true;    
    $mail->Host = 'ssl://smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";    
    $mail->Username = "teamstarma@gmail.com"; // SMTP username
    $mail->Password = "squirreltime"; // SMTP password
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
    $mail->Body = $message; //HTML Body
    $mail->AltBody = $message; //Text Body
    
    //$mail->Send();
   
    //return true;
   
    if($mail->Send())
    {
       return true;
    }
    else
    {
       log_this_action (account_action_email(), error_basic_action());
       echo "Mailer Error: " . $mail->ErrorInfo;
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
$link
<br><br> 
- The Starma Team

";
 
    if (sendMail($email, "Please activate your account.", $message, "contact@starma.com"))
    {
        return true;
    } else
    {
        return false;
    }
}
 
?>