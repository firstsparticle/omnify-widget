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
    var appURL = "http://business.getomnify.in";
    var websiteURL;
    var nonsessionMethod = "getOmnifyWidgetData";
    var iframeURL;
    var widgetData;
    var business_id;
    var customerURL = "https://customer.getomnify.com";

    $(function() {

        /**
         * Iris color picker
         */
		$('.color-picker').iris();    
		$(document).click(function (e) {
			if (!$(e.target).is(".color-picker, .iris-picker, .iris-picker-inner")) {
				$('.color-picker').iris('hide');
			}
		});
		$('.color-picker').click(function (event) {
			$('.color-picker').iris('hide');
			$(this).iris('show');
            return false;
		});

        /**
         * Copy shortcode click event
         */
        var clipboard = new Clipboard('.copy-shortcode-btn');
        clipboard.on('success', event => {
            if (event.text) {
                showTooltip(event.trigger, 'copied!');
            }
        });

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
         * Fetching business data
         */
        if(typeof(token) !== 'undefined') {
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
                    websiteURL = resp.base_protocol + "://" + resp.subdomain + '.' + resp.domain;
                    console.log(JSON.stringify(resp));
                    business_id = widgetData.business_id[0].business_id;
                    setPreviewInModal();
                    refreshButtonWidgetData();
                },
                error: function(error) {
                    alert("Unable to connect to " + appURL + ". Please try again later!");
                    return false;
                }
            });
        }

        /**
         * Category changing reflects button name
         */
        $("select[name='category']").on('change', refreshButtonWidgetData);
        function refreshButtonWidgetData() {
            var category = $("select[name='category']").val();
            $("select[name='select-service']").html("");

            if(widgetData && category != 'website' && category != 'signup' && category != 'login') {
                
                $(".select-service-row").show();
                for(var i = 0; i < widgetData[category].length; i++) {
                    var name = widgetData[category][i].name;
                    var id = widgetData[category][i].id;
                    
                    $("select[name='select-service']").append(
                            "<option value='" + id + "'>" + name + "</option>"
                            );
                }
            } else if(widgetData) {
                $(".select-service-row").hide();
            }
        }

        /*
         * View Widget Source
         */
        $(".view-code-btn").on('click', function() {
            var post_id = $(this).attr('id').split('-')[1];
            var code = $("#code-" + post_id).html();
            $("#widget-source-code").html(code);
        });

        function getLinkForCategory(id, widgetData, category) {

            if(!id || !widgetData || !category) {
                alert("Something went wrong. Please try again later!");
                return false;
            }

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

        function setPreviewInModal() {
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

        $(".iframe-check").on('change', setPreviewInModal);

        function generateButtonWidget(backColor, textColor, buttonText, CTA_URL ) {

            var buttonColors = "background-color: " + backColor +
                               "; color: " + textColor + ";";

            return "<style>#omnify-booking-widget-<post_id>{ " + buttonColors + "width : auto; height : auto ;border-radius : 25px; border: 1px solid #ddd; padding: 12px 25px 12px 25px; font-family : sans-serif ; font-weight: normal;font-size: 100%; }</style><script type='text/javascript'>function newPopup(url){popupWindow=window.open(url,'','left=10,top=100,resizable=yes,scrollbars=yes,menubar=no,location=no,,toolbar=no,directories=no,status=yes')}</script><h4><button id='omnify-booking-widget-<post_id>' onclick=\"JavaScript:newPopup(\'" + CTA_URL  + " \');\"" + "> " + buttonText + "</button></h4>";

        }

        function generateIframeWidget(height, width, url) {
            return '<iframe src=\"' + url + '\" style=\"height:' +
                    height + 'px; width:' + width + 'px;\"></iframe>';
        }

        /**
         * Generate iframe code button
         */
        $("#generate-iframe-btn").on('click', function() {
            var height = $("#iframe-height").val();
            var width = $("#iframe-width").val();
            
            if(!height || !width) {
                alert("Please provide all the details properly");
                return false;
            }

            var iframe_data = generateIframeWidget(height, width, iframeURL);
            var data = {
                'action' : 'gen_iframe',
                'iframe-data': iframe_data
            };

            if(!iframe_data) {
                alert("Please provide all the details properly.");
                return false;
            }

            console.log(data);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log( "Widget id: " + response);
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
                    
        });

         /**
         * Generate button code button
         */
        $("#generate-button-btn").on('click', function() {
            var buttonColor = $("input[name='button_color']").val();
            var textColor = $("input[name='text_color']").val();
            var serviceId = $("select[name='select-service']").val();
            var buttonText = $("#button_name").val();
            var category = $("select[name='category']").val()
            var cta_url = getLinkForCategory(serviceId, widgetData, category);
            var action = category;

            if(!buttonColor || !buttonText || !category || !serviceId || !cta_url) {
                alert("Please provide all the details properly.");
                return false;
            }

            var data = {
                'action' : 'gen_button',
                'button': {
                    'code' : generateButtonWidget( buttonColor, textColor, buttonText, cta_url ),
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
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        /**
         * Reset Auth Token
         */
        $(".reset-auth-token").on('click', function() {
            var toReset = confirm("Are you sure you want to reset your token?");

            if(toReset) {
                resetAuthToken();
            }

        });

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
                        location.reload();
                    } else {
                        alert("Reset failed!");
                    }
                }
            });
        }

        /**
         * Delete shortcode AJAX
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
                        location.reload();
                    } else {
                        alert("Deleting failed!");
                    }
                }
            });

        });
 

    });

})( jQuery );
