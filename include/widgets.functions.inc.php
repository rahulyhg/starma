<?php 

function flare_title ($title) {
  echo '<div class="flare_title">';

    echo '<div class="left_flare">';        
    echo '</div>';

    echo '<div class="title_content">';
      echo $title;
    echo '</div>';

    echo '<div class="right_flare">';
    echo '</div>';

  echo '</div>';
}

function time_accuracy_select ($the_interval, $the_name="interval", $greyed=0) {
  $interval_array = array("Exact" => 0, "Within 5 Minutes" => "000500", "Within 15 Minutes" => "001500", "Within 30 Minutes" => "003000", "Within 45 Minutes" => "004500", "Within 1 hour" => "010000", "Within 2 hours" => "020000", "Within 3 hours" => "030000", "More than 3 hours" => -1);
  echo '<select name="' . $the_name . '" id="' . $the_name . '" ';
  if ((string)$greyed == '1') {
    echo 'DISABLED="true"';
  }
  echo '>';
  foreach ($interval_array as $interval_name => $interval_value) {
    echo '<option value=' . $interval_value;
    if ((int)$the_interval == (int)$interval_value) {
      echo ' SELECTED';
    }
    echo '>' . $interval_name . '</option>';
  }
  echo '</select>';
}


function poi_select ($the_name="poi_id", $the_value="", $auto_submit=false, $form="blurb_edit_form") {
  $poi_list = get_poi_list ();
  echo '<select name="' . $the_name . '"';
  if ($auto_submit) {
      echo ' onchange="document[\'' . $form . '\'].submit()"';
  }
  echo '>';
  while ($poi = mysql_fetch_array($poi_list)) {
    echo '<option value=' . $poi["poi_id"];
    if ((string)$poi["poi_id"] == (string)$the_value) {
      echo ' SELECTED';
    }
    
    echo '>' . $poi["poi_name"] . '</option>';
  }
  echo '</select>';
  
}

function sign_select ($the_name="sign_id", $the_value="", $auto_submit=false, $form="blurb_edit_form") {
  $sign_list = get_sign_list ();
  echo '<select name="' . $the_name . '"';
  if ($auto_submit) {
      echo ' onchange="document[\'' . $form . '\'].submit()"';
  }
  echo '>';
  while ($sign = mysql_fetch_array($sign_list)) {
    echo '<option value=' . $sign["sign_id"];
    if ((string)$sign["sign_id"] == (string)$the_value) {
      echo ' SELECTED';
    }
    
    echo '>' . $sign["sign_name"] . '</option>';
  }
  echo '</select>';
  
}


//------------Matt Adding HOUSES section

function house_select ($the_name="house_id", $the_value="", $auto_submit=false, $form="blurb_edit_form") {
  $house_list = get_house_list ();
  echo '<select name="' . $the_name . '"';
  if ($auto_submit) {
      echo ' onchange="document[\'' . $form . '\'].submit()"';
  }
  echo '>';
  while ($house = mysql_fetch_array($house_list)) {
    echo '<option value=' . $house["house_id"];
    if ((string)$house["house_id"] == (string)$the_value) {
      echo ' SELECTED';
    }
    
    echo '>' . $house["house_name"] . '</option>';
  }
  echo '</select>';
  
}

function house_select2 ($the_name="house_id2", $the_value="", $auto_submit=false, $form="blurb_edit_form") {
  echo '<select name="' . $the_name . '"';
    if ($auto_submit) {
      echo ' onchange="document[\'' . $form . '\'].submit()"';
    }
   echo '>';
    for($i = 1; $i <= 12; $i++) {
      echo '<option value =' . $i;
      if($i == $the_value) {
        echo ' SELECTED';
      }
        echo '>House' . $i . '</option>';
    }
    echo '</select>';
}

//ENDMATT

