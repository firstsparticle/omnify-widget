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

// include only if the setup is not complete
$token = get_option('token');
$business = get_option('business');

if(!$token) {
    include_once( 'omnify-widget-setup-token.php' );
} else if(!$business){
    include_once( 'omnify-widget-setup-business.php' );
} else {
    if (isset($_GET['step']) && $_GET['step'] == 'create-iframe') {
        $staff = $this->api->get_staff(true);
        include_once( 'omnify-widget-create-iframe.php' );
    } else if (isset($_GET['step']) && $_GET['step'] == 'update-iframe' && isset($_GET['widget'])) {
        $widget = $this->api->get_widget(get_post_meta($_GET['widget'], 'omnify_id', true), true);
        $staff = $this->api->get_staff(true);
        include_once( 'omnify-widget-update-iframe.php' );
    }  else if (isset($_GET['step']) && $_GET['step'] == 'update-button' && isset($_GET['widget'])) {
        include_once( 'omnify-widget-update-button.php' );
    } else if (isset($_GET['step']) && $_GET['step'] == 'create-button') {
        include_once( 'omnify-widget-create-button.php' );
    } else {
        include_once( 'omnify-widget-home.php' );
        include_once( 'omnify-widget-shortcodes-data.php' );
    }
}
?>
<script>
    var business_id;
    var nonsessionMethod = "getOmnifyWidgetData";
    var appURL = "<?php echo $this->get_api();?>";
    var customerURL = "https://customer.getomnify.com";
</script>
<?php
if($token) {
    echo "<script> var token = '$token'; </script>";
}
if($business) {
    echo "<script> var business_id = '$business'; </script>";
}
?>
