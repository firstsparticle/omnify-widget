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

<div class="container">
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
    <input type="submit" data-loading="Submitting..." class="btn btn-primary btn-lg" value="Submit Access Token">
	</form>
  </div>
</div>
<div class="details-center-top">
  <div>
    <h4>How to get the Access Token?</h4>
  </div>
  <ol>
    <li>
      <a href="https://app.getomnify.com/login" target="_blank">Login</a> to Omnify or <a href="https://app.getomnify.com/signup" target="_blank">SignUp</a> if you're a new user.
    </li>
    <li>
      In the Omnify Dashboard, go to <b>Website</b> &gt; <b>Widgets</b> and click on <b>'Get Access Token'</b> button.
    </li>
    <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/generate-token.png" class="image-padding" alt="Step 1"><br>
    <li>
      Press 'Copy To Clipboard' in the resulting pop-up.
    </li>
    <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/copy-token.png" class="image-padding" alt="Step 2"><br>
  </ol>
</div>
