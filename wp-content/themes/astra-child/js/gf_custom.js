//----------------------------------------------------------------------------------------
// Garvity Forms Custom JS Script

jQuery(function($){
    $('.gform_wrapper form').on('submit', function(e){
        // document.getElementById("form-submit-indicator-div").style.display = "block";
        $('#form-submit-indicator-div').show();
	});

    // OSIR organization report start date & end date
    $('.date_picker').datepicker({
        dateFormat : 'yy-mm-dd',    // https://jqueryui.com/datepicker/#date-formats
        changeMonth: true,
        changeYear: true,
        buttonImageOnly: true,
        buttonImage: '/wp-content/themes/astra-child/images/calendar-small.jpg',
        showOn: 'button',
        yearRange: '2021:2025',     // https://jqueryui.com/datepicker/#min-max
        // yearRange: '-10:+10'     // Current Year -10 to Current Year + 10.
        // yearRange: '+0:+10'      // Current Year to Current Year + 10.
        // yearRange: '1900:+0'     // Year 1900 to Current Year.
        // yearRange: '1985:2025'   // Year 1985 to Year 2025.
        // yearRange: '-0:+0'       // Only Current Year.
        // yearRange: '2025'        // Only Year 2025.
    });

    // Validate organization report start & end dates
    $('.org-report-form').on('submit', function(e){
        var startDate = $('.report-start-date').val();
        var endDate = $('.report-end-date').val();

        // console.log(startDate);
        // console.log(endDate);
        // console.log(Date.parse(startDate));
        // console.log(Date.parse(endDate));

        if ( startDate === '' || endDate === '' ) {
            alert ('Organization reporting period is invalid. Please choose both the start and end dates!');
            return false;
        } else if ( Date.parse(startDate) > Date.parse(endDate) ) {
            alert ('Organization reporting period is invalid. Start date should be equal to or after the end date!');
            return false;
        }

        return true;
	});
});
	