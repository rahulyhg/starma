<?php
require_once("ajax_header.php");
    //IS THIS LOGIN POINT NECESSARY?
    //$logged_in = login_check_point($type="full");

    
    $data = array();
    if(isset($_POST["sign_id"]))   {
        $sign_id = true;
        $posted = $_POST["chart_id"] + $_POST["poi_id"] + $_POST["sign_id"];
    }
    else {
        $posted = $_POST["chart_id"] + $_POST["poi_id"] + $_POST["sign_id1"] + $_POST["sign_id2"];
        $sign_id = false;
    }

if (preg_match('%[0-9]+%', $posted)) {
    $data["poi_id"] = $_POST["poi_id"];
    $data["poi_name"] = get_poi_name($_POST["poi_id"]);
    $data["chart_id"] = $_POST["chart_id"];
    $data["poi_info"] = get_poi_blurb ($_POST["poi_id"]);
        
        if($sign_id == true) {
            $data["sign_id"] = $_POST["sign_id"];
            $data["sign_name"] = get_sign_name ($_POST["sign_id"]);
            $data["blurb"] = get_poi_sign_blurb ($_POST["poi_id"], $_POST["sign_id"]);
            //echo $data["blurb"];
            if($data['poi_id'] == 1) {
                $data["poi_in_sign"] = '<strong>' .  ucfirst(strtolower($data["sign_name"])) . ' ' . ucfirst(strtolower($data["poi_name"])) . ': </strong>';
            }
            else {
                $data["poi_in_sign"] = '<strong>' .  ucfirst(strtolower($data["poi_name"])) . ' in ' . ucfirst(strtolower($data["sign_name"])) . ': </strong>';
            }
        }
        else {
            $data["sign_id1"] = $_POST["sign_id1"];
            $data["sign_id2"] = $_POST["sign_id2"];
            $data["sign_name1"] = get_sign_name ($_POST["sign_id1"]);
            $data["sign_name2"] = get_sign_name ($_POST["sign_id2"]);
            $data["blurb"] = get_poi_sign_blurb ($_POST["poi_id"], $_POST["sign_id1"]);
            //echo $data["blurb"];
            $ketu = ($data["poi_id"]+1);
            $data["poi_in_sign"] = '<strong>' . ucfirst(strtolower($data["poi_name"])) . ' in ' . ucfirst(strtolower($data["sign_name1"]));
            $data["poi_in_sign2"] = ' & ' . ucfirst(strtolower(get_poi_name($ketu))) . ' in ' . ucfirst(strtolower(get_sign_name (get_sign_from_poi ($data["chart_id"], 10)))) . ': </strong>';
        }
            
    echo json_encode($data);
  		
    }
    else {
        return false;
    }

   

?>