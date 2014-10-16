$(document).ready(function(){

	function msieversion() {

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer, return version number
            //alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
        	alert('Certain parts of Starma.com may not load properly on older versions of Internet Explorer.  For a more enjoyable experience we recommend using a recent version of Firefox or Chrome.  Thank you! :)');
        else                 // If another browser, return 0
            //alert('otherbrowser');
        	//alert('Certain versions of Internet Explorer will have difficulty loading portions of Starma.com.  For a more enjoyable experience we recommend using recent version of Firefox.  Thank you!');

   		return false;
	}

	msieversion();

});