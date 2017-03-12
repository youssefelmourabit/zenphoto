<?php
/*	zpBase album-sdscroll.php 
*	An actual album.php script utilizing jQuery Smooth Div Scroll display.  
*	Will be included as the default album.php display, or can be called per album by the multiple layout plugin.
*	http://www.oswebcreations.com
================================================== */

if (($isMobile) && (getOption('zpbase_mobiletogrid'))) { include ('album.php'); } else {
 
$layoutbodyclass = 'body-sdscroll'; 
if (getOption('zpbase_sds_pagination') == 'all') { $showall = true; } else { $showall = false; }
include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row row-sdscroll">
			<div id="content">
				<div id="spinner"></div>	
				<div id="makeMeScrollable">
					<?php if (isAlbumPage()) { ?>
					<?php while (next_album($showall)): ?>
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
					<?php endwhile; ?>
					<?php } ?>
					<?php while (next_image($showall)): ?>
					<div class="sdscroll-item">
						<?php if (getOption('zpbase_nodetailpage')) { 
						printCustomSizedImage(getBareImageTitle(),null,null,getOption('zpbase_sds_maxheight'),null,null,null,null,'remove-attributes',null,true);
						} else { ?>
						<a href="<?php echo html_encode(getImageURL()); ?>" title="<?php printBareImageTitle(); ?>">
							<?php printCustomSizedImage(getBareImageTitle(),null,null,getOption('zpbase_sds_maxheight'),null,null,null,null,'remove-attributes',null,true); ?>
						</a>
						<?php } ?>
						<?php if ((getOption('zpbase_magnific_sds')) || (getOption('zpbase_nodetailpage'))) { 
						if (getOption('zpbase_magnific_target') == 'imagepage') { ?>
						<a class="popup-page" href="<?php echo html_encode(getImageURL()); ?>?show=imagepage" title="<?php printBareImageTitle();?>"><img src="<?php echo $_zp_themeroot; ?>/images/zoom-in-2-n.png" alt="<?php echo gettext('Image Details'); ?>" /></a>
						<?php } elseif (isImagePhoto($_zp_current_image)) { ?>
						<a title ="<?php echo getBareImageTitle(); ?>" class="image-popup" <?php if (!(getOption('zpbase_nodetailpage'))) { ?>data-source="<?php echo html_encode(getImageURL()); ?>" <?php } ?>href="<?php echo htmlspecialchars(getDefaultSizedImage()); ?>"><img src="<?php echo $_zp_themeroot; ?>/images/zoom-in-2-n.png" alt="<?php echo gettext('Preview Image'); ?>" /></a>
						<?php } 
						} ?>
					</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
		<div class="row">	
				<div id="object-info">
					<?php $albumnav = getPrevAlbum(); if (!is_null($albumnav)) { ?>
					<div class="object-link prev"><a href="<?php echo getPrevAlbumURL(); ?>" title="<?php echo html_encode($albumnav->getTitle()); ?>"></a></div>
					<?php } $albumnav = getNextAlbum(); if (!is_null($albumnav)) { ?>
					<div class="object-link next"><a href="<?php echo getNextAlbumURL(); ?>" title="<?php echo html_encode($albumnav->getTitle()); ?>"></a></div>
					<?php } ?>
					<div id="object-title">
						<div id="breadcrumb"><?php printParentBreadcrumb('',' / ',' / '); ?></div>
						<h1><?php printAlbumTitle(); ?></h1>
					</div>
					<div id="object-menu">
						<?php if ((getOption('zpbase_date_albums')) && ($_zp_gallery_page == 'album.php')) { ?><span><?php printAlbumDate(); ?></span><?php } ?>
						<span>
						<?php if ( (getNumAlbums() > 0) && (getNumImages() > 0) ) { $divider=', '; } else { $divider=''; } ?>
						<?php if (getNumAlbums() > 0) echo getNumAlbums().' '.gettext("albums"); ?>
						<?php echo $divider; ?>
						<?php if (getNumImages() > 0) echo getNumImages().' '.gettext("images"); ?>
						</span>
						<?php if ($_zp_gallery_page == 'album.php') {
						if (getOption('zpbase_social')) include ('inc/socialshare.php');
						if ((class_exists('RSS')) && (getOption('RSS_album_image'))) { ?>
						<span><?php printRSSLink('Collection','',gettext('Album RSS'),'',false); ?></span>
						<?php } 
						} ?>
						<?php if ((getOption('zpbase_galss')) && (checkForImages())) { ?>
						<span><?php printBaseSlideShowLink(); ?></span>
						<?php } elseif (function_exists('printSlideShowLink')) { ?>
						<span><?php printSlideShowLink(); ?></span>
						<?php } ?>
					</div>
					<div id="object-desc"><?php printAlbumDesc(); ?></div>
					<?php if (getOption('zpbase_archive')) {
					$singletag = getTags(); $tagstring = implode(', ', $singletag); 
					if (strlen($tagstring) > 0) { ?>
					<div class="block"><?php echo gettext('Tags: '); ?><?php printTags('links','','taglist', ', '); ?></div>
					<?php } 
					} ?>
					<?php if (function_exists('printGoogleMap')) { ?><div id="map-wrap"><?php printGoogleMap('Google Map',null,'hide'); ?></div><?php } ?>
				</div>
				
				<?php 
				if (((hasNextPage()) || (hasPrevPage())) && ($showall == false)) { $jumpclass='jump'; $pagin = true; } else { $jumpclass='jump center'; $pagin = false; } ?>
				<div id="page-nav">
					<div class="<?php echo $jumpclass; ?>"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
					<?php if ($pagin) printPageListWithNav('« '.gettext('prev set'),gettext('next set').' »',false,true,'pagination'); ?>
				</div>	
				
				<?php printCodeblock(); ?>

				<?php if (function_exists('printRating')) { ?>
				<div id="rating" class="block"><?php printRating(); ?></div>
				<?php } ?>
				<?php if ((function_exists('printAddToFavorites')) && ($_zp_gallery_page == 'album.php')) { ?>
				<div id="favorites" class="block"><?php printAddToFavorites($_zp_current_album); ?></div>
				<?php } ?>
				
				<?php if (getOption('zpbase_disqus')) { ?><div class="block"><?php printDisqusCommentForm(); ?></div>
				<?php } elseif (function_exists('printCommentForm')) { ?><div class="block"><?php printCommentForm(); ?></div><?php } ?>
				<?php if (function_exists('printRelatedItems')) { ?><div class="block"><?php printRelatedItems(5,'albums',null,null,'albums'); ?></div><?php } ?>
				
		</div>
	</div> 
	
<?php include ('inc/sdscroll-jscall.php');
include ('inc/footer.php');

} ?>