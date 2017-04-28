<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.getomnify.com/about-us/
 * @since      1.0.0
 *
 * @package    Omnify_Widget
 * @subpackage Omnify_Widget/admin/partials
 */
?>

<?php 

// include only if the setup is not complete
$token = get_option('token');
if(!$token) {
    include_once( 'omnify-widget-setup-token.php' );
} else {
    include_once( 'omnify-widget-home.php' );
    include_once( 'omnify-widget-shortcodes-data.php' );
}

?>
