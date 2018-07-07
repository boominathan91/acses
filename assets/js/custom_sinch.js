/*Intialize the sinch */
var sinchClient = new SinchClient({
	applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
	capabilities: {calling: true, video: true, messaging: true},
	supportActiveConnection: true,
	onLogMessage: function(message) {
		console.log(message);
	}
});
sinchClient.startActiveConnection();

/*Register New User in Sinch */
var register = function(data){	
	sinchClient.newUser(data, function(ticket) {
		console.log('Registeration success!');
	}).fail(handleFail);
}

/*Error Message */
var handleFail = function(error){
	updateNotification('', error, 'error');	
}

