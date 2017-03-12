<?php
/*	zpBase Footer include 
*	This file is included at the end of every page
*	http://www.oswebcreations.com
================================================== */
?>
	<div class="container" id="bottom">
		<div class="row">
			<div id="footer">
				<?php if (getOption('zpbase_copy')) { ?><div id="copyright"><?php echo getOption('zpbase_copy'); ?></div><?php } ?>
				<div id="footer-menu">
					<?php if(function_exists("printUserLogin_out")) { ?>
					<span>
					<?php
					if (zp_loggedin()) {
					printUserLogin_out('');
					} else {
					printCustomPageURL(gettext('Login'),'login','');
					} ?>
					</span>
					<?php } ?>		
					<?php if (!zp_loggedin() && function_exists('printRegistrationForm')) { ?>
					<span><?php printCustomPageURL(gettext('Register'),'register','',''); ?></span>
					<?php } ?>
					<?php
					$zpbase_sociallinks = false;
					if ($fb_linkurl = getOption('zpbase_facebook')) $zpbase_sociallinks = true;
					if ($tw_linkurl = getOption('zpbase_twitter')) $zpbase_sociallinks = true;
					if ($g_linkurl = getOption('zpbase_google')) $zpbase_sociallinks = true;
					if ($zpbase_sociallinks) { ?>
					<span id="sociallinks">
						<?php echo gettext ('Stay Connected').': '; ?>
						<?php if ($fb_linkurl) { ?><a target="_blank" href="<?php echo $fb_linkurl; ?>" title="<?php echo gettext('Find us on Facebook'); ?>"><?php echo gettext('Facebook'); ?></a><?php } ?>
						<?php if ($tw_linkurl) { ?><a target="_blank" href="<?php echo $tw_linkurl; ?>" title="<?php echo gettext('Find us on Twitter'); ?>"><?php echo gettext('Twitter'); ?></a><?php } ?>
						<?php if ($g_linkurl) { ?><a target="_blank" href="<?php echo $g_linkurl; ?>" title="<?php echo gettext('Find us Google+'); ?>"><?php echo gettext('Google+'); ?></a><?php } ?>
					</span>
					<?php } ?>
					<?php if (class_exists('RSS')) { ?>
					<span id="rsslinks">
						<?php if (($zenpage) && (getOption('zpbase_usenews')) && ($_zp_gallery_page == 'news.php') && (getOption('RSS_articles'))) {
						printRSSLink('News','',gettext('RSS News'),'',false); 
						} elseif (($zenpage) && ($_zp_gallery_page == 'pages.php') && (getOption('RSS_pages'))) {
						printRSSLink('Pages','',gettext('RSS Pages'),'',false);
						} elseif (getOption('RSS_album_image')) {
						printRSSLink('Gallery','',gettext('RSS Gallery'),'',false);
						} ?>
					</span>
					<?php } ?>
				</div>
				<?php if (function_exists('printLanguageSelector')) printLanguageSelector("langselector"); ?>
			</div>
			
		</div>
	</div>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>