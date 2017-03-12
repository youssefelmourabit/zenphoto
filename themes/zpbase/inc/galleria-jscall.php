<?php
/*	zpBase Galleria JS include 
*	This file is included when a page requires the Galleria script
*	http://www.oswebcreations.com
================================================== */
?>
<script src="<?php echo $_zp_themeroot; ?>/js/galleria-1.3.5.min.js"></script>
<script src="<?php echo $_zp_themeroot; ?>/js/galleria.classic.min.js"></script>
<?php if (getOption('zpbase_galhistory')) { ?><script src="<?php echo $_zp_themeroot; ?>/js/galleria.history.min.js"></script><?php } ?>			
				
<script>
	Galleria.run('#galleria', {
		dataSource: data,
		<?php if ($sspage) { ?>
		clicknext: <?php if (getOption('zpbase_nodetailpage')) { echo 'true'; } else { echo 'false'; } ?>,					
		autoplay: <?php if (is_numeric(getOption('zpbase_galinterval'))) { echo getOption('zpbase_galinterval'); } else { echo '4000'; } ?>,
		show: <?php echo $imagenumber; ?>,
		<?php } else { ?>
		clicknext: <?php if (getOption('zpbase_galclicknext')) { echo 'true'; } else { echo 'false'; } ?>,					
		autoplay: <?php if (getOption('zpbase_galautoplay') && (is_numeric(getOption('zpbase_galinterval')))) { echo getOption('zpbase_galinterval'); } elseif (getOption('zpbase_galautoplay')) { echo '4000'; } else { echo 'false'; } ?>,
		height: 0.81,
		<?php } ?>
		<?php if ($isMobile) { ?>
		thumbnails: false,
		carousel: false,
		imageCrop: false,
		
		<?php } else { ?>
		thumbnails: 'lazy',
		imageCrop: '<?php echo getOption('zpbase_galcropop'); ?>',
		<?php } ?>
		transition: '<?php echo getOption('zpbase_galtrans'); ?>',
		transtionSpeed: <?php if (is_numeric(getOption('zpbase_galtranspeed'))) { echo getOption('zpbase_galtranspeed'); } else { echo '500'; } ?>,
		debug: false,
		<?php if (getOption('zpbase_galpan')) echo 'imagePan: \'true\','; ?>
		thumbQuality: 'auto',
		touchTransition: 'slide',
		responsive: true,
		extend: function() {
			<?php if ( ($isMobile) || ($isTablet) ) { ?>
			$('#galleria-control-fullscreen').css('display','none');
			$('#galleria-control-play').css('display','none');
			$('#galleria-control-pause').css('display','none');
			<?php } else { ?>
			$('#galleria-control-fullscreen').click(this.proxy(function(e) {
				e.preventDefault();
				this.toggleFullscreen();
			}));
			$('.galleria-image-nav-left').click(this.proxy(function(e) {
				e.preventDefault();
				this.pause();
				$('#galleria-control-play').css('display','block');
				$('#galleria-control-pause').css('display','none');
			}));
			$('.galleria-image-nav-right').click(this.proxy(function(e) {
				e.preventDefault();
				this.pause();
				$('#galleria-control-play').css('display','block');
				$('#galleria-control-pause').css('display','none');
			}));
			$('.galleria-image').click(this.proxy(function(e) {
				e.preventDefault();
				this.pause();
				$('#galleria-control-play').css('display','block');
				$('#galleria-control-pause').css('display','none');
			}));
			$('#galleria-control-play').click(this.proxy(function(e) {
				e.preventDefault();
				this.play();
				$('#galleria-control-pause').css('display','block');
				$('#galleria-control-play').css('display','none');
			}));
			$('#galleria-control-pause').click(this.proxy(function(e) {
				e.preventDefault();
				this.pause();
				$('#galleria-control-play').css('display','block');
				$('#galleria-control-pause').css('display','none');
			}));
			<?php } ?>			
		}
	});
	Galleria.ready(function(options) {
		this.lazyLoadChunks(5);
		<?php if ((getOption('zpbase_galcaption')) || ($isMobile)) echo 'this.$(\'info-link\').click();'; ?>
		$('.galleria-container').append('<div id="galleria-custom-controls"><?php if ($sspage) { ?><a id="galleria-control-return" title="<?php echo html_encode($albumtitle).'&raquo; '.gettext('Return'); ?>" href="<?php echo html_encode($returnpath); ?>"><span></span></a><?php } ?><a id="galleria-control-play" href="#"><span></span></a><a id="galleria-control-pause" href="#"><span></span></a><a href="#" id="galleria-control-fullscreen"><span></span></a></div>');
	});
</script>
<?php if ((getOption('zpbase_galautoplay')) || ($sspage)) { ?> <style>#galleria-custom-controls a#galleria-control-play{display:none;}#galleria-custom-controls a#galleria-control-pause{display:block;}</style> <?php } ?>
	