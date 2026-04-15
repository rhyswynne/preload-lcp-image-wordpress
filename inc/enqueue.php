<?php

/**
 * Preload LCP Load the admin scripts
 *
 * @param [type] $hook
 * @return void
 */
function preload_lcp_load_admin_scripts($hook)
{
    global $typenow;

    $post_types_shown = preload_lcp_get_lcp_post_types();
    $taxonomies_shown = preload_lcp_get_lcp_taxonomies();

    $current_screen = get_current_screen();

    if ( property_exists( $current_screen, 'taxonomy' ) ){
        $current_taxonomy = $current_screen->taxonomy;
    } else {
        $current_taxonomy = '';
    }

    if (in_array($typenow, $post_types_shown) || in_array($current_taxonomy, $taxonomies_shown)) {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script('preload-lcp-admin-script', DR_PRELOAD_LCP_URL . '/inc/js/upload-media.js', array('jquery'), DR_PRELOAD_LCP_PLUGIN_VERSION );
        wp_localize_script(
            'preload-lcp-admin-script',
            'preload_lcp',
            array(
                'title' => __('Choose or Upload Media', 'preload_lcp'),
                'button' => __('Use this media', 'preload_lcp'),
            )
        );
        wp_enqueue_script('preload-lcp-admin-script');
    }

    /** TODO - Add to the options page */
    /* wp_enqueue_media();
    wp_enqueue_script('preload-lcp-admin-script', DR_PRELOAD_LCP_URL . '/inc/js/upload-media.js', array('jquery'), DR_PRELOAD_LCP_PLUGIN_VERSION); */
}
add_action('admin_enqueue_scripts', 'preload_lcp_load_admin_scripts', 10, 1);