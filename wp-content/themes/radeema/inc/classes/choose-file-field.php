<?php
function call_Choose_file_Field() {
    new Choose_file_Field();
}
 
if ( is_admin() ) {
    add_action( 'load-post.php',     'call_Choose_file_Field' );
    add_action( 'load-post-new.php', 'call_Choose_file_Field' );
}
 
/**
 * The Class.
 */
class Choose_file_Field {
 
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
                'choose_file',
                __( 'File', 'radeema' ),
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'side'
            );
            // remove yoast seo box from post type file
            remove_meta_box('wpseo_meta', 'post-file', 'normal');
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
        if ( ! isset( $_POST['url_file_custom_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['url_file_custom_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'url_file_custom_box' ) ) {
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
        $url_file = sanitize_url( $_POST['url_file'] );
        $file_name = sanitize_text_field( $_POST['file_name'] );
        $file_icon = sanitize_url( $_POST['file_icon'] );

        $data = array(
            'url_file' => $url_file, 
            'file_name' => $file_name,
            'file_icon' => $file_icon,
        );

        $mydata = json_encode($data);
        // Update the meta field.

        update_post_meta( $post_id, 'custom_url_file', $mydata );
    }
 
 
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'url_file_custom_box', 'url_file_custom_box_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $value = json_decode(get_post_meta( $post->ID, 'custom_url_file', true ));
        //var_dump($value);
        $url_file = ""; 
        $file_name = "";
        $file_icon = "";
        $content_file =  __('No file selected ', 'radeema');

        if(!empty($value)){

            $url_file = $value->url_file; 
            $file_name = $value->file_name;
            $file_icon = $value->file_icon;

            $content_file = '<div style="border: #ccd0d4 solid 1px;min-height: 84px;position: relative;background: #fff;">
                <div style="position: absolute;top: 0;left: 0;bottom: 0;padding: 10px;background: #F1F1F1;border-right: #d5d9dd solid 1px;">
                    <image src="'. $file_icon .'" data-name="icon" title="'. $file_name .'">
                </div>
                <div style="padding: 10px;margin-left: 69px;">
                    <p>'. $file_name .'</p>
                </div>
            </div>';
        }
 
        // Display the form, using the current value.
        //var_dump($value);
        ?>
        <p><strong><?= __( 'Choose a file: pdf, exel, word ...', 'radeema' ); ?></strong></p>

        <div id="stats_file" style="margin-bottom: 10px"><?= $content_file ?></div>
        <input type="hidden" id="url_file" name="url_file" value="<?php echo esc_attr( $url_file ); ?>" />
        <input type="hidden" id="file_name" name="file_name" value="<?php echo esc_attr( $file_name ); ?>" />
        <input type="hidden" id="file_icon" name="file_icon" value="<?php echo esc_attr( $file_icon ); ?>" />

        <input type="button" value="<?= __( 'Choose file', 'radeema' ); ?>" class="button btn_choose_file" id="get_file_url"/>
        <script type="text/javascript">

            jQuery(document).ready( function(){

                _orig_send_attachment = wp.media.editor.send.attachment;
                jQuery('body').on('click','.btn_choose_file', function(e) {


                    var send_attachment_bkp = wp.media.editor.send.attachment;
                    var button = jQuery('#'+jQuery(this).attr('id'));
                    wp.media.editor.send.attachment = function(props, attachment){

                        var url_file_value = jQuery("#url_file").val()
                        jQuery('#url_file').val( attachment.url );
                        jQuery('#file_name').val( attachment.filename );
                        jQuery('#file_icon').val( attachment.icon );

                        //console.log(props, attachment)

                        jQuery('#stats_file').html('<div style="border: #ccd0d4 solid 1px;min-height: 84px;position: relative;background: #fff;"><div style="position: absolute;top: 0;left: 0;bottom: 0;padding: 10px;background: #F1F1F1;border-right: #d5d9dd solid 1px;"><image src="'+attachment.icon+'" data-name="icon" title="'+attachment.title+'"></div><div style="padding: 10px;margin-left: 69px;"><p>'+attachment.filename+'</p></div></div>')

                    }
                    wp.media.editor.open(button);
                    return false;
                });
            });


        </script>
        <?php
    }
}



