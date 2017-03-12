<?php
/*	zpBase Smooth DIV Scroll JS include 
*	This file is included when a page requires the Smooth DIV Scroll script
*	http://www.oswebcreations.com
================================================== */
?>
<script src="<?php echo $_zp_themeroot; ?>/js/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo $_zp_themeroot; ?>/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo $_zp_themeroot; ?>/js/jquery.mousewheel.min.js" type="text/javascript"></script>
<script src="<?php echo $_zp_themeroot; ?>/js/jquery.kinetic.min.js" type="text/javascript"></script>
<script src="<?php echo $_zp_themeroot; ?>/js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
<script>
var $container = $("#makeMeScrollable").css({opacity:0});
var $spinner = $('#spinner').css({opacity:1});
$(document).ready(function(){ 
	resizeDiv();
	window.onresize = function(event) {
		resizeDiv();
	}
	function resizeDiv() {
		vpw = $(window).width();
		vph = $(window).height()*(.50);
		if (vph > <?php echo getOption('zpbase_sds_maxheight'); ?>) { vph = <?php echo getOption('zpbase_sds_maxheight'); ?>; }
		$('#makeMeScrollable').css({'height': vph + 'px'});
	}
    $container.imagesLoaded(function(){
		$container.smoothDivScroll({
			<?php if (($isMobile) || ($isTablet)) { ?>
			hotSpotScrolling: false,
			touchScrolling: true,
			<?php } ?>
			autoScrollingMode: "onStart",
			manualContinuousScrolling: true
		});
		$container.animate({opacity: 1});
		$spinner.animate({opacity: 0});
	});
});
</script>
