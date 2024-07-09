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

/**
 * Wrapper function to get one option field
 *
 * @param  string $option_field  The option to return
 * @return mixed                 The option we've returned, or false
 */
function preload_lcp_get_option( $option_field ) {
    $all_options = get_option('preload_lcp_image_settings');

    if (is_array($all_options)) {
        if (array_key_exists($option_field, $all_options)) {
            $option = $all_options[$option_field];
        } else {
            $option = false;
        }
    } else {
        $option = false;
    }

    return $option;
}


/**
 * Function to build the LCP Image
 *
 * @param  string $lcp_url The URL of the Preloaded LCP Image
 * @param  mixed  $astype  The string as type, or false if not present.
 * @param  mixed  $mime    The mime type of the image, or false if not present.
 * @param  mixed  $srcset  The srcset of the image, or false if not present.
 * @return string          The Preloaded LCP tag
 */
function preload_lcp_image_build_tag( $lcp_url, $astype = false, $mime = false, $srcset = false ) {
    
    $tag  = '<!-- Preload LCP Element - WordPress Plugin -->';
    $tag .= '<link rel="preload" fetchpriority="high" ';
    
    if ($astype) { 
        $tag .= ' as="' . esc_attr($astype) . '" ';
    }
    
    $tag .= ' href="' . esc_attr($lcp_url) .'" '; 

    if ($mime) {  
        $tag .= ' type="' . esc_attr($mime) . '" '; 
    } 
    if ($srcset) { 
        $tag .= ' imagesrcset="' . esc_attr($srcset) . '" '; 
    }
    
    $tag .= '><!-- / Preload LCP Element - WordPress Plugin -->';

    return $tag;
}