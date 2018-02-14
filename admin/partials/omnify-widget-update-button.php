<?php
$post_id = $_GET['widget'];
$name = htmlentities(get_post_meta($post_id, 'name', true));
$serviceCategory = htmlentities(get_post_meta($post_id, 'service-category', true));
$service = htmlentities(get_post_meta($post_id, 'service', true));
$textColor = htmlentities(get_post_meta($post_id, 'text-color', true));
$buttonColor = htmlentities(get_post_meta($post_id, 'button-color', true));
?>
<div class="custom-forms-body widgets-alt-mobile">
    <div class="custom-forms-left-section widgets-alt-width">
        <div class="web-settings-wrapper less-margin">
            <a href="<?php echo admin_url('options-general.php?page=omnify-widget'); ?>"
               class="go-back-link w-inline-block">
                <img src="http://uploads.webflow.com/55f957c03f37ee8b38860430/59551a1b8ee3b20909f5c4b6_chevron-left-min.png"
                     class="auto-email-back"/>
                <div>Go back</div>
            </a>
            <h1 class="settings-heading">Update Button</h1>
            <div class="web-settings-wrapper-body">
                <div class="w-form">
                    <form id="email-form-3" name="email-form-3" data-name="Email Form 3" class="btn-widget-form">
                        <input type="hidden" name="post_id" value="<?php echo $post_id;?>">
                        <div class="web-settings-terminology-wrapper no-margin">
                            <div class="web-settings-heading alt-top-margin smaller-size">Button Name</div>
                            <input type="text" name="name" maxlength="256" id="button_name" value="<?php echo $name; ?>"
                                   class="form-input-onbording w-input"/>

                            <div class="web-settings-heading alt-top-margin smaller-size">Select Service</div>
                            <select class=" form-input-onbording one-third one-third2 left-margin w-select"
                                    name="category" title="Select Category">
                                <option value="website">
                                    Omnify Website
                                </option>
                                <option value="login">Sign
                                    In
                                </option>
                                <option value="signup">Sign
                                    Up
                                </option>
                                <option value="events">
                                    Events
                                </option>
                                <option value="facilities">
                                    Facilities
                                </option>
                                <option value="memberships">
                                    Memberships
                                </option>
                                <option value="classpacks">
                                    Classpacks
                                </option>
                                <option value="classes">
                                    Classes
                                </option>
                                <option value="appointments">
                                    Appointments
                                </option>
                            </select>
                            <div class="select-service-row"<?php if (!$service) echo ' style="display: none;"'; ?>>
                                <div class="web-settings-heading alt-top-margin smaller-size">Select Service</div>
                                <select title="Select Service" name="select-service"
                                        class="form-input-onbording one-third one-third2 left-margin w-select">
                                </select>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size">Text Color</div>
                            <input name="text_color" class='color-picker form-input-onbording half w-input'
                                   value="<?php echo $textColor; ?>"/>

                            <div class="web-settings-heading alt-top-margin smaller-size">Button Color</div>
                            <input name="button_color" class='color-picker form-input-onbording half w-input'
                                   value="<?php echo $buttonColor; ?>"/>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget-btn-wrapper">
            <button type="button" class="add-website-filter-btn bottom-margin alt-margin delete-btn w-button go-home">
                Close
            </button>
            <button type="button" class="add-website-filter-btn bottom-margin alt-margin enabled w-button"
                    id="update-button-btn">Update
            </button>
        </div>
    </div>
    <div class="custom-forms-right-section widgets-alt-width">
        <div class="custom-form-field-block no-top-padding">
            <h1 class="settings-heading smaller-heading">Preview</h1>
            <div class="website-filter-card center-align button-widget-preview">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>/images/ajax-loader.gif" class="loader"
                     style="display: none"/>
                <div class="iframe-widget-preview button-widget-preview-content">
                    <?php echo get_post_field('post_content', $post_id); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        setTimeout(function(){
            jQuery('select[name="category"] > option[value="<?php echo $serviceCategory;?>"]').attr("selected", "selected").trigger("change");
            jQuery('select[name="select-service"] > option[value="<?php echo $service;?>"]').attr("selected", "selected").trigger("change");
            jQuery('#button_name').val('<?php echo $name;?>');
        }, 700);
    });
</script>