function cornerstone_select ($the_name="poi_id", $the_value="", $auto_submit=false, $form="blurb_edit_form") {
  $cornerstone_list = get_cornerstones(4);
  echo '<select name="' . $the_name . '"';
  if ($auto_submit) {
      echo ' onchange="document[\'' . $form . '\'].submit()"';
  }
  echo '>';
  foreach ($cornerstone_list as $cs) {
    $poi_id = get_poi_id (strtoupper($cs));
    echo '<option value=' . $poi_id;
    if ((string)$poi_id == (string)$the_value) {
      echo ' SELECTED';
    }
    
    echo '>' . strtoupper($cs) . '</option>';
  }
  // RULING PLANET TOO
  echo '<option value=-1';
    if ((string)$the_value == "-1") {
      echo ' SELECTED';
    }
    
    echo '>RULING</option>'; 
  echo '</select>';
  
}

function dynamic_select ($the_name="dynamic_id", $the_value="", $auto_submit=false, $form="blurb_edit_form") {
  $dyn_list = get_relationship_list ();
  echo '<select name="' . $the_name . '"';
  if ($auto_submit) {
      echo ' onchange="document[\'' . $form . '\'].submit()"';
  }
  echo '>';
  while ($dyn = mysql_fetch_array($dyn_list)) {
    echo '<option value=' . $dyn["relationship_id"];
    if ((string)$dyn["relationship_id"] == (string)$the_value) {
      echo ' SELECTED';
    }
    
    echo '>' . $dyn["relationship_title"] . '</option>';
  }
  echo '</select>';
  
}

function section_select ($the_name="section_id", $the_value="", $auto_submit=false, $form="blurb_edit_form") {
  $section_list = get_section_list ();
  echo '<select name="' . $the_name . '"';
  if ($auto_submit) {
      echo ' onchange="document[\'' . $form . '\'].submit()"';
  }
  echo '>';
  while ($section = mysql_fetch_array($section_list)) {
    echo '<option value=' . $section["section_id"];
    if ((string)$section["section_id"] == (string)$the_value) {
      echo ' SELECTED';
    }
    
    echo '>' . $section["section_name"] . '</option>';
  }
  echo '</select>';
  
}


function year_select ($the_year, $the_name="") {
  echo '<select name="year_' . $the_name . '" id="year">';
  //for ($x=1900; $x<=(int)date("Y")+5;$x++) {
  for ($x=1900; $x<=2020;$x++) {
    echo '<option value=' . $x;
    if ((int)$the_year == (int)$x) {
      echo ' SELECTED';
    }
    echo '>' . $x . '</option>';
  }
  echo '</select>';
}


