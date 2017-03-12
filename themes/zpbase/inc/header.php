<?php 
/*	zpBase Header include
* 	This file is included at the beginning of every page.
*	Sets up some variables depending on context and writes the necessary html at the beginning of every page.
* 	It also includeds the html for the top menu.
*	http://www.oswebcreations.com	
================================================== */
// force UTF-8 Ø

if (!defined('WEBPATH')) die();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php echo LOCAL_CHARSET; ?>" />
	<?php zp_apply_filter('theme_head');
	$zpbase_metadesc = truncate_string(getBareGalleryDesc(),150,'...');	
	// Set some things depending on what page we are on...
	switch ($_zp_gallery_page) {
		case 'index.php':
			if (getOption('zpbase_galleryishome')) $galleryactive = true;
			$objectclass = 'gallery-index';
			$rss_option = 'Gallery'; $rss_title = gettext('RSS Gallery Images');
			break;
		case 'gallery.php':
			$galleryactive = true;
			$objectclass = 'gallery-sep-index';
			$rss_option = 'Gallery'; $rss_title = gettext('RSS Gallery Images');
			break;
		case 'album.php':
			$zpbase_metadesc = truncate_string(getBareAlbumDesc(),150,'...');
			$galleryactive = true;
			$objectclass = str_replace (" ", "", getBareAlbumTitle()).'-'.$_zp_current_album->getID();
			$rss_option = 'Collection'; $rss_title = gettext('RSS Album Images');
			break;
		case 'image.php':
			$zpbase_metadesc = truncate_string(getBareImageDesc(),150,'...');
			$galleryactive = true;
			$objectclass = str_replace (" ", "", getBareImageTitle()).'-'.$_zp_current_image->getID();
			break;
		case 'archive.php':
			$zpbase_metadesc = gettext('Archive View').'... '.truncate_string(getBareGalleryDesc(),130,'...');	
			$objectclass = 'archive-page';			
			$rss_option = 'Gallery'; $rss_title = gettext('RSS Gallery Images');
			break;
		case 'search.php':	
			$objectclass = 'search-results';
			break;
		case 'pages.php':
			$zpbase_metadesc = strip_tags(truncate_string(getPageContent(),150,'...'));
			$objectclass = str_replace (" ", "", getBarePageTitle()).'-'.$_zp_current_zenpage_page->getID();
			$rss_option = 'Pages'; $rss_title = gettext('RSS Pages');
			break;
		case 'news.php':
			$rss_option = 'News'; $rss_title = gettext('RSS News');
			if (is_NewsArticle()) {
			$zpbase_metadesc = strip_tags(truncate_string(getNewsContent(),150,'...'));
			$objectclass = str_replace (" ", "", getBareNewsTitle()).'-'.$_zp_current_zenpage_news->getID();
			} else if ($_zp_current_category) {
			$zpbase_metadesc = strip_tags(truncate_string(getNewsCategoryDesc(),150,'...'));
			$objectclass = str_replace (" ", "", html_encode($_zp_current_category->getTitle())).'-news';
			$rss_option = 'Category'; $rss_title = gettext('RSS News Category');
			} else if (getCurrentNewsArchive()) {
			$zpbase_metadesc = getCurrentNewsArchive().' '.gettext('News Archive').'... '.truncate_string(getBareGalleryDesc(),130,'...');	
			$objectclass = str_replace (" ", "", getCurrentNewsArchive()).'-news';
			} else {
			$zpbase_metadesc = gettext('News').'... '.truncate_string(getBareGalleryDesc(),130,'...');	
			$objectclass = 'news-index';
			}
			break;
		case 'contact.php':
			$zpbase_metadesc = gettext('Contact').'... '.truncate_string(getBareGalleryDesc(),130,'...');	
			$objectclass = 'contact-page';	
			break;
		case 'login.php':
			$zpbase_metadesc = gettext('Login').'... '.truncate_string(getBareGalleryDesc(),130,'...');
			$objectclass = 'login-page';	
			break;
		case 'register.php':
			$zpbase_metadesc = gettext('Register').'... '.truncate_string(getBareGalleryDesc(),130,'...');
			$objectclass = 'register-page';	
			break;
		case 'password.php':
			$zpbase_metadesc = gettext('Enter Password').'... '.truncate_string(getBareGalleryDesc(),130,'...');
			$objectclass = 'password-page';	
			break;
		case '404.php':
			$zpbase_metadesc = gettext('404 Not Found').'... '.truncate_string(getBareGalleryDesc(),130,'...');
			$objectclass = 'notfound-page';	
			break;
		case 'favorites.php':
			$zpbase_metadesc = gettext('Favorites').'... '.truncate_string(getBareGalleryDesc(),130,'...');
			$objectclass = 'favorites-page';	
			break;
		default:
			$zpbase_metadesc = truncate_string(getBareGalleryDesc(),150,'...');
			$objectclass = null;
			break;
	} 
	// Print the defined RSS header links, title, and description
	if ((class_exists('RSS')) && ($rss_option != null)) printRSSHeaderLink($rss_option,$rss_title); ?>
	<?php printHeadTitle(); ?>
	<meta name="description" content="<?php echo $zpbase_metadesc; ?>" />	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/css/style.css">

	<script>
	// Mobile Menu
	$(function() {
		var navicon = $('#nav-icon');
		menu = $('#nav');
		menuHeight	= menu.height();
		$(navicon).on('click', function(e) {
			e.preventDefault();
			menu.slideToggle();
			$(this).toggleClass('menu-open');
		});
		$(window).resize(function(){
        	var w = $(window).width();
        	if(w > 320 && menu.is(':hidden')) {
        		menu.removeAttr('style');
        	}
    	});
	});
	</script>
	
	<?php if (getOption('zpbase_selectmenu') == 'chosen') { ?>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/css/chosen.css">
	<script src="<?php echo $_zp_themeroot; ?>/js/chosen.jquery.js"></script>
	<script>
	$(document).ready(function(){
		$(".jump select").chosen({
			disable_search_threshold: 15,
			search_contains: true
		}).change(function(e){
			window.location = $(this).val();
		});
	});
	</script>
	<!-- fix to drop UP -->
	<style>
	.chosen-container .chosen-drop {
		top:auto !important;
		bottom:29px;
		border:solid #aaa;
		border-width:1px 1px 0 1px;
	}
	</style>
	<?php } ?>
	
	<script src="<?php echo $_zp_themeroot; ?>/js/magnific-popup.js"></script>
	<script src="<?php echo $_zp_themeroot; ?>/js/zpbase_js.js"></script>
	
	<link rel="shortcut icon" href="<?php echo $_zp_themeroot; ?>/images/favicon.ico">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $_zp_themeroot; ?>/favicon-152.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo $_zp_themeroot; ?>/favicon-144.png">
	
	<?php if (getOption('zpbase_googlefont1') != null) { 
	$googlefontstack1 = str_replace('+',' ',getOption('zpbase_googlefont1')); ?>
	<link href="http://fonts.googleapis.com/css?family=<?php echo getOption('zpbase_googlefont1'); ?>" rel="stylesheet" type="text/css" />
	<?php } ?>
	<?php if (getOption('zpbase_googlefont2') != null) {
	$googlefontstack2 = str_replace('+',' ',getOption('zpbase_googlefont2')); ?>
	<link href="http://fonts.googleapis.com/css?family=<?php echo getOption('zpbase_googlefont2'); ?>" rel="stylesheet" type="text/css" />
	<?php } ?>
	<style>
		<?php if (is_numeric(getOption('zpbase_maxwidth'))) { echo '.row{max-width:'.getOption('zpbase_maxwidth').'px;}'; } else { echo '.row{max-width:900px;}'; } ?>
		<?php if (getOption('zpbase_bg') != null) { 
		$bg = pathurlencode(WEBPATH.'/'.UPLOAD_FOLDER.'/'.getOption('zpbase_bg'));
		echo 'body{background-image: url('.$bg.');}';
		} ?>
		<?php if (getOption('zpbase_align') == 'left') { ?>
		#object-info,#object-menu,#object-desc,#header,#footer,#footer-menu,.block.searchwrap h1,.block.archive h3,.searchresults {text-align:left;}
		#search,#imagemetadata table{margin-left:0;margin-right:0;}
		<?php } ?>
		<?php if (getOption('zpbase_googlefont1') != null) { ?>body,#nav a,#sidebar ul a{font-family: '<?php echo $googlefontstack1; ?>', sans-serif;} <?php } ?>
		<?php if (getOption('zpbase_googlefont2') != null) { ?>h1,h2,h3,h4,h5,h6{font-family: '<?php echo $googlefontstack2; ?>', serif;} <?php } ?>
		<?php if (((getOption('zpbase_fontsize')) > 10) && (getOption('zpbase_fontsize') < 19)) echo 'body{font-size:'.getOption('zpbase_fontsize').'px;}'; ?>
		<?php if (getOption('zpbase_customcss') != null) { echo getOption('zpbase_customcss'); } ?>
		<?php if (($isMobile) || ($isTablet)) { echo 'body{font-size:16px;}'; } ?>
	</style>
</head>
<body id="<?php echo getOption('zpbase_style'); ?>" class="<?php echo $objectclass.' '.$layoutbodyclass; ?>">
	<?php if ( (getOption('zpbase_analytics')) && (!zp_loggedin(ADMIN_RIGHTS)) ) { ?>
	<script>
		<?php if (getOption('zpbase_analytics_type') == 'universal') { ?>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', '<?php echo getOption('zpbase_analytics'); ?>', 'auto');
		ga('send', 'pageview');
		<?php } else { ?>
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo getOption('zpbase_analytics'); ?>']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		<?php } ?>
	</script>
	<?php } ?>
	<?php zp_apply_filter('theme_body_open'); ?>
	
	<?php if ( ($noset) && (zp_loggedin(ADMIN_RIGHTS)) ) { ?><div id="noset"><?php echo 'Admin Notice: Since you recently installed zpBase, switched themes or changed the Zenphoto installation, you need to <a style="color:black;text-decoration:underline;" href="'.WEBPATH.'/'.ZENFOLDER.'/admin-options.php?page=options&amp;tab=theme&amp;optiontheme=zpbase">visit the theme options page to set some things →</a>'; ?></div><?php } ?>
	<a href="#" class="scrollup" title="<?php echo gettext('Scroll to top'); ?>"><?php echo gettext('Scroll'); ?></a>
	<div class="container" id="top">
		<div class="row">
			<div id="header">
				<?php if (getOption('zpbase_pnglogo') != '') { ?>
				<a id="logo" href="<?php echo html_encode(getGalleryIndexURL()); ?>"><img class="remove-attributes" src="<?php echo pathurlencode(WEBPATH.'/'.UPLOAD_FOLDER.'/'.getOption('zpbase_pnglogo')); ?>" alt="<?php printGalleryTitle(); ?>" /></a>
				<?php } else { ?>
				<h1><a id="logo" href="<?php echo html_encode(getGalleryIndexURL()); ?>"><?php printGalleryTitle(); ?></a></h1>
				<?php } ?>
				<ul id="nav">
					<?php if (getOption('zpbase_galleryishome')) { ?>
					<li <?php if ($galleryactive) { ?>class="active" <?php } ?>>
						<a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo gettext('Gallery'); ?>"><?php echo gettext('Gallery'); ?></a>
					</li>
					<?php } else { ?>
					<li <?php if ($_zp_gallery_page == "index.php") { ?>class="active" <?php } ?>>
						<a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo gettext('Home'); ?>"><?php echo gettext('Home'); ?></a>
					</li>
					<li <?php if ($galleryactive) { ?>class="active" <?php } ?>>
						<?php printCustomPageURL(gettext('Gallery'),"gallery"); ?>
					</li>
					<?php } ?>
					<?php if ((function_exists('getNewsIndexURL')) && (getOption('zpbase_usenews'))) { ?>
					<?php if (getNumNews(true) > 0) { ?>
					<li <?php if ($_zp_gallery_page == "news.php") { ?>class="active" <?php } ?>>
						<a href="<?php echo getNewsIndexURL(); ?>"><?php echo $newsname; ?></a>
					</li>
					<?php }
					} ?>
					<?php if (function_exists('printPageMenu')) { ?>
					<?php printPageMenu('list','','active open','submenu','active open','',true,false); ?>
					<?php } ?>
					<?php if (getOption('zpbase_archive')) { ?>
					<li <?php if (($_zp_gallery_page == "archive.php") || ($_zp_gallery_page == "search.php")) { ?>class="active" <?php } ?>>
						<a href="<?php echo getCustomPageURL('archive'); ?>" title="<?php echo gettext('Search/Archive'); ?>"><?php echo gettext('Search/Archive'); ?></a>
					</li>
					<?php } ?>
					<?php if (function_exists('printContactForm')) { ?>
					<li <?php if ($_zp_gallery_page == "contact.php") { ?>class="active" <?php } ?>>
						<?php printCustomPageURL(gettext('Contact'),"contact"); ?>
					</li>
					<?php } ?>
				</ul>
				<a href="#" id="nav-icon"><span><?php echo gettext('Menu'); ?></span></a>
			</div>
		</div>
	</div>