$(document).ready(function() {
	$('#frmuser').validate({
	    rules: {
		    vname: "required",
		    imei: "required",
		    group: "required"
	    },
	    messages: {
	    	vname: "Please enter vehicle name",
	    	imei: "Please enter imei",
	    	group: "Please select a one or more group"		
		}
	});
});