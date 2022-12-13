<?php if( have_posts() ) { 

	while( have_posts() ) {
		the_post(); ?>

		<div class="col-lg-3 col-sm-4 col-6 block-image">
			<div style="position: relative;width:100%;height: 0;padding-bottom: 100%">
				<img 
					class="d-block w-100 h-100 fit-cover position-absolute"
					src="<?php esc_url( the_post_thumbnail_url( 'full' ) ); ?>"
					alt="<?php the_title(); ?>"
					data-toggle="modal" data-target="#modal-image">
			</div>
		</div>
	<?php }
} ?>