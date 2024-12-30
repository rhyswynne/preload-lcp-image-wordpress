<?php

/**
 * Add the taxonomy metabox
 *
 * @return void
 */
function preload_lcp_add_taxonomy_metabox()
{
    $taxonomies = preload_lcp_get_lcp_taxonomies();

    foreach ($taxonomies as $taxonomy) {
        add_action("{$taxonomy}_add_form_fields", 'preload_lcp_taxonomy_metabox_html', 50, 2);
        add_action("{$taxonomy}_edit_form_fields", 'preload_lcp_taxonomy_metabox_html', 50, 2);
    }
}
add_action('admin_init', 'preload_lcp_add_taxonomy_metabox');


/**
 * Add the HTML for the taxonomy metabox
 *
 * @param WP_Term $term The term object
 * @return void
 */
function preload_lcp_taxonomy_metabox_html($term)
{
    // Check if this is an edit screen
    $is_edit = is_object($term);

    // Get the term ID if editing
    $term_id = $is_edit ? $term->term_id : '';

    // Get the existing value if editing
    $lcp_url    = get_term_meta($term_id, 'lcp_url_preload', true);
    $lcp_id     = get_term_meta($term_id, 'lcp_id_preload', true);

    $lcp_mobile_url = get_term_meta($term_id, 'lcp_mobile_url_preload', true);
    $lcp_mobile_id  = get_term_meta($term_id, 'lcp_mobile_id_preload', true);

    $lcp_force_as        = get_term_meta($term_id, 'lcp_force_as', true);
    $lcp_mobile_force_as = get_term_meta($term_id, 'lcp_mobile_force_as', true);

    if ($is_edit) {

?>
        <tr class="form-field term-group-wrap">
            <th scope="row"><label for="lcp_url_preload"><?php _e('URL of the Image', 'preload_lcp'); ?></label></th>
            <td>
                <input type="url" name="lcp_url_preload" id="lcp_url_preload" value="<?php echo esc_attr($lcp_url); ?>">
                <input type="hidden" name="lcp_id_preload" id="lcp_id_preload" value="<?php echo esc_attr($lcp_id); ?>">
                <button type="button" class="button" id="lcp_find_media_url_button" data-media-uploader-target="#lcp_url_preload" data-media-uploader-id="#lcp_id_preload"><?php _e('Find Image to Preload', 'preload_lcp'); ?></button>
                <p class="description"><?php _e('You can add a URL of an image here, or alternatively click "Find Media" to find the media file to use instead.', 'preload_lcp'); ?></p>
            </td>
        </tr>
        <tr class="form-field term-group-wrap">
            <th scope="row"><label for="lcp_force_as"><?php _e('Force the file to be preloaded as an image', 'preload_lcp') ?></label></th>
            <td>
                <input type="checkbox" name="lcp_force_as" id="lcp_force_as" value="1" <?php checked(esc_attr($lcp_force_as), 1, true); ?> />
                <p class="description"><?php _e('Advanced setting: if you are getting an console error of <code>&lt;link rel=preload&gt; must have a valid `as` value</code>, then check this box.', 'preload_lcp') ?></p>
            </td>
        </tr>
        <tr class="form-field term-group-wrap">
            <th scope="row"><label for="lcp_url_mobile_preload"><?php _e('URL of the Image for Mobile', 'preload_lcp') ?></label></th>
            <td>
                <input type="url" class="large-text" name="lcp_mobile_url_preload" id="lcp_mobile_url_preload" value="<?php echo esc_attr($lcp_mobile_url); ?>">
                <input type="hidden" name="lcp_mobile_id_preload" id="lcp_mobile_id_preload" value="<?php echo esc_attr($lcp_mobile_id); ?>">
                <button type="button" class="button" id="lcp_find_media_url_button" data-media-uploader-target="#lcp_mobile_url_preload" data-media-uploader-id="#lcp_mobile_id_preload"><?php _e('Find Image to Preload', 'myplugin') ?></button>
                <p class="description"><?php _e('Should you wish to specify a different image to preload on mobile, you can do so here. If left blank, the image set in the "URL of the Image" will be used. Use this if the image is fundamentally different on mobile.', 'preload_lcp') ?></p>
            </td>
        </tr>
        <tr class="form-field term-group-wrap">
            <th scope="row"><label for="lcp_mobile_force_as"><?php _e('Force the file to be preloaded as an image (on mobile)', 'preload_lcp') ?></label></th>
            <td>
            <input type="checkbox" name="lcp_mobile_force_as" id="lcp_mobile_force_as" value="1" <?php checked(esc_attr($lcp_mobile_force_as), 1, true); ?> />
            <p class="description"><?php _e('Advanced setting: if you are getting an console error of <code>&lt;link rel=preload&gt; must have a valid `as` value</code> on mobile, then check this box.', 'preload_lcp') ?></p>
            </td>
        </tr>
    <?php


    } else {
    ?>
        <div class="form-field term-group">
            <label for="lcp_url_preload"><?php _e('URL of the Image', 'preload_lcp'); ?></label>
            <input type="url" name="lcp_url_preload" id="lcp_url_preload" value="<?php echo esc_attr($lcp_url); ?>">
            <input type="hidden" name="lcp_id_preload" id="lcp_id_preload" value="<?php echo esc_attr($lcp_id); ?>">
            <button type="button" class="button" id="lcp_find_media_url_button" data-media-uploader-target="#lcp_url_preload" data-media-uploader-id="#lcp_id_preload"><?php _e('Find Image to Preload', 'preload_lcp'); ?></button>
            <p class="description"><?php _e('You can add a URL of an image here, or alternatively click "Find Media" to find the media file to use instead.', 'preload_lcp'); ?></p>
        </div>

        <div class="form-field term-group">
            <p>
                <label for="lcp_force_as"><?php _e('Force the file to be preloaded as an image', 'preload_lcp') ?></label> <input type="checkbox" name="lcp_force_as" id="lcp_force_as" value="1" <?php checked(esc_attr($lcp_force_as), 1, true); ?> />
            </p>
            <p class="description"><?php _e('Advanced setting: if you are getting an console error of <code>&lt;link rel=preload&gt; must have a valid `as` value</code>, then check this box.', 'preload_lcp') ?></p>
        </div>

        <div class="form-field term-group">

            <p>
                <label for="lcp_url_mobile_preload"><?php _e('URL of the Image for Mobile', 'preload_lcp') ?></label>
                <?php
                /**
                 * The actual field that will hold the URL for our file
                 */
                ?>
                <input type="url" class="large-text" name="lcp_mobile_url_preload" id="lcp_mobile_url_preload" value="<?php echo esc_attr($lcp_mobile_url); ?>">
                <input type="hidden" name="lcp_mobile_id_preload" id="lcp_mobile_id_preload" value="<?php echo esc_attr($lcp_mobile_id); ?>">
            </p>


            <?php
            /**
             * The button that opens our media uploader
             * The `data-media-uploader-target` value should match the ID/unique selector of your field.
             * We'll use this value to dynamically inject the file URL of our uploaded media asset into your field once successful (in the myplugin-media.js file)
             */
            ?>
            <p>
                <button type="button" class="button" id="lcp_find_media_url_button" data-media-uploader-target="#lcp_mobile_url_preload" data-media-uploader-id="#lcp_mobile_id_preload"><?php _e('Find Image to Preload', 'myplugin') ?></button>
            </p>

            <p class="description"><?php _e('Should you wish to specify a different image to preload on mobile, you can do so here. If left blank, the image set in the "URL of the Image" will be used. Use this if the image is fundamentally different on mobile.', 'preload_lcp') ?></p>
        </div>

        <div class="form-field term-group">
            <p>
                <label for="lcp_mobile_force_as"><?php _e('Force the file to be preloaded as an image (on mobile)', 'preload_lcp') ?></label> <input type="checkbox" name="lcp_mobile_force_as" id="lcp_mobile_force_as" value="1" <?php checked(esc_attr($lcp_mobile_force_as), 1, true); ?> />
            </p>
            <p class="description"><?php _e('Advanced setting: if you are getting an console error of <code>&lt;link rel=preload&gt; must have a valid `as` value</code> on mobile, then check this box.', 'preload_lcp') ?></p>
        </div>
<?php
    }
}

