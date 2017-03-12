<?php
/*	zpBase Masonry JS include 
*	This file is included when a page requires the Masonry script
*	http://www.oswebcreations.com
================================================== */
?>
<script src="<?php echo $_zp_themeroot; ?>/js/masonry.pkgd.min.js"></script>
<script src="<?php echo $_zp_themeroot; ?>/js/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo $_zp_themeroot; ?>/js/jquery.infinitescroll.min.js"></script>
<?php if ((getOption('zpbase_iscrollbehavior')) == 'manual-first') { ?><script src="<?php echo $_zp_themeroot; ?>/js/jquery.infinitescroll.sr.js"></script><?php } ?>
<?php if ((getOption('zpbase_iscrollbehavior')) == 'manual-always') { ?><script src="<?php echo $_zp_themeroot; ?>/js/jquery.infinitescroll.manual-trigger.js"></script><?php } ?>

<script>

var $container = $('#masonry-style').css({opacity:0});
var $spinner = $('#spinner').css({opacity:1});
$(document).ready(function(){ 
    $container.imagesLoaded(function(){
		$container.masonry({
			columnWidth: '.masonry-style-item',
			itemSelector: '.masonry-style-item'
		});
		$container.animate({opacity: 1});
		$spinner.animate({opacity: 0});
	});
    $container.infinitescroll({
		navSelector  : '#page-nav-mas', 
		nextSelector : '#page-nav-mas a',
		<?php if ((getOption('zpbase_iscrollbehavior')) == 'manual-first') { ?>behavior:'simplyrecipes',<?php } ?>
		<?php if ((getOption('zpbase_iscrollbehavior')) == 'manual-always') { ?>behavior:'twitter',<?php } ?>
		itemSelector : '.masonry-style-item',  
		loading: {
			finishedMsg: '<?php echo gettext('No more items to load.'); ?>',
			msg: null,
			msgText: '<?php echo gettext('Loading...'); ?>',
			<?php if ((getOption('zpbase_style')) == 'dark') { ?>
			img: '<?php echo $_zp_themeroot; ?>/images/classic-loader.gif'
			<?php } else { ?>
			img: '<?php echo $_zp_themeroot; ?>/images/classic-loader-invert.gif'
			<?php } ?>
        }
    },
    function( newElements ) {
        var $newElems = $( newElements ).css({ opacity: 0 });
        $newElems.imagesLoaded(function(){
			$(".masonry-style-padding img").addClass("remove-attributes");
			$newElems.animate({ opacity: 1 });
			$container.masonry( 'appended', $newElems, true ); 
			<?php if (getOption('zpbase_magnific_target') == 'imagepage') { ?>
			$('a.masonry-image-popup').magnificPopup({
				type: 'iframe'
			});
			<?php } else { ?>
			$('a.masonry-image-popup').magnificPopup({
				type: 'image',
				closeOnContentClick: false,
				closeBtnInside: true,
				mainClass: 'mfp-with-zoom mfp-img-mobile',
				image: {
					verticalFit: true,
					<?php if (getOption('zpbase_nodetailpage')) { ?>
					titleSrc: function(item) {
						return item.el.attr('title');
					}
					<?php } else { ?>
					titleSrc: function(item) {
						return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'"><?php echo gettext('image details'); ?>&nbsp;&rarr;</a>';
					}
					<?php } ?>
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
			<?php } ?>
        });
      }
    );
	
	<?php if (getOption('zpbase_magnific_target') == 'imagepage') { ?>
	$('a.masonry-image-popup').magnificPopup({
		type: 'iframe'
	});
	<?php } else { ?>
	$('a.masonry-image-popup').magnificPopup({
		type: 'image',
		closeOnContentClick: false,
		closeBtnInside: true,
		mainClass: 'mfp-with-zoom mfp-img-mobile',
		image: {
			verticalFit: true,
			<?php if (getOption('zpbase_nodetailpage')) { ?>
			titleSrc: function(item) {
				return item.el.attr('title');
			}
			<?php } else { ?>
			titleSrc: function(item) {
				return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'"><?php echo gettext('image details'); ?>&nbsp;&rarr;</a>';
			}
			<?php } ?>
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
	<?php } ?>
});

</script>