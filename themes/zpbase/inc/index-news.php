<?php
/*	zpBase News Homepage option 
*	This file is is used when the homepage News option is enabled.
*	http://www.oswebcreations.com
================================================== */

include ('header.php'); $zpbase_newsstyle = getOption('zpbase_newsstyle'); ?>
			
	<div class="container" id="middle">
		<div class="row">
				
			<div id="content" class="<?php echo $zpbase_newsstyle; ?>">	
				<div id="object-info">
					<?php if (getOption('zpbase_galleryishome')) { ?><div id="object-desc"><?php printGalleryDesc(); ?></div><?php } ?>
					<div id="object-menu">
						<?php if (getOption('zpbase_social')) include ('socialshare.php'); ?>
						<?php if ((class_exists('RSS')) && (getOption('RSS_album_image'))) { ?>
						<span><?php printRSSLink('Gallery','',gettext('Gallery RSS'),'',false); ?></span>
						<?php } ?>
					</div>
				</div>
				
				<?php if ($zpbase_newsstyle == 'masonry-style') { ?><div id="spinner"></div><?php } ?>
				<div id="<?php echo $zpbase_newsstyle; ?>">
					<?php while (next_news()): ;?>
					<div class="<?php echo $zpbase_newsstyle; ?>-item">
						<div class="<?php echo $zpbase_newsstyle; ?>-padding">
							<h3><?php printNewsURL(); ?></h3>
							<div class="news-meta">
								<span>
								<?php if (getOption('zpbase_date_news')) echo getNewsDate().'&nbsp;|&nbsp;'; ?>
								<?php printNewsCategories(', ',gettext('Categories: '),'taglist'); ?>
								</span>
							</div>	
							<?php printNewsContent(); ?>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
				
				<?php if ($zpbase_newsstyle == 'masonry-style') { ?>
				<?php if (getNextNewsPageURL()) { ?>	
				<div id="page-nav-mas">
					<?php printNextNewsPageLink(gettext('Load More...')); ?>
				</div>
				<?php } ?>
				<div id="page-nav" class="clearfix">
					<div class="jump"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
				</div>
				<?php } else { ?>
				<div class="page-nav">
					<div class="jump"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
					<?php printNewsPageListWithNav(gettext('Next »'), gettext('« Prev'),true,'pagination',true); ?>
				</div>
				<?php } ?>
				
			</div>
			
			<?php if ($zpbase_newsstyle == 'blog-style') { ?>
			<div id="sidebar">
				<div class="block">
					<h3><?php echo gettext('Categories'); ?></h3>
					<?php printAllNewsCategories(gettext('All news'),true,'','menu-active',true,'submenu','menu-active'); ?>
				</div>
			</div>
			<?php } ?>
			
		</div>
	</div>

<?php if ($zpbase_newsstyle == 'masonry-style') include ('masonry-jscall.php'); ?>
<?php include ('footer.php'); ?>	