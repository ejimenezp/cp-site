/**
 * 
 */
window.$ = window.jQuery = require('jquery')
//require('bootstrap-sass');

///
/// jquery for page slideshows
///
$( document ).ready(function() {

	var currentIndex = 0,
	items = $('.cp-slideshow div'),
	itemAmt = items.length;
	
	function cycleItems() {
	var item = $('.cp-slideshow div').eq(currentIndex);
	items.hide();
	item.css('display','inline-block');
	}
	
	var autoSlide = setInterval(function() {
	currentIndex += 1;
	if (currentIndex > itemAmt - 1) {
	  currentIndex = 0;
	}
	cycleItems();
	}, 4000);

});

