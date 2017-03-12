<?php
/*	zpBase register.php 
*	This theme page shows the user registration form if this plugin is enabled.
*	http://www.oswebcreations.com
================================================== */

if (function_exists('printRegistrationForm')) {
include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<h1><?php echo gettext('User Registration') ?></h1>
				<?php printRegistrationForm(); ?>
			</div>				
		</div>
	</div>

<?php include ('inc/footer.php');
} else {
	include(dirname(__FILE__).'/404.php');
} ?>