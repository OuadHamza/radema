<?php get_header(); ?>
	
	<div class="actualite container">
		<div class="main-body">
			<h1 class="page-title"><?php single_term_title() ?></h1>
			<div class="row">

				<?php if( have_posts() ) { 

					while( have_posts() ) { 
						the_post(); 
						$categories = get_the_category();
						//var_dump($categories)
						?>

						<div class="col-sm-6 col-lg-4 block-article">
							<article class="radeema-article h-100">
								<?php if( has_post_thumbnail() ){ ?>
									<div class="article-image">
										<a href="<?php the_permalink(); ?>">
											<img loading="lazy" class="d-block w-100 h-100 fit-cover" src="<?php esc_url( the_post_thumbnail_url( 'full' ) ); ?>">
										</a>
									</div>
								<?php }else { ?>
									<div style="height: 200px;"></div>
								<?php } ?>
								<div class="article-body p-3">
									<h2 class="article-title"><?php the_title(); ?></h2>
									<time style="font-size: 18px;"><?= $categories[0]->name ?></time>
									<div class="description"><?php the_excerpt(); ?></div>
									<a href="<?php the_permalink(); ?>" class="btn-radeema btn-radeema-primary"><?= translate_options_radeema('Read more', 'radeema') ?></a>
								</div>
							</article>
						</div>
					<?php }
				} ?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>