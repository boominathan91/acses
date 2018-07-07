
/*Register New User in Sinch */
var register = function(data){
	var credential = {};
	credential.username = data.sinch_username;
	credential.password = data.sinch_username;

	sinchClient.newUser(data, function(ticket) {
		console.log('Registeration success!');
	}).fail(handleFail);
}


/*** Name of session, can be anything. ***/


/*Login  User in Sinch */
var login = function(data){	
	var sessionName = 'session_data'+sinchClient.applicationKey;
	var credential = {};
	credential.username = data.sinch_username;
	credential.password = data.sinch_username;		

	var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
	if(sessionObj.userId) { 
		sinchClient.start(sessionObj)
		.then(function() {
			localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
			window.location.href=base_url+"chat";
		})
		.fail(handleFail);
	}
	else {	
		sinchClient.start(credential).then(function() {
			localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
			window.location.href=base_url+"chat";
		}).fail(register(credential));
	}

	
}



/*Error Message */
var handleFail = function(error){
	//updateNotification('', error, 'error');	
}

