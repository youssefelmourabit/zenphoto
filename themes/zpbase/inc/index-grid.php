<?php
/*	zpBase Default Grid Homepage option 
*	This file is is used when the homepage Default Grid option is enabled.
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
				<div class="image-grid albums">
					<?php while (next_album()): ?>
					<div class="image-unit">
						<a class="album-thumb" href="<?php echo html_encode(getAlbumURL());?>" title="<?php printBareAlbumTitle();?>">
							<?php if (getOption('thumb_crop')) {
							printCustomAlbumThumbImage(getAnnotatedAlbumTitle(),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),null,null,'remove-attributes');
							} else {
							printAlbumThumbImage(getAnnotatedAlbumTitle(),'remove-attributes');
							} ?>
						</a>
						<h3><?php printBareAlbumTitle();?></h3>
						<p class="album-desc"><?php echo truncate_string(strip_tags(getAlbumDesc()),120,'...'); ?></p>
					</div>	
					<?php endwhile; ?>
				</div>
				<?php 
				if ((hasNextPage()) || (hasPrevPage())) { $jumpclass='jump'; $pagin = true; } else { $jumpclass='jump center'; $pagin = false; }
				?>
				<div id="page-nav">
					<div class="<?php echo $jumpclass; ?>"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
					<?php if ($pagin) printPageListWithNav('« '.gettext('prev set'),gettext('next set').' »',false,true,'pagination'); ?>
				</div>	
			</div>
		</div>
	</div>
	
<?php include ('footer.php'); ?>				