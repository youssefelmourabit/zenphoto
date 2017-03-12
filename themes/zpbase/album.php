<?php
/*	zpBase album.php 
*	redirects to an actual album script, depending on options set.  
*	The album.php file is used to display the album thumbnails.
*	http://www.oswebcreations.com
================================================== */

$albumlayout = getOption('zpbase_defaultalbum').'.php';
include ($albumlayout);
?>