<?php 

/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
**/

?>


<form role="search"  method="get" class="search-form mx-auto mb-3" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<input type="search" class="form-control" placeholder="<?= translate_options_radeema('Search', 'radeema') ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<input type="hidden" value="post" name="post_type" id="post_type" />

	<button type="submit" class="btn btn-default">
		<i class="fa fa-search"></i>
	</button>
</form>