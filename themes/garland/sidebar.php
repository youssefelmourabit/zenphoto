<?php

// force UTF-8 Ø

if (getOption('Allow_search')) {
	switch ($_zp_gallery_page) {
		case 'album.php':
		case 'image.php':
			$list = array('albums'=>array($_zp_current_album->name),'pages'=>'0', 'news'=>'0');
			$text = gettext('Search album');
			break;
		case 'gallery.php':
			$list = array('albums'=>'1','pages'=>'0', 'news'=>'0');
			$text = gettext('Search albums');
			break;
		case 'pages.php':
			$list = array('albums'=>'0','pages'=>'1', 'news'=>'0');
			$text = gettext('Search pages');
			break;
		case 'news.php':
			if (is_NewsCategory()) {
				$list = array('news'=>array($_zp_current_category->getTitlelink()),'albums'=>'0','images'=>'0','pages'=>'0');
				$text = gettext('Search category');
			} else {
				$list = array('news'=>'1','albums'=>'0','images'=>'0','pages'=>'0');
				$text = gettext("Search news");
			}
			break;
		case 'search.php':
			if (is_array($_zp_current_search->category_list)) {
				$list = array('news'=>$_zp_current_search->category_list,'albums'=>'0','images'=>'0','pages'=>'0');
				$text = gettext('Search within category');
			} else {
				if (is_array($_zp_current_search->album_list)) {
					$list = array('albums'=>$_zp_current_search->album_list,'pages'=>'0', 'news'=>'0');
					$text = gettext('Search within album');
				} else {
					$list = NULL;
					$text =gettext('Search gallery');
				}
			}
			break;
		default:
			$list = NULL;
			$text = gettext('Search gallery');
			break;
	}
	printSearchForm(NULL, 'search', NULL, $text, NULL, NULL, $list);
}

if(function_exists('printCustomMenu') && ($menu = getOption('garland_menu'))) {
	?>
	<div class="menu">
		<?php
		printCustomMenu($menu,'list','',"menu-active","submenu","menu-active",2);
		?>
	</div>
	<?php
} else {	//	"standard zenpage sidebar menus
	if(function_exists("printAllNewsCategories")) {
		?>
		<div class="menu">
			<h3><?php echo gettext("News articles"); ?></h3>
			<?php
			printAllNewsCategories(gettext("All news"),TRUE,"news_menu","menu",true,"menu_sub","menu_sub_active");
			?>
		</div>
		<?php
		}
	?>

	<?php
	if(function_exists("printAlbumMenu")) {
		?>
		<div class="menu">
			<h3><?php echo gettext("Gallery"); ?></h3>
			<?php
			$gallery = '';
			if (getOption('zp_plugin_zenpage')) {
				if ($_zp_gallery_page == 'index.php' || $_zp_gallery_page != 'gallery.php') {
					$gallery = gettext('Album index');
				}
			}
			printAlbumMenu("list","count","album_menu","menu","menu_sub","menu_sub_active", $gallery);
			?>
		</div>
		<?php
	} else {
		if (getOption('zp_plugin_zenpage')) {
			?>
			<div class="menu">
				<h3><?php echo gettext("Albums"); ?></h3>
				<ul id="album_menu">
					<li>
						<a href="<?php echo html_encode(getCustomPageURL('gallery')); ?>" title="<?php echo gettext('Album index'); ?>"><?php echo gettext('Album index'); ?></a>
					</li>
				</ul>
			</div>
			<?php
		}
	}
	?>

	<?php
	if(function_exists("printPageMenu")) {
		?>
		<div class="menu">
			<h3><?php echo gettext("Pages"); ?></h3>
			<?php
			printPageMenu("list","page_menu","menu-active","submenu","menu-active"); ?>
		</div>
		<?php
	}
}
?>