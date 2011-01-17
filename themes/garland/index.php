<?php
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php zp_apply_filter('theme_head'); ?>
<title><?php printGalleryTitle(); ?></title>
<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css"
	type="text/css" />
<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>
<body class="sidebars">
<?php zp_apply_filter('theme_body_open'); ?>
<div id="navigation"></div>
<div id="wrapper">
	<div id="container">
		<div id="header">
			<div id="logo-floater">
				<div>
          <h1 class="title"><a href="<?php echo html_encode(getGalleryIndexURL(false)); ?>" title="<?php echo gettext('Gallery Index'); ?>"><?php echo html_encode(getGalleryTitle()); ?></a></h1>
				</div>
			</div>
		</div>
	<!-- header -->
	<div class="sidebar">
     <div id="leftsidebar">
		<?php include("sidebar.php"); ?>
		</div>
	</div>
	<div id="center">
		<div id="squeeze">
			<div class="right-corner">
				<div class="left-corner"><!-- begin content -->
					<div class="main section" id="main">
						<h3 id="gallerytitle"><?php echo getGalleryTitle(); ?></h3>
						<?php
						if ($_zp_gallery_page=='index.php' && getOption('zp_plugin_zenpage')) {
							commonNewsLoop(false);
						} else {
							?>
							<div id="albums">
							<?php
							while (next_album($_zp_gallery_page == 'gallery.php')) {
								?>
								<div class="album">
									<a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php printf(gettest('View album: %s'),sanitize(getAlbumTitle())); ?>">
										<?php printCustomAlbumThumbImage(getAlbumTitle(),85,NULL,NULL,77,77); ?>
									</a>
									<div class="albumdesc"><small><?php printAlbumDate(gettext("Date Taken: ")); ?></small>
										<h3>
											<a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php printf(gettest('View album: %s'),sanitize(getAlbumTitle())); ?>">
												<?php printAlbumTitle(); ?>
											</a>
										</h3>
										<p><?php printAlbumDesc(); ?></p>
									</div>
								<p style="clear: both;"></p>
								</div>
								<?php
							}
							printPageListWithNav(gettext("&laquo; prev"), gettext("next &raquo;"));
							?>
							</div>
							<?php
						}
						?>
						<?php footer(); ?></div>
						<div style="clear: both;"></div>
					</div>
				<!-- end content --> <span class="clear"></span>
				</div>
			</div>
		</div>
		<div class="sidebar">
			<div id="rightsidebar">
				<?php
				if (function_exists('printLatestImages')) {?>
					<h2><?php  echo gettext('Latest Images'); ?></h2>
					<?php
					printLatestImages(7);
				}
				?>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php
printAdminToolbox();
zp_apply_filter('theme_body_close');
?>
</body>
</html>
