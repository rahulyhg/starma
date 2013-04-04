<?php

 require_once ("header.php");

if (isLoggedIn())
{
    if (isset($_GET["chart_id1"]) and isset($_GET["chart_id2"])) {
       $chart_id1 = $_GET["chart_id1"];
       $chart_id2 = $_GET["chart_id2"];
    }
    elseif (isset($_POST["chart_id1"]) and isset($_POST["chart_id2"])) {
       $chart_id1 = $_POST["chart_id1"];
       $chart_id2 = $_POST["chart_id2"];
    }
    else {
      $chart_id1 = -1;
      $chart_id2 = -1;
    }
    //echo $chart_id1 . '<br>';
    //echo $chart_id2 . '<br>';
    echo '<form name="compareform" action="compare_chart.php" method="post">';
      echo '<div class="dropdown firstdropdown">';
        echo 'Person A: ';
        chart_dropdown ($name='chart_id1', $value=$chart_id1);
      echo '</div>';
      echo '<div class="dropdown seconddropdown">';
        echo 'Person B: ';
        chart_dropdown ($name='chart_id2', $value=$chart_id2);
      echo '</div><br>';
      echo '<input type="submit" name="submit" value="Compare"/>';
      if ($chart_id1 != -1 and $chart_id2 != -1) {
        $chart1 = get_chart($chart_id1);
        $chart2 = get_chart($chart_id2);
        echo '<br><br>';
        echo '<b>' . $chart1["nickname"] . '</b> compared to <b>' . $chart2["nickname"] . '</b>';
        echo '<br><br>';
        generate_compare_data ($chart_id1, $chart_id2);
        compare_charts ($compare_results = $_SESSION["compare_data"]);
      }
    echo '<form>';
    echo '<br><br>';
    echo '<b><a style="font-size:1.5em" href="index.php">Go Back to Chart Entry Page</a></b>';

}
?> 