/**
 * Save the taxonomy metabox
 *
 * @param  int $term_id the ID of the term being saved
 * @return void
 */
function preload_lcp_save_taxonomy_metabox($term_id)
{

    if (isset($_POST['lcp_url_preload'])) {
        update_term_meta($term_id, 'lcp_url_preload', sanitize_url($_POST['lcp_url_preload']));
    }

    if (isset($_POST['lcp_id_preload'])) {
        update_term_meta($term_id, 'lcp_id_preload', sanitize_text_field($_POST['lcp_id_preload']));
    }


    if (isset($_POST['lcp_mobile_url_preload'])) {
        update_term_meta($term_id, 'lcp_mobile_url_preload', sanitize_url($_POST['lcp_mobile_url_preload']));
    }

    if (isset($_POST['lcp_mobile_id_preload'])) {
        update_term_meta($term_id, 'lcp_mobile_id_preload', sanitize_text_field($_POST['lcp_mobile_id_preload']));
    }
    if (array_key_exists('lcp_force_as', $_POST)) {
        update_term_meta(
            $term_id,
            'lcp_force_as',
            sanitize_text_field($_POST['lcp_force_as'])
        );
    } else {
        delete_term_meta($term_id, 'lcp_force_as');
    }

    if (array_key_exists('lcp_mobile_force_as', $_POST)) {
        update_term_meta(
            $term_id,
            'lcp_mobile_force_as',
            sanitize_text_field($_POST['lcp_mobile_force_as'])
        );
    } else {
        delete_term_meta($term_id, 'lcp_mobile_force_as');
    }
}
add_action('created_term', 'preload_lcp_save_taxonomy_metabox', 10, 3);
add_action('edited_term', 'preload_lcp_save_taxonomy_metabox', 10, 3);
