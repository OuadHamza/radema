<?php
/**
 * Radeema: Customizer
 *
 * @package WordPress
 * @subpackage Radeema
 * @since Radeema 1.0
 */

/**
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */


function radeema_customize_register( $wp_customize ) {

	require get_template_directory() . '/inc/classes/multiple_select_dropdown_taxonomies.php';

	$wp_customize->add_section( 'radeema_options', 
		array(
			'title'       => __( 'Radeema Options', 'radeema' ),
			'priority'    => 3,
			'capability'  => 'edit_theme_options',
			'description' => __('Allows you to customize settings for Theme.', 'radeema'),
		) 
	);

	$wp_customize->add_section( 'social_media', 
		array(
			'title'       => __( 'Social media', 'radeema' ),
			'priority'    => 4,
			'capability'  => 'edit_theme_options',
			'description' => __('Liens des social medias.', 'radeema'),
		) 
	);

	$wp_customize->add_setting(
		'show_video_yt',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
			'type'              => 'option', 
		)
	);

	$wp_customize->add_control(
		'show_video_yt',
		array(
			'label'   => __( 'show youtube videos', 'radeema' ),
			'section' => 'radeema_options',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'radeema_carousel_id_categories',
		array(
			'transport'   => 'refresh',
			'sanitize_callback' => 'radeema_sanitize_multiple_cat_select',
			'type' => 'option'
		) 
	);

	$wp_customize->add_control( new PFUN_Customize_Control_Checkbox_Multiple(
		$wp_customize,
		'carousel_categories_id',
		array(
			'label'      => __( 'Select categories to show in carousel', 'radeema' ),
			//'description' => __( 'Using this option you can change categories shown in carousel', 'radeema' ),
			'settings'   => 'radeema_carousel_id_categories',
			'priority'   => 10,
			'section'    => 'radeema_options',
			'choices' => Radeema_categories_tax_id(),
		)
	) );

	$wp_customize->add_setting( 'news_id_categories',
		array(
			'transport'   => 'refresh',
			'sanitize_callback' => 'radeema_sanitize_multiple_cat_select',
			'type' => 'option'
		) 
	);

	$wp_customize->add_control( new PFUN_Customize_Control_Checkbox_Multiple(
		$wp_customize,
			'news_box_categories_id',
			array(
			'label'      => __( 'Select categories to show in News block', 'radeema' ),
			'settings'   => 'news_id_categories',
			'priority'   => 12,
			'section'    => 'radeema_options',
			'choices' => Radeema_categories_tax_id(),
		)
	) );

	$wp_customize->add_setting(
		"fb_url",
		array(
			'default'    => '',
			'type'       => 'option',
		)
	);

	$wp_customize->add_control(
		'facebook_url',
		array(
			'settings' => "fb_url",
			'label'    =>  esc_html__( 'Facebook url', 'cakifo' ),
			'section'  => 'social_media',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		"insta_url",
		array(
			'default'    => '',
			'type'       => 'option',
		)
	);

	$wp_customize->add_control(
		'instagram_url',
		array(
			'settings' => "insta_url",
			'label'    =>  esc_html__( 'Instagram url', 'cakifo' ),
			'section'  => 'social_media',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		"tw_url",
		array(
			'default'    => '',
			'type'       => 'option',
		)
	);

	$wp_customize->add_control(
		'twitter_url',
		array(
			'settings' => "tw_url",
			'label'    =>  esc_html__( 'Twitter url', 'cakifo' ),
			'section'  => 'social_media',
			'type'     => 'text',
		)
	);
	
}


add_action( 'customize_register', 'radeema_customize_register' );


/**
 * Get only fr categories (default).
 *
 * @return array
 */


if( ! function_exists( 'Radeema_categories_tax_id' ) ) {

	function Radeema_categories_tax_id() {

		//$taxonomy = 'category';
		$args = array(
			'taxonomy' => 'category',
			'lang' => 'fr'
		);

		$cat_terms = get_terms( $args );

		$dropdown = array();

		foreach( $cat_terms as $cat_term ) {

			$dropdown[$cat_term->term_id] = $cat_term->name;
		}

		return $dropdown;
	}
}


/**
 * Sanitization Function - Multiple Categories
 * 
 * @param $input, $setting
 * @return $input
 */
if( !function_exists( 'radeema_sanitize_multiple_cat_select' ) ) {

    function radeema_sanitize_multiple_cat_select( $input, $setting ) {

        if(!empty($input)){

        	$multi_values = ! is_array( $input ) ? explode( ',', $input ) : $input;


            $input = array_map('sanitize_text_field', $multi_values);
        }

        return $input;
    } 
}

//function customizer_scripts() {

	/*wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_style( 'chosen', get_template_directory_uri() . '/css/chosen.css' );
	wp_enqueue_script( 'chosen', get_template_directory_uri() . '/js/chosen.js', array( 'jquery', 'jquery-ui-sortable' ), '1.0' );*/
	/*wp_enqueue_style( 'bootstrap-select', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css' );
	wp_enqueue_script( 'bootstrap-bundle', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js',  array('jquery'), 4.3, false);
	wp_enqueue_script( 'select-bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js',  array('jquery'), 1.13, false);*/
	/*wp_enqueue_style( 'bootstrap-multiselect', get_template_directory_uri() . '/css/bootstrap-multiselect.min.css' );
	wp_enqueue_script( 'bootstrap-multiselect', get_template_directory_uri() . '/js/bootstrap-multiselect.min.js', array('jquery'), '1.0', true );*/
//}

//add_action( 'customize_controls_enqueue_scripts', 'customizer_scripts' , 10 );


/*
	if setting type => theme_mod
		get value : get_theme_mod( 'setting_id', 'default_value' ) 
	else
		get value : get_option( 'setting_id', 'default_value' )

*/

