<?php
/*	zpBase functions.php
* 	This file (functions.php) is auto included when setting up the environment for each page, no need to include it manually.
*	http://www.oswebcreations.com	
================================================== */
// force UTF-8 Ø

// Check for lack of zenphoto setting thumb and image sizes until visiting theme option page (can't figure out why this is needed).
if (!getOption('thumb_size')) { 
	$noset = true;
	setOption('thumb_size',298,null,'zpbase'); 
	setOption('image_size',960,null,'zpbase'); 
} else {
	$noset = false;
}

// Check for mobile and tablets, set some options if so...
require_once (SERVERPATH . '/' . ZENFOLDER . '/' . PLUGIN_FOLDER . '/mobileTheme/Mobile_Detect.php');
$detect = new Mobile_Detect;
if ($detect->isTablet()) { $isTablet = true; } else { $isTablet = false; }
if ($detect->isMobile() && !$detect->isTablet()) { $isMobile = true; } else { $isMobile = false; }

if ($isMobile) { 
	setOption('image_size',400,false); 
	setOption('zpbase_galbigsize',400,false);
	if (getOption('zpbase_mobiletogrid')) {
		setOption('zpbase_defaultalbum','album-grid',false);
		setOption('zpbase_newsstyle','blog-style',false);
		setOption('zpbase_searchlayout','search-grid',false);
	}
}

// Check some settings
$zenpage = extensionEnabled('zenpage');
if (getOption('zpbase_newsname') == '') { $newsname = gettext('News'); } else { $newsname = getOption('zpbase_newsname'); }

$image_page = 'popup';
$galleryactive = '';
$layoutbodyclass = '';
$sspage = false;
$objectclass = '';
$rss_option = null;
$rss_title = null;

// tinymce input not good for responsiveness...overkill anyway.
setThemeOption('tinymce4_comments',false,null,'zpbase'); 

function my_checkPageValidity($request, $gallery_page, $page) {
	switch ($gallery_page) {
		case 'gallery.php':
			$gallery_page = 'index.php'; //	same as an album gallery index
			break;
		case 'index.php':
			if (!extensionEnabled('zenpage') || (getOption('zbase_indexlayout') != 'news')) { // only one index page if zenpage plugin is enabled & displaying
				break;
			}
		default:
			if ($page != 1) {
				return false;
			}
		case 'news.php':
		case 'album.php':
		case 'search.php':
			break;
	}
	return checkPageValidity($request, $gallery_page, $page);
}

/**
 * makex news page 1 link go to the index page
 * @param type $link
 * @param type $obj
 * @param type $page
 */
function newsOnIndex($link, $obj, $page) {
	if (is_string($obj) && $obj == 'news.php' && $page < 2) {
		return rtrim(WEBPATH, '/') . '/';
	}
	return $link;
}

if (!OFFSET_PATH) {
	$_zp_page_check = 'my_checkPageValidity';
	if (extensionEnabled('zenpage') && (getOption('zbase_indexlayout') == 'news')) { // only one index page if zenpage plugin is enabled & displaying
		zp_register_filter('getLink', 'newsOnIndex');
	}
}


