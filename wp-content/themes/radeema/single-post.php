<?php 

	get_header(); 

	$show_sidebar = get_post_meta( get_the_ID(), 'show_sidebar', true );

	$class_page_content = !$show_sidebar ? "col-lg-7" : "col-lg-12";
?>

	<div class="container single-post">
		<div class="row">
			<div class="<?= $class_page_content ?>">
				<article class="single-article-body">
					<div class="article-image">
						<img loading="lazy" class="d-block w-100 h-100" src="<?php esc_url( the_post_thumbnail_url( 'full' ) ); ?>">
					</div>
					<div class="article-body">
						<h2 class="article-title"><?php the_title(); ?></h2>
						<time><?= get_the_date('d M Y') ?></time>
						<div class="article-content">
							<?php the_content(); ?>
							<?php get_template_part( 'template-parts/common/content', 'files_upload' ); ?>
						</div>
					</div>
				</article>
				<?php comments_template(); ?>
			</div>
			<?php !$show_sidebar ? get_sidebar() : ""; ?>
		</div>
	</div>

<?php get_footer(); ?>