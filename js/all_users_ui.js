$(document).ready(function(){

	   $('#js_search_bar').focus(function(){
              var value = $(this).val();
              if( value == 'Search' ) {
                $(this).val('');
                $(this).css('color', 'black');
              }
           });
            
            $('#js_search_bar').blur(function(){
              var value = $(this).val();
              if( value == '' ) {
                $(this).val('Search');
                $(this).css('color', '#c0c0c0');
              }
           });

});