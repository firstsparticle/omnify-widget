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
  <h1>Omnify Widget</h1>
  <br/>
  <h3>Paste your Token in the input field below</h3>
    
  <form action="options.php" method="post" name="set_token">

    <?php

    settings_fields( $this->plugin_name );

    ?>

  <input type="text" class="form-control textbox-token" name="token" placeholder="Your token here..." />
  <br/>
  <input type="submit" data-loading="Submitting..." class="btn btn-primary btn-lg setup-token-btn" value="Submit Access Token">
  </form>
</div>

<div class="details-center-top">
  <div>
    <h4>How to get the Access Token?</h4>
  </div>
  <ol>
    <li>
      <a href="https://app.getomnify.com/login?utm_source=wordpress&utm_medium=plugin" target="_blank">Login</a> to Omnify or <a href="https://app.getomnify.com/signup?utm_source=wordpress&utm_medium=plugin" target="_blank">SignUp</a> if you're a new user.
    </li>
    <li>
      In the Omnify Dashboard, go to <b>Settings</b> &gt; <b>Integrations</b>.
    </li>
    <li>
      Click on <b>WordPress</b>
    </li>
    <img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/generate-token.png" class="image-padding" alt="Step 1"><br>
    <li>
      Click on <b>Copy Token</b> in the resulting pop-up.
    </li>
    <img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/copy-token.png" class="image-padding" alt="Step 2"><br>
  </ol>
</div>
