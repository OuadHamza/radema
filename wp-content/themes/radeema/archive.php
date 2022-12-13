<?php get_header(); 
	
	if( have_posts() ) { 

		if(has_post_format('video')){

			get_template_part( 'template-parts/content', 'video' );

		}else if(has_post_format('gallery')){

			get_template_part( 'template-parts/content', 'gallery' );

		}else {

			get_template_part( 'template-parts/common/content', 'posts' );
		} 
	} ?>

<?php get_footer(); ?>