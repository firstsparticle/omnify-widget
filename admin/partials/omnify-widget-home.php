<?php

/**
 * Provide a home view to admin for the plugin
 *
 * @link       https://www.getomnify.com/about-us/
 * @since      1.0.0
 *
 * @package    Omnify_Widget
 * @subpackage Omnify_Widget/admin/partials
 */
?>

<div style="text-align: center;margin-top:30px;">
    <img src='<?php echo plugin_dir_url(__FILE__); ?>/images/omnifylogo.png' style="width:320px" class="img-rounded"
         alt="Omnify Inc">
    <div style="margin-top: 70px">
        <h1><strong>Start selling from your existing website</strong></h1>
        <h4>Easily embed Omnify buttons and iframes onto your WordPress site</h4>
    </div>
    <br/>
    <a class="dashboard-button btn-primary"
       href="<?php echo admin_url('options-general.php?page=omnify-widget&step=create-button'); ?>">Create a Button
        Widget</a>
    <a class="dashboard-button btn-success"
       href="<?php echo admin_url('options-general.php?page=omnify-widget&step=create-iframe'); ?>">Create an iFrame
        Widget</a>
    <button class="dashboard-button btn-danger reset-auth-token" data-toggle="modal">Reset Auth Token</button>
    <br>
</div>
<br/>
<br/>

<div class="modal-loader"><!-- bottom of page --></div>
