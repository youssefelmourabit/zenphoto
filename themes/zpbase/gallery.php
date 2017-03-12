<?php
/*	zpBase index.php 
*	This theme page is the home page starting page, which loads the homepage script based on the option settings.
*	http://www.oswebcreations.com
================================================== */

if (($isMobile) && (getOption('zpbase_mobiletogrid'))) { 
$indexlayout = 'inc/index-grid.php';
} else {
$indexlayout = 'inc/'.getOption('zpbase_indexlayout').'.php';
}
include ($indexlayout);
?>