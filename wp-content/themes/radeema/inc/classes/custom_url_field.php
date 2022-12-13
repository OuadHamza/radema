<?php
function call_Custom_Url_Field() {
    new Custom_Url_Field();
}
 
if ( is_admin() ) {
    add_action( 'load-post.php',     'call_Custom_Url_Field' );
    add_action( 'load-post-new.php', 'call_Custom_Url_Field' );
}
 
/**
 * The Class.
 */
class Custom_Url_Field {
 
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
                'some_meta_box_name',
                __( 'Ajouter des fichiers téléchargeables', 'radeema' ),
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
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
        if ( ! isset( $_POST['url_files_custom_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['url_files_custom_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'url_files_custom_box' ) ) {
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
        $mydata = sanitize_text_field( $_POST['url_files'] );
 
        // Update the meta field.

        update_post_meta( $post_id, 'custom_url_files', $mydata );
    }
 
 
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'url_files_custom_box', 'url_files_custom_box_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta( $post->ID, 'custom_url_files', true );
 
        // Display the form, using the current value.
        ?>
        <label for="url_files">
            <?= __( 'Ajouter des fichiers pdf, exel, word ...', 'radeema' ); ?>
        </label>
        <div class="error_url_exist" style="color:red"></div>
        <div class="urls_of_files"><ul></ul></div>
        <input type="hidden" id="url_files" name="url_files" value="<?php echo esc_attr( $value ); ?>" size="25" />

        <input type="button" value="<?php _e( 'Upload Image', 'theme name' ); ?>" class="button custom_media_upload_for_urls" id="get_file_url"/>
        <script type="text/javascript">

            var arrayUrls = []
            if(jQuery("#url_files").val() != ""){
                arrayUrls = jQuery("#url_files").val().split(",");
                var urlList = arrayUrls.map((url, index) => '<li class="url_list_single" key="'+index+'" data-url="'+url+'">'+url+'<input class="enleve_url" value="enlever" type="button" ></li>' )
                    
                jQuery(".urls_of_files ul").html(urlList.join(''))
            }

            jQuery(document).ready( function(){

                _orig_send_attachment = wp.media.editor.send.attachment;
                jQuery('body').on('click','.custom_media_upload_for_urls', function(e) {


                    var send_attachment_bkp = wp.media.editor.send.attachment;
                    var button = jQuery('#'+jQuery(this).attr('id'));
                    wp.media.editor.send.attachment = function(props, attachment){

                    //console.log(jQuery("#url_files").val())
                    if(arrayUrls.indexOf(attachment.url) < 0){
                        var url_files_value = jQuery("#url_files").val()
                        jQuery('#url_files').val( url_files_value == "" ? attachment.url : url_files_value +","+ attachment.url ); 
                        arrayUrls.push(attachment.url);
                        jQuery('.error_url_exist').html('');
                    }else {
                        jQuery('.error_url_exist').html('ce fichier est deja exist !');

                    }
                    var urlList = arrayUrls.map((url, index) => '<li class="url_list_single" key="'+index+'" data-url="'+url+'">'+url+'<input class="enleve_url" value="enlever" type="button" ></li>' )
                    
                    //console.log(arrayUrls,...urlList, urlList.join(''))
                    jQuery(".urls_of_files ul").html(urlList.join(''))


                    }
                    wp.media.editor.open(button);
                    return false;
                });

                jQuery('body').on('click','.enleve_url', function(){

                    console.log('hiii')
                    var button_parent = jQuery( jQuery( this ).parent()[0]);
                    var removed_url = button_parent.data('url')

                    console.log('parent', button_parent, 'url', removed_url)
                    arrayUrls.splice(arrayUrls.indexOf(removed_url), 1);
                    button_parent.remove()
                    jQuery('#url_files').val(arrayUrls.join(','))
                })
            });


        </script>
        <?php
    }
}



