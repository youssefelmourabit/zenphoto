<?php
/*	zpBase archive.php 
*	This theme page shows the search box and archive lists (news and images by date and tags).
*	http://www.oswebcreations.com
================================================== */

include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<?php if (getOption('zpbase_archive')) { ?>
				<div class="block searchwrap">	
					<h1 class="notop"><?php echo gettext('Search'); ?></h1>
					<?php printSearchForm('','search',$_zp_themeroot.'/images/magnifying_glass_16x16.png',gettext('Search gallery'),$_zp_themeroot.'/images/list_12x11.png'); ?>	
				</div>
				<?php if (getOption('zpbase_date_images')) { ?>
				<div class="block archive">	
					<h3><?php echo gettext('Gallery Archive'); ?></h3>
					<div class="archive-cols">
						<?php printAllDates('archive','year','month'); ?>
					</div>
				</div>
				<?php } ?>
				<?php if ( ($zenpage) && (getOption('zpbase_usenews')) ) { ?>
				<?php if ((getNumNews(true) > 0) && (getOption('zpbase_date_news'))) { ?>
				<div class="block archive">	
					<h3><?php echo gettext('News Archive'); ?></h3>
					<div class="archive-cols">
						<?php printNewsArchive('archive','year','month'); ?>
					</div>
				</div>
				<?php }
				} ?>
				<div class="block archive">	
					<h3><?php echo gettext('Tags'); ?></h3>
					<div class="archive-cols">
						<?php printAllTagsAs('list','year','results',true,true,2,50,1); ?>
					</div>
				</div>
				<?php } else { ?>
				<p><?php echo gettext('Search and archive functions have been disabled...'); ?></p>
				<?php } ?>

			</div>
		</div>
	</div>

<?php include ('inc/footer.php'); ?>