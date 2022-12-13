<footer class="p-4" dir="ltr">
    <div class="container">

        <div class="row">
            <div class="col-lg-6">
                <img class="d-block radeema-center" src="<?= get_site_url() ?>/wp-content/uploads/2021/10/icon_contact.png">
            </div>
            <div class="col-lg-1">
            </div>
            <div class="col-lg-5 newsletter text-center">
              <form class="pt-4" action="" method="post">
                  <h4><?= translate_options_radeema('Newsletter', 'radeema') ?></h4>
                  <input type="email" name="subscriber_email" placeholder="<?= translate_options_radeema('Email address', 'radeema') ?>">
                  <input type="hidden" name="submit_subscription" value="Submit">
                  <!-- <input type="submit" name="submit_form" value="Submit"> -->
              </form>
              <nav class="navbar navbar-expand-lg navbar-light">
              <div class="collapse navbar-collapse show justify-content-center d-flex" id="navbarSupportedContent">
                <?php
                  wp_nav_menu( array( 
                    'theme_location' => 'secondairy-bottom-menu', 
                    'container'      => '',
                    'add_li_class'   => 'nav-item',
                    'add_a_class'    => 'nav-link',
                    'menu_class'     => 'navbar-nav mx-auto',
                    'fallback_cb'    => false ) ); 
                ?>
              </div>
            </div>
        </div>
      	<div class="row">
      		<div class="col-lg-6">
      			<nav class="navbar navbar-expand-lg navbar-light">
              <div class="collapse navbar-collapse show justify-content-center d-flex" id="navbarSupportedContent">
                <?php
                  // user domain/feed to rss `bloginfo('rss2_url')`  `http://example.com/?feed=rss2` `radeema-wordpress/feed/rss2/`
                  wp_nav_menu( array( 
                    'theme_location' => 'bottom-menu', 
                    'container'      => '',
                    'add_li_class'   => 'nav-item',
                    'add_a_class'    => 'nav-link',
                    'menu_class'     => 'navbar-nav mx-auto',
                    'fallback_cb'    => false ) ); 
                ?>
              </div>
            </nav>
      		</div>
          <div class="col-lg-1">
          </div>
      		<div class="col-lg-5 m-auto">
      			<p><?= translate_options_radeema('© All rights reserved Radeema 2021', 'radeema') ?></p>
      		</div>
      	</div>
        <a href="#top" id="smoothup" title="Back to top"><i class="fa fa-arrow-up"></i></a>
    </div>
</footer>
<div id="popup-consent" class="fixed-bottom bg-radeema-green text-center text-white" style="display: none">
  <div class="p-4">
    <p><?= translate_options_radeema('this site use cookies for access and stock non sensitive information such as your IP address', 'radeema') ?></p>
    <p><?= translate_options_radeema("The processing of your data allows us, for example, to improve your user experience and measure the site's audience", 'radeema') ?></p>
    <p><?= translate_options_radeema('by using our site you agree with our', 'radeema') ?> <a href="#" class="text-warning"><?= translate_options_radeema('privacy policy conditions', 'radeema') ?></a></p>
    <button class="btn-radeema btn-radeema-white" id="popup-consent-btn"><?= translate_options_radeema('Accept', 'radeema') ?></button>
  </div>
</div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content modal-search">
          <div class="modal-body">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <div class="form-group">
                <input type="search" name="s" class="form-control" placeholder="<?= translate_options_radeema('Search', 'radeema') ?> ..." value="<?php echo get_search_query(); ?>" required>
                <input type="hidden" value="post" name="post_type" id="post_type" />
              </div>
              <button type="submit" class="btn-radeema btn-radeema-primary"><?= translate_options_radeema('Search', 'radeema') ?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php if( isset($_COOKIE['subscription_status']) ) { 

      $background = "";
      $message = "";

      if( $_COOKIE['subscription_status'] == "verified" ) {
        $background = "bg-success";
        $message = "subscription complete";
      }else if($_COOKIE['subscription_status'] == "exist") {
        $background = "bg-warning";
        $message = "this email is already exist";
      }else {
        $background = "bg-danger";
        $message = "please enter a valid email";
      }

      ?>
      <div class="modal fade" id="message_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content <?= $background ?>">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <p class="mb-0 text-center text-white w-80"><?= $message ?></p>
            </div>
          </div>
        </div>
      </div>
      <button data-toggle="modal" data-target="#message_modal" class="d-none open_message_modal"></button>
    <?php } ?>
    <?php wp_footer(); ?>
    <?php 
      //var_dump($_COOKIE['email_registred']);
      if( isset($_COOKIE['subscription_status']) ){ ?>

        <script type="text/javascript">
          jQuery('.open_message_modal').click()
        </script>
    <?php } ?>
  </body>
</html>
