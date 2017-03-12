<?php
/*	zpBase album-galleria.php 
*	An actual album.php script utilizing jQuery Galleria display, depending on options set.  
*	Will be included as the default album.php display, or can be called per album by the multiple layout plugin.
*	http://www.oswebcreations.com
================================================== */

if (($isMobile) && (getOption('zpbase_mobiletogrid'))) { include ('album.php'); } else {
$layoutbodyclass = 'body-galleria'; 
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
					</div>
				</div>
					
				<script>
					var data = [
						<?php
						$c=0;
						if (isAlbumPage()) { 
						while (next_album(true)):
						if ($c==0) { echo '{'."\n"; } else { echo ',{'."\n"; }
						echo 'thumb: \''.getAlbumThumb().'\','."\n";
						echo 'image: \''.getCustomAlbumThumb(getOption('image_size')).'\','."\n";
						echo 'big: \''.getCustomAlbumThumb(getOption('zpbase_galbigsize')).'\','."\n";
						echo 'title: \''.html_encode(getBareAlbumTitle()).'\','."\n";
						if ( (getNumAlbums() > 0) && (getNumImages() > 0) ) { $divider='/ '; } else { $divider=''; }
						if (getNumAlbums() > 0) { $albumcount = getNumAlbums().' '.gettext('albums'); } else { $albumcount = ''; }
						if (getNumImages() > 0) { $imagecount = getNumImages().' '.gettext('images'); } else { $imagecount = ''; }
						$desc1 = $albumcount.$divider.$imagecount.' ... <a href="'.html_encode(getAlbumURL()).'">'.gettext('Goto Album').' &rarr;</a>';
						$desc2 = '<p>'.getBareAlbumDesc().'</p>';
						$desc2 = str_replace("\r\n", '<br />', $desc2);
						$desc2 = str_replace("\r", '<br />', $desc2);
						$desc = $desc1.$desc2;
						echo 'description: \''.js_encode($desc).'\','."\n";
						echo 'link: \''.html_encode(getAlbumURL()).'\''."\n";
						echo '}'."\n";
						$c++; 
						endwhile; 
						}
						while (next_image(true)):
						if (isImagePhoto($_zp_current_image)) {						
						if ($c==0) { echo '{'."\n"; } else { echo ',{'."\n"; }
						echo 'thumb: \''.getImageThumb().'\','."\n";
						echo 'image: \''.getDefaultSizedImage().'\','."\n";
						echo 'big: \''.getCustomImageURL(getOption('zpbase_galbigsize')).'\','."\n";
						echo 'title: \''.html_encode(getBareImageTitle()).'\','."\n";
						$desc = getBareImageDesc();
						$desc = str_replace("\r\n", '<br />', $desc);
						$desc = str_replace("\r", '<br />', $desc);
						echo 'description: \''.js_encode($desc).'\','."\n";
						if (!(getOption('zpbase_nodetailpage'))) { echo 'link: \''.html_encode(getImageURL()).'\''."\n"; }
						echo '}'."\n";
						$c++; 
						}
						endwhile; 
						?>	
					];
				</script>
				<?php if ($c>0) { ?>
				<div id="galleria"></div>
				<?php } else { ?>
				<p class="center"><?php echo gettext('No valid albums or images to display...'); ?></p>
				<?php } ?>
				
				<div id="object-desc"><?php printAlbumDesc(); ?></div>
				<?php if (function_exists('printGoogleMap')) { ?><div id="map-wrap"><?php printGoogleMap('Google Map',null,'hide'); ?></div><?php } ?>
				
				<?php if (getOption('zpbase_archive')) {
				$singletag = getTags(); $tagstring = implode(', ', $singletag); 
				if (strlen($tagstring) > 0) { ?>
				<div class="block"><?php echo gettext('Tags: '); ?><?php printTags('links','','taglist', ', '); ?></div>
				<?php } 
				} ?>
				
				<div id="page-nav" class="clearfix">
					<div class="jump center"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
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
	</div> 

<?php if ($c>0) { $sspage = false; include ('inc/galleria-jscall.php'); }
include ('inc/footer.php');

} ?>