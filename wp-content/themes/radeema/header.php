<?php do_action('email_subscription') ?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php wp_head(); ?>
	</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white top-nav">
        <div class="container">

            <div class="collapse navbar-collapse  show" id="top-nav-menu">
                <?php
                    $magrin_direction = function_exists('pll_current_language') && pll_current_language() == "ar" ? "ml-auto" : "mr-auto"; 
                    wp_nav_menu( array( 
                        'theme_location' => 'top-menu', 
                        'container'      => '',
                        'add_li_class'   => 'nav-item',
                        'add_a_class'    => 'nav-link',
                        'menu_class'     => 'navbar-nav '.$magrin_direction,
                        'fallback_cb'    => false
                    ) ); 
                    
 
                    $args = array(
                        'show_flags' => 0,
                        'show_names' => 1, 
                        'hide_current' => false,
                        'dropdown' => 0,
                        //'display_names_as'=>'slug'
                    ); 
                ?>
                <?php if( function_exists('pll_current_language') ) { ?>
                    <ul class="navbar-nav list_lang pb-1">
                        <?php
                            pll_the_languages($args);
                        ?>
                    </ul>
                <?php  } ?>

                <span><a href="<?= get_option('fb_url', '') ?>"><i class='fa fa-facebook-f'></i></a></span>
                <span><a href="<?= get_option('insta_url', '') ?>"><i class='fa fa-instagram'></i></a></span>
                <span><a href="<?= get_option('tw_url', '') ?>"><i class='fa fa-twitter'></i></a></span>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg main-nav" >
        <div class="container">
          <?php 

            if ( has_custom_logo() ) { 
              
              $custom_logo_id = get_theme_mod( 'custom_logo' );
              $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>

              <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="min-height: 80px">
                <img src="<?php echo esc_url( $logo[0] )?>" alt="<?php echo get_bloginfo( 'name' ) ?>" width="80">
              </a>
            <?php  } else { ?>
              <a class="navbar-brand py-5" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo( 'name' ); ?></a>
            <?php } ?>
            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-default navbar-btn show-mobile search-button"><i class='fa fa-search'></i></button>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php
                    wp_nav_menu( array( 
                        'theme_location' => 'main-menu', 
                        'container'      => '',
                        'add_li_class'   => 'nav-item',
                        'add_a_class'    => 'nav-link',
                        'menu_class'     => 'navbar-nav',
                        'walker'         => new Radeema_Custom_Nav_Walker(),
                        'fallback_cb'    => false
                    ) ); 
                ?>
                <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-default navbar-btn hide-mobile"><i class='fa fa-search'></i></button>
            </div>
        </div>
    </nav>