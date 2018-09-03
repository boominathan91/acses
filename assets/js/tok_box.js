var token;
var subscribers = {};



function get_call_notification(){
  $.get(base_url+'chat/get_call_notification',function(res){
    var obj = jQuery.parseJSON(res);
    var status = obj.status;
    var obj = obj.data;

    if(status == true){




      /* Notification occurs */

       $('audio#ringtone').prop("currentTime", 0);
      $('audio#ringtone').trigger("play");

      /* Show Chatting view */
      $('.profile').addClass('hidden');
      $('.text_chat,.chat-main-row').removeClass('hidden');
      $('#text_chat').addClass('active');
      $('#new_call_type').val(obj.type);
      $('#call_type').val(obj.call_type);
      $('.gr_tab,.group_vccontainer').removeClass('hidden');  



      /* Check Group call or one to one */

      if(obj.type == 'one'){ 



        if(obj.profile_img!=''){
          var caller_img = base_url+'uploads/'+obj.profile_img;    
        }else{
          var caller_img = base_url+'assets/img/user.jpg';  
        }    

        $('.caller_image').attr('src',caller_img);
        $('.caller_name').text(obj.first_name+' '+obj.last_name);
        $('.caller_login_id').val(obj.login_id);      
        $('#call_from_id').val(obj.login_id);      
        $('#call_to_id').val(obj.call_to_id);
        $('.caller_sinchusername').val(obj.sinch_username);      
        $('.caller_full_name').val(obj.first_name+' '+obj.last_name);      
        $('.caller_profile_img').val(caller_img);      
        $('#call_type').val(obj.call_type);    
        $('#group_id').val(obj.group_id);   

        $('#incoming_call').modal('show');         

        /* Remove old menu and prepend new user view */

        if( obj.online_status == 1){
          var online_status = 'online';
        }else{
          var online_status = 'offline';      
        }
        $('#'+obj.sinch_username).remove();
        $('li').removeClass('active');
        var html = '<li class="active" id="'+obj.sinch_username+'" onclick="set_chat_user('+obj.login_id+')">'+
        '<a href="#"><span class="status '+online_status+'"></span>'+obj.first_name+' '+obj.last_name+ '<span class="badge bg-danger pull-right" id="'+obj.sinch_username+'danger"></span></a>'+
        '</li>';       
        $('#new_call_user').html(html);              
        clearInterval(notify);


      }else if(obj.type == 'many'){

        var caller_img = base_url+'assets/img/user.jpg';  
        $('.caller_image').attr('src',caller_img);
        $('.caller_name').text(obj.group_name);

        $('#'+obj.group_name).remove();
        var data = '<li  id="'+obj.group_name+'" onclick="set_nav_bar_group_user('+obj.group_id+',this)">'+
        '<a href="#">#'+obj.group_name+ '<span class="badge bg-danger pull-right"  id="'+obj.group_name+'danger"></span></a>'+
        '</li>';
        $('#new_group_user').prepend(data);
        $('#'+obj.group_name).click();
        $('#incoming_call').modal('show');        
        clearInterval(notify);


      }             

    }else{
      $('audio#ringback').trigger("pause");
      $('audio#ringtone').trigger("pause");
      $('#incoming_call').modal('hide');

    }

  });
} 


var notify = setInterval(get_call_notification, 2000);

function handleError(error) {
  if (error) {
    console.error(error);
  }
}


