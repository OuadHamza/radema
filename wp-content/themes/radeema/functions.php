<?php
	
	require get_template_directory() . '/inc/classes/radeema-custom-menu.php';
	require get_template_directory() . '/inc/widgets/register-widgets.php';
	require get_template_directory() . '/inc/classes/theme-customizer.php';

	if (is_admin()){
		require get_template_directory() . '/inc/classes/choose-file-field.php';
		require get_template_directory() . '/inc/classes/date-fields-file.php';
		require get_template_directory() . '/inc/classes/show-hide-sidebar.php';	
		require get_template_directory() . '/inc/classes/custom_url_field.php';
	}

	function init_radeema() {
		global $wp_roles;

		$defaults = array(
			'height'               => 100,
			'width'                => 100,
			'flex-height'          => true,
			'flex-width'           => true,
			'header-text'          => array( 'site-title', 'site-description' ),
			'unlink-homepage-logo' => true, 
		);
		add_theme_support( 'custom-logo', $defaults );
		add_theme_support('title-tag');
		add_theme_support( 'post-thumbnails' );
		remove_theme_support( 'widgets-block-editor' );

		register_post_type( 'image-gallery',
			array(
				'labels'       => array(
					'name'          => __( 'Image gallery', 'radeema' ),
					'singular_name' => __( 'Image gallery', 'radeema' )
				),
				'public'       => true,
				'has_archive'  => true,
				'show_in_nav_menus' => false,
				'menu_icon'    => 'dashicons-format-gallery',
				'supports'     => array( 
					'title',
					'editor',
					'thumbnail'
				)
			)
		);
		register_post_type( 'video-yt',
			array(
				'labels'       => array(
					'name'          => __( 'Youtube video', 'radeema' ),
					'singular_name' => __( 'Youtube video', 'radeema' )
				),
				'public'       => true,
				'has_archive'  => true,
				'show_in_nav_menus' => false,
				'menu_icon'    => 'dashicons-format-video',
				'supports'     => array( 
					'title',
					'editor',
					'thumbnail'
				)
			)
		);


		register_post_type( 'post-file',
			array(
				'labels'       => array(
					'name'          => __( 'Files', 'radeema' ),
					'singular_name' => __( 'File', 'radeema' )
				),
				'public'       => true,
				'has_archive'  => true,
				'show_in_nav_menus' => false,
				'menu_icon'    => 'dashicons-media-document',
				'supports'     => array( 
					'title',
					'editor',
				)
			)
		);

		register_post_type( 'post-client',
			array(
				'labels'       => array(
					'name'          => __( 'Clients', 'radeema' ),
					'singular_name' => __( 'Client', 'radeema' ),
					'add_new_item'      => __( 'Add New client processus' ),
					'all_items'         => __( 'All client processus' ),
					'update_item'       => __( 'Update client processus' ),
					'search_items'      => __( 'Search client processus' ),
				),
				'public'       => true,			
				'has_archive'  => true,
				'show_in_nav_menus' => false,
				'menu_icon'    => 'dashicons-businessperson',
				'supports'     => array( 
					'title',
					'editor',
				)
			)
		);

		$labels = array(
			'name'              => _x( 'client categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'client category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search client categories' ),
			'popular_items'     => __( 'Popular client categories' ),
			'all_items'         => __( 'All client categories' ),
			'parent_item'       => __( 'Parent client category' ),
			'parent_item_colon' => __( 'Parent client category:' ),
			'edit_item'         => __( 'Edit client category' ),
			'update_item'       => __( 'Update client category' ),
			'add_new_item'      => __( 'Add New client category' ),
			'new_item_name'     => __( 'New client category Name' ),
		);
		register_taxonomy('client-cat',array('post-client'), array(
			'hierarchical' => true,
			'labels'       => $labels,
			'show_ui'      => true,
			'show_in_nav_menus' => false,
			'query_var'    => true,
			'rewrite'      => array( 'slug' => 'client-cat' ),
		));


		load_theme_textdomain( 'radeema', get_template_directory() . '/languages' );


	    if ( ! isset( $wp_roles ) )
			//list all currently available roles 
			$wp_roles = new WP_Roles();

		//change roles names
		$wp_roles->roles['editor']['name'] = 'Admin secondaire';
		$wp_roles->roles['administrator']['name'] = 'Admin general';
		$wp_roles->roles['contributor']['name'] = 'Redacteur';

		$wp_roles->role_names['editor'] = 'Admin secondaire';
		$wp_roles->role_names['administrator'] = 'Admin general';
		$wp_roles->role_names['contributor'] = 'Redacteur';

		add_editor_style( 'custom-editor-style.css' );

	}

	function radeema_scripts() {
		global $wp_query;

		//var_dump($wp_query);
		$template_directory_uri = get_template_directory_uri();

		wp_enqueue_style( 'bootstrap',  $template_directory_uri . '/css/bootstrap/bootstrap-4-3-1.min.css', 'all' );
		wp_enqueue_style( 'font-awesome',  $template_directory_uri . '/fonts/icons-font-awesome/font-awesome-4.min.css' );
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		wp_style_add_data( 'style', 'rtl', 'replace' ); 

		wp_enqueue_script( 'jquery', $template_directory_uri . '/js/jquery/jquery-3-3-1.min.js', false, 3.3, true);
		wp_enqueue_script( 'bootstrap', $template_directory_uri . '/js/bootstrap/bootstrap-4-3-1.min.js', false, 4.3, true);
		wp_enqueue_script( 'popper', $template_directory_uri . '/js/popper/popper-1-14-7.min.js', false, 1.14, true);
		wp_enqueue_script( 'radeema-custom', $template_directory_uri . '/js/custom.js', false, 0.1, true);

		//add datatables to page publications
		if ( isset($wp_query->query['pagename']) ){

			$post_name = $wp_query->query['pagename'];
			$post_id = $wp_query->queried_object->ID;

			if( function_exists('pll_default_language') && get_locale() != pll_default_language('locale') ){

				$default_post_id = pll_get_post($post_id, pll_default_language());
				//var_dump($default_post_id);
				$default_post = get_post($default_post_id);
				$post_name = $default_post->post_name;
			}
			if( $post_name == 'publications' ) {
				wp_enqueue_style( 'data-tables', $template_directory_uri . '/css/datatable/data-tables.min.css' );

				wp_enqueue_style( 'data-tables-responsive', $template_directory_uri . '/css/datatable/responsive.dataTables.min.css' );

				wp_enqueue_script('data-tables', $template_directory_uri . '/js/datatable/data-tables.min.js', array( 'jquery' ), 1.0, true );

				wp_enqueue_script('data-tables-responsive', $template_directory_uri . '/js/datatable/dataTables.responsive.min.js', array( 'jquery' ), 1.0, true );

				wp_enqueue_script('data-tables-start', $template_directory_uri . '/js/start-datatables.js', array( 'data-tables' ), 1.0, true );
			}
		}

		if( is_front_page() )
			wp_enqueue_script( 'radeema-font-page', $template_directory_uri . '/js/front-page.js', false, 0.1, true);
	}

	function radeema_menus() {
		register_nav_menus(
			array(
				'top-menu' => __( 'Top Menu', 'radeema' ),
				'main-menu' => __( 'Main Menu', 'radeema' ),
				'bottom-menu' => __( 'Bottom Menu', 'radeema' ),
				'secondairy-bottom-menu' => __( 'Secondairy Bottom Menu', 'radeema' ),
			)
		);
	}

	function add_additional_class_on_li($classes, $item, $args) {
		if(isset($args->add_li_class)) {
			$classes[] = $args->add_li_class;
		}
		return $classes;
	}

	function add_link_atts($atts, $item, $args) {
		if(isset($args->add_li_class)) {
			$atts['class'] = $args->add_a_class;
		}
		return $atts;
	}

	function custom_excerpt_length( $length ) {
		return 20;
	}


	function translate_options_radeema($string) {
		//choose poly lang for translation if is exist
		if(function_exists('pll__'))
			return pll__($string);
		// or choose gettext 
		else
			return __($string, 'radeema' );
	}

	function add_text_to_translate_with_polylang() {

		pll_register_string("Radeema", "News", "Radeema");
		pll_register_string("Radeema", "AGENDA", "Radeema");
		pll_register_string("Radeema", "Read more", "Radeema");
		pll_register_string("Radeema", "This page doesn't exist", "Radeema");
		pll_register_string("Radeema", "Sorry, the page you are looking for could not be found", "Radeema");
		pll_register_string("Radeema", "Try to look for something else ", "Radeema");
		pll_register_string("Radeema", "Or you can return to our", "Radeema");
		pll_register_string("Radeema", "home page", "Radeema");
		pll_register_string("Radeema", "or", "Radeema");
		pll_register_string("Radeema", "contact us", "Radeema");
		pll_register_string("Radeema", "if you can't find what you are looking for", "Radeema");
		pll_register_string("Radeema", "Comment navigation", "Radeema");
		pll_register_string("Radeema", "Comments are closed", "Radeema");
		pll_register_string("Radeema", "Newsletter", "Radeema");
		pll_register_string("Radeema", "© All rights reserved Radeema 2021", "Radeema");
		pll_register_string("Radeema", "Search", "Radeema");
		pll_register_string("Radeema", "Show all gallery", "Radeema");
		pll_register_string("Radeema", "Facebook", "Radeema");
		pll_register_string("Radeema", "RADEEMA page Official", "Radeema");
		pll_register_string("Radeema", "Incorrect verification", "Radeema");
		pll_register_string("Radeema", "The message was not sent. Try again", "Radeema");
		pll_register_string("Radeema", "Thank you! Your message has been sent", "Radeema");
		pll_register_string("Radeema", "Contact us", "Radeema");
		pll_register_string("Radeema", "Full name", "Radeema");
		pll_register_string("Radeema", "Email address", "Radeema");
		pll_register_string("Radeema", "We'll never share your email with anyone else", "Radeema");
		pll_register_string("Radeema", "Phone", "Radeema");
		pll_register_string("Radeema", "Object", "Radeema");
		pll_register_string("Radeema", "Message", "Radeema");
		pll_register_string("Radeema", "repeat this number", "Radeema");
		pll_register_string("Radeema", "Send", "Radeema");
		pll_register_string("Radeema", "Gallery", "Radeema");
		pll_register_string("Radeema", "NOTICES AND ALERTS", "Radeema");
		pll_register_string("Radeema", "Download", "Radeema");
		pll_register_string("Radeema", "Previous", "Radeema");
		pll_register_string("Radeema", "Next", "Radeema");
		pll_register_string("Radeema", "Title", "Radeema");
		pll_register_string("Radeema", "Description", "Radeema");
		pll_register_string("Radeema", "Accept", "Radeema");
		pll_register_string("Radeema", "by using our site you agree with our", "Radeema");
		pll_register_string("Radeema", "this site use cookies for access and stock non sensitive information such as your IP address", "Radeema", true);
		pll_register_string("Radeema", "The processing of your data allows us, for example, to improve your user experience and measure the site's audience", "Radeema", true);
		pll_register_string("Radeema", "privacy policy conditions", "Radeema");
	}

	if(function_exists('pll_register_string'))
		add_text_to_translate_with_polylang();


	function radeema_comment_remove_fields( $fields ) {

		//remove fields url and cookies (checkbox save my email for next comment)
		unset( $fields['url'] );
		unset( $fields['cookies'] );

		return $fields;
	}

	/*function hide_adminstrator_editable_roles( $roles ){
		if ( isset( $roles['subscriber'] ) ){
			unset( $roles['subscriber'] );
		}
		return $roles;
	}*/

/* 
// removed roles
remove_role( 'author' );
remove_role( 'wpseo_editor' );
remove_role( 'wpseo_manager' ); 
*/

	/**
	 * Wordpress: Filter admin columns and remove yoast seo columns
	 */
	function yoast_seo_remove_columns( $columns ) {
		/* remove the Yoast SEO columns */
		unset( $columns['wpseo-score'] );
		unset( $columns['wpseo-title'] );
		unset( $columns['wpseo-metadesc'] );
		unset( $columns['wpseo-focuskw'] );
		unset( $columns['wpseo-score-readability'] );
		unset( $columns['wpseo-links'] );
		unset( $columns['wpseo-linked'] );
		unset( $columns['tags'] );
		return $columns;
	}

	function polylang_remove_columns( $columns ){
		unset( $columns['language_ar'] );
		unset( $columns['language_fr'] );
		
		return $columns;
	}


	function events_page_remove_columns($columns) {
		$columns = yoast_seo_remove_columns( $columns );
		unset( $columns['events-cats'] );
		return $columns;
	}

	function email_subscription_radeema() {
		global $wpdb;

		if(isset($_COOKIE['subscription_status']))
			setcookie( "subscription_status", "0", strtotime('-1 day'), COOKIEPATH, COOKIE_DOMAIN );

		$radsfdf = "sdffd";
		if(isset($_POST['submit_subscription'])) {

			if( is_email( $_POST['subscriber_email'] ) ){
				$email = sanitize_email( $_POST['subscriber_email'] );

				if(email_exists($email)){

					if(!isset($_COOKIE['subscription_status']))
						setcookie( "subscription_status", "exist", strtotime('+1 day'), COOKIEPATH, COOKIE_DOMAIN );

					wp_redirect( home_url('/'));

				}else {
					$userID = $wpdb->get_results( 
						"SELECT max(ID) as ID FROM wp_users"
					);

					$user_login = substr($email, 0, strpos($email,"@"));
					$user_login = preg_replace('/[^A-Za-z0-9\-]/', '', $user_login);

					$userData = array(
						'user_login'   => $user_login,
						'user_pass'    => 's4EyEDBB0MdGD@@@Rv1&R$0L',
						'user_email'   => $email,
						'display_name' => $user_login,
						'role'         => 'subscriber'
					);

					if ( ! username_exists( $userName ) ) {
						wp_insert_user( $userData );

						if(!isset($_COOKIE['subscription_status']))
							setcookie( "subscription_status", "verified", strtotime('+1 day'), COOKIEPATH, COOKIE_DOMAIN );
						wp_redirect( home_url( '/') ); 
					}
				}
			}else{

				if(!isset($_COOKIE['subscription_status']))
					setcookie( "subscription_status", "not_verified", strtotime('+1 day'), COOKIEPATH, COOKIE_DOMAIN );
				wp_redirect( home_url( '/') ); 

			}
		}
	}

	function wp_infinitepaginate(){

		query_posts( array(
			'paged'               => $_POST['page_no'],
			'post_type'           => 'image-gallery',
			'ignore_sticky_posts' => true,
		) );
		get_template_part( 'template-parts/content', 'gallery' );

		exit;
	}
	add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate'); // for logged in user
	add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate'); // if user not logged in

	/*function add_custom_query_var( $vars ){
		$vars[] = "email_registred";
		$vars[] = "email_verified";
		return $vars;
	}*/

	function pll_remove_metabox() {
		remove_meta_box( 'ml_box', 'image-gallery', 'side' );
	}


	function block_api_non_auth ($result) {
		// If a previous authentication check was applied,
		// pass that result along without modification.
		if ( true === $result || is_wp_error( $result ) ) {
		    return $result;
		}

		// No authentication has been performed yet.
		// Return an error if user is not logged in.
		if ( ! is_user_logged_in() ) {
			return new WP_Error(
				'rest_not_logged_in',
				__( 'You are not currently logged in.' ),
				array( 'status' => 401 )
			);
		}

		// Our custom authentication check should have no effect
		// on logged-in requests
		return $result;
	}


	function check_video_if_empty( $post_id, $post, $update ) {
 	
 		if ( wp_is_post_revision( $post_id ) ) {
	        return;
	    }

		remove_action( 'save_post_video-yt', 'check_video_if_empty' );

	    $post_status = get_post_status();
	    //if ( $post_status != 'draft' && $post_status != 'auto-draft' )  {
	        if ( isset( $_POST['post_title'] ) ) {

	            $embeds = explode("[embed]", $post->post_content);

				$url_embed = "";

				if(!empty($embeds) ) {
					foreach($embeds as $embed) {
						$exist = strpos($embed, "[/embed]");
						if($exist) {
							$index = $exist;
							$just_url = substr($embed,0, $index);
								$url_embed = "[embed]" . $just_url . "[/embed]";
							break;
						}
					}
				}
				//die(json_encode($post));
				if($url_embed != "")
					wp_update_post( [
						"ID"         => $post_id,
						"post_content" => $url_embed,
					] );
				else
					wp_update_post( [
						"ID"         => $post_id,
						"post_status" => "draft",
					] );
	        }
	    //}

		add_action( 'save_post_video-yt', 'check_video_if_empty', 10, 3 );
	}

	add_action( 'save_post_video-yt', 'check_video_if_empty', 10, 3 );


	add_filter( 'page_template', function ( $template ) use ( &$post ) {
		// Check if we have page in default lang (fr) 
		if( function_exists('pll_default_language') && get_locale() != pll_default_language('locale') ){

			$default_post_id = pll_get_post(get_the_ID(), pll_default_language());

			$default_post = get_post($default_post_id);

			$locate_template = locate_template( "page-{$default_post->post_name}.php" );

			if ( $locate_template )
				return $locate_template;
		}

		return $template;

	});

	function wpb_mce_buttons_2($buttons) {
		array_unshift($buttons, 'styleselect');
		return $buttons;
	}	

	function my_mce_before_init_insert_formats( $init_array ) {  
		
		$style_formats = array(  
			array(
				'title' => 'Blue Button',  
				'block' => 'span',  
				'classes' => 'btn-radeema btn-radeema-primary',
				'wrapper' => true,
			),
		);  
		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = json_encode( $style_formats );  

		return $init_array;
	} 



	add_filter( 'rest_authentication_errors', 'block_api_non_auth');

	if(is_admin()){

		add_filter( 'manage_edit-post_columns', 'yoast_seo_remove_columns' );
		add_filter( 'manage_edit-page_columns', 'yoast_seo_remove_columns' );
		add_filter( 'manage_edit-image-gallery_custom_column', 'polylang_remove_columns' );
		add_filter( 'manage_edit-image-gallery_columns', 'yoast_seo_remove_columns' );
		add_filter( 'manage_edit-post-client_columns', 'yoast_seo_remove_columns' );
		add_filter( 'manage_edit-video-yt_columns', 'yoast_seo_remove_columns' );
		add_filter( 'manage_edit-tribe_events_columns', 'events_page_remove_columns' );
		add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 
		add_filter( 'mce_buttons_2', 'wpb_mce_buttons_2');
	}

	add_filter( 'comment_form_fields', 'radeema_comment_remove_fields' );
	add_filter( 'excerpt_length', 'custom_excerpt_length', 9 );
	add_filter( 'nav_menu_link_attributes', 'add_link_atts',1, 3);
	add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

	//add_action( 'init', 'sk_add_category_taxonomy_to_events', 0 );

	add_action( 'init', 'radeema_menus' );
	add_action('after_setup_theme', 'init_radeema');
	add_action( 'wp_enqueue_scripts', 'radeema_scripts');
	add_action('email_subscription' , 'email_subscription_radeema' );

	if(is_admin()){
		add_action( 'admin_head' , 'pll_remove_metabox' );
	}
	//add_action( 'editable_roles' , 'hide_adminstrator_editable_roles' );


/*add_shortcode( 'gallery_shortcode', 'gallery_shortcode_func' );

function gallery_shortcode_func() {

}*/



/*add_action( 'save_post', 'wpdocs_notify_subscribers', 10, 3 );
 
function wpdocs_notify_subscribers( $post_id, $post, $update ) {
 
    // If an old post is being updated, exit
    if ( $update ) {
        return;
    }
 
    $subscribers = get_users( array(
    	'role' => 'subscriber', 
    ) ) // list of subscribers

    $subject     = 'A new post has been added!';
    $message     = sprintf( 'We\'ve added a new post, %s. Click <a href="%s">here</a> to see the post', get_the_title( $post ), get_permalink( $post ) );
 
    wp_mail( $subscribers, $subject, $message );
}*/


?>