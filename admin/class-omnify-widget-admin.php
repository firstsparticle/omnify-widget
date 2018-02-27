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
class Omnify_Widget_Admin
{
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
     * Api url
     *
     * @since    2.0.0
     * @access   protected
     * @var      string    $api_url.
     */
    protected $api_url;

    private $api;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     * @param      string    $api_url
     */
    public function __construct($plugin_name, $version, $api_url)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->api_url = $api_url;
        $this->api = new Omnify_Widget_Api($api_url);
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook)
    {

        /**
         * An instance of this class should be passed to the run() function
         * defined in Omnify_Widget_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Omnify_Widget_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        // load only if it is the settings page to avoid css conflicts
        if ($hook == 'settings_page_omnify-widget') {
            wp_enqueue_style($this->plugin_name . '-bootstrap', plugin_dir_url(__FILE__) . 'css/omnify-widget-bootstrap.css', array(), $this->version, 'all');
            
            wp_enqueue_style($this->plugin_name . '-bootstrap-select', plugin_dir_url(__FILE__) . 'css/omnify-widget-bootstrap-select.css', array(), $this->version, 'all');
            
            wp_enqueue_style($this->plugin_name . '-hint', plugin_dir_url(__FILE__) . 'css/omnify-widget-hint.css', array(), $this->version, 'all');
            
            wp_enqueue_style($this->plugin_name . '-css', plugin_dir_url(__FILE__) . 'css/omnify-widget-admin.css', array(), $this->version, 'all');

            wp_enqueue_style($this->plugin_name . '-font', 'http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic%7CGreat+Vibes:400%7CLato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic%7CInconsolata:400,700', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook)
    {

        /**
         * An instance of this class should be passed to the run() function
         * defined in Omnify_Widget_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Omnify_Widget_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('iris');

        // load only if it is the settings page to avoid js conflicts
        if ($hook == 'settings_page_omnify-widget') {
            wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css');
            wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'));

            wp_enqueue_script($this->plugin_name . '-js', plugins_url('js/omnify-widget-admin.js', __FILE__), array( 'jquery', 'iris' ), $this->version, false);
            
            wp_enqueue_script($this->plugin_name . '-bootstrap', plugins_url('js/omnify-widget-bootstrap.js', __FILE__), array( 'jquery' ), $this->version, false);
            
            wp_enqueue_script($this->plugin_name . '-clipboard', plugins_url('js/omnify-widget-clipboard.js', __FILE__), array( 'jquery' ), $this->version, false);
            
            wp_enqueue_script($this->plugin_name . '-bootstrap-select', plugins_url('js/omnify-widget-bootstrap-select.js', __FILE__), array( $this->plugin_name . '-bootstrap' ), $this->version, false);

            wp_localize_script(
                $this->plugin_name . '-js',
                'ajax_object',
                array( 'ajax_url' => admin_url('admin-ajax.php') )
            );
        }
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu()
    {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         */
        add_options_page(
            'Omnify Widget Setup',
            'Omnify Widget',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links($links)
    {
        $settings_link = array(
           '<a href="' . admin_url(
               'options-general.php?page=' . $this->plugin_name
           ) . '">' . __('Settings', $this->plugin_name) . '</a>',
       );
       
        return array_merge($settings_link, $links);
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page()
    {
        include_once('partials/omnify-widget-index.php');
    }

    /**
     * Create a custom post type for Omnify Widgets
     *
     * @since    1.0.0
     */
    public function omnify_widget_custom_post_type()
    {
        $args = array(
            'public' => false,
            'label' => 'Omnify Widget',
            'description' => 'Holds shortcode data generated by Omnify Widget',
        );

        register_post_type('omnify_widget', $args);
    }

    /**
     * Validate the token received as input
     *
     * @since    1.0.0
     */
    public function validate_token($token)
    {
        if (isset($token) && !empty($token) && (strlen($token) == 20 || strlen($token) == 40)) {
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
    public function options_update()
    {
        register_setting($this->plugin_name, "token", array($this, 'validate_token'));
        register_setting($this->plugin_name, "business", array($this));
    }

    /**
     *
     * Handle AJAX requests for iframe generator
     *
     * @since   1.0.0
     **/
    public function omnify_widget_ah_gen_iframe()
    {
        $data = $_POST['iframe-data'];
        $width = $_POST['iframe-width'];
        $name = $_POST['iframe-name'];
        $page = $_POST['iframe-page'];
        $team = $_POST['iframe-team'];
        $services = $_POST['iframe-services'];
        $this->api->create_widget($data, $page, $width, $name, 'iframe', $team, $services);
        $_COOKIE['omnify_msg_success'] = 'The iframe widget bas been generated!';
        echo 'success';
        wp_die();
    }
    /**
     *
     * Handle AJAX requests for update iframe widget
     *
     * @since   2.0.0
     **/
    public function omnify_widget_ah_update_iframe()
    {
        $id = $_POST['iframe-id'];
        $data = $_POST['iframe-data'];
        $width = $_POST['iframe-width'];
        $name = $_POST['iframe-name'];
        $page = $_POST['iframe-page'];
        $team = $_POST['iframe-team'];
        $services = $_POST['iframe-services'];
        $this->api->update_widget($data, $id, $page, $width, $name, 'iframe', $team, $services);
        echo 'success';
        wp_die();
    }

    /**
     *
     * Handle AJAX requests for sync widgets
     *
     * @since   1.0.0
     **/
    public function omnify_widget_sync()
    {
        $query = new WP_Query("post_type=omnify_widget&meta_key=omnify_key&order=ASC");
        $posts = $query->posts;
        $keys = array_column($_POST['data'], 'key');
        foreach ($posts as $post) {
            if (!in_array(get_post_meta($post->ID, 'omnify_key', true), $keys)) {
                wp_delete_post($post->ID, true);
                echo 'refresh';
            }
        }
        foreach ($_POST['data'] as $widget) {
            if ($widget['type'] == 'button') {
                continue;
            }
            $widgetKey = $widget['key'];
            $widgetId = $widget['id'];
            $query = new WP_Query("post_type=omnify_widget&meta_key=omnify_key&meta_value=$widgetKey&order=ASC");
            if ($query->have_posts() == false) {
                $this->omnify_widget_create_widget('IFRAME', $widget['html_code'], 'IFRAME', $widget['name'], $widgetKey, $widgetId);
            } else {
                $post = $query->posts[0];
                $currentTitle = get_post_meta($post->ID, 'widget-title', true);
                if ($currentTitle != $widget['name']) {
                    update_post_meta($post->ID, 'widget-title', $widget['name']);
                    echo 'refresh';
                }
            }
        }
        wp_die();
    }

    /**
     *
     * Handle AJAX requests for button generator
     *
     * @since   1.0.0
     **/
    public function omnify_widget_ah_gen_button()
    {
        $data = $_POST['button'];
        $code = $data['code'];
        $title = $data['text'];
        $action = $data['action'];
        $extra = [];
        $extra['name'] = $title;
        $extra['service-category'] = $data['service-category'];
        $extra['service'] = $data['service'];
        $extra['text-color'] = $data['text-color'];
        $extra['button-color'] = $data['button-color'];
        $this->omnify_widget_create_widget('BUTTON', $code, $action, $title, null, null, $extra);
        wp_die();
    }

    /**
     *
     * Handle AJAX requests for button generator
     *
     * @since   2.0.0
     **/
    public function omnify_widget_ah_update_button()
    {
        $data = $_POST['button'];
        $code = $data['code'];
        $post_id = $data['postId'];
        $title = $data['text'];
        $action = $data['action'];
        $extra = [];
        $extra['name'] = $title;
        $extra['service-category'] = $data['service-category'];
        $extra['service'] = $data['service'];
        $extra['text-color'] = $data['text-color'];
        $extra['button-color'] = $data['button-color'];
        $this->omnify_widget_update_button($code, $action, $title, $extra, $post_id);
        wp_die();
    }

    /**
    *
    * Handle AJAX requests for deleting shortcode
    *
    * @since   1.0.0
    **/
    public function omnify_widget_ah_del_sc()
    {
        $post_id = $_POST['post_id'];
        if (wp_delete_post($post_id, true)) {
            $this->api->delete_widget($_POST['widget_id']);
            echo "success";
        }
        wp_die();
    }

    /**
    *
    * Handle AJAX requests for reset auth token
    *
    * @since   1.0.0
    **/
    public function omnify_widget_ah_reset_token()
    {
        if (delete_option('token')) {
            delete_option('business');
            delete_option('subdomain');
            echo "success";
        }
        wp_die();
    }


    /**
     *
     * Register shortcodes for all the widgets
     *
     * @since   1.0.0
     **/
    public function omnify_widget_register_shortcodes()
    {
        
        /**
         *
         * Register shortcodes for all the widgets
         *
         * @since   1.0.0
         **/

        function omnify_widget_handle_shortcodes($atts)
        {
            $post_id = $atts['id'];
            return get_post_field('post_content', $post_id);
        }

        add_shortcode('omnify_widget', 'omnify_widget_handle_shortcodes');
    }

    /**
     *
     * Create and populate widget to database
     *
     * @since   1.0.0
     * @param $widget_type
     * @param $code
     * @param string $action
     * @param string $title
     * @param null $widgetKey
     * @param null $widgetId
     * @param array $extra
     */
    private function omnify_widget_create_widget($widget_type, $code, $action = 'IFRAME', $title = '', $widgetKey = null, $widgetId = null, $extra = [])
    {
        if (!isset($widget_type) && !isset($code) && !isset($action)) {
            echo "Invalid post data";
            wp_die();
        }

        $post = array(
            'post_title'        => $widget_type,
            'post_content'      => $code,
            'post_status'       => 'publish',
            'post_type'         => 'omnify_widget',
            'post_excerpt'      => $action,
            'comment_status'    => 'closed',
        );

        $post_id = wp_insert_post($post, true);

        $post['ID'] = $post_id;
        $post['post_content'] = preg_replace('/<post_id>/', $post_id, $code);

        echo $post['post_content'];
        wp_update_post($post, true);

        $key = "shortcode";
        $value = '[omnify_widget id="' . $post_id . '"]';

        add_post_meta($post_id, $key, $value, true);

        $key = "widget-title";
        $value = $title;

        add_post_meta($post_id, $key, $value, true);
        if ($widgetKey) {
            $key = "omnify_key";
            $value = $widgetKey;

            add_post_meta($post_id, $key, $value, true);
        }
        if ($widgetId) {
            $key = "omnify_id";
            $value = $widgetId;
            add_post_meta($post_id, $key, $value, true);
        }
        if (count($extra) > 0) {
            foreach ($extra as $key => $value) {
                add_post_meta($post_id, $key, $value, true);
            }
        }

        echo $post_id;
    }

    /**
     *
     * @since   2.0.0
     * @param $code
     * @param string $action
     * @param string $title
     * @param array $extra
     * @param $post_id
     */
    private function omnify_widget_update_button($code, $action = 'IFRAME', $title = '', $extra = [], $post_id)
    {
        if (!isset($code) && !isset($action)) {
            echo "Invalid post data";
            wp_die();
        }

        $post = array(
            'ID'        => $post_id,
            'post_title'        => 'BUTTON',
            'post_content'      => $code,
            'post_status'       => 'publish',
            'post_type'         => 'omnify_widget',
            'post_excerpt'      => $action,
            'comment_status'    => 'closed',
        );

        wp_update_post($post, true);

        $post['ID'] = $post_id;
        $post['post_content'] = preg_replace('/<post_id>/', $post_id, $code);

        echo $post['post_content'];
        wp_update_post($post, true);

        $key = "widget-title";
        $value = $title;

        update_post_meta($post_id, $key, $value);

        if (count($extra) > 0) {
            foreach ($extra as $key => $value) {
                update_post_meta($post_id, $key, $value);
            }
        }

        echo $post_id;
    }

    /**
     * Retrieve the api url
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_api()
    {
        return $this->api_url;
    }
}
