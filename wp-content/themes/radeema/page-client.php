<?php get_header(); 


	$client_categories = get_terms( array(
		'taxonomy'   => 'client-cat',
		'hide_empty' => false, //true,
	) );


	$page_content = get_the_content();

	$tabs = '<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">';
	$tabs_content = '<div class="tab-content" id="pills-tabContent">';

	$count = 0;
	foreach ($client_categories as $category) { 
		$tabs .= '<li class="nav-item" role="tab-'. $category->term_id .'">
			<a class="btn-radeema btn-radeema-primary m-1 '. ($count == 0 ? 'active' : '') .'"
				id="tab-'. $category->term_id .'-tab"
				data-toggle="pill"
				href="#tab-'. $category->term_id .'"
				role="tab"
				aria-controls="tab-'. $category->term_id .'"
				aria-selected="true">'. $category->name .'</a>
		</li>';

		//var_dump('single-term', $category);
		wp_reset_query();
		$args = array('post_type' => 'post-client',
			'tax_query'           => array(
				array(
					'taxonomy' => 'client-cat',
					'field'    => 'slug',
					'terms'    => $category->slug,
				),
			),
		);
		$client_cat = new WP_Query($args);

		$tabs_content .= '<div class="tab-pane fade '. ($count == 0 ? 'show active' : '') .'" 
			id="tab-'. $category->term_id .'"
			role="tabpanel"
			aria-labelledby="'. $category->term_id .'-tab">
				<div class="py-3 " id="faq">
					<div class="row justify-content-center">
						<div class="col-12 col-md-12">
							<div class="accordion faq-accordian" id="faqAccordion">';

		if( $client_cat->have_posts() ){
			while( $client_cat->have_posts() ){

				$client_cat->the_post(); 

		        $tabs_content .= '<div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                        <div class="card-header" id="headingTwo">
                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#faq-'. get_the_ID() .'" aria-expanded="true" aria-controls="faq-'. get_the_ID() .'">'. get_the_title() .'<span><i class="fa fa-angle-up"></i></span></h6>
                        </div>
                        <div class="collapse" id="faq-'. get_the_ID() .'" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                            <div class="card-body">
                                '. get_the_content() .'
                            </div>
                        </div>
                    </div>';
		 	} 
		} 

		$tabs_content .= '</div></div></div></div></div>';
		$count++;
	} 

	$tabs .= '</ul>';
	$tabs_content .= '</div>';
?>

<div class="faq_area" style="min-height: 300px">
	<div class="p-4">
		<div class="row">
			<div class="col-md-4">
				<?= $page_content ?>
				<?= $tabs ?>
			</div>
			<div class="col-md-8">
				<?= $tabs_content ?>
			</div>
		</div>
	</div>
</div> 


<?php get_footer(); ?>