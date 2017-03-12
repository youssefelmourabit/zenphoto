<?php
/*	zpBase search.php 
*	This theme page shows the search and archive results, similar to the album display.
*	http://www.oswebcreations.com
================================================== */

include ('inc/header.php'); 
$zpcount = 0;
$numimages = getNumImages();
$numalbums = getNumAlbums();
$total = $numimages + $numalbums;
if ($total > 0) { $showpag = true; } else { $showpag = false; }
if ($zenpage && !isArchive()) {
	$numpages = getNumPages();
	if (getOption('zpbase_usenews')) { $numnews = getNumNews(); } else { $numnews = 0; }
	$zpcount = $numpages + $numnews;
	$total = $total + $numnews + $numpages;
} else {
	$numpages = $numnews = 0;
}
if ($total == 0) {
	$_zp_current_search->clearSearchWords();
}
?>
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<?php if (getOption('zpbase_archive')) { ?>
				
				<div class="block searchwrap">	
					<h1 class="notop"><?php echo gettext('Search'); ?></h1>
					<?php printSearchForm('','search',$_zp_themeroot.'/images/magnifying_glass_16x16.png',gettext('Search gallery'),$_zp_themeroot.'/images/list_12x11.png'); ?>	
					<?php
					$searchwords = getSearchWords();
					$searchdate = getSearchDate();
					if (!empty($searchdate)) {
						if (!empty($searchwords)) {
							$searchwords .= ": ";
						}
						$searchwords .= $searchdate;
					}
					if ($total > 0 ) { ?>
					<p class="searchresults"><?php printf(ngettext('%1$u Hit for <em>%2$s</em>','%1$u Hits for <em>%2$s</em>',$total), $total, html_encode($searchwords));?></p>
					<?php } else { ?>
					<p class="searchresults"><?php echo gettext('Sorry, no matches found. Try refining your search.'); ?></p>
					<?php } ?>
					<div id="object-menu">
						<?php if (getOption('zpbase_galss')) { ?>
						<span><?php printBaseSlideShowLink(); ?></span>
						<?php } elseif (function_exists('printSlideShowLink')) { ?>
						<span><?php printSlideShowLink(); ?></span>
						<?php } ?>
					</div>
				</div>
				
				<?php if (getOption('zpbase_searchlayout') == 'search-masonry') { ?>
				<div id="spinner"></div>
				<div id="masonry-style">
					<?php if (($zpcount > 0) && ($_zp_page == 1)) { ?>
					<?php if ($numpages > 0) {
					while (next_page()) { ?>
					<div class="masonry-style-item">
						<div class="masonry-style-padding">
							<h4><a href="<?php echo html_encode($_zp_current_zenpage_page->getLink()); ?>"><?php printPageTitle(); ?></a></h4>
							<p class="search-excerpt"><?php echo shortenContent(strip_tags(getPageContent()),180,getOption('zenpage_textshorten_indicator')); ?></p>
						</div>
					</div>
					<?php } 
					}
					if (($numnews > 0) && (getOption('zpbase_usenews'))) {
					while (next_news()) { ?>
					<div class="masonry-style-item">
						<div class="masonry-style-padding">
							<h4><?php printNewsURL(); ?></h4>
							<p class="search-excerpt"><?php echo shortenContent(strip_tags(getNewsContent()),180,getOption('zenpage_textshorten_indicator')); ?></p>
						</div>
					</div>
					<?php } 
					} 
					} ?>
					
					<?php if (isAlbumPage()) { ?>
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
					<?php while (next_image()): ?>
					<div class="masonry-style-item">
						<div class="masonry-style-padding">
							<?php if (getOption('zpbase_nodetailpage')) { 
								if (getOption('thumb_crop')) {
								printCustomSizedImage(getAnnotatedImageTitle(),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),null,null,'remove-attributes',null,true);
								} else { 
								printImageThumb(getBareImageTitle(),'remove-attributes'); 
								} 
							} else { ?>
							<a href="<?php echo html_encode(getImageURL()); ?>" title="<?php printBareImageTitle(); ?>">
								<?php if (getOption('thumb_crop')) {
								printCustomSizedImage(getAnnotatedImageTitle(),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),null,null,'remove-attributes',null,true);
								} else { 
								printImageThumb(getBareImageTitle(),'remove-attributes'); 
								} ?>
							</a>
							<?php } ?>
							<?php if ((getOption('zpbase_magnific_masonry')) || (getOption('zpbase_nodetailpage'))) { 
							if (getOption('zpbase_magnific_target') == 'imagepage') { ?>
							<a class="popup-page" href="<?php echo html_encode(getImageURL()); ?>?show=imagepage" title="<?php printBareImageTitle();?>"><img src="<?php echo $_zp_themeroot; ?>/images/zoom-in-2-n.png" alt="<?php echo gettext('Image Details'); ?>" /></a>
							<?php } elseif (isImagePhoto($_zp_current_image)) { ?>
							<a title ="<?php echo getBareImageTitle(); ?>" class="masonry-image-popup" <?php if (!(getOption('zpbase_nodetailpage'))) { ?>data-source="<?php echo html_encode(getImageURL()); ?>" <?php } ?>href="<?php echo htmlspecialchars(getDefaultSizedImage()); ?>"><img src="<?php echo $_zp_themeroot; ?>/images/zoom-in-2-n.png" alt="<?php echo gettext('Preview Image'); ?>" /></a>
							<?php } 
							} ?>
						</div>
					</div>
					<?php endwhile; ?>
					
				</div>
				
				<?php if ((hasNextPage()) && ($showpag)) { ?>	
				<div id="page-nav-mas">
					<?php printNextPageURL(gettext('Load More...')); ?>
				</div>
				<?php } ?>
				<div id="page-nav" class="clearfix">
					<div class="jump"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
				</div>
				
				
				<?php } else { ?>
				
				<?php if (($zpcount > 0) && ($_zp_page == 1)) { ?>
				<div class="block clearfix">
					<?php if ($numpages > 0) {
					while (next_page()) { ?>
					<div class="pageexcerpt">
						<h4><a href="<?php echo html_encode($_zp_current_zenpage_page->getLink()); ?>"><?php printPageTitle(); ?></a></h4>
						<p class="search-excerpt"><?php echo shortenContent(strip_tags(getPageContent()),180,getOption('zenpage_textshorten_indicator')); ?></p>
					</div>
					<?php } 
					}
					if (($numnews > 0) && (getOption('zpbase_usenews'))) {
					while (next_news()) { ?>
					<div class="pageexcerpt">
						<h4><?php printNewsURL(); ?></h4>
						<p class="search-excerpt"><?php echo shortenContent(strip_tags(getNewsContent()),180,getOption('zenpage_textshorten_indicator')); ?></p>
					</div>
					<?php } 
					} ?>
				</div>
				<?php } ?>
				
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
							<a class="image-thumb popup-page" href="<?php echo html_encode(getImageURL()); ?>?show=imagepage" title="<?php printBareImageTitle();?>"><?php printImageThumb(getBareImageTitle(),'remove-attributes'); ?></a>
							<?php } elseif (isImagePhoto($_zp_current_image)) { ?>
							<a title="<?php echo getBareImageTitle(); ?>" class="image-popup" <?php if (!(getOption('zpbase_nodetailpage'))) { ?>data-source="<?php echo html_encode(getImageURL()); ?>" <?php } ?>href="<?php echo htmlspecialchars(getDefaultSizedImage()); ?>">
								<?php if (getOption('thumb_crop')) {
								printCustomSizedImage(getAnnotatedImageTitle(),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),getOption('thumb_size'),null,null,'remove-attributes',null,true);
								} else { 
								printImageThumb(getBareImageTitle(),'remove-attributes'); 
								} ?>
							</a>
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
					<?php if (($showpag) && ((hasNextPage()) || (hasPrevPage()))) printPageListWithNav('« '.gettext('prev'),gettext('next').' »',false,true,'pagination'); ?>
				</div>

				<?php } ?>
				
			<?php } else { ?>
			<p><?php echo gettext('Search and archive functions have been disabled...'); ?></p>
			<?php } ?>
			</div>
		</div>
	</div> 

<?php if (getOption('zpbase_searchlayout') == 'search-masonry') include ('inc/masonry-jscall.php'); 
include ('inc/footer.php'); ?>