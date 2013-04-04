<?php 
include ('include/math.functions.inc.php');
include ('include/display.functions.inc.php');
include ('include/datetimelocation.functions.inc.php');
error_reporting(E_ALL); 
ini_set('display_errors', 'on'); 
 
?> 

<form method="post" action="test_geo_code.php">
  Address: <input type="text" name="address" value="<?php echo $_POST['address'];?>"><br><br>
  Date: <input type=text" name="date" value="<?php echo $_POST['date'];?>"><br><br>
  <input type="submit" name="submit" value="Get Coordinates">  
</form>

<?php

if (isset($_POST["address"])) {
  
  if ($coords = get_coordinates($_POST["address"])) {
    //echo '<br>' . $coords['lat'] . '<br>';
    //echo $coords['lng'] . '<br>';
    $lat = reformat_coordinate($coords['lat'], 'lat');
    $lng = reformat_coordinate($coords['lng'], 'lng');
    $title = $coords['title'];
    echo 'Location: ' . $title . '<br>';
    echo 'Latitude: ' . $lat[1] . ' ' . $lat[0] . '<br>';
    echo 'Longitude: ' . $lng[1] . ' ' . $lng[0] . '<br>';
  
    $timezone = timezone($coords['lat'], $coords['lng']);
    echo 'GMT Offset:  ' . abs((float)$timezone["offset"]) . '<br>';
    echo 'Timezone:  ' . $timezone["tID"] . '<br>'; 


    $DST = DST($timezone_id = $timezone["tID"], $date = $_POST["date"]);  


    echo 'DST:' . $DST . '<br>';

    //echo $birthDate->format('Y-m-d H:i:sP') . '<br>';
  }
  else { 
    echo 'Location Not Found.  Please Try Again.  Make sure the location is spelled correctly.';
  }


  //echo timezoneDoesDST($_POST["address"]);
}
?>