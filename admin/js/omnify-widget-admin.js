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

    // add color picker to all color type inputs
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
         * iFrame fetch source
         */
        var baseURL = 'http://livetest1.linkmysport.in/';
        var finalURL;

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

            finalURL = baseURL + '/?contentfilter=' + finalInteger;

            $(".iframe-view").attr('src', finalURL);
        }

        setPreviewInModal();
        $(".iframe-check").on('change', setPreviewInModal);;

        function generateButtonWidget() {
                
            var buttonColors = "background-color: " + $("#button_color").val() +
                               "; color: " + $("#text_color").val() + ";";

            var finalString = "<style>#omnify-booking-widget{ " + buttonColors + "width : auto; height : auto ;border-radius : 25px; border: 1px solid #ddd; padding: 12px 25px 12px 25px; font-family : sans-serif ; font-weight: normal;font-size: 100%; }</style><script type='text/javascript'>function newPopup(url){popupWindow=window.open(url,'','left=10,top=100,resizable=yes,scrollbars=yes,menubar=no,location=no,,toolbar=no,directories=no,status=yes')}</script><h4><button id='omnify-booking-widget' onclick=\"JavaScript:newPopup(\'" + finalURL  + " \');\"" + "> " + buttonText + "</button></h4>";

        }

        function generateIframeWidget() {
            var height = $("#iframe-height").val();
            var width = $("#iframe-width").val();
            return '<iframe src=\"' + finalURL + '\" style=\"height:' + height + 'px; width:' + width + 'px;\"></iframe>';
        }

        $("#generate-iframe-btn").on('click', function() {
            var data = {
                action : 'gen_iframe',
                'iframe-data': generateIframeWidget(),
            };

            console.log(data);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    alert(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
                    
        });

    });

})( jQuery );
