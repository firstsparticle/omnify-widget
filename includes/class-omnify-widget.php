<?php

/**
 * The file that defines the core plugin class
 *
 * @link       https://www.getomnify.com/about-us/
 * @since      1.0.0
 *
 * @package    Omnify_Widget
 * @subpackage Omnify_Widget/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks
 * the and site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Omnify_Widget
 * @subpackage Omnify_Widget/includes
 * @author     Omnify Team <tech@getomnify.com>
 */
class Omnify_Widget
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Omnify_Widget_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * The current version of the plugin.
     *
     * @since    2.0.0
     * @access   protected
     * @var      string    $api_url
     */
    protected $api_url;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->plugin_name = 'omnify-widget';
        $this->version = '2.0.0';
        $this->api_url = 'https://app.getomnify.com';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Omnify_Widget_Loader. Orchestrates the hooks of the plugin.
     * - Omnify_Widget_i18n. Defines internationalization functionality.
     * - Omnify_Widget_Admin. Defines all hooks for the admin area.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-omnify-widget-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-omnify-widget-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-omnify-widget-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-omnify-widget-api.php';

        $this->loader = new Omnify_Widget_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Omnify_Widget_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Omnify_Widget_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Omnify_Widget_Admin($this->get_plugin_name(), $this->get_version(), $this->get_api());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
        $this->loader->add_action('init', $plugin_admin, 'omnify_widget_custom_post_type');

        $this->loader->add_action('wp_ajax_gen_iframe', $plugin_admin, 'omnify_widget_ah_gen_iframe');
        $this->loader->add_action('wp_ajax_update_iframe', $plugin_admin, 'omnify_widget_ah_update_iframe');
        $this->loader->add_action('wp_ajax_sync', $plugin_admin, 'omnify_widget_sync');
        $this->loader->add_action('wp_ajax_gen_button', $plugin_admin, 'omnify_widget_ah_gen_button');
        $this->loader->add_action('wp_ajax_update_button', $plugin_admin, 'omnify_widget_ah_update_button');
        $this->loader->add_action('wp_ajax_delete_shortcode', $plugin_admin, 'omnify_widget_ah_del_sc');
        $this->loader->add_action('wp_ajax_reset_token', $plugin_admin, 'omnify_widget_ah_reset_token');

        // Add shortcodes
        $this->loader->add_action('init', $plugin_admin, 'omnify_widget_register_shortcodes');

        // Add Settings link to the plugin
        $plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->plugin_name . '.php');
        $this->loader->add_filter('plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links');

        // Save/Update our plugin options
        $this->loader->add_action('admin_init', $plugin_admin, 'options_update');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Omnify_Widget_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * @since     1.0.0
     * @return    string
     */
    public function get_api()
    {
        return $this->api_url;
    }
}
