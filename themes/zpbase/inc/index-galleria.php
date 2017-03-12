<?php
/*	zpBase Galleria Homepage option 
*	This file is is used when the homepage Galleria option is enabled.
*	http://www.oswebcreations.com
================================================== */
?>

<?php include ('header.php'); ?>
	
	<div class="container" id="middle">
		<div class="row">
			<div id="content">	
				<script>
					var data = [
						<?php if (getOption('zpbase_galhomeop') == 'albums') { // latest albums
						$c=0;
						while (next_album(true)):
						if ($c==0) { echo '{'."\n"; } else { echo ',{'."\n"; }
						echo 'thumb: \''.getAlbumThumb().'\','."\n";
						echo 'image: \''.getCustomAlbumThumb(getOption('image_size')).'\','."\n";
						echo 'big: \''.getCustomAlbumThumb(getOption('zpbase_galbigsize')).'\','."\n";
						echo 'title: \''.html_encode(getBareAlbumTitle()).'\','."\n";
						if ( (getNumAlbums() > 0) && (getNumImages() > 0) ) { $divider='/ '; } else { $divider=''; }
						if (getNumAlbums() > 0) { $albumcount = getNumAlbums().' '.gettext('albums'); } else { $albumcount = ''; }
						if (getNumImages() > 0) { $imagecount = getNumImages().' '.gettext('images'); } else { $imagecount = ''; }
						$desc1 = $albumcount.$divider.$imagecount.'<br />';
						$desc2 = getBareAlbumDesc();
						$desc2 = str_replace("\r\n", '<br />', $desc2);
						$desc2 = str_replace("\r", '<br />', $desc2);
						$desc = $desc1.'<br />'.$desc2;
						echo 'description: \''.js_encode($desc).'\','."\n";
						echo 'link: \''.html_encode(getAlbumURL()).'\''."\n";
						echo '}'."\n";
						$c++; 
						endwhile; 
						} else { // or latest images
						require_once(SERVERPATH.'/'.ZENFOLDER.'/'.PLUGIN_FOLDER.'/image_album_statistics.php');
						$images = getImageStatistic(getOption('zpbase_galhomecount'),'latest');
						$c=0;
						foreach ($images as $image) {
						if (isImagePhoto($image)) {
						makeImageCurrent($image);
						if ($c==0) { echo '{'."\n"; } else { echo ',{'."\n"; }
						echo 'thumb: \''.getImageThumb().'\','."\n";
						echo 'image: \''.getDefaultSizedImage().'\','."\n";
						echo 'big: \''.getCustomImageURL(getOption('zpbase_galbigsize')).'\','."\n";
						echo 'title: \''.html_encode($image->getTitle()).'\','."\n";
						$desc = $image->getDesc();
						$desc = str_replace("\r\n", '<br />', $desc);
						$desc = str_replace("\r", '<br />', $desc);
						echo 'description: \''.js_encode($desc).'\','."\n";
						if (!(getOption('zpbase_nodetailpage'))) { echo 'link: \''.html_encode(getImageURL()).'\''."\n"; }
						echo '}'."\n";
						$c++; 
						}
						}
						$_zp_current_album = null; set_context(ZP_INDEX); // reset for drop menu....
						} ?>
					];
				</script>
				
				<?php if ($c>0) { ?>
				<div id="galleria"></div>
				<?php } else { ?>
				<p class="center"><?php echo gettext('No valid images to display...'); ?></p>
				<?php } ?>
				
				<div id="object-info">
					<?php if (getOption('zpbase_galleryishome')) { ?><div id="object-desc"><?php printGalleryDesc(); ?></div><?php } ?>
					<div id="object-menu">
						<?php if (getOption('zpbase_social')) include ('socialshare.php'); ?>
						<?php if ((class_exists('RSS')) && (getOption('RSS_album_image'))) { ?>
						<span><?php printRSSLink('Gallery','',gettext('Gallery RSS'),'',false); ?></span>
						<?php } ?>
					</div>
				</div>
				<div id="page-nav" class="clearfix">
					<div class="jump center"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
				</div>
			</div>
		</div>
	</div>
	
<?php if ($c>0) include ('galleria-jscall.php'); ?>	
<?php include ('footer.php'); ?>	