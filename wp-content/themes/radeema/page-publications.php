<?php get_header(); ?>

	<?php 
		$page_title = get_the_title();

		wp_reset_query();
		$files_args = array (
			'post_type'           => 'post-file',
			'ignore_sticky_posts' => true,
		);

		$files_posts = new WP_Query( $files_args );
	?>

	<div class="container publication">
		<div class="main-body gallery-page pb-4">
			<div class="row pt-3">
				<div class="col-md-12">
					<h3 class="title pb-3"><?= $page_title ?></h3>
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0" data-lang="<?= get_locale() ?>">
							<thead>
								<tr>
									<th><?= translate_options_radeema('Title', 'radeema') ?></th>
									<th><?= translate_options_radeema('Description', 'radeema') ?></th>
									<th>Date lancement</th>
									<th>Date remise</th>
									<th>Date ouverture</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if( $files_posts->have_posts() ) { 

									while( $files_posts->have_posts() ) {
										$files_posts->the_post(); 

										$file_data = get_post_meta( get_the_ID(), 'custom_url_file', true );
										//var_dump("data ",json_decode($file_data));
										$file_data = json_decode($file_data); 
										$file_url = !empty($file_data) ? $file_data->url_file : "";

										$date_data = json_decode(get_post_meta(get_the_ID(), 'custom_date', true));

										?>
										<tr>
											<td><?= get_the_title() ?></td>
											<td><?= get_the_content() ?></td>
											<td><?= $date_data != "" ? $date_data->date_lancement : "" ?></td>
											<td><?= $date_data != "" ? $date_data->date_remise : "" ?></td>
											<td><?= $date_data != "" ? $date_data->date_ouverture : "" ?></td>
											<td>
												<?php if ($file_url != "") { ?>
													<a class="btn btn-info m-1" href="<?= esc_url($file_url) ?>" target="_blank" ><i class="fa fa-eye"></i></a>
													<a class="btn btn-success m-1" href="<?=  esc_url($file_url) ?>" download><i class="fa fa-download"></i></a>
												<?php } ?>
											</td>
										</tr>

									<?php }
								} ?>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>


                            
                           

<?php get_footer(); ?>