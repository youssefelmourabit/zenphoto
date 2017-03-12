<?php
/*	zpBase index.php 
*	This theme page is the home page starting page, which loads the homepage script based on the option settings.
*	http://www.oswebcreations.com
================================================== */

if (getOption('zpbase_galleryishome')) {

if (($isMobile) && (getOption('zpbase_mobiletogrid'))) { 
$indexlayout = 'inc/index-grid.php';
} else {
$indexlayout = 'inc/'.getOption('zpbase_indexlayout').'.php';
}
include ($indexlayout);

} else { ?>

<?php include ('inc/header.php'); ?>
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<?php printGalleryDesc(); ?>
				<div class="jump center">
					<?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?>
				</div>
			</div>
		</div>
	</div>
<?php include ('inc/footer.php'); ?>		

<?php } ?>