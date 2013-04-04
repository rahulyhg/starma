<?php
require_once "header.php"; 
?>

<?php
 echo '<div id="agreement">';
   echo '<form name="agreement_form" method="post" action="./register.php">';

   //carry over the form vars from the registration page
   echo '<input type="hidden" name="nickname" value="' . $_POST["nickname"] . '">';
   echo '<input type="hidden" name="password" value="' . $_POST["password"] . '">';
   echo '<input type="hidden" name="password2" value="' . $_POST["password"] . '">';
   echo '<input type="hidden" name="email" value="' . $_POST["email"] . '">';
   echo '<input type="hidden" name="email2" value="' . $_POST["email2"] . '">';
   echo '<input type="hidden" name="year_birthday" value="' . $_POST["year_birthday"] . '">';
   echo '<input type="hidden" name="month_birthday" value="' . $_POST["month_birthday"] . '">';
   echo '<input type="hidden" name="day_birthday" value="' . $_POST["day_birthday"] . '">';
   echo '<input type="hidden" name="token" value="' . $_POST["token"] . '">';


   echo '
   <b><span style="font-size:1.2em">Trial User Agreement</span></b>
   <br><Br>
   I understand and agree that I am represented herein by the username I will select on Starma.com, and that by using the token given to me by Starma LLC to create an account on Starma.com I am taking part in this trial run of Starma.com (“trial run”).  I agree to operate under the guidelines set forth in this agreement until otherwise notified through written notice by an official communication from Starma LLC.  
   <br><br>
   <b>Trial Run Guidelines</b>
   <br><br>
   I understand and agree that for the duration of the trial run, the ending date of which will be transmitted to me in writing from Starma LLC at a later time, I will keep private from all persons or entities not participating in the trial run: 
   <ul>
     <li>my password or token given to me by Starma LLC</li>
     <li>any information pertaining to the trial run such as the trade secrets or progress of Starma.com</li>
     <li>the content, design, theme, and concept of Starma.com</li>
   </ul>
   <div style="margin:auto; width:150px; height:50px">
    <input style="display:inline-block" type="submit" name="agreed" value="Accept"/>
    <input style="display:inline-block" type="submit" name="agreed" value="Decline"/>
   </div>
   We deeply appreciate your participation!
   <br><br>
   Sincerely,
   <br><Br>
   The Starma Team

   ';
   echo '</form>';
 echo '</div>';
 
 require_once "footer.php";
?> 