// optional disqus integration.
function printDisqusCommentForm() { 
	global $_zp_gallery_page,$_zp_current_image,$_zp_current_album,$_zp_current_zenpage_news,$_zp_current_zenpage_page;
	$zpdisqus_shortname = getOption('zpbase_disqus_shortname');
	$comments_open = false;
	switch ($_zp_gallery_page) {
		case 'image.php':
			if (!getOption('zpbase_disqus_comment_form_images')) return;
			$comments_open = $_zp_current_image->getCommentsAllowed();
			$zpdisqus_id = 'image'.$_zp_current_image->getID();
			$zpdisqus_title = $_zp_current_image->getTitle();
			break;
		case 'album.php':
			if (!getOption('zpbase_disqus_comment_form_albums')) return;
			$comments_open = $_zp_current_album->getCommentsAllowed();
			$zpdisqus_id = 'album'.$_zp_current_album->getID();
			$zpdisqus_title = $_zp_current_album->getTitle();
			break;
		case 'news.php':
			if (!getOption('zpbase_disqus_comment_form_articles')) return;
			$comments_open = $_zp_current_zenpage_news->getCommentsAllowed();
			$zpdisqus_id = 'news'.getNewsID();
			$zpdisqus_title = $_zp_current_zenpage_news->getTitle();
			break;
		case 'pages.php':
			if (!getOption('zpbase_disqus_comment_form_pages')) return;
			$comments_open = $_zp_current_zenpage_page->getCommentsAllowed();
			$zpdisqus_id = 'page'.getPageID();
			$zpdisqus_title = $_zp_current_zenpage_page->getTitle();
			break;
	}
	if (($zpdisqus_shortname != '') && ($comments_open)) { ?>

	<div id="disqus_thread"></div>
	<script type="text/javascript">
		var disqus_shortname = '<?php echo $zpdisqus_shortname; ?>';
		var disqus_identifier = '<?php echo $zpdisqus_id; ?>';
		var disqus_title = '<?php echo $zpdisqus_title; ?>';
		(function() {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
	</script>
	<?php 
	} elseif ($zpdisqus_shortname == '') {
		echo '<h3>'.gettext('Disqus shortname is not being provided...please contact the admin of this site').'</h3>';
	}
}


function printBaseAlbumMenuJump($option = "count", $indexname = "Gallery Index", $firstimagelink = false) {
	$type = getOption('zpbase_selectmenu');
	if ($type) {
	require_once (SERVERPATH . '/' . ZENFOLDER . '/' . PLUGIN_FOLDER . '/print_album_menu.php');
	global $_zp_gallery, $_zp_current_album, $_zp_gallery_page;
	$albumpath = rewrite_path("/", "/index.php?album=");
	if (!is_null($_zp_current_album) || $_zp_gallery_page == 'album.php') {
		$currentfolder = $_zp_current_album->name;
	}
	
	if ($type == 'standard') {
	?>
	<script type="text/javaScript">
		// <!-- <![CDATA[
		function gotoLink(form) {
		var OptionIndex=form.ListBoxURL.selectedIndex;
		parent.location = form.ListBoxURL.options[OptionIndex].value;
		}
		// ]]> -->
	</script>
	<form>
	<select name="ListBoxURL" size="1" onchange="gotoLink(this.form);">
	<?php } else { ?>
	<form>
	<select>
	<?php }
	
	if (getOption('zpbase_galleryishome')) { 
		if (($_zp_gallery_page == "index.php") || ($_zp_gallery_page == "album.php")) { ?>
		<option <?php if ($_zp_gallery_page == "index.php") echo 'selected'; ?> value="<?php echo html_encode(getGalleryIndexURL()); ?>"><?php echo $indexname; ?></option>
		<?php } else { ?>
		<option selected value=""><?php echo gettext('Select Album...'); ?></option>
		<option value="<?php echo html_encode(getGalleryIndexURL()); ?>"><?php echo $indexname; ?></option>
		<?php } 
	} else { ?>
		<option <?php if ($_zp_gallery_page == "index.php") echo 'selected'; ?> value="<?php echo html_encode(getGalleryIndexURL()); ?>"><?php echo gettext('Home'); ?></option>
		<?php if (($_zp_gallery_page == "gallery.php") || ($_zp_gallery_page == "album.php")) { ?>
		<option <?php if ($_zp_gallery_page == "gallery.php") echo 'selected'; ?> value="<?php echo getCustomPageURL('gallery'); ?>"><?php echo $indexname; ?></option>
		<?php } else { ?>
		<?php if ($_zp_gallery_page != "index.php") { ?><option selected value=""><?php echo gettext('Select Album...'); ?></option><?php } ?>
		<option value="<?php echo getCustomPageURL('gallery'); ?>"><?php echo $indexname; ?></option>
		<?php }
	}
	printAlbumMenuJump($option,"", $firstimagelink, NULL, true);
	?>
	</select>
	</form>
	
<?php }
}

	
// check to see if album contains more than 1 valid photo (vs. video or other), for slideshow link check.
function checkForImages() { 
	global $_zp_current_image, $_zp_current_album, $_zp_current_search, $_zp_gallery;
	$c = 0;
	while (next_image()):
		if (isImagePhoto()) $c++;
	endwhile;
	if ($c > 0) {
		return true;
	} else {
		return false;
	}
}	
	
function printBaseSlideShowLink($linktext = null) {
		global $_zp_gallery, $_zp_current_image, $_zp_current_album, $_zp_current_search, $slideshow_instance, $_zp_gallery_page;
		if (is_null($linktext)) {
			$linktext = gettext('View Slideshow');
		}
		if (empty($_GET['page'])) {
			$pagenr = 1;
		} else {
			$pagenr = sanitize_numeric($_GET['page']);
		}
		$slideshowhidden = '';
		$numberofimages = 0;
		if (in_context(ZP_SEARCH)) {
			$imagenumber = '';
			$imagefile = '';
			$albumnr = 0;
			$slideshowlink = rewrite_path('/' . _PAGE_ . '/slideshow', "index.php?p=slideshow");
			$slideshowhidden = '<input type="hidden" name="preserve_search_params" value="' . html_encode($_zp_current_search->getSearchParams()) . '" />';
		} else {
			if (in_context(ZP_IMAGE)) {
				$imagenumber = imageNumber();
				$imagefile = $_zp_current_image->filename;
			} else {
				$imagenumber = '';
				$imagefile = '';
			}
			if (in_context(ZP_SEARCH_LINKED)) {
				$albumnr = -$_zp_current_album->getID();
				$slideshowhidden = '<input type="hidden" name="preserve_search_params" value="' . html_encode($_zp_current_search->getSearchParams()) . '" />';
			} else {
				$albumnr = $_zp_current_album->getID();
			}
			if ($albumnr) {
				$slideshowlink = rewrite_path(pathurlencode($_zp_current_album->getFileName()) . '/' . _PAGE_ . '/slideshow', "index.php?p=slideshow&amp;album=" . urlencode($_zp_current_album->getFileName()));
			} else {
				$slideshowlink = rewrite_path('/' . _PAGE_ . '/slideshow', "index.php?p=slideshow");
				$slideshowhidden = '<input type="hidden" name="favorites_page" value="1" />';
			}
		}
		//$numberofimages = getNumImages();
		$slideshow_instance = 0;
		if (checkForImages()) { ?>
			<form name="slideshow_<?php echo $slideshow_instance; ?>" method="post"	action="<?php echo $slideshowlink; ?>">
				<?php echo $slideshowhidden; ?>
				<input type="hidden" name="pagenr" value="<?php echo html_encode($pagenr); ?>" />
				<input type="hidden" name="albumid" value="<?php echo $albumnr; ?>" />
				<input type="hidden" name="numberofimages" value="<?php echo $numberofimages; ?>" />
				<input type="hidden" name="imagenumber" value="<?php echo $imagenumber; ?>" />
				<input type="hidden" name="imagefile" value="<?php echo html_encode($imagefile); ?>" />
				<a class="slideshowlink" id="slideshowlink_<?php echo $slideshow_instance; ?>" 	href="javascript:document.slideshow_<?php echo $slideshow_instance; ?>.submit()"><?php echo $linktext; ?></a>
			</form>
		<?php }
		
	}


	function printBaseSlideShow() {
		global $_zp_gallery, $_zp_gallery_page, $_myFavorites, $_zp_conf_vars, $_zp_themeroot, $isMobile, $isTablet;
		if (!isset($_POST['albumid'])) {
			return '<div class="errorbox" id="message"><h2>' . gettext('Invalid linking to the slideshow page.') . '</h2></div>';
		}
		//getting the image to start with
		if (!empty($_POST['imagenumber'])) {
			$imagenumber = sanitize_numeric($_POST['imagenumber']) - 1; // slideshows starts with 0, but zp with 1.
		} else {
			$imagenumber = 0;
		}
		
		// set pagenumber to 0 if not called via POST link
		if (isset($_POST['pagenr'])) {
			$pagenumber = sanitize_numeric($_POST['pagenr']);
		} else {
			$pagenumber = 1;
		}
		// getting the number of images
		if (!empty($_POST['numberofimages'])) {
			$numberofimages = sanitize_numeric($_POST['numberofimages']);
		} else {
			$numberofimages = 0;
		}
		//if ($imagenumber < 2 || $imagenumber > $numberofimages) {
		//	$imagenumber = 0;
		//}
		//getting the album to show
		if (!empty($_POST['albumid'])) {
			$albumid = sanitize_numeric($_POST['albumid']);
		} else {
			$albumid = 0;
		}

		if (isset($_POST['preserve_search_params'])) { // search page
			$search = new SearchEngine();
			$params = sanitize($_POST['preserve_search_params']);
			$search->setSearchParams($params);
			$searchwords = $search->getSearchWords();
			$searchdate = $search->getSearchDate();
			$searchfields = $search->getSearchFields(true);
			$page = $search->page;
			$returnpath = getSearchURL($searchwords, $searchdate, $searchfields, $page);
			$albumobj = new AlbumBase(NULL, false);
			$albumobj->setTitle(gettext('Search'));
			$albumobj->images = $search->getImages(0);
			$albumtitle = gettext('Search');
		} else {
			if (isset($_POST['favorites_page'])) {
				$albumobj = $_myFavorites;
				$returnpath = rewrite_path($_myFavorites->getLink() . '/' . $pagenumber, FULLWEBPATH . '/index.php?p=favorites' . '&page=' . $pagenumber);
				$albumtitle = gettext('Favorites');
			} else {
				$albumq = query_single_row("SELECT title, folder FROM " . prefix('albums') . " WHERE id = " . $albumid);
				$albumobj = newAlbum($albumq['folder']);
				$albumtitle = $albumobj->getTitle();
				if (empty($_POST['imagenumber'])) {
					$returnpath = $albumobj->getLink($pagenumber);
				} else {
					$image = newImage($albumobj, sanitize($_POST['imagefile']));
					$returnpath = $image->getLink();
				}
			}
		}
		if (!$albumobj->isMyItem(LIST_RIGHTS) && !checkAlbumPassword($albumobj)) {
			return '<div class="errorbox" id="message"><h2>' . gettext('This album is password protected!') . '</h2></div>';
		}
		$slideshow = '';
		$numberofimages = $albumobj->getNumImages();
		if ($numberofimages == 0) {
			return '<div class="errorbox" id="message"><h2>' . gettext('No images for the slideshow!') . '</h2></div>';
		}
		$images = $albumobj->getImages(0);
		// slideshow generate data for galleria
		?>
		<script>
			var data = [				
			<?php 
			for ($c = 0, $idx = 0; $c < $numberofimages; $c++, $idx++) {
				if (is_array($images[$idx])) {
					$filename = $images[$idx]['filename'];
					$album = newAlbum($images[$idx]['folder']);
					$image = newImage($album, $filename);
				} else {
					$filename = $images[$idx];
					$image = newImage($albumobj, $filename);
				}
				if (isImagePhoto($image)) {
					makeImageCurrent($image);
					echo '{'."\n";
						echo 'thumb: \''.getImageThumb().'\','."\n";
						echo 'image: \''.getDefaultSizedImage().'\','."\n";
						echo 'big: \''.getCustomImageURL(getOption('zpbase_galbigsize')).'\','."\n";
						echo 'title: \''.js_encode($image->getTitle()).'\','."\n";
						$desc = $image->getDesc();
						$desc = str_replace("\r\n", '<br />', $desc);
						$desc = str_replace("\r", '<br />', $desc);
						echo 'description: \''.js_encode($desc).'\','."\n";
						if (!(getOption('zpbase_nodetailpage'))) { echo 'link: \''.html_encode($image->getLink()).'\''."\n"; }
					if ($c == $numberofimages - 1) { echo '}'."\n"; } else { echo '},'."\n"; }
				} else {
				if (($imagenumber > 0) && ($imagenumber > $c)) $imagenumber--;
				}
				
			}
			echo "\n";
			?>	
			];
		</script>	
		<?php 
		$sspage = true;
		require_once('inc/galleria-jscall.php'); 
	} 

?>