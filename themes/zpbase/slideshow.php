<?php
/*	zpBase slideshow.php 
*	This theme page shows the cusotm slideshow if enabled in the options.  It can also show the core Cycle slideshow, although will not be repsonsive.
*	http://www.oswebcreations.com
================================================== */

if (!defined('WEBPATH')) die(); 
?>
<!DOCTYPE html>
<html>

<?php if (getOption('zpbase_galss')) { ?>

<head>
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER; ?>/js/jquery.js"></script>
	<meta charset="<?php echo LOCAL_CHARSET; ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php echo gettext('Slideshow').' | '.getBareGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/css/style.css" type="text/css" />
</head>
<body id="dark" class="sspage">
	<div id="galleria"></div>	
	<?php printBaseSlideShow(); ?>
</body>

<?php } else { ?>

<head>
	<?php zp_apply_filter('theme_head'); ?>
	<meta charset="<?php echo LOCAL_CHARSET; ?>" />
	<title><?php echo gettext('Slideshow').' | '.getBareGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/css/style.css" type="text/css" />
</head>
<body>
	<?php zp_apply_filter('theme_body_open'); ?>
	<div id="slideshowpage">
		<?php printSlideShow(true,true); ?>
	</div>
	<?php zp_apply_filter('theme_body_close'); ?>
</body>

<?php } ?>

</html>
