//----------------------------------------------------------------------------------------
// Garvity Forms Custom JS Script

jQuery(function($){
    $(".gform_wrapper form").on("submit", function(e){
        // document.getElementById("form-submit-indicator-div").style.display = "block";
        $("#form-submit-indicator-div").show();
	});

    // OSIR organization report start date & end date
    $('.date_picker').datepicker({
        dateFormat : 'yy-mm-dd',    // https://jqueryui.com/datepicker/#date-formats
        changeMonth: true,
        changeYear: true,
        buttonImageOnly: true,
        buttonImage: '/wp-content/themes/astra-child/images/calendar-medium.jpg',
        showOn: 'button',
        yearRange: '2021:2025',     // https://jqueryui.com/datepicker/#min-max
        // yearRange: '-10:+10'     // Current Year -10 to Current Year + 10.
        // yearRange: '+0:+10'      // Current Year to Current Year + 10.
        // yearRange: '1900:+0'     // Year 1900 to Current Year.
        // yearRange: '1985:2025'   // Year 1985 to Year 2025.
        // yearRange: '-0:+0'       // Only Current Year.
        // yearRange: '2025'        // Only Year 2025.
    });
});
	