<?php
/*	zpBase Theme Options
* 	File for theme option handling.
* 	The Admin Options page tests for the presence of this file in the theme folder.
* 	If it is present it is linked to with a require_once call.
* 	If it is not present, no custom theme options are displayed.
*	http://www.oswebcreations.com	
================================================== */
// 	force UTF-8 Ø
class ThemeOptions {

	function ThemeOptions() {
		// force core theme options for this theme
		setThemeOption('albums_per_row',3,null,'zpbase');
		setThemeOption('images_per_row',3,null,'zpbase');
		setThemeOption('image_use_side','longest',null,'zpbase');
		// set core theme option defaults
		setThemeOptionDefault('albums_per_page',6);
		setThemeOptionDefault('images_per_page',12); 
		setThemeOptionDefault('thumb_crop',false); 
		// set zpbase option defaults
		setThemeOptionDefault('zpbase_pnglogo', '');
		setThemeOptionDefault('zpbase_style', 'light');
		setThemeOptionDefault('zpbase_maxwidth', '960');
		setThemeOptionDefault('zpbase_verticalscale', true);
		setThemeOptionDefault('zpbase_align', 'center');
		setThemeOptionDefault('zpbase_date_albums', true);
		setThemeOptionDefault('zpbase_date_images', true);
		setThemeOptionDefault('zpbase_date_news', true);
		setThemeOptionDefault('zpbase_date_pages', true);
		setThemeOptionDefault('zpbase_social', true);
		setThemeOptionDefault('zpbase_download', true);
		setThemeOptionDefault('zpbase_selectmenu', 'chosen');
		setThemeOptionDefault('zpbase_indexlayout', 'index-grid');
		setThemeOptionDefault('zpbase_galleryishome', true);
		setThemeOptionDefault('zpbase_defaultalbum', 'album-grid');
		setThemeOptionDefault('zpbase_newsstyle', 'masonry-style');
		setThemeOptionDefault('zpbase_searchlayout', 'search-masonry');
		setThemeOptionDefault('zpbase_usenews', true);
		setThemeOptionDefault('zpbase_newsname', '');
		setThemeOptionDefault('zpbase_archive', true);
		setThemeOptionDefault('zpbase_iscrollbehavior', 'manual-first');
		setThemeOptionDefault('zpbase_galss', true);
		setThemeOptionDefault('zpbase_galclicknext', false);
		setThemeOptionDefault('zpbase_galcropop', 'landscape');
		setThemeOptionDefault('zpbase_galpan', false);
		setThemeOptionDefault('zpbase_galcaption', false);
		setThemeOptionDefault('zpbase_galhomeop', 'albums');
		setThemeOptionDefault('zpbase_galhomecount', 30);
		setThemeOptionDefault('zpbase_galautoplay', false);
		setThemeOptionDefault('zpbase_galinterval', '4000');
		setThemeOptionDefault('zpbase_galtrans', 'fadeslide');
		setThemeOptionDefault('zpbase_galtranspeed', '400');
		setThemeOptionDefault('zpbase_galhistory', true);
		setThemeOptionDefault('zpbase_galbigsize', 1200);
		setThemeOptionDefault('zpbase_googlefont1', '');	
		setThemeOptionDefault('zpbase_googlefont2', '');	
		setThemeOptionDefault('zpbase_fontsize', '12');
		setThemeOptionDefault('zpbase_customcss', '');
		setThemeOptionDefault('zpbase_bg', '');
		setThemeOptionDefault('zpbase_facebook', '');
		setThemeOptionDefault('zpbase_twitter', '');
		setThemeOptionDefault('zpbase_google', '');
		setThemeOptionDefault('zpbase_copy', '© '.date("Y"));
		setThemeOptionDefault('zpbase_cbtarget', true);
		setThemeOptionDefault('zpbase_nodetailpage', false);
		setThemeOptionDefault('zpbase_disqus', false);
		setThemeOptionDefault('zpbase_disqus_shortname','');		
		setThemeOptionDefault('zpbase_disqus_comment_form_albums', true);
		setThemeOptionDefault('zpbase_disqus_comment_form_images', true);
		setThemeOptionDefault('zpbase_disqus_comment_form_pages', false);
		setThemeOptionDefault('zpbase_disqus_comment_form_articles', true);
		setThemeOptionDefault('zpbase_magnific_grid', false);
		setThemeOptionDefault('zpbase_magnific_masonry', true);
		setThemeOptionDefault('zpbase_magnific_sds', true);
		setThemeOptionDefault('zpbase_magnific_target', 'image');
		setThemeOptionDefault('zpbase_mobiletogrid', true);
		setThemeOptionDefault('zpbase_sds_maxheight', 500);
		setThemeOptionDefault('zpbase_sds_pagination','paginate');
		setThemeOptionDefault('zpbase_analytics','');
		setThemeOptionDefault('zpbase_analytics_type','universal');
		// set image sizes based on maxwidth
		setThemeOption('image_size',round(getOption('zpbase_maxwidth')),null,'zpbase');
		setThemeOption('thumb_size',round(.31 * (getOption('zpbase_maxwidth'))),null,'zpbase');
		if (class_exists('cacheManager')) {
			$me = basename(dirname(__FILE__));
			cacheManager::deleteThemeCacheSizes($me);
			cacheManager::addThemeCacheSize($me, getThemeOption('image_size'), NULL, NULL, NULL, NULL, NULL, NULL, false, getOption('fullimage_watermark'), NULL, NULL); // full image size
			cacheManager::addThemeCacheSize($me, getThemeOption('thumb_size'), NULL, NULL, NULL, NULL, NULL, NULL, true, getOption('Image_watermark'), NULL, NULL); // default thumb
			cacheManager::addThemeCacheSize($me, getThemeOption('zpbase_galbigsize'), NULL, NULL, NULL, NULL, NULL, NULL, false, getOption('fullimage_watermark'), NULL, NULL); //slideshow big image
			cacheManager::addThemeCacheSize($me, NULL, NULL, getOption('zpbase_sds_maxheight'), NULL, NULL, NULL, NULL, true, getOption('Image_watermark'), NULL, NULL); //sds layout image	
		}
	}
	
