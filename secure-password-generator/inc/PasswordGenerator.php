<?php

namespace AG\PasswordGenerator;

use AG\PasswordGenerator\Password\GetPassword as GetPassword;

use AG\PasswordGenerator\Input\FormInput as FormInput;

use AG\PasswordGenerator\Widget\PasswordGeneratorWidget as PasswordGeneratorWidget;

defined('ABSPATH') or die();

/**
 * Class made to generate cryptographically safe passwords
 * Author: András Gulácsi 2020
 */

final class PasswordGenerator
{
    private const TEXT_DOMAIN = 'ag-secure-psswrd-gen';


    // class instance
    private static $instance;


    /**
     * Get class instance, if not exists -> instantiate it
     * @return self $instance
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self(
                
            );
        }
        return self::$instance;
    }


    // CONSTRUCTOR ------------------------------
    // initialize properties, some defaults added
    private function __construct()
    {
        // self::$settings = $settings;

        add_action('plugins_loaded', array($this, 'loadTextdomain'));

        // add_filter('admin_init', array(self::$settings, 'createSettings'));

        // add admin menu and page
        // add_action('admin_menu', array($this, 'addAdminMenu'));

        // put the css into head (only admin page)
        // add_action('admin_head', array($this, 'addCSS'));
        // add script on the backend
        // add_action('admin_enqueue_scripts', array($this, 'adminLoadScripts'));

        // put the css before end of </body>
        add_action('wp_enqueue_scripts', array($this, 'addCSS'));

        // add ajax script
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('ag-secure-password-generator', plugins_url('js/agPasswordGenerator.js', dirname(__FILE__, 1)) , array('jquery'));

            // enable ajax on frontend
            wp_localize_script('ag-secure-password-generator', 'AGPasswordGeneratorAjax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'security' => wp_create_nonce('agPasswordGeneratorajax-vxe4bn6x68')
            ));
        });

        // connect AJAX request with PHP hooks
        add_action('wp_ajax_ag_generate_password_ajax_action', array($this, 'agPasswordGeneratorAJAXHandler'));
        add_action('wp_ajax_nopriv_ag_generate_password_ajax_action', array($this, 'agPasswordGeneratorAJAXHandler'));


        // hook for our widget implementation
        add_action('widgets_init', array($this, 'register_widgets'));
    }


    // DESCTRUCTOR -------------------------------
    public function __destruct()
    {
    }

    // getter
    public function __get($property)
    {
        // get private property
    }

    // setter
    public function __set($property, $value)
    {
        // set private property
    }


    // METHODS
    public static function loadTextdomain(): void
    {
        // modified slightly from https://gist.github.com/grappler/7060277#file-plugin-name-php

        $domain = self::TEXT_DOMAIN;
        $locale = apply_filters('plugin_locale', get_locale(), $domain);

        load_textdomain($domain, trailingslashit(\WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo');
        load_plugin_textdomain($domain, false, basename(dirname(__FILE__, 2)) . '/languages/');
    }

    /**
     * Register admin menu page and submenu page
     * @return void
     */
    // public function addAdminMenu(): void
    // {
    //     add_menu_page(
    //         __('Weather Now Admin'), // page title
    //         __('Current Weather in your City'), // menu title
    //         'manage_options', // capability
    //         'weather_now_settings', // menu slug
    //         array(self::$settings, 'settingsForm'), // callback
    //         'dashicons-cloud' // icon
    //     );
    // }


    /**
     * Add some styling to the plugin's admin and shortcode UI
     * @return void
     */
    public function addCSS(): void
    {
        wp_enqueue_style(
            'ag_secure_password_generator_css',
            plugins_url('css/password-generator.css', dirname(__FILE__, 1) )
        );
    }

    // public function adminLoadScripts($hook)
    // {
    //     if ($hook != 'toplevel_page_weather_now_settings') {
    //         return;
    //     }

    //     wp_enqueue_style(
    //         'ag_weather_now_admin_css',
    //         plugins_url() . '/weather-now/css/weather-now.css'
    //     );
    // }


    /**
     * Add add an option with the version when activated
     */
    public static function activatePlugin(): void
    {
       //
    }


    // This code will only run when plugin is deleted
    // it will drop the custom database table, delete wp_option record (if exists)
    public static function uninstallPlugin()
    {
        //
    }


    /**
     * Register the new widget.
     *
     * @see 'widgets_init'
     */
    public function register_widgets()
    {
        register_widget('\AG\PasswordGenerator\Widget\PasswordGeneratorWidget');
    }



    public function agPasswordGeneratorAJAXHandler()
    {
        if (check_ajax_referer('agPasswordGeneratorajax-vxe4bn6x68', 'security')) {
            
            $input = new FormInput();
            $pwd = new GetPassword();

            $args = $input->validateInput();

            // if exception is thrown, send back error msg
            if($args['error'] ?? 0) {
                wp_send_json_error($args['error']);
            }

            $output = $pwd->generatePassword($args);

            wp_send_json_success($output, 200);
        } else {
            wp_send_json_error();
        }
        wp_die();
    }
}
