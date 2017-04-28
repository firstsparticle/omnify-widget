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
    var appURL = "http://business.linkmysport.in";
    var websiteURL;
    var nonsessionMethod = "getOmnifyWidgetData";
    var finalURL;
    var widgetData;

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
         * Copy shortcode to clipboard
         */
        $(".copy-shortcode").click(function(e) {
            var shortcode = $(this).parent().find(".shortcode").val();
            alert(shortcode);
        });

        /**
         * Fetching business data
         */
        var apiEndPoint = appURL + "/v2/Apiv2/Nonsession.json?method=" +
                            nonsessionMethod + "&auth_code=" + token;

        /**
         * AJAX call to fetch the business info
         */
        $.ajax({
            url: apiEndPoint,
            type: 'GET',
            success: function(response) {
                widgetData = response;
                websiteURL = response.base_protocol + "://" + response.subdomain + '.' + response.domain;
                console.log(JSON.stringify(response));
                setPreviewInModal();
            }
        });

        /**
         * Category changing reflects button name
         */
        $("select[name='category']").on('change', function() {
            var category = $(this).val();
            $("select[name='select-service']").html("");

            if(widgetData && category != 'website' && category != 'signup' && category != 'login') {

                for(var i = 0; i < widgetData[category].length; i++) {
                    var name = widgetData[category][i].name;
                    var id = widgetData[category][i].id;
                    
                    $("select[name='select-service']").append(
                            "<option value='" + id + "'>" + name + "</option>"
                            );
                }

            }
        });

        function getLinkForCategory(id, widgetData, category) {

            appURL = "http://business.linkmysport.in";
            if(category != 'website' && category != 'signup' && category != 'login') {
                var link = widgetData['links'][category] + "/" + id ;
            } else {
                var link = category;
            }

            return  websiteURL + '/Welcome/' + link;
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

            finalURL = websiteURL + '/?contentfilter=' + finalInteger;

            $(".iframe-view").attr('src', finalURL);
        }

        $(".iframe-check").on('change', setPreviewInModal);

        function generateButtonWidget(backColor, textColor, buttonText, CTA_URL ) {

            var buttonColors = "background-color: " + backColor +
                               "; color: " + textColor + ";";

            return "<style>#omnify-booking-widget{ " + buttonColors + "width : auto; height : auto ;border-radius : 25px; border: 1px solid #ddd; padding: 12px 25px 12px 25px; font-family : sans-serif ; font-weight: normal;font-size: 100%; }</style><script type='text/javascript'>function newPopup(url){popupWindow=window.open(url,'','left=10,top=100,resizable=yes,scrollbars=yes,menubar=no,location=no,,toolbar=no,directories=no,status=yes')}</script><h4><button id='omnify-booking-widget' onclick=\"JavaScript:newPopup(\'" + CTA_URL  + " \');\"" + "> " + buttonText + "</button></h4>";

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
            var iframe_data = generateIframeWidget(height, width, finalURL);
            var data = {
                'action' : 'gen_iframe',
                'iframe-data': iframe_data
            };

            if(!iframe_data) {
                alert("Something went wrong! Please provide all the details properly.");
            }

            console.log(data);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
                    
        });

        $("#generate-button-btn").on('click', function() {
            var buttonColor = $("input[name='button_color']").val();
            var textColor = $("input[name='text_color']").val();
            var serviceId = $("select[name='select-service']").val();
            var buttonText = $("#button_name").val();
            var category = $("select[name='category']").val()
            var cta_url = getLinkForCategory(serviceId, widgetData, category);
            var action = category;

            if(!buttonColor && !buttonText && !category && !serviceId && !cta_url) {
                alert("Something went wrong! Please provide all the details properly.");
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
                    alert(response);
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

    });

})( jQuery );
