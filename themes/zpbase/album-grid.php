<?php
/*	zpBase album-grid.php 
*	An actual album.php script utilizing default standard css grid.  
*	Will be included as the default album.php display, or can be called per album by the multiple layout plugin.
*	http://www.oswebcreations.com
================================================== */

$layoutbodyclass = 'body-defaultgrid'; 
include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
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
						<?php if (getOption('zpbase_galss')) { ?>
						<span><?php printBaseSlideShowLink(); ?></span>
						<?php } elseif (function_exists('printSlideShowLink')) { ?>
						<span><?php printSlideShowLink(); ?></span>
						<?php } ?>
					</div>
					<div id="object-desc"><?php printAlbumDesc(); ?></div>
					<?php if (function_exists('printGoogleMap')) { ?><div id="map-wrap"><?php printGoogleMap('Google Map',null,'hide'); ?></div><?php } ?>
				</div>
					
				<?php if (isAlbumPage()) { ?>
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
						<p class="album-desc"><?php echo strip_tags(truncate_string(getAlbumDesc(),120,'...')); ?></p>
					</div>	
					<?php endwhile; ?>
				</div>
				<?php } ?>
				<div class="image-grid images">
					<?php while (next_image()): ?>
					<div class="image-unit">
						<?php if ( (getOption('zpbase_magnific_grid')) || (getOption('zpbase_nodetailpage'))) {
							if (getOption('zpbase_magnific_target') == 'imagepage') { ?>
							<a class="image-thumb popup-page" href="<?php echo html_encode(getImageURL()); ?>?show=imagepage" title="<?php printBareImageTitle();?>">
								<?php if (getOption('thumb_crop')) {
								printCustomSizedImage(getAnnotatedImageTitle(),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),null,null,'remove-attributes',null,true);
								} else { 
								printImageThumb(getBareImageTitle(),'remove-attributes'); 
								} ?>
							</a>
							<?php } elseif (isImagePhoto($_zp_current_image)) { ?>
							<a title="<?php echo getBareImageTitle(); ?>" class="image-popup" <?php if (!(getOption('zpbase_nodetailpage'))) { ?>data-source="<?php echo html_encode(getImageURL()); ?>" <?php } ?>href="<?php echo htmlspecialchars(getDefaultSizedImage()); ?>"><?php printImageThumb(getBareImageTitle(),'remove-attributes'); ?></a>
							<?php } else { ?>
								<?php if (getOption('thumb_crop')) {
								printCustomSizedImage(getAnnotatedImageTitle(),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),null,null,'remove-attributes',null,true);
								} else { 
								printImageThumb(getBareImageTitle(),'remove-attributes'); 
								} ?>
							<?php } ?>
						<?php } else { ?>
							<a class="image-thumb" href="<?php echo html_encode(getImageURL()); ?>" title="<?php printBareImageTitle();?>">
								<?php if (getOption('thumb_crop')) {
								printCustomSizedImage(getAnnotatedImageTitle(),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),null,null,'remove-attributes',null,true);
								} else { 
								printImageThumb(getBareImageTitle(),'remove-attributes'); 
								} ?>
							</a>
						<?php } ?>
					</div>
					<?php endwhile; ?>
				</div>
				
				<div id="page-nav" class="clearfix">
					<div class="jump"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
					<?php if ((hasNextPage()) || (hasPrevPage())) printPageListWithNav('« '.gettext('prev'),gettext('next').' »',false,true,'pagination'); ?>
				</div>
				
				<?php printCodeblock(); ?>
				
				<?php if (getOption('zpbase_archive')) {
				$singletag = getTags(); $tagstring = implode(', ', $singletag); 
				if (strlen($tagstring) > 0) { ?>
				<div class="block"><?php echo gettext('Tags: '); ?><?php printTags('links','','taglist', ', '); ?></div>
				<?php } 
				} ?>

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
	</div> 

<?php include ('inc/footer.php'); ?>