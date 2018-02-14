<?php

/**
 * Provide setup view for the plugin
 *
 * @link       https://www.getomnify.com/about-us/
 * @since      1.0.0
 *
 * @package    Omnify_Widget
 * @subpackage Omnify_Widget/admin/partials
 */
?>
<div class="form-group form-center-top">
    <h1>Omnify Widget, business selection</h1>
    <br/>
    <h3>Please, select your business</h3>
    <div class="col-md-4 col-md-offset-4">
        <form action="options.php" method="post" name="set_business">
            <?php

            settings_fields($this->plugin_name);

            ?>
            <select name="business" id="" class="form-control">
                <option value="">-- Select --</option>
            </select>
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <br/>
            <input type="submit" data-loading="Submitting..." class="btn btn-primary btn-lg setup-token-btn"
                   value="Set business">
        </form>
    </div>
</div>
