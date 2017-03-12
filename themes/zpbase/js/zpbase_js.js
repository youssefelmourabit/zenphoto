$(document).ready(function(){

	$(".imageFavorites input").removeClass("button");
	$(".masonry-style-padding img").addClass("remove-attributes");
	$(".blog-style-padding img").addClass("remove-attributes");
	$(".page-news-full img").addClass("remove-attributes");
	$("#relateditems img").addClass("remove-attributes");
	$(".album-thumb img").addClass("remove-attributes");
	
	$('.popup-page').magnificPopup({
		type: 'iframe'
	});
	
	$('a.image-popup').magnificPopup({
		type: 'image',
		closeOnContentClick: false,
		closeBtnInside: true,
		mainClass: 'mfp-with-zoom mfp-img-mobile',
		image: {
			verticalFit: true,
			titleSrc: function(item) {
				return item.el.attr('title');
			}
		},
		gallery: {
			enabled: true,
			preload: [1,2],
		},
		zoom: {
			enabled: true,
			duration: 300, // don't foget to change the duration also in CSS
			opener: function(element) {
				return element.find('img');
			}
		}	
	});
	$('.inline-popup').magnificPopup({type:'inline'});
	$('.video-popup').magnificPopup({
		//disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	});
	$('img.remove-attributes').each(function(){
        $(this).removeAttr('width')
        $(this).removeAttr('height');
    });

	$('.textobject').each(function(){
        $(this).removeAttr('style');
    });
	
	$( document ).keydown( function( e ) {
		var url = false;
		if ( e.which == 37 ) {  // Left arrow key code
			url = $( 'a.prev-link' ).attr( 'href' );
		}
		else if ( e.which == 39 ) {  // Right arrow key code
			url = $( 'a.next-link' ).attr( 'href' );
		}
		if ( url && ( !$( 'textarea, input' ).is( ':focus' ) ) ) {
			window.location = url;
		}
	});
  
	// scroll to top, 200 is amount of pixels scrolled for link to appear
	$(window).scroll(function(){
		if ($(this).scrollTop() > 200) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
  
  
});
