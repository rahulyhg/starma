<?php 
 // hello world
 require_once ("../header.php");
 //require_once ("db_connect.php");

  if (!isAdmin()) {
    header( 'Location: http://www.' . get_domain() . '/' . get_landing());
  }  
  else {
    if (!isset($_POST['submit'])) {
      $date = time();
      $threshold = date('YmdHis', mktime('00', '00', '00', date("m"), date("d"), date("Y"))); 
    }
    else {
      $threshold = $_POST['year_threshold'] . $_POST['month_threshold'] . $_POST['day_threshold'] . '000000';
      $date = mktime(0,0,0, $month=$_POST['month_threshold'], $day=$_POST['day_threshold'], $_POST['year_threshold']);
      
    }

    echo '<body>';    
    echo '<div class="page_title" style="font-weight:bold;font-size:1.5em">ONLINE STATS</div>';
    //echo $threshold . '<br>';
    //echo date('Ymd', $date) . '<br>';
    //echo 'Right Now: ' . date('YmdHis', time()) . '<br>';
    echo '<br><hr><br>';
    $users_online = users_online();
    $users_online_since = users_logged_since($threshold);
    echo '<form name="threshold_set" method="post" action="online.php">';
    echo 'Number of users Currently Online: <a href="" onclick="$(\'#users_online\').toggle(); return false;">' . sizeof($users_online) . '</a><br>';
    echo 'Number of users Who Logged in Since ';
    echo date_select ($date, 'threshold');
    echo ': <a href="" onclick="$(\'#users_online_since\').toggle(); return false;">' . sizeof($users_online_since) . '</a><br>';
    echo '<input type="submit" name="submit" value="Set Threshold"/>';

    echo '<div id="users_online" style="display:none; padding-top:40px;">';
      echo '<b>USERS ONLINE RIGHT NOW</b><Br>';
      for ($x=0; $x<sizeof($users_online); $x++) {
        $user = $users_online[$x];
        $user_id = $user['user_id'];
        if (is_online($user_id)) {$online_color = 'green';} elseif (is_away($user_id)) {$online_color = 'orange';} else {$online_color = 'red';} 
        echo '<span style="color:' . $online_color . '; font-family:arial;">•</span>';
        $name = $user['first_name'] . ' ' . $user['last_name'];
        if (trim($name) == "") {
          $name = "[No First or Last Name Entered]";
        }
        echo $user['nickname'] . ' --> ' . $name;
        echo '<br>';
      }
    echo '</div>';
   
    echo '<div id="users_online_since" style="display:none; padding-top:40px">';
      echo '<span style="font-weight:bold">USERS LOGGED IN SINCE ' . get_date_from_int(date('Ymd', $date)) . '</span><Br>';
      for ($x=0; $x<sizeof($users_online_since); $x++) {
        $user = $users_online_since[$x];
        $user_id = $user['user_id'];
        if (is_online($user_id)) {$online_color = 'green';} elseif (is_away($user_id)) {$online_color = 'orange';} else {$online_color = 'red';} 
        echo '<span style="color:' . $online_color . '; font-family:arial;">•</span>';
        $name = $user['first_name'] . ' ' . $user['last_name'];
        if (trim($name) == "") {
          $name = "[No First or Last Name Entered]";
        }
        echo $user['nickname'] . ' --> ' . $name;
        echo '<br>';
      }
    echo '</div>';
  }

  require_once ("../footer.php");
  
?>