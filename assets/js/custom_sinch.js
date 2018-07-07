/*Intialize the sinch */
var sinchClient = new SinchClient({
	applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
	capabilities: {calling: true, video: true, messaging: true},
	supportActiveConnection: true,
	onLogMessage: function(message) {
		console.log(message.message);
	}
});
sinchClient.startActiveConnection();


var sessionName = 'session_data'+sinchClient.applicationKey;


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
		}).fail(function(){
			sinchClient.newUser(data, function(ticket) {
				localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
				window.location.href=base_url+"chat";
			}).fail(handleFail);				
		});
	}

	
}


function message()
{


	var msg = $.trim($('#input_message').val());
	var to_username = $('#recipients').val();
	var sender_id = $('#sender_id').val();
	var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
	// console.log(msg);
	// console.log(to_username);
	// console.log(sender_id);
	// console.log(sessionObj);
	// console.log(sinchClient);
	
	
        // Get the messageClient
        var messageClient = sinchClient.getMessageClient(); 
        console.log(messageClient);
        // Create a new Message
        var message = messageClient.newMessage(to_username, msg);
        console.log(message);
        // Alt 1: Send it with success and fail handler
        messageClient.send(message);

        // $.post(base_url+'chat/insert_chat',{to_username:to_username,input_message:msg},function(response){
 	       // });




    }


			var myListenerObj = {
			onMessageDelivered: function(messageDeliveryInfo) {
			console.log(messageDeliveryInfo);
			// Handle message delivery notification
			},
			onIncomingMessage: function(message) {
			console.log(message);
			}
			}




 




/*Error Message */
var handleFail = function(error){
	//updateNotification('', error, 'error');	
}

