(function( $ ) {
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
    var websiteURL, iframeURL, widgetData, business_id;
    var nonsessionMethod = "getOmnifyWidgetData";
    var appURL = "http://business.getomnify.in";
    var customerURL = "https://customer.getomnify.com";

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
        if(typeof(token) !== 'undefined') {
            plugin_init();
        } else {
            setTimeout(plugin_init, 1000);
        }

        /**
         * Iris color picker
         */
		$('.color-picker').iris({
            hide: false,
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
		$(document).click(function (e) {
			if (!$(e.target).is(".color-picker, .iris-picker, .iris-picker-inner")) {
				$('.color-picker').iris('hide');
			}
		});

        /**
         * Show color picker - Click Event
         */
		$('.color-picker').click(function (event) {
			$('.color-picker').iris('hide');
			$(this).iris('show');
            return false;
		});

        /**
         * Category - Change event
         */
        $("select[name='category']").on('change', function() {
            autofillButtonName();
            refreshButtonWidgetData();
            setButtonPreviewInModal();
        });

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
         * View Widget Source - Click Event
         */
        $(".view-code-btn").on('click', function() {
            var post_id = $(this).attr('id').split('-')[1];
            var code = $("#code-" + post_id).html();
            $("#widget-source-code").html(code);
        });

        /**
         * Change iframe options - Change Event
         */
        $(".iframe-check").on('change', setIframePreviewInModal);

        /**
         * Reset Auth Token - Click Event
         */
        $(".reset-auth-token").on('click', function() {
            var toReset = confirm("Are you sure you want to reset your token?");

            if(toReset) {
                resetAuthToken();
            }
        });

        /**
         * Generate iframe - Click Event (AJAX)
         */
        $("#generate-iframe-btn").on('click', function() {
            var height = $("#iframe-height").val();
            var width = $("#iframe-width").val();
            
            if(!height || !width) {
                alert("Please provide all the details");
                return false;
            }

            var iframe_data = generateIframeWidget(height, width, iframeURL);
            var data = {
                'action' : 'gen_iframe',
                'iframe-data': iframe_data
            };

            if(!iframe_data) {
                alert("Please provide all the details.");
                return false;
            }

            console.log(data);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log( "Widget id: " + response);
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
            if(category == 'website' || category == 'signup' || category == 'login') {
                serviceId = 'N/A';
                action = category;
            } else {
                action = $("select[name='select-service'] option:selected").text();
            }

            var cta_url = getLinkForCategory(serviceId, widgetData, category);

            if(!buttonColor || !buttonText || !category || !serviceId || !cta_url) {
                alert("Please provide all the details");
                return false;
            }

            var data = {
                'action' : 'gen_button',
                'button': {
                    'code' : generateBtnWidget( buttonColor, textColor, buttonText, cta_url ),
                    'action' : action,
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

                    pageReload();
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

            var isDelete = confirm("Are you sure you want to delete widget " + post_id + " ?");

            if(!isDelete) {
                return false;
            }

            var data = {
                'action' : 'delete_shortcode',
                'post_id' : post_id
            };

            console.log(data);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    if(response == "success") {
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
			setTimeout(function () {
				elem.setAttribute('class', classNames);
			}, 2000);
		}

        /**
         * Get base URL for custom domains
         */
        function setWebsiteURL(resp) {
            if(resp.whitelabel == 1 && resp.custom_domain != null) {
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
            return $("select[name='category']").val();
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
            
            // remove all the options from 'Select Service' dropdown
            $("select[name='select-service']").html("");

            refreshSelectPicker();  // refresh the bootstrap-select UI

            if(widgetData && category != 'website' && category != 'signup' && category != 'login') {
                
                $(".select-service-row").show();    // show 'Select Service' field

                for(var i = 0; i < widgetData[category].length; i++) {
                    var name = widgetData[category][i].name;
                    var id = widgetData[category][i].id;
                    
                    $("select[name='select-service']").append(
                        "<option value='" + id + "'>" + name + "</option>"
                    );

                    refreshSelectPicker();  // refresh the bootstrap-select UI
                }

            } else if(widgetData) {
                $(".select-service-row").hide();
            }
        }

        /**
         * Generate button link based on selected category
         */
        function getLinkForCategory(id, widgetData, category) {

            if(category != 'website' && category != 'signup' && category != 'login') {

                var link = widgetData['links'][category] + "/" + id ;
                return  websiteURL + '/Welcome/' + link;

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

            if(category == 'website' || category == 'signup' || category == 'login') {
                serviceId = 'N/A';
            }

            if(!serviceId) {
                $(".button-widget-preview-content").html("<h3>Please select a service!</h3>");
                return false;
            }

            var cta_url = getLinkForCategory(serviceId, widgetData, category);

            if(backColor && textColor && buttonText && cta_url) {
                
                $(".button-widget-preview-content").hide();
                $(".loader").show();

                setTimeout(function() {
                    $(".loader").hide();
                }, 500);

                setTimeout(function() {
                    var buttonHTML = generateBtnWidget( backColor, textColor, buttonText, cta_url, "0" );
                    $(".button-widget-preview-content").html(buttonHTML);
                    $(".button-widget-preview-content").show();
                }, 500);
            }
        }

        /**
         * Display iframe preview in modal
         */
        function setIframePreviewInModal() {

            var showFooter = 1;

            var showHeader = $("input[type='checkbox'][name='show-header']")
                .prop('checked') ? 1 :  0;
            
            var showHerosection = $("input[type='checkbox'][name='show-herosection']")
                .prop('checked') ? 1 :  0;
           
            var showFacilities = $("input[type='checkbox'][name='show-facilities']")
                .prop('checked') ? 1 :  0;
           
            var showMemberships = $("input[type='checkbox'][name='show-memberships']")
                .prop('checked') ? 1 :  0;
           
            var showEvents = $("input[type='checkbox'][name='show-events']")
                .prop('checked') ? 1 :  0;
           
            var showClasses = $("input[type='checkbox'][name='show-classes']")
                .prop('checked') ? 1 :  0;
           
            var showClasspacks = $("input[type='checkbox'][name='show-classpacks']")
                .prop('checked') ? 1 :  0;
           
            var showAppointments = $("input[type='checkbox'][name='show-appointments']")
                .prop('checked') ? 1 :  0;

            var finalBinaryCode = "" + showHeader + showHerosection+ showFooter + showClasses +
                showClasspacks + showFacilities + showMemberships + showEvents + showAppointments;

            var finalInteger = parseInt( finalBinaryCode , 2);

            iframeURL = websiteURL + '/?contentfilter=' + finalInteger;

            $(".iframe-view").attr('src', iframeURL);
        }


        /**
         * Generate button widget HTML
         */
        function generateBtnWidget( backColor, textColor, buttonText, CTA_URL, post_id ) {

            if(!post_id) {
                post_id = "<post_id>";
            }

            var buttonColors = "background-color: " + backColor +
                               "; color: " + textColor + ";";

            return "<style>#omnify-booking-widget-" + post_id + "{ " + buttonColors + "width : auto;"
                        + "height : auto ;border-radius : 25px; border: 1px solid #ddd;"
                        + " padding: 12px 25px 12px 25px; font-family : sans-serif;"
                        + " font-weight: normal;font-size: 100%; }</style><script"
                        + " type='text/javascript'>function newPopup(url){popupWindow"
                        + "=window.open(url,'','left=10,top=100,resizable=yes, "
                        + "scrollbars=yes,menubar=no,location=no,,toolbar=no,"
                        + "directories=no,status=yes')}</script><h4><button"
                        + " id='omnify-booking-widget-" + post_id + "'"
                        + " onclick=\"JavaScript:newPopup(\'" + CTA_URL  + " \');\""
                        + "> " + buttonText + "</button></h4>";

        }

        /**
         * Generate iframe widget HTML
         */
        function generateIframeWidget(height, width, url) {
            return '<iframe src=\"' + url + '\" style=\"height:' +
                    height + 'px; width:' + width + '%;\"></iframe>';
        }

        /**
         * Autofills the button form
         */
        function autoFillButtonForm() {
            $("select[name='category']").val('website');
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
         * Reset auth token function (AJAX)
         */
        function resetAuthToken() {

            var data = {
                'action' : 'reset_token',
            };

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    if(response == "success") {
                        pageReload();
                    } else {
                        alert("Reset failed!");
                    }
                }
            });
        }

        /**
         * Function to fetch data and initialize plugin - (AJAX)
         */
        function plugin_init() {
            var apiEndPoint = appURL + "/v2/Apiv2/Nonsession.json?method=" +
                                nonsessionMethod + "&auth_code=" + token;

            /**
             * AJAX call to fetch the business info
             */
            $.ajax({
                url: apiEndPoint,
                type: 'GET',
                success: function(resp) {

                    if(!resp.success && resp.success == 0 ) {

                        var toReset = confirm(resp.message + " " + "Do you want to reset the token?");
                        if(toReset) {
                            resetAuthToken();
                        }
                        return false;
                    }

                    widgetData = resp;
                    setWebsiteURL(resp);
                    console.log(JSON.stringify(resp));
                    business_id = widgetData.business_id;

                    // set all the previews
                    setIframePreviewInModal();
                    refreshButtonWidgetData();
                    setButtonPreviewInModal();
                },
                error: function(error) {
                    alert("Unable to connect to " + appURL + ". Please try again later!");
                    return false;
                }
            });
        }

    });

})( jQuery );
