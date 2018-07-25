	
	function navigate(element){
    
  $("#for_audio").hide();
  $("#for_group_audio").hide();
  $("#for_video").hide();
  $("#for_group_video").hide();
  $("#for_screen_share_group").hide();
	$('.text_chat,.profile,.audio,.video,.screen_share').addClass('hidden');
	var page = $(element).attr('page');	
	switch(page) {
    	case 'profile':
       	$('.'+page).removeClass('hidden');
       	$('#'.page).addClass('active');
        	break;  
        case 'text_chat':
       	$('.'+page).removeClass('hidden');
       	$('#'.page).addClass('active');
        	break; 
        case 'audio':
       	$('.'+page).removeClass('hidden');
       	$('#'.page).addClass('active');
        	break; 
         case 'video':
       	$('.'+page).removeClass('hidden');
       	$('#'.page).addClass('active');
        	break;    
         case 'screen_share':
        $('.'+page).removeClass('hidden');
        $('#'.page).addClass('active');
          break; 
        }
        $.post(base_url+'chat/set_nav_bar',{page:page},function(res){
        	//console.log(res);
        });	
   
}


	
