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
    $image_path  = wp_get_original_image_path($image_id);

    $image_size  = wp_getimagesize($image_path);
    if (empty($image_size)) {
        return false;
    }
    $image_type  = preload_lcp_get_image_type_from_url($image_url, $image_id);
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
 * @param  string $image_url The Image URL
 * @param  integer $image_id  The Image ID (optional)
 * @return void
 */
function preload_lcp_get_image_type_from_url($image_url, $image_id = false )
{
    if ( $image_id ) {
        $image_path = wp_get_original_image_path( $image_id );
        $mime        = wp_get_image_mime($image_path);
    } else {
        $mime        = wp_get_image_mime($image_url);
    }
    $image_array = explode("/", $mime);
    $image_type  = false;

    if (is_array($image_array)) {

        if (sizeof($image_array) > 1 ) {
            $image_type = $image_array[1];
        }
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
 * Get the Taxonomiess to show the LCP Image metabox on
 * 
 * Used in case not set to show the default box
 *
 * @return array
 */
function preload_lcp_get_lcp_taxonomies()
{

    $options    = get_option('preload_lcp_image_settings');

    if (!is_array($options)) {
        $taxonomies_shown = array('categories', 'post_tag');
    } else {
        if (!array_key_exists('preload_lcp_taxonomy_settings', $options)) {
            $taxonomies_shown = array('categories', 'post_tag');
        } else {
            $taxonomies_shown = $options['preload_lcp_taxonomy_settings'];
        }
    }

    return $taxonomies_shown;
}

/**
 * Wrapper function to get one option field
 *
 * @param  string $option_field  The option to return
 * @return mixed                 The option we've returned, or false
 */
function preload_lcp_get_option($option_field)
{
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
function preload_lcp_image_build_tag($lcp_url, $astype = false, $mime = false, $srcset = false)
{

    $tag  = '<!-- Preload LCP Element - WordPress Plugin -->';
    $tag .= '<link rel="preload" fetchpriority="high" ';

    if ($astype) {
        $tag .= ' as="' . esc_attr($astype) . '" ';
    }

    $tag .= ' href="' . esc_attr($lcp_url) . '" ';

    if ($mime) {
        $tag .= ' type="' . esc_attr($mime) . '" ';
    }
    if ($srcset) {
        $tag .= ' imagesrcset="' . esc_attr($srcset) . '" ';
    }

    $tag .= '><!-- / Preload LCP Element - WordPress Plugin -->';

    return $tag;
}


/**
 * Function to build the Newsletter box
 * 
 * Here so it isn't in the way. Also allows more than one of my plugins to be loaded on the same blog without any issues.
 */
if (!function_exists('dwinrhys_print_newsletter_box')) {
    function dwinrhys_print_newsletter_box($textdomain = 'dwinrhys')
    {
?>
        <div id="mlb2-21162946" class="ml-form-embedContainer ml-subscribe-form ml-subscribe-form-21162946">
            <div class="ml-form-align-center ">
                <div class="ml-form-embedWrapper embedForm">
                    <div class="ml-form-embedBody ml-form-embedBodyDefault row-form">

                        <div class="ml-form-embedContent" style=" ">

                            <h2><?php _e('Get Notified for Updates', $textdomain); ?></h2>
                            <p><?php _e('Sign up below to receive updates to this plugin, as well as a monthly newsletter on SEO and WordPress news. Subscription is free and you can unsubscribe at any time.', $textdomain); ?></p>

                        </div>

                        <form class="ml-block-form" action="https://assets.mailerlite.com/jsonp/609353/forms/142144868274144703/subscribe" data-code="" method="post" target="_blank">
                            <div class="ml-form-formContent">



                                <div class="ml-form-fieldRow ">
                                    <div class="ml-field-group ml-field-name">




                                        <!-- input -->
                                        <input aria-label="name" type="text" class="form-control" data-inputmask="" name="fields[name]" placeholder="Name" autocomplete="given-name">
                                        <!-- /input -->

                                        <!-- textarea -->

                                        <!-- /textarea -->

                                        <!-- select -->

                                        <!-- /select -->

                                        <!-- checkboxes -->

                                        <!-- /checkboxes -->

                                        <!-- radio -->

                                        <!-- /radio -->

                                        <!-- countries -->

                                        <!-- /countries -->





                                    </div>
                                </div>
                                <div class="ml-form-fieldRow ml-last-item">
                                    <div class="ml-field-group ml-field-email ml-validate-email ml-validate-required">




                                        <!-- input -->
                                        <input aria-label="email" aria-required="true" type="email" class="form-control" data-inputmask="" name="fields[email]" placeholder="Email" autocomplete="email">
                                        <!-- /input -->

                                        <!-- textarea -->

                                        <!-- /textarea -->

                                        <!-- select -->

                                        <!-- /select -->

                                        <!-- checkboxes -->

                                        <!-- /checkboxes -->

                                        <!-- radio -->

                                        <!-- /radio -->

                                        <!-- countries -->

                                        <!-- /countries -->





                                    </div>
                                </div>

                            </div>



                            <!-- Privacy policy -->

                            <!-- /Privacy policy -->

                            <input type="hidden" name="ml-submit" value="1">

                            <div class="ml-form-embedSubmit">

                                <button type="submit" class="primary dr_button dr_button_primary"><?php _e('Subscribe', $textdomain); ?></button>

                                <button disabled="disabled" style="display: none;" type="button dr_button dr_button_disabled" class="loading">
                                    <div class="ml-form-embedSubmitLoad"></div>
                                    <span class="sr-only"><?php _e('Loading...', $textdomain); ?></span>
                                </button>
                            </div>


                            <input type="hidden" name="anticsrf" value="true">
                        </form>
                    </div>

                    <div class="ml-form-successBody row-success" style="display: none">

                        <div class="ml-form-successContent">

                            <h2><?php _e('Thank you!', $textdomain); ?></h2>

                            <p><?php _e('Thank you for your interest! To confirm, I have sent an email to you. Please click on that to subscribe!', $textdomain); ?></p>


                        </div>

                    </div>
                </div>
            </div>
        </div>





        <script>
            function ml_webform_success_21162946() {
                var $ = ml_jQuery || jQuery;
                $('.ml-subscribe-form-21162946 .row-success').show();
                $('.ml-subscribe-form-21162946 .row-form').hide();
            }
        </script>


        <script src="https://groot.mailerlite.com/js/w/webforms.min.js?v176e10baa5e7ed80d35ae235be3d5024" type="text/javascript"></script>
        <script>
            fetch("https://assets.mailerlite.com/jsonp/609353/forms/142144868274144703/takel")
        </script>
<?php
    }
}
