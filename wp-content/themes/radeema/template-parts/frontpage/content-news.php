<?php

$categories_to_show = get_option('news_id_categories', '');

$news_args = array(
	'post_type' => 'post',
	'ignore_sticky_posts' => true,
	'posts_per_page' => 3,
);

if(!empty($categories_to_show)){
	$news_args['category__in'] = $categories_to_show;
}

$news_posts = new WP_Query( $news_args );

?>


<div class="news h-100">
	<h4 class="news-title"><?= translate_options_radeema('News','radeema') ?></h4>
	<?php if( $news_posts->have_posts() ) { ?>

		<ul>

			<?php while( $news_posts->have_posts() ) {
				$news_posts->the_post(); ?>

				<li>
					<a href="<?php the_permalink(); ?>"><div class="w-100">
						<h4>
							<?php the_title(); ?>
						</h4>
						<div><time><?= get_the_date('d M Y') ?></time></div>
					</div></a>
				</li>
			<?php } ?>	
		</ul>
	<?php } ?>
</div>