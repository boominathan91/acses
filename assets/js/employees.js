$('.btn-link').click(function(){
	var id = $(this).attr('id');
	$(this).addClass('active');	
	if(id == 'staff-grid-view'){
		$('.div-table').addClass('grid-view');
		$('#staff-table-view').removeClass('active');
	}else{		
		$('.div-table').removeClass('grid-view');
		$('#staff-grid-view').removeClass('active');
	}
});