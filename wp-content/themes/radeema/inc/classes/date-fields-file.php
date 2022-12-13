<?php
function call_Fields_date_for_files() {
    new Fields_date_for_files();
}
 
if ( is_admin() ) {
    add_action( 'load-post.php',     'call_Fields_date_for_files' );
    add_action( 'load-post-new.php', 'call_Fields_date_for_files' );
}
 
/**
 * The Class.
 */
class Fields_date_for_files {
 
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
        //var_dump($post_type);
        $post_types = array( 'post-file' );
 
        if ( in_array( $post_type, $post_types ) ) {
            add_meta_box(
                'date_fields',
                __( 'File', 'radeema' ),
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'advanced',
                'core'
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
        if ( ! isset( $_POST['date__custom_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['date__custom_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'date__custom_box' ) ) {
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
        $date_lancement = sanitize_text_field( $_POST['date_lancement'] );
        $date_remise = sanitize_text_field( $_POST['date_remise'] );
        $date_ouverture = sanitize_text_field( $_POST['date_ouverture'] );

        $data = array(
            'date_lancement' => $date_lancement, 
            'date_remise' => $date_remise,
            'date_ouverture' => $date_ouverture,
        );
        //var_dump($data);die();
        $mydata = json_encode($data);
        // Update the meta field.

        update_post_meta( $post_id, 'custom_date', $mydata );
    }
 
 
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'date__custom_box', 'date__custom_box_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $value = json_decode(get_post_meta( $post->ID, 'custom_date', true ));
        //var_dump($value);
        $date_lancement = ""; 
        $date_remise = "";
        $date_ouverture = "";
        $content_file =  __('No file selected ', 'radeema');

        if(!empty($value)){

            $date_lancement = $value->date_lancement; 
            $date_remise = $value->date_remise;
            $date_ouverture = $value->date_ouverture;

        }
 
        // Display the form, using the current value.
        //var_dump($value);
        ?>

        <p><strong><?= __( 'date lancement', 'radeema' ); ?></strong></p>
        <input type="date" id="date_lancement" name="date_lancement" value="<?php echo esc_attr( $date_lancement ); ?>" />
        <p><strong><?= __( 'date remise', 'radeema' ); ?></strong></p>
        <input type="date" id="date_remise" name="date_remise" value="<?php echo esc_attr( $date_remise ); ?>" />
        <p><strong><?= __( 'date ouverture', 'radeema' ); ?></strong></p>
        <input type="date" id="date_ouverture" name="date_ouverture" value="<?php echo esc_attr( $date_ouverture ); ?>" />

        <?php
    }
}



