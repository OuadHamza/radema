<?php

if ( is_admin() ) {
	add_action( 'wp_nav_menu_item_custom_fields', 'menu_item_icon', 10, 2 );
	add_action( 'wp_update_nav_menu_item', 'save_menu_item_icon', 10, 2 );
}



function menu_item_icon( $item_id, $item ) {
	$menu_item_icon = get_post_meta( $item_id, '_menu_item_icon', true );
	?>
	<div style="clear: both;">
		<span class="description"><?php _e( "Item Description", 'menu-item-icon' ); ?></span><br />
		<input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />
		<div class="logged-input-holder">
			<input type="text" name="menu_item_icon[<?php echo $item_id ;?>]" id="menu-item-icon-<?php echo $item_id ;?>" value="<?php echo esc_attr( $menu_item_icon ); ?>" />
		</div>
	</div>
	<?php
}



function save_menu_item_icon( $menu_id, $menu_item_db_id ) {
	if ( isset( $_POST['menu_item_icon'][$menu_item_db_id]  ) ) {
		$sanitized_data = sanitize_text_field( $_POST['menu_item_icon'][$menu_item_db_id] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_item_icon' );
	}
}
