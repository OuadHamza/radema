<div class="actualite container">
	<div class="main-body">
		<h1 class="page-title"><?= single_term_title() ?></h1>
		<div class="row">

			<?php if( have_posts() ) { 

				while( have_posts() ) {
					the_post(); ?>

					<div class="col-sm-6 col-lg-4 block-article">
						<article class="radeema-article h-100">
							<div class="article-image">
								<?php the_content(); ?>
							</div>
							<div class="article-body p-3">
								<h2 class="article-title"><?php the_title(); ?></h2>
								<time><?= date('Y-m-d H:i', get_post_time(  )) ?></time>
							</div>
						</article>
					</div>
				<?php }
			} ?>

		</div>
	</div>
</div>