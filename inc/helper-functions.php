<?php


/**
 * Rudimentary function to check if there is a webp version of the image that exists
 * 
 * Used to check if the webp image has 
 *
 * @param  integer $image_id
 * @return void
 */
function preload_lcp_check_if_webp_exists($image_id)
{
    $image_url   = wp_get_attachment_image_url($image_id, 'full');

    $image_size  = wp_getimagesize($image_url);

    if ( empty( $image_size ) ) {
        return false;
    }

    $image_type  = preload_lcp_get_image_type_from_url($image_url);
    $image_path  = get_attached_file($image_id);
    $webp_path   = str_replace('.' . $image_type, '.webp', $image_path);

    if (file_exists($webp_path . '.webp')) {
        return true;
    } else {
        return false;
    }
}


/**
 * Get the image Type from the URL
 *
 * @param [type] $image_url
 * @return void
 */
function preload_lcp_get_image_type_from_url($image_url)
{
    $mime        = wp_get_image_mime($image_url);
    $image_array = explode("/", $mime);
    $image_type  = false;

    if (!empty($image_array)) {
        $image_type = $image_array[1];
    }

    return $image_type;
}

/**
 * Get the Post Types to show the LCP Image metabox on
 * 
 * Used in case not set to show the default box
 *
 * @return array
 */
function preload_lcp_get_lcp_post_types()
{

    $options    = get_option('preload_lcp_image_settings');
    
    if (!is_array($options)) {
        $post_types_shown = array('post', 'page');
    } else {
        if (!array_key_exists('preload_lcp_post_type_settings', $options)) {
            $post_types_shown = array('post', 'page');
        } else {
            $post_types_shown = $options['preload_lcp_post_type_settings'];
        }
    }

    return $post_types_shown;
}
