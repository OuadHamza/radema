<?php get_header(); ?>


<div class="actualite container">
	<div class="main-body">
		<h1 class="page-title"><?= translate_options_radeema('Search', 'radeema') ?></h1>

			<?php if( have_posts() ) { ?>

				<div class="row">
				<?php while( have_posts() ) {
					the_post(); ?>

					<div class="col-sm-6 col-lg-4 block-article">
						<article class="radeema-article h-100">
							<div class="article-image">
								<a href="<?php the_permalink(); ?>">
									<img loading="lazy" class="d-block w-100 h-100 fit-cover" src="<?php esc_url( the_post_thumbnail_url( 'full' ) ); ?>">
								</a>
							</div>
							<div class="article-body p-3">
								<h2 class="article-title"><?php the_title(); ?></h2>
								<time><?= date('Y-m-d H:i', get_post_time(  )) ?></time>
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
						'format'       => '?paged=%#%',
						'show_all'     => false,
						'prev_next'    => true,
					) );
				?>
			</div>
		<?php } ?>

	</div>
</div>


<?php get_footer(); ?>