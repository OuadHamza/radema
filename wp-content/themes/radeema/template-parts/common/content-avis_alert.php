<?php 

$avis_args = array (
	'post_type' => 'post',
	'ignore_sticky_posts' => true,
	'posts_per_page' => 3,
	'category_name' => 'Avis',
);
$avis_posts = new WP_Query( $avis_args );

?>


<h2><?= translate_options_radeema('NOTICES AND ALERTS', 'radeema') ?></h2>
<?php if( $avis_posts->have_posts() ) { ?>

	<ul>

		<?php while( $avis_posts->have_posts() ) {
			$avis_posts->the_post(); ?>

			<li>
				<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4>
				<p><?php the_excerpt(); ?></p></a>
			</li>
		<?php } ?>	
	</ul>

	<?php if( $avis_posts->post_count == 3) { ?> 
		<div class="row">
			<div class="col-12 text-right">
				<a href="#" class="btn-radeema btn-radeema-white"><?= translate_options_radeema('Read more', 'radeema') ?></a>
			</div>
		</div>
	<?php } ?>
<?php } ?>