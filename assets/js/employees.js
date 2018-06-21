$('.staff-table-view').hide();
$('.btn-link').click(function(){
	var id = $(this).attr('id');
	$(this).addClass('active');	
	if(id == 'staff-grid-view'){
		$('.staff-grid-view').show();
		$('.staff-table-view').hide();
		$('#staff-table-view').removeClass('active');
	}else{		
		$('.staff-table-view').show();
		$('.staff-grid-view').hide();
		$('#staff-grid-view').removeClass('active');
	}
});