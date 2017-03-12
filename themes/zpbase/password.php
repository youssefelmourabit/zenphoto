<?php
/*	zpBase password.php 
*	This theme page shows the login form when a user is trying to access something that is password protected.
*	http://www.oswebcreations.com
================================================== */

include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<h1><?php echo gettext('Login'); ?></h1>
				<?php printPasswordForm($hint, $show); ?>
				<?php if (!zp_loggedin() && function_exists('printRegistrationForm') && $_zp_gallery->isUnprotectedPage('register')) {
				printCustomPageURL(gettext('Register for this site'), 'register', '', '<br />');
				} ?>
			</div>				
		</div>
	</div>

<?php include ('inc/footer.php'); ?>