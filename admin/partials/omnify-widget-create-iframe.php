<div class="custom-forms-body widgets-alt-mobile">
    <div class="custom-forms-left-section widgets-alt-width">
        <div class="web-settings-wrapper less-margin">
            <a href="<?php echo admin_url('options-general.php?page=omnify-widget'); ?>"
               class="go-back-link w-inline-block">
                <img src="http://uploads.webflow.com/55f957c03f37ee8b38860430/59551a1b8ee3b20909f5c4b6_chevron-left-min.png"
                     class="auto-email-back"/>
                <div>Go back</div>
            </a>
            <h1 class="settings-heading">Create Iframe</h1>
            <div class="web-settings-wrapper-body">
                <div class="w-form">
                    <form id="email-form-3" name="email-form-3" class="iframe-widget-form" data-name="Email Form 3">
                        <div class="web-settings-terminology-wrapper no-margin">
                            <div class="web-settings-heading alt-top-margin smaller-size">Iframe Name</div>
                            <input type="text" name="name" maxlength="256" id="iframe_name" value="New Iframe Widget"
                                   class="form-input-onbording w-input"/>

                            <div class="web-settings-heading alt-top-margin smaller-size">Select Iframe Widget</div>
                            <select class=" form-input-onbording one-third one-third2 left-margin w-select"
                                    name="category" title="Select Category">
                                <option value="home">Home Page</option>
                                <option value="schedules">Schedules Page</option>
                                <option value="subscriptions">Subscriptions Page</option>
                            </select>

                            <div class="web-settings-heading alt-top-margin smaller-size">Iframe Width (in %)</div>
                            <input type="text" name="name" maxlength="256" id="iframe_width" value="100"
                                   class="form-input-onbording w-input"/>

                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox">
                                Show Header
                                <div class="material-switch pull-right">
                                    <input id="header" class="iframe-check" data-show="subscriptions schedules home" name="showheader" type="checkbox"
                                           checked="">
                                    <label for="header" class="label-primary"></label>
                                </div>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox">
                                Show Secondary Header
                                <div class="material-switch pull-right">
                                    <input id="secondary-header" class="iframe-check" data-show="subscriptions home" name="secondaryheader"
                                           type="checkbox"
                                           checked="">
                                    <label for="secondary-header" class="label-primary"></label>
                                </div>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox">
                                Show Footer
                                <div class="material-switch pull-right">
                                    <input id="footer" class="iframe-check" data-show="subscriptions schedules home" name="showfooter" type="checkbox"
                                           checked="">
                                    <label for="footer" class="label-primary"></label>
                                </div>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox">
                                Show Hero Image
                                <div class="material-switch pull-right">
                                    <input id="herosection" class="iframe-check" data-show="home" name="showherosection" type="checkbox"
                                           checked="">
                                    <label for="herosection" class="label-primary"></label>
                                </div>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox">
                                Show Filters
                                <div class="material-switch pull-right">
                                    <input id="filters" class="iframe-check" data-show="subscriptions schedules home" name="filter" type="checkbox"
                                           checked="">
                                    <label for="filters" class="label-primary"></label>
                                </div>
                            </div>
                            <hr>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox">
                                Pre-filtered View
                                <div class="material-switch pull-right">
                                    <input id="pre-filtered" class="pre-filtered" name="pre-filtered" type="checkbox">
                                    <label for="pre-filtered" class="label-primary"></label>
                                </div><br/>
                                <span style="color:#9f9f9f;font-size:14px;">This gives you the ability to filter which Services and Trainers to show in the Service Store. The filters themselves won't show in the Service Store.</span>
                            </div>

                            <div class="pre-filtered-space" style="display: none;">
                                <div class="web-settings-heading alt-top-margin smaller-size">Select Services</div>
                                <select style="width:70%" class="multiple-select form-input-onbording one-third one-third2 left-margin w-select"
                                        name="services" id="services-form" multiple="multiple">
                                    <option value="Class">Class</option>
                                    <option value="Classpack">Classpack</option>
                                    <option value="Membership">Membership</option>
                                    <option value="Appointment">Appointment</option>
                                    <option value="Event">Event</option>
                                    <option value="Facility">Facility</option>
                                </select>
                                <div class="web-settings-heading alt-top-margin smaller-size">Select Trainers</div>
                                <select style="width:70%" class="multiple-select form-input-onbording one-third one-third2 left-margin w-select"
                                        name="trainers" id="team-form" multiple="multiple">
                                    <?php foreach ($staff as $member) { ?>
                                        <option value="<?php echo $member['name']; ?>"><?php echo $member['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="clear" style="height:50px;"></div>
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
                    id="generate-iframe-btn">Generate Shortcode
            </button>
        </div>
    </div>
    <div class="custom-forms-right-section widgets-alt-width">
        <div class="custom-form-field-block no-top-padding">
            <h1 class="settings-heading smaller-heading">Preview</h1>
            <div class="website-filter-card center-align">
                <iframe class="iframe-view" src="" frameborder="0" allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</div>
