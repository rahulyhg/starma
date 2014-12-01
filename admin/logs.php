<?php 

 require_once ("../header.php");
 //require_once ("db_connect.php");

  if (!isAdmin()) {
    header( 'Location: http://www.' . get_domain() . '/' . get_landing());
  }  
  else {
    echo '<body>';
    
    echo '<div class="page_title">Log Reports</div>';
    echo '<br><hr><br>';
    echo 'Filters:';
    echo '<form name="log_filters" method="post" action="logs.php">';
    echo 'User:';
    echo 'Start Date:' . date_select (time(), 'start');
    echo 'End Date:' . date_select (time(), 'end');
    echo '<input type="submit" name="submit" value="Query"/>';
    echo '</form>';
    echo '<br><br>';
    echo '<a href="../">Go Back To Chart Management</a>';
    echo '</body>';
    echo '<hr>';
    if (isset($_POST["submit"])) {
      $start_date = $_POST['year_start'] . $_POST['month_start'] . $_POST['day_start'];
      $end_date = $_POST['year_end'] . $_POST['month_end'] . $_POST['day_end'];
      $the_logs = get_logs($start_date, $end_date);
      $num_rows = mysql_num_rows($the_logs);
      echo '<table id="log_table">';
      echo '<tr>';
        echo '<th>Date</th>';
        //echo '<th>Time</th>';
        echo '<th>User ID</th>';
        echo '<th>Username</th>';
        echo '<th>User</th>';
        echo '<th>IP</th>';
        echo '<th>Action</th>';
        echo '<th>Details</th>';
      echo '</tr>';
      while ($row = mysql_fetch_array($the_logs)) {
        echo '<tr>';
          echo '<td>' . get_date_from_int($row['date']) . '</td>';
          //echo '<td>' . get_time_from_int($row['time']) . '</td>';
          if ($user = get_just_user_from_id ($row['user_id'])) {
            echo '<td>' . $user['user_id'] . '</td>';
            echo '<td>' . $user['nickname'] . '</td>';
            echo '<td>' . $user['first_name'] . ' ' . $user['last_name'] . '</td>';  
          }
          else {
            if ($row['user_id'] == -1) {
              echo '<td>GUEST</td>';
              echo '<td>NA</td>';
              echo '<td>NA</td>';
            }
            else {

              echo '<td style="color:red">' . $row['user_id'] . '</td>';
              echo '<td style="color:red">UNAVAIABLE</td>';
              echo '<td style="color:red">UNAVAIABLE</td>';
            }
          }
          echo '<td>' . $row['user_ip'] . '</td>';
          echo '<td>' . $row['log_action'] . '</td>';
          echo '<td>' . $row['log_sub_action'] . ' ' . $row['log_basic_action'] . '</td>';
          
        echo '</tr>';
      }
      echo '</table>';   

      echo 'Total Rows Found: ' . $num_rows;
    }
  }

   require_once ("../footer.php");
  
?>