<?php
/*	zpBase contact.php 
*	This theme page shows the standard contact form of the contact plugin if enabled.
*	http://www.oswebcreations.com
================================================== */

if (function_exists('printContactForm')) {
include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<h1><?php echo gettext("Contact"); ?></h1>
				<?php printContactForm(); ?>
			</div>				
		</div>
	</div>

<?php include ('inc/footer.php');
} else {
	include (dirname(__FILE__).'/404.php');
} ?>