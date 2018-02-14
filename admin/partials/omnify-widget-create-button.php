<div class="custom-forms-body widgets-alt-mobile">
    <div class="custom-forms-left-section widgets-alt-width">
        <div class="web-settings-wrapper less-margin">
            <a href="<?php echo admin_url('options-general.php?page=omnify-widget'); ?>"
               class="go-back-link w-inline-block">
                <img src="http://uploads.webflow.com/55f957c03f37ee8b38860430/59551a1b8ee3b20909f5c4b6_chevron-left-min.png"
                     class="auto-email-back"/>
                <div>Go back</div>
            </a>
            <h1 class="settings-heading">Create Button</h1>
            <div class="web-settings-wrapper-body">
                <div class="w-form">
                    <form id="email-form-3" name="email-form-3" data-name="Email Form 3" class="btn-widget-form">
                        <div class="web-settings-terminology-wrapper no-margin">
                            <div class="web-settings-heading alt-top-margin smaller-size">Button Name</div>
                            <input type="text" name="name" maxlength="256" id="button_name" value="Visit Website" class="form-input-onbording w-input"/>

                            <div class="web-settings-heading alt-top-margin smaller-size">Select Service</div>
                            <select class=" form-input-onbording one-third one-third2 left-margin w-select"
                                    name="category" title="Select Category">
                                <option value="website">Omnify Website</option>
                                <option value="login">Sign In</option>
                                <option value="signup">Sign Up</option>
                                <option value="events">Events</option>
                                <option value="facilities">Facilities</option>
                                <option value="memberships">Memberships</option>
                                <option value="classpacks">Classpacks</option>
                                <option value="classes">Classes</option>
                                <option value="appointments">Appointments</option>
                            </select>
                            <div class="select-service-row" style="display: none;">
                                <div class="web-settings-heading alt-top-margin smaller-size">Select Service</div>
                                <select title="Select Service" name="select-service"
                                        class="form-input-onbording one-third one-third2 left-margin w-select">
                                </select>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size">Text Color</div>
                            <input name="text_color" class='color-picker form-input-onbording half w-input'
                                   value="#FFFFFF"/>

                            <div class="web-settings-heading alt-top-margin smaller-size">Button Color</div>
                            <input name="button_color" class='color-picker form-input-onbording half w-input'
                                   value="#3898EC"/>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget-btn-wrapper">
            <button type="button" class="add-website-filter-btn bottom-margin alt-margin delete-btn w-button go-home">Close
            </button>
            <button type="button" class="add-website-filter-btn bottom-margin alt-margin enabled w-button"
                    id="generate-button-btn">Generate Shortcode
            </button>
        </div>
    </div>
    <div class="custom-forms-right-section widgets-alt-width">
        <div class="custom-form-field-block no-top-padding">
            <h1 class="settings-heading smaller-heading">Preview</h1>
            <div class="website-filter-card center-align button-widget-preview">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>/images/ajax-loader.gif" class="loader"/>
                <div class="iframe-widget-preview button-widget-preview-content"></div>
            </div>
        </div>
    </div>
</div>