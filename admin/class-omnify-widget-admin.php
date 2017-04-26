<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.getomnify.com/about-us/
 * @since      1.0.0
 *
 * @package    Omnify_Widget
 * @subpackage Omnify_Widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Omnify_Widget
 * @subpackage Omnify_Widget/admin
 * @author     Omnify Team <tech@getomnify.com>
 */
class Omnify_Widget_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Omnify_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Omnify_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_style( $this->plugin_name . '-bootstrap', plugin_dir_url( __FILE__ ) . 'css/omnify-widget-bootstrap.css', array(), $this->version, 'all' );
        
        wp_enqueue_style( $this->plugin_name . '-bootstrap-select', plugin_dir_url( __FILE__ ) . 'css/omnify-widget-bootstrap-select.css', array(), $this->version, 'all' );
        
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/omnify-widget-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Omnify_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Omnify_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
         */

        wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/omnify-widget-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
        
        wp_enqueue_script( $this->plugin_name . '-bootstrap', plugin_dir_url( __FILE__ ) . 'js/omnify-widget-bootstrap.js', array( 'jquery' ), $this->version, false );
        
        wp_enqueue_script( $this->plugin_name . '-bootstrap-select', plugin_dir_url( __FILE__ ) . 'js/omnify-widget-bootstrap-select.js', array( $this->plugin_name . '-bootstrap' ), $this->version, false );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 */
		add_options_page( 'Omnify Widget Setup', 'Omnify Widget', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
    public function add_action_links( $links ) {

	   $settings_link = array(
           '<a href="' . admin_url(
               'options-general.php?page=' . $this->plugin_name
           ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
       
       return array_merge( $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {
		include_once( 'partials/omnify-widget-admin-display.php' );
	}

	/**
	 * Validate the token received as input
	 *
	 * @since    1.0.0
	 */
    public function validate_token($token) {
        if(isset($token) && !empty($token) && strlen($token) == 20) {
            return $token;
        } else {
            die("<h2>Invalid Token!</h2>");
        }
    }


    /**
     *
     * Update the token option
     *
	 * @since    1.0.0
     **/
     public function options_update() {
         register_setting($this->plugin_name, "token" , array($this, 'validate_token'));
     }

}
