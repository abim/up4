/* Tooltip */
$(function() {
	$('.tooltip').tooltip({
		track: true,
		delay: 0,
		showURL: false,
		showBody: " - ",
		fade: 250
	});
});

/* Printer */
$(document).ready(function() {
    $(".btnPrint").printPage();
  });

/* Tables */
$(document).ready(function() {
    $('#DataTable').dataTable( {
        "sPaginationType": "full_numbers"
    } );
} );