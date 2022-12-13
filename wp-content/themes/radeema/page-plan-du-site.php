<?php get_header(); 

	$locations = get_nav_menu_locations();

	function get_menu_parents($item) {
		return($item->menu_item_parent == 0);
	}

	function show_siblings($menu_items, $parent_item){

		$siblings = array_filter($menu_items, function($sibling) use ($parent_item) {
			return($sibling->menu_item_parent == $parent_item->ID);
		});
		echo "<ul>";

		if(!empty($siblings)){
			foreach ($siblings as $item) {
				echo "<li><a href='". $item->url ."'>". $item->title ."</a></li>";
				show_siblings($menu_items, $item);
			}
		}
		echo "</ul>";
	} ?>

<div class="container pt-3">
	
<?php

	foreach ($locations as $menu_name => $id) {

		$menu = get_term( $id, 'nav_menu' );

		$menu_items = wp_get_nav_menu_items( $menu->slug, array( 
			'meta_key'  => '_menu_item_object_id',
			'post_type' => 'nav_menu_item',
		) );

		$menu_parents_items = array_filter($menu_items,"get_menu_parents");

		echo "<div class='bg-radeema-primary p-4 text-white' style='border-radius:10px'>";

			foreach ($menu_parents_items as $parent_item) {

				echo "<h4><a href='". $parent_item->url ."'>". $parent_item->title ."</a></h4>";
				show_siblings($menu_items, $parent_item);
			}
		echo "</div>
		<br>";
	}
?>
</div>

<?php get_footer() ?>