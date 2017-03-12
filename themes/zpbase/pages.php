<?php
/*	zpBase pages.php 
*	This theme page shows the individual pages created from the Zenpage plugin.
*	http://www.oswebcreations.com
================================================== */

include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content" class="wside">
				<div id="object-info">
					<div id="object-title">
						<div><?php printZenpageItemsBreadcrumb('',' / '); ?></div>
						<h1><?php printPageTitle(); ?></h1>
					</div>
					<div id="object-menu">
						<?php if (getOption('zpbase_date_pages')) { ?><span><?php echo gettext('Last Updated: '); ?><?php echo getPageLastChangeDate(); ?></span><?php } ?>
						<?php if (getOption('zpbase_social')) include ('inc/socialshare.php'); ?>
					</div>
				</div>
				<?php $hasFeaturedImage = false; if (function_exists('printSizedFeaturedImage')) $hasFeaturedImage = getFeaturedImage(); ?>
				<?php if ( (getCodeBlock()) || ($hasFeaturedImage) || (getPageExtraContent()) ) { ?>
				<div class="page-inset">
					<?php if ($hasFeaturedImage) printSizedFeaturedImage(null,null,getOption('thumb_size'),null,null,null,null,null,null,'remove-attributes',null,true,null); ?>
					<?php printCodeblock(); ?>
					<?php if (getPageExtraContent()) printPageExtraContent(); ?>
				</div>
				<?php } ?>
				<?php printPageContent(); ?>
				
				<?php if (getOption('zpbase_archive')) {
				$singletag = getTags(); $tagstring = implode(', ', $singletag); 
				if (strlen($tagstring) > 0) { ?>
				<div class="block"><?php echo gettext('Tags: '); ?><?php printTags('links','','taglist', ', '); ?></div>
				<?php } 
				} ?>
				
				<?php if (getPageCustomData() == 'subpagesexcerpts') { ?>
				<div class="block clearfix sidemenu">
					<?php printSubPagesExcerpts(); ?>
				</div>
				<?php } ?>
				
				<?php if (function_exists('printRating')) { ?>
				<div id="rating" class="block"><?php printRating(); ?></div>
				<?php } ?>
				
				<?php if (getOption('zpbase_disqus')) { ?><div class="block"><?php printDisqusCommentForm(); ?></div>
				<?php } elseif (function_exists('printCommentForm')) { ?><div class="block"><?php printCommentForm(); ?></div><?php } ?>
				<?php if (function_exists('printRelatedItems')) { ?><div class="block"><?php printRelatedItems(5,'pages',null,null,'pages'); ?></div><?php } ?>
				
			</div>
			<?php include ('inc/sidebar.php'); ?>
			
		</div>
	</div>

<?php include ('inc/footer.php'); ?>