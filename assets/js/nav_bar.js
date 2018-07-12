	
	function navigate(element){
	$('.text_chat,.profile,.audio,.video').addClass('hidden');
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
        }
        $.post(base_url+'chat/set_nav_bar',{page:page},function(res){
        	console.log(res);
        });	
   
}


	