function month_select ($the_month, $the_name="") {
  $months = array (1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
  echo '<select name="month_' . $the_name . '" id="month">';
  for ($x=1; $x<=12;$x++) {
    echo '<option value=' . format_piece($x);
    if ((int)$the_month == (int)$x) {
      echo ' SELECTED';
    }
    echo '>' . $months[$x] . '</option>';
  }
  echo '</select>';
}

function day_select ($the_day, $the_name="") {
  echo '<select name="day_' . $the_name . '" id="day">';
  for ($x=1; $x<=31;$x++) {
    echo '<option value=' . format_piece($x);
    if ((int)$the_day == (int)$x) {
      echo ' SELECTED';
    }
    echo '>' . $x . '</option>';
  }
  echo '</select>';
}

function date_select ($the_date, $the_name) {
  month_select ($the_month = (int)date("m", $the_date), $the_name = $the_name);
  day_select ($the_day = (int)date("d", $the_date), $the_name = $the_name);
  year_select ($the_year = (int)date("Y", $the_date), $the_name = $the_name);
}


function hour_select ($the_hour, $the_name="", $greyed=0) {
  echo '<select name="hour_' . $the_name . '" id="hour_' . $the_name . '" ';
  if ((string)$greyed == '1') {
    echo 'DISABLED="true"';
  }
  echo '>';
  for ($x=1; $x <= 12;$x++) {
    echo '<option value=' . format_piece($x);
    if ((int)$the_hour == (int)$x) {
      echo ' SELECTED';
    }
    echo '>' . format_piece($x) . '</option>';
  }
  echo '</select>';
}


function minute_select ($the_minute, $the_name="", $greyed=0) {
  echo '<select name="minute_' . $the_name . '" id="minute_' . $the_name . '" ';
  if ((string)$greyed == '1') {
    echo 'DISABLED="true"';
  }
  echo '>';
  for ($x=0; $x<=59;$x++) {
    echo '<option value=' . format_piece($x);
    if ((int)$the_minute == (int)$x) {
      echo ' SELECTED';
    }
    echo '>' . format_piece($x) . '</option>';
  }
  echo '</select>';
}

function second_select ($the_second, $the_name="", $greyed=0) {
  /*
  echo '<select name="second_' . $the_name . '" id="second_' . $the_name . '" ';
  if ((string)$greyed == '1') {
    echo 'DISABLED="true"';
  }
  echo '>';
  for ($x=0; $x<=59;$x++) {
    echo '<option value=' . format_piece($x);
    if ((int)$the_second == (int)$x) {
      echo ' SELECTED';
    }
    echo '>' . format_piece($x) . '</option>';
  }
  echo '</select>';
  */
  echo '<input type="hidden" name="second_' . $the_name . '" value="00"/>';
}

function meridiem_select ($the_meridiem, $the_name, $greyed=0) {
  echo '<select name="meridiem_' . $the_name . '" id="meridiem_' . $the_name . '" ';
  if ((string)$greyed == '1') {
    echo 'DISABLED="true"';
  }
  echo '>';
  
    echo '<option value="am"';
    if ($the_meridiem == "am") {
      echo ' SELECTED';
    }
    echo '>am</option>';
  
    echo '<option value="pm"';
    if ($the_meridiem == "pm") {
      echo ' SELECTED';
    }
    echo '>pm</option>';
  
  echo '</select>';
}

function time_select ($the_time, $the_name, $greyed) {
  //echo 'Hours:';
  $hour_object = unapply_meridiem(date("H", $the_time));
  hour_select ($the_hour = (int)$hour_object[0], $the_name = $the_name, $greyed);
  //echo 'Minutes:';
  minute_select ($the_minute = (int)date("i", $the_time), $the_name = $the_name, $greyed);
  //echo 'Seconds:';
  second_select ($the_second = (int)date("s", $the_time), $the_name = $the_name, $greyed);
  meridiem_select ($hour_object[1], $the_name, $greyed);
  
}

function gender_select ($the_gender, $the_name="gender") {
  echo '<select name="' . $the_name . '" id="gender_select">';
          echo '<option value="none"';
          if ($the_gender = "") {
            echo "SELECTED";
          }
          echo '>Select a Gender</option>';
          echo '<option value="M"';
          if ($the_gender == "M") {
            echo " SELECTED";
          }
          echo '>Male</option>';
          echo '<option value="F"';
          if ($the_gender == "F") {
            echo " SELECTED";
          }
          echo '>Female</option>';
   echo '</select>';
}

function country_select ($country_id, $the_name="country_id") {
  $country_list = get_country_list ();
  echo '<select name="' . $the_name . '" id="country_id">';
  while ($country = mysql_fetch_array($country_list)) {
    echo '<option value=' . $country["country_id"];
    if ((string)$country["country_id"] == (string)$country_id) {
      echo ' SELECTED';
    }
    
    //echo '>' . ucwords(strtolower($country["country_title"])) . '</option>';
    echo '>' . format_country_name($name = $country["country_title"]) . '</option>';
  }
  echo '</select>';
  
}

function format_country_name ($name) {

  $nocap = array("of", "the", "a", "or", "and");
  $str_arr = explode(" ", $name);
  $string = "";
  foreach($str_arr as $word) {
    $word = strtolower($word);
    if (!in_array($word, $nocap)) {
      $string = $string . ucfirst($word);
    }
    else { 
      $string = $string . $word;
    }
    $string = $string . " "; 
  }
  return trim($string);
}
?>
