var apiKey='46145352';
var sessionId='1_MX40NjE0NTM1Mn5udWxsfjE1MzU0NTE0NTY4MTJ-YldudWM0T004TW5yWVFBOXF6YkN5QWxQfn4';
var token;
var subscribers = {};

function handleError(error) {
  if (error) {
    console.error(error);
  }
}

function initializeSession() {

  $.post(base_url+'chat/get_chat_token',function(res){
    
    // console.log(res);
  });


  return false;
  var session = OT.initSession(apiKey, sessionId);
  // initialize the publisher
  var publisherOptions = {
    showControls: true,
    insertMode: 'append',
    width: '100%',
    height: '100%'
  };
  var publisher = OT.initPublisher('publisher', publisherOptions, handleError);

  var token = $('#token').val();
  // Connect to the session
  session.connect(token, function callback(error) {
    if (error) {
      handleError(error);
    } else {
      // If the connection is successful, publish the publisher to the session
      session.publish(publisher, handleError);
    }
  });





  // Subscribe to a newly created stream
  // session.on('streamCreated', function streamCreated(event) {
  //   var subscriberOptions = {
  //     insertMode: 'append',
  //     width: '30%',
  //     height: '50%'
  //   };
  

  //   console.log('--event--');
  //   console.log(event);
  //   console.log('--stream--');
  //   console.log(event.stream);
  //   console.log('--streams--');
  //   console.log(event.streams);

  //   var subscriber_id = 'subscriber_' + event.stream.connection.connectionId;
  //   subscriberHtmlBlock = '<div class="subscriber" id="' + subscriber_id + '"></div>';
  //   $('#videos').append(subscriberHtmlBlock);
  //   var subscriber = session.subscribe(event.stream, subscriber_id, subscriberOptions, handleError);
  //   subscribers[subscriber_id] = subscriber;
  //   console.log(subscribers);  
  // });

  // session.on('sessionDisconnected', function sessionDisconnected(event) {
  //   console.log('You were disconnected from the session.', event.reason);
  // });

  
}


