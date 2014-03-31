$(document).ready(function() {
	$('#frmuser').validate({
	    rules: {
	      fname: {
	        required: true
	      },
	      username: {
		      required: true
	      },
	      password: {
		      required: true
	      },
	      cpassword: {
	    	  equalTo: password,
		      required: true
	      },
	      group: "required"
	    },
	    messages: {
	    	fname: "Please enter your fullname",
	    	username: "Please enter username",
	    	password: "Please enter password here",
	    	cpassword: {
				required: "Please typ password again",
				equalTo: "Please enter the same password as above"
			},
			group: "Please provide a password"
			
		}
	});
});