function initializeSession() {

  clearInterval(notify);

  var call_type = $('#new_call_type').val();
  var type_of_call = $('#call_type').val();

  $.post(base_url+'chat/get_chat_token',{call_type:call_type,type_of_call:type_of_call},function(res){
    // console.log(res);
    var obj = jQuery.parseJSON(res);
    if(obj.error){
      updateNotification('',obj.error,'error');
      $('.vcend').addClass('hidden');
      return false;
    }


    /* New Outgoing  Call Initiated */
    var apiKey = obj.apiKey;    
    var sessionId = obj.sessionId;   
    var token = obj.token;
    var group_id = obj.dummy_group_id;
    $('#group_id').val(obj.dummy_group_id);

    var type = $('#call_type').val(); /* Audio Or Video call type */

    if(type == 'audio'){
      var publisherOptions = {      
        insertMode: 'append',
        width: '100%',
        height: '100%',      
        name: currentUserName,
        style: { nameDisplayMode: "on" },
        publishAudio:true,
        publishVideo:false
      };
      $('.phone').css('color','#55ce63'); 
      $('.vccam').addClass('active');

    }else{
      var publisherOptions = {      
        insertMode: 'append',
        width: '100%',
        height: '100%',      
        name: currentUserName,
        style: { nameDisplayMode: "on" }
      };
      $('.camera').css('color','#55ce63'); 
    }


    var session = OT.initSession(apiKey, sessionId);
    /*Initialize the publisher*/  
    var publisher = OT.initPublisher('outgoing', publisherOptions, handleError);
    $('#group_outgoing_caller_image').addClass('hidden');
    $('.vcend,.vccam').removeClass('hidden');  
    $('li').attr('disabled',true);      
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
     session.on('streamCreated', function streamCreated(event) {
      var subscriberOptions = {
        insertMode: 'append',
        width: '100%',
        height: '100%'

      };

      console.log('--event--');
      console.log(event);
      console.log('--stream--');
      console.log(event.stream);
      console.log('--streams--');
      console.log(event.streams);


      $('.test').addClass('hidden');

      $('.subscriber').click(function(){
        if($(this).hasClass('active')){         
          $('#inner_image').removeClass('hidden');
          $(this).removeClass('active');  
          $('.sample').html('');    
        }else{    
          $('#inner_image').addClass('hidden');
          $(this).addClass('active'); 
          var data =$(this).html();
          $('.sample').html(data);    
        }

      });



     var subscriber_id = 'subscriber_' + event.stream.connection.connectionId;
      subscriberHtmlBlock = '<div class="subscriber" id="' + subscriber_id + '" ></div>';
      $('#member_tab').append(subscriberHtmlBlock);
      var subscriber = session.subscribe(event.stream, subscriber_id, subscriberOptions, handleError);
      subscribers[subscriber_id] = subscriber;
     // console.log(subscribers);


          /* Video Swapping into large view */
       $('#'+subscriber_id).click(function(){  
       subscribers[subscriber_id].subscribeToVideo(false);
          $('#inner_image').addClass('hidden');
          $(this).addClass('active').html('');           
          var id = $(this).attr('id');

          var subscriberOptions = {
        insertMode: 'append',
        width: '100%',
        height: '100%',
        publishAudio:true,
      publishVideo:true 
      };
          var subscriber = session.subscribe(event.stream,'sample', subscriberOptions, handleError); 
          $('#sample').attr('data-id',id); 
          $('#sample').addClass('active'); 
      });   


        $('#sample').click(function(){
        if($(this).hasClass('active')){
          var id  = $(this).attr('data-id');          
            $('#temp').html('<div id="'+id+'" class="subscriber"></div>');;
          var subscriber = session.subscribe(event.stream,id, subscriberOptions, handleError); 
          $(this).removeClass('active').html('');
          $('#inner_image').removeClass('hidden');
          }   

          $('#'+subscriber_id).click(function(){  
          subscribers[subscriber_id].subscribeToVideo(false);
          $('#inner_image').addClass('hidden');
          $(this).addClass('active').html('');           
          var id = $(this).attr('id');

          var subscriberOptions = {
          insertMode: 'append',
          width: '100%',
          height: '100%',
          publishAudio:true,
          publishVideo:true 
          };
          var subscriber = session.subscribe(event.stream,'sample', subscriberOptions, handleError); 
          $('#sample').attr('data-id',id); 
          $('#sample').addClass('active'); 
          });   
      
       });


     });




     session.on('sessionDisconnected', function sessionDisconnected(event) {
      console.log('You were disconnected from the session.', event.reason);
    });

     /* Mute the  Video */

     $('#group_video_mute').click(function(){         
      if($(this).hasClass('active')){
        $(this).removeClass('active');                 
        publisher.publishVideo(true);         
      }else{
        $(this).addClass('active');                                
        publisher.publishVideo(false);
      }
        //console.log(stream);
      });      

     /* Reject the Call  */
     $('.vcend').click(function(event) {
      event.preventDefault();  
      session.unpublish(publisher);  
      var group_id  = $('#group_id').val();
      $.post(base_url+'chat/discard_notify',{group_id:group_id},function(res){
      //$('#group_id').val('');
      window.location.reload();

    })
    });
     return false;
   });
}
