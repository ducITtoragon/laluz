<?php

/**
 * Plugin Name:Mona Filter login
 * Plugin URI: https://mona-media.com
 * Description: This plugin provides features and integrations specifically for Vietnam.
 * Author: monamedia
 * Author URI: https://mona-media.com
 * Text Domain: monamedia
 * Domain Path: monamedia
 * Version: 1.3.1
 * Lic
 **/
if (!defined('ABSPATH')) {
    exit;
}

define('MONA_FILTER_PATCH', plugin_dir_path(__FILE__));
define('MONA_FILTER_URL', plugins_url('/', __FILE__));
define('MONA_FORGOT_PASS', 194);
define('MONA_LOGIN', 192);
define('MONA_REGISTER', 167);
add_filter('lostpassword_url', 'lostpassword_url', 99999999, 1);

function lostpassword_url($url)
{

    return get_the_permalink(MONA_FORGOT_PASS);
}

include(MONA_FILTER_PATCH . '/includes/functions.php');
include(MONA_FILTER_PATCH . '/includes/filter_content.php');
include(MONA_FILTER_PATCH . '/includes/ajax.php');

class Mona_filter_init
{

    private static $instance;

    const VERSION = '1.0.1';

    static $default_settings = array();

    public static function get_instance()
    {

        if (null == self::$instance) {
            self::$instance = new Mona_filter_init();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->i18n();

        $this->main();
    }

    public function load_script()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_style('mona-magnific-ex-front', MONA_FILTER_URL . 'js/Magnific-Popup-master/magnific-popup.css');
        wp_enqueue_style('mona-awesome', MONA_FILTER_URL . 'js/font-awesome-4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('mona-dpicker', MONA_FILTER_URL . 'js/Date-picker/datepicker.min.css');
        wp_enqueue_style('mona--filter-ex-front-css', MONA_FILTER_URL . 'css/style.css');
        wp_enqueue_script('mona-Date-picker-ex-front', MONA_FILTER_URL . 'js/Date-picker/datepicker.min.js', array(), false, true);
        wp_enqueue_script('mona-Magnific-ex-front', MONA_FILTER_URL . 'js/Magnific-Popup-master/jquery.magnific-popup.min.js', array(), false, true);
        wp_enqueue_script('mona--filter-ex-front', MONA_FILTER_URL . 'js/front.js', array(), false, true);
        wp_localize_script('mona--filter-ex-front', 'mona_filter_ajax_url', array('ajaxURL' => admin_url('admin-ajax.php'), 'siteURL' => get_site_url()));
    }

    public function admin_script()
    {
        wp_enqueue_style('mona-filter-ex-admin', MONA_FILTER_URL . 'css/admin.css');
    }

    public function i18n()
    {
        load_plugin_textdomain('monamedia', false, basename(dirname(__FILE__)) . '/languages/');
    }

    /**
     * The main method to load the components
     */
    public function main()
    {
        add_action('wp_enqueue_scripts', array($this, 'load_script'));
        add_action('admin_enqueue_scripts', array($this, 'admin_script'));
        add_filter("theme_page_templates", [$this, 'mona_filter_template_loader'], 9999, 4);
        add_filter('template_include', array($this, 'include_page_template'), 99);

        $settings = self::get_settings();
    }

    static function get_settings()
    {
        return self::$default_settings;
    }

    function include_page_template($template)
    {
        if (is_singular()) {
            $plugin_path = MONA_FILTER_PATCH . 'template/';
            $meta = get_post_meta(get_the_ID(), '_wp_page_template', true);
            $pluginfile = $plugin_path . $meta;
            if (file_exists($pluginfile) && $meta != '') {
                $template = $pluginfile;
            }
        }

        return $template;
    }

    function mona_filter_template_loader($page_templates, $obz, $post, $post_type)
    {
        $page_templates['lost-pass.php'] = 'Lost password';
        $page_templates['login-template.php'] = 'Login Page';
        $page_templates['register-template.php'] = 'Register Page';
        return $page_templates;
    }
}

add_action('plugins_loaded', array('Mona_filter_init', 'get_instance'), 0);
