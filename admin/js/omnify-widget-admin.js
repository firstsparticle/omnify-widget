(function($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     */

    /**
     * Global variables
     */
    var websiteURL, iframeURL, widgetData;

    /**
     * Show loader on AJAX requests
     */
    $(document).on({
        ajaxStart: function() {
            $("body").addClass("loading");
        },
        ajaxStop: function() {
            $("body").removeClass("loading");
        }
    });

    $(document).ready(function() {

        /**
         * All of the initializations should reside below this comment.
         *
         * Note: It is recommended that, any block of code containing
         * AJAX calls should be at the bottom of all the initializations.
         */

        /**
         * Initialize plugin
         */
        if (typeof(token) !== 'undefined') {
            plugin_init();
            if (typeof(business_id) !== 'undefined') {
                getWidgetData();
                setBusiness();
            }
        } else {
            setTimeout(plugin_init, 1000);
        }
        if (typeof(token) !== 'undefined' && typeof(business_id) == 'undefined') {
            setTimeout(populateBusinesses, 1000);
        } else {
            syncIframeWidgets();
        }

        /**
         * Iris color picker
         */
        $('.color-picker').iris({
            hide: true,
            change: setButtonPreviewInModal
        });

        /**
         * Integrating clipboard plugin
         */
        var clipboard = new Clipboard('.copy-shortcode-btn');
        clipboard.on('success', event => {
            if (event.text) {
                showTooltip(event.trigger, 'copied!');
            }
        });


        /**
         * All of the browser events handler should reside below.
         *
         * Note: It is recommended that, the event handlers which
         * perform AJAX calls should be placed at the bottom.
         */

        /**
         * Hide color picker - Click Event
         */
        $(document).click(function(e) {
            if (!$(e.target).is(".color-picker, .iris-picker, .iris-picker-inner")) {
                $('.color-picker').iris('hide');
            }
        });

        /**
         * Show color picker - Click Event
         */
        $('.color-picker').click(function(event) {
            $('.color-picker').iris('hide');
            $(this).iris('show');
            return false;
        });

        /**
         * Category - Change event
         */
        $("form.btn-widget-form select[name='category']").on('change', function() {
            autofillButtonName();
            refreshButtonWidgetData();
            setButtonPreviewInModal();
        });

        /**
         * Category - Change event
         */
        $("form.iframe-widget-form select[name='category']").on('change', function() {
            var $selected = $(this).val();
            $('input.iframe-check').each(function() {
                var $show = $(this).data('show');
                if ($show.indexOf($selected) == -1) {
                    $(this).prop('checked', false);
                    $(this).closest('.inline-checkbox').hide();
                } else {
                    $(this).prop('checked', true);
                    $(this).closest('.inline-checkbox').show();
                }
            });
        });

        $('.multiple-select').select2();

        /**
         * Service - Change Event
         */
        $("select[name='select-service']").on('change', function() {
            setButtonPreviewInModal();
        });

        /**
         * Button name - Change Event
         */
        $("#button_name").on('input propertychange paste', function() {
            setButtonPreviewInModal();
        });

        /*
         * Click on close button
         */
        $(".go-home").on('click', function() {
            goHome();
        });

        /**
         * Change iframe options - Change Event
         */
        $("input[name='filter']").on('change', function() {
            if ($(this).is(':checked')) {
                $('input[name="pre-filtered"]').prop('checked', false);
                $('.pre-filtered-space').hide();
            } else {
                $('input[name="pre-filtered"]').prop('checked', true);
                $('.pre-filtered-space').show();
            }
        });

        /**
         * Change iframe options - Change Event
         */
        $("input[name='pre-filtered']").on('change', function() {
            if ($('input[name="filter"]').is(':checked')) {
                if ($(this).is(':checked')) {
                    $('input[name="filter"]').prop('checked', false);
                    $('.pre-filtered-space').show();
                } else {
                    $('input[name="filter"]').prop('checked', true);
                    $('.pre-filtered-space').hide();
                }
            }
            if ($(this).is(':checked')) {
                $('.pre-filtered-space').show();
            } else {
                $('.pre-filtered-space').hide();
            }
        });

        /**
         * Reset Auth Token - Click Event
         */
        $(".reset-auth-token").on('click', function() {
            var toReset = confirm("Are you sure you want to reset your token?");

            if (toReset) {
                resetAuthToken();
            }
        });

        /**
         * Generate iframe - Click Event (AJAX)
         */
        $("#generate-iframe-btn").on('click', function() {
            var width = $("#iframe_width").val();
            var name = $("#iframe_name").val();
            var page = $("select[name='category'] option:selected").val();
            var services = $("#services-form").val();
            var team = $("#team-form").val();

            if (!name || !width) {
                alert("Please provide all the details");
                return false;
            }

            var iframe_data = {};
            $(".iframe-check").each(function(index, elem) {
                var id = this.name;
                iframe_data[id] = (this.checked ? 1 : 0);
            });

            var data = {
                'action': 'gen_iframe',
                'iframe-data': JSON.stringify(iframe_data),
                'iframe-name': name,
                'iframe-team': team,
                'iframe-services': services,
                'iframe-width': width,
                'iframe-page': page
            };

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    goHome('#active-widgets');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        /**
         * Update iframe - Click Event (AJAX)
         */
        $("#update-iframe-btn").on('click', function() {
            var id = $("#iframe_id").val();
            var width = $("#iframe_width").val();
            var name = $("#iframe_name").val();
            var page = $("select[name='category'] option:selected").val();
            var services = $("#services-form").val();
            var team = $("#team-form").val();

            if (!name || !width) {
                alert("Please provide all the details");
                return false;
            }

            var iframe_data = {};
            $(".iframe-check").each(function(index, elem) {
                var id = this.name;
                iframe_data[id] = (this.checked ? 1 : 0);
            });

            var data = {
                'action': 'update_iframe',
                'iframe-data': JSON.stringify(iframe_data),
                'iframe-id': id,
                'iframe-name': name,
                'iframe-width': width,
                'iframe-team': team,
                'iframe-services': services,
                'iframe-page': page
            };

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    pageReload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        /**
         * Generate button widget - Click event (AJAX)
         */
        $("#generate-button-btn").on('click', function() {
            var buttonColor = $("input[name='button_color']").val();
            var textColor = $("input[name='text_color']").val();
            var buttonText = $("#button_name").val();
            var category = getCategory();
            var action;

            var serviceId = $("select[name='select-service']").val();
            if (category == 'website' || category == 'signup' || category == 'login') {
                serviceId = 'N/A';
                action = category;
            } else {
                action = $("select[name='select-service'] option:selected").text();
            }

            var cta_url = getLinkForCategory(serviceId, widgetData, category);

            if (!buttonColor || !buttonText || !category || !serviceId || !cta_url) {
                alert("Please provide all the details");
                return false;
            }

            var data = {
                'action': 'gen_button',
                'button': {
                    'code': generateBtnWidget(buttonColor, textColor, buttonText, cta_url),
                    'text': buttonText,
                    'service-category': category,
                    'service': serviceId,
                    'text-color': textColor,
                    'button-color': buttonColor,
                    'action': action,
                }
            };

            console.log(data);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log("Widget id: " + response);

                    $(':input')
                        .not(':button, :submit, :reset, :hidden, .shortcode')
                        .val('')
                        .removeAttr('checked')
                        .removeAttr('selected');

                    goHome('#active-widgets');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        /**
         * Update button widget - Click event (AJAX)
         */
        $("#update-button-btn").on('click', function() {
            var buttonColor = $("input[name='button_color']").val();
            var textColor = $("input[name='text_color']").val();
            var postId = $("input[name='post_id']").val();
            var buttonText = $("#button_name").val();
            var category = getCategory();
            var action;

            var serviceId = $("select[name='select-service']").val();
            if (category == 'website' || category == 'signup' || category == 'login') {
                serviceId = 'N/A';
                action = category;
            } else {
                action = $("select[name='select-service'] option:selected").text();
            }

            var cta_url = getLinkForCategory(serviceId, widgetData, category);

            if (!buttonColor || !buttonText || !category || !serviceId || !cta_url) {
                alert("Please provide all the details");
                return false;
            }

            var data = {
                'action': 'update_button',
                'button': {
                    'code': generateBtnWidget(buttonColor, textColor, buttonText, cta_url),
                    'text': buttonText,
                    'postId': postId,
                    'service-category': category,
                    'service': serviceId,
                    'text-color': textColor,
                    'button-color': buttonColor,
                    'action': action,
                }
            };

            console.log(data);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log("Widget id: " + response);

                    $(':input')
                        .not(':button, :submit, :reset, :hidden, .shortcode')
                        .val('')
                        .removeAttr('checked')
                        .removeAttr('selected');

                    goHome('#active-widgets');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        /**
         * Delete shortcode - Click Event (AJAX)
         */
        $(".delete-widget-btn").on('click', function() {
            var post_id = $(this).attr('id').split('-')[1];
            var widget_id = $(this).data('key');

            var isDelete = confirm("Are you sure you want to delete widget " + post_id + " ?");

            if (!isDelete) {
                return false;
            }

            var data = {
                'action': 'delete_shortcode',
                'post_id': post_id,
                'widget_id': widget_id
            };

            console.log(data);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    if (response == "success") {
                        autoFillButtonForm();
                        pageReload();
                    } else {
                        alert("Deleting failed!");
                    }
                }
            });
        });


        /**
         * All of the functions should reside below this comment.
         *
         * Note: It is recommended that, the functions which perform
         * AJAX calls should be at the bottom of all the functions.
         */

        /**
         * Show the tooltip 'Copied!'
         */
        function showTooltip(elem, msg) {
            var classNames = elem.className;
            elem.setAttribute('class', classNames + ' hint--top');
            elem.setAttribute('aria-label', msg);
            setTimeout(function() {
                elem.setAttribute('class', classNames);
            }, 2000);
        }

        /**
         * Get base URL for custom domains
         */
        function setWebsiteURL(resp) {
            if (resp.whitelabel == 1 && resp.custom_domain != null) {
                websiteURL = resp.base_protocol + "://" + resp.custom_domain;
            } else {
                websiteURL = resp.base_protocol + "://" + resp.subdomain + '.' + resp.domain;
            }
        }

        /**
         * Autofills button name based on category
         */
        function autofillButtonName() {
            var category = getCategory();
            var btnText;

            switch (category) {

                case 'website':
                    btnText = "Visit Website";
                    break;

                case 'signup':
                    btnText = "Join Now";
                    break;

                case 'login':
                    btnText = "Login";
                    break;

                default:
                    btnText = "Book Now";
                    break;
            }

            $("#button_name").val(btnText);
        }

        /**
         * Category getter
         */
        function getCategory() {
            return $("form.btn-widget-form select[name='category']").val();
        }

        /**
         * Refresh bootstrap-select to update
         */
        function refreshSelectPicker() {
            $(".selectpicker").selectpicker('refresh');
        }

        /**
         * Sets service data based on category
         */
        function refreshButtonWidgetData() {
            var category = getCategory();
            if (typeof category == 'undefined') {
                return false;
            }
            // remove all the options from 'Select Service' dropdown
            $("select[name='select-service']").html("");

            refreshSelectPicker(); // refresh the bootstrap-select UI

            if (widgetData && category != 'website' && category != 'signup' && category != 'login') {
                $(".select-service-row > div").html('Select ' + category);
                $(".select-service-row").show(); // show 'Select Service' field
                if (widgetData[category]) {
                    for (var i = 0; i < widgetData[category].length; i++) {
                        var name = widgetData[category][i].name;
                        var id = widgetData[category][i].id;

                        $("select[name='select-service']").append(
                            "<option value='" + id + "'>" + name + "</option>"
                        );

                        refreshSelectPicker(); // refresh the bootstrap-select UI
                    }
                }

            } else if (widgetData) {
                $(".select-service-row").hide();
            }
        }

        /**
         * Generate button link based on selected category
         */
        function getLinkForCategory(id, widgetData, category) {

            if (category != 'website' && category != 'signup' && category != 'login') {

                var link = widgetData['links'][category] + "/" + id;
                return websiteURL + '/Welcome/' + link;

            } else {

                switch (category) {

                    case 'website':
                        return websiteURL;

                    case 'signup':
                        return customerURL + '/Welcome/' + category + '/' + business_id +
                            '?redirectback=' + websiteURL;

                    case 'login':
                        return customerURL + '/Welcome/' + category + '/' + business_id +
                            '?redirectback=' + websiteURL;
                }
            }
        }

        /**
         * Display button preview in modal
         */
        function setButtonPreviewInModal() {

            var serviceId = $("select[name='select-service']").val();
            var backColor = $("input[name='button_color']").val();
            var textColor = $("input[name='text_color']").val();
            var buttonText = $("#button_name").val();
            var category = getCategory();

            if (category == 'website' || category == 'signup' || category == 'login') {
                serviceId = 'N/A';
            }


            if (!serviceId) {
                $(".button-widget-preview-content").html("<h3>Please select a service!</h3>");
                return false;
            }

            var cta_url = getLinkForCategory(serviceId, widgetData, category);

            if (backColor && textColor && buttonText && cta_url) {
                $(".loader").hide();
                var buttonHTML = generateBtnWidget(backColor, textColor, buttonText, cta_url, "0");
                $(".button-widget-preview-content").html(buttonHTML);
                $(".button-widget-preview-content").show();
            }
        }

        /**
         * Generate button widget HTML
         */
        function generateBtnWidget(backColor, textColor, buttonText, CTA_URL, post_id) {

            if (!post_id) {
                post_id = "<post_id>";
            }

            var buttonColors = "background-color: " + backColor +
                "; color: " + textColor + ";";

            return "<style>#omnify-booking-widget-" + post_id + "{ " + buttonColors + "width : auto;" +
                "height : auto ;" +
                " border-radius:2px; padding:12px 25px 12px 25px; font-family:sans-serif; " +
                "font-weight: normal;font-size: 100%;cursor: pointer;}</style><script" +
                " type='text/javascript'>function newPopup(url){popupWindow" +
                "=window.open(url,'','left=10,top=100,resizable=yes, " +
                "scrollbars=yes,menubar=no,location=no,,toolbar=no," +
                "directories=no,status=yes')}</script><h4><button" +
                " id='omnify-booking-widget-" + post_id + "'" +
                " onclick=\"JavaScript:newPopup(\'" + CTA_URL + " \');\"" +
                "> " + buttonText + "</button></h4>";

        }

        /**
         * Autofills the button form
         */
        function autoFillButtonForm() {
            $("form.btn-widget-form select[name='category']").val('website');
            $("#button_name").val('Visit Website');
            $("input[name='text_color']").val('#ffffff');
            $("input[name='button_color']").val('#00a6a6');
        }

        /**
         * Page refresh
         */
        function pageReload() {
            autoFillButtonForm();
            location.reload();
        }

        /**
         * Go to the homepage of the plugin
         */
        function goHome(toId) {
            var currentUrl = window.location.href;
            var newUrl = currentUrl.split('&')[0];
            if (typeof toId == 'undefined') {
                toId = '';
            }
            window.location.href = newUrl + toId;
        }

        /**
         * Reset auth token function (AJAX)
         */
        function resetAuthToken() {

            var data = {
                'action': 'reset_token',
            };

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    if (response == "success") {
                        pageReload();
                    } else {
                        alert("Reset failed!");
                    }
                }
            });
        }

        function populateBusinesses() {
            get_businesses();
        }

        function get_businesses() {
            var apiEndPoint = appURL + "/extv1/businesses/?apikey=" + token;
            /**
             * AJAX call to fetch the business info
             */
            $.ajax({
                url: apiEndPoint,
                type: 'GET',
                success: function(resp) {
                    $.each(resp.data, function(i, item) {
                        $('select[name="business"]').append($('<option>', {
                            value: item.id,
                            text: item.name
                        }));
                    });
                },
                error: function(error) {
                    alert("Unable to connect to " + apiEndPoint + ". Please try again later!");
                    console.log(error);
                    return false;
                }
            });
        }

        function setBusiness() {
            var apiEndPoint = appURL + "/extv1/businesses/?apikey=" + token;
            /**
             * AJAX call to fetch the business info
             */
            $.ajax({
                url: apiEndPoint,
                type: 'GET',
                success: function(resp) {
                    $.each(resp.data, function(i, item) {
                        if (item.id == business_id) {
                            setWebsiteURL(item);
                            setButtonPreviewInModal();
                            return;
                        }
                    });
                },
                error: function(error) {
                    alert("Unable to connect to " + apiEndPoint + ". Please try again later!");
                    console.log(error);
                    return false;
                }
            });
        }

        /**
         * Function to sync iframe widgets between omnify dashboard and wp instance
         */
        function syncIframeWidgets() {
            var apiEndPoint = appURL + "/extv1/businesses/" + business_id + "/widgets/?apikey=" + token;

            /**
             * AJAX call to fetch the business info
             */
            $.ajax({
                url: apiEndPoint,
                type: 'GET',
                success: function(resp) {
                    if (resp.success == '0') {
                        return false;
                    }
                    doSync(resp);
                },
                error: function(error) {
                    var rsp = $.parseJSON(error.responseText);
                    if (rsp.error == 'No records found') {
                        doSync([]);
                    } else {
                        alert("Unable to connect to " + apiEndPoint + ". Please try again later!");
                        return false;
                    }
                }
            });
        }

        function doSync(items) {
            var data = {
                'action': 'sync',
                'data': items
            };

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response) {
                        location.reload();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }


        /**
         * Function to fetch data and initialize plugin - (AJAX)
         */
        function plugin_init() {
            var apiEndPoint = appURL + "/extv1/auth/?apikey=" + token;
            /**
             * AJAX call to fetch the business info
             */
            $.ajax({
                url: apiEndPoint,
                type: 'GET',
                success: function(resp) {
                    if (!resp.success && resp.success == 0) {

                        var toReset = confirm(resp.message + " " + "Do you want to reset the token?");
                        if (toReset) {
                            resetAuthToken();
                        }
                        return false;
                    }
                    console.log(JSON.stringify(resp));

                    // set all the previews
                    setButtonPreviewInModal();
                },
                error: function(error) {
                    alert("Unable to connect to " + apiEndPoint + ". Please try again later!");
                    console.log(error);
                    return false;
                }
            });
        }

        /**
         * Function to fetch data
         */
        function getWidgetData() {
            var apiEndPoint = appURL + "/extv1/businesses/" + business_id + "/services/?apikey=" + token;

            /**
             * AJAX call to fetch the business info
             */
            $.ajax({
                url: apiEndPoint,
                type: 'GET',
                success: function(resp) {

                    widgetData = resp.data;
                    // set all the previews
                    setButtonPreviewInModal();
                },
                error: function(error) {
                    alert("Unable to connect to " + apiEndPoint + ". Please try again later!");
                    console.log(error);
                    return false;
                }
            });
        }
    });
})(jQuery);
