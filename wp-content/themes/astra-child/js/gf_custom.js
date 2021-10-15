//----------------------------------------------------------------------------------------
// Garvity Forms Custom JS Script

jQuery(function($){
    $(".gform_wrapper form").on("submit", function(e){
        // document.getElementById("form-submit-indicator-div").style.display = "block";
        $("#form-submit-indicator-div").show();
	});

    // OSIR organization report start date & end date
    $('.date_picker').datepicker({
        dateFormat : 'yy-mm-dd', // https://jqueryui.com/datepicker/#date-formats
        changeMonth: true,
        changeYear: true,
        yearRange: '2021:2025' // to Year 2025.
    });
});
	