<?php 
function isWord($word) {
 if ((int)(strpos($word, ' ')) > 0 || strlen($word) == 0) {
   return false;
 }
 else {
   return true;
 }
}

function show_astrologers_view() {
  if (isLoggedIn()) {
    if ($_GET['the_page'] == 'psel') {  //MY PROFILE
      if ($_GET['western'] == 0) {  //VEDIC
        $chart_id = get_my_chart_id();
      }
      else {  //WESTERN
        $chart_info = get_chart_by_name("Alternate",get_my_user_id());  
        $chart_id = $chart_info['chart_id'];
      }
    }
    else {  //ANOTHER PROFILE
      if ($_GET['western'] == 0) {  //VEDIC
        $chart_id = $_GET['chart_id2'];
      }
      else {  //WESTERN
        $chart_id = $_GET['chart_id2'];
        if (!is_freebie_chart($chart_id)) { //USER OR CELEB
          $chart_info = get_chart_by_name("Alternate",get_user_id_from_chart_id($chart_id));  
          $chart_id = $chart_info['chart_id'];
        }
        else {  //FREEBIE
          $chart_id = chart_already_there("Alternate_Freebie1",get_my_user_id());
        }    
      }
    }
  }
  else {  //GUEST VIEW
    $guest_user_id = get_guest_user_id();
    if ($_GET['western'] == 0) {  //VEDIC
      $chart_id = get_guest_chart_id($guest_user_id);
    }
    else {  //WESTERN VIEW
      $chart_info = get_chart_by_name("Alternate",get_guest_user_id());  
      $chart_id = $chart_info['chart_id'];
    }
  }
   
  $rising_sign_id = get_sign_from_poi ($chart_id, 1);
  if ($rising_sign_id !== -1) {
    echo '<div id="astrologers_view" class="later_on">';
    $houses = get_house_list();
    while ($house = mysql_fetch_array($houses)) {
      echo '<div id="house_' . $house['house_id'] . '_sign">';
        echo get_sign_in_house_id($chart_id, $house['house_id']);  
      echo '</div>';
     
      $poi_list = get_poi_in_house_id($chart_id, $house['house_id']);
      
      if ($house['house_id'] == 2 || $house['house_id'] == 6 || $house['house_id'] == 8 || $house['house_id'] == 12) {
        echo '<div id="house_' . $house['house_id'] . '_poi">';
          echo '<div style="text-align:center; width: 177px;">';
          while ($poi = mysql_fetch_array($poi_list)) {
            echo '<span>' . $poi['poi_abbr'] . '&nbsp;</span>';
          }
          echo '</div>';
        echo '</div>';
      }  
      else {
        echo '<div id="house_' . $house['house_id'] . '_poi">';
          echo '<table><tr><td>';
          while ($poi = mysql_fetch_array($poi_list)) {
            echo '<span>' . $poi['poi_abbr'] . '</span><br>';
          }
          echo '</td></tr></table>';
        echo '</div>';
      }
      
    }
  }
  else {
    $isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($chart_id)));
    $user_info = profile_info(get_user_id_from_chart_id($chart_id));
    if ($isCeleb) {
      $user_title = $user_info['first_name'] . ' ' . $user_info['last_name'];
    }
    elseif (!is_freebie_chart($chart_id)) {
        $user_title = $user_info["nickname"];
    }
    if (!is_freebie_chart($chart_id)) {
      echo '<div class="later_on" style="font-size:1.3em; margin-bottom: 225px; margin-top:25px;">Sorry!  We can\'t show you the Astrologers View because ' . $user_title . ' doesn\'t have a precise birth time.</div>';
    }
    else {
      echo '<div class="later_on" style="font-size:1.3em; margin-bottom: 225px; margin-top:25px;">Sorry!  We can\'t show you the Astrologers View because we don\'t have a precise birth time for this Custom Chart.</div>';
    }
  }
  
  echo '</div>'; //close astrologers_view
}


function show_sheen ($flag=0, $form_function) {
   echo '<div id="sheen">';
    

     echo '<div id="sheen_screen">';
    
     echo '</div>';
     echo '<div id="sheen_content">';
        $form_function($flag);
     echo '</div>';
    echo '</div>';
}

function show_user_invite () {
  echo '<div id="msg_sheen_content_invite">';
    echo '<div id="sign_up_box">';
      echo  '<div class="heading">Send Invite With...</div>';
        echo '<div style="margin-top: 15px;">';
          echo '<div style="margin-bottom: 4px;" id="fb_invite"><button type="button" id="invite_w_fb" class="sign_up"';
          if (get_my_fb_id()) {
            echo ' onClick="checkLoginStateInvite();"'; 
          }
          else {
            echo ' onClick="fbLoginMain();"';
          }
          echo '>Facebook</button></div>';
          echo '<div id="or">~ or ~</div>';
          //echo '<button type="button" onClick="revokeFB();">revoke fb</button>'; 
          echo '<div style="margin-top: 11px;"><button type="button" id="invite_w_email" class="sign_up">Email</button></div>';
        echo '</div>';
      echo '</div>'; //Close sign_up_box
    echo '</div>'; //Close msg_sheen_content_invite
}

function show_user_invite_email () {
  echo '<div id="msg_sheen_content_invite_email">';
                echo '<div id="invite_type_area">';
                  echo '<div style="width:100%; text-align:center; font-size:2em; margin-bottom:10px;"><strong>Invite A Friend</strong></div>';
                  //echo '<form id="send-message-area" action="chat/invite_new_user.php" method="POST">
                  echo '<div id="send-message-area">';
                    echo '<div id="first_name_error" class="invite_error"></div>';
                    echo '<div id="last_name_error" class="invite_error"></div>';
                    echo '<div id="their_name_error" class="invite_error"></div>';
                    echo '<div id="their_email_error" class="invite_error"></div>';
                    echo '<div id="sender_id_error" class="invite_error"></div>';
                    echo '<div style="font-size:1.19em;">Your Name</div>
                          <input type="text" value="';
                            $first_name = get_my_first_name();
                            if(!$first_name) {
                              echo '';
                            } 
                            else {
                              echo $first_name;
                            }
                            echo '" id="first_name_invite" placeholder="First Name" name="first_name" maxlength="17" />
                          <input type="text" value="';
                            $last_name = get_my_last_name();
                            if(!$last_name) {
                              echo '';
                            } 
                            else {
                              echo $last_name;
                            }
                          echo '" id="last_name_invite" name="last_name" placeholder="Last Name" maxlength="17" /> <br />
                          <div style="font-size:1.19em;">Who are you inviting?</div>
                          <input type="text" placeholder="Name" id="their_name_invite" name="their_name" maxlength="34" />
                          <input type="text" placeholder="Email" id="their_email_invite" name="their_email" /> <br />
                          <div style="font-size:1.19em;">Personal Message (Optional)</div>
                          <textarea id="msg_sendie_invite" name="text_body" maxlength = "255" ></textarea>
                          <div id="cancel">Cancel</div>
                          <div id="send_invite">Send</div>
                          <input type="hidden" value=' . get_my_user_id() . ' name="sender_user_id"/>';                         
                        //echo '</form>';
                        echo '</div>'; //Clost send-message-area
                      echo '<span id="invite_sent"></span>';
                  echo '</div>';
                echo '</div>';
}

function compare_info_form($flag) {
  echo '<span style="text-align:center">Welcome to Starma\'s Compatibility Test<br><br></span>';
  echo 'At the top of the this page you will see a rating out of 5 stars.  Your star rating is meant to give you a general impression of your compatibility with the person you have selected, but not to tell the whole story!  Astrological compatibility is very complex, and therefore very difficult to represent with a simple score. We highly recommend that you read through the dynamics found below the star rating, to get a clearer picture of your compatibility.  Also, our system and formula for compatibility is designed specifically for Vedic astrology, so you will only be able to test your compatibility using your default Starma Chart for now.
        <br><br>
        For more information on our compatibility system please visit our FAQ page.  Enjoy!<br><br>';
  echo '<div style="text-align:center">';
    hide_info_box($flag, "compare_more_info_flag");
  echo '<br><br></div>';
}

function chart_info_form($flag) {
  echo '<span style="text-align:center">Welcome ' . get_my_nickname() . '!<br><br></span>';
  echo '1. This section of Starma is dedicated to your Starma Chart, AKA your "Birth Chart."  The icons to the left and right show your Rising sign, Sun sign, Moon sign, etc.  Click on each one to read what it means.  Because each placement only tells a small part of a bigger story, in order to understand your Starma Chart, you have to read it as a whole.  We highly recommend consulting a Vedic astrologer if you want a more in-depth understanding.
        <br><br>
        2. Your Starma Chart is calculated using Vedic astrology, which we have found to be more accurate.  If you\'re already familiar with your Western chart, the placements you\'re about to see may be slightly different.  However, to accommodate everyone, we have included a Western Chart View which you can access by clicking the link in the upper right corner of this page.  
        <br><br>
        3. We will be adding Neptune, Pluto and Uranus to your Starma Western Chart soon.  In fact, we will be constantly adding features and content so please check back regularly!<br><br>';
  echo '<div style="text-align:center">';
    hide_info_box($flag, "chart_more_info_flag");
  echo '<br><br></div>';
}



function showchat() {
 echo '<div class="chat_alert_list_div">
        <ul id="chat_alert_list">';
            $my_chattings = get_my_chat_status();
            while ($chat_status = mysql_fetch_array($my_chattings)) { 
               $chat_open = "";
               if ($chat_status["chatting"] == 2) {
                 $chat_open = " chat_open";
               }
               $partner_id = $chat_status["user_id_B"];
               echo '<li id="chat_request_' . $partner_id . '" class="chat_request" style="display:block">';

               echo '<div class="chat_header_text' . $chat_open . '">';
               echo '<a href="#" class="text_link" onclick="handle_chat_notification_click(' . $partner_id . '); return false;">Chat with ' . get_nickname($partner_id) . '</a>';
               echo '<a href="#" class="shut_chat" onclick="unloadChat(' . $partner_id . '); return false;" style="color:red; float:right">X</a>';
               echo '</div>';
               //open chat window goes here
               if ($chat_open != "") {
                 echo '<div id="chat_block_' . $partner_id . '" class="chat_block ' . $chat_open . '"  style="display:block">';
                 show_msg_area($partner_id);
                 echo '<script type="text/javascript">';
                   //echo '$("#chat_area_' . $partner_id . '").scrollTop($("#chat_area_' . $partner_id . '")[0].scrollHeight)';
                   echo 'document.getElementById("chat_area_' . $partner_id . '").scrollTop = document.getElementById("chat_area_' . $partner_id . '").scrollHeight;';
                 echo '</script>';
               }
               echo '</li>';
            }
  echo '</ul>
      </div>';
}

function show_msg_area ($r_id) {
  $my_msgs = get_my_msgs_with ($r_id);
  //print_r ($my_msgs);
  //die(); 
    
      echo '<div id="chat_area_' . $r_id . '" class="chat_area">';
      $place_date = "0";
      while ($msg = mysql_fetch_array($my_msgs)) { 
         //echo $place_date . '<br>' . $msg["date_time"];
         $local_date_time = apply_my_timezone(strtotime($msg["date_time"]));
         if ($place_date != date('d/m/Y', $local_date_time)) {
           
           echo '<p class="chat_date">' . chat_date($local_date_time) . '</p>';
           $place_date = date('d/m/Y', $local_date_time);
         } 
         echo '<p class="chat_time">' . date('g:i A', $local_date_time) . '</p><p>' . get_nickname($msg["sender_id"]) . ': ' . $msg["text_body"] . '</p>';
         if ($msg["sender_id"] == get_my_user_id()) {
             $which_partner = "sender";
         }
         else {
             $which_partner = "receiver";
         }
         flag_as_read_my_msg($msg["msg_line_id"], $which_partner);
      }
     echo '</div>';
     echo '<form id="send-message-area">
             <textarea id="sendie" maxlength = "200" ></textarea>
           </form>';
    
  addJSChatEvents($r_id); 
  return true;
}


function show_msg_area_inbox ($r_id) {
  $my_msgs = get_my_msgs_with ($r_id);
  //print_r ($my_msgs);
  //die(); 
    
      echo '<div id="chat_area_inbox" class="chat_area" >';
      $place_date = "0";
      while ($msg = mysql_fetch_array($my_msgs)) { 
         //echo $place_date . '<br>' . $msg["date_time"];
         $local_date_time = apply_my_timezone(strtotime($msg["date_time"]));
         if ($place_date != date('d/m/Y', $local_date_time)) {
           
           echo '<p class="chat_date">' . chat_date($local_date_time) . '</p>';
           $place_date = date('d/m/Y', $local_date_time);
         } 
         $is_new = "";
         if ($msg["sender_id"] == get_my_user_id()) {
             $which_partner = "sender";
         }
         else {
             $which_partner = "receiver";
             if ($msg["receiver_has_seen"] == 0) {
               $is_new = " is_new";
             }
         }
         echo '<p class="chat_time' . $is_new  . '">';
         if ($is_new != "") {
           echo "(new) ";
         }
         echo date('g:i A', $local_date_time) . '</p><p class="' . $is_new . '">' . get_nickname($msg["sender_id"]) . ': ' . $msg["text_body"] . '</p>';
         
         flag_as_read_my_msg($msg["msg_line_id"], $which_partner);
      }
     echo '</div>';
     echo '<div id="type_area">';
       echo '<form id="send-message-area" action="send_message.php" method="post">
               <textarea id="sendie" name="text_body" maxlength = "500" ></textarea>
               <input type="submit" name="submit" value="Reply"/>
               <input type="hidden" value=' . $r_id . ' name="other_user_id"/>
             </form>';
     echo '</div>';
     
  //addJSChatEvents($r_id); 
  return true;
}

//************---Matt add teaser blurb to Conversations

function show_msg_last ($r_id) {

  $my_msgs = get_my_msgs_with ($r_id);

  //$msg = mysql_fetch_array($my_msgs)['text_body'];
  
      while($msgs = mysql_fetch_array($my_msgs)) {
        extract($msgs);
        $msg = array();
        array_push($msg, $text_body);        
      }
/*
      if(is_array($msg)){
        $msg = $msg[0];
      } 
      else {
        $msg = $msg;
      } 
 */ 
  return end($msg);
}

//************---Matt add msg popup from other's profile Message button - Going to try with Jquery instead
/*
function show_sheen_msg_popup ($r_id) {
   echo '<div id="sheen">';
    
     echo '<div id="sheen_screen">';
    
     echo '</div>';
     echo '<div id="sheen_content">';
       echo '<div id="type_area">';
       echo '<form id="send-message-area" action="send_message.php" method="post">
               <textarea id="sendie" name="text_body" maxlength = "500" ></textarea>
               <input type="submit" name="submit" value="Reply"/>
               <input type="hidden" value=' . $r_id . ' name="other_user_id"/>
             </form>';
     echo '</div>';
     echo '</div>';
    echo '</div>';
    return true;
}
*/
//************---End Matt Stuff

function show_msg_area_blank () {
  
    
      
     echo '<div id="type_area" class="blank">';
       echo '<form id="send-message-area" action="send_message.php" method="post">
               <input type="text" name="to_name" id="search_favorites_bar"/>
               <textarea id="sendie" name="text_body" maxlength = "500" ></textarea>
               <input type="submit" name="submit" value="Send"/>
               
             </form>';
     echo '</div>';
   
   
  //addJSChatEvents($r_id); 
  return true;
}



function show_msgs ($r_id) {
  $my_msgs = get_my_msgs_with ($r_id);
  //print_r ($my_msgs);
  //die();
   
  while ($msg = mysql_fetch_array($my_msgs)) { 
     
     echo '<p>' . get_nickname($msg["sender_id"]) . ': ' . $msg["text_body"];
     if ($msg["sender_id"] == get_my_user_id()) {
         $which_partner = "sender";
     }
     else {
         $which_partner = "receiver";
     }
     flag_as_read_my_msg($msg["msg_line_id"], $which_partner);
  }
  return true;
}

function showNewMessageAlert() {
  $num_chats = num_new_non_chats();
  if ($num_chats > 0) {
    echo '<div id="new_message_alert">';
      echo num_new_non_chats();
    echo '</div>';
  }
}


function show_account_menu () {
  echo '<div id="account_menu"><a class="later_on" href="">' . get_my_nickname() . '&nbsp;&nbsp;&nbsp;&nbsp;</a>';
  echo '<div class="dropdown">';
    echo '<ul>';
      echo '<li><a class="later_on" href="main.php?the_page=ssel&the_left=nav1&the_tier=1">Settings</a></li>';
      echo '<li><a class="later_on" style="border-bottom:2px solid black"';
        if (get_my_fb_id()) {
          echo ' onClick="fbLogout();" ';
        }
      echo ' href="logout.php">Logout</a></li>';
    echo '</ul>';
  echo '</div>';
  echo '</div>';
}

function show_circle_and_arrow_hilite($dir="up") {
  echo '<div class="circle_hilite">';
  echo '</div>';
  echo '<div class="' . $dir . '_arrow_hilite">';
  echo '</div>';
}

function menu_status($page) {
  if ($page == '#') {
    return 'inactive';
  }
  else {
    return 'active';
  }
}

function edit_biography_info() {
  $user_info = my_profile_info();
  echo '<div id="edit_interests">';
  echo '<form name="interests_form" action="save_bio.php" method="post">';
    echo '<div id="activities">';
      echo '<div class="title">Biography</div>';
      echo '<div class="value">';
        echo '<textarea name="about_me">' . $user_info["about_me"] . '</textarea>';
      echo '</div>';
    echo '</div>';
       
    move_on_buttons();
  echo '</form>';
  echo '</div>';
}

function edit_descriptors_info() {
  echo "What 3 Words describe you best?<br><br>";
  $words = get_my_descriptors();
  echo '<div id="edit_descriptors">';
  echo '<form name="descriptor_form" action="save_descriptors.php" method="post">';
  $counter = 0;

  while ($word = mysql_fetch_array($words)) {
    echo '<div id="des_selector_' . (string)($counter+1) . '">';
      echo '<div class="title">' . (string)($counter+1) . ':</div>';
      echo '<div class="value">';
        echo '<input type="text" name="des_name_' . (string)($counter+1) . '" value="' . $word["descriptor"] . '"/>';
      echo '</div>';
    echo '</div>';
    $counter = $counter + 1;
  }

  while ($counter < max_descriptors()) {
    echo '<div id="des_selector_' . (string)($counter+1) . '">';

      echo '<div class="title">' . (string)($counter+1) . ':</div>';
      echo '<div class="value">';
        echo '<input type="text" name="des_name_' . (string)($counter+1) . '" value=""/>';
      echo '</div>';

    echo '</div>';
    $counter = $counter + 1;
  }

  move_on_buttons();
  echo '</form>';
  echo '</div>';
}




function edit_interests_info() {
  $user_info = my_profile_info();
  echo '<div id="edit_interests">';
  echo '<form name="interests_form" action="save_interests.php" method="post">';
    echo '<div id="biography">';
      echo '<div class="title">Biography</div>';
      echo '<div class="value">';
        echo '<textarea name="about_me">' . $user_info["about_me"] . '</textarea>';
      echo '</div>';
    echo '</div>';

    echo '<div id="activities">';
      echo '<div class="title">Activities</div>';
      echo '<div class="value">';
        echo '<textarea name="activities">' . $user_info["activities"] . '</textarea>';
      echo '</div>';
    echo '</div>';
    
    echo '<div id="music">';
      echo '<div class="title">Music</div>';
      echo '<div class="value">';
        echo '<textarea name="music">' . $user_info["music"] . '</textarea>';
      echo '</div>';
    echo '</div>';

    echo '<div id="books">';
      echo '<div class="title">Books</div>';
      echo '<div class="value">';
        echo '<textarea name="books">' . $user_info["books"] . '</textarea>';
      echo '</div>';
    echo '</div>';

    echo '<div id="film_television">';
      echo '<div class="title">Film & Television</div>';
      echo '<div class="value">';
        echo '<textarea name="film_television">' . $user_info["film_television"] . '</textarea>';
      echo '</div>';
    echo '</div>';

    echo '<div id="spiritual">';
      echo '<div class="title">Religion/Spirituality</div>';
      echo '<div class="value">';
        echo '<textarea name="spiritual">' . $user_info["spiritual"] . '</textarea>';
      echo '</div>';
    echo '</div>';
    
    echo '<div id="political">';
      echo '<div class="title">Political Views</div>';
      echo '<div class="value">';
        echo '<textarea name="political">' . $user_info["political"] . '</textarea>';
      echo '</div>';
    echo '</div>';
  
    echo '<div id="inspirational_figures">';
      echo '<div class="title">Inspirational Figures</div>';
      echo '<div class="value">';
        echo '<textarea name="inspirational_figures">' . $user_info["inspirational_figures"] . '</textarea>';
      echo '</div>';
    echo '</div>';
    echo '<input style="position: absolute; right: 20px; top: 18px;" type="submit" name="submit" value="Save My Info"/>';
    //move_on_buttons();
  echo '</form>';
  echo '</div>';
}


function edit_general_info() {
  $user_info = my_profile_info();
  
  echo '<div id="edit_general_information">';
  echo '<form name="general_information_form" action="save_general_information.php" method="post">';
    echo '<div id="first_name">';
      echo '<div class="title">First Name</div>';
      echo '<div class="value">';
        echo '<input type="text" name="first_name" value="' . $user_info["first_name"] . '"/>';
      echo '</div>';
    echo '</div>';
    echo '<div id="last_name">';
      echo '<div class="title">Last Name</div>';
      echo '<div class="value">';
        echo '<input type="text" name="last_name" value="' . $user_info["last_name"] . '"/>';
      echo '</div>';
    echo '</div>';
    echo '<div id="gender">';
      echo '<div class="title">Gender</div>';
      echo '<div class="value">';
        gender_select(get_my_gender());
      echo '</div>';
    echo '</div>';
    echo '<div id="location">';
      echo '<div class="title">Location</div>';
      echo '<div class="value">';
        echo '<input type="text" name="location" value="' . $user_info["location"] . '"/>';
      echo '</div>';
    echo '</div>';
    move_on_buttons();
  echo '</form>';
  echo '</div>';
}

//MATT ADDING AJAX TO SAVE DESCRIPTORS

function show_my_descriptors_info() {
  $words = get_my_descriptors();
  echo '<div id="descriptors">';
  echo '<form id="desc_submit" method="POST" action="save_descriptors.php">';
  
  $i = 0;

  while ($word = mysql_fetch_array($words)) {
    echo '<div id="des_selector_' . ($i+1) . '" class="des_selector">';
      echo '<div class="title">' . ($i+1) . '.</div>';
      echo '<input type="text" class="desc_input" name="' . ($i + 1) . '" maxlength="15"/>';
      echo '<input type="hidden" name="user_des_id" value="' . $word["user_des_id"] . '"/>';
      echo '<div class="value">';
        echo '<span class="word">' . $word["descriptor"] . '</span><span class="saved"></span>';
        echo '<span class="edit_icon pencil"></span>';
      echo '</div>';

    echo '</div>';
    $i = $i + 1;
  }

  //echo '<span id="hello">Hello!</span>'; //for testing ajax post

  echo '</form>';
  echo '</div>';

}

//END MATT DESCRIPTORS


/*//OLD WAY
function show_my_descriptors_info() {
  $words = get_my_descriptors();
  echo '<div id="descriptors">';
  
  $counter = 0;

  while ($word = mysql_fetch_array($words)) {
    echo '<div id="des_selector_' . (string)($counter+1) . '" class="des_selector">';
      echo '<div class="title">' . (string)($counter+1) . '.</div>';
      echo '<div class="value">';
        echo '<span>' . $word["descriptor"] . '</span>';
        js_edit_framework("desc_" . (string)($counter+1) . "_edit_box", "des_selector_" . (string)($counter+1) . " .value span", "user_descriptor", $word["user_des_id"], $word["descriptor"]);
      echo '</div>';
    echo '</div>';
    $counter = $counter + 1;
  }

  while ($counter < max_descriptors()) {
    echo '<div id="des_selector_' . (string)($counter+1) . '">';

      echo '<div class="title">' . (string)($counter+1) . '.</div>';
      

    echo '</div>';
    $counter = $counter + 1;
  }

  
  echo '</div>';
}

*/

//**************---Matt added for Homepage spacing

function show_my_descriptors_info_home() {
  $words = get_my_descriptors();
  echo '<div id="descriptors">';
  
  $counter = 0;

  while ($word = mysql_fetch_array($words)) {
    echo '<div id="des_selector_' . (string)($counter+1) . '" class="des_selector">';
      echo '<div class="title">' . (string)($counter+1) . '.</div>';
      echo '<div class="value_home">';
        echo '<span>';
          if (strlen($word['descriptor']) > 10) {
            echo substr($word["descriptor"], 0, 10) . '...';
          } 
          else {
            echo $word["descriptor"];
          }
          echo '</span>';
        //js_edit_framework("desc_" . (string)($counter+1) . "_edit_box", "des_selector_" . (string)($counter+1) . " .value span", "user_descriptor", $word["user_des_id"], $word["descriptor"]);
      echo '</div>';
    echo '</div>';
    $counter = $counter + 1;
  }

  while ($counter < max_descriptors()) {
    echo '<div id="des_selector_' . (string)($counter+1) . '">';

      echo '<div class="title">' . (string)($counter+1) . '.</div>';
      

    echo '</div>';
    $counter = $counter + 1;
  }

  
  echo '</div>';
}

//**************ENDMatt

function show_my_interests_info() {
  $isCeleb = null;
  show_interests_info(get_my_chart_id(), $isCeleb);
  /*
  $user_info = my_profile_info();
  echo '<div id="interests">';
   echo '<div id="left_column" class="column">';
    echo '<div id="activities" class="single_interest">';
      echo '<div class="title">Activities</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["activities"] . '</span>';
      echo '</div>';
    echo '</div>';

    echo '<div id="books" class="single_interest">';
      echo '<div class="title">Books</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["books"] . '</span>';
      echo '</div>';
    echo '</div>';

    echo '<div id="spiritual" class="single_interest">';
      echo '<div class="title">Religion/Spirituality</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["spiritual"] . '</span>';
      echo '</div>';
    echo '</div>';
  
    echo '<div id="inspirational_figures" class="single_interest">';
      echo '<div class="title">Inspirational Figures</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["inspirational_figures"] . '</span>';
      echo '</div>';
    echo '</div>';
   echo '</div>';

   echo '<div id="right_column" class="column">';
      echo '<div id="music" class="single_interest">';
      echo '<div class="title" ]>Music</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["music"] . '</span>';
      echo '</div>';
    echo '</div>';
    echo '<div id="film_television" class="single_interest">';
      echo '<div class="title">Film & Television</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["film_television"] . '</span>';
      echo '</div>';
    echo '</div>';
    echo '<div id="political" class="single_interest">';
      echo '<div class="title">Political Views</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["political"] . '</span>';
      echo '</div>';
    echo '</div>';
   echo '</div>';
  echo '</div>';
  */
}


function show_my_general_info() {

  $user_info = my_profile_info();
  if (trim($user_info["location"]) == "") {
    $location = "Unknown";
  }
  else {
    $location = $user_info["location"];
    if ($user_info["country_id"] == 236) {  // UNITED STATES
      $state = get_state ($user_info["state_id"]);
      $location = $user_info["location"] . ', ' . strtoupper($state["state_code"]);
    }
    else {
      $country = get_country ($user_info["country_id"]);
      $location = $location . '<br>' . format_country_name ($country["country_title"]);
    }
  }
  echo '<div class="profile_info_area">';
    echo '<div class="later_on nickname_area">';
    
      echo $user_info["nickname"];
    echo '</div>';
    echo '<div class="name_area">';
      if ($user_info["permissions_id"] == PERMISSIONS_CELEB()) {
        $chart = get_my_chart ();
        $birthday = $chart["birthday"];
      }
      else {
        $birthday = $user_info["birthday"];
      }
      echo calculate_age(substr((string)$birthday, 0, 10));
      
      if (get_my_gender() != "U") {
        echo '/' . get_my_gender();
      }
      echo '<span id="location">&nbsp;' . $location . '</span>';
       //Adding editable location
      echo '<span class="location_edit"></span>';  //HIDING UNTIL COORDINATE WITH LOCATION CHANGES FROM SIGN UP
    echo '</div>';
   
    //echo '<div class="location_area">';
    //  echo $location;
    //echo '</div>';
  echo '</div>';
}

function move_on_buttons () {
  echo '<input type="submit" name="submit" value="Save and Go To the Next Step"/>';
  echo '<input type="submit" name="submit" value="Save and Go To My Profile"/>';
}

function move_on_form () { 
 echo '<div id="move_on_form">';
 echo '<form name="move_on_form" action="move_on.php" method="post">'; 
    move_on_buttons();
  echo '</form>';
  echo '</div>';
}

function show_photos() {
   echo 'Show Photo Here';
}

function show_my_main_photo() {
   echo '<div id="main_photo_box">';
    echo '<div id="border_wrapper">';
     echo '<div id="main_photo">';
     
       $main_photo = get_my_main_photo();
       echo '<div class="fitter">';
         echo format_image($main_photo, $type="profile");
       echo '</div>';
     echo '</div>';
    echo '</div>';
   echo '</div>';

}

function show_my_photo_grid ($link=1) {
  show_interactive_photo_grid (get_my_user_id(),$link);
}

function show_interactive_photo_grid ($user_id,$link=1,$url_offset='') {

  echo '<div id="my_photos">';
  
  $photo_grid = get_photos ($user_id);
  //$length = sizeof($photo_list);
  
  $my_photos = array();
  $my_photo_ids = array();
  while ($photo = mysql_fetch_array($photo_grid)) {
      
      if ($photo["main"] == 0) {  
        
        if ($link==1) {
          //echo '<div class="grid_photo_wrapper_link">';
          if (isAdmin() and $user_id != get_my_user_id()) { // IF ADMIN CHANGING SOMEONE ELSES PROFILE PIC, USE ADMIN TECH
            //$href='change_profile_pic.php?photo_id=' . $photo["user_pic_id"];
          }
          else {                                            // ELSE USE NORMAL TECH
            //$href='change_my_profile_pic.php?photo_id=' . $photo["user_pic_id"];
          }
        }
        else { 
          //echo '<div class="grid_photo_wrapper">';
          $href="#";
        }
            //echo '<div class="grid_photo_border_wrapper profile_tiny">';
              //echo '<div class="grid_photo">'; 
                //echo ORIGINAL_IMAGE_PATH() . $photo['picture'];
                $p = '<a href="/img/user/original/original_' . $photo['picture'] . '" class="magnific_popup">' . format_image($photo["picture"], $type="compare") . '</a>'; 
                $p_id = '<input type="hidden" name="p_id" value="' . $photo["user_pic_id"] . '" />'; 
                //echo $photo["user_pic_id"] . ', ';       
                //echo '<a href="' . $href . ' class="magnific_popup">' . format_image($photo["picture"], $type="thumbnail") . '</a>';
                  
              //echo '</div>';   
            //echo '</div>';
            if ($link==1) { 
              //echo '<div class="delete_grid_photo">'; 
                //echo '<a href="' . $url_offset . 'delete_photo.php?photo_id=' . $photo["user_pic_id"] . '">Delete</a>';
              //echo '</div>';
            }
            else {
              echo '<div class="grid_photo_border_wrapper profile_mouseover">';
              echo '<div class="grid_photo">';          
                echo '<a href="' . $href . '">' . format_image($photo["picture"], $type="compare") . '</a>';
                    
              echo '</div>';   
            echo '</div>';
            }
        
          //echo '</div>';
        array_push($my_photos, $p);  //USER'S PHOTOS
        array_push($my_photo_ids, $p_id);  //USER'S PHOTO IDS
      }
      
        
  }
  //print_r($my_photos);
  //print_r($my_photo_ids);

  //NEW PHOTO GRID
  echo '<table id="photo_table">';
    echo '<tr>';
      $x = 0;
      while ($x<4) {
        if (!empty($my_photos[$x])) {
          echo '<td class="has_photo1"><div class="make_profile_pic later_on">Make Profile Pic</div>' . $my_photos[$x] . '<div class="delete_photo1 later_on">Delete</div>' . $my_photo_ids[$x] . '</td>';
        }
        else {
          echo '<td class="later_on no_photo upload_photo"><div class="div_no_photo later_on">Upload<br> a<br> Photo</div></td>';
        }
        $x++;
      }
      unset($x);
    echo '</tr>';
    echo '<tr>';
      $x = 4;
      while ($x<8) {
        if (!empty($my_photos[$x])) {
          echo '<td class="has_photo2"><div class="make_profile_pic later_on">Make Profile Pic</div>' . $my_photos[$x] . '<div class="delete_photo2 later_on">Delete</div>' . $my_photo_ids[$x] . '</td>';
        }
        else {
          echo '<td class="later_on no_photo upload_photo"><div class="div_no_photo later_on">Upload<br> a<br> Photo</div></td>';
        }
        $x++;
      }
      unset($x);
    echo '</tr>';
  echo '</table>';
  
  echo '</div>';
}

function show_upload_photo_box () {
  echo '<div id="msg_sheen" class="pop_photo">';    
    echo '<div id="msg_sheen_screen" class="pop_photo"></div>';
      echo '<div id="msg_sheen_content" class="pop_photo">';
        echo '<div id="photo_form_profile">';      
          echo '<div class="heading">Upload Your Photo</div>';

        //ERRORS----------

          if (isset($_GET['error'])) {
            log_this_action (profile_action_photos(), error_basic_action(), $error);
            if ($_GET['error'] == 1) {
              echo '<div class="photo_profile_err">There was an error with your photo.  Please try again.</div>';
            }
            elseif ($_GET['error'] == 2) {
              echo '<div class="photo_profile_err">You have too many photos.  Please delete one to upload a new photo.</div>';
            }
            elseif ($_GET['error'] == 3) {
              echo '<div class="photo_profile_err">Please select a photo with the Browse button.</div>';
            }
            elseif ($_GET['error'] == 4) {
              echo '<div class="photo_profile_err">Pease select a valid file.</div>';
            }
            elseif ($_GET['error'] == 5) {
              echo '<div class="photo_profile_err">We are having trouble recognizing this file. Please choose another photo.</div>';
            }
            else {
              echo '<div class="photo_profile_err">There was an error.  Please try again.</div>';
            }
            
          }

        //END ERRORS------------

            echo '<form id="form_photo" action="process_photo.php" method="post" enctype="multipart/form-data">';          
              echo '<input id="image" type="file" name="image"/>';
              echo '<input type="submit" value="Upload" name="action" id="upload_photo" />';
              echo '<div id="cancel_photo" class="later_on">Cancel</div>';
           echo '</form>';
        echo '</div>';
      echo '</div>';
  echo '</div>';
}

function show_delete_photo_box() {
  echo '<div id="msg_sheen" class="d_photo_pop">';    
    echo '<div id="msg_sheen_screen" class="d_photo_pop"></div>';
      echo '<div id="msg_sheen_content" class="d_photo_pop">';
        echo '<div id="delete_photo_box">';
          echo '<div class="heading">Are you sure?</div>';
              echo '<form action="ajax_delete_photo.php" method="post" name="crop_photo_form">';
                echo '<input type="hidden" name="d_p_id" value="" id="d_p_id" />';
                echo '<div id="cancel_delete_photo" class="later_on pointer">Cancel</div>';
                echo '<div id="confirm_delete_photo" class="later_on pointer">Delete</div>';
              echo '</form>';
          echo '</div>'; //close crop_box
        echo '</div>'; //close msg_sheen_content
    echo '</div>'; //close msg_sheen
}

function show_photo_grid ($user_id) {
  echo '<div id="my_photos">';
  if(isLoggedIn()) {
    $photo_grid = get_photos ($user_id);
  //$length = sizeof($photo_list);
  }
  else {
    $photo_grid = get_guest_photos();
  }
  if (mysql_num_rows($photo_grid) > 1) {

    $user_photos = array();
    while ($photo = mysql_fetch_array($photo_grid)) {
 
      if ($photo["main"] == 0) { 

        $p = '<a href="/img/user/original/original_' . $photo['picture'] . '" class="magnific_popup">' . format_image($photo["picture"], $type="compare") . '</a>';
        array_push($user_photos, $p);
        //echo $photo['picture'];
        /*
       echo '<div class="grid_photo_wrapper">';

        echo '<div class="grid_photo_border_wrapper profile_tiny">';
          echo '<div class="grid_photo">';
            //echo '<a href="#">' . format_image($photo["picture"], $type="thumbnail", $user_id) . '</a>';
            echo '<a href="#">' . format_image($photo["picture"], $type="thumbnail", $user_id) . '</a>';
          echo '</div>';       
        echo '</div>';

        echo '<div class="grid_photo_border_wrapper profile_mouseover ">';
          echo '<div class="grid_photo">
             <a href="#">' . format_image($photo["picture"], $type="compare", $user_id) . '</a>';
          echo '</div>';       
        echo '</div>';
        
       echo '</div>';
       */
      }             
    }
//NEW PHOTO GRID-----------
    //print_r($user_photos);
    
    echo '<table id="photo_table">';
      echo '<tr>';
      $total_photos = count($user_photos);
      //echo $total_photos;
        $x = 0;
        foreach ($user_photos as $photo_link) {
          if ($x < 4 ) {
            echo '<td>' . $photo_link . '</td>';
            $x++;
          }        
        }
      echo '</tr>';
    if ($total_photos > 3) {
      echo '<tr>';
      $x2 = $x;
      //echo $x2;
      do {
        echo '<td>' . $user_photos[$x2] . '</td>';        
        $x2++;
      } while ($x2 < $total_photos);
      unset($x);
      unset($x2);
      echo '</tr>';
    
    }
    echo '</table>';
  }
  else {
    echo '<div class="later_on" style="font-size:1.5em;">' . get_nickname($user_id) . ' has no other photos.</div>';
  } 
  
  echo '</div>';
}


/************---Matt adding tiny photo on Homepage about you box----*/

function show_tiny_photo ($user_id) {
  
  $tiny_photo = get_main_photo ($user_id);
  //$length = sizeof($photo_list);
       //echo '<div class="grid_photo_wrapper">';

        //echo '<div class="grid_photo_border_wrapper profile_tiny">';
          //echo '<div class="grid_photo">';
            echo '<div class="user_button">';
            //echo '<a href="#">' . format_image($photo["picture"], $type="thumbnail", $user_id) . '</a>';
            echo '<a href="#">' . format_image($photo["picture"], $type="thumbnail", $user_id) . '</a>';
            echo '</div>';
          //echo '</div>';       
        //echo '</div>';
        
       //echo '</div>';
  
}

/*************EndMatt---*/

function show_photo_cropper_old($photo_to_crop) {
  $img_id = $photo_to_crop["user_pic_id"];
  $img_name = $photo_to_crop["picture"];
  echo '<div id="photo_cropping_area">';
    echo '<img id="photo_crop_' . $img_id . '" src="' . ORIGINAL_IMAGE_PATH() . $img_name . '?' . time() . '">';
    echo '<input id="crop_and_set" type="submit" name="submit" value="Crop and Set"/>';
    echo '<input id="rotate_left" type="submit" name="submit" value="<- Rotate"/>';
    echo '<input id="rotate_right" type="submit" name="submit" value="Rotate ->"/>';
    echo '<input type="hidden" name="x1" id="x1" value=""/>';
    echo '<input type="hidden" name="y1" id="y1" value=""/>';
    echo '<input type="hidden" name="x2" id="x2" value=""/>';
    echo '<input type="hidden" name="y2" id="x2" value=""/>';
    echo '<input type="hidden" name="w" id="w" value=""/>';
    echo '<input type="hidden" name="h" id="h" value=""/>';
  echo '</div>';

  //echo '<div id="photo_cropping_preview">';
  //  echo '<img id="preview_' . $img_id . '">';
  //echo '</div>';

  activate_photo_cropper ($img_id, $img_name, 'x1', 'y1', 'x2', 'y2', 'w', 'h');
}

function show_photo_cropper($photo_to_crop) {
  $img_id = $photo_to_crop["user_pic_id"];
  //$img_name = str_replace('\'', '', $photo_to_crop["picture"]);
  $img_name = $photo_to_crop["picture"];
  echo '<div class="photo_cropper_content">';
    echo '<div id="zoom">Use scrollbar to zoom</div>';
    echo '<div class="cropSlider"></div>';
    echo '<div id="rotate">';
      echo '<input id="rotate_left" type="submit" name="submit" value="<- Rotate"/>';
      echo '<input id="rotate_right" type="submit" name="submit" value="Rotate ->"/>';
    echo '</div>';
    echo '<div class="cropMain" style="margin:auto;"></div>';
    echo '<div style="width:500px; margin:20px auto auto;"><button class="cropButton" />Crop and Set</button></div>';
    
    


    echo '<style>
 
   	    .photo_cropper_content .cropMain {
		width:500px;
		height:500px;
	    }
 
          </style>

    ';

    //echo '<img id="photo_crop_' . $img_id . '" src="' . ORIGINAL_IMAGE_PATH() . $img_name . '?' . time() . '">';    
    //echo '<input type="hidden" name="x1" id="x1" value=""/>';
    //echo '<input type="hidden" name="y1" id="y1" value=""/>';
    //echo '<input type="hidden" name="x2" id="x2" value=""/>';
    //echo '<input type="hidden" name="y2" id="x2" value=""/>';
    //echo '<input type="hidden" name="w" id="w" value=""/>';
    //echo '<input type="hidden" name="h" id="h" value=""/>';
  echo '</div>';

  activate_photo_cropper ($img_id, $img_name);
}


function show_main_photo($chart_id) {
  echo '<div id="main_photo_box">';
   echo '<div id="border_wrapper">';
     echo '<div id="main_photo">';
       //echo '* Chart ID: ' . $chart_id . ' - ' . get_user_id_from_chart_id ($chart_id) . '*';
       //die();
       $main_photo = get_main_photo(get_user_id_from_chart_id ($chart_id));
       echo '<div class="fitter">';
         echo format_image($main_photo, $type="profile",get_user_id_from_chart_id ($chart_id));
       echo '</div>';
     echo '</div>';
   echo '</div>';
  echo '</div>';
}

function show_general_info($chart_id, $from='default') {
  $user_id = get_user_id_from_chart_id ($chart_id);
  $user_info = profile_info($user_id);
  $is_celeb = $user_info["permissions_id"] == PERMISSIONS_CELEB();
  if (trim($user_info["location"]) == "") {
    $location = "Unknown";
  }
  else {
    $location = $user_info["location"];
    if ($user_info["country_id"] == 236) {  // UNITED STATES
      $state = get_state ($user_info["state_id"]);
      $location = $user_info["location"]. ', ' . strtoupper($state["state_code"]);
    }
    if (isLoggedIn()) {
      $my_info = my_profile_info();      
    }
    else {
      $my_info['country_id'] = 236;
    }
    if (!($user_info["country_id"] == $my_info["country_id"])) {
      $country = get_country ($user_info["country_id"]);
      $location = $location . ', ' . format_country_name ($country["country_title"]);
    }
    //elseif ($user_id == get_guest_user_id()) { //GUEST VIEW
      //$location = $user_info["location"]. ', ' . strtoupper($state["state_code"]);
    //}
  }
  if (is_online($user_id)) {$online_color = 'green';} elseif (is_away($user_id)) {$online_color = 'orange';} else {$online_color = 'red';} 
  echo '<div class="profile_info_area">';
    echo '<div class="later_on nickname_area';
      if ($is_celeb) {
        echo '_celeb">';
        echo $user_info["first_name"] . ' ' . $user_info["last_name"];
      }
      else {
        if(!isLoggedIn() && $_GET['the_page'] != 'psel' && ($_GET['tier'] == 2 || $_GET['tier'] == 3)) {
          echo '" style="line-height:2;">';
        }
        else {
          echo '">';
        }
        if (isLoggedIn()) {
          //echo 'from:' . $from;
          if ($from == 'nts') {
            echo '';
            //echo 'from nts:' . $from;
          }
          elseif ($from == 'default') {
            echo '<span style="color:' . $online_color . '; font-family:arial;">•</span>';
            //echo 'from0:' . $from;
          } 
          else {
            echo '<span style="color:' . $online_color . '; font-family:arial;">•</span>';
            //echo 'from else:' . $from;
          }
        }
        echo $user_info["nickname"];
      }
    echo '</div>';
      if ($is_celeb) {
        $chart = get_chart ($chart_id);
        $birthday = $chart["birthday"];
      }
      else {
        $birthday = $user_info["birthday"];
      }
      if (!$is_celeb) {
        $age_private = get_preferences(get_user_id_from_chart_id($chart_id), 'age_private', 0);
        echo '<div class="name_area">';
        if ($age_private == 0) {
          echo calculate_age(substr((string)$birthday, 0, 10)) . '/';
        }
        if (get_gender($user_info["user_id"]) != "U") {
          echo get_gender($user_info["user_id"]);
        }
        echo ' ' . $location;
        echo '</div>';
      }
    
    //echo '<div class="location_area">';
    //  echo $location;
    //echo '</div>';
  echo '</div>';
}


function general_info_for_scroll ($chart_id, $user_id) {
  //$user_id = get_user_id_from_chart_id ($chart_id);
  $user_info = profile_info($user_id);
  $is_celeb = $user_info["permissions_id"] == PERMISSIONS_CELEB();
  if (trim($user_info["location"]) == "") {
    $location = "Unknown";
  }
  else {
    $location = $user_info["location"];
    if ($user_info["country_id"] == 236) {  // UNITED STATES
      $state = get_state ($user_info["state_id"]);
      $location = $user_info["location"]. ', ' . strtoupper($state["state_code"]);
    }
    if (isLoggedIn()) {
      $my_info = my_profile_info();      
    }
    else {
      $my_info['country_id'] = 236;
    }
    if (!($user_info["country_id"] == $my_info["country_id"])) {
      $country = get_country ($user_info["country_id"]);
      $location = $location . ', ' . format_country_name ($country["country_title"]);
    }
  }
  if (is_online($user_id)) {$online_color = 'green';} elseif (is_away($user_id)) {$online_color = 'orange';} else {$online_color = 'red';} 

  if (isLoggedIn()) {
    if(!$is_celeb) { //USER
      $birthday = $user_info["birthday"];
      $age = calculate_age(substr((string)$birthday, 0, 10));
      $age_private = get_preferences($user_id, 'age_private', 0);
      //return '<div>' . $age . '&bull;</div>';
      if ($age_private == 0) {
        return '<div class="profile_info_area"><div class="later_on nickname_area">' . $user_info["nickname"] . '</div><div class="name_area">' . $age . '/' . get_gender($user_id) . ' ' . $location . '</div></div>';
      }
      else {
        return '<div class="profile_info_area"><div class="later_on nickname_area">' . $user_info["nickname"] . '</div><div class="name_area">' . get_gender($user_id) . ' ' . $location . '</div></div>';
      }
      //<span style="color:' . $online_color . '; font-family:arial;">&bull;</span>
    }
    else { //IS_CELEB
      //return 'Hello';
      return '<div class="profile_info_area"><div class="later_on nickname_area_celeb">' . $user_info["first_name"] . ' ' . $user_info["last_name"] . '</div></div>';
    }
  }
  else { //NOT LOGGED IN
    if(!$is_celeb) { //USER
      $birthday = $user_info["birthday"];
      $age = calculate_age(substr((string)$birthday, 0, 10));
      $age_private = get_preferences($user_id, 'age_private', 0);
      if ($age_private == 0) {
        return '<div class="profile_info_area"><div class="later_on nickname_area">' . $user_info["nickname"] . '</div><div class="name_area">' . $age . '/' . get_gender($user_id) . ' ' . $location . '</div></div>'; 
      }
      else {
        return '<div class="profile_info_area"><div class="later_on nickname_area">' . $user_info["nickname"] . '</div><div class="name_area">' . get_gender($user_id) . ' ' . $location . '</div></div>'; 
      } 
    }
    else { //IS_CELEB
      return '<div class="profile_info_area"><div class="later_on nickname_area_celeb">' . $user_info["first_name"] . ' ' . $user_info["last_name"] . '</div></div>';
    }
  }
}

//-----------------Matt added so Interests on Other's Profile only show up if filled out

function show_interests_info($chart_id, $isCeleb) {
  $user_id = get_user_id_from_chart_id ($chart_id);
  if(isLoggedIn()) { 
    $my_user_id = get_my_user_id();
  }
  else {
    $my_user_id = get_guest_user_id();
  }
  $user_info = profile_info($user_id);
  $nickname = get_nickname($user_id);
  $gender = get_gender($user_id);
  if($gender == "M") {
    $gender = "his";
  }
  elseif($gender == "F") {
    $gender = "her";
  }
  else{
    $gender = "their";
  }

  if($user_id == $my_user_id) {
    echo '<div id="interests">';
     echo '<div id="left_column" class="column">';

     echo '<div id="biography" class="single_interest">';
        echo '<div class="title">Biography</div>';
         echo '<div class="value text_block">';
          echo '<span>' . $user_info["about_me"] . '</span>';
        echo '</div>';
      echo '</div>';

      echo '<div id="activities" class="single_interest">';
        echo '<div class="title">Activities</div>';
          echo '<div class="value text_block">';
            echo '<span>' . $user_info["activities"] . '</span>';
       echo '</div>';
     echo '</div>';

     echo '<div id="music" class="single_interest">';
        echo '<div class="title" ]>Music</div>';
         echo '<div class="value text_block">';
          echo '<span>' . $user_info["music"] . '</span>';
        echo '</div>';
      echo '</div>';

      echo '<div id="film_television" class="single_interest">';
        echo '<div class="title">Film & Television</div>';
        echo '<div class="value text_block">';
          echo '<span>' . $user_info["film_television"] . '</span>';
        echo '</div>';
      echo '</div>';

      echo '<div id="books" class="single_interest">';
        echo '<div class="title">Books</div>';
        echo '<div class="value text_block">';
          echo '<span>' . $user_info["books"] . '</span>';
        echo '</div>';
      echo '</div>';

      echo '<div id="political" class="single_interest">';
        echo '<div class="title">Political Views</div>';
        echo '<div class="value text_block">';
          echo '<span>' . $user_info["political"] . '</span>';
        echo '</div>';
      echo '</div>';

      echo '<div id="spiritual" class="single_interest">';
        echo '<div class="title">Religion/Spirituality</div>';
        echo '<div class="value text_block">';
          echo '<span>' . $user_info["spiritual"] . '</span>';
        echo '</div>';
      echo '</div>';
  
      echo '<div id="inspirational_figures" class="single_interest">';
        echo '<div class="title">Inspirational Figures</div>';
        echo '<div class="value text_block">';
          echo '<span>' . $user_info["inspirational_figures"] . '</span>';
        echo '</div>';
      echo '</div>';
     echo '</div>'; //closing left_column

   

   /* 
   echo '<div id="right_column" class="column">';
    
   
    
   echo '</div>';
   */
    echo '</div>'; //closing #interests
  }
  else {
    echo '<div id="interests">';
     echo '<div id="left_column" class="column">';
     if((strlen($user_info["about_me"]) + strlen($user_info["activities"]) + strlen($user_info["music"])
          + strlen($user_info["film_television"]) + strlen($user_info["books"]) + strlen($user_info["political"]) 
          + strlen($user_info["spiritual"]) + strlen($user_info["inspirational_figures"])) == 0 ) {
      if (!$isCeleb) {
        echo "<div class='later_on' style='font-size:1.3em;' id='profile_empty'>" . $nickname . " has not filled out " . $gender . " profile yet</div>";
        echo "</div>"; //Close left_column
      }
      else {
        echo "<div class='later_on' style='font-size:1.3em;' id='profile_empty'>We have not added content for " . $user_info['first_name'] . " " . $user_info['last_name'] . " yet.</div>";
        echo "</div>"; //Close left_column
      }
     }
     else{
        if(strlen($user_info["about_me"]) != 0) {
           echo '<div id="biography" class="single_interest">';
              echo '<div class="title">Biography</div>';
               echo '<div class="value text_block">';
                echo '<span>' . $user_info["about_me"] . '</span>';
              echo '</div>';
            echo '</div>';
        }
        else {
          echo "";
        }
        if(strlen($user_info["activities"]) !=0) {
          echo '<div id="activities" class="single_interest">';
           echo '<div class="title">Activities</div>';
              echo '<div class="value text_block">';
                echo '<span>' . $user_info["activities"] . '</span>';
            echo '</div>';
          echo '</div>';
        }
        else {
          echo "";
        }
        if(strlen($user_info["music"]) != 0) {
          echo '<div id="music" class="single_interest">';
              echo '<div class="title" ]>Music</div>';
               echo '<div class="value text_block">';
                echo '<span>' . $user_info["music"] . '</span>';
             echo '</div>';
            echo '</div>';
        }
        else {
          echo "";
        }
        if(strlen($user_info["film_television"]) != 0) {
            echo '<div id="film_television" class="single_interest">';
              echo '<div class="title">Film & Television</div>';
              echo '<div class="value text_block">';
                echo '<span>' . $user_info["film_television"] . '</span>';
              echo '</div>';
            echo '</div>';
        }
        else {
          echo "";
        }
        if(strlen($user_info["books"]) != 0) {
            echo '<div id="books" class="single_interest">';
              echo '<div class="title">Books</div>';
              echo '<div class="value text_block">';
                echo '<span>' . $user_info["books"] . '</span>';
             echo '</div>';
            echo '</div>';
        }
        else {
          echo "";
        }
        if(strlen($user_info["political"]) != 0) {
            echo '<div id="political" class="single_interest">';
              echo '<div class="title">Political Views</div>';
              echo '<div class="value text_block">';
                echo '<span>' . $user_info["political"] . '</span>';
              echo '</div>';
           echo '</div>';
        }
        else {
          echo "";
        }
        if(strlen($user_info["spiritual"]) != 0) {
            echo '<div id="spiritual" class="single_interest">';
              echo '<div class="title">Religion/Spirituality</div>';
              echo '<div class="value text_block">';
                echo '<span>' . $user_info["spiritual"] . '</span>';
              echo '</div>';
            echo '</div>';
        }
        else {
          echo "";
        }
        if(strlen($user_info["inspirational_figures"]) != 0) {  
            echo '<div id="inspirational_figures" class="single_interest">';
              echo '<div class="title">Inspirational Figures</div>';
              echo '<div class="value text_block">';
                echo '<span>' . $user_info["inspirational_figures"] . '</span>';
              echo '</div>';
            echo '</div>';
          echo '</div>';  //Close left_column
        }
        else {
          echo "";
          echo '</div>';  //Close left_column
        }
    }
   

   /* 
   echo '<div id="right_column" class="column">';
    
   
    
   echo '</div>';
   */
    //echo '</div>'; //closing left_column
    echo '</div>'; //closing #interests
  }
}


/*
function show_interests_info($chart_id) {
  $user_info = profile_info(get_user_id_from_chart_id ($chart_id));
  echo '<div id="interests">';
   echo '<div id="left_column" class="column">';

    echo '<div id="biography" class="single_interest">';
      echo '<div class="title">Biography</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["about_me"] . '</span>';
      echo '</div>';
    echo '</div>';

    echo '<div id="activities" class="single_interest">';
      echo '<div class="title">Activities</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["activities"] . '</span>';
      echo '</div>';
    echo '</div>';

    echo '<div id="music" class="single_interest">';
      echo '<div class="title" ]>Music</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["music"] . '</span>';
      echo '</div>';
    echo '</div>';

    echo '<div id="film_television" class="single_interest">';
      echo '<div class="title">Film & Television</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["film_television"] . '</span>';
      echo '</div>';
    echo '</div>';

    echo '<div id="books" class="single_interest">';
      echo '<div class="title">Books</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["books"] . '</span>';
      echo '</div>';
    echo '</div>';

    echo '<div id="political" class="single_interest">';
      echo '<div class="title">Political Views</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["political"] . '</span>';
      echo '</div>';
    echo '</div>';

    echo '<div id="spiritual" class="single_interest">';
      echo '<div class="title">Religion/Spirituality</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["spiritual"] . '</span>';
      echo '</div>';
    echo '</div>';
  
    echo '<div id="inspirational_figures" class="single_interest">';
      echo '<div class="title">Inspirational Figures</div>';
      echo '<div class="value">';
        echo '<span>' . $user_info["inspirational_figures"] . '</span>';
      echo '</div>';
    echo '</div>';
   echo '</div>';

   

    
   //echo '<div id="right_column" class="column">';
    
   
    
   //echo '</div>';
   
  echo '</div>';
}
*/



function show_descriptors_info($chart_id) {
  $words = get_descriptors(get_user_id_from_chart_id ($chart_id));
  echo '<div id="descriptors">';
  
  $counter = 0;

  while ($word = mysql_fetch_array($words)) {
    echo '<div id="des_selector_' . (string)($counter+1) . '" class="des_selector">';
      echo '<div class="title">' . (string)($counter+1) . '.</div>';
      echo '<div class="value_others">';
        echo '<p>' . $word["descriptor"] . '</p>';
      echo '</div>';
    echo '</div>';
    $counter = $counter + 1;
  }

  while ($counter < max_descriptors()) {
    echo '<div id="des_selector_' . (string)($counter+1) . '">';

      echo '<div class="title">' . (string)($counter+1) . '.</div>';
      

    echo '</div>';
    $counter = $counter + 1;
  }

  
  echo '</div>';
}



function upload_photo_form() {
  
  //show_my_main_photo();
  //echo num_my_photos();
  echo '<div id="upload_photo_form">
    <br>You may upload <b><span style="color:red">' . (max_photos() - num_my_photos()) . '</span></b> more photo(s)<br><br>
    <form action="process_photo.php" method="post" enctype="multipart/form-data">
    Upload Photo: <input type="file" name="image" /><input type="submit" value="Upload" name="action" />
    </form>
  </div>';
  if (isset($_GET['error']) == 3) {
    echo '<div style="color:#C82923; position:relative; left:524px; bottom: 58px;">No file selected</div>';
  }
  //echo '<div style="">
    //Click on a photo to set it as your profile picture.
  //</div>';
  show_my_photo_grid();
   
  //move_on_form();
}

function upload_photo_form_admin($user_id) {
  $chart = get_chart_by_name('Main',$user_id);
  show_main_photo($chart["chart_id"]);
  echo '<div id="upload_photo_form">
    <br>You may upload <b><span style="color:red">' . (max_photos() - num_photos($user_id)) . '</span></b> more photo(s)<br><br><br>
    <form action="process_photo_admin.php" method="post" enctype="multipart/form-data"> 
    Upload Photo: <input type="file" name="image" /><input type="submit" value="Upload" name="action" />
    <input name="user_id" value="' . $user_id . '" type="hidden"/>
    </form>
  </div>';
  show_interactive_photo_grid ($user_id,$link=1, '../');
}

function get_left_menu ($the_page) {
  for ($x=1; $x<=6; $x++) {
    $menu['nav' . $x] = array('','#'); 
  }
  if ($the_page == 'cesel') {
    $menu['nav1'] = array('Celebrities&nbsp;&nbsp;','celebrities.php');
    /*$menu['nav2'] = array('Houses&nbsp;&nbsp;','#');
    $menu['nav3'] = array('&nbsp;&nbsp;','#');
    $menu['nav4'] = array('Career Advice&nbsp;&nbsp;','#');
    $menu['nav5'] = array('My Birth Info&nbsp;&nbsp;','birth_info.php');
    $menu['nav6'] = array('About Astrology&nbsp;&nbsp;','two_zodiacs.php');
    */
  }
  elseif ($the_page == 'psel') {
    $menu['nav1'] = array('Profile&nbsp;&nbsp;','non_chart_profile.php');
    //$menu['nav2'] = array('houses&nbsp;&nbsp;','#');
    //$menu['nav2'] = array('Romantic Advice&nbsp;&nbsp;','romantic_advice.php');
    //$menu['nav3'] = array('Career Advice&nbsp;&nbsp;','career_advice.php');
    $menu['nav2'] = array('Why Vedic Astrology?','two_zodiacs.php');
    $menu['nav3'] = array('My Birth Info&nbsp;&nbsp;','birth_info.php');
    $menu['nav4'] = array('Cookbook Astrology&nbsp;&nbsp;','cookbook_astrology.php');
    //$menu['nav6'] = array('Career&nbsp;&nbsp;','#');
    //$menu['nav6'] = array('about astrology&nbsp;&nbsp;','two_zodiacs.php');
  }
  elseif ($the_page == 'cosel') {
    //$menu['nav1'] = array('New to Starma&nbsp;&nbsp;','all_users.php');
    $menu['nav1'] = array('New to Starma&nbsp;&nbsp;','new_to_starma.php');
    $menu['nav2'] = array('Favorites&nbsp;&nbsp;','favorites.php');
    //$menu['nav3'] = array('Celebrities&nbsp;&nbsp;','celebrities.php');
    $menu['nav3'] = array('Custom Chart&nbsp;&nbsp;', 'enter_user.php');
    //$menu['nav4'] = array('Find Friends&nbsp;&nbsp;', 'search.php');  //SEARCH TESTING
    
  }
  elseif ($the_page == 'hsel') {
    $menu['nav1'] = array('Welcome&nbsp;&nbsp;','welcome.php');
    $menu['nav2'] = array('About Starma&nbsp;&nbsp;', 'about_starma.php');
    $menu['nav3'] = array('Why Vedic Astrology?','two_zodiacs.php');
    $menu['nav4'] = array('Cookbook Astrology&nbsp;&nbsp;','cookbook_astrology.php');
    
  }
  elseif ($the_page == 'isel') {
    $menu['nav1'] = array('Inbox&nbsp;&nbsp;','inbox.php');
    
  }
  elseif ($the_page == 'ssel') {
    $menu['nav1'] = array('Settings&nbsp;&nbsp;','settings.php');
    //$menu['nav2'] = array('Log Out&nbsp;&nbsp;','main_logout.php');
    
  }
  
  return $menu;
}


function edit_profile_form ($user_id) {  // FOR ADMINS ONLY
  if (permissions_check ($req = 10)) {
    if ($info = profile_info($user_id)) {
      $nickname = $info["nickname"];
      $first_name = $info["first_name"];
      $last_name = $info["last_name"];
      $gender = $info["gender"];
      $about_me = $info["about_me"];
    } 
    else {
      $nickname = "";
      $first_name = "";
      $last_name = "";
      $gender = "M";
      $about_me = "";
    }
    echo '<form name="edit_profile_form" method="POST" action="edit_profile.php">';
       echo '<table>';
         echo '<tr>';
           echo '<td>Nickname:</td><td><input name="nickname" type="text" ';
           if ($user_id != '-1') {
             echo 'DISABLED ';
           }
           echo 'value="' . $nickname . '"/></td>';
         echo '</tr>';
         echo '<tr>';
           echo '<td>First Name:</td><td><input name="first_name" type="text" value="' . $first_name . '"/></td>';
         echo '</tr>';
         echo '<tr>';
           echo '<td>Last Name:</td><td><input name="last_name" type="text" value="' . $last_name . '"/></td>';   
         echo '</tr>';
         echo '<tr>';
           echo '<td>Gender:</td><td>';
           gender_select ($gender);
           echo '</td>';
         echo '</tr>';
         echo '<tr>';
           echo '<td>Biography:</td><td><textarea name="about_me">' . $about_me . '</textarea></td>';   
         echo '</tr>';
         echo '<tr>';
           echo '<td></td><td><input name="submit" type="submit" value="Submit"/></td>';     
         echo '</tr>';
         
       echo '</table>';
       echo '<input type="hidden" name="user_id" value="' . $user_id . '"/>';
    echo '</form>';
  }
}

function show_desc_photo_form($errors, $des_names,$action="birth_info_first_time.php") {
  echo '<div id="desc_photo_form_div">';
    echo '<h1>';
      echo "What 3 Words describe you best?";
    echo '</h1>';
    //echo '<div id="img_div">';
    //  echo '<img id="desc_img_1" src="img/account_info/Starma-Astrology-GenderBox.png"/>';
    //  echo '<img id="desc_img_2" src="img/account_info/Starma-Astrology-GenderBox.png"/>';
    //  echo '<img id="desc_img_3" src="img/account_info/Starma-Astrology-GenderBox.png"/>';
    //echo '</div>';
 
    

    echo '<div id="edit_descriptors">';

      echo '<form id="desc_form" name="descriptor_form" action="' . $action . '" method="post">';
      $counter = 0;

      while ($counter < max_descriptors()) {
        echo '<div id="des_selector_' . (string)($counter+1) . '" class="selector">';

          
          echo '<div class="value">';
            echo '<input type="text" name="des_name_' . (string)($counter+1) . '" value="' . $des_names[$counter] . '"/>';
          echo '</div>';

        echo '</div>';
        $counter = $counter + 1;
      }

      echo '<div id="register_button_div">';
       echo '<input id="bug_button" type="submit" value="" name="desc_photo_submit">';
      echo '</div>';

      echo '</form>';
    echo '</div>';


    echo '<div id="photo_form_div">';
      
        echo '<h1>';       
          echo 'Upload your profile photo:';
        echo '</h1>';
        echo '<form id="form_photo" action="process_photo.php" method="post" enctype="multipart/form-data">';
          echo '<div id="photo_display">';
            echo '<div id="my_tiny_photo"><div class="grid_photo_border_wrapper"><div class="grid_photo">';
              show_user_inbox_picture ('', get_my_user_id());
            echo '</div></div></div>';
          echo '</div>';
          echo '
          <input type="file" name="image" onchange="
                   $(\'#form_photo #des_1\').val($(\'#desc_form #des_selector_1 .value input\').val());
                   $(\'#form_photo #des_2\').val($(\'#desc_form #des_selector_2 .value input\').val());
                   $(\'#form_photo #des_3\').val($(\'#desc_form #des_selector_3 .value input\').val());
                   $(\'#form_photo\').submit();
                   $(this).prop( \'disabled\', true ); 
                   $(\'#desc_photo_first_time #enter_info #desc_photo_form_div #register_button_div input\').prop( \'disabled\', true ); 
          "/>
          <input type="hidden" name="firsttime" value="1"/>
          <input type="hidden" id="des_1" name="des_name_1" value=""/>
          <input type="hidden" id="des_2" name="des_name_2" value=""/>
          <input type="hidden" id="des_3" name="des_name_3" value=""/>
        </form>';
      
      
      
    echo '</div>';

     echo '<div id="go_bug_path" class="go_bug_path_fix_desc_photo"></div>';

   

    $output = $errors;

    echo '<div class="error';
    if (!in_array(NOT_WORDS_ERROR(), $output)) {echo ' hidden_error';}
    echo '" id="not_words_error">';
    echo 'Words cannot contain spaces or be left blank';
    echo '</div>';
    
    echo '<div class="error';
    if (!in_array(PHOTO_ERROR(), $output)) {echo ' hidden_error';}
    echo '" id="photo_first_time_error">';
    echo 'You must upload a profile photo';
    echo '</div>';

    echo '<div class="error';
    if (!in_array(ILLEGAL_WORDS_ERROR(), $output)) {echo ' hidden_error';}
    echo '" id="illegal_words_error">';
    echo 'No naughty words please';
    echo '</div>';
    
    //clear_error();
  echo '</div>';
}

function show_gender_location_form ($errors = array(), $title="", $country_id, $gender, $action="desc_photo_first_time.php") {
  echo '<div id="gender_location_form_div">';
      //echo '<div id="img_div">';
      //  echo '<img id="gender_img" src="img/account_info/Starma-Astrology-GenderBox.png"/>';
      //  echo '<img id="country_img" src="img/account_info/Starma-Astrology-CountryBox.png"/>';
      //  echo '<img id="zip_img" src="img/account_info/Starma-Astrology-ZipBox.png"/>';
        
      //echo '</div>';
      
      echo '<form id="gender_location_form" method="post" action="' . $action . '">';
      echo '<div id="input_divs">';
        echo '<table>
          <tr>
           <td class="align_right">gender:</td>
           <td>';
              gender_select ($the_gender=$gender, $the_name="gender");
            echo '</td>
          </tr>

          <tr>
           <td class="align_right"></td>
           <td>
              Current Location
           </td>
          </tr>

          <tr>
           <td class="align_right">country:</td>
           <td>';
              country_select ($country_id, "js_country_id");
           echo '</td>
          </tr>

          <tr id="js_city_div">
           <td class="align_right">city:</td>
           <td><input type="text" name="title" value="' . $title . '"/></td>
          </tr>

          <tr id="js_zip_div">
           <td class="align_right">zip:</td>
           <td>';
             zipcode_input ("zip", "location_verification .location_text");
           echo '</td>
           
            
          </tr>
          
          <tr id="location_verification">
           <td></td>
           <td class="location_text"></td>
           
          </tr>
         </table>';

        
         echo '<div id="go_bug_path"></div>';
        echo '<div id="register_button_div">';
          echo '<input id="bug_button" type="submit" value="" name="location_gender_submit">';
        echo '</div>';

     echo '</div>';
    echo '</form>';
  echo '</div>';

  //Javascript handler for changing if you select a different country
  echo '<script type="text/javascript">';
    echo '$("select[name=js_country_id]").change(function(event) { 
      //alert ("stuff");
      if ($("select[name=js_country_id]").val() == "236") {
        $("#js_zip_div").show();
        $("#location_verification").css(\'visibility\', \'visible\');
        $("#js_city_div").hide();
        
      }
      else {
        $("#js_zip_div").hide();
        $("#location_verification").css(\'visibility\', \'hidden\');
        $("#js_city_div").show();
      }
    })';
  echo '</script>';
  
  if ($country_id != 236) {
    echo '<script type="text/javascript">';
     
       echo '$("#js_zip_div").hide();';
       echo '$("#location_verification").css(\'visibility\', \'hidden\')'; 
       echo '$("#js_city_div").show();';
       
  
    echo '</script>';
  }
}

//MATT ADDED FOR CHANGING LOCATION ONLY

function show_current_location_form() {

  //$title = get_my_location();
  $country_id = get_my_country_id();
      echo '<div id="current_location">
            <div style="margin:auto; text-align:center; font-weight:bold; padding-bottom: 10px;">Current Location</div>';
            //<form id="current_location_form" action="chat/ajax_update_current_location.php" method="POST">
       echo  '<table style="margin:auto;">

              <tr>
                <td class="align_right">country:</td>
                <td>';
                  country_select ($country_id, "js_country_id");
                  echo '<input type="hidden" name="country_id" value="' . $country_id . '">';
          echo '</td>
              </tr>';
            //if(!$country_id == 236) {
              echo '<tr id="js_city_div">
                <td class="align_right">city:</td>
                <td><input type="text" name="title" value=""/></td>
                <td><span class="location_error_area" id="title_error"></span></td>
              </tr>';
            //}
             echo '<tr id="js_zip_div">
                <td class="align_right">zip:</td>
                <td>';
              
              echo zipcode_input ("zip", "location_verification .location_text");
           echo '</td>
                <td><span class="location_error_area" id="zip_error"></span></td>
            
              </tr>
          
              <tr id="location_verification">
                <td></td>
                <td class="location_text"></td>
           
              </tr>
          </table>';

        
         
       echo '<div style="width:100%;">
              <input type="submit" name="submit" value="Send" class="location_send"/>
              <button type="button" name="cancel" class="location_cancel">Cancel</button>
            </div>';

     echo '</div>'; //close current_location
    //echo '</form>';


  //Javascript handler for changing if you select a different country
    echo '<script type="text/javascript" src="js/current_location.js"></script>';
}



///MATT ADDED FUNCTION TO STYLE CUSTOM BIRTH FORM

function show_birth_info_form_custom ($errors = array(), $sao=0, $title="", $action="cast_chart.php", $stage=1) {
  
  if (isset($_SESSION["change_info"])) {
    $type="mine";
  }
  else if ($stage==2 && get_chart_by_name("Freebie1")) {
    $type="freebie";
  }
  else if (isset($_SESSION["proxy_user_id"]) and get_chart_by_name("Main",$_SESSION["proxy_user_id"]) and isAdmin()) {
    $type=$_SESSION["proxy_user_id"];
  }
  else {
    $type="default";
  }
  //print_r ($_SESSION["chart_input_vars"]);
  echo '<div id="birth_info_custom">';
    echo '<div class="later_on" style="font-size:2em; text-align:center;">Birth Info</div>';
    echo '<div id="birth_info_form_custom">
          <form id="birth_info_form" method="post" action=' . $action . '>';
            //echo '<table>';
//// THIS AREA ONLY APPLIES TO ENTERING SOMEONE ELSES USER INFORMATION (AS AN ADMIN OR OTHERWISE) OR UPDATING YOUR OWN ////
  if ($stage == 2 or isset($_SESSION["change_info"]) or (isAdmin() and isset($_SESSION["proxy_user_id"]))) {
     //echo '     <tr>
                  //<td id="birth_date_input" class="align_right">';
                echo '<div style="display:inline-block; margin-right: 30px;">';
                     echo '<div class="later_on" style="font-size:1.19em;">Date of Birth</div>
                     <input type="hidden" name="stage" value="' . $stage . '"/>';
                  //echo '</td>
                  //<td id="birth_date_input" colspan="2">';
                    date_select ($the_date=get_inputed_date($type), $the_name="birthday");
                    //echo 'date test: ' . get_inputed_date($type);
                    //echo '<br> type: ' . $type;
                echo '</div>';
       //echo '     </td>
         //      </tr>';
       $help_text_offset = 'offset';
       $gender = "";
       if($type == "freebie") {
         if(isset($_SESSION['alternate_chart_gender'])) {
           $gender = $_SESSION['alternate_chart_gender'];
         } 
       }
       //echo '<tr>
               //<td id="gender_select_title" class="no_move align_right">gender</td>
               //<td colspan="1" id="gender_select_input" class="no_move">';
    if($_GET['the_page'] == 'cosel') {
      echo '<div style="display:inline-block;">';
        echo '<div class="later_on" style="font-size:1.19em;">Gender</div>';
                echo gender_select($gender);
       //echo '</td><td><div class="gender_validation"></div></td><span class="gender_validation"></span>
             //</tr>';
      echo '</div>';
    }
  }
////////////////////////////////////////////////////////////////////////////////////////////////
  else {
     //echo  '<tr>
       //      <td id="birth_place_title" class="no_move align_right">
                echo '<div class="later_on" style="font-size:1.19em;">Place of Birth</div>';
         //    </td>
           //  <td colspan="2" id="birth_place_input" class="no_move">
                echo '<input type="text" name="address" value="' . get_inputed_var("location", $title, $type) . '"/>';
             //</td>
            //</tr>';
     $help_text_offset = '';
  }
 // echo '     <tr>
   //            <td id="birth_time_title" class="align_right">';
      //          echo 'time of birth
        //       </td>';
          echo '<div style="display:inline-block; margin-right:30px;">';
             echo '<div class="later_on" style="font-size:1.19em;">Time of Birth</div>';
  //echo '       <td id="birth_time_input" colspan="2">';
                time_select (get_inputed_time($type), "time", (string)get_inputed_var("time_unknown",0,$type));
          echo '</div>';
        // echo '</td>
           //   </tr>
           //  <tr>
            //   <td id="birth_interval_title" class="align_right">';
              //    echo 'accuracy of time
              // </td>';             
         //echo '<td id="birth_interval_input">';
          echo '<div style="display:inline-block;">';
                echo '<div class="later_on" style="font-size:1.19em;">Accuracy</div>';
                 time_accuracy_select (get_inputed_var("interval",0,$type), "interval", (string)get_inputed_var("time_unknown",0,$type));
            echo '<div id="birth_time_hover_box_custom" class="hover_box">             
                   ?<span>This function is very important! The Accuracy of Time drop down menu lets you tell us how close or far off your time of birth might be. For example, if you put in 7:00pm for your time of birth, but you hear from your parents or a legal guardian that you were born between 6:00pm and 8:00pm, you can use the Accuracy of Time drop down menu to select “within 1 hour”. This tells us that you could be born 1 hour ahead or behind the time of birth (7:00pm) you entered.  Some things, such as your Rising sign, can change even in a couple hours! So please make sure your information is as accurate as possible!</span>
                 </div>';
          echo '</div>';
         //echo '</td>';
    //echo '     <td>
                

               //</td>
             //</tr>';
 // echo '     <tr>';
  //echo '       <td id="birth_interval_box_title" class="align_right">';
    //echo '       birthtime unknown';
    //echo '     </td>';
  //echo '       <td id="birth_interval_box_input">';
    //echo '<div id="birth_interval_box_input">';
          /*
                echo '<div style="margin-bottom: 6px; margin-top: -8px;">';
                echo '<input onclick="var box_obj = document.getElementById(\'birth_interval_box_help_text\'); var acc_obj = document.getElementById(\'interval\'); var hour_obj = document.getElementById(\'hour_time\'); var minute_obj = document.getElementById(\'minute_time\'); var meridiem_obj = document.getElementById(\'meridiem_time\');if ($(\'#birth_interval_box_help_text\').is(\':visible\')) {box_obj.style.display=\'none\'; acc_obj.disabled=false;hour_obj.disabled=false;minute_obj.disabled=false;meridiem_obj.disabled=false;} else {box_obj.style.display=\'block\'; acc_obj.value=\'-1\'; acc_obj.disabled=true;hour_obj.disabled=true;minute_obj.disabled=true;meridiem_obj.disabled=true;}" type="checkbox" name="time_unknown" value="1" ';
                 if ( (string)get_inputed_var("time_unknown",0,$type) == '1' ) {
                   echo 'CHECKED';
                 }
                 echo '/>';
              */
                 echo '<div id="help_link"> Help! I don\'t know my birth time</div>';
                 /*
                 echo '<div class="later_on" style="font-size:1.19em; display:inline-block; margin-left:10px;">Birth Time Unknown';
            
                 //echo '<div style="position:relative">';
                 echo '<div id="birth_interval_box_help_text" class="' . $help_text_offset . '" ';
                 if ((string)get_inputed_var("time_unknown",0,$type) == '1') {
                    echo 'style="display:inline-block;"';
                 }
                 echo '>';
                 echo '       <a onclick="basicPopup(\'help_text_birth_time.php\', \'Help Text\', \'height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no, titlebar=no\')" href="#">-> help!</a>';
                 //echo '</div>';
                 echo '</div>';
                 */
          //echo '</div>';
          //echo '</div>';
          echo '<input type="hidden" id="time_unknown" name="time_unknown" value="0" />';

    //echo '</div>';
    //echo '     </td>';
  //echo '     </tr>';
  

  
  if ($stage == 2 or isset($_SESSION["change_info"]) or isAdmin() ) { //PLACE OF BIRTH IS LATER WHEN YOU UPDATE YOUR INFO OR COME FROM SOMEONE ELSE'S         
      //echo  '<tr>
        //      <td id="birth_place_title" class="align_right">
          //      place of birth
          //    </td>
            //  <td id="birth_place_input" colspan="2">
            echo '<div style="margin-top:10px;">';
                echo '<div class="later_on" style="font-size:1.19em;">Place of Birth<span class="birth_place_validation"></span></div>';
                echo '<input type="text" name="address" value="' . get_inputed_var("location", $title, $type) . '" id="birth_place_input_bar"/>';
            echo '</div>';
            // </td>
             // <td><div class="birth_place_validation"></div></td>
            // </tr>';
  }
  /*
            if ($sao == 1) {
     echo '  <tr>
               <td colspan="3" id="daylight_div"> 
                 <span style="color:red">*</span><input type="radio" name="daylight" value="0"';
                 if ($_POST["daylight"] == "0") {
                   echo ' checked';
                 }
                 echo '>Standard Time
                 <input type="radio" name="daylight" value="1"';
                 if ($_POST["daylight"] == "1") {
                   echo ' checked';
                 }
                 echo '>Daylight Savings Time
               </td>
             </tr>
             <tr>
               <td id="time_zone_div_title" class="align_right">   
                  <input type="hidden" name="sao" value=' . $sao . '/>';
     echo '       <span style="color:red">*</span>Time Zone: 
               </td>
               <td id="time_zone_div">
                  <input type="text" size=1 name="timezone" value="' . $_POST["timezone"] . '">
               </td>
             </tr>
             <tr>
               <td id="latitude_div_title" class="align_right">
                 <span style="color:red">*</span>Latitude:
               </td>
               <td colspan="2" id="latitude_div">  
                   <input type="text" size="1" name="c1d" value="' . $_POST["c1d"] . '"/>' . chr(176) .
                  '<input type="text" size="1" name="c1m" value="' . $_POST["c1m"] . '"/>\'
                   <input type="text" size="1" name="c1s" value="' . $_POST["c1s"] . '"/>"
                   <input type="radio" name="LaDir" value="North"';
                   if ($_POST["LaDir"] == "North") {
                     echo ' checked';
                   }
                   echo '/>North
                   <input type="radio" name="LaDir" value="South"';
                   if ($_POST["LaDir"] == "South") {
                     echo ' checked';
                   }
                   echo '/>South
                </td>
              </tr>
              <tr>
                <td id="longitude_div_title" class="align_right">
                  <span style="color:red">*</span>Longitude:
                </td> 
                <td colspan="2" id="longitude_div">
                   <input type="text" size="1" name="c2d" value="' . $_POST["c2d"] . '"/>' . chr(176) .
                  '<input type="text" size="1" name="c2m" value="' . $_POST["c2m"] . '"/>\'
                   <input type="text" size="1" name="c2s" value="' . $_POST["c2s"] . '"/>"
                   <input type="radio" name="LoDir" value="East"';
                   if ($_POST["LoDir"] == "East") {
                     echo ' checked';
                   }
                   echo '/>East
                   <input type="radio" name="LoDir" value="West"';
                   if ($_POST["LoDir"] == "West") {
                     echo ' checked';
                   }
                   echo '/>West
                </td>
              </tr>';
                
            }

            else {*/
    echo '      
                    
                    <input type="text" name="blarg" value="" style="display:none">
                    
                    <input type="hidden" name="daylight" value="' . $_POST["daylight"] . '">
                    <input type="hidden" name="timezone" value="' . $_POST["timezone"] . '">
            
            
                    <input type="hidden" name="c1d" value="' . $_POST["c1d"] . '"/>
                    <input type="hidden" name="c1m" value="' . $_POST["c1m"] . '"/>
                    <input type="hidden" name="c1s" value="' . $_POST["c1s"] . '"/>
                    <input type="hidden" name="LaDir" value="' . $_POST["LaDir"] . '"/>
                
                    <input type="hidden" size="1" name="c2d" value="' . $_POST["c2d"] . '"/>
                    <input type="hidden" size="1" name="c2m" value="' . $_POST["c2m"] . '"/>
                    <input type="hidden" size="1" name="c2s" value="' . $_POST["c2s"] . '"/>
                    <input type="hidden" name="LoDir" value="' . $_POST["LoDir"] . '"/>';
      /*
      if ($_GET['the_page'] == 'psel') {
        echo '<input type="hidden" name="birth_info" value="profile">';
      }
      if ($_GET['the_page'] == 'cosel') {
        echo '<input type="hidden" name="birth_info" value="custom">';
      }
      */
           //}
    //echo '</table>';


/////////////////////////////////////////////////////
echo '<div id="go_bug_path"></div>';
echo        '<div id="submit_div_custom">
                <input type="submit" name="submit" ';

                  if ($_GET['the_page'] == 'psel' && !get_my_chart()) {
                    echo ' id="from_my_birth_time" ';
                  }
                echo 'value=""/>
             </div>
             </div>
          </form>
        </div>
        ';
  if (sizeof($errors) > 0) { 
    display_error_list ($errors);
  }

echo '<script type="text/javascript" src="js/birth_form_ui.js"></script>';

}
///END MATT CUSTOM BIRTH FORM

function show_birth_info_form ($errors = array(), $sao=0, $title="", $action="cast_chart.php", $stage=1) {
  //if(!get_my_chart()) {
  //  $no_chart = true;
  //}
  if (isset($_SESSION["change_info"])) {
    $type="mine";
  }
  else if ($stage==2 && get_chart_by_name("Freebie1")) {
    $type="freebie";
  }
  else if (isset($_SESSION["proxy_user_id"]) and get_chart_by_name("Main",$_SESSION["proxy_user_id"]) and isAdmin()) {
    $type=$_SESSION["proxy_user_id"];
  }
  else {
    $type="default";
  }
  //print_r ($_SESSION["chart_input_vars"]);
  echo '<div id="birth_info">
          <form id="birth_info_form" method="post" action=' . $action . '>
            <table>';
//// THIS AREA ONLY APPLIES TO ENTERING SOMEONE ELSES USER INFORMATION (AS AN ADMIN OR OTHERWISE) OR UPDATING YOUR OWN ////
  if ($stage == 2 or isset($_SESSION["change_info"]) or (isAdmin() and isset($_SESSION["proxy_user_id"]))) {
     echo '     <tr>
                  <td id="birth_date_input" class="align_right">';
                     echo 'date of birth
                     <input type="hidden" class="input_style" name="stage" value="' . $stage . '"/>';
                  echo '</td>
                  <td id="birth_date_input" colspan="2">';
                    date_select ($the_date=get_inputed_date($type), $the_name="birthday");
  
       echo '     </td>
               </tr>';
       $help_text_offset = 'offset';
  }
////////////////////////////////////////////////////////////////////////////////////////////////
  else {
     echo  '<tr>
             <td id="birth_place_title" class="no_move align_right">
                place of birth
             </td>
             <td colspan="2" id="birth_place_input" class="no_move">
                <input type="text" class="input_style" name="address" value="' . get_inputed_var("location", $title, $type) . '"/>
             </td>
            </tr>';
     $help_text_offset = '';
  }
  echo '     <tr>
               <td id="birth_time_title" class="align_right">';
                echo 'time of birth
               </td>';
             
  echo '       <td id="birth_time_input" colspan="2">';
              //if ($no_chart){
              //  time_select_profile (get_inputed_time($type), "time", (string)get_inputed_var("time_unknown",0,$type));
              //}
              //else { 
                time_select (get_inputed_time($type), "time", (string)get_inputed_var("time_unknown",0,$type));
              //}
         echo '</td>
              </tr>
             <tr>
               <td id="birth_interval_title" class="align_right">';
                  echo 'accuracy of time
               </td>';             
         echo '<td id="birth_interval_input">';
              //if ($no_chart) {
              //  time_accuracy_select_profile (get_inputed_var("interval",0,$type), "interval", (string)get_inputed_var("time_unknown",0,$type));
              //}
              //else {
                time_accuracy_select (get_inputed_var("interval",0,$type), "interval", (string)get_inputed_var("time_unknown",0,$type));
              //}
                 
         echo '</td>';
    echo '     <td>
                 <div id="birth_time_hover_box" class="hover_box">             
                   ?<span>This function is very important! The Accuracy of Time drop down menu lets you tell us how close or far off your time of birth might be. For example, if you put in 7:00pm for your time of birth, but you hear from your parents or a legal guardian that you were born between 6:00pm and 8:00pm, you can use the Accuracy of Time drop down menu to select “within 1 hour”. This tells us that you could be born 1 hour ahead or behind the time of birth (7:00pm) you entered.  Some things, such as your Rising sign, can change even in a couple hours! So please make sure your information is as accurate as possible!</span>
                 </div>
               </td>
             </tr>';
  echo '     <tr>';
  echo '       <td id="birth_interval_box_title" class="align_right">';
    echo '       birthtime unknown';
    echo '     </td>';
  echo '       <td id="birth_interval_box_input">';
    echo '       <input onclick="var box_obj = document.getElementById(\'birth_interval_box_help_text\'); var acc_obj = document.getElementById(\'interval\'); var hour_obj = document.getElementById(\'hour_time\'); var minute_obj = document.getElementById(\'minute_time\'); var meridiem_obj = document.getElementById(\'meridiem_time\');if ($(\'#birth_interval_box_help_text\').is(\':visible\')) {box_obj.style.display=\'none\'; acc_obj.disabled=false;hour_obj.disabled=false;minute_obj.disabled=false;meridiem_obj.disabled=false;} else {box_obj.style.display=\'block\'; acc_obj.value=\'-1\'; acc_obj.disabled=true;hour_obj.disabled=true;minute_obj.disabled=true;meridiem_obj.disabled=true;}" type="checkbox" name="time_unknown" value="1" ';
                 if ( (string)get_inputed_var("time_unknown",0,$type) == '1' ) {
                   echo 'CHECKED';
                 }
                 echo '/>';
                 echo '<div style="position:relative"><div id="birth_interval_box_help_text" class="' . $help_text_offset . '" ';
                 if ((string)get_inputed_var("time_unknown",0,$type) == '1') {
                    echo 'style="display:block;"';
                 }
                 echo '>';
                 echo '       <a onclick="basicPopup(\'help_text_birth_time.php\', \'Help Text\', \'height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no, titlebar=no\')" href="#">-> help!</a>';
                 echo '</div></div>';               
    echo '     </td>';
  echo '     </tr>';
  

  
  if ($stage == 2 or isset($_SESSION["change_info"]) or isAdmin() ) { //PLACE OF BIRTH IS LATER WHEN YOU UPDATE YOUR INFO OR COME FROM SOMEONE ELSE'S         
      echo  '<tr>
              <td id="birth_place_title" class="align_right">
                place of birth
              </td>
              <td id="birth_place_input" colspan="2">
                <input type="text" name="address" value="' . get_inputed_var("location", $title, $type) . '"/>
              </td>
             </tr>';
  }
            if ($sao == 1) {
     echo '  <tr>
               <td colspan="3" id="daylight_div"> 
                 <span style="color:red">*</span><input type="radio" name="daylight" value="0"';
                 if ($_POST["daylight"] == "0") {
                   echo ' checked';
                 }
                 echo '>Standard Time
                 <input type="radio" name="daylight" value="1"';
                 if ($_POST["daylight"] == "1") {
                   echo ' checked';
                 }
                 echo '>Daylight Savings Time
               </td>
             </tr>
             <tr>
               <td id="time_zone_div_title" class="align_right">   
                  <input type="hidden" name="sao" value=' . $sao . '/>';
     echo '       <span style="color:red">*</span>Time Zone: 
               </td>
               <td id="time_zone_div">
                  <input type="text" size=1 name="timezone" value="' . $_POST["timezone"] . '">
               </td>
             </tr>
             <tr>
               <td id="latitude_div_title" class="align_right">
                 <span style="color:red">*</span>Latitude:
               </td>
               <td colspan="2" id="latitude_div">  
                   <input type="text" size="1" name="c1d" value="' . $_POST["c1d"] . '"/>' . chr(176) .
                  '<input type="text" size="1" name="c1m" value="' . $_POST["c1m"] . '"/>\'
                   <input type="text" size="1" name="c1s" value="' . $_POST["c1s"] . '"/>"
                   <input type="radio" name="LaDir" value="North"';
                   if ($_POST["LaDir"] == "North") {
                     echo ' checked';
                   }
                   echo '/>North
                   <input type="radio" name="LaDir" value="South"';
                   if ($_POST["LaDir"] == "South") {
                     echo ' checked';
                   }
                   echo '/>South
                </td>
              </tr>
              <tr>
                <td id="longitude_div_title" class="align_right">
                  <span style="color:red">*</span>Longitude:
                </td> 
                <td colspan="2" id="longitude_div">
                   <input type="text" size="1" name="c2d" value="' . $_POST["c2d"] . '"/>' . chr(176) .
                  '<input type="text" size="1" name="c2m" value="' . $_POST["c2m"] . '"/>\'
                   <input type="text" size="1" name="c2s" value="' . $_POST["c2s"] . '"/>"
                   <input type="radio" name="LoDir" value="East"';
                   if ($_POST["LoDir"] == "East") {
                     echo ' checked';
                   }
                   echo '/>East
                   <input type="radio" name="LoDir" value="West"';
                   if ($_POST["LoDir"] == "West") {
                     echo ' checked';
                   }
                   echo '/>West
                </td>
              </tr>';
                
            }
            else {
    echo '      
                    
                    <input type="text" name="blarg" value="" style="display:none">
                    
                    <input type="hidden" name="daylight" value="' . $_POST["daylight"] . '">
                    <input type="hidden" name="timezone" value="' . $_POST["timezone"] . '">
            
            
                    <input type="hidden" name="c1d" value="' . $_POST["c1d"] . '"/>
                    <input type="hidden" name="c1m" value="' . $_POST["c1m"] . '"/>
                    <input type="hidden" name="c1s" value="' . $_POST["c1s"] . '"/>
                    <input type="hidden" name="LaDir" value="' . $_POST["LaDir"] . '"/>
                
                    <input type="hidden" size="1" name="c2d" value="' . $_POST["c2d"] . '"/>
                    <input type="hidden" size="1" name="c2m" value="' . $_POST["c2m"] . '"/>
                    <input type="hidden" size="1" name="c2s" value="' . $_POST["c2s"] . '"/>
                    <input type="hidden" name="LoDir" value="' . $_POST["LoDir"] . '"/>';
           }
    echo '</table>';


/////////////////////////////////////////////////////
     echo '<div id="go_bug_path"></div>';
echo        '<div id="submit_div">
                <input type="submit" name="submit" value=""/>
             </div>
          </form>
        </div>
        ';
  if (sizeof($errors) > 0) { 
    display_error_list ($errors);
  }
}


//STUPID EXTRA BIRTH FORM FOR NO CHART

function show_birth_info_form_no_chart() {
  //echo $_SESSION['user_id'];
  echo '<div class="later_on" style="margin:0 auto 13px; width: 520px; text-align: center; line-height: 1.2; font-size: 1.4em;">To view your Birth Chart, please enter your time and place of birth. This information remains private.</div>';
  echo '<div id="birth_info_form_no_chart">';
  if (isset($_GET['chart_error'])) {
    echo '<span id="chart_error_exists" style="display:none;"></span>';
  }
    echo '<form id="birth_info_form_chart_page" method="post" action="cast_chart_time_and_place.php">';
      
       $help_text_offset = 'offset';
    echo '<div class="small_title">Place of Birth</div>';
 
          echo '<div id="country">';    
            country_select_profile ($_SESSION['country_id'], "country_id");
            
          echo '</div>';

          echo '<div id="js_city_div">';
            echo '<input type="text" id="city" class="input_style city_p" name="city" placeholder="i.e. San Francisco, CA" value="' . $_SESSION['city'] . '"';
              if ($_GET['chart_error'] == 2 || $_GET['chart_error'] == 3 || $_GET['chart_error'] == 6) {
              echo ' style="border-color:#C82923;"';
            }
            echo '/>';
            
          echo '</div>';

  echo '<div style="display:inline-block; float:left; width:147px;">'; //Time of birth box
    echo '<div class="small_title">Time of birth</div>';
    echo '<div id="time">';
      time_select_profile (get_inputed_time($type), "time", (string)get_inputed_var("time_unknown",0,$type));
    echo '</div>';
  echo '</div>'; //Close Time of birth box

  echo '<div style="display:inline-block; float:right; width:120px;">'; //Accuracy box
      echo '<div class="small_title" class="align_right">Accuracy</div>';             
        echo '<div id="accuracy">';
                 time_accuracy_select_profile (get_inputed_var("interval",0,$type), "interval", (string)get_inputed_var("time_unknown",0,$type));
         
        echo '<div id="tp_birth_time_hover_box_no_chart" class="hover_box">?<span>This function is very important! The Accuracy of Time drop down menu lets you tell us how close or far off your time of birth might be. For example, if you put in 7:00pm for your time of birth, but you hear from your parents or a legal guardian that you were born between 6:00pm and 8:00pm, you can use the Accuracy of Time drop down menu to select “within 1 hour”. This tells us that you could be born 1 hour ahead or behind the time of birth (7:00pm) you entered.  Some things, such as your Rising sign, can change even in a couple hours! So please make sure your information is as accurate as possible!</span>
              </div>';
      echo '</div>'; //Close accuracy
  echo '</div>'; //Close Accuracy box

    echo '<div id="help_link"> Help! I don\'t know my birth time'; 
    
   /* echo '<input class="pointer" onclick="var box_obj = document.getElementById(\'birth_interval_box_help_text\'); var acc_obj = document.getElementById(\'interval\'); var hour_obj = document.getElementById(\'hour_time\'); var minute_obj = document.getElementById(\'minute_time\'); var meridiem_obj = document.getElementById(\'meridiem_time\');if ($(\'#birth_interval_box_help_text\').is(\':visible\')) {box_obj.style.display=\'none\'; acc_obj.disabled=false;hour_obj.disabled=false;minute_obj.disabled=false;meridiem_obj.disabled=false;} else {box_obj.style.display=\'block\'; acc_obj.value=\'-1\'; acc_obj.disabled=true;hour_obj.disabled=true;minute_obj.disabled=true;meridiem_obj.disabled=true;}" type="checkbox" name="time_unknown" value="1" ';
                 if ( (string)get_inputed_var("time_unknown",0,$type) == '1' ) {
                   echo 'CHECKED';
                 }
                 echo '/>';
                 echo '<div style="position:relative"><div id="birth_interval_box_help_text" class="' . $help_text_offset . '" ';
                 if ((string)get_inputed_var("time_unknown",0,$type) == '1') {
                    echo 'style="display:block;"';
                 }
                 echo '>';
                 echo '<a onclick="basicPopup(\'help_text_birth_time.php\', \'Help Text\', \'height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no, titlebar=no\')" href="#">Help me find my birth time</a>';
                 echo '</div></div>'; 
    */
    echo '</div>';
      echo '<input type="hidden" id="time_unknown" class="time_unknown_p" name="time_unknown" value="0" />';
      echo '<input type="hidden" name="time_and_place" value="1" />';
      //echo '<input class="sign_me_up" name="submit" type="submit" value="Continue" />';
      echo '<button type="submit" id="next_no_chart">Next ></button>';
    echo '</form>';           
  echo '</div>'; //close time_and_place

//ERRORS--------------------------------------------------

  echo '<div class="tp_err" id="tp_cid_error_h">?</div>
        <div class="tp_err_exp" id="tp_err_cid_exp">Please select a country</div>';
  echo '<div class="tp_err" id="tp_city_error_h">?</div>
        <div class="tp_err_exp" id="tp_err_city_exp">Please enter a city</div>';

  if ($_GET['chart_error'] == 1) {
    echo '<div class="tp_err" id="tp_cid_error">?</div>
          <div class="tp_err_exp" id="tp_err_cid_exp">Please select a country</div>';
  }
  if ($_GET['chart_error'] == 2 || $_GET['chart_error'] == 3 || $_GET['chart_error'] == 6) {        
    echo '<div class="tp_err" id="tp_city_error">?</div>
          <div class="tp_err_exp" id="tp_err_city_exp">';
            if ($_GET['chart_error'] == 2) {  
              echo 'Please enter a city';
            }
            if ($_GET['chart_error'] == 3 || $_GET['chart_error'] == 6) {
              echo 'Please double check your city';
            }

    echo '</div>';
  }
  /*
  if ($_GET['error'] == 2 || $_GET['error'] == 4 || $_GET['error'] == 6) {
     echo '<div class="tp_err" id="tp_zip_error">?</div>
           <div class="tp_err_exp" id="tp_err_zip_exp">';
            if ($_GET['error'] == 2) {
              echo 'Please enter a zip code';
            }
            if ($_GET['error'] == 4 || $_GET['error'] == 6) {
              echo 'Please double check your zip code';
            }
      echo '</div>';
  }
*/

  echo '<script type="text/javascript" src="/js/time_and_place_ui.js"></script>';

}




function save_secondary_chart ($return_vars, $location, $birthtime, $url, $redir=true, $the_nickname="Freebie1", $interval, $time_unknown, $method="E") {
  
  if ($return_vars[2] == 'South') {
    $LaDirAdd = 'S';
  }
  else {
    $LaDirAdd = 'N';
  }
  if ($return_vars[3] == 'West') {
    $LoDirAdd = 'W';
  }
  else {
    $LoDirAdd = 'E';
  }
  if (isset($_POST['year_birthday'])) {
    $birthdate = combine_pieces ($_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday']); 
    $birthdatetime = substr ($birthdate, 0, 4) . '-' . substr ($birthdate, 4, 2) . '-' . substr ($birthdate, 6, 2) . ' ' . format_piece (get_hours ($birthtime)) . ':' . format_piece (get_minutes($birthtime)) . ':' . format_piece (get_seconds ($birthtime));
  }
  else {
    $birthdatetime = $birthtime;
    
  }
  

  $longitude = $return_vars[0] . $LoDirAdd;
  $latitude = $return_vars[1] . $LaDirAdd;
  $DST = $return_vars[4];
  $timezone = $return_vars[5];
  $asc_coord = $return_vars[6];
  $asc_sign_id = $return_vars[7];
  $address = $return_vars[10];
  $nickname = $the_nickname;
  if ($nickname == "Main") {
    $personal = 1;
  }
  else {
    $personal = 0;
  }
 
  //$birthdatetime = substr ($birthdate, 0, 4) . '-' . substr ($birthdate, 4, 2) . '-' . substr ($birthdate, 6, 2) . ' ' . format_piece (get_hours ($birthtime)) . ':' . format_piece (get_minutes($birthtime)) . ':' . format_piece (get_seconds ($birthtime));

  //echo 'Preparing to Save Chart;  Total Birthdatetime input:  ' . $birthdatetime . '<br>';
  //die();
  /*      
  for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
        //echo '<br>';
        $planetArray = PlanetForm ($return_vars[0], $return_vars[8], $return_vars[9], $poi_id, $method);
        $pos_var_name = 'planet_' . $poi_id . '_position';
        $sign_var_name = 'planet_' . $poi_id . '_sign';
        $$pos_var_name = $planetArray[0];
        $$sign_var_name = $planetArray[1];
  }  
  */
  $poi_array = array();
  for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
    $planetArray = PlanetForm ($return_vars[0], $return_vars[8], $return_vars[9], $poi_id, $method);
          
    $poi_array[$poi_id] = $planetArray;
  
  } 

  unset($_SESSION["chart_input_vars"]);
        
  if (store_chart_by_sign ($nickname, $birthdatetime, $longitude, $latitude, $DST, $timezone, $asc_coord, $asc_sign_id, $location, $poi_array, $personal, $interval, $time_unknown, $method)) {
    //echo date('Y-m-d H:i:s', $birthdatetime);
    if ($redir) {
      do_redirect ($url=$url);
    }
    else {
      return true;
    }
  }
  else {
    return false;
  }

}


function confirm_form ($return_vars, $location, $birthtime, $return_vars2=0, $interval=0, $time_unknown=0, $method="E") {

  for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
        //echo '<br>';
        $planetArray = PlanetForm ($return_vars[0], $return_vars[8], $return_vars[9], $poi_id, $method);
        $pos_var_name = 'planet_' . $poi_id . '_position';
        $sign_var_name = 'planet_' . $poi_id . '_sign';
        $$pos_var_name = $planetArray[0];
        $$sign_var_name = $planetArray[1];
  } 

  //build 2nd planet array if casting 2 charts and consolidating 

  if ($return_vars2 != 0) {
    for ($poi_id2 = 2; $poi_id2 <= 10; $poi_id2++) {
        //echo '<br>';
        $planetArray2 = PlanetForm ($return_vars2[0], $return_vars2[8], $return_vars2[9], $poi_id2, $method);
        $pos_var_name2 = 'planet_' . $poi_id2 . '_position2';
        $sign_var_name2 = 'planet_' . $poi_id2 . '_sign2';
        $$pos_var_name2 = $planetArray2[0];
        $$sign_var_name2 = $planetArray2[1];
    } 
  }

  //show_landing_logo();
echo '<div style="border:2px solid black; background: #e7ebee; width:500px; margin: 10px auto; padding:10px 0;">';
  echo '<div class="heading">Is this information correct?</div>';

  echo '<div id="confirm_form" style="width:400px; margin:auto;">';
  echo '<form name="formx" action="save_chart.php" method="post">';
      // A MILLION FORM VARIABLES GO HERE TO STORE CHART
      //echo '*' . (int) $_POST["t1h"] . '*';

      if ($return_vars[2] == 'South') {
        $LaDirAdd = 'S';
      }
      else {
        $LaDirAdd = 'N';
      }

      if ($return_vars[3] == 'West') {
        $LoDirAdd = 'W';
      }
      else {
        $LoDirAdd = 'E';
      }
      if (isset($_SESSION["change_info"])) {
        $birthday = date('Ymd', get_inputed_date());
        
        //$birthday = combine_pieces ($_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday']); 
        echo '<input type="hidden" name="birthdate" value="' . $birthday . '"/>';
      }
      else {
        $birthday = get_my_birthday();
        echo '<input type="hidden" name="birthdate" value="' . combine_pieces (substr ($birthday, 0, 4), substr ($birthday, 5, 2), substr ($birthday, 8, 2)) . '"/>'; 
      }
      
      echo '<input type="hidden" name="birthtime" value="' . $birthtime . '"/>'; 
      echo '<input type="hidden" name="longitude" value="' . $return_vars[0] . $LoDirAdd . '"/>'; 
      echo '<input type="hidden" name="latitude" value="'. $return_vars[1] . $LaDirAdd . '"/>'; 
      echo '<input type="hidden" name="DST" value="' . $return_vars[4] . '"/>'; 
      echo '<input type="hidden" name="timezone" value="' . $return_vars[5] . '"/>';    

      echo '<input type="hidden" name="asc_coord" value="' . $return_vars[6] . '"/>';
      echo '<input type="hidden" name="asc_sign_id" value="' . $return_vars[7] . '"/>';
      echo '<input type="hidden" name="address" value="' . $location . '"/>';   
 
      echo '<input type="hidden" name="interval" value="' . $interval . '"/>';        
      echo '<input type="hidden" name="time_unknown" value="' . $time_unknown . '"/>'; 

      for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
          $pos_var_name = 'planet_' . $poi_id . '_position';
          $sign_var_name = 'planet_' . $poi_id . '_sign';
          echo '<input type="hidden" name="' . $pos_var_name . '" value="' . $$pos_var_name . '"/>'; 
          echo '<input type="hidden" name="' . $sign_var_name . '" value="' . $$sign_var_name . '"/>'; 
          
      } 

      //set vars for 2nd chart if casting 2 charts and consolidating 

      if ($return_vars2 != 0) {

        echo '<input type="hidden" name="asc_coord2" value="' . $return_vars2[6] . '"/>';
        echo '<input type="hidden" name="asc_sign_id2" value="' . $return_vars2[7] . '"/>';
        
        for ($poi_id2 = 2; $poi_id2 <= 10; $poi_id2++) {
           $pos_var_name2 = 'planet_' . $poi_id2 . '_position2';
           $sign_var_name2 = 'planet_' . $poi_id2 . '_sign2';
           echo '<input type="hidden" name="' . $pos_var_name2 . '" value="' . $$pos_var_name2 . '"/>'; 
           echo '<input type="hidden" name="' . $sign_var_name2 . '" value="' . $$sign_var_name2 . '"/>'; 
        }    

      }
      
      echo '<div class="later_on" style="text-align:center; font-size:1.5em;"><span>' . get_my_nickname()  . '</span><br>Born in<br><span>' . $location . '</span></div>';
      //echo '<div id="rising_text">Your Rising Sign: ' . get_sign_name ($return_vars[7]) . '</div>';
      echo '<input type="hidden" name="chart_name" value="Main"/>';
      echo '<input type="hidden" name="personal" value="1"/>';
    echo '<div style="width:100px; margin:auto; margin-top:12px;">';
      echo '<input type="submit" name="submit" value="Yes" id="confirm_form_button" class="confirm_form_yes" style="margin-right:20px;"/>';
      echo '<input type="submit" name="submit" value="No" id="confirm_form_button"/>';
    echo '</div>';  
      
   echo '</form>';
   echo '</div>';
echo '</div>'; //Close background and border div

echo '<script type="text/javascript">';
  echo '$(document).ready(function(){
          $(".confirm_form_yes").click(function(){
            mixpanel.track("Time and Place", {
                "address"      : $("input[name=address]").val(),
                "TP From"      : "My Birth Time"
            });
          });
        });';
echo '</script>';
}


function save_form($return_vars) {

  for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
        echo '<br>';
        $planetArray = PlanetForm ($return_vars[0], $return_vars[8], $return_vars[9], $poi_id);
        $pos_var_name = 'planet_' . $poi_id . '_position';
        $sign_var_name = 'planet_' . $poi_id . '_sign';
        $$pos_var_name = $planetArray[0];
        $$sign_var_name = $planetArray[1];
  }  

  echo '<div class="save_form">';
  echo '<form name="formx" action="save_chart.php" method="post">';
      // A MILLION FORM VARIABLES GO HERE TO STORE CHART
      //echo '*' . (int) $_POST["t1h"] . '*';

      if ($return_vars[2] == 'South') {
        $LaDirAdd = 'S';
      }
      else {
        $LaDirAdd = 'N';
      }

      if ($return_vars[3] == 'West') {
        $LoDirAdd = 'W';
      }
      else {
        $LoDirAdd = 'E';
      }
 
      echo '<input type="hidden" name="birthdate" value="' . combine_pieces ($_POST["d1y"], $_POST["d1m"], $_POST["d1d"]) . '"/>'; 
      echo '<input type="hidden" name="birthtime" value="' . combine_pieces ($_POST["t1h"], $_POST["t1m"], $_POST["t1s"]) . '"/>'; 
      echo '<input type="hidden" name="longitude" value="' . $return_vars[0] . $LoDirAdd . '"/>'; 
      echo '<input type="hidden" name="latitude" value="'. $return_vars[1] . $LaDirAdd . '"/>'; 
      echo '<input type="hidden" name="DST" value="' . $return_vars[4] . '"/>'; 
      echo '<input type="hidden" name="timezone" value="' . $return_vars[5] . '"/>';    

      echo '<input type="hidden" name="asc_coord" value="' . $return_vars[6] . '"/>';
      echo '<input type="hidden" name="asc_sign_id" value="' . $return_vars[7] . '"/>';
      echo '<input type="hidden" name="address" value="' . $return_vars[10] . '"/>';   

      for ($poi_id = 2; $poi_id <= 10; $poi_id++) {
        
        
          $pos_var_name = 'planet_' . $poi_id . '_position';
          $sign_var_name = 'planet_' . $poi_id . '_sign';
        
  
          echo '<input type="hidden" name="' . $pos_var_name . '" value="' . $$pos_var_name . '"/>'; 
          echo '<input type="hidden" name="' . $sign_var_name . '" value="' . $$sign_var_name . '"/>'; 
      } 
      
      echo '<input type="text" name="chart_name" value=""/>';
      echo '<input type="submit" name="submit" value="Save This Chart"/>';
      
   echo '</form>';
   echo '</div>';
}

function display_error_list($errors) {
  echo '<div class="error_list" style="color:red">'; //put this into a real CSS sheet at some point
  echo 'ERROR:';
  echo '<ul>';
  for ($x=0; $x < sizeof($errors); $x++) {
    echo '<li>' . $errors[$x] . '</li>';
  }
  echo '</ul>';
  echo '</div>';
}

function chart_dropdown ($name, $value) {
  echo '<select name="' . $name . '" id="' . $name . '">';
  $chart_list = get_chart_list ();
  while ($chart = mysql_fetch_array($chart_list)) {
     echo '<option value="' . $chart["chart_id"] . '"';
     if ((int)$chart["chart_id"] == (int)$value) {
      echo 'SELECTED';
     }
     echo '>' . $chart["nickname"] . '</option>';
  }
  echo '</select>';
}

function format_as_sign_coordinates ($c) {

  $degrees = substr ($c, 0, 2);
  $minutes = substr ($c, 2, 2);
  $seconds = substr ($c, 4, 2);

  $result = $degrees . chr(176) . $minutes . "'" . $seconds . "\"";
  return $result;

}

function format_as_long_coordinates ($c) {

  $degrees = substr ($c, 0, 3);
  $minutes = substr ($c, 3, 2);
  $seconds = substr ($c, 5, 2);

  $result = $degrees . chr(176) . $minutes . "'" . $seconds . "\"";
  return $result;

}

function format_as_time ($t) {

  $hours = substr ($t, 0, 2);
  $minutes = substr ($t, 2, 2);
  $seconds = substr ($t, 4, 2);

  $result = $hours . 'h ' . $minutes . "m " . $seconds . "s";
  return $result;

}

function format_piece ($p) {
  $result = (string) $p;
  $result = trim($result);
  if (strlen($result) == 1){
    $result = '0' . $result;
  }
  if (strlen($result) == 0){
    $result = '00';
  }
  return $result;
}

function format_piece_long_degrees ($p) {
  $result = (string) $p;
  $result = trim($result);
  if (strlen($result) == 2){
    $result = '0' . $result;
  }
  if (strlen($result) == 1){
    $result = '00' . $result;
  }
  if (strlen($result) == 0){
    $result = '000';
  }
  return $result;
}

function format_whole_time ($w) {
  $result = (string) $w;
  $result = trim($result);
  while (strlen($result) < 6) {
    $result= '0' . $result; 
  }
  return $result;
}

function format_whole_sign_coord ($w) {
  $result = (string) $w;
  $result = trim($result);
  while (strlen($result) < 6) {
    $result= '0' . $result; 
  }
  return $result;
}

function format_whole_long_coord ($w) {
  $result = (string) $w;
  $result = trim($result);
  while (strlen($result) < 7) {
    $result= '0' . $result; 
  }
  return $result;
}

function test_form_coordinates () {
  if (isset($_POST["test_submit"])) {
    $c1d = $_POST["c1d"];
    $c1m = $_POST["c1m"];
    $c1s = $_POST["c1s"];
    $c2d = $_POST["c2d"];
    $c2m = $_POST["c2m"];
    $c2s = $_POST["c2s"];
  }
  else {
    $c1d = "";
    $c1m = "";
    $c1s = "";
    $c2d = "";
    $c2m = "";
    $c2s = "";
  }
  echo '<form name="formx" action="./index.php" method="post">
           <table><tr><td>
           1st Coordinates:</td><td> 
           <input type="text" size="1" name="c1d" value="' . $c1d . '"/>' . chr(176) .
           '<input type="text" size="1" name="c1m" value="' . $c1m . '"/>\'
           <input type="text" size="1" name="c1s" value="' . $c1s . '"/>"
           </td></tr><tr><td>
           2nd Coordinates: </td><td>
           <input type="text" size="1" name="c2d" value="' . $c2d . '"/>' . chr(176) .
           '<input type="text" size="1" name="c2m" value="' . $c2m . '"/>\'
           <input type="text" size="1" name="c2s" value="' . $c2s . '"/>"</td></tr><tr>
           <td colspan=2>
           <input type="submit" name="test_submit" value="Add"/>
           <input type="submit" name="test_submit" value="Subtract"/>
           </td></tr></table>
        </form>';
}

function test_form_time () {
  if (isset($_POST["test_submit_time"])) {
    $t1h = $_POST["t1h"];
    $t1m = $_POST["t1m"];
    $t1s = $_POST["t1s"];
    $t2h = $_POST["t2h"];
    $t2m = $_POST["t2m"];
    $t2s = $_POST["t2s"];
  }
  else {
    $t1h = "";
    $t1m = "";
    $t1s = "";
    $t2h = "";
    $t2m = "";
    $t2s = "";
  }
  echo '<form name="formy" action="./index.php" method="post">
           <table><tr><td>
           1st Time:</td><td>
           <input type="text" size="1" name="t1h" value="' . $t1h . '"/>h&nbsp;
           <input type="text" size="1" name="t1m" value="' . $t1m . '"/>m&nbsp;
           <input type="text" size="1" name="t1s" value="' . $t1s . '"/>s
           </td></tr><tr><td>
           2nd Time: </td><td>
           <input type="text" size="1" name="t2h" value="' . $t2h . '"/>h&nbsp;
           <input type="text" size="1" name="t2m" value="' . $t2m . '"/>m&nbsp;
           <input type="text" size="1" name="t2s" value="' . $t2s . '"/>s</td></tr><tr>
           <td colspan=2>
           <input type="submit" name="test_submit_time" value="Add"/>
           <input type="submit" name="test_submit_time" value="Subtract"/>
           </td></tr></table>
        </form>';
}

function show_compare_results ($score, $goto=".", $results_type, $text_type, $stage="2") {

      if(!isLoggedIn()) {
        $guest_user_id2 = get_guest_user_id2();
        echo '<script type="text/javascript">
                $(document).ready(function(){
                    $(".pop_guest").slideFadeToggle();
                });
              </script>';
      }

      //$isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($_GET["chart_id2"])));
      $freebie = is_freebie_chart($_SESSION['compare_chart_ids'][1]);

      if ($freebie) {
        if(isset($_SESSION['alternate_chart_gender'])) {
          $alt_gender = $_SESSION['alternate_chart_gender'];
          //echo $_SESSION['alternate_chart_gender'];
        } 
      }

  $can_view = can_view_section($_SESSION['compare_chart_ids'][1]);

//COMPARE TUTORIALS ----------------------------------------
      
    //MAJOR COMPARE TUTORIAL
      if(my_compare_major_flag() == 1 && $can_view[0]) {
        
          echo '<div id="msg_sheen" class="major_compare_pop">';    
            echo '<div id="msg_sheen_screen_mact" class="major_compare_pop"></div>';
              
              echo '<div id="msg_sheen_mact1" class="major_compare_pop msg_sheen_mact">';
                echo '<div id="major_compare_pop1">';
                echo '<div class="ct_step later_on">1 / 4</div>';
                  echo '<div class="heading">Compatibility Tutorial</div>';
                  echo '<div class="later_on ct_text">Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs - we call these the "Major Connections."  You\'re likely to see both positive and negative dynamics, so keep in mind that a relationship can work with even one positive dynamic!</div>';
                  echo '<div class="later_on mact_next" id="mact1_done"><a href="#" class="later_on">Next></a></div>';
              echo '</div>'; //close #major_compare_pop1
            echo '</div>'; //close msg_sheen_cot1

            echo '<div id="msg_sheen_mact2" class="msg_sheen_mact">';
                echo '<div id="major_compare_pop2">';
                echo '<div class="ct_step later_on">2 / 4</div>';
                  echo '<div class="later_on ct_text">Important! As you read about your compatibility, keep this analogy in mind: If you had never eaten cake before, and you separately tasted eggs, sugar, flour and milk, it might be hard to imagine the result of having them all baked together. Similarly, if you separately read the dynamics between your Rising, Sun, Moon and Venus Signs, they might all have their own contradictory meaning. Understanding how the ingredients of your compatibility all "bake" together is the job of an astrologer. What you\'re about to read, we affectionately refer to as "Cook Book Astrology." For a more in depth understanding of your compatibility, please consult an astrologer.</div>';
                  echo '<div class="later_on mact_next" id="mact2_done"><a href="#" class="later_on">Next></a></div>';
              echo '</div>'; //close #major_compare_pop2
            echo '</div>'; //close msg_sheen_cot1

            echo '<div id="msg_sheen_mact3" class="msg_sheen_mact">';
                echo '<div id="major_compare_pop3">';
                echo '<div class="ct_step later_on">3 / 4</div>';
                  echo '<div class="later_on ct_text">The images between your Rising, Sun, Moon and Venus Signs represent the dynamic between them.  To read about the dynamics, click on any of the images or click "show text."</div>';
                  echo '<div class="later_on mact_next" id="mact3_done"><a href="#" class="later_on">Next ></a></div>';
              echo '</div>'; //close #major_compare_pop3
            echo '</div>'; //close msg_sheen_cot1

            echo '<div id="msg_sheen_mact4" class="msg_sheen_mact">';
                echo '<div id="major_compare_pop4">';
                echo '<div class="ct_step later_on">4 / 4</div>';
                  echo '<div class="later_on ct_text">To see more details about your compatability click through these tabs.</div>';
                  echo '<div class="later_on mact_next" id="mact4_done"><a href="#" class="later_on">Done</a></div>';
              echo '</div>'; //close #compare_pop1
            echo '</div>'; //close msg_sheen_cot1

        echo '</div>'; //close msg_sheen

      //MAJOR TEXT CIRCLE
        echo '<div id="major_text_circle"></div>';
        echo '<div id="compare_subnav_circle"></div>';
        }

    //MINOR COMPARE TUTORIAL
        if (my_compare_minor_flag() == 1 && $can_view[0]) {
          echo '<div id="msg_sheen" class="minor_compare_pop">';    
            echo '<div id="msg_sheen_screen_mict" class="minor_compare_pop"></div>';
              
              echo '<div id="msg_sheen_mict1" class="minor_compare_pop msg_sheen_mict">';
                echo '<div id="minor_compare_pop1">';
                echo '<div class="ct_step later_on">1 / 4</div>';
                  //echo '<div class="heading">Compatibility Tutorial</div>';
                  echo '<div class="later_on ct_text">The Supporting Connections do just what their name suggests.  They support the dynamics between your Major Connections.  Whether a Major Connection is strong or weak, the strength of the Supporting Connections can effect it.  For example, even if your Moon Signs are in the dynamic of Challenges (indicating there are challenges in emotional compatibility), good Supporting Connections can strengthen your emotional compatibility.</div>';
                  echo '<div class="later_on mict_next" id="mict1_done"><a href="#" class="later_on">Next></a></div>';
              echo '</div>'; //close #compare_pop1
            echo '</div>'; //close msg_sheen_cot1

            echo '<div id="msg_sheen_mict2" class="msg_sheen_mict">';
                echo '<div id="minor_compare_pop2">';
                echo '<div class="ct_step later_on">2 / 4</div>';
                  echo '<div class="later_on ct_text">To read about the level of support each Major Connection receives, click through these tabs.</div>';
                  echo '<div class="later_on mict_next" id="mict2_done"><a href="#acropolis" class="later_on">Next></a></div>';
              echo '</div>'; //close #compare_pop1
            echo '</div>'; //close msg_sheen_cot1

            echo '<div id="msg_sheen_mict3" class="msg_sheen_mict">';
                echo '<div id="minor_compare_pop3">';
                echo '<div class="ct_step later_on">3 / 4</div>';
                  echo '<div class="later_on ct_text">The pillars in the acropolis represent how much support is provided for each of your Major Connections.  The more intact pillars you have, the more support your Major Connection receives.  We sum up the support here.</div>';
                  echo '<div class="later_on mict_next" id="mict3_done"><a href="#acropolis" class="later_on">Next></a></div>';
              echo '</div>'; //close #compare_pop1
            echo '</div>'; //close msg_sheen_cot1

            echo '<div id="msg_sheen_mict4" class="msg_sheen_mict">';
                echo '<div id="minor_compare_pop4">';
                echo '<div class="ct_step later_on">4 / 4</div>';
                  echo '<div class="later_on ct_text">Click on all the pillars to see the dynamics between each of your supporting connections.</div>';
                  echo '<div class="later_on mict_next" id="mict4_done"><a href="#acropolis" class="later_on">Done</a></div>';
              echo '</div>'; //close #compare_pop1
            echo '</div>'; //close msg_sheen_cot1

          echo '</div>'; //close msg_sheen

          echo '<div id="pillar_icons_circle"></div>';
          echo '<div id="supporting_tabs_circle"></div>';
          echo '<div id="supporting_sum_up_circle"></div>';

        }
    
  //END COMPARE TUTORIALS ------------------------------------


       
       $text_type = $_GET["text_type"];

      echo '<script type="text/javascript" src="/js/compare_ui.js"></script>';
      
      //PICTURE OF YOU
      echo '<div id="chart_1_pic">';
        if (!$user_id_1 = get_user_id_from_chart_id ($_SESSION['compare_chart_ids'][0]))
          $user_id_1 = -1;

        if (!$freebie) {
          $Gurl = "?the_page=psel&the_left=nav1";
        }  
        else { 
          $Gurl = '#';
        }

        //show_user_compare_picture ($Gurl, $user_id_1);
        
        echo '<div class="photo_border_wrapper_compare">';
          echo '<div class="compare_photo">';
            show_user_compare_picture($Gurl, $user_id_1);
         
          echo '</div>';
        echo '</div>'; 
        show_general_info($_SESSION['compare_chart_ids'][0]);

     

      echo '</div>';

      if (!$user_id_2 = get_user_id_from_chart_id ($_SESSION['compare_chart_ids'][1])) {
            $user_id_2 = -1;
      }
      else {
        $user_id_2 = get_user_id_from_chart_id ($_SESSION['compare_chart_ids'][1]);
      }

      //PICTURE OF OTHER USER
      if (!$guest_user_id2 || $guest_user_id2 != $user_id_2) {
        echo '<div id="chart_2_pic">';

          if (!$freebie) {
            $Gurl = $goto . '&tier=3&chart_id2=' . $_SESSION['compare_chart_ids'][1];  
          }
          else {
            $Gurl = '?the_left=nav3&the_page=cosel&tier=4';
          }
          //show_user_compare_picture ($Gurl, $user_id_2);
          echo '<div class="photo_border_wrapper_compare">';
            echo '<div class="compare_photo">';
              show_user_compare_picture($Gurl, $user_id_2);
         
            echo '</div>';
          echo '</div>'; 
          if (!$freebie) {
            show_general_info($_SESSION['compare_chart_ids'][1]);
          }
          else {      //ADDED FOR FREEBIE
            echo '<div id="custom_nickname_compare">Custom Chart</div>';
          }
        echo '</div>';
      }
      
      //Lady_Starmeow
      else {
        echo '<div id="chart_2_pic" class="pop_guest_click">';
        $Gurl = '';
        //show_user_compare_picture ($Gurl, $user_id_2);
          echo '<div class="photo_border_wrapper_compare">';
            echo '<div class="compare_photo">';
              show_user_compare_picture($Gurl, $guest_user_id2);
         
            echo '</div>';
          echo '</div>'; 
          show_general_info($_SESSION['compare_chart_ids'][1]);
        echo '</div>';
      }
     
        
   
      if (!isset($_POST["connection_type"])) {
        $connection_type = "rising";
      }
      else {
        $connection_type = $_POST["connection_type"];
      }

      echo '<div id="compare_results">';
      //echo '<form name="connection_browser" action="." method="post">';
      //echo '<input type="hidden" name="connection_type"/>';
      //echo '<div id="header" class="compare">';
        //echo 'Compare Chart';
        //flare_title("Compare Charts");
      //echo '</div>';
      echo '<div id="star_rating">';
        if ((string)$score != '-1') {
          $rating = get_star_rating ($score);
          for ($x=1; $x<=5; $x++) {
            if ($rating >= $x) 
              echo '<div class="star"><img src="/img/Starma-Astrology-Compare-Star-1.png"/></div>';
            elseif ($rating >= ($x - 0.25))
              echo '<div class="star"><img src="/img/Starma-Astrology-Compare-Star-.75.png"/></div>';
            elseif ($rating >= ($x - 0.50))
              echo '<div class="star"><img src="/img/Starma-Astrology-Compare-Star-.5.png"/></div>';
            elseif ($rating >= ($x - 0.75))
              echo '<div class="star"><img src="/img/Starma-Astrology-Compare-Star-.25.png"/></div>';
            else 
              echo '<div class="star"><img src="/img/Starma-Astrology-Compare-Star-0.png"/></div>';
          }
        }
        else {
          if ($freebie) {
            $help_text="Oh no!  We can't give you an accurate Starma Rating because either your <a href='main.php?the_left=nav3&the_page=psel'>birth info</a> or the <a href='" . custom_chart_url() . "'>custom birth info</a> is not accurate enough.";
          }
          else {
            $help_text="Oh no!  We can't give you an accurate Starma Rating without a more accurate <a href='main.php?the_left=nav3&the_page=psel'>time of birth</a>.  If your time of birth is already exact, please encourage " . $username2 = get_nickname ($user_id_2) . " to enter a more accurate time of birth.";
          }
          echo '<div class="hover_box">';
          for ($x=1; $x<=5; $x++) {
            echo '<div class="star"><img src="/img/Starma-Astrology-Compare-Star-Unknown.png"/></div>';
          }
          echo '<span>' . $help_text . '</span>';
          echo '</div>';
        }
        //echo '<br>';
        //echo '*' . $score . '*';
      echo '</div>'; //close star_rating

    if(isLoggedIn()) {
      echo '<div id="view_compare_tutorial"><div class="sign_up">View Tutorial</div>';
          echo '<input type="hidden" id="c_id1" value="' . $_SESSION['compare_chart_ids'][0] .'" />';
          echo '<input type="hidden" id="c_id2" value="' . $_SESSION['compare_chart_ids'][1] .'" />';
          echo '<input type="hidden" id="the_left" value="' . $_GET['the_left'] . '" />';
          echo '<input type="hidden" id="the_page" value="' . $_GET['the_page'] . '" />';
      echo '</div>';
    }  

      /*
      echo '<div id="explanation" class="explanation_less later_on">';
          echo '<span class="exp_less">Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs...'; 
            
            //if($results_type == 'major') {
              //echo 'Your Major Connections...'; 
            //}

          echo '</span>';
          echo '<span class="exp_more">Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs - we call these the “Major Connections.”  You’re likely to see both positive and negative dynamics, so keep in mind that a relationship can work with even one good dynamic!  It’s also normal to encounter contradictory information, so be sure to remember the Cake Analogy!  Enjoy!</span>';
        echo '<div id="explain_more">MORE</div>';
        */

        /*//TAKING OUT FOR REDESIGN
        echo 'Display Text For:';
        //echo 'Below is the basic structure of compatibility.  It must be read as a whole with the understanding that a strong dynamic can compensate for a weak one.  The Major Connections have the strongest influence on compatibility and the Minor Connections have the potential to support or weaken them.';
        echo '<div id="text_selector">';
          echo '<div class="friends_button ';
          if ((string)$text_type == "2") {
             echo 'selected';
          }
          echo '">';
          echo '<a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="connection_browser", $action=$goto . "&text_type=2" . "&stage=" . $stage, $hidden="connection_type", $value="'" . $connection_type . "'", $hidden2="", $value2="") . '"';        
          echo '/>FRIENDS</a></div>';
          echo 'or';
          echo '<div class="romance_button ';
          if ((string)$text_type == "1") {
             echo 'selected';
          }
          echo '">';
          echo '<a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="connection_browser", $action=$goto . "&text_type=1" . "&stage=" . $stage, $hidden="connection_type", $value="'" . $connection_type . "'", $hidden2="", $value2="") . '"';        
          echo '/>ROMANCE</a></div>';
        echo '</div>';
        */
        
      //echo '</div>'; //close explanation

      //if ($results_type == "major") {
        //echo '<div id="major_small_bubble"><img src="/img/Starma-Astrology-Major-Small-Bubble.png" height="10px" width="10px" /></div>';
        //echo '<div id="major_medium_bubble"><img src="/img/Starma-Astrology-Major-Small-Bubble.png" height="15px" width="15px" /></div>';
      //}

      
    
    if ($can_view[0]) {

      echo '<div id="compare_results_selector"><a name="acropolis"></a>'; //name acropolis there for minor compare tutorial
      echo '<ul>';
      //Major
      echo '<li class="selector ';    //took out class="major"
      if ($results_type == "major") {
        echo 'selected';
      }
      echo '" id="major_select">';
      echo '<span';
      //echo 'onclick="' . javascript_submit ($form_name="connection_browser", $action=$goto . "&results_type=major" . "&stage=2", $hidden="connection_type", $value="'rising'", $hidden2="", $value2="") . '"';        
      echo '/>Major Connections</span></li>';

      //Minor
      echo '<li class="selector ';   //took out class="minor"
      if ($results_type == "minor") {
        echo 'selected';
      }
      echo '" id="minor_select">';
      echo '<span ';
      //echo 'onclick="' . javascript_submit ($form_name="connection_browser", $action=$goto . "&results_type=minor" . "&stage=2", $hidden="connection_type", $value="'rising'", $hidden2="", $value2="") . '"';        
      echo '/>Supporting Connections</span></li>';
      //Bonus
      echo '<li class="selector ';   //took out class="bonus"
      //if ($results_type == "ruler") {
        //echo 'selected';
      //}
      echo '" id="ruler_select">';
        echo '<span>';
          //' . $goto . '&stage=2' . '&results_type=ruler">Ruling Planets</a></li>';   //NEED TO MAKE IT'S OWN AND NOT BONUS
        echo '1st House Lords</span></li>';

      echo '<li class="end selector ';   //took out class="bonus"
      //if ($results_type == "bonus") {
        //echo 'selected';
      //} 
      echo '" id="bonus_select"><span>';
        //echo . $goto . '&stage=2' . '&results_type=bonus">';
      echo 'Bonus Connections</span></li>';  //NEED TO MAKE INTO BONUS
   
        echo '</ul>';
        echo '</div>';

        /*//REDESIGN
        
        echo '<div id="detail_selector">';
          echo '<a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="connection_browser", $action=$goto . "&stage=2", $hidden="connection_type", $value="'" . $connection_type . "'", $hidden2="", $value2="") . '"';        
          if ($stage == 2) {
            echo ' style="font-weight:bold"';
          }
          echo '/>At a Glance</a>/';
     
          echo '<a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="connection_browser", $action=$goto . "&stage=3", $hidden="connection_type", $value="'" . $connection_type . "'", $hidden2="", $value2="") . '"';        
          if ($stage == 3) {
            echo ' style="font-weight:bold"';
          }
          echo '/>More Info</a>';
        echo '</div>';

        */

        /***************---Matt REDESIGN------
        $chart_id1 = $_GET["chart_id1"];
        $chart_id2 = $_GET["chart_id2"];
        echo '<div id="compare_results_selector">
          <ul>
            <li><input type="submit" id="major" value="Major" /></li>     
            <li><input type="submit" id="minor" value="Minor" /></li>
            <li class="end"><input type="submit" id="bonus" value="Bonus" /></li>
          </ul>
          <input type="hidden" value=' . $chart_id1 . ' name="chart_id1"/>
          <input type="hidden" value=' . $chart_id2 . ' name="chart_id2"/>  
        </div>';

      
        echo '<script type="text/javascript" src="/js/ajax_compare_submit.js"></script>';
        */
      }
      //echo '</form>';
      echo '</div>';
}

function show_compare_results_homepage($chart_id1, $chart_id2, $score) {
  $user_id_1 = get_my_user_id();
  //PICTURE OF YOU
  echo '<div id="homepage_suggested_match">';
    echo '<div style="margin:auto auto 8px; width:100%;">';
      echo '<div id="homepage_compare_thumb_left">';
        echo '<div class="grid_photo_border_wrapper">';
          echo '<div class="grid_photo">';
            show_user_inbox_picture('', $user_id_1);
         
          echo '</div>';
        echo '</div>'; 
      echo '</div>';

        echo '<div id="homepage_compare_stars">';
          $rating = get_star_rating ($score);
          for ($x=1; $x<=5; $x++) {
            if ($rating >= $x) 
              echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small1.png"/></div>';
            elseif ($rating >= ($x - 0.25))
              echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small.75.png"/></div>';
            elseif ($rating >= ($x - 0.50))
              echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small.5.png"/></div>';
            elseif ($rating >= ($x - 0.75))
              echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small.25.png"/></div>';
            else 
              echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small0.png"/></div>';
          }
        echo '</div>'; //close star_rating

          //PICTURE OF OTHER USER
        if (!$user_id_2 = get_user_id_from_chart_id ($chart_id2)) {
          $user_id_2 = -1;
        }
        else {
          $user_id_2 = get_user_id_from_chart_id ($chart_id2);
        }
        echo '<div id="homepage_compare_thumb_right">';
          echo '<div class="grid_photo_border_wrapper">';
            echo '<div class="grid_photo">';
              show_user_inbox_picture('', $user_id_2);
         
            echo '</div>';
          echo '</div>'; 
          //show_general_info($user_id_2);
        echo '</div>';

    echo '</div>'; //close container
    echo '<div id="sample_compare_text">Compatibility is not just for romantic connections! Test your compatibility with friends and family for insight into your relationship dynamics...</div>';
  echo '</div>'; //close homepage_compare_sample

}

function show_compare_results_no_chart_homepage() {
  echo '<div id="homepage_suggested_match">';
    echo '<div style="margin:auto auto 8px; width:100%;">';
      echo '<div id="homepage_compare_thumb_left">';
        echo '<div class="grid_photo_border_wrapper">';
          echo '<div class="grid_photo">';
            show_user_inbox_picture('', -1);
         
          echo '</div>';
        echo '</div>'; 
      echo '</div>';

        echo '<div id="homepage_compare_stars">';
          echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small1.png"/></div>';
          echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small1.png"/></div>';
          echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small1.png"/></div>';
          echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small1.png"/></div>';
          echo '<div class="star_homepage"><img src="/img/Starma-Astrology-Compare-Star-Small1.png"/></div>';
        echo '</div>'; //close star_rating

        //PICTURE OF OTHER USER
        echo '<div id="homepage_compare_thumb_right">';
          echo '<div class="grid_photo_border_wrapper">';
            echo '<div class="grid_photo">';
              show_user_inbox_picture('', -1);
         
            echo '</div>';
          echo '</div>'; 
          //show_general_info($user_id_2);
        echo '</div>';

    echo '</div>'; //close container
    echo '<div id="sample_compare_text">Enter your birth information to see compatibility scores with other members, celebrities, or custom charts!</div>';
  echo '</div>'; //close homepage_compare_sample
}

/**************---Matt Redesign Loading everything on one page per connection type */

function show_major_connections ($compare_data, $text_type, $goTo = ".", $stage="2", $chart_id1, $chart_id2) {

      if(isset($_SESSION['alternate_chart_gender'])) {
        $alt_gender = $_SESSION['alternate_chart_gender'];
        //echo $_SESSION['alternate_chart_gender'];
      }
      if($temp_id = get_user_id_from_chart_id($chart_id2)) {
              if (get_gender($temp_id) == "M") {
                  $gender = 'HIS';
              }
              elseif (get_gender($temp_id) == "F") {
                 $gender = 'HER';
              }
              else {
                  $gender = '';
              }
      }
      elseif ($alt_gender) {
              if ($alt_gender == "M") {
                  $gender = 'HIS';
              }
              elseif ($alt_gender == "F") {
                   $gender = 'HER';
              }
              else {
                  $gender = '';
              }
      }
      else {
         $gender = '';
      }    

      $connection_type = "rising";
      //if ( isset($_POST["connection_type"]) and in_array($_POST["connection_type"], get_cornerstones()) ) {
      
      //  $connection_type = $_POST["connection_type"];
      //}

      //Log the Action
      log_this_action (compare_action_major(), viewed_basic_action(), $chart_id2, $stage, get_poi_id (strtoupper($connection_type)));
  


    //echo '<div id="compare">';
      //echo'<div id="section">';
  
    echo '<div id="major">';
      echo '<form name="major_connection_browser" action="." method="post">';
      echo '<input type="hidden" name="connection_type"/>';
      echo '<div id="major_connections">'; 
      
             

      //Left Side;
      echo '<div class="poi_column">';
      echo '<ul>';
      
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));
          echo '<li>';
          echo '<div class="poi_column_wrapper">';
          echo '<div class="left pointer ' . get_selector_name($button_sign_id) . '_tall';
          //if ($connection_type == $connection or $stage==2) { 
          //  echo ' selected';
          //}
          echo '"><span class="icon"><span class="minor_poi_title">YOUR</span><span class="poi_title_tall">' . strtoupper($connection) . '</span></span></div>';

            $button_sign_id2 = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
              echo '<div class="right pointer ' . get_selector_name($button_sign_id2) . '_tall';
              //if ($connection_type == $connection or $stage==2) { 
              //  echo ' selected';
              //}
              echo '"><span class="icon"><span class="minor_poi_title">' . $gender . '</span><span class="poi_title_tall">' . strtoupper($connection) . '</span></span></div>';

              $relationship_id = $compare_data[$connection . '2' . $connection]["relationship_id"];
              $relationship_name = $compare_data[$connection . '2' . $connection]["relationship_title"];
              echo '<div class="dynamic_icon dynamic_column ' . get_rela_selector_name($relationship_id);
              echo '"></div>';  
            

                  //blurb boxes
                    echo '<div class="blurb">';
                    $connection_poi_id = get_poi_id (strtoupper($connection));
                    $connection_data = $compare_data[$connection . '2' . $connection];
                    $relationship_id = $connection_data["relationship_id"];
                    echo '<div class="text"><span class="hide_show">SHOW TEXT</span></div>';
                    echo "<span class='small_intro text_block'>" . substr(get_dynamic_blurb ($connection_poi_id, $connection_poi_id), 0, 53); 
                    echo "...</span>";
                    show_dynamic_info($connection_poi_id, $connection_poi_id, $relationship_id, $chart_id1, $chart_id2);
                    show_poi_dynamic_blurb ($connection_poi_id, $connection_poi_id, $relationship_id, $text_type, $chart_id1, $chart_id2);
                    echo '</div>';
                    //' . ucfirst($relationship_name) . '  --TOOK OUT OF <A> SPAN DYNAMIC ICON

          echo '</div>';  //closing poi_column_wrapper
          echo '</li>';  
        
      }
      echo '</ul>';
      echo '</div>';
    
      echo '</div>';
      echo '</form>';
    echo '</div>'; //close #major
  //echo '</div>';   //closing #section
  //echo '</div>';  //closing #compare

  
}

function show_minor_connections ($compare_data, $text_type, $goTo = ".", $stage="2", $chart_id1, $chart_id2) {


  //echo $chart_id1 . ' ' . $chart_id2;
  if(isset($_SESSION['alternate_chart_gender'])) {
    $alt_gender = $_SESSION['alternate_chart_gender'];
    //echo $_SESSION['alternate_chart_gender'];
  }
  if($temp_id = get_user_id_from_chart_id($chart_id2)) {
              if (get_gender($temp_id) == "M") {
                  $gender = 'HIS';
              }
              elseif (get_gender($temp_id) == "F") {
                 $gender = 'HER';
              }
              else {
                  $gender = '';
              }
      }
      elseif ($alt_gender) {
              if ($alt_gender == "M") {
                  $gender = 'HIS';
              }
              elseif ($alt_gender == "F") {
                   $gender = 'HER';
              }
              else {
                  $gender = '';
              }
      }
      else {
         $gender = '';
      }    
      $connection_type = "rising";
      //if ( isset($_POST["connection_type"]) and in_array($_POST["connection_type"], get_cornerstones()) ) {
      //  $connection_type = $_POST["connection_type"];
      //}
      
      //Log the Action
      log_this_action (compare_action_minor(), viewed_basic_action(), $chart_id2, $stage, get_poi_id (strtoupper($connection_type)));

    //***********---Matt Added for Redesign---

      //echo '<div id="compare">';
        //echo'<div id="section">';
      echo '<div id="minor">';
    //----ENDMATT--- 

        echo '<div id="minor_subnav" class="later_on">';
          //echo '<div style="position: relative; bottom: 8px; font-size:1.9em;">Support For: </div>';
          echo '<div class="mc mc_rising selected">Rising Sign <br/> Connection <input type="hidden" value="0" /></div>';
          echo '<div style="width:1px; background:black; height: 36px;"></div>';
          echo '<div class="mc mc_sun">Sun Sign <br/> Connection <input type="hidden" value="1" /></div>';
          echo '<div style="width:1px; background:black; height: 36px;"></div>';
          echo '<div class="mc mc_moon">Moon Sign <br/> Connection <input type="hidden" value="2" /></div>';
          echo '<div style="width:1px; background:black; height: 36px;"></div>';
          echo '<div class="mc mc_venus">Venus Sign <br/> Connection <input type="hidden" value="3" /></div>';
        echo '</div>';

      //echo '<form name="minor_connection_browser" action="." method="post">';
      echo '<input type="hidden" name="connection_type"/>';
      echo '<div id="minor_connections">'; 
      
             

      
      echo '<div class="poi_column">';
      //echo '<ul>';
      //echo '*' . $connection_type . '*';
      $support_con = array();
      $support_con = get_cornerstones();
      //$connection = get_cornerstones();
      //$connection = $connection[0];

      
      $x = 0;
      foreach (get_cornerstones() as $connection) {

        $relationship_ids = array(); //keep track of amount of support for each connection
      //for ($x = 0; $x < 5; $x++) {

        //$connection_type = $support_con[$x];
          echo '<div id="mc_';
            if ($x == 0) {
              echo 'rising';
            }
            elseif ($x == 1) {
              echo 'sun';
            }
            elseif ($x == 2) {
              echo 'moon';
            }
            else {
              echo 'venus';
            }
          echo '">';
          //echo '<li>'; 
          echo '<div class="poi_column_wrapper_minor">';
          $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));  //in user functions
          $button_sign_id2 = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
         
          
          //Left Side;
            echo '<div class="left no_hover ' . get_selector_name($button_sign_id) . '_tall';
            echo '"><span class="icon"><span class="minor_poi_title">YOUR</span><span class="poi_title_tall">' . strtoupper($connection) . '</span></span></div>';  //End Left Side
        
          //Right Side
            echo '<div class="right no_hover right_icon_adjust ' . get_selector_name($button_sign_id2) . '_tall';
            echo '"><span class="icon"><span class="minor_poi_title">' . $gender . '</span><span class="poi_title_tall">' . strtoupper($connection) . '</span></span></div>';  //End Right Side

                //Pillars Images

                //Bridge top
                echo '<div class="bridge_top"><div class="bridge_top_title later_on">SUPPORT FOR YOUR ';
                  echo strtoupper($connection);
                echo ' SIGN CONNECTION</div>';

                //End Bridge top

                //Arrow Test
                echo '<span class="add_arrow_top"><span></span></span>';

                echo '</div>';  //close Bridge Top

                //End Arrow Test

                //Blurb Boxes and Pillars
                //Your Y to their X
                  $z = 1;
                  for ($y = 0; $y < count(get_cornerstones()); $y++) {
                    $con_x = $support_con[$x];
                    $con_y = $support_con[$y];
                    if ($con_x != $con_y) {
                      $button_sign_id3 = get_sign_from_poi ($chart_id1, get_poi_id (strtoupper($con_y)));
                      $relationship_id2 = $compare_data[$con_y .'2' . $con_x]["relationship_id"];
                    //echo 'c1: ' . $connection1 . '<br>c2: ' . $connection2;
                    //echo $connection1 . 'to';
                    //echo $connection2 . '<br>';
                      echo '<div class="';
                        if($relationship_id2 < 5) {
                          echo 'pillar">';
                        }
                        else {
                          echo 'pillar_broken">';
                        }

                      //echo '">';
                        echo '<div class="pillar_icon_minor L ' . get_selector_name($button_sign_id3) . '_tall';
                        echo '"><span class="icon pointer main to_leg' . $z . '"><span class="minor_poi_title">YOUR</span><span class="poi_title_tall">' . strtoupper($con_y) . '</span></span></div>';                     
                      echo '</div>'; //close pillar/pillar_broken
                          $z++; 
                          array_push($relationship_ids, $relationship_id2);
                    }
                    
                  } //close your Y to their X
                
                //Your X to their Y
                $zz = 4;    
                for ($y = 0; $y < count(get_cornerstones()); $y++) {

                  $con_x = $support_con[$x];
                  $con_y = $support_con[$y];
                  if ($con_x != $con_y) {
                    $button_sign_id4 = get_sign_from_poi ($chart_id2, get_poi_id (strtoupper($con_y)));
                    $relationship_id2 = $compare_data[$con_x .'2' . $con_y]["relationship_id"];
                    //echo 'c1: ' . $connection1 . '<br>c2: ' . $connection2;
                    //echo $connection1 . 'to';
                    //echo $connection2 . '<br>';
                     echo '<div class="';
                        if($relationship_id2 < 5) {
                          echo 'pillar">';
                        }
                        else {
                          echo 'pillar_broken">';
                        }
                    
                        echo '<div class="pillar_icon_minor R ' . get_selector_name($button_sign_id4) . '_tall';
                        echo '"><span class="icon pointer main to_leg' . $zz . '"><span class="minor_poi_title">' . $gender . '</span>';

                        echo '<span class="poi_title_tall">' . strtoupper($con_y) . '</span></span></div>';
                    //echo 'c1: ' . $connection1 . '<br>c2: ' . $connection2;
                    //echo $connection1 . 'to';
                    //echo $connection2 . '<br>';
                        echo '</div>'; //close pillar/pillar_broken
                          $zz++; 
                          array_push($relationship_ids, $relationship_id2);
                    }
                    
                  } //close your X to their Y

                echo '<div class="support_level later_on">' . get_minor_compare_support_level($relationship_ids) . '</div>';

                echo '<div class="bridge_base"><img src="/img/Starma-Astrology-Stairs.png" /></div>'; //Base

                  //Blurb Boxes for 1-3 (yours to theirs)
                $zzz = 1;    
                for ($y = 0; $y < count(get_cornerstones()); $y++) {
                  $con_x = $support_con[$x];
                  $con_y = $support_con[$y];
                    if ($con_x != $con_y) {
                          $relationship_id2 = $compare_data[$con_y .'2' . $con_x]["relationship_id"];
                          $connection_poi_id_A = get_poi_id (strtoupper($con_y));
                          $connection_poi_id_B = get_poi_id (strtoupper($con_x));
                            //echo 'cA: ' . $connection_poi_id_A . 'cB: ' . $connection_poi_id_B . '<br> rID: ' . $relationship_id2;
                                                          
                              //BLURB BOX
                              echo "<div class='blurb_supporting text_block leg" . $zzz . "'>";
                                //DYNAMIC ICON
                                echo '<div class="dynamic_icon ' . get_rela_selector_name($relationship_id2); //REMOVED .dynamic_column class
                                echo '"></div>'; 
                                if ($temp_id = get_user_id_from_chart_id($chart_id2)) {
                                  //echo "<span>" . gender_converter_wrapper (get_gender($temp_id), get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                                  echo '<span>' . gender_converter_wrapper (get_gender($temp_id), get_minor_dynamic_blurb($connection, $connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . '</span>';
                                }
                                elseif ($alt_gender) {
                                  echo '<span>' . gender_converter_wrapper ($alt_gender, get_minor_dynamic_blurb($connection, $connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . '</span>';
                                  //echo "<span>" . gender_converter_wrapper ($alt_gender, get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                                }
                                else {
                                  echo '<span>' . get_minor_dynamic_blurb($connection, $connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2) . '</span>';
                                  //echo "<span>" . get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, $text_type, $chart_id1, $chart_id2) . "</span>";
                                }
                              echo '</div>'; //close Blurb Box
                             $zzz++;
                    }
                   
                  }

                  //Blurb Boxes for 4-6 (theirs to yours)
                  $zzzz = 4;    
                  for ($y = 0; $y < count(get_cornerstones()); $y++) {
                      $con_x = $support_con[$x];
                      $con_y = $support_con[$y];
                      if ($con_x != $con_y) {
                        $relationship_id2 = $compare_data[$con_x .'2' . $con_y]["relationship_id"];
                        $connection_poi_id_A = get_poi_id (strtoupper($con_x));
                        $connection_poi_id_B = get_poi_id (strtoupper($con_y));
                        //echo 'cA: ' . $connection_poi_id_A . 'cB: ' . $connection_poi_id_B . '<br> rID: ' . $relationship_id2;
                              
                        //BLURB BOX
                          echo "<div class='blurb_supporting text_block leg" . $zzzz . "'>";
                            //DYNAMIC ICON
                            echo '<div class="dynamic_icon ' . get_rela_selector_name($relationship_id2); //REMOVED .dynamic_column class
                            echo '"></div>'; 
                            //echo 'r_id: ' . $relationship_id2;
                            if ($temp_id = get_user_id_from_chart_id($chart_id2)) {                                  
                              echo '<span>' . gender_converter_wrapper (get_gender($temp_id), get_minor_dynamic_blurb($connection, $connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . '</span>';
                            }
                            elseif ($alt_gender) {
                              echo '<span>' . gender_converter_wrapper ($alt_gender, get_minor_dynamic_blurb($connection, $connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . '</span>';
                            }
                            else {
                              echo '<span>' . get_minor_dynamic_blurb($connection, $connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2) . '</span>';
                            }
                            /*
                            if ($temp_id = get_user_id_from_chart_id($chart_id2)) {
                              echo "<span>" . gender_converter_wrapper (get_gender($temp_id), get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                            }
                            elseif ($alt_gender) {
                                  echo "<span>" . gender_converter_wrapper ($alt_gender, get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, 1, $chart_id1, $chart_id2)) . "</span>";
                                }
                            else {
                              echo "<span>" . get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id2, $text_type, $chart_id1, $chart_id2) . "</span>";
                            }
                            */
                          echo '</div>'; //close Blurb Box 
                          $zzzz++;
                      }
                      
                    }

                  
                //echo '</div>'; //close Pillars
                //End Pillars
                  
                 echo "</div>"; //close poi_column_wrapper
                 //echo '</li>';
                 echo '</div>'; //close mc_poi
              $x++;
            } //end ForEach <li>
            //} //TEST FOR LOOP

          //echo '</ul>';
        echo '</div>'; //close poi_column
       echo '</div>'; //close minor_connections
      //echo '</form>';
    echo '</div>'; //close #minor
      //echo '</div>';   //closing #section
      //echo '</div>';  //closing #compare
      
            
    }


/*****************EndMatt---*/


/* Old Way
function show_major_connections ($compare_data, $text_type, $goTo = ".", $stage="2", $chart_id1, $chart_id2) {


      $connection_type = "rising";
      if ( isset($_POST["connection_type"]) and in_array($_POST["connection_type"], get_cornerstones()) ) {
      
        $connection_type = $_POST["connection_type"];
      }

      //Log the Action
      log_this_action (compare_action_major(), viewed_basic_action(), $chart_id2, $stage, get_poi_id (strtoupper($connection_type)));
  
  //Matt Redesign

    echo '<div id="compare">';
      echo'<div id="section">';
  //ENDMATT   

      echo '<form name="major_connection_browser" action="." method="post">';
      echo '<input type="hidden" name="connection_type"/>';
      echo '<div id="major_connections">'; 
      
             

      //Left Side;
      echo '<div class="chart_tabs left_side stage' . $stage . '"/>';
      echo '<ul>';
      //echo '*' . $connection_type . '*';
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));
          echo '<li class="' . get_selector_name($button_sign_id);
          if ($connection_type == $connection or $stage==2) { 
            echo ' selected';
          }
          echo '"><a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($connection) . '</span></a></li>';  
        
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side
     
      //Right Side
      
      echo '<div class="chart_tabs right_side stage' . $stage . '"/>';
      echo '<ul>';
      
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
          echo '<li class="' . get_selector_name($button_sign_id);
          if ($connection_type == $connection or $stage==2) { 
            echo ' selected';
          }
          echo '"><a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($connection) . '</span></a></li>';  
        
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side
 
      
     
      //if ($stage !="3") {
        //left arrows
        echo '<div class="chart_tabs left_side arrows stage' . $stage . '"/>';
        echo '<ul>';
      
        foreach (get_cornerstones() as $connection) {
          if ($connection_type == $connection or $stage==2) { 
            echo '<li class="left_side_arrow"><a href=""></a></li>';
          }
          else {
            echo '<li class=""><a href=""></a></li>';
          }
      
        }
        echo '</ul>';
        echo '</div>';
        //End left arrows
   
        //right arrows
        echo '<div class="chart_tabs right_side arrows stage' . $stage . '"/>';
        echo '<ul>';
      
        foreach (get_cornerstones() as $connection) {
          if ($connection_type == $connection or $stage==2) { 
            echo '<li class="right_side_arrow"><a href="#"></a></li>';
          }
          else {
            echo '<li class=""><a href=""></a></li>';
          }
      
        }
        echo '</ul>';
        echo '</div>';
        //End right arrows 
      //}
      

      if ($stage=="3") {
        if ($connection_type != "none") {
          echo '<div id="blurb">';
            $connection_poi_id = get_poi_id (strtoupper($connection_type));
            $connection_data = $compare_data[$connection_type . '2' . $connection_type];
            $relationship_id = $connection_data["relationship_id"];
            //echo "<span>" . get_poi_dynamic_blurb ($connection_poi_id, $connection_poi_id, $relationship_id) . "</span>";
            show_dynamic_info($connection_poi_id, $connection_poi_id, $relationship_id, $chart_id1, $chart_id2);
            show_poi_dynamic_blurb ($connection_poi_id, $connection_poi_id, $relationship_id, $text_type, $chart_id1, $chart_id2);
          echo '</div>';
        }
        else {
          echo '<div id="blurb">';
            echo "<span>Please select a dynamic</span>";
          echo '</div>';
        }
      } 
      else {
        //Middle Relationships
        echo '<div class="chart_tabs middle"/>';
        echo '<ul>';
      
        foreach (get_cornerstones() as $connection) {
            //$button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
            $relationship_id = $compare_data[$connection . '2' . $connection]["relationship_id"];
            $relationship_name = $compare_data[$connection . '2' . $connection]["relationship_title"];
            echo '<li class="' . get_rela_selector_name($relationship_id);
            echo '"><a href="#" ';
            echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($relationship_name) . '</span></a></li>';  
        
        }
        echo '</ul>';
        echo '</div>';
        //End Middle Relationships

      }
      echo '</div>';
      echo '</form>';
  echo '</div>';   //closing #section
  echo '</div>';  //closing #compare
}



function show_minor_connections ($compare_data, $text_type, $goTo = ".", $stage="2", $chart_id1, $chart_id2) {


      
      $connection_type = "rising";
      if ( isset($_POST["connection_type"]) and in_array($_POST["connection_type"], get_cornerstones()) ) {
        $connection_type = $_POST["connection_type"];
      }
      
      //Log the Action
      log_this_action (compare_action_minor(), viewed_basic_action(), $chart_id2, $stage, get_poi_id (strtoupper($connection_type)));

    //***********---Matt Added for Redesign---

      echo '<div id="compare">';
        echo'<div id="section">';
    //----ENDMATT--- 

      echo '<form name="minor_connection_browser" action="." method="post">';
      echo '<input type="hidden" name="connection_type"/>';
      echo '<div id="minor_connections">'; 
      
             

      //Left Side;
      echo '<div class="chart_tabs left_side stage' . $stage . '"/>';
      echo '<ul>';
      //echo '*' . $connection_type . '*';
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));
          echo '<li class="' . get_selector_name($button_sign_id);
          if ($connection_type == $connection) { 
            echo ' selected';
          }
          echo '"><a href="#" ';
          echo 'onclick="' . javascript_submit ($form_name="minor_connection_browser", $action=$goTo . "&stage=" . $stage, $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($connection) . '</span></a></li>';  
        
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side
     
      //Right Side
      
      echo '<div class="chart_tabs right_side stage' . $stage . '"/>';
      echo '<ul>';
      
      foreach (get_cornerstones() as $connection) {
          $button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
          echo '<li class="' . get_selector_name($button_sign_id);
          if ($connection_type != $connection) { 
            echo ' selected';
          }
          else {
            echo ' no_hover';
          }
          echo '"><a href="#"/><span>' . ucfirst($connection) . '</span></a></li>';  
        
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side

      
      //left arrows
        echo '<div class="chart_tabs left_side ' . $connection_type . ' arrows stage' . $stage . '"/>';
        
        echo '</div>';
      //End left arrows 
   
      //right arrows
        echo '<div class="chart_tabs right_side ' . $connection_type . ' arrows stage' . $stage . '"/>';
        if ($stage == 2) {
          echo '<ul>';
      
          foreach (get_cornerstones() as $connection) {
            if ($connection_type != $connection) { 
              echo '<li class="right_side_arrow"><a href="#"></a></li>';
            }
            else {
              echo '<li class=""><a href=""></a></li>';
            }
      
          }
          echo '</ul>';
        }
        echo '</div>';
      //End right arrows
      
      //Middle Relationships
      if ($stage=="3") {
        echo '<div id="multi_blurb">';
        $counter = 0;
        foreach (get_cornerstones() as $connection) {
            if ($connection != $connection_type) {
            
              $relationship_id = $compare_data[$connection_type . '2' . $connection]["relationship_id"];
              $relationship_name = $compare_data[$connection_type . '2' . $connection]["relationship_title"];
              $connection_poi_id_A = get_poi_id (strtoupper($connection_type));
              $connection_poi_id_B = get_poi_id (strtoupper($connection));
              echo "<div id='blurb" . $counter . "'>";
                if ($temp_id = get_user_id_from_chart_id($chart_id2)) {
                  echo "<span>" . gender_converter_wrapper (get_gender($temp_id), get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id, 1, $chart_id1, $chart_id2)) . "</span>";
                }
                else {
                  echo "<span>" . get_poi_dynamic_blurb ($connection_poi_id_A, $connection_poi_id_B, $relationship_id, $text_type, $chart_id1, $chart_id2) . "</span>";
                }
              
              echo "</div>";
              $counter++;
            }
        
        }
        echo '</div>';
      } 
      else {
        //Middle Relationships
        echo '<div class="chart_tabs middle"/>';
        echo '<ul>';
      
        foreach (get_cornerstones() as $connection) {
            
            //$button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
            $relationship_id = $compare_data[$connection_type . '2' . $connection]["relationship_id"];
            $relationship_name = $compare_data[$connection_type . '2' . $connection]["relationship_title"];
            echo '<li class="' . get_rela_selector_name($relationship_id);
            if ($connection_type == $connection) { 
              echo ' hidden';
            }
            
            echo '"><a href="#" ';
            echo 'onclick="' . javascript_submit ($form_name="minor_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection_type . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($relationship_name) . '</span></a></li>';  
            
        
        }
        echo '</ul>';
        echo '</div>';
      }
      
      //End Middle Relationships
     
      echo '</div>';
      echo '</form>';
  
    echo '</div>';   //closing #section
  echo '</div>';  //closing #compare
}

*/  //End Old Way

function show_rp_connections ($compare_data, $text_type, $goTo = ".", $stage="2", $chart_id1, $chart_id2) {

//echo '<div id="compare">';
    //echo'<div id="section">';
    echo '<div id="ruler">';
      echo '<div>Coming Soon...</div>';
    echo '</div>'; //close #ruler
    //echo '</div>';
  //echo '</div>';

/*//NEEDS TO BE REBUILD
      $bonus_connections = array('ruling');
      $connection_type = "ruling";
      if ( isset($_POST["connection_type"]) and in_array($_POST["connection_type"], $bonus_connections) ) {
        $connection_type = $_POST["connection_type"];
         
      }
      $rp_id1 = get_ruling_planet($chart_id1);
      $rp_id2 = get_ruling_planet($chart_id2);

      //Log the Action
      log_this_action (compare_action_bonus(), viewed_basic_action(), $chart_id2, $stage, -2);

    //---Matt Added for Redesign---

      echo '<div id="compare">';
        echo'<div id="section">';
    //----ENDMATT--- 

      echo '<form name="major_connection_browser" action="." method="post">';
      echo '<input type="hidden" name="connection_type"/>';
      echo '<div id="major_connections">'; 
      
             

      //Left Side;
      echo '<div class="chart_tabs left_side stage' . $stage . '"/>';
      echo '<ul>';
      //echo '*' . $connection_type . '*';
      foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
            if ($connection == 'ruling') {
              $button_sign_id = get_sign_from_poi ($chart_id1, $rp_id1);
              //echo $rp_id1;
              if (!$poi_name = get_poi_name ($rp_id1)) {
                 $poi_name = "Unknown";
              }
            } 
            else {
              $button_sign_id = get_sign_from_poi ($chart_id1, get_poi_id (ucfirst($connection)));
              $poi_name = $connection;
            }
            echo '<li class="' . get_selector_name($button_sign_id);
            if ($connection_type == $connection or $stage==2) { 
              echo ' selected';
            }
            echo '"><a href="#" ';
            echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($poi_name) . '</span></a></li>';  
          }
        
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side
     
      //Right Side
    
      echo '<div class="chart_tabs right_side stage' . $stage . '"/>';
      echo '<ul>';
      
      foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
            if ($connection == 'ruling') {
              $button_sign_id = get_sign_from_poi ($chart_id2, $rp_id2); 
              
              if (!$poi_name = get_poi_name ($rp_id2)) {
                 $poi_name = "Unknown";
              }
            }
            else {
              $button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
              $poi_name = $connection;
            }
            echo '<li class="' . get_selector_name($button_sign_id);
            if ($connection_type == $connection or $stage==2) { 
             echo ' selected';
            }
            echo '"><a href="#" ';
            echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($poi_name) . '</span></a></li>';  
          }
        
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side

      //left arrows
        echo '<div class="chart_tabs left_side arrows stage' . $stage . '"/>';
        echo '<ul>';
      
        foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
            if ($connection_type == $connection or $stage==2) { 
              echo '<li class="left_side_arrow"><a href=""></a></li>';
            }
            else {
              echo '<li class=""><a href=""></a></li>';
            }
           }
      
        }
        echo '</ul>';
        echo '</div>';
        //End left arrows
   
        //right arrows
        echo '<div class="chart_tabs right_side arrows stage' . $stage . '"/>';
        echo '<ul>';
      
        foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
            if ($connection_type == $connection or $stage==2) { 
              echo '<li class="right_side_arrow"><a href="#"></a></li>';
            }
            else {
              echo '<li class=""><a href=""></a></li>';
            }
          }
      
        }
        echo '</ul>';
        echo '</div>';
      //End right arrows

      if ($stage=="3") {
        if ($connection_type != "none") {
          echo '<div id="blurb">';
            $relationship_id = $compare_data[$connection_type . '2' . $connection_type]["relationship_id"];
            show_dynamic_info(-1, -1, $relationship_id, $chart_id1, $chart_id2);
            
            show_poi_dynamic_blurb (-1, -1, $relationship_id, $text_type, $chart_id1, $chart_id2);
          echo '</div>';
        }
        else {
          echo '<div id="blurb">';
            echo "<span>Please select a dynamic</span>";
          echo '</div>';
        }
      } 
      else {
        //Middle Relationships
        echo '<div class="chart_tabs middle"/>';
        echo '<ul>';
      
        foreach (get_cornerstones($depth=5) as $connection) {
          if ($connection == 'ruling') { //ONLY RULING HERE
              //$button_sign_id = get_sign_from_poi ($chart_id2, get_poi_id (ucfirst($connection)));
              $relationship_id = $compare_data[$connection . '2' . $connection]["relationship_id"];
              $relationship_name = $compare_data[$connection . '2' . $connection]["relationship_title"];
              echo '<li class="' . get_rela_selector_name($relationship_id);
              echo '"><a href="#" ';
              echo 'onclick="' . javascript_submit ($form_name="major_connection_browser", $action=$goTo . "&stage=3", $hidden="connection_type", $value="'" . $connection . "'", $hidden2="", $value2="") . '"/><span>' . ucfirst($relationship_name) . '</span></a></li>';  
          }
        
        }
        echo '</ul>';
        echo '</div>';
        //End Middle Relationships
      }
      echo '</div>';
      echo '</form>';

    echo '</div>';   //closing #section
  echo '</div>';  //closing #compare
  
*/

}

function show_bonus_connections () {

  //echo '<div id="compare">';
    //echo'<div id="section">';
    echo '<div id="bonus">';
      echo '<div>Coming Soon...</div>';
    echo '</div>'; //close #bonus
    //echo '</div>';
  //echo '</div>';

}

function gender_converter_wrapper ($gender, $blurb) {
  if ($gender == "M") {
    return str_ireplace (array(". h",".  h"), ". H" , str_ireplace (array("hes/shes", "shes/hes"), "he's", str_ireplace (array("he/she", "she/he"), "he", str_ireplace (array("him/her","her/him"), "him", str_ireplace (array("his/her","her/his"), "his", str_ireplace (array("his/hers","hers/his"), "his", $blurb))))));
  }
  elseif ($gender == "F") {
    return str_ireplace (array(". s",".  s"), ". S" , str_ireplace (array("hes/shes", "shes/hes"), "she's", str_ireplace (array("he/she", "she/he"), "she", str_ireplace (array("him/her","her/him"), "her", str_ireplace (array("his/her","her/his"), "her", str_ireplace (array("his/hers","hers/his"), "hers", $blurb))))));
  }
  else {
    return $blurb;
  }
}

function blurb_form ($blurb_type, $the_value1=1, $the_value2=1, $the_value3=1, $the_value4=1) {
  
  echo '<form name="blurb_edit_form" method="post" action="./edit_blurbs.php">';
  echo '<input type="hidden" name="blurb_type" value="' . $blurb_type . '">';
  echo '<table>';
  if ($blurb_type == 'poi_sign') {
   echo '<tr>';
   echo '<td>Select a Point Of Influence:</td>';
   echo '<td>';
   poi_select ($the_name="poi_id", $the_value=$the_value1, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';
   echo '<tr>';
   echo '<td>Select a Sign:</td>';
   echo '<td>';
   sign_select ($the_name="sign_id", $the_value=$the_value2, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';
   echo '<tr>';
   echo '<td>Relation Blurb:</td>';
   echo '<td>';
   echo '<textarea style="width:300px; height:200px" name="blurb">' . get_poi_sign_blurb ($the_value1, $the_value2) . '</textarea>';;
   echo '</td>'; 
   echo '</tr>';
  }
  elseif ($blurb_type == 'poi_dynamic') {
   echo '<tr>';
   echo '<td>Select the first Point of Influence:</td>';
   echo '<td>';
   cornerstone_select ($the_name="poi_id_A", $the_value=$the_value1, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';
   echo '<tr>';
   echo '<td>Select the second Point of Influence:</td>';
   echo '<td>';
   cornerstone_select ($the_name="poi_id_B", $the_value=$the_value2, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';
   echo '<tr>';
   echo '<td>Select the Dynamic:</td>';
   echo '<td>';
   dynamic_select ($the_name="dynamic_id", $the_value=$the_value3, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';

   echo '<tr>';
   echo '<td>Select the Section:</td>';
   echo '<td>';
   section_select ($the_name="section_id", $the_value=$the_value4, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';
 
   echo '<tr>';
   echo '<td>Relation Blurb:</td>';
   echo '<td>';
   echo '<textarea style="width:300px; height:200px" name="blurb">' . get_poi_dynamic_blurb_for_admins ($the_value1, $the_value2, $the_value3, $the_value4) . '</textarea>';
   echo '</td>'; 
   echo '</tr>';
  }

  //MATT ADDED HOUSESE
  elseif ($blurb_type == 'poi_house_ruler') {
   //echo '<tr>';
   //echo '<td>Select a Rising Sign: </td>';
   //echo '<td>';
   //sign_select ($the_name="sign_id", $the_value=$the_value1, $auto_submit=true, $form="blurb_edit_form");
   //echo '</td>'; 
   //echo '</tr>';
   echo '<tr>';
   echo '<td>Select Ruler of the: </td>';
   echo '<td>';
   house_select ($the_name="house_id", $the_value=$the_value2, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';
   echo '<tr>';
   echo '<td>Residing in the: </td>';
   echo '<td>';
   house_select2 ($the_name="house_id2", $the_value=$the_value3, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';
   echo '<tr>';
   echo '<td>Ruling Planet Blurb:</td>';
   echo '<td>';
   //echo $the_value1 . ' and ' . $the_value2 . ' and ' . $the_value3;
   //$poi_house_ruler_blurb = get_poi_house_ruler_blurb ($the_value1, $the_value2, $the_value3);
   echo '<textarea style="width:300px; height:200px" name="blurb">' . get_house_ruler_blurb (1, $the_value2, $the_value3) . '</textarea>';
   echo '</td>'; 
   echo '</tr>';
  }

  elseif ($blurb_type == 'hl_desc_blurb') {
   echo '<tr>';
   echo '<td>Select a House: </td>';
   echo '<td>';
   house_select ($the_name="house_id", $the_value=$the_value1, $auto_submit=true, $form="blurb_edit_form");
   echo '</td>'; 
   echo '</tr>';
   echo '<tr>';
   echo '<td>House Description:</td>';
   echo '<td>';
   //echo $the_value1 . ' and ' . $the_value2 . ' and ' . $the_value3;
   //$poi_house_ruler_blurb = get_poi_house_ruler_blurb ($the_value1, $the_value2, $the_value3);
   echo '<textarea style="width:300px; height:200px" name="hl_desc_blurb">' . get_hl_desc ($the_value1) . '</textarea>';
   echo '</td>'; 
   echo '</tr>';
  }

  echo '</table>';
  echo '<input type="submit" value="Update" name="Update">';
  echo '</form>';
}



function show_poi_sign_blurb ($poi_id, $sign_id, $chart_id=-1) {
  
  $blurb = get_poi_sign_blurb ($poi_id, $sign_id, $chart_id);

/************---Matt added this to Blurb section*/
  $poi_name = get_poi_name($poi_id);
  $house_id = get_house_from_poi ($chart_id, $poi_id);
  $house_name = get_house_name ($house_id);
  $sign_name = get_sign_name ($sign_id);
  echo "<span>"; 
    if($poi_id != 1) {
        echo '<strong>' . ucfirst(strtolower($poi_name)) . ' in ' . ucfirst(strtolower($sign_name));
          if ($poi_id == 9) {
            echo ' & ';
            echo ucfirst(strtolower(get_poi_name($poi_id+1))) . ' in ' . ucfirst(strtolower(get_sign_name (get_sign_from_poi ($chart_id, 10))) . ': </strong>');
          }
          else {
            echo ': </strong>';
          }
    }
    elseif($poi_id == 1) {
        echo '<strong>' .  ucfirst(strtolower($sign_name) . ' ' . ucfirst(strtolower($poi_name)) . ': </strong>');
    }
  echo $blurb . "</span>";
  
  
}

function show_poi_sign_blurb_abbr ($poi_id, $sign_id, $chart_id=-1) {
  
  $blurb = get_poi_sign_blurb ($poi_id, $sign_id, $chart_id);
  if ($chart_id == -1) {
    echo substr($blurb, 0, 140) . "...";
  }
  else {
    echo substr($blurb, 0, 175) . "...";
  }
}

/******************** --Matt-- Need to have Aries Rising instead of Rising in Aries 

if($poi_id != 1) {
  echo ucfirst(strtolower($poi_name)) . ' in ' . ucfirst(strtolower($sign_name)); 
}
else {
  echo ucfirst(strtolower($sign_name) . ' ' . ucfirst(strtolower($poi_name))  );
}

*/
function show_poi_info ($poi_id, $chart_id, $sign_id) {
  $poi_name = get_poi_name($poi_id);
  $house_id = get_house_from_poi ($chart_id, $poi_id);
  $house_name = get_house_name ($house_id);
  $sign_name = get_sign_name ($sign_id);

/************---MATT moving this to beginning of Blurb 
  echo '<div id="planet_sign_title">';
    echo '<h>';
    if($poi_id != 1) {
        echo ucfirst(strtolower($poi_name)) . ' in ' . ucfirst(strtolower($sign_name));
    }
    if ($poi_id == 9) {
        echo ' & ';
        echo ucfirst(strtolower(get_poi_name($poi_id+1))) . ' in ' . ucfirst(strtolower(get_sign_name (get_sign_from_poi ($chart_id, 10))));
    }
    elseif($poi_id == 1) {
        echo ucfirst(strtolower($sign_name) . ' ' . ucfirst(strtolower($poi_name))  );
    }
    echo '</h><br>';
  echo '</div>';
*/
  
  echo '<div id="planet_info">';    
    echo get_poi_blurb ($poi_id);
  echo '</div>';
    
}

function show_poi_dynamic_blurb ($connection_poi_id, $connection_poi_id2, $relationship_id, $section_id=1, $chart_id1, $chart_id2) {
  
  if(isset($_SESSION['alternate_chart_gender'])) {
    $alt_gender = $_SESSION['alternate_chart_gender'];
    //echo $_SESSION['alternate_chart_gender'];
  }

  //MATT REDESIGN
     if ($connection_poi_id == -1) {
      $rp_id1 = get_ruling_planet($chart_id1);
      $poi_name1 = "Ruling Planet in";
      $sign_name1 = get_sign_name (get_sign_from_poi ($chart_id1, $rp_id1));
    }
    else {
      $poi_name1 = get_poi_name($connection_poi_id);
      $sign_id1 = get_sign_from_poi ($chart_id1, $connection_poi_id);
      $sign_name1 = get_sign_name ($sign_id1);
    }
    if ($connection_poi_id2 == -1) {
      $rp_id2 = get_ruling_planet($chart_id2);
      $poi_name2 = "Ruling Planet in";
      $sign_name2 = get_sign_name (get_sign_from_poi ($chart_id2, $rp_id2));
    }
    else {
      $poi_name2 = get_poi_name($connection_poi_id2);
      $sign_id2 = get_sign_from_poi ($chart_id2, $connection_poi_id2);
      $sign_name2 = get_sign_name ($sign_id2);
    }


  //END MATT

  if ($user_id2 = get_user_id_from_chart_id($chart_id2)) {
    $blurb = gender_converter_wrapper (get_gender($user_id2),get_poi_dynamic_blurb ($connection_poi_id, $connection_poi_id2, $relationship_id, $section_id, $chart_id1, $chart_id2));
  }
  else {
    $blurb = gender_converter_wrapper ($alt_gender, get_poi_dynamic_blurb ($connection_poi_id, $connection_poi_id2, $relationship_id, $section_id, $chart_id1, $chart_id2));
  }
  if($connection_poi_id == -1) {
    echo "<span class='dynamic_blurb text_block'><strong>" . $poi_name1 . ' ' . ucfirst(strtolower($sign_name1)) . ' to ' . $poi_name2 . ' ' . ucfirst(strtolower($sign_name2)) . ": </strong>" . $blurb . "</span>";
  }
  else {
    echo "<span class='dynamic_blurb text_block'><strong>" . ucfirst(strtolower($sign_name1)) . ' ' . ucfirst(strtolower($poi_name1)) . ' to ' . ucfirst(strtolower($sign_name2)) . ' ' . ucfirst(strtolower($poi_name2)) . ": </strong>" . $blurb . "</span>";
  } 
}


function show_dynamic_info ($connection_poi_id, $connection_poi_id2, $relationship_id, $chart_id, $chart_id2) {
  if ($connection_poi_id == -1) {
    $rp_id1 = get_ruling_planet($chart_id);
    $poi_name1 = "Ruling Planet in";
    $sign_name1 = get_sign_name (get_sign_from_poi ($chart_id, $rp_id1));
  }
  else {
    $poi_name1 = get_poi_name($connection_poi_id);
    $sign_id1 = get_sign_from_poi ($chart_id, $connection_poi_id);
    $sign_name1 = get_sign_name ($sign_id1);
  }
  if ($connection_poi_id2 == -1) {
    $rp_id2 = get_ruling_planet($chart_id2);
    $poi_name2 = "Ruling Planet in";
    $sign_name2 = get_sign_name (get_sign_from_poi ($chart_id2, $rp_id2));
  }
  else {
    $poi_name2 = get_poi_name($connection_poi_id2);
    $sign_id2 = get_sign_from_poi ($chart_id2, $connection_poi_id2);
    $sign_name2 = get_sign_name ($sign_id2);
  }

  //echo $connection_poi_id . '**' . $connection_poi_id2 . '**' . $chart_id . '**' . $chart_id2;

   
  /************---Matt Redesign

  echo '<div id="dynamic_sign_title"';
  if ($connection_poi_id == -1) {
    echo ' style="font-size:1em"';
  }
  echo '>';
    echo '<h>';
    if ($connection_poi_id == -1) {
      echo $poi_name1 . ' ' . ucfirst(strtolower($sign_name1)) . ' to ' . $poi_name2 . ' ' . ucfirst(strtolower($sign_name2));
    }
    else {
      echo ucfirst(strtolower($sign_name1)) . ' ' . ucfirst(strtolower($poi_name1)) . ' to ' . ucfirst(strtolower($sign_name2)) . ' ' . ucfirst(strtolower($poi_name2));
    }
    
    //if ($poi_id == 9) {
    //   echo ' & ';
    //   echo ucfirst(strtolower(get_poi_name($poi_id+1))) . ' in ' . ucfirst(strtolower(get_sign_name (get_sign_from_poi ($chart_id, 10))));
    //}
    echo '</h><br>';
  echo '</div>';
*/
  echo '<div class="dynamic_info text_block">'; 
    if ($connection_poi_id == -1) {
      echo 'The relationship between the Ruling Planet signs further emphasizes the dynamic between the Rising Signs. If the Rising is the lens through which you see the world, the Ruling Planet is the filter that colors that lens.';
    }
    else {   
      echo get_dynamic_blurb ($connection_poi_id, $connection_poi_id2);
    }
  echo '</div>';
    
}



function show_intro_text($western_sun_sign) {
  echo '<div id="planet_info">';
    echo '<p>When someone asks "what\'s your sign?" you might respond by saying "' . $western_sun_sign . '."  A birth chart is a collection of ALL your signs (Moon, Venus, Mars, etc.)  It gives a more well rounded view on different aspects of who you are.  We\'ve calculated your chart using Vedic astrology (Jyotish).  As such, some of your signs will be different than what you\'re accustomed to seeing in your western chart. To see your Western chart, select "Western View."  To learn why we use Vedic Astrology <a href="" title="A Tale of Two Zodiacs">click here</a>.</p>';
    echo '<p><strong>The Cake Metaphor:</strong> It\'s important to consider that reading through your birth chart is like like tasting the different ingredients in a recipe.  If you had never eaten cake before, you could taste an egg, then some sugar, nibble some flour, and sip some milk without ever experiencing the delicious result of having them all baked together.  Similarly, while reading through your birth chart, keep in mind that the ingredients of your chart may seem very different (even contradictory) when read alone, but when read altogether they make something completely different.  Often, it takes a professional astrologer to interpret all the pieces of your chart, but we\'ve created a sampling of ingredients we think you\'ll enjoy.</p>';
    echo '<--  BEGIN BY CLICKING YOUR RISING SIGN ON THE LEFT';

  //echo '<div id="planet_info">';
  //echo 'Your Starma Chart is calculated using the Sidereal Zodiac, a zodiac typically used by Eastern astrologers.  Most Western astrologers use the Tropical Zodiac, so if you\'re already familiar with your chart, the one you\'re about to see may look slightly different.  The reason we\'ve chosen to use the Sidereal Zodiac here at Starma is because it relies on the relationship of points in the sky to the earth, whereas the Tropical Zodiac relies on seasonal changes.  To read more about the Zodiacs, and why Starma utilizes the Sidereal Zodiac, please click <a href="?the_left=nav6&the_page=csel">Learn More About Astrology</a>.'; 
  //echo '<br><br>';
  //echo 'Interpreting your chart is a task for a professional astrologer, so as you read about your different astrological placements, please keep in mind that your chart must be interpreted as a whole.  You may have one placement that says you\'re a shy introvert and another that says you\'re a gregarious extrovert.  This doesn\'t mean that your chart is bogus; it simply means that these are different components of who you are.  Sometimes, one placement may be stronger than another and, to continue with the example, you might feel like more of an introvert than an extrovert, but try to see if you can recognize the latent extrovert within you.  It might finds its moments to surface, and before you know it, you\'re singing Small Town Girl at the top of your lungs on karaoke night. To fully understand your Starma Chart, we recommend an in-depth reading from a Sidereal or Vedic astrologer, but in the meantime, we hope you enjoy reading about your different placements on starma.com!';
  //echo '<br><br>
  //echo '</div>';
}

function show_guest_chart($the_page, $the_left, $user_id, $western=0) {
  $guest_user_id = get_guest_user_id();
  $guest_chart_id = get_guest_chart_id($guest_user_id);
  
  if ($western == 0) {
    $chart_info = get_guest_chart($user_id);
  }
  else {
    //echo 'Hello There';
    $chart_info = get_chart_by_name("Alternate",get_guest_user_id());  
    
  }
  if ($chart_info) {
      $chart_id = $chart_info["chart_id"];
      if (!isset($_POST["poi_id"])) {
        #if (get_my_preferences("chart_more_info_flag", 1) == 0) { 
        $poi_id = 1;
        #}
        #else {
        #  $poi_id = 0;
        #}
      }
      else {
        $poi_id = $_POST["poi_id"];
      }

      $poi_list = get_poi_list();
     
      $sign_id = get_sign_from_poi ($chart_id, $poi_id);

    echo '<div id="profile_chart">';

    echo '<div id="chart_scroll">';
        echo '<div id="chart_scroll_container">';
          echo '<div id="chart_prev">< Previous</div>';
            echo '<div id="birth_chart_type" class="pointer"><a class="later_on" ';
              if ($western == 0) {
                echo 'style="text-decoration:underline;"';
              }
              echo 'href="?the_page=' . $the_page .'&the_left=' . $the_left . '&western=0&section=chart_selected">Vedic</a>  |  ';
              echo '<a class="later_on" ';
              if ($western == 1) {
                echo 'style="text-decoration:underline;"';
              }
              echo 'href="?the_page=' . $the_page .'&the_left=' . $the_left . '&western=1&section=chart_selected">Western</a>';
            echo '</div>'; //close birth_chart_type

          echo '<div id="chart_next">Next ></div>';
        echo '</div>';
      echo '</div>'; //Close chart_scroll

      echo '<form name="chart_browser" action="." method="post">';
      echo '<input type="hidden" name="chart_id" value="' . $chart_id . '"/>';  //MATT added VALUE chart ID
      echo '<input type="hidden" name="poi_id"/>';
      echo '<div id="starma_chart">';
      /*
      if (my_chart_flag() == 1) {
        show_circle_and_arrow_hilite("down");
       
      }
      */
/***  --Matt-- Rebuilt with span icons for ajax submit ***/

      echo '<div class="chart_tabs left_side"/>';
      echo '<ul>';
      while ($poi = mysql_fetch_array($poi_list)) {
        if (in_array($poi["poi_id"], poi_left_side())) {
          $button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
          echo '<li class="chart_li ' . get_selector_name($button_sign_id);
          if ($poi_id == $poi["poi_id"]) { 
            echo ' selected';
          }
          echo '">';
          echo '<div class="chart_tabs_wrapper">';

          echo '<span class="icon left pointer"><span class="poi_title">' . $poi["poi_name"] . '</span></span>';
          echo '<span class="arrow ';
            if ($poi_id == $poi["poi_id"]) {
              echo 'arrow_left_on';
            }
          echo '"></span>';
          echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
          echo '<input type="hidden" name="sign_id" value="' . $button_sign_id . '" />';
          echo '</div>'; //close wrapper
          echo '</li>';
          //echo '<a ';
          
        
          //echo 'onclick="' . javascript_submit ($form_name="chart_browser", $action=$goTo, $hidden="poi_id", $value=$poi["poi_id"]) . '"/><span>' . $poi["poi_name"] . '</span></a></li>';
          
        }
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side
      /*
      //Left Side Chart Arrow
      echo '<div class="chart_tabs left_side chart_arrow"/>';
      echo '<ul>';
      $poi_list = get_poi_list();
      while ($poi = mysql_fetch_array($poi_list)) {
        if (in_array($poi["poi_id"], poi_left_side())) {
          if ($poi_id == $poi["poi_id"]) { 
            $the_class="arrow";
          }
          else {
            $the_class="";
          }
          echo '<li class="' . $the_class;
          
          echo '"><a></a></li>';
          
        }
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side Chart Arrow
      */
     
      //Right Side
      $poi_list = get_poi_list();
      echo '<div class="chart_tabs right_side"/>';
      echo '<ul>';
      
      while ($poi = mysql_fetch_array($poi_list)) {
        if (in_array($poi["poi_id"], poi_right_side())) {
          if ($poi["poi_id"] == 9) {
            $rahu_sign_id = get_sign_from_poi ($chart_id, 9);
            $ketu_sign_id = get_sign_from_poi ($chart_id, 10);
            echo '<li class="chart_li ' . get_selector_name($rahu_sign_id, $ketu_sign_id);           
            echo '">';
              echo '<div class="chart_tabs_rk_wrapper">';
                echo '<span class="arrow ';
                echo '"></span>';
                echo '<span class="icon right pointer"><span class="poi_title">' . $poi["poi_name"] . '</span>';
                echo '<span class="ketu_text">Ketu</span>';
                echo '</span>';
                echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
                echo '<input type="hidden" name="sign_id1" value="' . $rahu_sign_id . '" />';
                echo '<input type="hidden" name="sign_id2" value="' . $ketu_sign_id . '" />';
              echo '</div>';

          }
          else {
            $button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
            echo '<li class="chart_li ' . get_selector_name($button_sign_id);  
          
              if ($poi_id == $poi["poi_id"]) { 
               echo ' selected';
              }
              echo '">';
              echo '<div class="chart_tabs_wrapper">';
          
              echo '<span class="arrow ';
              echo '"></span>';

              echo '<span class="icon right pointer"><span class="poi_title">' . $poi["poi_name"] . '</span>';
              echo '</span>';
          //echo '<a ';
          
          //echo 'onclick="' . javascript_submit ($form_name="chart_browser", $action=$goTo, $hidden="poi_id", $value=$poi["poi_id"]) . '"/><span>' . $poi["poi_name"] . '</span>';
    
            echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
          
            echo '<input type="hidden" name="sign_id" value="' . $button_sign_id . '" />';
            echo '</div>';
          }
          echo '</li>';
          
        }
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side
      /*
      //Right Side Chart Arrow
      echo '<div class="chart_tabs right_side chart_arrow"/>';
      echo '<ul>';
      $poi_list = get_poi_list();
      while ($poi = mysql_fetch_array($poi_list)) {
        if (in_array($poi["poi_id"], poi_right_side())) {
          if ($poi_id == $poi["poi_id"]) { 
            $the_class="arrow";
          }
          else {
            $the_class="";
          }
          echo '<li class="' . $the_class;
          
          echo '"><a></a></li>';
        }
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side Chart Arrow
      */
      echo '<div id="blurb" class="text_block">';
        if ($poi_id == 0) {
          show_intro_text();
        }
        else {
          show_poi_info($poi_id, $chart_id, $sign_id);
          show_poi_sign_blurb ($poi_id, $sign_id);
        }
      echo '</div>';
      echo '</div>';
      echo '</form>';
    echo '</div>';  //close #profile_chart
  }

}



function show_my_chart ($the_page, $the_left, $western=0) {

  //$western = $_GET['western'];

  if ($western == 0) {
    $chart_info = get_my_chart();
  }
  else {
    
    $chart_info = get_chart_by_name("Alternate",get_my_user_id());  
    
  }
  if ($chart_info) {
      $chart_id = $chart_info["chart_id"];



  //CHART FLAG TESTING---------------------------------
      
      //if (my_chart_flag()==1) {
      /*
        echo '<div style="margin-bottom:20px;">';
          //echo '<form name="flag_test" method="POST" action="flag_test">';
            echo '<input type="checkbox" id="cfc" /><div id="clickMe">CLICK</div><span> <- Click to set chart flag value</span><br><br>';
            echo '<div class="later_on">Chart flag: <span id="cfv" class="cfv_err">' . my_chart_flag() . '</span>';
        echo '</div>';
      */

        if(my_chart_flag() == 1) {
          echo '<div id="msg_sheen" class="chart_pop">';    
            echo '<div id="msg_sheen_screen_ct" class="chart_pop"></div>';
              
              echo '<div id="msg_sheen_ct1" class="chart_pop msg_sheen_ct">';
                echo '<div id="chart_pop1">';
                echo '<div class="ct_step later_on">1 / 5</div>';
                  echo '<div class="heading">Birth Chart Tutorial</div>';
                  echo '<div class="later_on ct_text">Your Birth Chart is a collection of ALL your signs (Sun, Moon, Venus, etc.)  Most of us know at least a little about our Sun Sign, but reading a Birth Chart gives us a more complete picture on different aspects of our astrological make up.  We\'ve calculated your Birth Chart using Vedic astrology (Jyotish).  As such, some of your signs will be different than what you\'re accustomed to seeing in your Western Chart.</div>';
                  echo '<div class="later_on ct_next" id="ct1_done"><a href="#" class="later_on">Next></a></div>';
              echo '</div>'; //close #chart_pop1
            echo '</div>'; //close msg_sheen_ct1

            echo '<div id="msg_sheen_ct2" class="msg_sheen_ct">';
                echo '<div id="chart_pop2">';
                echo '<div class="ct_step later_on">2 / 5</div>';
                  echo '<div class="later_on ct_text">Most of Starma is built using Vedic astrology, but if you want to see your Western chart, select "Western".</div>';
                  echo '<div class="later_on ct_next" id="ct2_done"><a href="#" class="later_on">Next></a></div>';
              echo '</div>'; //close #chart_pop1
            echo '</div>'; //close msg_sheen_ct2

            echo '<div id="msg_sheen_ct3" class="msg_sheen_ct">';
                echo '<div id="chart_pop3">';
                echo '<div class="ct_step later_on">3 / 5</div>';
                  echo '<div class="later_on ct_text">To learn why we use Vedic Astrology, click "Why Vedic Astrology?".</div>';
                  echo '<div class="later_on ct_next" id="ct3_done"><a href="#" class="later_on">Next></a></div>';
              echo '</div>'; //close #chart_pop1
            echo '</div>'; //close msg_sheen_ct3

            echo '<div id="msg_sheen_ct4" class="msg_sheen_ct">';
                echo '<div id="chart_pop4">';
                echo '<div class="ct_step later_on">4 / 5</div>';
                  echo '<div class="later_on ct_text">Important! As you read through your Birth Chart, keep this analogy in mind: If you had never eaten cake before, and you separately tasted eggs, sugar, flour and milk, it might be hard to imagine the result of having them all baked together. Similarly, if you separately read your Sun, Moon and Venus signs, they might all have their own contradictory meaning. Understanding how the ingredients of your chart all "bake" together is the job of an astrologer. What you\'re about to read, we affectionately refer to as "Cook Book Astrology." For a more in depth understanding of your Birth Chart, please consult an astrologer.</div>';
                  echo '<div class="later_on ct_next" id="ct4_done"><a href="#ct5" class="later_on">Next></a></div>';
              echo '</div>'; //close #chart_pop1
            echo '</div>'; //close msg_sheen_ct3

            echo '<div id="msg_sheen_ct5" class="msg_sheen_ct">';
                echo '<div id="chart_pop5">';
                echo '<div class="ct_step later_on">5 / 5</div>';
                  echo '<div class="later_on ct_text">Click through these links to read different aspects of your Birth Chart. If you want to see this tutorial again, go to "Settings" and select "Turn on Birth Chart Tutorial".</div>';
                  echo '<div class="later_on ct_next" id="ct5_done"><a href="#" class="later_on">Done</a></div>';
              echo '</div>'; //close #chart_pop1
            echo '</div>'; //close msg_sheen_ct3

        echo '</div>'; //close msg_sheen
        }
        

      //}
      /*
      if (!isset($_POST["poi_id"])) {
        #if (get_my_preferences("chart_more_info_flag", 1) == 0) { 
        if (my_chart_flag() == 1 && $western == 0) {
          $poi_id = 0;
        }
        else {
          $poi_id = 1;
        }       
        #}
        #else {
        #  $poi_id = 0;
        #}
      }
      else {*/
        //$poi_id = $_POST["poi_id"];
        $poi_id = 1;
      //}

      //if ($poi_id > 0 and my_chart_flag() == 1) {
  
      //   set_my_chart_flag(0);
      
      //}

      $poi_list = get_poi_list();
     
      $sign_id = get_sign_from_poi ($chart_id, $poi_id);

    echo '<div id="profile_chart">';


      echo '<div id="chart_scroll">';
        echo '<div id="chart_scroll_container">';
          echo '<div id="chart_prev">< Previous</div>';
          echo '<div id="birth_chart_type" class="pointer"><a class="later_on" ';
            if ($western == 0) {
              echo 'style="text-decoration:underline;"';
            }
            echo 'href="?the_page=' . $the_page .'&the_left=' . $the_left . '&western=0&section=chart_selected">Vedic</a>  |  ';
            echo '<a class="later_on" ';
            if ($western == 1) {
              echo 'style="text-decoration:underline;"';
              //echo '<div id="birth_chart_type" class="pointer"><a class="later_on" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=chart_selected">Switch to Vedic View</a></div>';
            }
            echo 'href="?the_page=' . $the_page .'&the_left=' . $the_left . '&western=1&section=chart_selected">Western</a>';
          echo '</div>'; //close birth_chart_type
          echo '<div id="chart_next">Next ></div>';
        echo '</div>';
      echo '</div>'; //Close chart_scroll

      
      echo '<form name="chart_browser" action="." method="post">';
      echo '<input type="hidden" name="chart_id" value="' . $chart_id . '"/>';  //MATT added VALUE chart ID
      echo '<input type="hidden" name="chart_id_e" value="' . $chart_id . '"/>'; //FOR CHART SUBMIT
      echo '<input type="hidden" name="poi_id"/>';
      echo '<div id="starma_chart">';
   
      if (my_chart_flag() == 1) {
        //show_circle_and_arrow_hilite("down");
       echo '<div id="poi_circle_left"></div>';
       echo '<div id="poi_circle_right"></div>';
      }

/***  --Matt-- Rebuilt with span icons for ajax submit ***/

      echo '<div class="chart_tabs left_side"/>';
      echo '<ul>';
      while ($poi = mysql_fetch_array($poi_list)) {
        if (in_array($poi["poi_id"], poi_left_side())) {
          $button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
          echo '<li class="chart_li ' . get_selector_name($button_sign_id);
          if ($poi_id == $poi["poi_id"]) { 
            echo ' selected';
          }
          echo '">';
          echo '<div class="chart_tabs_wrapper">';

          echo '<span class="icon left pointer"><span class="poi_title">' . $poi["poi_name"] . '</span></span>';
          echo '<span class="arrow ';
            if ($poi_id == $poi["poi_id"]) {
              echo 'arrow_left_on';
            }
          echo '"></span>';
          echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
          echo '<input type="hidden" name="sign_id" value="' . $button_sign_id . '" />';
          echo '</div>'; //close wrapper
          echo '</li>';
          //echo '<a ';
          
        
          //echo 'onclick="' . javascript_submit ($form_name="chart_browser", $action=$goTo, $hidden="poi_id", $value=$poi["poi_id"]) . '"/><span>' . $poi["poi_name"] . '</span></a></li>';
          
        }
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side
      /*
      //Left Side Chart Arrow
      echo '<div class="chart_tabs left_side chart_arrow"/>';
      echo '<ul>';
      $poi_list = get_poi_list();
      while ($poi = mysql_fetch_array($poi_list)) {
        if (in_array($poi["poi_id"], poi_left_side())) {
          if ($poi_id == $poi["poi_id"]) { 
            $the_class="arrow";
          }
          else {
            $the_class="";
          }
          echo '<li class="' . $the_class;
          
          echo '"><a></a></li>';
          
        }
      }
      echo '</ul>';
      echo '</div>';
      //End Left Side Chart Arrow
      */
     
      //Right Side
      $poi_list = get_poi_list();
      echo '<div class="chart_tabs right_side"/>';
      echo '<ul>';
      
      while ($poi = mysql_fetch_array($poi_list)) {
        if (in_array($poi["poi_id"], poi_right_side())) {
          if ($poi["poi_id"] == 9) {
            $rahu_sign_id = get_sign_from_poi ($chart_id, 9);
            $ketu_sign_id = get_sign_from_poi ($chart_id, 10);
            echo '<li class="chart_li ' . get_selector_name($rahu_sign_id, $ketu_sign_id);           
            echo '">';
              echo '<div class="chart_tabs_rk_wrapper">';
                echo '<span class="arrow ';
                echo '"></span>';
                echo '<span class="icon right pointer"><span class="poi_title">' . $poi["poi_name"] . '</span>';
                echo '<span class="ketu_text">Ketu</span>';
                echo '</span>';
                echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
                echo '<input type="hidden" name="sign_id1" value="' . $rahu_sign_id . '" />';
                echo '<input type="hidden" name="sign_id2" value="' . $ketu_sign_id . '" />';
              echo '</div>';

          }
          else {
            $button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
            echo '<li class="chart_li ' . get_selector_name($button_sign_id);  
          
              if ($poi_id == $poi["poi_id"]) { 
               echo ' selected';
              }
              echo '">';
              echo '<div class="chart_tabs_wrapper">';
          
              echo '<span class="arrow ';
              echo '"></span>';

              echo '<span class="icon right pointer"><span class="poi_title">' . $poi["poi_name"] . '</span>';
              echo '</span>';
          //echo '<a ';
          
          //echo 'onclick="' . javascript_submit ($form_name="chart_browser", $action=$goTo, $hidden="poi_id", $value=$poi["poi_id"]) . '"/><span>' . $poi["poi_name"] . '</span>';
    
            echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
          
            echo '<input type="hidden" name="sign_id" value="' . $button_sign_id . '" />';
            echo '</div>';
          }
          echo '</li>';
          
        }
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side
      /*
      //Right Side Chart Arrow
      echo '<div class="chart_tabs right_side chart_arrow"/>';
      echo '<ul>';
      $poi_list = get_poi_list();
      while ($poi = mysql_fetch_array($poi_list)) {
        if (in_array($poi["poi_id"], poi_right_side())) {
          if ($poi_id == $poi["poi_id"]) { 
            $the_class="arrow";
          }
          else {
            $the_class="";
          }
          echo '<li class="' . $the_class;
          
          echo '"><a></a></li>';
        }
      }
      echo '</ul>';
      echo '</div>';
      //End Right Side Chart Arrow
      */
      echo '<div id="blurb" class="text_block">';
        if ($poi_id == 0) {
          $chart_info = get_chart_by_name("Alternate",get_my_user_id());  //GET WESTERN SUN SIGN
          $western_sun_sign = get_sign_name(get_sign_from_poi ($chart_info['chart_id'], 2));
          show_intro_text($western_sun_sign);
        }
        else {
          show_poi_info($poi_id, $chart_id, $sign_id);
          show_poi_sign_blurb ($poi_id, $sign_id);
        }
      echo '</div>';
      echo '</div>';
      echo '</form>';

    echo '</div>';  //close #profile_chart
  }
}

function show_others_chart ($the_page, $the_left, $chart_id2, $western=0) {

  //$western_there = grab_var('western_there',chart_already_there("Alternate",get_user_id_from_chart_id($chart_id2)));
  if ($western == 0 or is_freebie_chart($chart_id2)) {
    //$chart_info = get_chart($chart_id);
    $calc_chart_id = $chart_id2;
  }
  else {
    $calc_chart_id = chart_already_there("Alternate",get_user_id_from_chart_id($chart_id2));  
  }
  if ($chart_info = get_chart($calc_chart_id)) {
      $goTo = $goTo . '&chart_id2=' . $chart_id2;
      if (!isset($_POST["poi_id"])) {
        $poi_id = 1;
      }
      else {
        $poi_id = $_POST["poi_id"];
      }
      $poi_list = get_poi_list();
     
      $sign_id = get_sign_from_poi ($calc_chart_id, $poi_id);
      //echo '&&' . $sign_id . '&&<br>';
    echo '<div id="profile_chart">';

    if (!is_freebie_chart($chart_id2)) {
      $tier = 3;
    }
    else {
      $tier = 4;
    }
      echo '<div id="chart_scroll">';
        echo '<div id="chart_scroll_container">';
          echo '<div id="chart_prev">< Previous</div>';
          if (isLoggedIn()) {
            echo '<div id="birth_chart_type" class="pointer"><a class="later_on" ';
              if ($western == 0) {
                echo 'style="text-decoration:underline;"';
              }
              echo 'href="?the_page=' . $the_page .'&the_left=' . $the_left . '&chart_id2=' . $chart_id2 . '&tier=' . $tier . '&western=0&section=chart_selected">Vedic</a>  |  ';
              echo '<a class="later_on" ';
              if ($western == 1) {
                echo 'style="text-decoration:underline;"';
              }
              echo 'href="?the_page=' . $the_page .'&the_left=' . $the_left . '&chart_id2=' . $chart_id2 . '&tier=' . $tier . '&western=1&section=chart_selected">Western</a>';
            echo '</div>'; //close birth_chart_type
          }
          else {
            echo '<div id="birth_chart_type" class="pointer">';
              echo '<a class="later_on" style="text-decoration:underline;">Vedic</a>  |  ';
              echo '<a class="later_on pop_guest_click">Western</a>';
            echo '</div>'; //close birth_chart_type
          }
          
          echo '<div id="chart_next">Next ></div>';
        echo '</div>';
      echo '</div>'; //Close chart_scroll

      echo '<form name="chart_browser" action="." method="post">';
      echo '<input type="hidden" name="chart_id" value="' . $calc_chart_id . '"/>';
      echo '<input type="hidden" name="chart_id_e" value="' . $chart_id2 . '"/>';  //FOR CHART SUBMIT AJAX
      echo '<input type="hidden" name="poi_id"/>';
      echo '<div id="starma_chart">';
      $header = "";
      if (!is_freebie_chart($chart_id2)) {
        $user_info = profile_info(get_user_id_from_chart_id($chart_id2));
        
        $user_title = $user_info["nickname"];
        if (substr(strtoupper($user_info["nickname"]), -1) == "S") {
          $user_title = $user_title . "'";
        }
        else {
          $user_title = $user_title . "'s";
        }
        $header = $header . $user_title . " Chart";
      }
    
       //echo '<div id="top_ad_space">';
       //  echo 'Your Ad Here';
       //echo '</div>';
      if(isLoggedIn()) {
        //Left Side
      echo '<div class="chart_tabs left_side"/>';
      echo '<ul>';
        while ($poi = mysql_fetch_array($poi_list)) {
          if (in_array($poi["poi_id"], poi_left_side())) {
            $button_sign_id = get_sign_from_poi ($calc_chart_id, $poi["poi_id"]);
            echo '<li class="chart_li ' . get_selector_name($button_sign_id);
            if ($poi_id == $poi["poi_id"]) { 
              echo ' selected';
            }
            echo '">';
            echo '<div class="chart_tabs_wrapper">';

            echo '<span class="icon left pointer"><span class="poi_title">' . $poi["poi_name"] . '</span></span>';
            echo '<span class="arrow ';
              if ($poi_id == $poi["poi_id"]) {
                echo 'arrow_left_on';
              }
            echo '"></span>';
            echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
            echo '<input type="hidden" name="sign_id" value="' . $button_sign_id . '" />';
            echo '</div>'; //close wrapper
            echo '</li>';
          
          }
        }
        echo '</ul>';
        echo '</div>';
        //End Left Side

        //Right Side
        $poi_list = get_poi_list();
        echo '<div class="chart_tabs right_side">';
        echo '<ul>';
      
        while ($poi = mysql_fetch_array($poi_list)) {
          if (in_array($poi["poi_id"], poi_right_side())) {
            if ($poi["poi_id"] == 9) {
              $rahu_sign_id = get_sign_from_poi ($calc_chart_id, 9);
              $ketu_sign_id = get_sign_from_poi ($calc_chart_id, 10);
              echo '<li class="chart_li ' . get_selector_name($rahu_sign_id, $ketu_sign_id);           
              echo '">';
                echo '<div class="chart_tabs_rk_wrapper">';
                  echo '<span class="arrow ';
                  echo '"></span>';
                  echo '<span class="icon right pointer"><span class="poi_title">' . $poi["poi_name"] . '</span>';
                  echo '<span class="ketu_text">Ketu</span>';
                  echo '</span>';
                  echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
                  echo '<input type="hidden" name="sign_id1" value="' . $rahu_sign_id . '" />';
                  echo '<input type="hidden" name="sign_id2" value="' . $ketu_sign_id . '" />';
                echo '</div>';

            }
            else {
              $button_sign_id = get_sign_from_poi ($calc_chart_id, $poi["poi_id"]);
              echo '<li class="chart_li ' . get_selector_name($button_sign_id);  
          
                if ($poi_id == $poi["poi_id"]) { 
                echo ' selected';
                }
                echo '">';
                echo '<div class="chart_tabs_wrapper">';
          
                echo '<span class="arrow ';
                echo '"></span>';

                echo '<span class="icon right pointer"><span class="poi_title">' . $poi["poi_name"] . '</span>';
                echo '</span>';
          //echo '<a ';
          
          //echo 'onclick="' . javascript_submit ($form_name="chart_browser", $action=$goTo, $hidden="poi_id", $value=$poi["poi_id"]) . '"/><span>' . $poi["poi_name"] . '</span>';
    
              echo '<input type="hidden" class="pass_poi_id" value="' . $poi["poi_id"] .'" />';
          
              echo '<input type="hidden" name="sign_id" value="' . $button_sign_id . '" />';
              echo '</div>';
            }
            echo '</li>';
          
          }
        }
        echo '</ul>'; //Close Right ul
        echo '</div>'; //Close Right Side
        //End Right Side
      }
      else {

    //**********************GUEST VIEW OF OTHERS CHART*******************************//
    //LEFT SIDE------------------------------------
      echo '<div class="chart_tabs left_side">';
      echo '<ul>';
        $poi_ids = array(1, 2, 3);
        foreach ($poi_ids as $poi_id_sample) {         
            $button_sign_id = get_sign_from_poi ($calc_chart_id, $poi_id_sample);
            echo '<li class="chart_li ' . get_selector_name($button_sign_id);
            if ($poi_id_sample == 1) { 
              echo ' selected';
            }
            echo '">';
            echo '<div class="chart_tabs_wrapper">';

            echo '<span class="icon left pointer"><span class="poi_title">' . get_poi_name($poi_id_sample) . '</span></span>';
            echo '<span class="arrow ';
              if ($poi_id_sample == 1) {
                echo 'arrow_left_on';
              }
            echo '"></span>';
            echo '<input type="hidden" class="pass_poi_id" value="' . $poi_id_sample .'" />';
            echo '<input type="hidden" name="sign_id" value="' . $button_sign_id . '" />';
            echo '</div>'; //close wrapper
            echo '</li>';
          
          
        }
        echo '<li class="Blurred_button pop_guest_click">
                <div class="chart_tabs_wrapper">
                  <span class="icon left pointer"><span class="poi_title">VENUS</span></span><span class="arrow"></span>
                  <input type="hidden" class="pass_poi_id" value="0" />
                </div> 
              </li>';        
        echo '<li class="Blurred_button pop_guest_click">
                <div class="chart_tabs_wrapper">
                  <span class="icon left pointer"><span class="poi_title">MARS</span></span><span class="arrow"></span>
                  <input type="hidden" class="pass_poi_id" value="0" />
                </div> 
              </li>';        
        echo '</ul>'; //Close Left ul
        echo '</div>'; //Close Left Side
        //End Left Side

      //RIGHT SIDE---------------------------------
        //$poi_list = get_poi_list();
        echo '<div class="chart_tabs right_side">';
        echo '<ul>';
        
        $poi_list = array('MERCURY', 'JUPITER', 'SATURN');
        for ($x = 0; $x<3; $x++) {
          echo '<li class="Blurred_button pop_guest_click">';
            echo '<div class="chart_tabs_wrapper">';
              echo '<span class="arrow"></span>';
              echo '<span class="icon right pointer"><span class="poi_title">' . $poi_list[$x] . '</span>';
              echo '<input type="hidden" class="pass_poi_id" value="0" />';
              echo '</span>';
            echo '</div>';
          echo '</li>';
        }

        echo '<li class="Blurred_button_rk pop_guest_click">';
                echo '<div class="chart_tabs_rk_wrapper">';
                  echo '<span class="arrow"></span>';
                  echo '<span class="icon right pointer"><span class="poi_title">RAHU</span>';
                  echo '<span class="ketu_text">KETU</span>';
                  echo '</span>';
                  echo '<input type="hidden" class="pass_poi_id" value="0" />';
                echo '</div>';
         
        echo '</ul>'; //Close Right ul
        echo '</div>'; //Close Right side
        //End Right Side
      }
        
      echo '<div id="blurb" class="text_block">';
        show_poi_info($poi_id, $calc_chart_id, $sign_id);
        show_poi_sign_blurb ($poi_id, $sign_id, $chart_id2);
        
      echo '</div>';
      echo '</div>';
      echo '</form>';

    echo '</div>';  //close #profile_chart
  }
  else {
    $isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($_GET["chart_id2"])));
    $user_info = profile_info(get_user_id_from_chart_id($chart_id2));
    if ($isCeleb) {
      $user_title = $user_info['first_name'] . ' ' . $user_info['last_name'];
    }
    elseif (!is_freebie_chart($chart_id2)) {
        $user_title = $user_info["nickname"];
    }
    echo '<div style="font-size:1.3em;" class="pointer"><a class="later_on" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $chart_id2 . '&tier=3&western=0&section=chart_selected">< Back to Vedic View</a></div>';
    echo '<div class="later_on" style="font-size:1.3em; margin-bottom: 225px; margin-top: 10px;">' . $user_title . ' does\'t have a western Birth Chart yet.</div>';
  }
}

function show_no_chart() {
  echo '<div id="chart_scroll">';
        echo '<div id="chart_scroll_container">';
          echo '<div id="chart_prev">< Previous</div>';
            echo '<div id="birth_chart_type" class="pointer"><a class="later_on" ';
              if ($western == 0) {
                echo 'style="text-decoration:underline;"';
              }
              echo 'href="?the_page=' . $the_page .'&the_left=' . $the_left . '&chart_id2=' . $chart_id2 . '&tier=' . $tier . '&western=0&section=chart_selected">Vedic</a>  |  ';
              echo '<a class="later_on" ';
              if ($western == 1) {
                echo 'style="text-decoration:underline;"';
              }
              echo 'href="?the_page=' . $the_page .'&the_left=' . $the_left . '&chart_id2=' . $chart_id2 . '&tier=' . $tier . '&western=1&section=chart_selected">Western</a>';
            echo '</div>'; //close birth_chart_type          
          echo '<div id="chart_next">Next ></div>';
        echo '</div>';
      echo '</div>'; //Close chart_scroll
      echo '<div id="starma_chart">';

    //$poi_list = get_poi_list();


    //LEFT SIDE

      $poi_left = poi_left_side();
      echo '<div class="chart_tabs left_side">';
      echo '<ul>';
        for ($x=0; $x<5; $x++) {
            //$button_sign_id = get_sign_from_poi ($calc_chart_id, $poi["poi_id"]);
            echo '<li class="chart_li Unknown_button';
            if ($x == 0) { 
              echo ' selected';
            }
            echo '">';
            echo '<div class="chart_tabs_wrapper">';

            echo '<span class="icon left pointer"><span class="poi_title">' . get_poi_name($poi_left[$x]) . '</span></span>';
            echo '<span class="arrow ';
              if ($x == 0) {
                echo 'arrow_left_on';
              }
            echo '"></span>';
            echo '</div>'; //close wrapper
            echo '</li>';
          
        }
        echo '</ul>';
        echo '</div>';
      
      //END LEFT SIDE


      //RIGHT SIDE
        

        $poi_right = poi_right_side();
        echo '<div class="chart_tabs right_side">';
        echo '<ul>';
        for ($x=0; $x<4; $x++) {
            //$button_sign_id = get_sign_from_poi ($calc_chart_id, $poi["poi_id"]);
          if ($poi_right[$x] == 9) {
            echo '<li class="chart_li Unknown_button rahuketu">';
                echo '<div class="chart_tabs_rk_wrapper">';
                  echo '<span class="arrow"></span>';
                  echo '<span class="icon right pointer"><span class="poi_title">RAHU</span>';
                  echo '<span class="ketu_text">Ketu</span>';
                  echo '</span>';
                echo '</div>';
              echo '</li>';
          }
          else {
            echo '<li class="chart_li Unknown_button">';

            echo '<div class="chart_tabs_wrapper">';

            echo '<span class="icon right pointer"><span class="poi_title">' . get_poi_name($poi_right[$x]) . '</span></span>';
            echo '<span class="arrow ';
              if ($x == 0) {
                echo 'arrow_left_on';
              }
            echo '"></span>';
            echo '</div>'; //close wrapper
            echo '</li>';
          }          
        }
        
        echo '</ul>';
        echo '</div>';

        //END RIGHT SIDE

        show_birth_info_form_no_chart();

}


function show_chart ($chart_id, $goTo = ".") {
  if ($chart_info = get_chart($chart_id)) {
      if (!isset($_POST["poi_id"])) {
        $poi_id = 1;
      }
      else {
        $poi_id = $_POST["poi_id"];
      }
      $poi_list = get_poi_list();
      $poi_name = get_poi_name($poi_id);
      $house_id = get_house_from_poi ($chart_id, $poi_id);
      $house_name = get_house_name ($house_id);
      $sign_id = get_sign_from_poi ($chart_id, $poi_id);
      $sign_name = get_sign_name ($sign_id);
      echo '<form name="chart_browser" action="." method="post">';
      echo '<input type="hidden" name="chart_id"/>';
      echo '<input type="hidden" name="poi_id"/>';
      echo '<div class="chart">';
      echo '<div class="chart_tabs"/>';
      echo '<ul>';
      $counter = 1;
      while ($poi = mysql_fetch_array($poi_list)) {
        echo '<li';
        if ($poi_id == $poi["poi_id"]) { 
          echo ' class="selected"';
        }
        echo '><a href="#" ';
        if ($counter == mysql_num_rows($poi_list)) {
          echo 'class="right_end" ';
        }
        
        echo 'onclick="' . javascript_submit ($form_name="chart_browser", $action=$goTo, $hidden="chart_id", $value=$chart_id, $hidden2="poi_id", $value2=$poi["poi_id"]) . '"/>' . $poi["poi_name"] . '</a></li>';
        $counter = $counter + 1;
      }
      echo '</ul>';
      echo '</div>';
      echo '<div class="planet_info">';
      
      echo '<h>' . $poi_name . '</h><Br>';
      echo 'Sign: ' . $sign_name . '<br><br>';
      //echo 'House: ' . $house_name . '<br>'; 
      show_poi_sign_blurb ($poi_id, $sign_id);
      echo '</div>';
      echo '</div>';
      echo '</form>';
  }
  elseif (isset($_POST["submit"]))  {  //IF NO ID IS GIVEN, CAST CHART BASED ON INPUT
      $longitude = combine_long_pieces ($_POST["c2d"], $_POST["c2m"], $_POST["c2s"]);
      $latitude = combine_pieces ($_POST["c1d"], $_POST["c1m"], $_POST["c1s"]);
      $LoDir = $_POST["LoDir"];
      $LaDir = $_POST["LaDir"];
      $timezone = $_POST["timezone"];
      $daylight = $_POST["daylight"];
      if (trim($_POST['address']) != '') {
      
        if ($coords = get_coordinates($_POST["address"])) {
          //echo '*' . $lat .'*';
          $lat = reformat_coordinate($coords['lat'], 'lat');
          $lng = reformat_coordinate($coords['lng'], 'lng');
          $title = $coords['title'];
          $latitude = $lat[1];
          $longitude = $lng[1];
          $LoDir = $lng[0];
          $LaDir = $lat[0];
          $timezone_object = timezone($coords['lat'], $coords['lng']);
          $timezone = abs((float)$timezone_object["offset"]);
          $daylight = DST($timezone_id = $timezone_object["tID"], $date = $_POST["d1m"] . '/' . $_POST["d1d"] . '/' . $_POST["d1y"]);  
          
        } 
        
      }


      $sTime = combine_pieces ($_POST["t1h"], $_POST["t1m"], $_POST["t1s"]);
      $uTimeResultArray = apply_timezone($timezone, $LoDir, apply_daylight($daylight, $sTime, "false"), "false");
    
      
      
      //echo 'Test Birthday.  THE FOLLOWING IS HARDCODED!  01/01/1901 when put into the PHP date function yields: ' . date("F j, Y", mktime (0, 0, 0, 1, 1, 1901)) . '<br>';
      $birthdate = mktime (0, 0, 0, (int) $_POST["d1m"], (int) $_POST["d1d"], (int) $_POST["d1y"]);
  
      echo 'Born: ' . format_as_time($sTime) . ' on ' . date("F j, Y",$birthdate);
      echo '<br>';
       
      //$uTimeResultArray = time_reducto ($uTime);
      $uTime = $uTimeResultArray[1];
      $greenwichdate = mktime (0, 0, 0, date("m", $birthdate), date("d", $birthdate)+$uTimeResultArray[0], date("Y", $birthdate) );   
      $greenwichDatetimeRounded = mktime (get_hours($uTime), get_minutes($uTime), round(get_seconds($uTime)/60) * 60, date("m", $greenwichdate), date("d", $greenwichdate), date("Y", $greenwichdate));
      $uTimeRounded = combine_pieces (date("H", $greenwichDatetimeRounded), date("i", $greenwichDatetimeRounded), date("s", $greenwichDatetimeRounded));

      //$tCorrection = combine_pieces ($_POST["t2h"], $_POST["t2m"], $_POST["t2s"]);
      //echo 'Greenwich Date: ' . date("Y", $greenwichdate);
      $tCorrectionQ = deltaT ((string) date("Y", $greenwichDatetimeRounded));
      $tCorrection = format_whole_time (remove_letters ($tCorrectionQ["correction"]));
      $tCorrectionSign = $tCorrectionQ["sign"];

      echo 'tCorrection: *' . $tCorrection . '*';
      echo '<br>';
      
      $eTimeDayCorrection = 0;

      if ($tCorrectionSign == -1) {
        $eTime = time_subtract ($uTime, $tCorrection);
        if ($tCorrections > $uTime) {
          $eTime = time_subtract ('240000', $eTime);
          $eTimeDayCorrection = -1;
        }         
      }
      else {
        $eTime = time_add ($uTime, $tCorrection);  
      }
      $eTimeResultArray = time_reducto ($eTime);
      $etime = $eTimeResultArray[1];
      $eTimeResultArray[0] = $eTimeResultArray[0] + $eTimeDayCorrection;
      //echo date ("F j, Y", mktime (0, 0, 0, 11, 15, 1952));

      
    
      echo 'Universal Time: ' . format_as_time($uTime)  . ' on ' . date("F j, Y",$greenwichdate);
      echo '<br>';
      echo 'Universal Greenwich Rounded Time: ' . format_as_time($uTimeRounded)  . ' on ' . date("F j, Y", $greenwichDatetimeRounded);
      echo '<br>';     

      $ephemdate = mktime (0, 0, 0, date("m", $birthdate), date("d", $birthdate)+$eTimeResultArray[0]+$uTimeResultArray[0], date("Y", $birthdate));
   
      echo 'Ephemeris Time: ' . format_as_time($eTime)  . ' on ' . date("F j, Y",$ephemdate);
      echo '<br>';

      //$gsTime00 = combine_pieces ($_POST["t3h"], $_POST["t3m"], $_POST["t3s"]);

      $gsTime00Q = gsTime ($greenwichdate);
      $gsTime00 = format_whole_time (remove_letters ($gsTime00Q["greenwich_sidereal_time"]));
      
      echo 'Greenwich Sidereel Time 00h: ' . format_as_time($gsTime00);
      echo '<br>';

      //$ssCorrection = combine_pieces ($_POST["t4h"], $_POST["t4m"], $_POST["t4s"]);
      
      $ssCorrectionQ = ssCorrection ($uTimeRounded);
      $ssCorrection = format_whole_time (remove_letters ($ssCorrectionQ["correction"]));
      
      echo 'Solar-Sidereal Correction: ' . $ssCorrection; 
      echo '<br>';

      $piece = time_add ($uTime, $gsTime00);
      $gsTime = time_add ($piece, $ssCorrection);

      if ($LaDir == 'South') {
        $gsTime = time_add ($gsTime, '120000');
      }

      
 

      $lcDegrees = combine_pieces ((string) floor(get_long_degrees ($longitude) / 15), (string) (4*(get_long_degrees ($longitude) % 15)), "00");
      $minutes = get_long_minutes (coordinate_long_round ($longitude));
      $lcMinutes = combine_pieces ("00", (string) floor($minutes / 15), (string) (4*($minutes % 15)));
      
      echo 'Longitude Correction Degrees: ' . $lcDegrees;
      echo '<br>';
      echo 'Longitude Correction Minutes: ' . $lcMinutes;
      echo '<br>';
      
      $lCorrection = time_add ($lcDegrees, $lcMinutes);      
      
      $lsTimeResultArray = correct_longitude ($lCorrection, $LoDir, $gsTime);
      $lsTime = $lsTimeResultArray[1];

   
      echo 'Greenwich Sidereel Time: ' . format_as_time($gsTime);
      echo '<br>';           

      $lsdate = mktime (0, 0, 0, date("m", $greenwichdate), date("d", $greenwichdate)+$lsTimeResultArray[0], date("Y", $greenwichdate) );
   
      echo 'Local Sidereel Time: ' . format_as_time($lsTime)  . ' on ' . date("F j, Y",$lsdate); 
      echo '<br>'; 
  
      $eLST = getLSTChunk ($lsTime, "earlier");    
      $lLST = getLSTchunk ($lsTime, "later");
      $LSTInc = time_subtract ($lsTime, $eLST);

      $lowerLat = get_sign_degrees($latitude);
      if ($lowerLat < 20) {
        while ($lowerLat % 5 != 0) {
          $lowerLat = $lowerLat - 1;
        }
        $higherLat = $lowerLat + 5;
      }
      else {
        if (get_sign_minutes ($latitude) == 0 and get_sign_seconds ($latitude) == 0) {
          $higherLat = $lowerLat;
        }
        else {
          $higherLat = $lowerLat + 1; 
        }
      }

      $latInc = coordinate_subtract ($latitude, $lowerLat);

      

      echo 'Earlier LST: ' . $eLST . '<br>';
      echo 'Later LST: ' . $lLST . '<br>';
      echo 'LST Increment: ' . $LSTInc . '<br>';
      echo '<br>';
      echo 'Lower Latitude: ' . $lowerLat . '<br>';
      echo 'Higher Latitude: ' . $higherLat . '<br>';
      echo 'Latitude Increment: ' . $latInc . '<br>';

      $timeInc = (float) time_down_to_seconds ('000400');
      $LSTIncSeconds = (float) time_down_to_seconds ($LSTInc);
     

      //echo $timeInc . '<br>';
      //echo $LSTIncSeconds . '<br>';   
     
      $percentOfTimeInc = $LSTIncSeconds / $timeInc;

      // GET ASCENDANT'S POSITION AT THE *LOWER* LATITUDE

      $lowerLatAscLater = getAscPosition ($lowerLat, $lLST); 
      $lowerLatAscEarlier = getAscPosition ($lowerLat, $eLST);
      
      // echo '<br>**' . poiPositionToSignCoord($lowerLatAscLater) . ' - ' . poiPositionToSignCoord($lowerLatAscEarlier) . '**';  
 
      $lowerCuspInterval = coordinate_subtract (poiPositionToSignCoord($lowerLatAscLater), poiPositionToSignCoord($lowerLatAscEarlier));

      if (poiPositionToSignCoord($lowerLatAscEarlier) > poiPositionToSignCoord($lowerLatAscLater)) {
        $lowerCuspInterval = coordinate_subtract ('300000', $lowerCuspInterval);
      }
  
      $lowerAscOffsetInSeconds = $percentOfTimeInc * (float) coord_down_to_seconds ($lowerCuspInterval);
      $lowerAscOffset = up_to_coord ($lowerAscOffsetInSeconds);
      $lowerAscPosition = coordinate_add (poiPositionToSignCoord($lowerLatAscEarlier), $lowerAscOffset);

      $lowerAscSign = get_poiPosition_sign ($lowerLatAscEarlier);

      echo 'LOWER LATITUDE ASCENDANT POSITION<br>';
 
      echo 'House Cusp at Later LST: ' . $lowerLatAscLater . '<br>';
      echo 'House Cusp at Earlier LST: ' . $lowerLatAscEarlier . '<br>';
      echo 'House Cusp Interval: ' . $lowerCuspInterval . '<br>';

      echo 'Percent of Time Increment: ' . $percentOfTimeInc . '<br>';
      echo 'Distance Ascendant Traveled during the Interval: ' . $lowerAscOffset . '<br>';
      echo '<b>Ascendant\'s Position at the Lower Latitude: ' . $lowerAscPosition . ' ' . $lowerAscSign . '</b><br>';
      echo '<br>';

      // GET ASCENDANT'S POSITION AT THE *HIGHER* LATITUDE

     

      $higherLatAscLater = getAscPosition ($higherLat, $lLST); 
      $higherLatAscEarlier = getAscPosition ($higherLat, $eLST);
      $higherCuspInterval = coordinate_subtract (poiPositionToSignCoord($higherLatAscLater), poiPositionToSignCoord($higherLatAscEarlier));

      if (poiPositionToSignCoord($higherLatAscEarlier) > poiPositionToSignCoord($higherLatAscLater)) {
        $higherCuspInterval = coordinate_subtract ('300000', $higherCuspInterval);
      }

      $higherAscOffsetInSeconds = $percentOfTimeInc * (float) coord_down_to_seconds ($higherCuspInterval);
      // $higherAscOffsetArray = up_to_coord ($higherAscOffsetInSeconds);
      // $higherAscOffset = $higherAscOffsetArray[1];
      $higherAscOffset = up_to_coord ($higherAscOffsetInSeconds);
      $higherAscPosition = coordinate_add (poiPositionToSignCoord($higherLatAscEarlier), $higherAscOffset);

      $higherAscSign = get_poiPosition_sign ($higherLatAscEarlier);
   
      echo 'HIGHER LATITUDE ASCENDANT POSITION<br>';

      echo 'House Cusp at Later LST: ' . $higherLatAscLater . '<br>';
      echo 'House Cusp at Earlier LST: ' . $higherLatAscEarlier . '<br>';
      echo 'House Cusp Interval: ' . $higherCuspInterval . '<br>';

      echo 'Percent of Time Increment: ' . $percentOfTimeInc . '<br>';
      echo 'Distance Ascendant Traveled during the Interval: ' . $higherAscOffset . '<br>';
      echo '<b>Ascendant\'s Position at the Higher Latitude: ' . $higherAscPosition . ' ' . $higherAscSign . '</b><br><br>';


    
      //USE ASCENDANT'S POSITION AT HIGHER AND LOWER LATITUDES TO DETERMINE *EXACT* ASCENDANT'S POSITION AT PLACE/TIME OF BIRTH
      if (get_sign_degrees($latitude) < 20) {
        $CoordInc = (float) coord_down_to_seconds ('050000');
      }
      else { 
        $CoordInc = (float) coord_down_to_seconds ('010000');
      }
      $LatIncInSeconds = (float) coord_down_to_seconds ($latInc);

      
      $percentOfCoordInc = $LatIncInSeconds / $CoordInc;


      $CoordInterval = coordinate_subtract ($higherAscPosition, $lowerAscPosition);  

      $retrograde = 1;

      if ($lowerAscPosition > $higherAscPosition) {
        if ($lowerAscSign != $higherAscSign) {
          $CoordInterval = coordinate_subtract ('300000', $CoordInterval);
          
        }
        else {
          $retrograde = -1;
        }
      }


      $CoordIntervalInSeconds = (float) coord_down_to_seconds ($CoordInterval);

      $AscOffsetInSeconds = $percentOfCoordInc * $CoordIntervalInSeconds;
      // $AscOffsetArray = up_to_coord ($AscOffsetInSeconds);
      // $AscOffset = $AscOffsetArray[1];
      $AscOffset = up_to_coord ($AscOffsetInSeconds);
      
      if ($retrograde > 0) {      
        $AscPosition = coordinate_add ($lowerAscPosition, $AscOffset);
      }
      else {
        $AscPosition = coordinate_subtract ($lowerAscPosition, $AscOffset); 
      }
      $AscSign = $lowerAscSign;
     
      $resultAscArray = Ayanamsafy (date("Y", $greenwichdate), $AscPosition, $AscSign);

      $resultAsc = $resultAscArray[0];
      $AscSign = $resultAscArray[1];
      
      $finalAscArray = coordinate_sign_reducto ($resultAsc);
      $finalAsc = $finalAscArray[1];
      $finalSign = sign_code_arithmetic ($AscSign, $finalAscArray[0]);
      
      if ($LaDir == 'South') {
        $finalSign = sign_code_arithmetic ($AscSign, 6);
      }

      echo 'Ascendant Position at Higher Lat: ' . $higherAscPosition . ' ' . $higherAscSign . '</b><br>';
      echo 'Ascendant Position at Lower Lat:' . $lowerAscPosition . ' ' . $lowerAscSign . '</b><br>';
      echo 'Ascendant Interval: ' . $CoordInterval . '<br>';
      echo 'Percent of Latitude Increment: ' . $percentOfCoordInc . '<br>';
      echo 'Distance Ascendant Traveled during the Interval: ' . $AscOffset . '<br>';
      echo 'Ascentants\' Position Before Ayanamsa: ' . $AscPosition . '<br>';
      echo 'Ayanamsa: ' . ayanamsa (date("Y", $greenwichdate)) . '<br>';
      echo '<b>Ascendant\'s Exact Position at Birth place/time: ' . $finalAsc . ' ' . $finalSign . '</b><br>';

      //echo $timeInc . '<br>';
      //echo $LSTIncSeconds . '<br>';        

      

      return array($longitude, $latitude, $LaDir, $LoDir, $daylight, $timezone, $finalAsc, get_sign_id($finalSign), $eTime, $greenwichdate, $_POST["address"]); 
  }
  else {
    echo 'No Chart Found';
  }
}

/////////////////MATT ADD HOUSES

function show_hl_intro_text($x) {
  if ($x == 1) {
    echo '<div id="hl_info">Oh no!  We need your Rising sign to determine how the houses are placed.  Please enter a more precise <a href="main.php?the_left=nav5&the_page=psel">time of birth</a> so we can get your Rising sign.</div>';
  }
  elseif ($x == 2) {
    echo '<div id="hl_info">Oh no!  Meow.  Please enter a more precise <a href="main.php?the_left=nav5&the_page=psel">time of birth</a> so we can get your Rising sign.</div>';
  }
}

function show_house_lords () {

  $pref_name = 'hl_private';
  $guest_user_id = get_guest_user_id();
  $guest_chart_id = get_guest_chart_id($guest_user_id);

  if (isLoggedIn()) {
    if(!isset($_GET['chart_id2'])) {  //MY HOUSE LORDS
      //$chart_name = 'mine';
      $chart_id = get_my_chart_id();
      $pref = 0;
    }
    elseif (is_freebie_chart($_GET['chart_id2'])) { //CUSTOM
      $chart_id = chart_already_there("Freebie1",get_my_user_id());
      $pref = 0;
      $custum = true;
    }
    else {  //OTHER USER
      //$chart_name = 'other_user';
      $chart_id = $_GET['chart_id2'];
      $pref = get_preferences(get_user_id_from_chart_id($chart_id), $pref_name, 0);
      $username = get_nickname(get_user_id_from_chart_id($chart_id));
    }
    /*
    else {                              //CUSTOM
      //$chart_name = 'custom';
      $chart = get_chart_by_name ("Freebie1");
      $chart_id = $chart["chart_id"];
      $pref = 0;
      $custum = true;
    } 
    */
  }
  else {                                //GUEST USER
    if(!isset($_GET['chart_id2'])) {    //GUEST EXPLORER
      //$chart_name = 'guest';
      $chart_id = $guest_chart_id;
      $pref = 0;
    }               
    elseif (isset($_GET['chart_id2'])) {   //GUEST VIEWING OTHER USER RIGHT NOW NOT POSSIBLE
      //$chart_name = 'guest_other_user';
      $chart_id = $_GET['chart_id2'];
      $pref = 0;
    }
  }
  //echo $pref;
  //if($pref) {
    $can_view = can_view_section($chart_id);
    if (!$can_view[0]) {
      
      echo $can_view[1];
    }     
    else {
     if ($pref == 0) {
      //echo $chart_id;
      $rising_sign_id = get_sign_from_poi ($chart_id, 1);
      //echo $rising_sign_id;

//IF RISING SIGN EXISTS-------------------
      if($rising_sign_id !== -1) { //in user functions
          $sign_id_arr = array();
          $sign_name_arr = array();
          $house_arr = array();
          $ruler_of_sign_arr = array();
          $sign_of_res_arr = array();
          $house_of_res_arr = array();
          $house_blurb_arr = array();

//GET VARIABLES TO BUILD HOUSE LORDS-------------------
        for($i = 1; $i <= 12; $i++) {
          $sign_id = $rising_sign_id + ($i - 1);

          if($sign_id > 12) {
            $sign_id_arr[$i] = $sign_id - 12;
          }
          else {
            $sign_id_arr[$i] = $sign_id;
          }
          $house_arr[$i] = $i;

          $sign_name_arr[$i] = get_sign_name($sign_id_arr[$i]);
        
          $results = get_ruler_of_sign($sign_id_arr[$i]);
          while($row = mysql_fetch_array($results)) {
            $ruler_of_sign_id[$i] = $row["ruling_poi_id"];
            $ruler_of_sign[$i] = strtolower(ucfirst(get_poi_name($row["ruling_poi_id"])));
          }
                
          $sign_of_res_arr[$i] = get_sign_from_poi($chart_id, $ruler_of_sign_id[$i]);

          $house_of_residence = $sign_of_res_arr[$i] - $rising_sign_id;
          if ($house_of_residence < 0) {
            $house_of_residence = $house_of_residence + 12;
          }
          $house_of_res_arr[$i] = $house_of_residence + 1;

          $house_burb_arr[$i] = get_house_ruler_blurb($rising_sign_id, $i, $house_of_res_arr[$i]);

        }

  //BUILD HOUSE LORDS WITH ABOVE VARIABLES------------------------
      echo '<div id="profile_house_lords">';
        echo '<form name="hl_browser" action="." method="post">';
        echo '<input type="hidden" name="chart_id_e" value="' . $chart_id . '"/>'; //FOR CHART SUBMIT
        echo '<input type="hidden" name="rising_sign_id" value="' . $rising_sign_id . '"/>'; //FOR CHART SUBMIT
          echo '<div id="starma_house_lords">';

      //if (my_chart_flag() == 1) {
      //  show_circle_and_arrow_hilite("down");
      //}

            echo '<div class="hl_nav_wrapper">';
      //echo '<ul>';
              for ($h=1; $h < 13; $h++) {
      //for ($h=1; $h < 13; $h++)  {  
          //$button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
          //echo '<li class="hl_li ' . $h . '">';
          //echo '<div class="hl_tabs_wrapper">';

          
          //echo '<span class="hl_title">' . $h . '<br>' . $sign_name_arr[$h] . '</span>';
          //echo '</div>';

                echo '<div class="hl_nav hl_nav_icon_' . $h . ' pointer">';
                  echo '<div></div>';
                  echo '<input type="hidden" class="pass_house_id" value="' . $h .'" />';
                  echo '<input type="hidden" name="sign_id" value="' . $sign_id_arr[$h] . '" />';
                  echo '<input type="hidden" name="ruler_of_sign" value="' . $ruler_of_sign_arr[$h] . '" />';
                  echo '<input type="hidden" name="sign_of_res" value="' . $sign_of_res_arr[$h] . '" />';
                  echo '<input type="hidden" name="house_of_res" value="' . $house_of_res_arr[$h] . '" />';
                echo '</div>';
       
            }
          echo '</div>'; //close hl_nav_wrapper
        // echo '</ul>';
          echo '<div id="hl_scroll_container">';
            echo '<div id="hl_scroll">';
              echo '<div id="hl_prev" class="pointer"></div><div id="hl_next" class="pointer"></div>';
            echo '</div>';
          echo '</div>';

          show_hl_results($chart_id, $username);

        echo '</div>'; //starma_house_lords
      echo '</form>';

    echo '</div>';  //close #profile_house_lords

    }    
    else {  //RISING SIGN EQUALS -1 -------------------------


      echo '<div id="profile_house_lords">';

        echo '<form name="hl_browser" action="." method="post">';
        echo '<input type="hidden" name="chart_id_e" value="' . $chart_id . '"/>'; //FOR CHART SUBMIT
        echo '<input type="hidden" name="rising_sign_id" value="' . $rising_sign_id . '"/>'; //FOR CHART SUBMIT
          echo '<div id="starma_house_lords">';

          if ($chart_id == get_my_chart_id()) {
            echo '<div class="later_on" style="font-size:1.5em; text-align:center; margin-bottom:260px;">Oh no!  We can\'t tell you about your House Lords without a more accurate <a href="' . get_domain() . '/main.php?the_left=nav3&the_page=psel" title="My Birth Time">time of birth</a></div>';
          }
          elseif ($custom) {
            echo '<div class="later_on" style="font-size:1.5em; text-align:center; margin-bottom:260px;">Oh no!  We can\'t tell you about this peron\'s House Lords without a more accurate time of birth</div>';
          }
          else {
            echo '<div class="later_on" style="font-size:1.5em; text-align:center; margin-bottom:260px;">Oh no!  We can\'t tell you about ' . $username . '\'s House Lords without a more accurate time of birth</div>';
          }
      //if (my_chart_flag() == 1) {
      //  show_circle_and_arrow_hilite("down");
      //}
  

          echo '</div>'; //starma_house_lords
        echo '</form>';

      echo '</div>';  //close #profile_house_lords
    }
  }
  else {
    echo '<div class="later_on" style="font-size:1.5em; text-align:center; margin-bottom:260px;">' . $username . ' has chosen to keep this section private.</div>';
  }
  }
  //}
}

function show_hl_results ($chart_id, $username) {

  echo '<div id="hl_results_container">';
    echo '<div id="hl_intro" class="later_on" style="font-size:1.3em; line-height: 1.3; margin:auto; width:450px;">';
      if($chart_id == get_my_chart_id()) {
        echo 'The Zodiac is not only divided into 12 Signs, but also into 12 Houses.  One way that astrologers read a chart is by determining where the Lord of a House resides.  Sound confusing? Don\'t worry, you don\'t need to understand how this is determined in order to read about what this means.  All you have to know is that there are 12 Houses, each House has a Lord, and each Lord has a House it occupies.  The relationship between the House the Lord rules and the House the Lord occupies can tell you a lot about your astrological make up.  We recommend that you start by clicking on your 1st House and read on to see where all 12 of your House Lords reside.';
      }
      else {
        echo 'The Zodiac is not only divided into 12 Signs, but also into 12 Houses.  One way that astrologers read a chart is by determining where the Lord of a House resides.  Sound confusing? Don\'t worry, you don\'t need to understand how this is determined in order to read about what this means.  All you have to know is that there are 12 Houses, each House has a Lord, and each Lord has a House it occupies.  The relationship between the House the Lord rules and the House the Lord occupies can tell you a lot about your astrological make up.  We recommend that you start by clicking on the 1st House and read on to see where all 12 of the House Lords reside.';
      }
   
    echo '</div>';
    echo '<div id="hl_iconL"></div>';
    echo '<div id="palenquin_wrapper">';
      echo '<div id="palenquin_stars" style="display:none;"></div>';
    echo '</div>';
    echo '<div id="hl_iconR"></div>';
  echo '</div>'; //close hl_results_container
  echo '<div id="hl_text_container">';
    echo '<div id="hl_desc" class="text_block"></div>';
    echo '<div id="hl_blurb" class="text_block"></div>';
  echo '</div>';
}





//OLD HOUSE WAY 
/*
/OLD WAY--------------------------------
    
        
      echo '<div id="hl_scroll">';
        echo '<div id="hl_scroll_container">';
          echo '<div id="hl_prev">< Previous</div>';

          echo '<div id="hl_next">Next ></div>';
        echo '</div>';
      echo '</div>'; //Close hl_scroll
  
   //echo '<div class="later_on hl_nav pointer">' . $h . '</div>';
          if($h == 1) {
            echo 'st';
          }
          elseif ($h == 2) {
            echo 'nd';
          }
          elseif ($h == 3) {
            echo 'rd';
          }
          else {
            echo 'th';
          }
        //echo '</div>';
          //echo '<div class="hl_icon left pointer"></div>';
          //echo '<div class="hl_exp">Hello</div>';
        
          //echo '<div id="palenquin_stars"></div>'; 
          //echo '<div class="hl_icon left pointer"></div>';
          /*
          echo '<input type="hidden" class="pass_house_id" value="' . $h .'" />';
          echo '<input type="hidden" name="sign_id" value="' . $sign_id_arr[$h] . '" />';
          echo '<input type="hidden" name="ruler_of_sign" value="' . $ruler_of_sign_arr[$h] . '" />';
          echo '<input type="hidden" name="sign_of_res" value="' . $sign_of_res_arr[$h] . '" />';
          echo '<input type="hidden" name="house_of_res" value="' . $house_of_res_arr[$h] . '" />'

          //echo '</div>'; //close wrapper
          //echo '</li>';


    //LEFT SIDE-----------------------
      echo '<div class="hl_tabs left_side"/>';
      echo '<ul>';
      for ($h=1; $h < 7; $h++) {
      //for ($h=1; $h < 13; $h++)  {
          //$button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
          echo '<li class="hl_li ' . $h . ' ';
            if ($h == 1) {
              echo 'selected';
            }
          echo '">';
          echo '<div class="hl_tabs_wrapper">';

          echo '<div class="hl_icon left pointer">';
            //echo '<span class="hl_title">' . $h . '<br>' . $sign_name_arr[$h] . '</span>';
          echo '</div>';
          echo '<span class="arrow"></span>';
          echo '<input type="hidden" class="pass_house_id" value="' . $h .'" />';
          echo '<input type="hidden" name="sign_id" value="' . $sign_id_arr[$h] . '" />';
          echo '<input type="hidden" name="ruler_of_sign" value="' . $ruler_of_sign_arr[$h] . '" />';
          echo '<input type="hidden" name="sign_of_res" value="' . $sign_of_res_arr[$h] . '" />';
          echo '<input type="hidden" name="house_of_res" value="' . $house_of_res_arr[$h] . '" />';
          echo '</div>'; //close wrapper
          echo '</li>';
      }
      echo '</ul>';
      echo '</div>'; //Close LEFT SIDE

    //RIGHT SIDE-----------------------
      echo '<div class="hl_tabs right_side"/>';
      echo '<ul>';
      for ($h=7; $h < 13; $h++) {
      //for ($h=1; $h < 13; $h++)  {  
          //$button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
          echo '<li class="hl_li ' . $h . '">';
          echo '<div class="hl_tabs_wrapper">';

          echo '<div class="hl_icon right pointer">';
          //echo '<span class="hl_title">' . $h . '<br>' . $sign_name_arr[$h] . '</span>';
          echo '</div>';
          echo '<span class="arrow"></span>';
          echo '<input type="hidden" class="pass_house_id" value="' . $h .'" />';
          echo '<input type="hidden" name="sign_id" value="' . $sign_id_arr[$h] . '" />';
          echo '<input type="hidden" name="ruler_of_sign" value="' . $ruler_of_sign_arr[$h] . '" />';
          echo '<input type="hidden" name="sign_of_res" value="' . $sign_of_res_arr[$h] . '" />';
          echo '<input type="hidden" name="house_of_res" value="' . $house_of_res_arr[$h] . '" />';
          echo '</div>'; //close wrapper
          echo '</li>';
      }
      echo '</ul>';
      echo '</div>';
  
      echo '<div id="blurb">';
        echo '<span id="rising_sign_id_err></span>';
        echo '<span id="house_id_err"></span>';
        echo '<span id="house_of_res_err"></span>';
          if ($h == 0) {
            show_hl_intro_text(1);
          }
          else {
            //H1 - PALENQUIN - H2 PIC GOES HERE
            //BLURB GOES HERE
            //echo get_house_ruler_blurb($rising_sign_id, 1, $house_of_res_arr[1]);
            //echo '<div width="350px"><div id="palenquin_stars"></div></div>';
          }
      echo '</div>';//close blurb


*/

      /*
    //LEFT SIDE-----------------------
      echo '<div class="hl_tabs left_side"/>';
      echo '<ul>';
      for ($h=1; $h < 7; $h++) {
        
          //$button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
          echo '<li class="hl_li ' . $h . ' ';
            if ($h == 1) {
              echo 'selected';
            }
          echo '">';
          echo '<div class="hl_tabs_wrapper">';

          echo '<span class="hl_icon left pointer"><span class="hl_title">' . $h . '<br>Unknown</span></span>';
          echo '<span class="arrow"></span>';
          echo '<input type="hidden" class="pass_house_id" value="' . $h .'" />';
          echo '<input type="hidden" name="sign_id" value="0" />';
          echo '<input type="hidden" name="ruler_of_sign" value="0" />';
          echo '<input type="hidden" name="sign_of_res" value="0" />';
          echo '<input type="hidden" name="house_of_res" value="0" />';
          echo '</div>'; //close wrapper
          echo '</li>';
      }
      echo '</ul>';
      echo '</div>'; //Close LEFT SIDE

    //RIGHT SIDE-----------------------
      echo '<div class="hl_tabs right_side"/>';
      echo '<ul>';
      for ($h=7; $h < 13; $h++) {
        
          //$button_sign_id = get_sign_from_poi ($chart_id, $poi["poi_id"]);
          echo '<li class="hl_li ' . $h . '">';
          echo '<div class="hl_tabs_wrapper">';

          echo '<span class="hl_icon right pointer"><span class="hl_title">' . $h . '<br>Unknown</span></span>';
          echo '<span class="arrow"></span>';
          echo '<input type="hidden" class="pass_house_id" value="' . $h .'" />';
          echo '<input type="hidden" name="sign_id" value="0" />';
          echo '<input type="hidden" name="ruler_of_sign" value="0" />';
          echo '<input type="hidden" name="sign_of_res" value="0" />';
          echo '<input type="hidden" name="house_of_res" value="0" />';
          echo '</div>'; //close wrapper
          echo '</li>';
      }
      echo '</ul>';
      echo '</div>';

      echo '<div id="blurb">';
        echo '<span id="rising_sign_id_err></span>';
        echo '<span id="house_id_err"></span>';
        echo '<span id="house_of_res_err"></span>';
          if ($rising_sign_id == -1) {
            if ($chart_id !== get_my_chart_id()) {  
              show_hl_intro_text(2);
            }
            else show_hl_intro_text(1);
          }
          else {
            //H1 - PALENQUIN - H2 PIC GOES HERE
            //BLURB GOES HERE
            //echo get_house_ruler_blurb($rising_sign_id, 1, $house_of_res_arr[1]);
            //show_poi_info($poi_id, $chart_id, $sign_id);
            //show_poi_sign_blurb ($poi_id, $sign_id);
          }
      echo '</div>';//close blurb
    */
//END OLD WAY------------------------------------^



//END HOLD HOUSE WAY

//////////////////ENDMATT

function chart_entry_form($chart_id) {
  $show_advanced_options = 0;
  if (isset($_POST["submit"])) {
   $address = $_POST["address"];
   $t1h = $_POST["t1h"];
   $t1m = $_POST["t1m"];
   $t1s = $_POST["t1s"];
   if (trim($_POST["d1m"]) != "") {
    
    
    
    $c1d = $_POST["c1d"];
    $c1m = $_POST["c1m"];
    $c1s = $_POST["c1s"];
    $c2d = $_POST["c2d"];
    $c2m = $_POST["c2m"];
    $c2s = $_POST["c2s"];
    $LaDir = $_POST["LaDir"];
    $LoDir = $_POST["LoDir"];
    $daylight = $_POST["daylight"];
    $timezone = $_POST["timezone"];
    $address = $_POST["address"];
    $show_advanced_options = 1;
    
    if (trim($address) != '') {
      
      if ($coords = get_coordinates($address)) {
        
        //echo '<br>' . $coords['lat'] . '<br>';
        //echo $coords['lng'] . '<br>';
        $lat = reformat_coordinate($coords['lat'], 'lat');
        $lng = reformat_coordinate($coords['lng'], 'lng');
        $title = $coords['title'];
        //echo 'Location: ' . $title . '<br>';
        //echo 'Latitude: ' . $lat[1] . ' ' . $lat[0] . '<br>';
        //echo 'Longitude: ' . $lng[1] . ' ' . $lng[0] . '<br>';
  
        $latitude = $lat[1];
        $longitude = $lng[1];
        $c1d = get_sign_degrees ($latitude);
        $c1m = get_sign_minutes ($latitude);
        $c1s = get_sign_seconds ($latitude);
        $c2d = get_long_degrees ($longitude);
        $c2m = get_long_minutes ($longitude);
        $c2s = get_long_seconds ($longitude);
        $LoDir = $lng[0];
        $LaDir = $lat[0];
        $timezone_object = timezone($coords['lat'], $coords['lng']);
        $timezone = abs((float)$timezone_object["offset"]);
        //echo 'GMT Offset:  ' . $timezone["offset"] . '<br>';
        //echo 'Timezone:  ' . $timezone_object["tID"] . '<br>'; 
        $daylight = DST($timezone_id = $timezone_object["tID"], $date = $_POST["d1m"] . '/' . $_POST["d1d"] . '/' . $_POST["d1y"]);  
        //echo 'DST:' . $DST . '<br>';
        $show_advanced_options = 0;
      } 
     } 
    }
    $d1y = $_POST["d1y"];
    $d1m = $_POST["d1m"];
    $d1d = $_POST["d1d"];
    
    
  }
  elseif ($chart_info = get_chart($chart_id)) { 
    $birthday = (string) $chart_info["birthday"];
    $latitude = $chart_info["latitude"];
    $longitude = $chart_info["longitude"];
    $t1h = substr ($birthday, 11, 2);
    $t1m = substr ($birthday, 14, 2);
    $t1s = substr ($birthday, 17, 2);
    $c1d = get_sign_degrees ($latitude);
    $c1m = get_sign_minutes ($latitude);
    $c1s = get_sign_seconds ($latitude);
    $c2d = get_long_degrees ($longitude);
    $c2m = get_long_minutes ($longitude);
    $c2s = get_long_seconds ($longitude);
    $d1y = substr ($birthday, 0, 4);
    $d1m = substr ($birthday, 5, 2);
    $d1d = substr ($birthday, 8, 2);
    $daylight = $chart_info["DST"];
    $timezone = $chart_info["timezone"];
    $address = $chart_info["location"]; //you gotta store this and retrieve it here
    if (substr ($latitude, -1) == 'N') {
      $LaDir = 'North';
    }
    else {
      $LaDir = 'South'; 
    }
    if (substr ($longitude, -1) == 'E') {
      $LoDir = 'East';
    }
    else {
      $LoDir = 'West';
    }
    $show_advanced_options = 1;
    
  }
  else {
    $t1h = "";
    $t1m = "";
    $t1s = "";
    $c1d = "";
    $c1m = "";
    $c1s = "";
    $c2d = "";
    $c2m = "";
    $c2s = "";
    $d1y = "";
    $d1m = "";
    $d1d = "";
    $daylight = "";
    $timezone = "";
    $LaDir = "";
    $LoDir = "";
    $address = "";
  }
  echo '<form name="formx" action="./index.php" method="post">
           <table>
           <tr>
             <td>Born (24-hour clock):</td>
             <td>
               <input type="text" size="1" name="t1h" value="' . $t1h . '"/>h&nbsp;
               <input type="text" size="1" name="t1m" value="' . $t1m . '"/>m&nbsp;
               <input type="text" size="1" name="t1s" value="' . $t1s . '"/>s
             </td>
           </tr>
           <tr>
             <td>Birth City:</td>
             <td><input type="text" name="address" value="' . $address . '"></td>
            </tr>';
           if ($show_advanced_options == 1) {
  echo '    <tr>
             <td><span style="color:red">*</span><input type="radio" name="daylight" value="0"';
             if ($daylight == "0") {
               echo ' checked';
             }
             echo '>Standard Time</td>
             <td><input type="radio" name="daylight" value="1"';
             if ($daylight == "1") {
               echo ' checked';
             }
             echo '>Daylight Savings Time</td>
            </tr>
            <tr>
             <td><span style="color:red">*</span>Time Zone: </td><td><input type="text" size=1 name="timezone" value="' . $timezone . '"></td>
            </tr>
            <tr>
             <td><span style="color:red">*</span>Latitude: </td>
             <td>
               <input type="text" size="1" name="c1d" value="' . $c1d . '"/>' . chr(176) .
              '<input type="text" size="1" name="c1m" value="' . $c1m . '"/>\'
               <input type="text" size="1" name="c1s" value="' . $c1s . '"/>"
               <input type="radio" name="LaDir" value="North"';
               if ($LaDir == "North") {
                 echo ' checked';
               }
               echo '/>North
               <input type="radio" name="LaDir" value="South"';
               if ($LaDir == "South") {
                 echo ' checked';
               }
               echo '/>South
             </td>
            </tr>
            <tr>
             <td><span style="color:red">*</span>Longitude: </td>
             <td>
               <input type="text" size="1" name="c2d" value="' . $c2d . '"/>' . chr(176) .
              '<input type="text" size="1" name="c2m" value="' . $c2m . '"/>\'
               <input type="text" size="1" name="c2s" value="' . $c2s . '"/>"
               <input type="radio" name="LoDir" value="East"';
               if ($LoDir == "East") {
                 echo ' checked';
               }
               echo '/>East
               <input type="radio" name="LoDir" value="West"';
               if ($LoDir == "West") {
                 echo ' checked';
               }
               echo '/>West
             </td>
            </tr>';
           }
           else {
echo '      <tr>
             <td>
                <input type="hidden" name="daylight" value="' . $daylight . '">
                <input type="hidden" name="timezone" value="' . $timezone . '">
            
            
                <input type="hidden" name="c1d" value="' . $c1d . '"/>
                <input type="hidden" name="c1m" value="' . $c1m . '"/>
                <input type="hidden" name="c1s" value="' . $c1s . '"/>
                <input type="hidden" name="LaDir" value="' . $LaDir . '"/>
                
                <input type="hidden" size="1" name="c2d" value="' . $c2d . '"/>
                <input type="hidden" size="1" name="c2m" value="' . $c2m . '"/>
                <input type="hidden" size="1" name="c2s" value="' . $c2s . '"/>
                <input type="hidden" name="LoDir" value="' . $LoDir . '"
             </td>
            </tr>';
           }
echo '     <tr>
             <td>Date: </td>
             <td>
               <input type="text" size="1" name="d1m" value="' . $d1m . '"/>/
               <input type="text" size="1" name="d1d" value="' . $d1d . '"/>/
               <input type="text" size="1" name="d1y" value="' . $d1y . '"/>
             </td>
           </tr>

           <tr>
             <td colspan=2>
               <input type="submit" name="submit" value="DO EET"/>
               
             </td>
           </tr>
           </table>
        </form>';
  
  return $show_advanced_options;
}

function cast_chart () {
  if (isset($_GET["chart_id"])) {
    $chart_id = $_GET["chart_id"];
  }
  else {
    $chart_id = -1;
  }
  if (isset($_POST["submit"])) {
    $t1h = $_POST["t1h"];
    $t1m = $_POST["t1m"];
    $t1s = $_POST["t1s"];
    //$t2h = $_POST["t2h"];
    //$t2m = $_POST["t2m"];
    //$t2s = $_POST["t2s"];
    //$t3h = $_POST["t3h"];
    //$t3m = $_POST["t3m"];
    //$t3s = $_POST["t3s"];
    //$t4h = $_POST["t4h"];
    //$t4m = $_POST["t4m"];
    //$t4s = $_POST["t4s"];
    if (trim($_POST['address']) == '') {
      $c1d = $_POST["c1d"];
      $c1m = $_POST["c1m"];
      $c1s = $_POST["c1s"];
      $c2d = $_POST["c2d"];
      $c2m = $_POST["c2m"];
      $c2s = $_POST["c2s"];
      $LaDir = $_POST["LaDir"];
      $LoDir = $_POST["LoDir"];
    }
    else {
      $found = true;
      if (!($coords = geocode ($_POST["address"],$type='postalCodeSearch?placename'))) {
        if (!($coords = geocode ($_POST["address"], $type='wikipediaSearch?q'))) {
          $found = false;
        }
        else {
          echo 'Using Wikipedia lookup... ' . '<br>';
        }
      }
      else {
        echo 'Using postal code lookup... ' . '<br>';
      }
      if ($found) {
        
        $lat = reformat_coordinate($coords['lat'], 'lat');
        $lng = reformat_coordinate($coords['lng'], 'lng');
        $latitude = $lat[1];
        $longitude = $lng[1];
        $c1d = get_sign_degrees ($latitude);
        $c1m = get_sign_minutes ($latitude);
        $c1s = get_sign_seconds ($latitude);
        $c2d = get_long_degrees ($longitude);
        $c2m = get_long_minutes ($longitude);
        $c2s = get_long_seconds ($longitude);
        $LoDir = $lng[0];
        $LaDir = $lat[0];
      }
      else { // this implementation is redundant (See same code within the parent "IF statement), BUT it saves on Geoname requests by not having to query the server for blank requests
        $d1y = $_POST["d1y"];
        $d1m = $_POST["d1m"];
        $d1d = $_POST["d1d"];
        $daylight = $_POST["daylight"];
        $timezone = $_POST["timezone"]; 
      }
    }
    $d1y = $_POST["d1y"];
    $d1m = $_POST["d1m"];
    $d1d = $_POST["d1d"];
    $daylight = $_POST["daylight"];
    $timezone = $_POST["timezone"];
    
  }
  elseif ($chart_info = get_chart($chart_id)) { 
    $birthday = (string) $chart_info["birthday"];
    $latitude = $chart_info["latitude"];
    $longitude = $chart_info["longitude"];
    $t1h = substr ($birthday, 11, 2);
    $t1m = substr ($birthday, 14, 2);
    $t1s = substr ($birthday, 17, 2);
    $c1d = get_sign_degrees ($latitude);
    $c1m = get_sign_minutes ($latitude);
    $c1s = get_sign_seconds ($latitude);
    $c2d = get_long_degrees ($longitude);
    $c2m = get_long_minutes ($longitude);
    $c2s = get_long_seconds ($longitude);
    $d1y = substr ($birthday, 0, 4);
    $d1m = substr ($birthday, 5, 2);
    $d1d = substr ($birthday, 8, 2);
    $daylight = $chart_info["DST"];
    $timezone = $chart_info["timezone"];
    if (substr ($latitude, -1) == 'N') {
      $LaDir = 'North';
    }
    else {
      $LaDir = 'South'; 
    }
    if (substr ($longitude, -1) == 'E') {
      $LoDir = 'East';
    }
    else {
      $LoDir = 'West';
    }
    
    
  }
  else {
    $t1h = "";
    $t1m = "";
    $t1s = "";
    $t2h = "";
    $t2m = "";
    $t2s = "";
    $t3h = "";
    $t3m = "";
    $t3s = "";
    $t4h = "";
    $t4m = "";
    $t4s = "";
    $c1d = "";
    $c1m = "";
    $c1s = "";
    $c2d = "";
    $c2m = "";
    $c2s = "";
    $d1y = "";
    $d1m = "";
    $d1d = "";
    $daylight = "0";
    $timezone = "8";
    $LaDir = "North";
    $LoDir = "West";
  }
  echo '<form name="formx" action="./index.php" method="post">
           <table>
           <tr>
             <td>Born (24-hour clock):</td>
             <td>
               <input type="text" size="1" name="t1h" value="' . $t1h . '"/>h&nbsp;
               <input type="text" size="1" name="t1m" value="' . $t1m . '"/>m&nbsp;
               <input type="text" size="1" name="t1s" value="' . $t1s . '"/>s
             </td>
           </tr>
           <tr>
             <td><input type="radio" name="daylight" value="0"';
             if ($daylight == "0") {
               echo ' checked';
             }
             echo '>Standard Time</td>
             <td><input type="radio" name="daylight" value="1"';
             if ($daylight == "1") {
               echo ' checked';
             }
             echo '>Daylight Savings Time</td>
           </tr>
           <tr>
             <td>Time Zone: </td><td><input type="text" size=1 name="timezone" value="' . $timezone . '"></td>
           </tr>

           <tr>
             <td>Birth City:</td>
             <td><input type="text" name="address"></td>
           </tr>

           <tr>
             <td>Latitude: </td>
             <td>
               <input type="text" size="1" name="c1d" value="' . $c1d . '"/>' . chr(176) .
              '<input type="text" size="1" name="c1m" value="' . $c1m . '"/>\'
               <input type="text" size="1" name="c1s" value="' . $c1s . '"/>"
               <input type="radio" name="LaDir" checked value="North"';
               if ($LaDir == "North") {
                 echo ' checked';
               }
               echo '/>North
               <input type="radio" name="LaDir" value="South"';
               if ($LaDir == "South") {
                 echo ' checked';
               }
               echo '/>South
             </td>
           </tr>
           <tr>
             <td>Longitude: </td>
             <td>
               <input type="text" size="1" name="c2d" value="' . $c2d . '"/>' . chr(176) .
              '<input type="text" size="1" name="c2m" value="' . $c2m . '"/>\'
               <input type="text" size="1" name="c2s" value="' . $c2s . '"/>"
               <input type="radio" name="LoDir" value="East"';
               if ($LoDir == "East") {
                 echo ' checked';
               }
               echo '/>East
               <input type="radio" name="LoDir" value="West"';
               if ($LoDir == "West") {
                 echo ' checked';
               }
               echo '/>West
             </td>
           </tr>
           <tr>
             <td>Date: </td>
             <td>
               <input type="text" size="1" name="d1m" value="' . $d1m . '"/>/
               <input type="text" size="1" name="d1d" value="' . $d1d . '"/>/
               <input type="text" size="1" name="d1y" value="' . $d1y . '"/>
             </td>
           </tr>

           <tr>
             <td colspan=2>
               <input type="submit" name="submit" value="DO EET"/>
               
             </td>
           </tr>
           </table>
        </form>';
}

function format_image ($picture, $type, $user_id=-2) {
  if ($user_id == -2) {
    $user_id = get_my_user_id();
  }
  if (trim($picture) == "" or $picture == false) {
    if ($type == 'profile') { 
      if (is_male($user_id)) {
        return '<img src="/img/Starma-Astrology-Large-Default-Pic-Male.png"/>';   
      }
      else {
        return '<img src="/img/Starma-Astrology-Large-Default-Pic-Female.png"/>';  
      }
    }
    elseif ($type == "thumbnail") 
      if ($user_id == -1) {
        return '<img src="/img/Starma-Astrology-Small-Default-Pic-Male.png"/>';
      }
      else {
        if (is_male($user_id)) {
          return '<img src="/img/Starma-Astrology-Small-Default-Pic-Male.png"/>';   
        }
        else {
          return '<img src="/img/Starma-Astrology-Small-Default-Pic-Female.png"/>';
        }
      }
    else {
      if ($user_id == -1) {
        if (isset($_SESSION['alternate_chart_gender'])) {
          $alt_gender = $_SESSION['alternate_chart_gender'];
          if($alt_gender == "M") {
            $gender = "Male";
          }
          else {
            $gender = "Female";
          }
        }
        else {
          $gender = "Male";
        }
        return '<img src="/img/Starma-Astrology-Compatibility-' . $gender . '-Pic.png"/>';
      }
      else {
        if (is_male($user_id)) {
          return '<img src="/img/Starma-Astrology-Compatibility-Male-Pic.png"/>';   
        }
        else {
          return '<img src="/img/Starma-Astrology-Compatibility-Female-Pic.png"/>';
        }
      }
    }
  }
  else {
    if ($type == 'profile')
      return '<img src="/img/user/' . $picture . '"/>';
    elseif ($type == "thumbnail")
      return '<img src="/img/user/thumbnail/thumb_' . $picture . '"/>';
    else
      return '<img src="/img/user/compare/compare_' . $picture . '"/>';
  }
}

function show_user_compare_picture ($url, $user_id) {
  if ($user_id == get_my_user_id()) {
    $url = '?the_page=psel&the_left=nav1';
  }
  echo '<div class="user_button"><a href="' . $url . '">' . format_image($picture=get_main_photo($user_id), $type="compare", $user_id) . '</a></div>';
}

function user_compare_picture_for_scroll ($url, $user_id) {
  return '<div class="user_button"><a href="' . $url . '">' . format_image($picture=get_main_photo($user_id), $type="compare", $user_id) . '</a></div>';
}

function show_user_inbox_picture ($url, $user_id) {
  if ($url == '') {
    echo '<div class="user_inbox_button"><a>' . format_image($picture=get_main_photo($user_id), $type="thumbnail", $user_id) . '</a></div>'; 
  }
  else {
    echo '<div class="user_inbox_button"><a href="' . $url . '">' . format_image($picture=get_main_photo($user_id), $type="thumbnail", $user_id) . '</a></div>';
  }
}

function display_all_users ($url="", $filter=0) {
    
  if ($filter == 0) {
    $user_list = get_user_list ();
    
  }
  elseif ($filter == 1) {
    $user_list = get_favorties_user_list ();
    
  }
  else {
    $user_list = get_celebrity_user_list ();
  }
  //$length = sizeof($user_list);
  $user_array = query_to_array($user_list);
  //$user_array = add_scores ($user_list);
  //$user_array = quicksort_users($user_array);
  
  //while ($user = mysql_fetch_array($user_list)) {

  if (isLoggedIn()) {
    $chart_id = get_my_chart_id();
  }
  else {
    $chart_id = get_guest_chart_id(get_guest_user_id());
  }

  if (count($user_array) > 0) {

    foreach ($user_array as $user) {
 
      echo '<div class="user_block js_user_' . $user["user_id"] . '">';
        echo '<div class="photo_border_wrapper_compare">';
          echo '<div class="compare_photo">';
            show_user_compare_picture($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
            //echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';
         
          echo '</div>';
        echo '</div>'; 
        show_general_info($user["chart_id"]);
        //echo '<div class="user_info">' . $user["nickname"] . '</div>';      
        //echo '*' . $user["score"] . '*';
      echo '</div>';        
    }
  }
  else {
    echo '<div>You have no favorites yet!  Add members of Starma or celebrities to your Favorites by clicking the "add to favorites button" on their profiles.</div>';
  }
  
}

function display_welcome_page_thumbnails($celebs=0, $generic=0) {
  $chart_id1 = get_my_chart_id();
  if ($generic == 0) {
    $my_info = my_profile_info();

    if ($celebs == 0) {
      $age = calculate_age(substr((string)$my_info['birthday'], 0, 10));
      $user_list = get_weighted_user_list ($age-5, $age+5); 
    }
    else {
      $user_list = get_pic_only_celebrity_user_list ();
    }
  }
  else {
    if ($celebs == 0) {
      
      $user_list = get_user_list_pics_only (); 
    }
    else {
      $user_list = get_pic_only_celebrity_user_list ();
    }
  }
  $old_user_array = query_to_array($user_list);
  $user_array = array();
  //pick 8 random ones
  while (sizeof($user_array) < 8 and sizeof($old_user_array) > 0) {
    $random_index = array_rand($old_user_array);
    $new_item_array = array_splice($old_user_array, $random_index, 1);    
    $user_array[] = $new_item_array[0];
  }

  if ($celebs == 0) {

    foreach ($user_array as $user) {
      echo '<div class="grid_photo_wrapper">';  
        echo '<div class="grid_photo_border_wrapper"><div class="grid_photo">';
            
          show_user_inbox_picture ('?the_page=cosel&the_left=nav1&tier=3&stage=2&chart_id1=' . $chart_id1 . '&chart_id2=' . $user['chart_id'], $user['user_id']);
         
        echo '</div></div>';
      echo '</div>'; 
    }
  }
  else {
    foreach ($user_array as $user) {
      echo '<div class="grid_photo_wrapper">';  
        echo '<div class="grid_photo_border_wrapper"><div class="grid_photo">';
            
          show_user_inbox_picture ('?the_page=cesel&the_left=nav1&tier=3&stage=2&chart_id1=' . $chart_id1 . '&chart_id2=' . $user['chart_id'], $user['user_id']);
         
        echo '</div></div>';
      echo '</div>'; 
    }
  }
}

function display_thumbnails_sign_up($celebs, $generic) {
  if ($celebs == 0) {   
      $user_list = get_user_list_pics_only (); 
  }
  else {
    $user_list = get_pic_only_celebrity_user_list ();
  }
  $old_user_array = query_to_array($user_list);
  $user_array = array();
  //pick 8 random ones
  while (sizeof($user_array) < 8 and sizeof($old_user_array) > 0) {
    $random_index = array_rand($old_user_array);
    $new_item_array = array_splice($old_user_array, $random_index, 1);    
    $user_array[] = $new_item_array[0];
  }
  foreach ($user_array as $user) {
      echo '<div class="grid_photo_wrapper">';  
        echo '<div class="grid_photo_border_wrapper"><div class="grid_photo">';
            
          show_user_inbox_picture ('#', $user['user_id']);
         
        echo '</div></div>';
      echo '</div>'; 
    }

}


//SEARCH RESULTS-----------------------------------


function show_search_results($user_array, $users_per_page, $chart_id, $gender, $low_bound, $high_bound) {

    $url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
    if (count($user_array) > 0) {
  
        

        //print_r($pages);      
        //$x=0;
        //foreach ($pages as $page) {   
          //echo '<div class="s_nav ' . $x . '">';              
            //if ($x == 0) {
                $upp = 0;
                foreach ($user_array as $user) {
                  
                  if ($upp < $users_per_page) {
                        echo '<div class="user_block js_user_' . $user["user_id"] . '">';
                          echo '<div class="photo_border_wrapper_compare">';
                              echo '<div class="compare_photo">';
                                show_user_compare_picture($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                                //echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';   
                                echo '</div>';
                            echo '</div>'; 
                          show_general_info($user["chart_id"]);
                          //echo '<div class="user_info">' . $user["nickname"] . '</div>';      
                          //echo '*' . $user["score"] . '*';
                        echo '</div>';       
                    }
                    else {
                      break;
                   }
                    $upp++; 
                    //echo 'upp: ' . $upp . '<br>';
                  }
                  
            //}
            //echo '</div>'; //close s_nav
              
            //$x++;
                //echo 'x= ' . $x . '<br>';
        //}
      }
      else {
        echo '<div class="later_on" style="font-size:1.5em;">We currently have no users matching your search.  Try widening your net...</div>';
      }
      unset($x);
      unset($upp); 


}



//END SEARCH RESULTS-----------------------------------


//SHOW NEW TO STARMA -----------------------------------


function show_profiles ($url="", $limit, $filter=0) {
  $begin = 0;
  $users_per_page = 24;

  if ($filter == 0) {
    $user_list = get_user_list ($begin, $limit);
    
  }
  elseif ($filter == 1) {
    $user_list = get_favorties_user_list ();
    
  }
  else {
    $user_list = get_celebrity_user_list ($begin, $limit);
  }
  //$length = sizeof($user_list);
  $user_array = query_to_array($user_list);
  //$user_array = add_scores ($user_list);
  //$user_array = quicksort_users($user_array);
  
  //while ($user = mysql_fetch_array($user_list)) {

  if (isLoggedIn()) {
    $chart_id = get_my_chart_id();
  }
  else {
    $chart_id = get_guest_chart_id(get_guest_user_id());
  }


    //$url = '?the_page=cosel&the_left=nav1&tier=3&stage=2';
    if (count($user_array) > 0) {
  
                $upp = 0;
                foreach ($user_array as $user) {
                  
                  if ($upp < $users_per_page) {
                        echo '<div class="user_block js_user_' . $user["user_id"] . '">';
                          echo '<div class="photo_border_wrapper_compare">';
                              echo '<div class="compare_photo">';
                                show_user_compare_picture($url . '&chart_id1=' . $chart_id . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
                                //echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';   
                                echo '</div>';
                            echo '</div>'; 
                          show_general_info($user["chart_id"], 'nts');
                          //echo '<div class="user_info">' . $user["nickname"] . '</div>';      
                          //echo '*' . $user["score"] . '*';
                        echo '</div>';       
                    }
                    else {
                      break;
                   }
                    $upp++; 
                    //echo 'upp: ' . $upp . '<br>';
                  }

      }
      else {
        echo '<div class="later_on" style="font-size:1.5em;">Sorry! There was an error, please refresh the page.</div>';
      }
      unset($x);
      unset($upp); 

      if (count($user_array) > 24) {
        echo '<input type="hidden" id="next_page" value="2" />';
        echo '<input type="hidden" id="load_next" value="true" />';
      }

}


//END NEW TO STARMA -----------------------------------

/********************** ALL USERS TEST **********************************/
function display_all_users_test ($url="", $filter=0) {
    
  if ($filter == 0) {
    $user_list = get_user_list ();
    
  }
  elseif ($filter == 1) {
    $user_list = get_favorties_user_list ();
    
  }
  else {
    $user_list = get_celebrity_user_list ();
  }
  //$length = sizeof($user_list);
  //$user_array = query_to_array($query);
  $user_array = add_scores ($user_list);
  $user_array = quicksort_users($user_array);
  
  //while ($user = mysql_fetch_array($user_list)) {
  foreach ($user_array as $user) {
 
      echo '<div class="user_block js_user_' . $user["user_id"] . '">';
        echo '<div class="photo_border_wrapper_compare">';
          echo '<div class="compare_photo">';
            show_user_compare_picture($url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"], $user["user_id"]);
            //echo '<div class="user_button"><a href="' . $url . '&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $user["chart_id"] . '">' . format_image($picture=get_main_photo($user["user_id"]), $type="compare",$user["user_id"]) . '</a></div>';
         
          echo '</div>';
        echo '</div>'; 
        show_general_info($user["chart_id"]);
        //echo '<div class="user_info">' . $user["nickname"] . '</div>';      
        echo '*' . $user["score"] . '*';
      echo '</div>';        
  }
  
}
/********************** ALL USERS TEST END*******************************/

function display_my_chart_list () {
  echo '<div style="float:right">';
  echo '<form name="delete_form" action="" method="post">';
  echo '<input type="hidden" name="chart_id" value=""/>';
  $chart_list = get_chart_list ();
  echo '<table width="200px">';
  echo '<tr><td>My Charts</td></tr>';
  while ($chart = mysql_fetch_array($chart_list)) {
     $chartsUser = profile_info (get_any_user_id_from_chart_id ($chart["chart_id"]));
     echo '<tr>';
     echo '<td><a href="?chart_id=' . $chart["chart_id"] . '">' . $chartsUser["nickname"] . ' - ' . $chart["nickname"] . '</a></td>';
     echo '<td><input type="button" value="DELETE" name="DELETE" onclick="' . javascript_submit ($form_name="delete_form", $action="./delete_chart.php", $hidden="chart_id", $value=$chart["chart_id"]) . '"/></td>';
     echo '<tr>';
  }
  echo '</table>';
  echo '<br><br>';
  echo '<b><a style="font-size:1.5em" href="compare_chart.php">Compare Charts to Each Other</a></b>';
  echo '</form>';
  echo '</div>';
}



function combine_pieces ($p1, $p2, $p3) {
  return format_piece($p1) . format_piece($p2) . format_piece($p3);
}

function combine_long_pieces ($p1, $p2, $p3) {
  return format_piece_long_degrees($p1) . format_piece($p2) . format_piece($p3);
}

function show_userbox()
{
    // retrieve the session information
    $u = $_SESSION['username'];
    $uid = $_SESSION['loginid'];
    // display the user box
    echo "<div id='userbox'>
			Welcome $u
			<ul>
				<li><a href='./changepassword.php'>Change Password</a></li>
				<li><a href='./logout.php'>Logout</a></li>
			</ul>
		 </div>";
}
 
function show_changepassword_form(){
  echo '<div id="change_password_form">';

  if (is_pass_there()) {  //HAS ACCOUNT WITH PASSWORD
    echo '<div class="heading">Change Password</div>';

    //CHANGED ALL ID's TO js_search_bar MAKE SURE THIS ISN'T A PROBLEM

    echo '<br>';  
    //if ($_GET["error"] == 1) {
    echo '<div class="later_on" style="font-size:1.4em; margin-bottom:10px;">Your new password must be between 6 and 15 characters and include only letters and numbers</div>';
    echo '<div id="pass_validation"></div>';
    //echo '<br><br>';
    //global $seed;
    //echo mysql_real_escape_string(sha1('1crowon1toad'.$seed)) . '<br>';
    //echo '*'.$seed.'*';
    //}
    echo '<form action="." method="POST">  
            <table id="reset_pass">
              <tbody>
                <tr>
                  <td><label class="later_on" for="oldpassword">Current Password:</label></td> 
                </tr>
                <tr>    
                  <td><input name="oldpassword" type="password" class="input_style" id="js_search_bar" maxlength="15" class="settings_pass"></td>
                </tr>

                <tr>
                  <td><label class="later_on" for="password">New Password:</label> </td>
                </tr>
                <tr>
                  <td><input name="password" type="password" class="input_style" id="js_search_bar" maxlength="15" class="settings_pass"> </td>
                </tr>

                <tr>
                  <td><label class="later_on" for="password2">Re-type new password:</label> </td>
                </tr>
                <tr>
                  <td><input name="password2" type="password" class="input_style" id="js_search_bar" maxlength="15" class="settings_pass"> </td>
                  <td><span class="pass_correct">Correct!</span>
                </tr>
                <tr> 
                  <td><input name="change_pass" id="change_pass" type="button" value="Reset Password"><span id="ajax_loader"></span> </td>
                </tr> 
              </tbody>
            </table>
          </form>';
  }         
  else {  //ONLY HAS FB ACCOUNT AND NO PASS YET
    echo '<div class="heading">Create Password</div>';

    //CHANGED ALL ID's TO js_search_bar MAKE SURE THIS ISN'T A PROBLEM

    echo '<br>';  
    echo '<div id="create_pass_first" class="later_on"></div>';
    //if ($_GET["error"] == 1) {
    echo '<div class="later_on" style="font-size:1.4em; margin-bottom:10px;">Your new password must be between 6 and 15 characters and include only letters and numbers</div>';
    echo '<div id="pass_validation"></div>';
    //echo '<br><br>';
    //global $seed;
    //echo mysql_real_escape_string(sha1('1crowon1toad'.$seed)) . '<br>';
    //echo '*'.$seed.'*';
    //}
    echo '<form action="." method="POST">  
            <table id="reset_pass">
              <tbody>
                <tr>
                  <td><label class="later_on" for="password">New Password:</label> </td>
                </tr>
                <tr>
                  <td><input name="password" type="password" class="input_style" id="js_search_bar" maxlength="15" class="settings_pass"> </td>
                </tr>

                <tr>
                  <td><label class="later_on" for="password2">Re-type new password:</label> </td>
                </tr>
                <tr>
                  <td><input name="password2" type="password" class="input_style" id="js_search_bar" maxlength="15" class="settings_pass"> </td>
                  <td><span class="pass_correct">Correct!</span>
                </tr>
                <tr> 
                  <td><input name="create_pass" id="create_pass" type="button" value="Create Password"><span id="ajax_loader"></span> </td>
                </tr> 
              </tbody>
            </table>
          </form>';
  }
  

  echo '</div>';
}


function show_privacy_form () {

  echo '<div id="privacy_form">';
  echo '<div class="heading">Privacy Settings</div>';
   //echo '<form name="privacy_form" method="POST" action="privacy_settings.php">';
      echo '<div style="margin-bottom:10px; line-height: 1.5;">';
        echo '<input type="checkbox"';
          if (get_my_preferences('email_search_private', 0) == 1) {
            echo ' checked';
          }
        echo ' name="chart" id="escb" style="display:inline; margin-right:8px;"/>';
        echo '<div class="later_on" id="email_search_text" style="display:inline;">Don\'t let other users search for me by entering my email<span id="es_done" class="later_on" style="display:none; padding-left:10px;"></span>';
        echo '</div>';
      echo '</div>';

      echo '<div style="margin-bottom:10px; line-height: 1.5;">';
        echo '<input type="checkbox"';
          if (get_my_preferences('chat_emails_flag', 1) == 1) {
            echo ' checked';
          }
        echo ' name="chart" id="cecb" style="display:inline; margin-right:8px;"/>';
        echo '<div class="later_on" id="chat_emails_text" style="display:inline;">Email me when I get messages from other Starma users<span id="ce_done" class="later_on" style="display:none; padding-left:10px;"></span>';
        echo '</div>';
      echo '</div>';

      echo '<div style="margin-bottom:20px; line-height: 1.5;">';
        echo '<input type="checkbox"';
          if (get_my_preferences('age_private', 1) == 1) {
            echo ' checked';
          }
        echo ' name="chart" id="agecb" style="display:inline; margin-right:8px;"/>';
        echo '<div class="later_on" id="age_private_text" style="display:inline;">Hide my age<span id="age_done" class="later_on" style="display:none; padding-left:10px;"></span>';
        echo '</div>';
      echo '</div>';

      echo '<div style="margin-bottom:10px;">';
        echo '<input type="checkbox"';
          if (get_my_preferences('chart_private', 0) == 1) {
            echo ' checked';
          }
        echo ' name="chart" id="chartcb" style="display:inline-block; margin-right:8px;"/>';
        echo '<div class="later_on" id="chart_text" style="display:inline-block;">Keep my whole Birth Chart private<span id="chart_done" class="later_on" style="display:none; padding-left:10px;"></span>';
        echo '</div>';
      echo '</div>';
      echo '<div style="margin-bottom:20px; margin-left:20px">';
        echo '<input type="checkbox"';
          if (get_my_preferences('hl_private', 0) == 1 || get_my_preferences('chart_private', 0) == 1) {
            echo ' checked';
          }
          if (get_my_preferences('chart_private', 0) == 1) {
            echo ' disabled';
          }
        echo ' name="house_lords" id="hlcb" style="display:inline-block; margin-right:8px;"/>';
        echo '<div class="later_on" id="hl_text" style="display:inline-block';
        if (get_my_preferences('chart_private', 0) == 1) {
          echo ';color:gray';
        }
        echo '">Keep my house lords private<span id="hl_done" class="later_on" style="display:none; padding-left:10px;"></span>';
        echo '</div>';
      echo '</div>';

      //echo $pref = get_my_preferences('fb_connected', 0);

      if (get_my_preferences('fb_connected', 0) == 1) {
        echo '<div style="display: inline-block; margin-right:20px;"><button type="button" id="pref_fb" class="s_button disconnect_fb" disabled="disabled">Disconnect from Facebook</button></div><span id="fb_done" class="later_on" style="display:none; padding-left:10px;"></span>';
      }
      if (get_my_preferences('fb_connected', 0) == 0) {
        echo '<div style="display: inline-block; margin-right:20px;"><button type="button" id="pref_fb" class="s_button connect_fb" disabled="disabled">Connect with Facebook</button></div><span id="fb_done" class="later_on" style="display:none; padding-left:10px;"></span>';
      }

      echo '<div id="change_username" style="width:200px;"><div class="s_button">Change Username</div></div>';
      /*
      echo '<div>';
        echo '<input type="checkbox" ';
          if (get_my_preferences('fb_connected', 0) == 1) {
            echo 'checked';
          }
        echo ' name="fb_connected" id="fbcb" style="display:inline-block; margin-right:8px;"/>';
        echo '<div class="later_on" style="display:inline-block;">Connect with my Facebook account<span id="fb_done" class="later_on" style="display:none; padding-left:10px;"></span>';
        echo '</div>';
      echo '</div>';
      */
   //echo '</form>';


  echo '</div>'; //close Privacy

}

function show_tutorials_form () {
  echo '<div id="tutorials_form">';
    echo '<div class="heading">Tutorials</div>';
      echo '<div style="margin-bottom:10px;"><input type="checkbox" ';
        if (my_chart_flag() == 1) {
          echo 'checked';
        }
      echo ' name="chart_flag" id="cfcb" style="display:inline-block; margin-right:8px;"/>';
      echo '<div class="later_on" style="display:inline-block;">Turn on Birth Chart Tutorial<span id="cf_done" class="later_on" style="display:none; padding-left:10px;"></span></div>';
      echo '</div>';

      echo '<div><input type="checkbox" ';
        if (my_compare_major_flag() == 1 && my_compare_minor_flag() == 1) {
          echo 'checked';
        }
      echo ' name="compare_flag" id="cofcb" style="display:inline-block; margin-right:8px;"/>';
      echo '<div class="later_on" style="display:inline-block;">Turn on Compatibility Tutorial<span id="cof_done" class="later_on" style="display:none; padding-left:10px;"></span></div>';
      echo '</div>';
  echo '</div>'; //close Tutorials
}


 
function show_loginform($disabled = false)
{

    echo '<form name="login-form" id="login-form" method="post" action="./login_page.php"> 
  <fieldset> 
  <legend>Please login</legend> 
  <dl> 
    <dt><label title="nickname">Username: </label></dt> 
    <dd><input tabindex="1" accesskey="u" name="nickname" type="text" maxlength="30" id="username" /></dd> 
  </dl> 
  <dl> 
    <dt><label title="Password">Password: </label></dt> 
    <dd><input tabindex="2" accesskey="p" name="password" type="password" maxlength="15" id="password" /></dd> 
  </dl> 
  <ul> 
    <!---<li><a href="./register.php" title="Register">Register</a></li> --->
    <li><a href="./lostpassword.php" title="Lost Password">Lost password?</a></li> 
  </ul> 
  <p><input tabindex="3" accesskey="l" type="submit" name="cmdlogin" value="Login" ';
    if ($disabled == true)
    {
        echo 'disabled="disabled"';
    }
    echo ' /></p></fieldset></form>';
    echo '<script type="text/javascript">

            $(document).ready(function(){
              $("#username").focus();
            });

          </script>';
 
 
}
 
function show_lostpassword_form(){
  echo '<div id="forgot_password_box">';
   echo '<form action="./lostpassword.php" method="post"> 
          <div>Reset Password</div>
            <input type="text" name="email" id="email" maxlength="55" placeholder="Your Email" />
            <input type="submit" value="Reset Password" name="lostpass" />
        </form>';
  echo '</div>';
 
}
 
function show_registration_form($output=array(-1)){
  echo '<div id="register">';
  show_landing_logo();
  echo '<div class="title">Create an Account</div>';
  echo '<div class="bg" id="create_account">';  
  //echo '<img src="img/account_info/Starma-Astrology-Create-Account-Boxes.png"/>';
  echo '<div id="register_form_old">';
  if(sizeof($output) > 1) {
    echo '<div class="register_error_area register_error">There was an error, please try again</div><br/>';
  }
    echo '<form name="register_form" action="./register.php" method="post"> 
    <table style="width:800px;"> 
      <tr>	
        <td style="width:106px" class="align_right">username</td> 
        <td><input class="input_style" name="nickname" type="text" maxlength="14" value="' . $_POST["nickname"] . '"></td>';
        echo '<td><span class="register_error_area_old" id="username_error"></span></td>';
        /*
          echo '<div class="error';
          if (!in_array(USERNAME_ERROR(), $output)) {echo ' hidden_error';}
          echo '" id="username_error">';
          echo 'Username empty or containers illegal characters';
          echo '</div>';
          echo '<div class="error';
          if (!in_array(USER_EXISTS_ERROR(), $output)) {echo ' hidden_error';}
          echo '" id="user_exists_error">';
          echo 'Nickname or Email already in use';
          echo '</div>';
        */
        echo '</tr>
      <tr>
        <td class="align_right">birthday</td> 
        <td>';
          date_select ($the_date=get_inputed_date ($type="default"), $the_name="birthday");
        echo '</td>';
        echo '<td><span class="register_error_area_old" id="underage_error"></span></td>';
        /*
          echo '<div class="error';
          if (!in_array(UNDERAGE_ERROR(), $output)) {echo ' hidden_error';}
          echo '" id="underage_error">';
          echo 'You must be at least 18 years old';
          echo '</div>';
        */
        echo '  
      </tr>
      <tr>
        <td class="align_right">email</td> 
        <td><input class="input_style" name="email" type="text" id="email" maxlength="30" value="' . $_POST["email"] . '"></td>';
        echo '<td><span class="register_error_area_old" id="email_error"></span></td>';
        /*
          echo '<div class="error';
          if (!in_array(EMAIL_ERROR(), $output)) {echo ' hidden_error';}
          echo '" id="email_error">';
          echo 'Invalid Email Address';
          echo '</div>';
        */
        echo '</tr>
      <tr>
        <td class="align_right"><div style="width:105px;">confirm email</div></td> 
        <td><input class="input_style" name="email2" type="text" id="email2" maxlength="30"></td>';
        echo '<td><span class="register_error_area_old" id="email2_error"></span></td>';
        /*
          echo '<div class="error';
          if (!in_array(EMAIL_NO_MATCH_ERROR(), $output)) {echo ' hidden_error';}
          echo '" id="email_no_match_error">';
          echo 'Email addresses do not match';
          echo '</div>';
        */
        echo '</tr>
      <tr>
        <td class="align_right">password</td> 
        <td><input class="input_style" name="password" type="password" id="password" maxlength="15"></td>';
        echo '<td><span class="register_error_area_old" id="password_error"></span></td>';
        /*
          echo '<div class="error';
          if (!in_array(PASSWORD_ERROR(), $output)) {echo ' hidden_error';}
          echo '" id="password_error">';
          echo 'Invalid or Empty Password';
          echo '</div>';
        */
        echo '</tr>
    
      <tr>
        <td style="vertical-align:top;" class="align_right"><input style="top:5px" type="checkbox" name="agreement" value="1"/></td>
        <td class="info_font" colspan="2"><div class="terms">I have read and agree to the <a href="docs/termsOfUse.htm" target="_blank">Terms of Use</a> and <a href="docs/privacyPolicy.htm" target="_blank">Privacy Policy</a> for Starma.com, and I certify that I am at least 18 years old.</div></td>
      </tr>
    </table>
    

    <div id="register_button_div"> 
      <div id="go_bug_path"></div><input id="bug_button" name="register" type="submit" value=""> 
    </div>
  </form></div>'; //close #register_form
/*
  echo '<div id="register_form_errors">';
    echo '<div class="register_error_area" id="username_error"></div>';
    echo '<div class="register_error_area" id="underage_error"></div>';
    echo '<div class="register_error_area" id="email_error"></div>';
    echo '<div class="register_error_area" id="email2_error"></div>';
    echo '<div class="register_error_area" id="password_error"></div>';
    echo '<div class="register_error_area" id="terms_error"></div>';
  echo '</div>'; //close #register_form_errors
*/
  //echo '<img class="token_img" src="img/account_info/Starma-Astrology-Token-Box.png"/>';
echo '</div>';  //close #create_account
show_bugaboos();
//echo '<div class="register_error_area" id="terms_error"></div>';
/*
echo '<div';
   if (!in_array(TERMS_ERROR(), $output)) {echo ' class="hidden_error"';}
   echo ' id="terms_error">';
   echo 'You must indicate that you agree to the above terms';
   echo '</div>';
  */
echo '</div>';
echo '<script type="text/javascript" src="js/ajax_register.js"></script>';
require_once ("landing_footer.php"); 
}

//********************************  LANDING BOXES  ********************************/


function show_sign_up_or_sign_in_box () {
  echo '<div id="sign_up_or_sign_in">';
    //echo  '<div class="heading">Welcome to Starma!</div>';
    echo '<div style="margin-top: 27px;">';
      echo '<div style="margin-bottom:12px;">';
        echo '<button type="button" id="sign_up_button" class="sign_up">Sign Up</button>';
      echo '</div>';
      //echo '<div id="or">~ or ~</div>';
      echo '<div style="margin-top: 23px; margin-bottom:12px;">';
        echo '<button type="button" id="sign_in_button" class="sign_up">Log In</button>';
      echo '</div>';

      echo '<button type="button" class="sign_up" onClick="window.location.assign(\'/guest/main.php\');">Explore Starma</button>';

    echo '</div>';
  echo '</div>';

}


function show_login_options_landing () {
  //echo '<div style="width:190px; margin:0 20px 10px 0;"><button type="button" class="login_options later_on" onClick="fbLogin();">Facebook Login</button></div>';
  //echo '<div style="width:100px; display: inline-block;"><button type="button" class="sign_up" id="login_email_landing">Log In</button></div>';
}

function show_login_box_landing () {
    echo '<div id="login_box">';
      //echo '<div class="heading">Log In</div>';
      echo '<div><img src="/img/logoLaterOnLCHP.png"/></div>';
        echo '<button type="button" id="fb_login" class="sign_up" onClick="fbLogin();">Facebook Login</button>';
        echo '<div id="or">~ or ~</div>';
        echo '<form action="/chat/login_form_fields.php" method="POST" id="login_from_guest">';
          echo '<input type="text" id="login_email" name="email" placeholder="Your Email" value="';
            if(isset($_GET['email'])) {
              echo $_GET['email'];
            }
          echo '"/>';
          //echo '<div class="register_error_area" id="login_email_error"></div>';
          echo '<input type="password" id="login_password" name="password" placeholder="Password" />';
          //echo '<input type="text" id="pass" name="password" placeholder="Password" />';
          //echo '<div class="register_error_area" id="login_password_error"></div>';
          echo '<div id="kmsi_fp">';  
            echo '<div id="forgot_password_landing">forgot your password?</div>';
            echo '<div id="stay_logged_in"><input type="checkbox" name="stay_logged_in" value="" /><div style="float:left; font-size: 1.1em;">keep me signed in</div></div>';
          echo '</div>';
          //echo '<button type="submit" id="go" class="later_on" name="Login">Go!</button>';
          echo '<button type="submit" id="go_bug_button" name="Login"></button>';
          //echo '<div class="sign_up_text">Go ></div>';
          //echo '<input type="submit" id="go_bug_button" name="Login" value=""/>';
          //echo '<button type="submit" name="login_submit" class="sign_up">Log In</button>';
        echo '</form>';
        //echo '<div id="cancel_login">Cancel</div>';

        echo '<div id="go_bug_path_landing"></div>';
        echo '<div class="later_on cursor" id="back_login">< Back</div>';

    echo '</div>';

  //ERRORS----------------------
    //echo '<div class="register_error_area" id="login_email_error"></div>';
    //echo '<div class="register_error_area" id="login_password_error"></div>';
}


function show_sign_up_box_landing () {
  
    echo '<div id="sign_up_box">';
      echo  '<div class="heading">Create an Account</div>';
        echo '<div style="margin-top: 27px;">';
          echo '<div style="margin-bottom: 12px;"><button type="button" name="sign_up_fb" class="sign_up" onClick="fbSignUp();">Facebook</button></div>';
          echo '<div id="or">~ or ~</div>';
          //echo '<button type="button" onClick="revokeFB();">revoke fb</button>'; 
          echo '<div style="margin-top: 23px;"><button type="button" name="sign_up_email" class="sign_up">Email</button></div>';
        echo '</div>';
      echo '</div>'; //Close sign_up_box
}


function show_registration_box_landing () {

  
echo '<div id="create_account">';  
  //echo '<div class="title">Create an Account</div>';
  //echo '<img src="img/account_info/Starma-Astrology-Create-Account-Boxes.png"/>';
  echo '<div id="register_form">';
    echo '<form name="register_form" action="../chat/register_user.php" method="post" id="register_form">';
      echo '<div class="register_error_area" id="reg_user_exists"></div>';
      echo '<div id="username"><input type="text" id="register_username" placeholder="Choose a Username" /><span class="reg_err check" id="reg_username_check"></span><span class="reg_err" id="reg_username_error"></span><div class="reg_err_exp" id="reg_err_username_exp"></div></div>'; 
      //echo '<div class="register_error_area" id="reg_username_error"></div>';
      echo '<div id="birthday">';
        echo '<div class="small_title">Date of Birth (this stays private):</div>';
        echo '<span>';
          date_select($the_date=get_inputed_date ($type="default"), $the_name="birthday");
        echo '</span>';
        echo '<span class="reg_err check" id="reg_birthday_check"></span><span class="reg_err" id="reg_birthday_error"></span><div class="reg_err_exp" id="reg_err_birthday_exp"></div>';
      echo '</div>';
      //echo '<div class="register_error_area" id="reg_birthday_error"></div>';
      echo '<div id="email"><input type="text" id="register_email" placeholder="Your Email" /><span class="reg_err check" id="reg_email_check"></span><span class="reg_err" id="reg_email_error"></span><div class="reg_err_exp" id="reg_err_email_exp"></div></div>';
      //echo '<div class="register_error_area" id="reg_email_error"></div>';
      //echo '<div id="email2"><input type="text" id="register_email2" placeholder="Confirm Email" /></div>';
      //echo '<div class="register_error_area" id="reg_email2_error"></div>';
      echo '<div id="password"><input type="password" id="register_password" placeholder="Password" /><span class="reg_err check" id="reg_password_check"></span><span class="reg_err" id="reg_password_error"></span><div class="reg_err_exp" id="reg_err_password_exp"></div></div>';
      //echo '<div class="register_error_area" id="reg_password_error"></div>';
      echo '<div id="terms">By using Starma, I agree to the <a href="/docs/termsOfUse.htm" target="_blank">Terms of Use</a> and <a href="/docs/privacyPolicy.htm" target="_blank">Privacy Policy</a>.</div>';
      echo '<input type="submit" name="submit" class="sign_me_up" id="register_submit" value="Create Account" />';
      //echo '<div id="next">Next ></div>';
    echo '</form>';  
  echo '</div>'; //Close register_form
  echo '<div><div id="cancel_email_sign_up">Cancel</div></div>';
echo '</div>';  //close #create_account
//ERRORS
//echo '<div class="reg_err_exp" id="reg_err_email_exp"></div>';

//echo '<script type="text/javascript" src="js/ajax_register_guest.js"></script>';

}

function show_fb_registration_box_landing () {

  
echo '<div id="create_account_fb">';  
  echo '<div id="register_form_fb">';
    echo '<form name="register_form_fb" action="../chat/register_user.php" method="post" id="r_form_fb">';
      echo '<div class="register_error_area_fb" id="reg_user_exists_fb"></div>';
      echo '<div id="username_fb"><input type="text" id="register_username_fb" placeholder="Choose a Username" /><span class="reg_err check" id="reg_username_check_fb"></span><span class="reg_err" id="reg_username_error_fb"></span><div class="reg_err_exp" id="reg_err_username_exp_fb"></div></div>'; 
      echo '<div id="birthday_fb">';
        echo '<div class="small_title">When is your birthday?</div>';
        echo '<span>';
          date_select($the_date=get_inputed_date ($type="default"), $the_name="birthday", $for="sign_up_fb");
        echo '</span>';
        echo '<span class="reg_err check" id="reg_birthday_check_fb"></span><span class="reg_err" id="reg_birthday_error_fb"></span><div class="reg_err_exp" id="reg_err_birthday_exp_fb"></div>';
      echo '</div>';
      echo '<div id="email_fb"><input type="text" id="register_email_fb" placeholder="Your Email" /><span class="reg_err check" id="reg_email_check_fb"></span><span class="reg_err" id="reg_email_error_fb"></span><div class="reg_err_exp" id="reg_err_email_exp_fb"></div></div>';
      echo '<div id="terms">By using Starma, I agree to the <a href="/docs/termsOfUse.htm" target="_blank">Terms of Use</a> and <a href="/docs/privacyPolicy.htm" target="_blank">Privacy Policy</a>.</div>';
      echo '<input type="submit" name="submit_fb" class="sign_me_up" id="register_submit_fb" value="Create Account" />';
      //echo '<input type="hidden" name="fb" id="from_fb" value="fb" />';
    echo '</form>';  
  echo '</div>'; //Close register_form
  echo '<div><div id="cancel_sign_up_fb">Cancel</div></div>';
echo '</div>';  //close #create_account
}


function show_forgot_password_box() {
  echo '<div id="forgot_password_box">';
   echo '<form action="/chat/forgot_password.php" method="POST" id="forgot_password_form"> 
          <div class="heading">Reset Password</div>
            <input type="text" name="email" id="fp_email" maxlength="55" placeholder="Your Email" />
            <button type="submit" class="sign_up" name="fp_submit" id="fp_submit">Reset Password</button>
        </form>';
    echo '<div id="sending"></div>';
    echo '<div id="close_fp" class="later_on">Close</div>';
  echo '</div>';
}




function show_landing_logo() {
  echo '
  <div class="bg" id="logo">
    <a href="' . get_landing() . '"><img src="img/account_info/Starma-Astrology-Logo.png"/></a>
  </div>';
}

function show_bugaboos() {
  echo '
  <div id="bug1">
    <img src="img/account_info/Starma-Astrology-Feet-Bugaboo.png"/>
  </div>
  <div id="bug2">
    <img src="img/account_info/Starma-Astrology-Planet-Bugaboo.png"/>
  </div>';
}


//******************************* SIGN UP BOXES **********************************/

//SINGLE PAGE SIGN UP

function show_sign_up_page() {
  echo '<div id="sign_up_page">';
  echo '<div id="gender_location">';
    echo '<div class="title">Congratulations!</div>';
    echo '<div class="congrats">You\'ve created an account.  We just need a tiny bit of info and you\'ll be ready to start!</div>';
    //echo '<div id="step">1 / 3</div>';
      echo '<form id="sign_up_page_form" name="sign_up" method="post" action="/chat/sign_up_page.php">';
        
        echo '<div class="small_title">Gender</div>';
          echo '<div id="gender">';
            gender_select ($the_gender=$gender, $the_name="gender");
            
          echo '</div>';

          echo '<div class="small_title">Current Location</div>';
              
          echo '<div id="country">';    
            country_select ($country_id, "js_country_id");
            
          echo '</div>';

          echo '<div id="js_city_div">';
            echo '<input type="text" id="city" name="title" placeholder="City"/>';
            
          echo '</div>';

          echo '<div id="js_zip_div">';
            //zipcode_input ("zip", "location_verification .location_text");
          echo '<input maxlength="5" type="text" id="zip"';
            if ($_GET['error'] == 2 || $_GET['error'] == 4 || $_GET['error'] == 6 ) {
              echo ' style="border-color:#C82923;"';
            } 

          echo ' name="zip" value="' . $_SESSION['zip'] . '" placeholder="Zip Code">';
           
          echo '</div>'; 
          
          echo '<div id="location_verification">';
            
          echo '</div>';

    //echo '</div>'; //close gender_location

    //ERRORS---------------

    echo '<div class="gl_err" id="gl_gender_error"></div>
          <div class="gl_err_exp" id="gl_err_gender_exp"></div>';

    echo '<div class="gl_err" id="gl_cid_error"></div>
          <div class="gl_err_exp" id="gl_err_cid_exp"></div>';

    echo '<div class="gl_err" id="gl_city_error"></div>
          <div class="gl_err_exp" id="gl_err_city_exp"></div>';

     echo '<div class="gl_err" id="gl_zip_error"></div>
           <div class="gl_err_exp" id="gl_err_zip_exp"></div>';

    //echo '<script type="text/javascript" src="/js/ajax_gender_location.js"></script>';



//3 WORDS & PHOTO

  $user_id = get_my_user_id();
  $descriptors = get_descriptors($user_id);
  //print_r($descriptors);
  //echo '<br>descriptor1: ' . $descriptors[0]['descriptor'];
  //echo '<div id="words_photo" ';
    //if (isset($_GET['error'])) {
      //echo 'style="display:none;"';
    //}
  //echo '>';
  //echo '<div id="step">2 / 3</div>';
    echo '<div style="text-align:center;" class="small_title">Upload a photo and choose 3 words to describe yourself</div>';

    echo '<div id="action_step" class="later_on"></div>';
    //PROFILE PIC ---

    echo '<div id="profile_photo">';

      echo '<div class="photo_border_wrapper_compare">';
        echo '<div class="compare_photo">';
          if ($main_photo = get_main_photo($user_id)) {           
            echo '<div class="user_button">' . format_image($picture=get_main_photo($user_id), $type="compare", $user_id) . '</div>';            
          }
          elseif (get_my_main_photo_uncropped()) {
            do_redirect( $url = get_domain() . '/sign_up.php?crop');
          }
          else {
            echo '<div class="user_button"><div class="div_no_photo later_on pointer">Upload<br> a<br> Photo</div></div>';
          }
        echo '</div>';
      echo '</div>';

      echo '<div id="use_photo" style="height:15px;"></div>';
      //if (!get_my_fb_id()) {
        //echo '<div id="use_fb_photo" class="later_on" onclick="fbSignUp();">Use Facebook My Pic</div>';
      //}
      //else {
        //echo '<div id="use_fb_photo" class="later_on div_no_photo">Upload a Photo</div>';
      //}
      

    echo '</div>';

    echo '<div id="edit_words">';
      
      //echo '<form id="words_photo_form" action="/chat/ajax_words_photo.php" method="post">';
        
        //if ($desc = mysql_fetch_array($descriptors)) {
        if (isset($descriptors)) {
          //echo $descriptors;
          $x = 0;
          while ($desc = mysql_fetch_array($descriptors)) {
            echo '<input type="text" maxlength="15" id="word_' . ($x + 1) . '" placeholder="' . ($x + 1) . '. " value="' . $desc["descriptor"] . '"/>';
            $x = $x + 1;
          }
        }        
        if (isset($x) && $x == 0) {
          //echo $x;
           //for ($x = 1; $x<4; $x++) {
            //$x = 4;
              //echo '<div class="value">';
               echo '<input type="text" maxlength="15" id="word_1" placeholder="i.e. quirky "';
                  if(isset($_SESSION['word_1'])) {
                    echo 'value="' . $_SESSION['word_1'] . '"';
                  }
                echo '/>';

                echo '<input type="text" maxlength="15" id="word_2" placeholder="i.e. cat-loving"';
                  if(isset($_SESSION['word_2'])) {
                    echo 'value="' . $_SESSION['word_2'] . '"';
                  }
                echo '/>';

                echo '<input type="text" maxlength="15" id="word_3" placeholder="i.e. astronaut"';
                  if(isset($_SESSION['word_3'])) {
                    echo 'value="' . $_SESSION['word_3'] . '"';
                  }
                echo '/>';  
          //}
        }

        //echo 'X = ' . $x;
        //echo $_SESSION['word_1'];
        //echo $_SESSION['word_2'];
        //echo $_SESSION['word_3'];
        elseif (isset($x) && $x > 0 && $x < 3) {
          for ($i = ($x + 1); $i < 4; $i++) {
            echo '<input type="text" id="word_' . $i . '" placeholder="' . $i . '. " value=""/>';
          }
        }
        unset($x);
        
        //echo '<input type="hidden" value="words" id="words" />';

      //ERRORS---------------------------
        echo '<div class="w_err" id="w_1_error"></div>';
        echo '<div class="w_err_exp" id="w_1_err_exp"></div>';

        echo '<div class="w_err" id="w_2_error"></div>';
        echo '<div class="w_err_exp" id="w_2_err_exp"></div>';

        echo '<div class="w_err" id="w_3_error"></div>';
        echo '<div class="w_err_exp" id="w_3_err_exp"></div>';


      
    echo '</div>'; //close edit_words

  

    if ($main_photo = get_main_photo($user_id)) {
      echo '<div id="sign_up_submit">';
        //echo '<input type="submit" class="sign_me_up" id="words_photo_submit" value="Continue" />';
        echo '<button type="submit" id="next">Done ></button>';
      echo '</div>';
    }
    else {
      echo '<div id="sign_up_submit">';
        //echo '<input type="submit" class="sign_me_up" id="words_photo_submit" value="Continue" />';
        echo '<div id="next" class="incomplete">Done ></div>';
      echo '</div>';
    }
    //echo '</div>';  //close 3_words_photo
  echo '</form>';

  echo '</div>'; //close gender_location
  echo '</div>'; //close sign_up_page

//PHOTO ERRORS---------------------------------
  /*
  echo '<div class="p_err" id="p_error">';
    if($_GET['error'] !== 0) {
      echo '?';
    }
  echo '</div>';
  echo '<div class="w_err_exp" id="p_err_exp">';
    if($_GET['error'] == 1) {
      echo 'There was an error, please try again';
    }
    elseif($_GET['error'] == 2) {
      echo 'You have reached the limit of 5 photos';
    }
    elseif($_GET['error'] == 3) {
      echo 'No file selected';
    }
    elseif($_GET['error'] == 4) {
      echo 'Not a valid file';
    }
  echo '</div>';
  */
  //echo '<script type="text/javascript" src="/js/ajax_words_photo.js"></script>';

}

function show_upload_photo_sign_up_box () {
        echo '<div id="upload_photo_form_sign_up" ';
          if (isset($_GET['error'])) {
            echo 'style="display:block;"';
          }
        echo '>';      
          echo '<div class="heading">Upload Your Photo</div>';

        //ERRORS----------

          if (isset($_GET['error'])) {
            if ($_GET['error'] == 1) {
              echo '<div class="p_err">There was an error.  Please try again.</div>';
            }
            if ($_GET['error'] == 2) {
              echo '<div class="p_err">You have too many photos.  Please delete one to upload a new photo.</div>';
            }
            if ($_GET['error'] == 3) {
              echo '<div class="p_err">Please select a photo with the Browse button.</div>';
            }
            if ($_GET['error'] == 4) {
              echo '<div class="p_err">Pease select a valid file.</div>';
            }
          }

        //END ERRORS------------

            echo '<form id="form_photo" action="process_photo.php" method="post" enctype="multipart/form-data">';          
              echo '<div><input id="image" type="file" name="image"/></div>';
              echo '<input type="submit" value="Next >" name="action" id="upload_photo" />';

              echo '<input type="hidden" name="desc1" id="desc1" value=""/>';
              echo '<input type="hidden" name="desc2" id="desc2" value=""/>';
              echo '<input type="hidden" name="desc3" id="desc3" value=""/>';
              echo '<input type="hidden" name="firsttime" value="1"/>';
              //echo '<div id="cancel_photo" class="later_on">Cancel</div>';
           echo '</form>';
        echo '</div>';
      echo '</div>';
}


/*//OLD WAY 
function show_gender_location_box() {
  echo '<div id="gender_location">';
    echo '<div class="title">Congratulations!</div>';
    echo '<div class="congrats">You\'ve created an account.  Just 3 more steps and you\'re ready to start!</div>';
    echo '<div id="step">1 / 3</div>';
      echo '<form id="gender_location_form" method="post" action="/chat/ajax_gender_location.php">';
        
        echo '<div class="small_title">Gender</div>';
          echo '<div id="gender">';
            gender_select ($the_gender=$gender, $the_name="gender");
            
          echo '</div>';

          echo '<div class="small_title">Current Location</div>';
              
          echo '<div id="country">';    
            country_select ($country_id, "js_country_id");
            
          echo '</div>';

          echo '<div id="js_city_div">';
            echo '<input type="text" id="city" name="title" placeholder="City"/>';
            
          echo '</div>';

          echo '<div id="js_zip_div">';
            //zipcode_input ("zip", "location_verification .location_text");
          echo '<input maxlength="5" type="text" id="zip"';
            if ($_GET['error'] == 2 || $_GET['error'] == 4 || $_GET['error'] == 6 ) {
              echo ' style="border-color:#C82923;"';
            } 

          echo ' name="zip" value="' . $_SESSION['zip'] . '" placeholder="Zip Code">';
           
          echo '</div>'; 
          
          echo '<div id="location_verification">';
            //echo '<div class="location_text"></div>';
          echo '</div>';

          //echo '<button class="sign_me_up" type="submit" name="location_gender_submit">Continue</button>';

          echo '<button type="submit" id="next">Next ></button>';

      echo '</form>';
    echo '</div>';

    //ERRORS---------------

    echo '<div class="gl_err" id="gl_gender_error"></div>
          <div class="gl_err_exp" id="gl_err_gender_exp"></div>';

    echo '<div class="gl_err" id="gl_cid_error"></div>
          <div class="gl_err_exp" id="gl_err_cid_exp"></div>';

    echo '<div class="gl_err" id="gl_city_error"></div>
          <div class="gl_err_exp" id="gl_err_city_exp"></div>';

     echo '<div class="gl_err" id="gl_zip_error"></div>
           <div class="gl_err_exp" id="gl_err_zip_exp"></div>';

    echo '<script type="text/javascript" src="/js/ajax_gender_location.js"></script>';

}


function show_3_words_photo_box () {

  $user_id = get_my_user_id();
  $descriptors = get_descriptors($user_id);
  //print_r($descriptors);
  //echo '<br>descriptor1: ' . $descriptors[0]['descriptor'];
  echo '<div id="words_photo" ';
    if (isset($_GET['error'])) {
      echo 'style="display:none;"';
    }
  echo '>';
  echo '<div id="step">2 / 3</div>';
    echo '<div style="text-align:center;" class="small_title">Upload a photo and choose 3 words to describe yourself</div>';

    echo '<div id="action_step" class="later_on"></div>';
    //PROFILE PIC ---

    echo '<div id="profile_photo">';

      echo '<div class="photo_border_wrapper_compare">';
        echo '<div class="compare_photo">';
          if ($main_photo = get_main_photo($user_id)) {           
            echo '<div class="user_button">' . format_image($picture=get_main_photo($user_id), $type="compare", $user_id) . '</div>';            
          }
          elseif (get_my_main_photo_uncropped()) {
            do_redirect( $url = get_domain() . '/sign_up.php?2_5');
          }
          else {
            echo '<div class="user_button"><div class="div_no_photo later_on">Upload<br> a<br> Photo</div></div>';
          }
        echo '</div>';
      echo '</div>';

    echo '</div>';

    echo '<div id="edit_words">';
      
      echo '<form id="words_photo_form" action="/chat/ajax_words_photo.php" method="post">';
        
        //if ($desc = mysql_fetch_array($descriptors)) {
        if (isset($descriptors)) {
          //echo $descriptors;
          $x = 0;
          while ($desc = mysql_fetch_array($descriptors)) {
            echo '<input type="text" maxlength="15" id="word_' . ($x + 1) . '" placeholder="' . ($x + 1) . '. " value="' . $desc["descriptor"] . '"/>';
            $x = $x + 1;
          }
        }        
        if (isset($x) && $x == 0) {
          //echo $x;
           //for ($x = 1; $x<4; $x++) {
            //$x = 4;
              //echo '<div class="value">';
               echo '<input type="text" maxlength="15" id="word_1" placeholder="i.e. quirky "';
                  if(isset($_SESSION['word_1'])) {
                    echo 'value="' . $_SESSION['word_1'] . '"';
                  }
                echo '/>';

                echo '<input type="text" maxlength="15" id="word_2" placeholder="i.e. cat-loving"';
                  if(isset($_SESSION['word_2'])) {
                    echo 'value="' . $_SESSION['word_2'] . '"';
                  }
                echo '/>';

                echo '<input type="text" maxlength="15" id="word_3" placeholder="i.e. astronaut"';
                  if(isset($_SESSION['word_3'])) {
                    echo 'value="' . $_SESSION['word_3'] . '"';
                  }
                echo '/>';  
          //}
        }

        //echo 'X = ' . $x;
        //echo $_SESSION['word_1'];
        //echo $_SESSION['word_2'];
        //echo $_SESSION['word_3'];
        elseif (isset($x) && $x > 0 && $x < 3) {
          for ($i = ($x + 1); $i < 4; $i++) {
            echo '<input type="text" id="word_' . $i . '" placeholder="' . $i . '. " value=""/>';
          }
        }
        unset($x);
        
        echo '<input type="hidden" value="words" id="words" />';

      //ERRORS---------------------------
        echo '<div class="w_err" id="w_1_error"></div>';
        echo '<div class="w_err_exp" id="w_1_err_exp"></div>';

        echo '<div class="w_err" id="w_2_error"></div>';
        echo '<div class="w_err_exp" id="w_2_err_exp"></div>';

        echo '<div class="w_err" id="w_3_error"></div>';
        echo '<div class="w_err_exp" id="w_3_err_exp"></div>';


        if ($main_photo = get_main_photo($user_id)) {
          echo '<div id="submit_words_photo">';
            //echo '<input type="submit" class="sign_me_up" id="words_photo_submit" value="Continue" />';
            echo '<button type="submit" id="next">Next ></button>';
          echo '</div>';
        }
        else {
          echo '<div id="submit_words_photo">';
            //echo '<input type="submit" class="sign_me_up" id="words_photo_submit" value="Continue" />';
            echo '<div id="next" class="incomplete">Next ></div>';
          echo '</div>';
        }

      echo '</form>';
    echo '</div>'; //close edit_words


    /*
    echo '<div id="photo_form_div">';
      
        //echo '<h1>';       
          echo '<div class="small_title">Upload your profile photo:</div>';
        //echo '</h1>';
        echo '<form id="form_photo" action="process_photo.php" method="post" enctype="multipart/form-data">';
          //echo '<div id="photo_display">';
            echo '<div id="my_tiny_photo">
                    <div class="grid_photo_border_wrapper"><div class="grid_photo">';
                    show_user_inbox_picture ('', get_my_user_id());
            echo '</div></div></div>';
          //echo '</div>';
          
          echo '<input id="image" type="file" name="image"/>';
          echo '<input type="submit" value="Click to upload your photo" name="action" id="upload_photo" />';
            
            if (isset($_GET['error'])) {
              echo '<input type="hidden" id="crop_error" />';
            }
          echo '<div id="p_error" class="p_err"></div>';

          echo '<input type="hidden" name="desc1" id="desc1" value=""/>';
          echo '<input type="hidden" name="desc2" id="desc2" value=""/>';
          echo '<input type="hidden" name="desc3" id="desc3" value=""/>';
          echo '<input type="hidden" name="firsttime" value="1"/>';
          

          echo '</div>';
        
      echo '</form>';
  */


  /*echo '</div>';  //close 3_words_photo*/


//PHOTO ERRORS---------------------------------
  /*
  echo '<div class="p_err" id="p_error">';
    if($_GET['error'] !== 0) {
      echo '?';
    }
  echo '</div>';
  echo '<div class="w_err_exp" id="p_err_exp">';
    if($_GET['error'] == 1) {
      echo 'There was an error, please try again';
    }
    elseif($_GET['error'] == 2) {
      echo 'You have reached the limit of 5 photos';
    }
    elseif($_GET['error'] == 3) {
      echo 'No file selected';
    }
    elseif($_GET['error'] == 4) {
      echo 'Not a valid file';
    }
  echo '</div>';
  */
  //echo '<script type="text/javascript" src="/js/ajax_words_photo.js"></script>';

//}



function show_photo_cropper_sign_up($photo_to_crop) {
  $img_id = $photo_to_crop["user_pic_id"];
  $img_name = $photo_to_crop["picture"];
  echo '<div class="photo_cropper_content">';
    echo '<div id="zoom">Use scroll bar to zoom</div>';
    echo '<div class="cropSlider"></div>';
    echo '<div id="rotate">';
      echo '<input id="rotate_left" type="submit" name="submit" value="<- Rotate"/>';
      echo '<input id="rotate_right" type="submit" name="submit" value="Rotate ->"/>';
    echo '</div>';
    echo '<div class="cropMain" style="margin:0 auto 16px;"></div>';
    if ($_GET['the_page'] == 'psel') {
      echo '<button name="submit" id="next_profile" class="later_on pointer">Next ></button>';
    }
    else {
      echo '<button name="submit" id="next">Next ></button>';
    }
    
    


    echo '<style>
 
        .photo_cropper_content .cropMain {
          width:244px;
          height:244px;
          border: 2px solid black;
        }
 
          </style>

    ';

    //echo '<img id="photo_crop_' . $img_id . '" src="' . ORIGINAL_IMAGE_PATH() . $img_name . '?' . time() . '">';    
    //echo '<input type="hidden" name="x1" id="x1" value=""/>';
    //echo '<input type="hidden" name="y1" id="y1" value=""/>';
    //echo '<input type="hidden" name="x2" id="x2" value=""/>';
    //echo '<input type="hidden" name="y2" id="x2" value=""/>';
    //echo '<input type="hidden" name="w" id="w" value=""/>';
    //echo '<input type="hidden" name="h" id="h" value=""/>';
  echo '</div>';

  activate_photo_cropper ($img_id, $img_name);
}

function show_crop_box() {
  echo '<div id="crop_box">';
    //$descriptors = get_my_descriptors(); //causes error without a real user
    $unc_photos = uncropped_photos(get_my_user_id());
    if ($photo_to_crop = mysql_fetch_array($unc_photos)) {
      //echo '<div id="photo_cropper_reg">';
         echo '<form action="crop_photo.php" method="post" name="crop_photo_form">';
            show_photo_cropper_sign_up($photo_to_crop);
            echo '<input type="hidden" name="imgName" value="' . $photo_to_crop["picture"] . '"/>';
            echo '<input type="hidden" name="imgID" value="' . $photo_to_crop["user_pic_id"] . '"/>';
            echo '<input type="hidden" name="firsttime" value="1"/>';
            /*$x = 0;
            while ($desc = mysql_fetch_array($descriptors)) {
              echo '<input type="hidden" name="desc"' . $x . '" value="' . $desc["descriptor"] . '"/>';
              $x = $x++;
            }
            */
            echo '<input type="hidden" name="word_1" value="' . $_SESSION["word_1"] . '"/>';
            echo '<input type="hidden" name="word_1" value="' . $_SESSION["word_2"] . '"/>';
            echo '<input type="hidden" name="word_1" value="' . $_SESSION["word_3"] . '"/>';
        echo '</form>';
      //echo '</div>';
    }
    else {
      //echo '<div><a href="/sign_up.php?2">Please upload a photo</a></div>';
      //do_redirect(get_domain() . '/sign_up.php?2');
      do_redirect(get_domain() . '/sign_up.php');
    }
  echo '</div>'; //close crop_box
}

function show_time_and_place_box() {
  //echo $_SESSION['user_id'];
  echo '<div id="time_and_place" class="time_and_place">';
  echo '<div id="step"></div>';
  if (isset($_GET['chart_error'])) {
    echo '<span id="chart_error_exists" style="display:none;"></span>';
  }
  //echo '<div class="title">Your Birth Info</div>';
  echo '<div class="later_on" style="margin-bottom: 13px; margin-top: 0px; text-align: center; line-height: 1.2; font-size: 1.3em;">To view your compatibility, please enter your time and place of birth. This information remains private, and you only have to enter it once.</div>';
    echo '<form id="birth_info_form" method="post" action="cast_chart_time_and_place.php">';
      
       $help_text_offset = 'offset';
    echo '<div class="small_title">Place of Birth</div>';
    //echo '<input type="text" placeholder="i.e. San Francisco, CA" name="address" value="' . get_inputed_var("location", $title, $type) . '"/>';
 
          echo '<div id="country">';    
            country_select ($_SESSION['country_id'], "country_id");
            
          echo '</div>';

          echo '<div id="js_city_div">';
            echo '<input type="text" id="city" class="input_style" name="city" placeholder="i.e. San Francisco, CA" value="' . $_SESSION['city'] . '"';
              if ($_GET['chart_error'] == 2 || $_GET['chart_error'] == 3 || $_GET['chart_error'] == 6) {
              echo ' style="border-color:#C82923;"';
            }
            echo '/>';
            
          echo '</div>';

          //echo '<div id="js_zip_div">';
          //  zipcode_input ("zip", "location_verification .location_text");           
          //echo '</div>'; 
          
          //echo '<div id="location_verification">';
          //  echo '<div class="location_text"></div>';
          //echo '</div>';

  echo '<div style="display:inline-block; float:left; width:147px;">'; //Time of birth box
    echo '<div class="small_title">Time of birth</div>';
    echo '<div id="time">';
      time_select (get_inputed_time($type), "time", (string)get_inputed_var("time_unknown",0,$type));
    echo '</div>';
  echo '</div>'; //Close Time of birth box

  echo '<div style="display:inline-block; float:right; width:120px;">'; //Accuracy box
      echo '<div class="small_title" class="align_right">Accuracy</div>';             
        echo '<div id="accuracy">';
                 time_accuracy_select (get_inputed_var("interval",0,$type), "interval", (string)get_inputed_var("time_unknown",0,$type));
         
        echo '<div id="tp_birth_time_hover_box" class="hover_box">?<span>This function is very important! The Accuracy of Time drop down menu lets you tell us how close or far off your time of birth might be. For example, if you put in 7:00pm for your time of birth, but you hear from your parents or a legal guardian that you were born between 6:00pm and 8:00pm, you can use the Accuracy of Time drop down menu to select “within 1 hour”. This tells us that you could be born 1 hour ahead or behind the time of birth (7:00pm) you entered.  Some things, such as your Rising sign, can change even in a couple hours! So please make sure your information is as accurate as possible!</span>
              </div>';
      echo '</div>'; //Close accuracy
  echo '</div>'; //Close Accuracy box

    echo '<div id="help_link"> Help! I don\'t know my birth time'; 
    
   /* echo '<input class="pointer" onclick="var box_obj = document.getElementById(\'birth_interval_box_help_text\'); var acc_obj = document.getElementById(\'interval\'); var hour_obj = document.getElementById(\'hour_time\'); var minute_obj = document.getElementById(\'minute_time\'); var meridiem_obj = document.getElementById(\'meridiem_time\');if ($(\'#birth_interval_box_help_text\').is(\':visible\')) {box_obj.style.display=\'none\'; acc_obj.disabled=false;hour_obj.disabled=false;minute_obj.disabled=false;meridiem_obj.disabled=false;} else {box_obj.style.display=\'block\'; acc_obj.value=\'-1\'; acc_obj.disabled=true;hour_obj.disabled=true;minute_obj.disabled=true;meridiem_obj.disabled=true;}" type="checkbox" name="time_unknown" value="1" ';
                 if ( (string)get_inputed_var("time_unknown",0,$type) == '1' ) {
                   echo 'CHECKED';
                 }
                 echo '/>';
                 echo '<div style="position:relative"><div id="birth_interval_box_help_text" class="' . $help_text_offset . '" ';
                 if ((string)get_inputed_var("time_unknown",0,$type) == '1') {
                    echo 'style="display:block;"';
                 }
                 echo '>';
                 echo '<a onclick="basicPopup(\'help_text_birth_time.php\', \'Help Text\', \'height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no, titlebar=no\')" href="#">Help me find my birth time</a>';
                 echo '</div></div>'; 
    */
    echo '</div>';
      echo '<input type="hidden" id="time_unknown" name="time_unknown" value="0" />';
      echo '<input type="hidden" name="time_and_place" value="1" />';
      //echo '<input class="sign_me_up" name="submit" type="submit" value="Continue" />';
      echo '<button type="submit" id="next">Done ></button>';
    echo '</form>';           
  echo '</div>'; //close time_and_place

//ERRORS--------------------------------------------------

  echo '<div class="tp_err" id="tp_cid_error_h">?</div>
        <div class="tp_err_exp" id="tp_err_cid_exp">Please select a country</div>';
  echo '<div class="tp_err" id="tp_city_error_h">?</div>
        <div class="tp_err_exp" id="tp_err_city_exp">Please enter a city</div>';

  if ($_GET['chart_error'] == 1) {
    echo '<div class="tp_err" id="tp_cid_error">?</div>
          <div class="tp_err_exp" id="tp_err_cid_exp">Please select a country</div>';
  }
  if ($_GET['chart_error'] == 2 || $_GET['chart_error'] == 3 || $_GET['chart_error'] == 6) {        
    echo '<div class="tp_err" id="tp_city_error">?</div>
          <div class="tp_err_exp" id="tp_err_city_exp">';
            if ($_GET['chart_error'] == 2) {  
              echo 'Please enter a city';
            }
            if ($_GET['chart_error'] == 3 || $_GET['chart_error'] == 6) {
              echo 'Please double check your city';
            }

    echo '</div>';
  }

  echo '<div class="close_tp later_on pointer">x</div>';
  /*
  if ($_GET['error'] == 2 || $_GET['error'] == 4 || $_GET['error'] == 6) {
     echo '<div class="tp_err" id="tp_zip_error">?</div>
           <div class="tp_err_exp" id="tp_err_zip_exp">';
            if ($_GET['error'] == 2) {
              echo 'Please enter a zip code';
            }
            if ($_GET['error'] == 4 || $_GET['error'] == 6) {
              echo 'Please double check your zip code';
            }
      echo '</div>';
  }
*/

  echo '<script type="text/javascript" src="/js/time_and_place_ui.js"></script>';

}

function show_donate_button() {
  echo '<div id="donate_button_div"/>';
  echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
          <input type="hidden" name="cmd" value="_s-xclick">
          <input type="hidden" name="hosted_button_id" value="X2BUW3R9GBZNC">
          <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
        </div>';
}



//*************************  GUEST VIEW BOXES  *********************************/

function show_login_box_guest () {
    echo '<div id="login_box">';
      //echo '<div class="heading">Log In</div>';
        echo '<button type="button" class="sign_up" onClick="fbLoginGuest();">Facebook Login</button>';
        echo '<div id="or">~ or ~</div>';
        echo '<form action="../chat/login_form_fields.php" method="POST" id="login_from_guest">';
          echo '<input type="text" id="login_email" name="email" placeholder="Your Email" value="';
            if(isset($_GET['email'])) {
              echo $_GET['email'];
            }
          echo '"/>';
          //echo '<div class="register_error_area" id="login_email_error"></div>';
          echo '<input type="password" id="login_password" name="password" placeholder="Password" />';
          //echo '<input type="text" id="pass" name="password" placeholder="Password" />';
          //echo '<div class="register_error_area" id="login_password_error"></div>';
          echo '<div id="kmsi_fp">';  
            echo '<div id="forgot_password">forgot your password?</div>';
            echo '<div id="stay_logged_in"><input type="checkbox" name="stay_logged_in" value="" /><div>keep me signed in</div></div>';
          echo '</div>';
          echo '<button type="submit" id="go_bug_button" name="Login"></button>';
          //echo '<div class="sign_up_text">Go ></div>';
          //echo '<input type="submit" id="go_bug_button" name="Login" value=""/>';
          //echo '<button type="submit" name="login_submit" class="sign_up">Log In</button>';
        echo '</form>';
        echo '<div id="go_bug_path_guest"></div>';
    echo '</div>';

  //echo '<script type="text/javascript" src="js/ajax_login_guest.js"></script>';
}

function show_sign_up_box_guest () {
  echo '<div id="sign_up_box_guest">';
    echo  '<div id="sign_up_box_text" class="sign_up_text">';
    //if ($_GET['chart_id2'] == 861) {
    if ($_GET['tier'] == 2 && $_GET['chart_id2'] == 861) {
      echo 'You\'re about to see an example of two people\'s compatibility.  To view your own compatibility with someone...';
    }
    elseif ($_GET['tier'] == 2 && !($_GET['chart_id2'] == 861)) {
      $isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($_GET["chart_id2"])));
      if (!$isCeleb) {
        $username = get_nickname(get_user_id_from_chart_id($_GET['chart_id2']));
        echo 'You\'re about to see an example of two people\'s compatibility.  To view your own compatibility with ' . $username . '...';
      }
      else {
        $user_info = profile_info(get_user_id_from_chart_id($_GET['chart_id2']));
        echo 'You\'re about to see an example of two people\'s compatibility.  To view your own compatibility with ' . $user_info['first_name'] . ' ' . $user_info['last_name'] . '...';
      }
    }
    elseif ($_GET['the_page'] == 'psel' && ($_GET['section'] == 'chart_selected' || $_GET['section'] == 'western_selected' || $_GET['section'] == 'astrologers_view_selected' || !isset($_GET['section']))) {
      echo 'You\'re about to see an example of a birth chart.  To view your own birth chart...';
    }
    else {
      echo 'This part of the site is reserved for Starma members only. In order to view this content...';     
    }
    echo '</div>';
    echo '<button type="button" name="create_an_account" id="create_an_account">Create an Account</button>';
    echo '<div id="close" class="close">Close</div>';
  echo '</div>'; //Close sign_up_box
}

function show_fb_or_email_box_guest () {
  echo '<div id="fb_or_email_guest">';
    echo  '<div class="heading">Create an Account</div>';
      echo '<button type="button" name="sign_up_fb" class="sign_up" onClick="fbSignUpGuest();">Facebook</button>';
      echo '<div id="or">~ or ~</div>';
      //echo '<button type="button" onClick="revokeFB();">revoke fb</button>';
      echo '<button type="button" name="sign_up_email" class="sign_up">Email</button>';    
  echo '</div>'; //Close sign_up_box
}

function show_fb_or_email_login_box_guest () {
  echo '<div id="fb_or_email_login_guest">';
    echo  '<div class="heading">Log In With...</div>';
      echo '<button type="button" name="login_fb" class="sign_up" onClick="fbLoginGuest();">Facebook</button>';
      echo '<div id="or">~ or ~</div>';
      //echo '<button type="button" onClick="revokeFB();">revoke fb</button>';
      echo '<button type="button" name="login_email" class="sign_up">Email</button>';
  echo '</div>'; //Close sign_up_box
}

function show_forgot_password_box_guest() {
  echo '<div id="forgot_password_box">';
   echo '<form action="../chat/forgot_password.php" method="POST" id="forgot_password_form"> 
          <div class="heading">Reset Password</div>
            <input type="text" name="email" id="fp_email" maxlength="55" placeholder="Your Email" />
            <button type="submit" class="sign_up" name="fp_submit" id="fp_submit">Reset Password</button>
        </form>';
    echo '<div id="sending"></div>';
    echo '<div id="close_fp" class="later_on">Close</div>';
  echo '</div>';
}

function show_registration_box_guest() {

  
echo '<div id="create_account">';  
  //echo '<div class="title">Create an Account</div>';
  //echo '<img src="img/account_info/Starma-Astrology-Create-Account-Boxes.png"/>';
  echo '<div id="register_form">';
    echo '<form name="register_form" action="../chat/register_user.php" method="post" id="register_form">';
      echo '<div class="register_error_area" id="reg_user_exists"></div>';
      echo '<div id="username"><input type="text" id="register_username" placeholder="Choose a Username" /><span class="reg_err_guest check" id="reg_username_check"></span><span class="reg_err_guest" id="reg_username_error"></span><div class="reg_err_exp_guest" id="reg_err_username_exp_g"></div></div>'; 
      //echo '<div class="register_error_area" id="reg_username_error"></div>';
      echo '<div id="birthday">';
        echo '<div class="small_title">Date of Birth (this stays private):</div>';
        echo '<span>';
          date_select($the_date=get_inputed_date ($type="default"), $the_name="birthday");
        echo '</span>';
        echo '<span class="reg_err_guest check" id="reg_birthday_check"></span><span class="reg_err_guest" id="reg_birthday_error"></span><div class="reg_err_exp_guest" id="reg_err_birthday_exp_g"></div>';
      echo '</div>';
      //echo '<div class="register_error_area" id="reg_birthday_error"></div>';
      echo '<div id="email"><input type="text" id="register_email" placeholder="Your Email" /><span class="reg_err_guest check" id="reg_email_check"></span><span class="reg_err_guest" id="reg_email_error"></span><div class="reg_err_exp_guest" id="reg_err_email_exp_g"></div></div>';
      //echo '<div class="register_error_area" id="reg_email_error"></div>';
      //echo '<div id="email2"><input type="text" id="register_email2" placeholder="Confirm Email" /></div>';
      //echo '<div class="register_error_area" id="reg_email2_error"></div>';
      echo '<div id="password"><input type="password" id="register_password" placeholder="Password" /><span class="reg_err_guest check" id="reg_password_check"></span><span class="reg_err_guest" id="reg_password_error"></span><div class="reg_err_exp_guest" id="reg_err_password_exp_g"></div></div>';
      //echo '<div class="register_error_area" id="reg_password_error"></div>';
      echo '<div id="terms">By using Starma, I agree to the <a href="../docs/termsOfUse.htm" target="_blank">Terms of Use</a> and <a href="../docs/privacyPolicy.htm" target="_blank">Privacy Policy</a>.</div>';
      echo '<input type="submit" name="submit" class="sign_me_up" id="register_submit" value="Create Account" />';
      //echo '<div id="next">Next ></div>';
    echo '</form>';  
  echo '</div>'; //Close register_form
  echo '<div><div id="cancel_email_sign_up">Cancel</div></div>';
echo '</div>';  //close #create_account

//echo '<script type="text/javascript" src="js/ajax_register_guest.js"></script>';
//ERRORS
//echo '<div class="reg_err_exp" id="reg_err_email_exp"></div>';

//echo '<script type="text/javascript" src="js/ajax_register_guest.js"></script>';

}

function show_fb_registration_box_guest () {

  
echo '<div id="create_account_fb">';  
  echo '<div id="register_form_fb">';
    echo '<form name="register_form_fb" action="../chat/register_user.php" method="post" id="r_form_fb">';
      echo '<div class="register_error_area_fb" id="reg_user_exists_fb"></div>';
      echo '<div id="username_fb"><input type="text" id="register_username_fb" placeholder="Choose a Username" /><span class="reg_err_guest check" id="reg_username_check_fb"></span><span class="reg_err_guest" id="reg_username_error_fb"></span><div class="reg_err_exp_guest" id="reg_err_username_exp_fb_g"></div></div>'; 
      echo '<div id="birthday_fb">';
        echo '<div class="small_title">When is your birthday?</div>';
        echo '<span>';
          date_select($the_date=get_inputed_date ($type="default"), $the_name="birthday", $for="sign_up_fb");
        echo '</span>';
        echo '<span class="reg_err_guest check" id="reg_birthday_check_fb"></span><span class="reg_err_guest" id="reg_birthday_error_fb"></span><div class="reg_err_exp_guest" id="reg_err_birthday_exp_fb_g"></div>';
      echo '</div>';
      echo '<div id="email_fb"><input type="text" id="register_email_fb" placeholder="Your Email" /><span class="reg_err_guest check" id="reg_email_check_fb"></span><span class="reg_err_guest" id="reg_email_error_fb"></span><div class="reg_err_exp_guest" id="reg_err_email_exp_fb_g"></div></div>';
      echo '<div id="terms">By using Starma, I agree to the <a href="/docs/termsOfUse.htm" target="_blank">Terms of Use</a> and <a href="/docs/privacyPolicy.htm" target="_blank">Privacy Policy</a>.</div>';
      echo '<input type="submit" name="submit_fb" class="sign_me_up" id="register_submit_fb" value="Create Account" />';
      //echo '<input type="hidden" name="fb" id="from_fb" value="fb" />';
    echo '</form>';  
  echo '</div>'; //Close register_form
  echo '<div><div id="cancel_sign_up_fb">Cancel</div></div>';
echo '</div>';  //close #create_account
}



?>