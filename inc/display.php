<?php


function preload_lcp_display_header()
{

    global $post;

    if (is_singular()) {

        if (wp_is_mobile()) {
            $id_field       = 'lcp_mobile_id_preload';
            $url_field      = 'lcp_mobile_url_preload';
            $force_as_field = 'lcp_mobile_force_as';

            $temp_lcp_id  = get_post_meta(get_the_id(), $id_field, true);
            $temp_lcp_url = get_post_meta(get_the_id(), $url_field, true);

            if (!$temp_lcp_id && !$temp_lcp_url) {
                $id_field = 'lcp_id_preload';
                $url_field = 'lcp_url_preload';
            }
        } else {
            $id_field       = 'lcp_id_preload';
            $url_field      = 'lcp_url_preload';
            $force_as_field = 'lcp_force_as';
        }

        // We're going to begin with ID, but fall back to url
        $lcp_id     = get_post_meta(get_the_id(), $id_field, true);
        $lcp_url    = '';
        $lcp_path   = false;

        if ($lcp_id) {


            $lcp_url  = wp_get_attachment_image_url($lcp_id, 'full');
            $lcp_path = wp_get_original_image_path( $lcp_id );
            $srcset   = wp_get_attachment_image_srcset($lcp_id, array(400, 200));

            $webp     = preload_lcp_check_if_webp_exists($lcp_id);

            if ($webp) {
                $image_type = preload_lcp_get_image_type_from_url($lcp_url, $lcp_id);
                $lcp_url = str_replace('.' . $image_type, '.webp', $lcp_url);
                $srcset = str_replace('.' . $image_type, '.webp', $srcset);
            }
            
        } else {
            $lcp_url = get_post_meta(get_the_id(), $url_field, true);
            $srcset  = false;
        }


        if ($lcp_url) {

            $astype     = false;
            $mime       = false;

            if ($lcp_path) {                
                $imagesize  = wp_getimagesize($lcp_path);
                $mime       = wp_get_image_mime($lcp_path);
            }

  

            if (!empty($mime)) {
                $as_array   = explode("/", $mime);

                if (!empty($as_array)) {
                    $astype = $as_array[0];
                }
            }



            // If we want to force the "As" type, then we shall
            if (!$astype) {
                if (get_post_meta(get_the_ID(), $force_as_field, true)) {
                    $astype = 'image';
                }
            }

            
            echo preload_lcp_image_build_tag($lcp_url, $astype, $mime, $srcset);
        } elseif (!$lcp_url) {

            $show_default = preload_lcp_get_option('preload_lcp_default_to_featured_image');

            if ('show_featured_image' == $show_default) {
                $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());

                if ($post_thumbnail_id) {
                    $lcp_url  = wp_get_attachment_image_url($post_thumbnail_id, 'full');
                    $lcp_path = wp_get_original_image_path($post_thumbnail_id);
                    $srcset   = wp_get_attachment_image_srcset($post_thumbnail_id, array(400, 200));

                    $webp    = preload_lcp_check_if_webp_exists($post_thumbnail_id);

                    if ($webp) {
                        $image_type = preload_lcp_get_image_type_from_url($lcp_url, $lcp_id);
                        $lcp_url = str_replace('.' . $image_type, '.webp', $lcp_url);
                        $srcset = str_replace('.' . $image_type, '.webp', $srcset);
                    }

                    $astype     = false;
                    $mime       = false;
                    $imagesize  = wp_getimagesize($lcp_path);

                    if (!empty($imagesize)) {

                        $mime       = wp_get_image_mime($lcp_url);
                        $as_array   = explode("/", $mime);

                        if (!empty($as_array)) {
                            $astype = $as_array[0];
                        }
                    }


                    // If we want to force the "As" type, then we shall
                    if (!$astype) {
                        if (get_post_meta(get_the_ID(), $force_as_field, true)) {
                            $astype = 'image';
                        }
                    }

                    echo preload_lcp_image_build_tag($lcp_url, $astype, $mime, $srcset);
                }
            }
        }
    } elseif (is_tax() || is_category() || is_tag()) {
        // This is the repeat of the field above, at some point we should refactor it so we only call it once.
        // We don't default to the featured image, that's the only difference.

        $term_id = get_queried_object_id();

        if (wp_is_mobile()) {
            $id_field       = 'lcp_mobile_id_preload';
            $url_field      = 'lcp_mobile_url_preload';
            $force_as_field = 'lcp_mobile_force_as';

            $temp_lcp_id  = get_term_meta($term_id, $id_field, true);
            $temp_lcp_url = get_term_meta($term_id, $url_field, true);

            if (!$temp_lcp_id && !$temp_lcp_url) {
                $id_field = 'lcp_id_preload';
                $url_field = 'lcp_url_preload';
            }
        } else {
            $id_field       = 'lcp_id_preload';
            $url_field      = 'lcp_url_preload';
            $force_as_field = 'lcp_force_as';
        }

        // We're going to begin with ID, but fall back to url
        $lcp_id     = get_term_meta($term_id, $id_field, true);
        $lcp_url    = '';

        if ($lcp_id) {
            $lcp_url  = wp_get_attachment_image_url($lcp_id, 'full');
            $lcp_path = wp_get_original_image_path($lcp_id);
            $srcset   = wp_get_attachment_image_srcset($lcp_id, array(400, 200));

            $webp    = preload_lcp_check_if_webp_exists($lcp_id);

            if ($webp) {
                $image_type = preload_lcp_get_image_type_from_url($lcp_url, $lcp_id);
                $lcp_url = str_replace('.' . $image_type, '.webp', $lcp_url);
                $srcset = str_replace('.' . $image_type, '.webp', $srcset);
            }
        } else {
            $lcp_url = get_term_meta($term_id, $url_field, true);
            $srcset  = false;
        }


        if ($lcp_url) {

            $astype     = false;
            $mime       = false;
            $imagesize  = wp_getimagesize($lcp_path);

            if (!empty($imagesize)) {

                $mime       = wp_get_image_mime($lcp_url);
                $as_array   = explode("/", $mime);

                if (!empty($as_array)) {
                    $astype = $as_array[0];
                }
            }


            // If we want to force the "As" type, then we shall
            if (!$astype) {
                if (get_term_meta($term_id, $force_as_field, true)) {
                    $astype = 'image';
                }
            }

            echo preload_lcp_image_build_tag($lcp_url, $astype, $mime, $srcset);
        }
    }
}
add_action('wp_head', 'preload_lcp_display_header');
