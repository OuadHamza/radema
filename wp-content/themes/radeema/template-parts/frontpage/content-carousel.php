<?php

//var_dump(get_option( 'show_video_yt', 1 ));
$categories_to_show = get_option('radeema_carousel_id_categories', '');

if( get_option( 'show_video_yt', 1 ) ) {

	$args = array(
		'fields' => 'ids',
		'post_type' => 'post',
		'ignore_sticky_posts' => true,
		'posts_per_page' => 8,
	);

	if(!empty($categories_to_show)){
		$args['category__in'] = $categories_to_show;
	}

	$query1 = new WP_Query( $args );

	$query2 = new WP_Query(array(
		'fields' => 'ids',
		'post_type' => 'video-yt',
		'ignore_sticky_posts' => true,
		'posts_per_page' => 8,
	));


	//get posts ids from categories in carousel and merge it with youtube videos  
	$slider_post_ids = array_merge($query1->posts,$query2->posts);

	//new query, get posts using post__in parameter
	$slider_posts = new WP_Query(array(
		'post_type' => array('post', 'video-yt'),
		'lang' => '',
		'post__in' => $slider_post_ids,
		'posts_per_page' => 8,
	));

} else {

	$args = array(
		'post_type' => 'post',
		'ignore_sticky_posts' => true,
		'posts_per_page' => 8,
	);

	if(!empty($categories_to_show)){
		$args['category__in'] = $categories_to_show;
	}

	$slider_args = array ( $args );
	
	$slider_posts = new WP_Query( $slider_args );
}

//var_dump($slider_posts);

?>


<div id="radeema-carousel" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<?php for ($i=0; $i < $slider_posts->post_count ; $i++) { ?>
			<li data-target="#radeema-carousel" data-slide-to="<?=$i?>" <?= $i == 0 ? 'class="active"' : "" ?>></li>
		<?php } ?>
	</ol>
	<div class="carousel-inner">
		<?php if( $slider_posts->have_posts() ) { 
			$count = 0;
			while( $slider_posts->have_posts() ) {
				$slider_posts->the_post();
				$categories = get_the_category(); ?>

				<div class="carousel-item <?= $count == 0 ? 'active' : "" ?>">

					<div class="post-carousel-image">
						<?php if( get_post_type() == "video-yt" ){  ?>
							<div class="d-block w-100 h-100">
								
								<?php the_content(); ?>
							</div>
						</div>
						<?php } else { ?>
							<!-- <img class="d-block w-100" src="<?php esc_url( the_post_thumbnail_url( 'full' ) ); ?>"> -->
							<div class="d-md-block w-100 h-100 slider-image-article" style="background-image: url(<?php esc_url( the_post_thumbnail_url( 'medium_large' ) ); ?>);"></div>
						</div>
						<div class="carousel-caption">
							<p class="d-sm-none d-md-block"><?= $categories[0]->name ?></p>
							<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						</div>
					<?php } ?>	
				</div>

			<?php $count++; }
		} ?>

	</div>
	<a class="carousel-control-prev" href="#radeema-carousel" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only"><?= __('Previous', 'radeema') ?></span>
	</a>
	<a class="carousel-control-next" href="#radeema-carousel" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only"><?= __('Next','radeema') ?></span>
	</a>
</div>