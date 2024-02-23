<?php
class Mona_Custom_ACF_Product_Variation
{

    /**
     * Undocumented function
     */
    public function __construct()
    {

        add_filter('acf/location/rule_values/post_type', [$this, 'acf_location_rule_values_Post']);
        add_action('woocommerce_product_after_variable_attributes', [$this, 'acf_product_after_variable_attributes'], 10, 3);
        add_action('woocommerce_save_product_variation', [$this, 'acf_save_product_variation'], 10, 2);
        add_action('admin_enqueue_scripts', [$this, 'add_support_javascript_loader']);
    }

    /**
     * Undocumented function
     *
     * @param [type] $choices
     * @return void
     */
    public function acf_location_rule_values_Post($choices)
    {

        $choices['product_variation'] = __('Gallery Product', 'mona-admin');
        return $choices;
    }

    /**
     * Undocumented function
     *
     * @param [type] $loop
     * @param [type] $variation_data
     * @param [type] $variation_post
     * @return void
     */
    public function acf_product_after_variable_attributes($loop_index, $variation_data, $variation_post)
    {

        global $abcdefgh_i;
        $abcdefgh_i = $loop_index;

        add_filter('acf/prepare_field', [$this, 'acf_prepare_field_update_field_name']);

        $acf_field_groups = acf_get_field_groups();
        foreach ($acf_field_groups as $acf_field_group) {
            foreach ($acf_field_group['location'] as $group_locations) {
                foreach ($group_locations as $rule) {
                    if ($rule['param'] == 'post_type' && $rule['operator'] == '==' && $rule['value'] == 'product_variation') {
                        acf_render_fields($variation_post->ID, acf_get_fields($acf_field_group));
                        break 2;
                    }
                }
            }
        }

        remove_filter('acf/prepare_field', [$this, 'acf_prepare_field_update_field_name']);
    }

    /**
     * Undocumented function
     *
     * @param [type] $field
     * @return void
     */
    public function acf_prepare_field_update_field_name($field)
    {

        global $abcdefgh_i;
        $field['name'] = preg_replace('/^acf\[/', "acf_variation[$abcdefgh_i][", $field['name']);
        return $field;
    }

    /**
     * Undocumented function
     *
     * @param [type] $variation_id
     * @param integer $i
     * @return void
     */
    public function acf_save_product_variation($variation_id, $i = -1)
    {

        if (!empty($_POST['acf_variation']) && is_array($_POST['acf_variation']) && array_key_exists($i, $_POST['acf_variation']) && is_array(($fields = $_POST['acf_variation'][$i]))) {
            foreach ($fields as $key => $val) {
                update_field($key, $val, $variation_id);
            }
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function add_support_javascript_loader()
    {

        wp_enqueue_media();
        wp_enqueue_script('product-variation-support-loader', get_template_directory_uri() . '/app/modules/products/js/product-variation-acf.js', array(), false, true);
    }
}

if (class_exists('Mona_Custom_ACF_Product_Variation')) {
    new Mona_Custom_ACF_Product_Variation();
}
