<?php
require_once "header.php"; 
?>



 <div id="welcome">
 <?php
  if (!get_my_chart()) {
    $no_chart = true;
  }
 //echo my_compare_flag();
  /*
    echo '<script>
      $(document).ready(function(){
        $("#tfb").click(function(event){
          event.preventDefault();
          var data = {"test" : "test"};
          $.ajax({
            type: "POST",
            url: "/chat/test_fb_insert.php",
            data: data,
            dataType: "json"
          })
          .done(function(data){
            if (data.errors) {
              if (data.errors.update) {
                console.log(data.errors.update);
              }
              if (data.errors.get) {
                console.log(data.errors.get);
              }
            }
            if (data.fb_id) {
              console.log(data.fb_id);
            }            
          });
        });
      });
    </script>';
     echo '<div id="tfb">fb test</div>';
     echo $_SESSION['fb_id'];
    */
    if (!$no_chart) {
      $chart_id1 = get_my_chart_id();
      $match = get_my_single_suggested_match();
      $isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($match['chart_id2'])));
      if ($isCeleb) {
        $match_name = get_first_name(get_user_id_from_chart_id($match['chart_id2'])) . ' ' . get_last_name(get_user_id_from_chart_id($match['chart_id2']));
      }
      else {
        $match_name = get_nickname(get_user_id_from_chart_id($match['chart_id2']));
      }
    }
     
 ?>
    <!--<?php flare_title();?>-->
    <div class="later_on welcome_text">
      Welcome to Starma!  Our site is still in development, so please <a href="mailto:contact@starma.com">contact us</a> if you encounter any problems.  Below are some of the ways you can get started.
    </div>
 
    <div id="suggested_match_link" class="homepage_div">
      <span class="header">Compatibility</span>
      <?php
        echo '<a class="box_link" href="';
          if ($no_chart) {
            echo '#" class="no_chart"';
          }
          else {
            if ($isCeleb) {
              echo 'main.php?the_page=cesel&the_left=nav1&tier=3&stage=2chart_id1=' . get_my_chart_id() . '&chart_id2=' . $match["chart_id2"] . '"';
            }
            else {
              echo 'main.php?the_page=cosel&the_left=nav1&tier=3&stage=2chart_id1=' . get_my_chart_id() . '&chart_id2=' . $match["chart_id2"] . '" title="You and ' . $match_name . '"';
            }
          }
        echo '></a>';
      ?>
      
      <div id="homepage_suggested_match_button">

      <?php
      
        if ($no_chart) {
          echo 'Enter your birth info to get your matches...';
        }
        else {
          //echo 'Match: <br>';
          //print_r($match);
          show_compare_results_homepage($chart_id1, $match['chart_id2'], $match['score']);

          echo '<div id="sample_compare_text">Compatibility is not just for romance! Test your compatibility with your friends and family for all kinds of fun insights...</div>';
        }

        if ($no_chart) {
          echo '';
        }
        else {
          echo '<div id="p_box_blurb"><p class="hsel_box_blurb">See your compatibility with ' . $match_name . '...</p></div>';
        }
        
      ?>

        

        <!--<div class="photo_border_wrapper_compare">
          <div class="compare_photo">   
            <?php 
              show_user_compare_picture ('', get_my_user_id()); 
            ?>
        </div>
        
        <?php //show_descriptors_info(get_my_chart_id()); 
            show_my_descriptors_info_home();
        ?>  
      </div>-->  
    </div>
    </div>
    <div id="community_box_link" class="homepage_div">
      <span class="header">Explore the Community</span>
      <a class="box_link" href="main.php?the_page=cosel&the_left=nav1&tier=1"></a>
      <div id="homepage_thumbnails">
        <?php
          display_welcome_page_thumbnails($celebs=0);
        ?>
      </div>
      <div id="co_box_blurb"><p class="hsel_box_blurb">Make connections and test compatability...</p></div>
    </div>
    <div id="horoscope_box_link" class="homepage_div">
      <span class="header">Read Your Birth Chart</span>
      
        <?php
        echo '<a class="box_link" href="main.php?the_page=psel&the_left=nav1"></a>
                <div id="homepage_chart_button_info">';
          if (!get_my_chart()) {
            echo '<div id="enter_birth_time_square"><img src="/img/EnterBirthTimeSquare.png"/></div>';
            //echo '<div id="enter_birth_time_square_link">Enter My Birth Time</div>';
          }
          else {
            $button_sign_id = get_sign_from_poi (get_my_chart_id(), 1);
            echo '<ul>';
            echo '  <li class="' . get_selector_name($button_sign_id) . ' selected"><span class="icon"><div class="poi_title">' . get_poi_name(1) . '</div></span></li>';
            echo '</ul>';
            echo '<div id="blurb">';
              show_poi_sign_blurb_abbr (1, $button_sign_id);
            echo '</div>';
          }
          
        ?>
        <div id="h_box_blurb"><p class="hsel_box_blurb">Learn details about your Sun Sign and more...</p></div>
      </div>
    </div>
    <div id="celebrities_box_link" class="homepage_div">
      <span class="header">Browse Celebrities</span>
      <a class="box_link" href="main.php?the_page=cesel&the_left=nav1&tier=1"></a>
      <div id="homepage_thumbnails">
        <?php
          display_welcome_page_thumbnails(1);
        ?>
      </div>
      <div id="ce_box_blurb"><p class="hsel_box_blurb">See what you have in common with the stars...</p></div>
    </div>
 </div> 

