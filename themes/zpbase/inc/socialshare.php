<?php
/*	zpBase simple social sharing include 
*	This file is included on a page to show social sharing links, if set in options
*	http://www.oswebcreations.com
================================================== */
?>
<?php 
$host = sanitize("http://" . $_SERVER['HTTP_HOST']);
$url = $host . getRequestURI();

$fb_url = 'http://www.facebook.com/sharer.php?u='.$url;
$tw_url = 'http://twitter.com/home?status='.$url;
$g_url = 'https://plus.google.com/share?url='.$url;
?>

<span id="social-share">
	<?php echo gettext('Share: '); ?>
	<a target="_blank" class="share fb" href="<?php echo $fb_url; ?>" title="<?php echo gettext('Share on Facebook'); ?>">Facebook</a>
	, <a target="_blank" class="share tw" href="<?php echo $tw_url; ?>" title="<?php echo gettext('Share on Twitter'); ?>">Twitter</a>
	, <a target="_blank" class="share g" href="<?php echo $g_url; ?>" title="<?php echo gettext('Share on Google+'); ?>">Google+</a>
</span>
