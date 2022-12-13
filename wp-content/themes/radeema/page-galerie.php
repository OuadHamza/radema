<?php get_header(); ?>

	<?php 

		$gallery_args = array (
			'post_type'           => 'image-gallery',
			'ignore_sticky_posts' => true,
		);

		$gallery_posts = new WP_Query( $gallery_args );
	?>

	<div class="container">
		<div class="main-body gallery-page pb-4">
			<h1><?= translate_options_radeema('Gallery', 'radeema') ?></h1>
			<div class="row append_other_images">
				<?php if( $gallery_posts->have_posts() ) { 

					while( $gallery_posts->have_posts() ) {
						$gallery_posts->the_post(); ?>

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
			</div>
			<div class="row">
				<div class="col-lg-12 text-center p-4">
					<img id="spinner" width="40" src="<?= get_template_directory_uri()."/assets/spinner.gif"?>" style="display: none;">
					<button class="btn-radeema btn-radeema-primary load-more">load more</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-labelledby="modalImage">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
            <img class="preview-image d-block w-100 h-100" src="">
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
    	jQuery(function($) {

    		$('img').click(function() {
    			console.log(this)
    			$('.preview-image').attr('src', this.src)
    		})
    	});
    </script>
    <script type="text/javascript">
		jQuery(document).ready(function($) {
			var count = 2;
			var total = <?= $gallery_posts->max_num_pages; ?>;

			$(".load-more").on("click", function() {
				if (count > total){
					$('.load-more').hide('fast');
					return false;
				}else{
					loadArticle(count);
					count++;
				}
			})

			function loadArticle(pageNumber){
				$('#spinner').show('fast');
				$.ajax({
					url: "<?php echo admin_url(); ?>admin-ajax.php",
					type:'POST',
					data: "action=infinite_scroll&page_no="+ pageNumber,
					success: function (html) {
						console.log(html)
						$('#spinner').hide('1000');
						$(".append_other_images").append(html);
					}
				});
				return false;
			}

			//loadArticle(1);
		});
	</script>


<?php get_footer(); ?>