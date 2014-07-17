$(document).ready(function(){
          
          if ($('input[name=country_id]').val() == 236) {
            $("#js_zip_div").show();
            $("#location_verification").css('visibility', 'visible');
            $("#js_city_div").hide();
          }
          else {
            $("#js_zip_div").hide();
            $("#location_verification").css('visibility', 'hidden'); 
            $("#js_city_div").show();
          }
    $("select[name=js_country_id]").change(function(event) { 
            //alert ("stuff");
            if ($("select[name=js_country_id]").val() == "236") {
                $("#js_zip_div").show();
                $("#location_verification").css('visibility', 'visible');
                $("#js_city_div").hide();
        
            }
            else {
              $("#js_zip_div").hide();
              $("#location_verification").css('visibility', 'hidden');
              $("#js_city_div").show();
            }
          });
  });