<?php

/**
 * Register the Preload LCP Options Menu
 * @return void
 */
function preload_lcp_image_options()
{
    $options_suffix = add_options_page('Preload LCP Image', 'Preload LCP Image', 'manage_options', 'preloadlcpimage', 'preload_lcp_image_options_page');
    add_action('load-' . $options_suffix, 'preload_lcp_enqueue_on_option_page');
}
add_action('admin_menu', 'preload_lcp_image_options');


function preload_lcp_image_settings_init()
{
    register_setting('preload_LCP_Image', 'preload_lcp_image_settings');
    add_settings_section(
        'preload_lcp_admin_section',
        __('', 'preload_lcp'),
        'preload_lcp_display_settings_callback',
        'preload_LCP_Image'
    );

    add_settings_field(
        'preload_lcp_post_type_settings',
        __('Posts types to show', 'preload_lcp'),
        'preload_lcp_post_type_settings_render',
        'preload_LCP_Image',
        'preload_lcp_admin_section'
    );

    add_settings_field(
        'preload_lcp_taxonomy_settings',
        __('Posts Taxonomies to show', 'preload_lcp'),
        'preload_lcp_taxonomy_settings_render',
        'preload_LCP_Image',
        'preload_lcp_admin_section'
    );

    add_settings_field(
        'preload_lcp_default_to_featured_image',
        __('Default to Featured Image', 'preload_lcp'),
        'preload_lcp_default_to_featured_image_render',
        'preload_LCP_Image',
        'preload_lcp_admin_section'
    );
}
add_action('admin_init', 'preload_lcp_image_settings_init');


/**
 * The display settings section callback
 * 
 * Blank because I haven't figured out another way to do this
 * @return void
 */
function preload_lcp_display_settings_callback() {}


/**
 * Render the post type settings option
 * 
 * @return void
 */
function preload_lcp_post_type_settings_render()
{

    $post_types       = get_post_types(array('public' => true), 'objects');

    $post_types_shown = preload_lcp_get_lcp_post_types();

    if ($post_types) {

        foreach ($post_types as $post_type) {

            if (in_array($post_type->name, $post_types_shown)) {
                $checkedval = "checked";
            } else {
                $checkedval = "";
            }
?>
            <input type='checkbox' name='preload_lcp_image_settings[preload_lcp_post_type_settings][]' value='<?php echo esc_attr($post_type->name); ?>' <?php echo esc_attr($checkedval); ?>><?php echo esc_attr($post_type->label); ?><br />
    <?php
        }
    }
    ?>
    <p class="description"><?php _e('Show the Preload LCP Image metabox on the chosen post type(s)', 'preload_lcp'); ?></p>
    <?php
}


/**
 * Render the post type settings option
 * 
 * @return void
 */
function preload_lcp_taxonomy_settings_render()
{

    $taxonomies       = get_taxonomies(array('public' => true), 'objects');

    $taxonomies_to_show = preload_lcp_get_lcp_taxonomies();

    if ($taxonomies) {

        foreach ($taxonomies as $taxonomy) {

            if (in_array($taxonomy->name, $taxonomies_to_show)) {
                $checkedval = "checked";
            } else {
                $checkedval = "";
            }
    ?>
            <input type='checkbox' name='preload_lcp_image_settings[preload_lcp_taxonomy_settings][]' value='<?php echo esc_attr($taxonomy->name); ?>' <?php echo esc_attr($checkedval); ?>><?php echo esc_attr($taxonomy->label); ?><br />
    <?php
        }
    }
    ?>
    <p class="description"><?php _e('Show the Preload LCP Image metabox on the chosen taxonomies', 'preload_lcp'); ?></p>
<?php
}


/**
 * Options render to show the featured image if not present
 *
 * @return void
 */
function preload_lcp_default_to_featured_image_render()
{

    $show_default = preload_lcp_get_option('preload_lcp_default_to_featured_image');

?>
    <input type='checkbox' name='preload_lcp_image_settings[preload_lcp_default_to_featured_image]' value='show_featured_image' <?php checked($show_default, 'show_featured_image', true) ?>>
    <p class="description"><?php _e('Preload the featured image of the page or post as the LCP image if no other image is specified', 'preload-lcp-image'); ?></p>
<?php
}

/**
 * Create and add the Preload LCP Options Page
 * 
 * @return void
 */
function preload_lcp_image_options_page()
{

    $current_user = wp_get_current_user();

?>
    <div class="dr_admin_wrap">
        <h1><?php _e('Preload LCP Image Options', 'preload_lcp_image'); ?></h1>

        <div class="dr_admin_main_wrap">
            <div class="dr_admin_wrap_left">

                <form method="post" action="options.php" id="options">

                    <?php

                    settings_fields('preload_LCP_Image');
                    do_settings_sections('preload_LCP_Image');
                    submit_button();

                    ?>

                </form>
            </div>
            <div class="dr_admin_wrap_right">
                <div class="dr_box dr_box_highlighted">
                    <h2><?php _e('Is Your WordPress Site Slow?', 'preload_lcp'); ?></h2>
                    <p><img src="https://gravatar.com/avatar/13b432f781f24140731c6fe815e6d831?s=70&d=mm" alt="<?php _e('Rhys Wynne', 'preload_cp'); ?>" class="dr_avatar" />
                        <?php _e("Hello! Dwi'n Rhys (I am Rhys in Welsh), and I am an experienced WordPress developer from the United Kingdom, specialising in WordPress perfomance automation, as well as API integration, maintenance and custom code projects. Let's talk and see what I can do for you!", "preload_lcp"); ?>
                    </p>
                    <p><a href="https://dwinrhys.com/wordpress-speed-optimisation/?utm_source=plugin-options&utm_medium=wordpress&utm_campaign=preload-lcp-image" target="_blank" class="dr_button dr_button_primary"><?php _e("Get your site optimised!", "preload_lcp"); ?></a></p>
                </div>

                <div class="dr_box">
                    <?php dwinrhys_print_newsletter_box( 'preload_lcp' ); ?>
                </div>
            </div>
        </div>
    </div>

<?php

}
