<?php
/*	zpBase Masonry Homepage option 
*	This file is is used when the homepage Masonry option is enabled (Gallery).
*	http://www.oswebcreations.com
================================================== */
?>
<?php include ('header.php'); ?>
	
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<div id="object-info">
					<?php if (getOption('zpbase_galleryishome')) { ?><div id="object-desc"><?php printGalleryDesc(); ?></div><?php } ?>
					<div id="object-menu">
						<?php if (getOption('zpbase_social')) include ('socialshare.php'); ?>
						<?php if ((class_exists('RSS')) && (getOption('RSS_album_image'))) { ?>
						<span><?php printRSSLink('Gallery','',gettext('Gallery RSS'),'',false); ?></span>
						<?php } ?>
					</div>
				</div>
				<div id="masonry-style">
					<?php while (next_album()): ?>
					<div class="masonry-style-item album">
						<div class="masonry-style-padding">
							<h3><?php printAlbumTitle(); ?></h3>
							<a class="album-thumb" href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php printBareAlbumTitle(); ?>">
								<?php if (getOption('thumb_crop')) {
								printCustomAlbumThumbImage(getAnnotatedAlbumTitle(),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),null,null,'remove-attributes');
								} else {
								printAlbumThumbImage(getAnnotatedAlbumTitle(),'remove-attributes');
								} ?>
							</a>
							<p class="album-desc"><?php echo truncate_string(strip_tags(getAlbumDesc()),140,'...'); ?></p>
							<div class="album-stats">
								<?php if ( (getNumAlbums() > 0) && (getNumImages() > 0) ) { $divider='- '; } else { $divider=''; } ?>
								<?php if (getNumAlbums() > 0) echo getNumAlbums().' '.gettext("subalbums"); ?>
								<?php echo $divider; ?>
								<?php if (getNumImages() > 0) echo getNumImages().' '.gettext("images"); ?>
							</div>
						</div>
					</div>	
					<?php endwhile; ?>
				</div>
				
				<?php if (hasNextPage()) { ?>	
				<div id="page-nav-mas">
					<?php printNextPageURL(gettext('Load More...')); ?>
				</div>
				<?php } ?>
				<div id="page-nav" class="clearfix">
					<div class="jump"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
				</div>
	
<?php include ('masonry-jscall.php'); ?>
<?php include ('footer.php'); ?>