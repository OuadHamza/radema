<?php get_header();

    /**
     * Retrieves siblings of item menu.
     *
     * @param  object $item item menu.
     * @return bool An array of current `$menu_item` siblings.
     *         False if no siblings for the `$menu_item`.
     *@since   0.0.1
     *
     */
	function get_siblings($item) {
		global $menu_item;
		return($item->menu_item_parent == $menu_item[0]->menu_item_parent 
			&& $item->ID != $menu_item[0]->ID);
	}


	$locations = get_nav_menu_locations();
	$current_menu_location = get_term( $locations['main-menu'], 'nav_menu' );

	$menu_item = wp_get_nav_menu_items( $current_menu_location->slug, array( 
		'meta_key'   => '_menu_item_object_id',
		'meta_value' => get_the_ID(),
		'post_type'  => 'nav_menu_item',
	) );
	

	//var_dump($menu_item);
	if (!empty($menu_item) && $menu_item[0]->menu_item_parent != "0"){

		//get items in the same sub menu this page in 
		$menu = wp_get_nav_menu_items( $current_menu_location->slug );
		$siblings = array_filter($menu,"get_siblings");
	}


	$show_sidebar = get_post_meta( get_the_ID(), 'show_sidebar', true );

	$class_page_content = !$show_sidebar ? "col-lg-7" : "col-lg-12";

?>

<div class="container">
	<div class="row">
		<?php if(isset($siblings)) { ?>
			<div class="col-lg-12 py-3">
				<div class="card mw-100 px-1 shadow-sm bg-muted">
					<div class="card-body">
						<?php foreach ($siblings as $item) { ?>
							
							<button class="btn-radeema btn-radeema-primary m-1"><a href="<?= $item->url ?>"><?= $item->title ?></a></button>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
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
		</div>
		<?php !$show_sidebar ? get_sidebar() : ""; ?>
	</div>
</div>


<?php get_footer(); ?>