$(document).ready(function() {
	
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	
	$('.sortable-table tbody tr').css('cursor', 'move');
	$('.sortable-table tbody').sortable({ helper: fixHelper, update: function() {
			
		var order = $(this).sortable('toArray'); 
		
		$.ajax({
		  type: "POST",
		  url: SITE_URL + "admin/products/fields/order",
		  data: {order: order},
		});																 
	}								  
	}).disableSelection();

});