	function getOptionsDisabled() {
		return array('thumb_size','custom_index_page','image_size');
	}
	
	function getOptionsSupported() {
		$showdates_checkboxes = array(
			gettext('Albums') => 'zpbase_date_albums', 
			gettext('Images') => 'zpbase_date_images', 
			gettext('News') => 'zpbase_date_news', 
			gettext('Pages') => 'zpbase_date_pages'
			);
		$disqus_checkboxes = array(
			gettext('Albums') => 'zpbase_disqus_comment_form_albums', 
			gettext('Images') => 'zpbase_disqus_comment_form_images',
			gettext('Pages') => 'zpbase_disqus_comment_form_pages',
			gettext('News') => 'zpbase_disqus_comment_form_articles'
			);
		$magnific_checkboxes = array(gettext('Default Grid') => 'zpbase_magnific_grid', gettext('Masonry') => 'zpbase_magnific_masonry', gettext('Smooth DIV Scroll') => 'zpbase_magnific_sds');
		
		return array(	
			gettext('Header logo') => array('key' => 'zpbase_pnglogo', 'type' => OPTION_TYPE_CUSTOM, 
				'order' => 1, 
				'desc' => sprintf(gettext('Select a logo (files in the <em>%s</em> folder) or select to use a text logo of your gallery name. You can use the built in file uploader in Zenphoto to upload your logo file and then select it here.'),UPLOAD_FOLDER)),
			gettext('Style') => array('key' => 'zpbase_style', 'type' => OPTION_TYPE_RADIO, 
				'order' => 2,
				'buttons' => array(gettext('Light')=>'light', gettext('Dark')=>'dark'),
				'desc' => gettext("Select the contrast style you would like to use as the starting base style. You can always add custom css declarations below.")),
			gettext('Max Width of Site') => array('key' => 'zpbase_maxwidth', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>3, 
				'multilingual' => 0,
				'desc' => gettext('Set the max-width of site in pixels.  Site is fluid but will not expand beyond this width for styling and image sizing purposes. <p class="notebox">*<strong>Note:</strong> The theme uses this value also to set the default image and thumb size as a percentage of this width, so that maximum efficiency of image/thumb size is gained while still filling the column width with the image.  When you change this number, images will be re-cached on load.  It is recommended to keep the max-width in the 900-1200 range.</p>')),
			gettext('Vertical Scale Full Image') => array('key' => 'zpbase_verticalscale', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 3.1,
				'desc' => gettext("If unchecked, the full image will scale to max-width of the site.  If checked, the full image will also scale vertically to the viewport using javascript to ensure it is always entirely visible on the full image page.")),
			gettext('General Alignment') => array('key' => 'zpbase_align', 'type' => OPTION_TYPE_RADIO, 
				'order' => 4,
				'buttons' => array(gettext('Center')=>'center', gettext('Left')=>'left'),
				'desc' => gettext("Header text alignment style.")),
			gettext('Background Image') => array('key' => 'zpbase_bg', 'type' => OPTION_TYPE_CUSTOM, 
				'order' => 5, 
				'desc' => sprintf(gettext('Select an optional repeating background image from the <em>%s</em> folder. Some great, free repeating backgrounds can be found at <a href="http://www.subtlepatterns.com" target="_blank">http://subtlepatterns.com</a>. You can also use <a href="http://bradjasper.com/subtle-patterns-bookmarklet/" target="_blank">a great bookmarklet</a> to test out their backgrounds on your site instantly!'),UPLOAD_FOLDER)),
			gettext('Show Search/Archive') => array('key' => 'zpbase_archive', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 6,
				'desc' => gettext("Check to enable gallery and news search and archive functions. Note that if unchecked, tags will not be displayed as this is a search function.")),
			gettext('Show Date') => array('key' => 'zpbase_date', 'type' => OPTION_TYPE_CHECKBOX_ARRAY,
				'order' => 7,
				'checkboxes' => $showdates_checkboxes,
				'desc' => gettext("Toggle whether to display dates in albums, images, news, and pages. On \"pages\", zpbase shows last updated date if checked. Note that you need to show dates on images, or on news, for those to show on the archive page.")),
			gettext('Download Button') => array('key' => 'zpbase_download', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 8,
				'desc' => gettext("Check to enable users ability to download original image from image details page. If you want a save dialog, you will need to set the appropriate option in options->image as well (protected, download).")),
			gettext('Simple Social Sharing?') => array('key' => 'zpbase_social', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 9,
				'desc' => gettext("Check to display simple links (lightweight) for users to share to their Facebook, Google, and Twitter accounts. Make sure to enable the meta tags plugin and enable the og entries for these sites to pull the correct thumbs, titles, and descriptions upon share.")),
			gettext('Use News Feature') => array('key' => 'zpbase_usenews', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 10,
				'desc' => gettext("IF you have the Zenpage plugin enabled, you can uncheck this to NOT use the news feature of the Zenpage plugin (use only pages).")),
			gettext('News Name') => array('key' => 'zpbase_newsname', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>11, 
				'desc' => gettext('Leave blank for default zenpage naming. Option to rename the title of NEWS, to such as blog,for example.  Note this does not change the url from news.  It changes the heading title of the news page and the menu item only.')),
			gettext('No Image Detail page') => array('key' => 'zpbase_nodetailpage', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 12,
				'desc' => gettext("Check to NOT us an standard image details page (magnific popup (image or image+ details) and galleria utilization for large image viewing only). Note that if you have videos you better enable image+ details for magnific or your users would have no way to view them!")),
			gettext('Mobile Force Default Grid') => array('key' => 'zpbase_mobiletogrid', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 13,
				'desc' => gettext("Check to force default grid layout on mobile devices (recommended for javascript issues on mobiles with other layouts as well as reduceing bandwidth load).")),
			gettext('Select Drop Box') => array('key' => 'zpbase_selectmenu', 'type' => OPTION_TYPE_SELECTOR,
				'selections' => array(
					gettext('Chosen Script') => 'chosen', 
					gettext('Standard') => 'standard', 
					gettext('None') => ''), 					
				'multilingual' => 0,
				'order'=>14,
				'desc' => gettext('Select a drop down menu option (select box) which is shown various spots throughout the site. Standard is obviously the standard "print_album_menu" output, "Chosen" converts this output to a searchable list, or "none" to not display anything.')),
			gettext('Gallery Index is Homepage') => array('key' => 'zpbase_galleryishome', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 14.2,
				'desc' => gettext("Uncheck to have a separate homepage (Home) and Gallery index page (Gallery).  If unchecked, the html (source) of the homepage comes form the Gallery Description in the Gallery options.")),
			
			array('type' => OPTION_TYPE_NOTE, 
				'order' => 15,
				'desc' => gettext('<h2>Disqus Commenting</h2><hr />')),			
			gettext('Use Disqus Comments') => array('key' => 'zpbase_disqus', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 16,
				'desc' => gettext("Check to use Disqus comments, free account required on <a href=\"http://disqus.com\" target=\"_blank\">disqus.com</a>.")),
			gettext('Disqus Short Name') => array('key' => 'zpbase_disqus_shortname', 'type' => OPTION_TYPE_TEXTBOX,
				'order' => 17,
				'desc' => gettext('Enter your Disqus account short name here if you want to enable disus comments (Disqus account required, see <a href=\"http://disqus.com\" target=\"_blank\">Disqus</a> for more info.)')),
			gettext('Allow Disqus comments on') => array('key' => 'disqus_comment_form_allowed','type' => OPTION_TYPE_CHECKBOX_ARRAY,
				'order' => 18,
				'checkboxes' => $disqus_checkboxes,
				'desc' => gettext('Disqus comment forms will be presented on the checked page types.<div class="notebox">Note: Toggling comments on/off is also controlled on each individual image/album/article/page admin page.</div>')),
	
			
			array('type' => OPTION_TYPE_NOTE, 
				'order' => 20,
				'desc' => gettext('<h2>Multiple Layout Options/Defaults</h2><hr />')),
			gettext('Gallery Index Layout') => array('key' => 'zpbase_indexlayout', 'type' => OPTION_TYPE_SELECTOR,
				'selections' => array(
					gettext('Standard Grid') => 'index-grid', 
					gettext('Masonry+IS') => 'index-masonry', 
					gettext('News') => 'index-news', 					
					gettext('Galleria') => 'index-galleria', 
					gettext('Smooth DIV Scroll') => 'index-sdscroll'), 
				'multilingual' => 0,
				'order'=>21,
				'desc' => gettext('Select the gallery index layout option.')),
			gettext('Gallery Index Option') => array('key' => 'zpbase_galhomeop', 'type' => OPTION_TYPE_RADIO,
				'order' => 22,
				'buttons' => array(
								gettext('Albums')=>'albums', 
								gettext('Images')=>'images'
								),
				'desc' => gettext("Select either latest images or albums to diplay on Gallery Index (Galleria and SDS option only, others always show latest albums or news).")),
			gettext('Gallery Index Latest Image Count') => array('key' => 'zpbase_galhomecount', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>23, 
				'multilingual' => 0,
				'desc' => gettext('If you are showing latest images on a home page Galleria or Smooth DIV Scroll, enter the image count (number!) to display here.')),
			
			gettext('Default Album Layout') => array('key' => 'zpbase_defaultalbum', 'type' => OPTION_TYPE_SELECTOR,
				'selections' => array(
					gettext('Standard Grid') => 'album-grid', 
					gettext('Masonry+IS') => 'album-masonry', 
					gettext('Galleria') => 'album-galleria', 
					gettext('Smooth DIV Scroll') => 'album-sdscroll'), 
				'multilingual' => 0,
				'order'=>24,
				'desc' => gettext('Select the default album layout.  You can also always choose individually per album with the multiple layout plugin enabled.')),
			gettext('News Page Style') => array('key' => 'zpbase_newsstyle', 'type' => OPTION_TYPE_RADIO,
				'buttons' => array(
					gettext('Blog Style') => 'blog-style', 
					gettext('Masonry Style') => 'masonry-style'
					),
				'multilingual' => 0,
				'order'=>25,
				'desc' => gettext('Select the style to display the news page, affects both standard news page and news gallery index page option.')),
			gettext('Search Page Style') => array('key' => 'zpbase_searchlayout', 'type' => OPTION_TYPE_RADIO,
				'buttons' => array(
					gettext('Standard Grid Style') => 'search-grid', 
					gettext('Masonry Style') => 'search-masonry'
					),
				'multilingual' => 0,
				'order'=>26,
				'desc' => gettext('Select the style to display the search page, affects both search and archive displays.')),
			gettext('Infinite Scroll Behavior') => array('key' => 'zpbase_iscrollbehavior', 'type' => OPTION_TYPE_SELECTOR,
				'selections' => array(
					gettext('Automatic') => 'auto', 
					gettext('Manual first, then auto') => 'manual-first', 
					gettext('Manual always') => 'manual-always'), 
				'multilingual' => 0,
				'order'=>27,
				'desc' => gettext('Select the infinite scroll behavior. Auto will load pages/items automatically when user scrolls. Manual first will require user to click next the first time then load items auto after that (allows user to get to the footer first time if so chooses). Manual always requires user click to load additional items.')),
				
			array('type' => OPTION_TYPE_NOTE, 
				'order' => 30,
				'desc' => gettext("<h2>Galleria Layout and Slideshow Options - <em>Note: Options apply to the custom slideshow, and both album layout and homepage layout if set.</em></h2><hr />")),
			gettext('Galleria Default Slideshow Engine') => array('key' => 'zpbase_galss', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 31,
				'desc' => gettext("Check to use the custom Galleria slideshow as the default slideshow engine for all layouts. Note that slideshow links will not appear on layouts already using galleria, as the slideshow is already available in that layout. It is recommended if using this slideshow to disable the core slideshow plugin to prevent uneeded script loading.")),
			gettext('Galleria Crop Option') => array('key' => 'zpbase_galcropop', 'type' => OPTION_TYPE_SELECTOR,
				'order' => 32,
				'selections' => array(
								gettext('True')=>'true', 
								gettext('False')=>'false', 
								gettext('Height')=>'height', 
								gettext('Width')=>'width', 
								gettext('Landscape')=>'landscape', 
								gettext('Portrait')=>'portrait'
								),
				'desc' => gettext("Select how Galleria should fit the images in the Galleria stage.  See <a href=\"http://galleria.io/docs/options/imageCrop/\" target=\"_blank\">Galleria options</a> for more info.")),
			gettext('Galleria Image pan') => array('key' => 'zpbase_galpan', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 33,
				'desc' => gettext("Check to allow image panning on cropped images.")),
			
			gettext('Galleria Initial Caption Display') => array('key' => 'zpbase_galcaption', 'type' => OPTION_TYPE_RADIO,
				'order' => 34,
				'buttons' => array(
								gettext('Visible')=>true, 
								gettext('Hidden')=>false
								),
				'desc' => gettext("Select if image or album caption should be intially visible, or hidden with an info link.")),
			gettext('Galleria Slide Advance') => array('key' => 'zpbase_galautoplay', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 35,
				'desc' => gettext('Check to autoplay Galleria. In slideshow mode, galleria will always autoplays regardless of this setting.')),
			gettext('Galleria Click Next') => array('key' => 'zpbase_galclicknext', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 36,
				'desc' => gettext("Check to advance to next slide on mouse click instead of linking to image details page.")),
			gettext('Interval') => array('key' => 'zpbase_galinterval', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>37, 
				'multilingual' => 0,
				'desc' => gettext('Enter the slide advancement interval in milliseconds (4000 equals 4 seconds).')),
			gettext('Transition') => array('key' => 'zpbase_galtrans', 'type' => OPTION_TYPE_SELECTOR,
				'selections' => array(
					gettext('Fade') => 'fade', 
					gettext('Flash') => 'flash', 
					gettext('Pulse') => 'pulse',
					gettext('Fade-Slide') => 'fadeslide',  					
					gettext('Slide') => 'slide'), 
				'multilingual' => 0,
				'order'=>38,
				'desc' => gettext('The transition that is used when displaying the images in Galleria.')),
			gettext('Transition Speed') => array('key' => 'zpbase_galtranspeed', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>39, 
				'multilingual' => 0,
				'desc' => gettext('Enter the slide transition speed in milliseconds (400 default).')),
			gettext('Galleria History Plugin') => array('key' => 'zpbase_galhistory', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 40,
				'desc' => gettext("Check to enable Galleria history plugin, giving each image a unique url. Back/forward browser buttons work, able to bookmark, send direct links to images in Galleria, etc. Note you cannot send links of the slideshow page, as this is created on the fly with POST data.")),
			gettext('Galleria Fullscreen Image Size') => array('key' => 'zpbase_galbigsize', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>41, 
				'multilingual' => 0,
				'desc' => gettext('Enter the image pixel size to create for the large, fullscreen slideshow (1200 default).')),
			
			array('type' => OPTION_TYPE_NOTE, 
				'order' => 45,
				'desc' => gettext("<h2>Smooth DIV Scroll Layout Options</h2><hr />")),
			gettext('Pagination') => array('key' => 'zpbase_sds_pagination', 'type' => OPTION_TYPE_RADIO,
				'order' => 46,
				'buttons' => array(
								gettext('Show All Always')=>'all', 
								gettext('Show All on Home')=>'home-all', 
								gettext('Paginate')=>'paginate'
								),
				'desc' => gettext("Select if layout should show all items, or pagination. You can also just show all on the optional home page sds layout, and paginate the albums. Showing all on large galleries or albums is not recomended.")),
			gettext('Max-height') => array('key' => 'zpbase_sds_maxheight', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>47, 
				'multilingual' => 0,
				'desc' => gettext('Enter the max height of the scrolling division. This will scale down on smaller displays vias css. SDS creates new cached images for it\'s layout.  You can recache batches using the cache manager plugin.')),
			
			array('type' => OPTION_TYPE_NOTE, 
				'order' => 50,
				'desc' => gettext("<h2>Magnific Popup Options</h2><hr />")),
			gettext('Enable Magnific Popup on') => array('key' => 'zpbase_magnific_enabled','type' => OPTION_TYPE_CHECKBOX_ARRAY,
				'order' => 51,
				'checkboxes' => $magnific_checkboxes,
				'desc' => gettext('Check which layouts to enable <a target="_blank" href="http://dimsemenov.com/plugins/magnific-popup/">Magnific popup</a>. <div class="notebox">Note: Magnific popup will activate automatically when setting the option - "no image details page".</div>')),
			gettext('Magnific Target') => array('key' => 'zpbase_magnific_target', 'type' => OPTION_TYPE_RADIO,
				'order' => 52,
				'buttons' => array(
								gettext('Image Only')=>'image', 
								gettext('Image+ Details ')=>'imagepage'
								),
				'desc' => gettext('Image popup can be either just the image or a custom image detail page showing (if enabled) the image, title, description, tags, rating, comments. <div class="notebox">Note: Image+ Details option goes very well with the option above - "no image details page".</div>')),
			
			array('type' => OPTION_TYPE_NOTE, 
				'order' => 60,
				'desc' => gettext("<h2>Advanced - Custom Google fonts and analytics, CSS, font size - <em>Allows custom CSS styles and usage of additional Google Fonts as well.</em></h2><hr />")),
			gettext('Custom font for body text') => array('key' => 'zpbase_googlefont1', 'type' => OPTION_TYPE_SELECTOR,
				'selections' => array(
					gettext('NONE') => '',
					gettext('Josephin Slab') => 'Josephin+Slab', 
					gettext('Lato') => 'Lato', 
					gettext('Bree Serif') => 'Bree+Serif', 
					gettext('Cabin') => 'Cabin', 
					gettext('Droid Sans') => 'Droid+Sans', 
					gettext('Droid Serif') => 'Droid+Serif', 
					gettext('Lobster') => 'Lobster', 
					gettext('Lobster Two') => 'Lobster+Two', 
					gettext('Lora') => 'Lora', 
					gettext('Open Sans') => 'Open+Sans', 
					gettext('Oswald') => 'Oswald', 
					gettext('Pacifico') => 'Pacifico', 
					gettext('Patua One') => 'Patua+One', 
					gettext('Poly') => 'Poly', 
					gettext('PT Sans') => 'PT+Sans', 
					gettext('Source Sans Pro') => 'Source+Sans+Pro', 
					gettext('Varela Round') => 'Verela+Round', 
					gettext('Vollkorn') => 'Vollkorn', 		
					gettext('Arvo') => 'Arvo'), 
				'multilingual' => 0,
				'order'=>61,
				'desc' => gettext('Optionally select a google font to use for the body and menu text.')),
			gettext('Custom font for header text') => array('key' => 'zpbase_googlefont2', 'type' => OPTION_TYPE_SELECTOR,
				'selections' => array(
					gettext('NONE') => '',
					gettext('Josephin Slab') => 'Josephin+Slab', 
					gettext('Lato') => 'Lato', 
					gettext('Bree Serif') => 'Bree+Serif', 
					gettext('Cabin') => 'Cabin', 
					gettext('Droid Sans') => 'Droid+Sans', 
					gettext('Droid Serif') => 'Droid+Serif', 
					gettext('Lobster') => 'Lobster', 
					gettext('Lobster Two') => 'Lobster+Two', 
					gettext('Lora') => 'Lora', 
					gettext('Open Sans') => 'Open+Sans', 
					gettext('Oswald') => 'Oswald', 
					gettext('Pacifico') => 'Pacifico', 
					gettext('Patua One') => 'Patua+One', 
					gettext('Poly') => 'Poly', 
					gettext('PT Sans') => 'PT+Sans', 
					gettext('Source Sans Pro') => 'Source+Sans+Pro', 
					gettext('Varela Round') => 'Verela+Round', 
					gettext('Vollkorn') => 'Vollkorn', 		
					gettext('Arvo') => 'Arvo'),  
				'multilingual' => 0,
				'order'=>62,
				'desc' => gettext('Optionally select a google font to use for header (h1, h2, etc) text.')),
			gettext('Base Font Size') => array('key' => 'zpbase_fontsize', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>63, 
				'multilingual' => 0,
				'desc' => gettext('Enter a base font size in pixels (10-18).  All other font-sizes are taken as percentages of this. Note: Any number outside this range will default back to 12.')),
			
			gettext('Custom CSS') => array('key' => 'zpbase_customcss', 'type' => OPTION_TYPE_TEXTAREA, 
				'order'=>64, 
				'multilingual' => 0,
				'desc' => gettext('Enter any custom CSS, safely carries over upon theme upgrade. Will be placed between style tags in the head.')),
			gettext('Google Tracking Code') => array('key' => 'zpbase_analytics', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>65, 
				'multilingual' => 0,
				'desc' => gettext('Enter your Google Analytics Universal Tracking Id here to auto insert the tracking code on every page (UA-...). Leave blank to omit. Note that the analytics code will not be outputted for admin users, so that administrator page visits will not be counted.')),
			gettext('Tracking Type') => array('key' => 'zpbase_analytics_type', 'type' => OPTION_TYPE_RADIO, 
				'order' => 66,
				'buttons' => array(gettext('Universal')=>'universal', gettext('Classic')=>'classic'),
				'desc' => gettext("Select what type of analytics you are using. See your Google analytics account for explanations.")),
				
			array('type' => OPTION_TYPE_NOTE, 
				'order' => 70,
				'desc' => gettext("<h2>Site Footer Options</h2><hr />")),
			gettext('Facebook Link') => array('key' => 'zpbase_facebook', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>71, 
				'multilingual' => 0,
				'desc' => gettext('Enter your full Facebook page link (http://....). Leave blank to omit.')),
			gettext('Twitter Link') => array('key' => 'zpbase_twitter', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>72, 
				'multilingual' => 0,
				'desc' => gettext('Enter your full Twitter page link (http://....). Leave blank to omit.')),
			gettext('Google+ Link') => array('key' => 'zpbase_google', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>73, 
				'multilingual' => 0,
				'desc' => gettext('Enter your full Google+ page link (http://....). Leave blank to omit.')),
			gettext('Copyright Text') => array('key' => 'zpbase_copy', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>74, 
				'multilingual' => 0,
				'desc' => gettext('Edit text for footer copyright. Leave blank to omit.'))
			
		
							
		);
	}
	
	function handleOption($option, $currentValue) {
		if($option == "zpbase_pnglogo") { ?>
			<select id="zpbase_pnglogo" name="zpbase_pnglogo">
				<option value="" style="background-color:LightGray"><?php echo gettext('*Use Gallery Name Text'); ?></option>';
				<?php zp_apply_filter('theme_head');
				generateListFromFiles($currentValue, SERVERPATH.'/'.UPLOAD_FOLDER,'');
				?>
			</select>	
		<?php }
		if($option == "zpbase_bg") { ?>
			<select id="zpbase_bg" name="zpbase_bg">
				<option value="" style="background-color:LightGray"><?php echo gettext('* no bg image'); ?></option>';
				<?php zp_apply_filter('theme_head');
				generateListFromFiles($currentValue, SERVERPATH.'/'.UPLOAD_FOLDER,'');
				?>
			</select>	
		<?php }
	}
}
?>
