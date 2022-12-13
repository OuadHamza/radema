<?php

	add_action( 'widgets_init', 'Radeema_widgets_init' );

	require get_template_directory() . '/inc/widgets/links-widget.php';

	function Radeema_widgets_init() {

		register_sidebar( array(

			'name'          => 'Links block',
			'id'            => 'links-block',
			/*'description'   => 'Add widgets here.',
			'before_widget' => '<div id="%1$s" class="row widget %2$s">',
			'after_widget'  => '</div>',*/
		) );


		register_widget( 'Radeema_Links' );
	}

?>