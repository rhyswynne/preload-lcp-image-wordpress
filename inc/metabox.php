<?php

/**
 * Add the metabox to the page
 *
 * @return void
 */
function preload_lcp_add_metabox()
{

    $post_types_shown = preload_lcp_get_lcp_post_types();

    add_meta_box(
        'preload-lcp-metabox',                 // Unique ID
        'Preload LCP Image',      // Box title
        'preload_lcp_metabox_html',  // Content callback, must be of type callable
        $post_types_shown
    );
}
add_action('add_meta_boxes', 'preload_lcp_add_metabox');


/**
 * Render the metabox
 */
function preload_lcp_metabox_html()
{

    // Variables
    global $post;
    $lcp_url    = get_post_meta($post->ID, 'lcp_url_preload', true);
    $lcp_id     = get_post_meta( $post->ID, 'lcp_id_preload', true );
    
?>

    <fieldset class="lcp-metabox-fieldset">

        <div>
            <?php
            /**
             * The label for the media field
             */
            ?>
            <label for="lcp_url_preload"><?php _e('URL of the Image', 'preload_lcp') ?></label><br>

            <?php
            /**
             * The actual field that will hold the URL for our file
             */
            ?>
            <p class="description"><?php _e('You can add a URL of an image here, or alternatively click "Find Media" to find the media file to use instead.', 'preload_lcp') ?></p>
            <input type="url" class="large-text" name="lcp_url_preload" id="lcp_url_preload" value="<?php echo esc_attr($lcp_url); ?>"><br>
            <input type="hidden" name="lcp_id_preload" id="lcp_id_preload" value="<?php echo esc_attr($lcp_id); ?>"><br>

            <?php
            /**
             * The button that opens our media uploader
             * The `data-media-uploader-target` value should match the ID/unique selector of your field.
             * We'll use this value to dynamically inject the file URL of our uploaded media asset into your field once successful (in the myplugin-media.js file)
             */
            ?>
            <button type="button" class="button" id="lcp_find_media_url_button" data-media-uploader-target="#lcp_url_preload"  data-media-uploader-id="#lcp_id_preload"><?php _e('Find Image to Preload', 'myplugin') ?></button>
        </div>

    </fieldset>

<?php

    // Security field
    wp_nonce_field('preload_lcp_metabox_process', 'preload_lcp_metabox_nonce');
}


/**
 * Save the post data for the LCP Metabox
 *
 * @param  integer $post_id The post string
 * @return void
 */
function preload_lcp_metabox_save_postdata($post_id)
{
    
    if (!isset($_POST['preload_lcp_metabox_nonce']) || !wp_verify_nonce($_POST['preload_lcp_metabox_nonce'], 'preload_lcp_metabox_process' ) ) {
        return;
    }

    if (array_key_exists('lcp_url_preload', $_POST)) {
        update_post_meta(
            $post_id,
            'lcp_url_preload',
            sanitize_url( $_POST['lcp_url_preload'] )
        );
    }

    if (array_key_exists('lcp_id_preload', $_POST)) {
        update_post_meta(
            $post_id,
            'lcp_id_preload',
            sanitize_text_field( $_POST['lcp_id_preload'] )
        );
    }
}
add_action('save_post', 'preload_lcp_metabox_save_postdata');
