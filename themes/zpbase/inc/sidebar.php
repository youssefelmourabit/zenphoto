<?php
/*	zpBase sidebar.php, included on news and pages
*	http://www.oswebcreations.com
================================================== */
?>
			
			<div id="sidebar">
				
				<div class="sidebar-block">
					<h3><?php echo gettext('Page Menu'); ?></h3>
					<?php printPageMenu('list','sidebar-page-menu','top-active','sub-list','sub-active',null,true,true,25); ?>
				</div>
				
				<?php if ( (getOption('zpbase_usenews') && (getNumNews(true) > 0)) ) { ?>
				<div class="sidebar-block news-cats">
					<h3><?php echo gettext('News Categories'); ?></h3>
					<?php printAllNewsCategories($newsname,true,'','menu-active',true,'submenu','menu-active','list',true,25); ?>
				</div>
				<?php } ?>
				
				<?php if ( (getOption('zpbase_disqus')) && (getOption('zpbase_disqus_shortname')) ) { ?>
				<div class="sidebar-block">
					<h3><?php echo gettext('Latest Comments'); ?></h3>
					<script type="text/javascript" src="http://<?php echo getOption('zpbase_disqus_shortname'); ?>.disqus.com/recent_comments_widget.js?num_items=5&hide_avatars=0&avatar_size=32&excerpt_length=150"></script>
				</div>
				<?php } elseif (function_exists('printCommentForm')) { ?>
				<div class="sidebar-block">
					<h3><?php echo gettext('Latest Comments'); ?></h3>
					<?php printLatestComments(5,'150','all'); ?>
				</div>
				<?php } ?>
				
			</div>