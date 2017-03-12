<?php
/*	zpBase Masonry Homepage option 
*	This file is is used when the homepage script utilizing jQuery Smooth Div Scroll display is enabled.
*	http://www.oswebcreations.com
================================================== */

$layoutbodyclass = 'body-sdscroll'; 
if ((getOption('zpbase_sds_pagination') == 'all') || (getOption('zpbase_sds_pagination') == 'home-all')) { $showall = true; } else { $showall = false; }
include ('header.php'); ?>

	<div class="container" id="middle">
		<div class="row row-sdscroll">
			<div id="content">
				<div id="spinner"></div>	
				<div id="makeMeScrollable">
					<?php if (getOption('zpbase_galhomeop') == 'albums') { // latest albums
					while (next_album($showall)): ?>
					<div class="sdscroll-item">
						<a class="album-thumb" href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php printBareAlbumTitle(); ?>">
							<?php printCustomAlbumThumbImage(getBareAlbumTitle(),null,null,getOption('zpbase_sds_maxheight'),null,null,null,null,'remove-attributes'); ?>
						</a>
						<div class="sdscroll-albuminfo">
							<h3><?php printAlbumTitle(); ?></h3>
							<p class="album-desc"><?php echo strip_tags(truncate_string(getAlbumDesc(),140,'...')); ?></p>
							<div class="album-stats">
								<?php if ( (getNumAlbums() > 0) && (getNumImages() > 0) ) { $divider='- '; } else { $divider=''; } ?>
								<?php if (getNumAlbums() > 0) echo getNumAlbums().' '.gettext("subalbums"); ?>
								<?php echo $divider; ?>
								<?php if (getNumImages() > 0) echo getNumImages().' '.gettext("images"); ?>
							</div>
						</div>
					</div>	
					<?php endwhile; 
					} else { // or latest images
					require_once(SERVERPATH.'/'.ZENFOLDER.'/'.PLUGIN_FOLDER.'/image_album_statistics.php');
					$images = getImageStatistic(getOption('zpbase_galhomecount'),'latest');
					foreach ($images as $image) {
					if (isImagePhoto($image)) {
					makeImageCurrent($image); ?>
					<div class="sdscroll-item">
						<?php if (getOption('zpbase_nodetailpage')) { 
						printCustomSizedImage(getBareImageTitle(),null,null,getOption('zpbase_sds_maxheight'),null,null,null,null,'remove-attributes',null,true);
						} else { ?>
						<a href="<?php echo html_encode(getImageURL()); ?>" title="<?php printBareImageTitle(); ?>">
							<?php printCustomSizedImage(getBareImageTitle(),null,null,getOption('zpbase_sds_maxheight'),null,null,null,null,'remove-attributes',null,true); ?>
						</a>
						<?php } ?>
						<?php if ( ((getOption('zpbase_magnific_sds')) || (getOption('zpbase_nodetailpage'))) && (isImagePhoto($_zp_current_image)) ) { ?> 
						<a title ="<?php echo getBareImageTitle(); ?>" class="image-popup" <?php if (!(getOption('zpbase_nodetailpage'))) { ?>data-source="<?php echo html_encode(getImageURL()); ?>" <?php } ?>href="<?php echo htmlspecialchars(getDefaultSizedImage()); ?>"><img src="<?php echo $_zp_themeroot; ?>/images/zoom-in-2-n.png" alt="<?php echo gettext('Preview Image'); ?>" /></a>
						<?php } ?>
					</div>
					<?php }
					}
					$_zp_current_album = null; set_context(ZP_INDEX); // reset for drop menu....
					} ?>
				</div>
			</div>
		</div>
		<div class="row">
				<div id="object-info">
					<?php if (getOption('zpbase_galleryishome')) { ?><div id="object-desc"><?php printGalleryDesc(); ?></div><?php } ?>
					<div id="object-menu">
						<?php if (getOption('zpbase_social')) include ('socialshare.php'); ?>
						<?php if ((class_exists('RSS')) && (getOption('RSS_album_image'))) { ?>
						<span><?php printRSSLink('Gallery','',gettext('Gallery RSS'),'',false); ?></span>
						<?php } ?>
					</div>
				</div>
				<?php 
				if ( 
					((hasNextPage()) || (hasPrevPage()))
					&& ((getOption('zpbase_galhomeop') == 'albums') && ($showall == false))
					) 
					{ $jumpclass='jump'; $pagin = true; } else { $jumpclass='jump center'; $pagin = false; }
				?>
				<div id="page-nav">
					<div class="<?php echo $jumpclass; ?>"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
					<?php if ($pagin) printPageListWithNav('« '.gettext('prev set'),gettext('next set').' »',false,true,'pagination'); ?>
				</div>	

		</div>
	</div> 
<?php include ('sdscroll-jscall.php'); ?>
<?php include ('footer.php'); ?>