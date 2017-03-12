<?php
/*	zpBase 404.php 
*	This theme page is displayed when there is an error 404 page not found.
*	http://www.oswebcreations.com
================================================== */

include ('inc/header.php'); ?>
			
	<div class="container" id="middle">
		<div class="row">
			<div id="content"<?php if (getOption('zpbase_align') == 'center') echo ' class="center"'; ?>>
				<h1><?php echo gettext('404 not found'); ?></h1>
				<p><?php echo gettext('The page you are requesting cannot be found.'); ?></p>		
			</div>
		</div>
	</div> 

<?php include ('inc/footer.php'); ?>