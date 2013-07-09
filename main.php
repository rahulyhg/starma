<?php
require_once ("header.php");

  
login_check_point($type="full");

if (!isset($_GET["the_page"])) {
  $the_page = "hsel";
}
else {
  $the_page = $_GET["the_page"];
}

 $left_menu = get_left_menu ($the_page = $the_page);

 $hsel = "";
 $psel = "";
 $csel = "";
 $cosel = "";
 $isel = "";


 $$the_page = "selected";

if (!isset($_GET["the_left"])) {
  $the_left = "nav1";
}
else {
  $the_left = $_GET["the_left"];
}

if ($the_left=="nav1") {
  clean_session();
  clear_compare_data();
}

//if ($the_page == "psel" and !is_my_profile_done()) {
//  $the_left = get_my_profile_step();
//}

 $nav1 = "";
 $nav2 = "";
 $nav3 = "";
 $nav4 = "";
 $nav5 = "";
 $nav6 = "";

 $$the_left = "selected";
 if (isset($_GET["chart_id2"])) {
   $chart_id2_holder = $_GET["chart_id2"];
 }
 elseif (isset($_POST["chart_id2"])) {
   $chart_id2_holder = $_POST["chart_id2"];   
 }
 elseif (isset($_SESSION['compare_chart_ids'])) {
   $chart_id2_holder = $_SESSION['compare_chart_ids'][1];
   
 }
 else {
   $chart_id2_holder = -1;
 }
 if ($chart_id2_holder != -1) {
   
   if (isCeleb(get_user_id_from_chart_id($chart_id2_holder))) {
      
      $$the_left = "";
      $nav3 = "selected";  
   }
 }
 

?> 

<!-- Include he following conditional to get click-throughs to work with IE -->
    
    <!--[if IE]>
      <style type="text/css">
 
        .circle_hilite {
          filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/img/arrows/RedCircle_chart.png', sizingMethod='scale');
          background:none !important;
        }
 
        </style>
    <![endif]-->
    
<body>
<div id="img_preloader">

  

  <img src="/img/Starma-Astrology-SideNav1.png"/>
  <img src="/img/Starma-Astrology-SideNav2.png"/>
  <img src="/img/Starma-Astrology-SideNav3.png"/>
  <img src="/img/Starma-Astrology-SideNav4.png"/>
  <img src="/img/Starma-Astrology-SideNav5.png"/>
  <img src="/img/Starma-Astrology-SideNav6.png"/>

  <img src="/img/Starma-Astrology-SideNav1On.png"/>
  <img src="/img/Starma-Astrology-SideNav2On.png"/>
  <img src="/img/Starma-Astrology-SideNav3On.png"/>
  <img src="/img/Starma-Astrology-SideNav4On.png"/>
  <img src="/img/Starma-Astrology-SideNav5On.png"/>
  <img src="/img/Starma-Astrology-SideNav6On.png"/>

  <img src="/img/sign_buttons/Starma-Astrology-Aries-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Taurus-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Gemini-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Cancer-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Leo-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Virgo-ON.png"/>

  <img src="/img/sign_buttons/Starma-Astrology-Libra-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Scorpio-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Sagittarius-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Capricorn-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Aquarius-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Pisces-ON.png"/>

  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Aquarius-Leo-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Cancer-Capricorn-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Aries-Libra-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Capricorn-Cancer-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Gemini-Sagittarius-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Leo-Aquarius-ON.png"/>

  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Libra-Aries-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Pisces-Virgo-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Sagittarius-Gemini-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Scorpio-Taurus-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Taurus-Scorpio-ON.png"/>
  <img src="/img/sign_buttons/Starma-Astrology-Rahu-Ketu-Virgo-Pisces-ON.png"/>

  <img src="/img/Starma-Astrology-CelebritiesBoxH.png"/>
  <img src="/img/Starma-Astrology-ProfileBoxH.png"/>
  <img src="/img/Starma-Astrology-ChartBoxH.png"/>
  <img src="/img/Starma-Astrology-CompareBoxH.png"/>   
   
</div>

<div id="frame">
  <div id="topnav">
    <ul>
      <li class="logo"><a href="#"></a></li>
      <li class="home_link <?php echo $hsel;?>"><a title="Home" href="?the_page=hsel&the_left=nav1"></a></li>
      <li class="profile_link <?php echo $psel;?>"><a title="Profile" href="?the_page=psel&the_left=nav1"></a></li>
      <li class="chart_link <?php echo $csel;?>"><a title="Chart" href="?the_page=csel&the_left=nav1"></a></li>
      <li class="compare_link <?php echo $cosel;?>"><a title="Compare" href="?the_page=cosel&the_left=nav1&the_tier=1"></a></li>
      <li class="inbox_link <?php echo $isel;?>"><a title="Inbox" href="?the_page=isel&the_left=nav1"></a></li>
      <li class="mail_area"><img src="img/top_nav_shorter/Starma-Astrology-SearchBar.png"/></li>
    </ul>
  </div>

  <div id="sidenav">
    <ul>
      
      <li class="sidenav1 <?php echo $nav1;?> <?php echo menu_status($left_menu['nav1'][1]);?>"><a href="?the_left=nav1&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav1'][0];?></a></li>
      <li class="sidenav2 <?php echo $nav2;?> <?php echo menu_status($left_menu['nav2'][1]);?>"><a href="?the_left=nav2&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav2'][0];?></a></li>
      <li class="sidenav3 <?php echo $nav3;?> <?php echo menu_status($left_menu['nav3'][1]);?>"><a href="?the_left=nav3&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav3'][0];?></a></li>
      <li class="sidenav4 <?php echo $nav4;?> <?php echo menu_status($left_menu['nav4'][1]);?>"><a href="?the_left=nav4&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav4'][0];?></a></li>
      <li class="sidenav5 <?php echo $nav5;?> <?php echo menu_status($left_menu['nav5'][1]);?>"><a href="?the_left=nav5&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav5'][0];?></a></li>
      <li class="sidenav6 <?php echo $nav6;?> <?php echo menu_status($left_menu['nav6'][1]);?>"><a href="?the_left=nav6&the_page=<?php echo $the_page;?>"><?php echo $left_menu['nav6'][0];?></a></li>
 
      <li class="bar_line"><img src="/img/Starma-Astrology-SideNav7.png"/></li>
    </ul>
  </div>
 
  <div id="logout_link">
    <!--<a href="/logout.php">Logout</a>-->
    <?php show_account_menu()?>
  </div>
 
  <div id="page_body">
    <?php
      if ($left_menu[$the_left][1] != '#') {
         require($left_menu[$the_left][1]);
      }
      
    ?>
  </div>
  
</div>

<?php
 require_once "footer.php";
?> 
</body>