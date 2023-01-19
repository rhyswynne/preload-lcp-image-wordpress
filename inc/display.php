<?php


function preload_lcp_display_header()
{

    global $post;

    if (is_singular()) {

        // We're going to begin with ID, but fall back to url
        $lcp_id     = get_post_meta(get_the_id(), 'lcp_id_preload', true);
        $lcp_url    = '';

        if ($lcp_id) {
            $lcp_url = wp_get_attachment_image_url($lcp_id, 'full');
            $srcset  = wp_get_attachment_image_srcset($lcp_id, array(400, 200));

            $webp    = preload_lcp_check_if_webp_exists($lcp_id);

            if ($webp) {
                $image_type = preload_lcp_get_image_type_from_url($lcp_url);

                $lcp_url = str_replace('.' . $image_type, '.webp', $lcp_url);
                $srcset = str_replace('.' . $image_type, '.webp', $srcset);
            }
        } else {
            $lcp_url = get_post_meta(get_the_id(), 'lcp_url_preload', true);
            $srcset  = false;
        }


        if ($lcp_url) {
            $mime       = wp_get_image_mime($lcp_url);
            $as_array   = explode("/", $mime);
            $astype     = false;

            if (!empty($as_array)) {
                $astype = $as_array[0];
            }
?>
            <!-- Preload LCP Element - WordPress Plugin -->
            <link rel="preload" fetchpriority="high" as="<?php echo $astype; ?>" href="<?php echo $lcp_url; ?>" <?php if ($mime) {
                                                                                                                    echo 'type="' . $mime . '"';
                                                                                                                } ?> <?php if ($srcset) {
                                                                                                                            echo 'imagesrcset="' . $srcset . '"';
                                                                                                                        } ?>>
            <!-- / Preload LCP Element - WordPress Plugin -->
<?php
        }
    }
}
add_action('wp_head', 'preload_lcp_display_header');
