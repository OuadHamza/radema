<?php get_header(); ?>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v11.0&appId=913822932678224&autoLogAppEvents=1" nonce="QNct9InB"></script>

	<?php 

		$actualite_args = array(
			'post_type' => 'post',
			'ignore_sticky_posts' => true,
			'category_name' => 'Actualité',
			'posts_per_page' => wp_is_mobile() ? 3 : 6,
		);
		$actualite_articles = new WP_Query( $actualite_args );


		$gallery_args = array (
			'post_type' => 'image-gallery',
			'ignore_sticky_posts' => true,
			'lang' => '',
			'posts_per_page' => 6,
		);

		$gallery_posts = new WP_Query( $gallery_args );
	?>
	
	<div class="front_page container">
		<div class="row carousel-news-block">
			<div class="col-lg-8 resize-col">
				<?php get_template_part( 'template-parts/frontpage/content', 'carousel' ); ?>
			</div>
			<div class="col-lg-4 resize-col">
				<?php get_template_part( 'template-parts/frontpage/content', 'news' ); ?>
			</div>
		</div>
		
		<?php get_template_part( 'template-parts/frontpage/content', 'links' ); ?>

		<div class="row agenda-alerts-block py-5">
			<div class="col-lg-6 avis-alerts-block">
				<div class="p-4 pl-5">
					<?php get_template_part( 'template-parts/common/content', 'avis_alert' ); ?>

				</div>
			</div>
			<div class="col-lg-6 agenda-block">
				<div class="p-4 pl-5">
					<?php get_template_part( 'template-parts/common/content', 'agenda' ); ?>
				</div>
			</div>
		</div>
			
		<div class="main-body">
			<div class="row">

				<?php if( $actualite_articles->have_posts() ) { 

					while( $actualite_articles->have_posts() ) {
						$actualite_articles->the_post();
						$categories = get_the_category(); ?>

						<div class="col-sm-6 col-lg-4 block-article">
							<article class="radeema-article h-100">
								<div class="article-image">
									<a href="<?php the_permalink(); ?>">
										<img loading="lazy" class="d-block w-100 h-100 fit-cover" src="<?php esc_url( the_post_thumbnail_url( 'medium_large' ) ); ?>">
									</a>
								</div>
								<div class="article-body p-3">
									<h2 class="article-title"><?php the_title(); ?></h2>
									<time><?= $categories[0]->name ?></time>
									<div class="description"><?php the_excerpt(); ?></div>
									<a href="<?php the_permalink(); ?>" class="btn-radeema btn-radeema-primary"><?= translate_options_radeema('Read more', 'radeema') ?></a>
								</div>
							</article>
						</div>
					<?php }
				} ?>

			</div>
		</div>
		<div class="gallery-facebook">
			<div class="row">
				<div class="col-md-8">
					<div class="gallery p-5 h-100">
						<h2><?= translate_options_radeema('Gallery', 'radeema') ?></h2>

						<?php if( $gallery_posts->have_posts() ) { ?>
							<div class="row">

								<?php while( $gallery_posts->have_posts() ) {
									$gallery_posts->the_post(); ?>

									<div class="col-sm-4 col-6 block-image">
										<div style="position: relative;width:100%;height: 0;padding-bottom: 100%">
											<img 
												class="d-block w-100 h-100 fit-cover position-absolute"
												src="<?php esc_url( the_post_thumbnail_url( 'medium_large' ) ); ?>"
												alt="<?php the_title(); ?>">
										</div>
									</div>

								<?php } ?>
							</div>
							<div class="row">
								<div class="col-12 text-right pt-3">
									<?php 
										$galerie_page = get_posts( array(
											'post_type' => 'page',
											'name' => 'galerie'
										));
									?>
									<a href="<?= get_permalink( $galerie_page[0] )?>" class="btn-radeema btn-radeema-primary"><?= translate_options_radeema('Show all gallery', 'radeema') ?></a>
								</div>
							</div>
						<?php } ?>

					</div>
				</div>
				<div class="col-md-4 pt-3 pb-2 text-center facebook-block">
					<?php 
						$text_direction = function_exists('pll_current_language') && pll_current_language() == "ar" ? "text-right" : "text-left"; 
					?>
					<h4 class="<?= $text_direction ?>"><?= translate_options_radeema('Facebook', 'radeema') ?></h4>
					<div class="fb-page" data-href="https://web.facebook.com/RADEEMAKECH" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://web.facebook.com/RADEEMAKECH" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/RADEEMAKECH"><?= translate_options_radeema('RADEEMA page Official', 'radeema') ?></a></blockquote></div>
				</div>
			</div>
		</div>
	</div>
	
<?php get_footer(); ?>