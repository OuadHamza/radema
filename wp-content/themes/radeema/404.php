<?php get_header(); ?>

<div class="container text-center py-5 page-404">

	<h1 class="error-code">404 !</h1>
	<h1 class="error-title"><?php translate_options_radeema("This page doesn't exist", 'radeema' ) ?></h1>
	<p class="error-desc"><?= translate_options_radeema('Sorry, the page you are looking for could not be found', 'radeema') ?>.</p>
	<p><?= translate_options_radeema('Try to look for something else ', 'radeema') ?>...</p>
	<?php get_search_form() ?>
	<p><?= translate_options_radeema('Or you can return to our', 'radeema') ?><a href="#"> <?= translate_options_radeema('home page', 'radeema') ?></a>, <?= translate_options_radeema('or', 'radeema') ?> <a href="#"><?= translate_options_radeema('contact us', 'radeema') ?></a> <?= translate_options_radeema("if you can't find what you are looking for", 'radeema') ?>. </p>
</div>

<?php get_footer(); ?>