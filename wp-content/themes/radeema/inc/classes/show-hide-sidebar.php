<?php
function call_show_hide_sidebar() {
    new Show_hide_sidebar();
}
 
if ( is_admin() ) {
    add_action( 'load-post.php',     'call_show_hide_sidebar' );
    add_action( 'load-post-new.php', 'call_show_hide_sidebar' );
}
 
/**
 * The Class.
 */
class Show_hide_sidebar {
 
    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post',      array( $this, 'save'         ) );
    }
 
    /**
     * Adds the meta box container.
     */
    public function add_meta_box( $post_type ) {
        // Limit meta box to certain post types.
        $post_types = array( 'post', 'page' );
 
        if ( in_array( $post_type, $post_types ) ) {
            add_meta_box(
                'show_hide_sidebar',
                __( 'Sidebar', 'radeema' ),
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'side'
            );
        }
    }
 
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save( $post_id ) {
 
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */
 
        // Check if our nonce is set.
        if ( ! isset( $_POST['sidebar_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['sidebar_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'verify_sidebar_field' ) ) {
            return $post_id;
        }
 
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
 
        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
 
        /* OK, it's safe for us to save the data now. */
 
        // Sanitize the user input.
        $mydata = sanitize_text_field( $_POST['show_sidebar'] ) == "on" ? 1 : 0 ;
 
        // Update the meta field.

        update_post_meta( $post_id, 'show_sidebar', $mydata );
    }
 
 
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'verify_sidebar_field', 'sidebar_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $show_sidebar = get_post_meta( $post->ID, 'show_sidebar', true );
        //var_dump($show_sidebar);
        // Display the form, using the current value.
        ?>
        <label for="show_sidebar">
            <?= __( 'hide sidebar', 'radeema' ); ?>
        </label>
        <input type="checkbox" id="show_sidebar" name="show_sidebar" <?= $show_sidebar ? "checked" : "" ?> />

        <?php
    }
}
