<?php

function links_wdscript() {
    wp_enqueue_media();
    wp_enqueue_script('widget_script', get_template_directory_uri() . '/js/widget-links.js', false, '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'links_wdscript');


class Radeema_Links extends WP_Widget {

	function __construct () {

		parent::__construct(
            'radeema_links',  // Base ID
            'Radeema lien',   // Name
            array(
                'description' => 'un lien pour les autres site/application comme agence en ligne', 
            )
        );
	}

	public function form( $instance ) {

		$defaults = array(
			'title_fr' => '',
			'description_fr' => '',
			'url' => '',
			'image' => ''
		); 

		//var_dump(pll_languages_list(), function_exists('pll_languages_list'));

		$instance = wp_parse_args( (array) $instance, $defaults ); 

		if(function_exists('pll_languages_list')){

			foreach ( pll_languages_list() as $lang) { 

				if($lang == 'fr') continue;
				$defaults['title_'.$lang] = '';
				$defaults['description_'.$lang] = '';
				?>


				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('title_'.$lang) ); ?>">
						<strong>Titre <?= $lang ?></strong>
					</label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title_'.$lang) ); ?>" name="<?php echo esc_attr( $this->get_field_name('title_'.$lang) ); ?>" type="text" value="<?php echo esc_attr( $instance['title_'.$lang] ); ?>" />   
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('description_'.$lang) ); ?>">
						<strong>Description <?= $lang ?></strong>
					</label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('description_'.$lang) ); ?>" name="<?php echo esc_attr( $this->get_field_name('description_'.$lang) ); ?>" type="text" value="<?php echo esc_attr( $instance['description_'.$lang] ); ?>" />   
				</p>
			<?php } 
		} ?>	

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title_fr') ); ?>">
				<strong>Titre</strong>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title_fr') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title_fr') ); ?>" type="text" value="<?php echo esc_attr( $instance['title_fr'] ); ?>" />   
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('description_fr') ); ?>">
				<strong>Description</strong>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('description_fr') ); ?>" name="<?php echo esc_attr( $this->get_field_name('description_fr') ); ?>" type="text" value="<?php echo esc_attr( $instance['description_fr'] ); ?>" />   
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('url') ); ?>">
				<strong>Lien</strong>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('url') ); ?>" type="text" value="<?php echo esc_attr( $instance['url'] ); ?>" />   
		</p>
		<div id="<?php echo esc_attr( $this->get_field_id('image') ); ?>" >
			<input type="button" value="<?php _e( 'Upload Image', 'theme name' ); ?>" class="button custom_media_upload" id="<?php echo esc_attr( $this->get_field_id('image') ); ?>"/>

			<input class="image_url_input" type="hidden" name="<?php echo esc_attr( $this->get_field_name('image') ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>"/>

			<img class="custom_media_image <?php echo esc_attr( $this->get_field_id('image') ); ?>" src="<?php if(!empty($instance['image'])){echo $instance['image'];} ?>" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" />
		</div>

      	<?php
	}


	public function widget( $args, $instance) {

		//var_dump($instance, get_locale(),pll_current_language());
		if(function_exists('pll_current_language')){

			$title = apply_filters("widget_title", empty($instance['title_'.pll_current_language()]) ? "" : $instance['title_'.pll_current_language()], $instance, $this->id_base);
			
			$description = isset( $instance['description_'.pll_current_language()] ) ? $instance['description_'.pll_current_language()] : '';
		}else {

			$title = apply_filters("widget_title", empty($instance['title_fr']) ? "" : $instance['title_fr'], $instance, $this->id_base);

			$description = isset( $instance['description_fr'] ) ? $instance['description_fr'] : '';
		} 

		$url = isset( $instance['url'] ) ? $instance['url'] : '';

		$image = isset( $instance['image'] ) ? $instance['image'] : ''; 
		?>



		<div class="col-sm-6 col-lg-3 link-block">
			<div class="w-100">
				<img class="d-block m-auto" src="<?= $image ?>">
				<a href="<?= $url ?>" ><h4><?= $title ?></h4></a>
				<p class="description"><?= $description ?></p>
			</div>
		</div>

		<?php
	}
}

?>