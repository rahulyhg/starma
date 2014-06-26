/* page scrolling
================================================== */

// scroll to #hash when a nav link is clicked
$("nav a").on('click', function(){

	var self = $(this),
		li = self.parent('li').index();

	$('body, html').animate({scrollTop:$(this.hash).offset().top}, 700);

	return false;
});

// change .active li when page scrolls
$(window).scroll(function() {

    var scrollTo = $(window).scrollTop(),
    	height = $(window).height();




	        $('article > section').each(function(i) {

	            if ($(this).position().top <= scrollTo) {

	                $('nav li.active').removeClass('active');
	                $('nav li').eq(i).addClass('active');

	            }

	        });

}).scroll();

$(document).ready(function() {

	prettyPrint();

});