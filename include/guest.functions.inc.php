<?php

##### Guest Functions #####

function get_guest_user_id() {
	$q = 'SELECT user_id from user where nickname = "Lord_Starmeow"';
		if($result = mysql_query($q)) {
			if ($row = mysql_fetch_array ($result)) {
        		return $row['user_id'];
      		}
      		else {
        		return false;
      		}
    	}
    	else {
      		return false;
    	}
}

function get_guest_user_id2() {
  $q = 'SELECT user_id from user where nickname = "Lady_Starmeow"';
    if($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
            return $row['user_id'];
          }
          else {
            return false;
          }
      }
      else {
          return false;
      }
}

function get_guest_chart($user_id) {
  $q = 'SELECT * from chart where user_id = ' . $user_id . ' and personal = 1';
    if ($result = mysql_query($q)) {
      if ($row = mysql_fetch_array ($result)) {
        return $row;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
}

function get_guest_chart_id($user_id) {
  if ($chart = get_guest_chart($user_id)) {
    return $chart['chart_id'];
  }
}

function get_guest_photos() {
  //if (isLoggedIn()) {
    $user_id = get_guest_user_id();
    $q = "SELECT * from user_picture where user_id = " . $user_id . " and uncropped = 0";
    $result = mysql_query($q) or die(mysql_error());
    return $result;
     
  //}
  //else {
    //return false;
  //}
}

function show_birth_info_form_custom_guest () {
  
  
  echo '<div id="birth_info_custom">';
  echo '<div id="birth_info_form_custom_heading">Birth Info</div>';
  echo '<div id="birth_info_form_custom">
          <form id="birth_info_form" method="post" action="">
            <table>';

     echo '     <tr>
                  <td id="birth_date_input" class="align_right">';
                     echo 'date of birth
                     <input type="hidden" name="stage" value=""/>';
                  echo '</td>
                  <td id="birth_date_input" colspan="2">';
                    date_select ($the_date=get_inputed_date(""), $the_name="birthday");
  
       echo '     </td>
               </tr>';
       
            $gender = "";
          
          
          echo '<tr>
              <td id="gender_select_title" class="no_move align_right">gender</td>
              <td colspan="1" id="gender_select_input" class="no_move">';
                gender_select($gender);
         echo  '</td><td><span class="gender_validation"></span></td>
            </tr>';
        

  
     echo  '<tr>
             <td id="birth_place_title" class="no_move align_right">
                place of birth
             </td>
             <td colspan="2" id="birth_place_input" class="no_move">
                <input type="text" id="address" name="address" value="' . get_inputed_var("location", $title, "") . '"/>
             </td>
            </tr>';
     $help_text_offset = '';
  
  echo '     <tr>
               <td id="birth_time_title" class="align_right">';
                echo 'time of birth
               </td>';
             
  echo '       <td id="birth_time_input" colspan="2">';
                time_select (get_inputed_time(""), "time", (string)get_inputed_var("time_unknown",0,""));
         echo '</td>
              </tr>
             <tr>
               <td id="birth_interval_title" class="align_right">';
                  echo 'accuracy of time
               </td>';             
         echo '<td id="birth_interval_input">';
                 time_accuracy_select (get_inputed_var("interval",0,""), "interval", (string)get_inputed_var("time_unknown",0,""));
         echo '</td>';
    echo '     <td>
                 <div id="birth_time_hover_box_custom" class="hover_box">             
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
                 if ( (string)get_inputed_var("time_unknown",0,"") == '1' ) {
                   echo 'CHECKED';
                 }
                 echo '/>';
                 echo '<div style="position:relative"><div id="birth_interval_box_help_text" class="' . $help_text_offset . '" ';
                 if ((string)get_inputed_var("time_unknown",0,"") == '1') {
                    echo 'style="display:block;"';
                 }
                 echo '>';
                 echo '       <a onclick="basicPopup(\'help_text_birth_time.php\', \'Help Text\', \'height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no, titlebar=no\')" href="#">-> help!</a>';
                 echo '</div></div>';               
    echo '     </td>';
  echo '     </tr>';
  

            
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
           
    echo '</table>';

echo '<div id="go_bug_path"></div>';
echo        '<div id="submit_div_custom">
                <input id="submit" type="submit" name="submit" value=""/>
             </div>
             </div>
          </form>
        </div>
        ';

echo '<script type="text/javascript" src="/js/birth_form_guest_ui.js"></script>';

}

function get_left_menu_guest ($the_page) {
  for ($x=1; $x<=6; $x++) {
    $menu['nav' . $x] = array('','#'); 
  }
  if ($the_page == 'cesel') {
    $menu['nav1'] = array('Celebrities&nbsp;&nbsp;','celebrities.php','');
    /*$menu['nav2'] = array('Houses&nbsp;&nbsp;','#','');
    $menu['nav3'] = array('&nbsp;&nbsp;','#','');
    $menu['nav4'] = array('Career Advice&nbsp;&nbsp;','#','');
    $menu['nav5'] = array('My Birth Info&nbsp;&nbsp;','','pop_guest_click');
    $menu['nav6'] = array('About Astrology&nbsp;&nbsp;','two_zodiacs.php','');
    */
  }
  elseif ($the_page == 'psel') {
    $menu['nav1'] = array('Profile&nbsp;&nbsp;','non_chart_profile.php','');
    //$menu['nav2'] = array('houses&nbsp;&nbsp;','#','');
    $menu['nav2'] = array('Romantic Advice&nbsp;&nbsp;','romantic_advice.php','pop_guest_click');
    $menu['nav3'] = array('Career Advice&nbsp;&nbsp;','career_advice.php','pop_guest_click');
    $menu['nav4'] = array('My Birth Info&nbsp;&nbsp;','','pop_guest_click');
    //$menu['nav6'] = array('Career&nbsp;&nbsp;','#','');
    //$menu['nav6'] = array('about astrology&nbsp;&nbsp;','two_zodiacs.php','');
  }
  elseif ($the_page == 'cosel') {
    $menu['nav1'] = array('New to Starma&nbsp;&nbsp;','new_to_starma.php','');
    $menu['nav2'] = array('Favorites&nbsp;&nbsp;','','pop_guest_click');
    //$menu['nav3'] = array('Celebrities&nbsp;&nbsp;','celebrities.php','');
    $menu['nav3'] = array('Custom Chart&nbsp;&nbsp;', 'enter_user.php','');
    
  }
  elseif ($the_page == 'hsel') {
    $menu['nav1'] = array('Welcome&nbsp;&nbsp;','welcome.php','');
    $menu['nav2'] = array('About Starma&nbsp;&nbsp;', 'about_starma.php', '');
    $menu['nav3'] = array('About Astrology&nbsp;&nbsp;','two_zodiacs.php','pop_guest_click');
    
  }
  elseif ($the_page == 'isel') {
    $menu['nav1'] = array('Inbox&nbsp;&nbsp;','inbox.php','');
    
  }
  elseif ($the_page == 'ssel') {
    $menu['nav1'] = array('Settings&nbsp;&nbsp;','settings.php','');
    //$menu['nav2'] = array('Log Out&nbsp;&nbsp;','main_logout.php','');
    
  }
  
  return $menu;
}

?>