<?php
/*	zpBase image.php 
*	This theme page shows the large default sized single image.
*	http://www.oswebcreations.com
================================================== */
if (isset($_GET['show'])) {
include ('inc/image-popup.php');
} else {

include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<div id="image-full" class="block clearfix">
					<div id="single-img-nav"<?php if (isImageVideo()) echo ' class="video-nav"'; ?>>
						<?php if (hasPrevImage()) { ?>
						<a class="prev-link" href="<?php echo html_encode(getPrevImageURL());?>" title="<?php echo gettext("Previous Image"); ?>"><span></span></a>
						<?php } if (hasNextImage()) { ?>
						<a class="next-link" href="<?php echo html_encode(getNextImageURL());?>" title="<?php echo gettext("Next Image"); ?>"><span></span></a>
						<?php } ?>
					</div>
					<?php printDefaultSizedImage(getBareImageTitle(),'remove-attributes'); ?>
					<?php if (getOption('zpbase_verticalscale')) { ?>
					<script>
						function resizeFullImageDiv() {
							vpw = $(window).width();
							vph = $(window).height()*(.60);
							if (vph > <?php echo getOption('image_size'); ?>) { vph = <?php echo getOption('image_size'); ?>; }
							if (vph < vpw) { 
								$('#image-full').css({'height': vph + 'px'}); 
							} else {
								$('#image-full').css({'height': 'auto'}); 
							}
						}
						resizeFullImageDiv();
						window.onresize = function(event) {
							resizeFullImageDiv();
						}
					</script>
					<?php } ?>
				</div>
				<div id="object-info">
					<?php 
					// The following checks and modifications of breadcrumb link backs are necessary when using an album layout without pagination, since default behaviour is to provide a link back to the album page the image is on.
					$linkbackpaged = true;
					if (function_exists('getSelectedLayout')) {
					$albumlayout = getSelectedLayout($_zp_current_album,'multiple_layouts_albums');
					} else {
					$albumlayout = array('data'=>'');
					}
					if (($albumlayout['data'] == 'album-masonry.php') || ($albumlayout['data'] == 'album-galleria.php') || (getOption('zpbase_defaultalbum') == 'album-galleria') || (getOption('zpbase_defaultalbum') == 'album-masonry')) { $linkbackpaged = false; if (in_context(ZP_SEARCH_LINKED)) $_zp_current_search->page = '1'; }
					?>
					<div id="object-title">
						<div id="breadcrumb">
							<?php 
							printParentBreadcrumb('',' / ',' / '); 
							if ($linkbackpaged) {
							printAlbumBreadcrumb(' ', ' / '); 
							} else {
							$link = rewrite_path("/" . pathurlencode($_zp_current_album->name) . "/","/index.php?album=" . pathurlencode($_zp_current_album->name)); ?>
							<a href="<?php echo $link; ?>" title="<?php echo $_zp_current_album->getTitle(); ?>"><?php echo $_zp_current_album->getTitle(); ?></a>&nbsp;/&nbsp;
							<?php } ?>
							<span>(<em><?php echo imageNumber().' of '.getNumImages(); ?></em>)</span>
						</div>
						<h1 class="notop"><?php printImageTitle(); ?></h1>
					</div>
					<div id="object-menu">
						<?php if (getOption('zpbase_date_images')) { ?><span><?php printImageDate(); ?></span><?php } ?>
						<?php if (getOption('zpbase_social')) include ('inc/socialshare.php'); ?>
						<?php if (getOption('zpbase_download')) { ?><span><a href="<?php echo html_encode(getFullImageURL()); ?>" title="<?php echo gettext('Download'); ?>"><?php echo gettext('Download').' ('.getFullWidth().' x '.getFullHeight().')'; ?></a></span><?php } ?>
						<?php if (getOption('zpbase_galss')) { 
						if (isImagePhoto()) { ?><span><?php printBaseSlideShowLink(); ?></span><?php } ?>
						<?php } elseif (function_exists('printSlideShowLink')) { ?>
						<span><?php printSlideShowLink(); ?></span>
						<?php } ?>
					</div>
					<div id="object-desc"><?php printImageDesc(); ?></div>
					<?php if (function_exists('printGoogleMap')) { ?><div id="map-wrap"><?php printGoogleMap('Google Map',null,'hide'); ?></div><?php } ?>
					<?php if (getImageData('copyright')) { ?><p class="image-copy"><?php echo getImageData('copyright'); ?></p><?php } ?>
					
					<?php if (getOption('zpbase_archive')) {
					$singletag = getTags(); $tagstring = implode(', ', $singletag); 
					if (strlen($tagstring) > 0) { ?>
					<div class="block"><?php echo gettext('Tags: '); ?><?php printTags('links','','taglist', ', '); ?></div>
					<?php } 
					} ?>
					
					<?php printCodeblock(); ?>
					
					<?php if (getImageMetaData()) { ?><p><?php printImageMetadata('',false,'imagemetadata'); ?></p><?php } ?>
					
				</div>
				
				<div class="jump center">
					<?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?>
				</div>
					
				<?php if (function_exists('printRating')) { ?>
				<div id="rating" class="block"><?php printRating(); ?></div>
				<?php } ?>
				<?php if (function_exists('printAddToFavorites')) { ?>
				<div id="favorites" class="block"><?php printAddToFavorites($_zp_current_image); ?></div>
				<?php } ?>
				<?php if (getOption('zpbase_disqus')) { ?><div class="block"><?php printDisqusCommentForm(); ?></div>
				<?php } elseif (function_exists('printCommentForm')) { ?><div class="block"><?php printCommentForm(); ?></div><?php } ?>
				<?php if (function_exists('printRelatedItems')) { ?><div class="block"><?php printRelatedItems(5,'pages',null,null,'pages'); ?></div><?php } ?>
				
			</div>
		</div>
	</div>

<?php include ('inc/footer.php'); 
} ?>
