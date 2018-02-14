<?php
$blocks = [];
if (isset($widget['data']['iframe_form_data'][$widget['data']['widget_data']['params']['page']]['blocks'])) {
    $blocks = $widget['data']['iframe_form_data'][$widget['data']['widget_data']['params']['page']]['blocks'];
}
$widget = $widget['data'];
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
            <h1 class="settings-heading">Update Iframe</h1>
            <div class="web-settings-wrapper-body">
                <div class="w-form">
                    <form id="email-form-3" name="email-form-3" class="iframe-widget-form" data-name="Email Form 3">
                        <div class="web-settings-terminology-wrapper no-margin">
                            <div class="web-settings-heading alt-top-margin smaller-size">Iframe Name</div>
                            <input type="text" name="name" maxlength="256" id="iframe_name"
                                   value="<?php echo $widget['widget_data']['name']; ?>"
                                   class="form-input-onbording w-input"/>

                            <div class="web-settings-heading alt-top-margin smaller-size">Select Iframe Widget</div>
                            <select class=" form-input-onbording one-third one-third2 left-margin w-select"
                                    name="category" title="Select Category">
                                <option value="home" <?php if ($widget['widget_data']['params']['page'] == 'home') {
                                    echo 'selected';
                                } ?>>Home Page
                                </option>
                                <option value="schedules" <?php if ($widget['widget_data']['params']['page'] == 'schedules') {
                                    echo 'selected';
                                } ?>>Schedules Page
                                </option>
                                <option value="subscriptions" <?php if ($widget['widget_data']['params']['page'] == 'subscriptions') {
                                    echo 'selected';
                                } ?>>Subscriptions Page
                                </option>
                            </select>

                            <div class="web-settings-heading alt-top-margin smaller-size">Iframe Width (in %)</div>
                            <input type="text" name="name" maxlength="256" id="iframe_width" value="<?php echo $widget['widget_data']['style'];?>"
                                   class="form-input-onbording w-input"/>

                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox"<?php if(!isset($blocks['showheader'])) echo ' style="display:none;"';?>>
                                Show Header
                                <div class="material-switch pull-right">
                                    <input id="header" class="iframe-check" data-show="subscriptions schedules home"
                                           name="showheader" type="checkbox"
                                        <?php if(isset($widget['widget_data']['params']['blocks']['showheader']) && $widget['widget_data']['params']['blocks']['showheader'] == 1) { echo ' checked=""';}?>>
                                    <label for="header" class="label-primary"></label>
                                </div>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox"<?php if(!isset($blocks['secondaryheader'])) echo ' style="display:none;"';?>>
                                Show Secondary Header
                                <div class="material-switch pull-right">
                                    <input id="secondary-header" class="iframe-check" data-show="subscriptions home"
                                           name="secondaryheader"
                                           type="checkbox"
                                        <?php if(isset($widget['widget_data']['params']['blocks']['secondaryheader']) && $widget['widget_data']['params']['blocks']['secondaryheader'] == 1) { echo ' checked=""';}?>>
                                    <label for="secondary-header" class="label-primary"></label>
                                </div>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox"<?php if(!isset($blocks['showfooter'])) echo ' style="display:none;"';?>>
                                Show Footer
                                <div class="material-switch pull-right">
                                    <input id="footer" class="iframe-check" data-show="subscriptions schedules home"
                                           name="showfooter" type="checkbox"
                                        <?php if(isset($widget['widget_data']['params']['blocks']['showfooter']) && $widget['widget_data']['params']['blocks']['showfooter'] == 1) { echo ' checked=""';}?>>
                                    <label for="footer" class="label-primary"></label>
                                </div>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox"<?php if(!isset($blocks['showherosection'])) echo ' style="display:none;"';?>>
                                Show Hero Image
                                <div class="material-switch pull-right">
                                    <input id="herosection" class="iframe-check" data-show="home" name="showherosection"
                                           type="checkbox"
                                        <?php if(isset($widget['widget_data']['params']['blocks']['showherosection']) && $widget['widget_data']['params']['blocks']['showherosection'] == 1) { echo ' checked=""';}?>>
                                    <label for="herosection" class="label-primary"></label>
                                </div>
                            </div>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox">
                                Show Filters
                                <div class="material-switch pull-right">
                                    <input id="filter" class="iframe-check" data-show="subscriptions schedules home"
                                           name="filter"type="checkbox" <?php if(isset($widget['widget_data']['params']['prefilter']) && $widget['widget_data']['params']['prefilter'] == 0) { echo ' checked=""';}?>>
                                    <label for="filter" class="label-primary"></label>
                                </div>
                            </div>

                            <input type="hidden" name="name" maxlength="256" id="iframe_id"
                                   value="<?php echo $widget['widget_data']['id']; ?>"/>
                            <hr>
                            <div class="web-settings-heading alt-top-margin smaller-size inline-checkbox">
                                Pre-filtered View
                                <div class="material-switch pull-right">
                                    <input id="pre-filtered" class="pre-filtered" name="pre-filtered" type="checkbox" <?php if(isset($widget['widget_data']['params']['prefilter']) && $widget['widget_data']['params']['prefilter'] == 1) { echo ' checked=""';}?>>
                                    <label for="pre-filtered" class="label-primary"></label>
                                </div>
                                <br/>
                                <span style="color:#9f9f9f;font-size:14px;">This gives you the ability to filter which Services and Trainers to show in the Service Store. The filters themselves won't show in the Service Store.</span>
                            </div>
                            <div class="pre-filtered-space" style="<?php if($widget['widget_data']['params']['prefilter'] == 0) { echo 'display: none;';}?>">
                                <div class="web-settings-heading alt-top-margin smaller-size">Select Services</div>
                                <select style="width:70%"
                                        class="multiple-select form-input-onbording one-third one-third2 left-margin w-select"
                                        name="services" id="services-form" multiple="multiple">
                                    <option value="Class"<?php if(in_array('Class', $widget['widget_data']['params']['services'])) { echo ' selected';}?>>Class</option>
                                    <option value="Classpack"<?php if(in_array('Classpack', $widget['widget_data']['params']['services'])) { echo ' selected';}?>>Classpack</option>
                                    <option value="Membership"<?php if(in_array('Membership', $widget['widget_data']['params']['services'])) { echo ' selected';}?>>Membership</option>
                                    <option value="Appointment"<?php if(in_array('Appointment', $widget['widget_data']['params']['services'])) { echo ' selected';}?>>Appointment</option>
                                    <option value="Event"<?php if(in_array('Event', $widget['widget_data']['params']['services'])) { echo ' selected';}?>>Event</option>
                                    <option value="Facility"<?php if(in_array('Facility', $widget['widget_data']['params']['services'])) { echo ' selected';}?>>Facility</option>
                                </select>
                                <div class="web-settings-heading alt-top-margin smaller-size">Select Trainers</div>
                                <select style="width:70%"
                                        class="multiple-select form-input-onbording one-third one-third2 left-margin w-select"
                                        name="trainers" id="team-form" multiple="multiple">
                                    <?php foreach ($staff as $member) { ?>
                                        <option value="<?php echo $member['name']; ?>"<?php if(in_array($member['name'], $widget['widget_data']['params']['trainers'])) { echo ' selected';}?>><?php echo $member['name']; ?></option>
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
                    id="update-iframe-btn">Update
            </button>
        </div>
    </div>
    <div class="custom-forms-right-section widgets-alt-width">
        <div class="custom-form-field-block no-top-padding">
            <h1 class="settings-heading smaller-heading">Preview</h1>
            <div class="website-filter-card center-align" style="height:500px;">
                <?php echo get_post_field('post_content', $_GET['widget']); ?>
            </div>
        </div>
    </div>
</div>
