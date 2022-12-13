<?php get_header(); ?>

	<?php 
	wp_reset_query();
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$actualite_args = array(
			'post_type' => 'post',
			'ignore_sticky_posts' => true,
			'category_name' => 'Actualité',
			'paged' => $paged
		);
		$actualite_articles = new WP_Query( $actualite_args );
	?>

	<div class="actualite container">
		<div class="main-body">
			<h1 class="page-title"><?php single_post_title(); ?></h1>

				<?php if( $actualite_articles->have_posts() ) { ?>

					<div class="row">
					<?php while( $actualite_articles->have_posts() ) {
						$actualite_articles->the_post(); 
						$categories = get_the_category();
						//var_dump($categories)
						?>

						<div class="col-sm-6 col-lg-4 block-article">
							<article class="radeema-article h-100">
								<div class="article-image">
									<a href="<?php the_permalink(); ?>">
										<img loading="lazy" class="d-block w-100 h-100 fit-cover" src="<?php esc_url( the_post_thumbnail_url( 'full' ) ); ?>">
									</a>
								</div>
								<div class="article-body p-3">
									<h2 class="article-title"><?php the_title(); ?></h2>
									<time style="font-size: 18px;"><?= $categories[0]->name ?></time>
									<div class="description"><?php the_excerpt(); ?></div>
									<a href="<?php the_permalink(); ?>" class="btn-radeema btn-radeema-primary"><?= translate_options_radeema('Read more', 'radeema') ?></a>
								</div>
							</article>
						</div>
					<?php } ?>
				</div>

				<div class="pagination text-center p-3 d-flex justify-content-center">
					<?php 
						echo paginate_links( array(
							'current'      => max( 1, get_query_var( 'paged' ) ),
							'total'        => ceil($actualite_articles->found_posts / $actualite_articles->query_vars["posts_per_page"]),
							'format'       => '?paged=%#%',
							'show_all'     => false,
						) );
					?>
				</div>
			<?php } ?>
		</div>
	</div>

<?php get_footer(); ?>