<?php
/*	zpBase news.php 
*	This theme page shows both the news snippets/blog/combinews and single news page of the Zenpage plugin.
*	http://www.oswebcreations.com
================================================== */

include ('inc/header.php'); $zpbase_newsstyle = getOption('zpbase_newsstyle'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			
			<?php if(is_NewsArticle()) { ?>
			
			<div id="content" class="wside">	
				<div id="object-info">
					<?php if (getPrevNewsURL()) { ?>
					<div class="object-link prev"><?php printPrevNewsLink(''); ?></div>
					<?php } if (getNextNewsURL()) { ?>
					<div class="object-link next"><?php printNextNewsLink(''); ?></div>
					<?php } ?>
					<div id="object-title">
						<h1><?php printNewsTitle(); ?></h1>
					</div>
					<div id="object-menu">
						<?php if (getOption('zpbase_date_news')) { ?><span><?php echo gettext('Date: '); ?><?php printNewsDate(); ?></span><?php } ?>
						<span><?php echo gettext('Category: '); ?><?php printNewsCategories(', ',' ','taglist'); ?></span>
						<?php if (getOption('zpbase_social')) include ('inc/socialshare.php'); ?>
					</div>
				</div>
				<?php $hasFeaturedImage = false; if (function_exists('printSizedFeaturedImage')) $hasFeaturedImage = getFeaturedImage(); ?>
				<?php if ( (getCodeBlock()) || ($hasFeaturedImage) || (getPageExtraContent()) ) { ?>
				<div class="page-inset">
					<?php if ($hasFeaturedImage) printSizedFeaturedImage(null,null,getOption('thumb_size'),null,null,null,null,null,null,'remove-attributes',null,true,null); ?>
					<?php printCodeblock(); ?>
					<?php if (getNewsExtraContent()) printNewsExtraContent(); ?>
				</div>
				<?php } ?>
				<div class="page-news-full">
					<?php printNewsContent(); ?>
				</div>
				
				<?php if (getOption('zpbase_archive')) {
				$singletag = getTags(); $tagstring = implode(', ', $singletag); 
				if (strlen($tagstring) > 0) { ?>
				<div class="block"><?php echo gettext('Tags: '); ?><?php printTags('links','','taglist', ', '); ?></div>
				<?php } 
				} ?>
					
				<?php if (function_exists('printRating')) { ?>
				<div id="rating" class="block"><?php printRating(); ?></div>
				<?php } ?>
				
				<?php if (getOption('zpbase_disqus')) { ?><div class="block"><?php printDisqusCommentForm(); ?></div>
				<?php } elseif (function_exists('printCommentForm')) { ?><div class="block"><?php printCommentForm(); ?></div><?php } ?>
				<?php if (function_exists('printRelatedItems')) { ?><div class="block"><?php printRelatedItems(5,'news',null,null,'news'); ?></div><?php } ?>
			</div>
			<?php include ('inc/sidebar.php'); ?>
			
			<?php } else { ?>
				
			<div id="content" class="<?php echo $zpbase_newsstyle; ?>">	
				<div id="object-info">
					<div id="object-title">
						<?php if (in_context(ZP_ZENPAGE_NEWS_CATEGORY)) { ?>
						<div><?php printNewsIndexURL($newsname); echo ' / '; ?></div>
						<h1><?php printCurrentNewsCategory(); ?></h1>
						<?php } else if (in_context(ZP_ZENPAGE_NEWS_DATE)) { ?>
						<div><?php printNewsIndexURL($newsname); echo ' / '; ?></div>
						<h1><?php printCurrentNewsArchive(); ?></h1>
						<?php } else { ?>
						<h1><?php echo $newsname; ?></h1>
						<?php } ?>
					</div>
					<div id="object-desc">
						<div><?php printNewsCategoryDesc(); ?></div>
						<?php $hasFeaturedImage = false; if (function_exists('printSizedFeaturedImage')) $hasFeaturedImage = getFeaturedImage(); ?>
						<?php if ($hasFeaturedImage) printSizedFeaturedImage(null,null,getOption('thumb_size'),null,null,null,null,null,null,'remove-attributes center',null,true,null); ?>
					</div>
				</div>
				<?php if ($zpbase_newsstyle == 'masonry-style') { ?><div id="spinner"></div><?php } ?>
				<div id="<?php echo $zpbase_newsstyle; ?>">
					<?php while (next_news()): ?>
					<div class="<?php echo $zpbase_newsstyle; ?>-item">
						<div class="<?php echo $zpbase_newsstyle; ?>-padding">
							<?php if (function_exists('printSizedFeaturedImage')) printSizedFeaturedImage(null,null,getOption('thumb_size'),null,null,null,null,null,null,'remove-attributes',null,true,null); ?>
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
				<div id="page-nav" class="clearfix">
					<div class="jump"><?php printBaseAlbumMenuJump('count',gettext('Gallery Index')); ?></div>
					<?php printNewsPageListWithNav(gettext('Next »'), gettext('« Prev'),true,'pagination',true); ?>
				</div>
				<?php } ?>
				
			</div>
			
			<?php if ($zpbase_newsstyle == 'blog-style') include ('inc/sidebar.php'); ?>
			
			<?php } ?>
		</div>
	</div>

<?php if ($zpbase_newsstyle == 'masonry-style') include ('inc/masonry-jscall.php'); ?>
<?php include ('inc/footer.php'); ?>		