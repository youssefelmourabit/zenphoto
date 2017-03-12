<?php
/*	zpBase login.php 
*	This theme page shows the login form when the login link is accessed from the user login-out plugin (login link shown in footer).
*	http://www.oswebcreations.com
================================================== */

if (function_exists('printUserLogin_out')) {
include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content">
				<h1><?php echo gettext('Login'); ?></h1>
				<?php printUserLogin_out('','',true); ?>
			</div>				
		</div>
	</div>

<?php include ('inc/footer.php');
} else {
	include(dirname(__FILE__).'/404.php');
} ?>