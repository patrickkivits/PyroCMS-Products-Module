$(document).ready(function() {
    
	$('.progress').hide();
	
	var bar = $('.bar');
	var percent = $('.percent');
	var status = $('#status');
	   
	$('#ajax-form-upload').ajaxForm({
		beforeSend: function() {
			status.empty();
			var percentVal = '0%';
			bar.width(percentVal)
			percent.html(percentVal);
			$('.progress').show();
		},
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		complete: function(xhr) {
			
			$('.progress').hide();
			
			// Delete old image first
			$.post(SITE_URL + 'admin/products/ajax_delete_image/', {
				thumbnail: $('input[name="thumbnail"]').val(),
				image: $('input[name="image"]').val(),
				csrf_hash_name: $.cookie("csrf_cookie_name")
			},
			function(data) {});
			
			var obj = jQuery.parseJSON(xhr.responseText);
	
			$('input[name="thumbnail"]').val(obj.thumbnail);
			$('input[name="image"]').val(obj.image);
			$('#thumbnail img').attr('src', obj.upload_path + obj.thumbnail);
		}
	}); 
	
	$('a#delete-image-button').live("click", function(e){
			$.post(SITE_URL + 'admin/products/ajax_delete_image/', {
				thumbnail: $('input[name="thumbnail"]').val(),
				image: $('input[name="image"]').val(),
				csrf_hash_name: $.cookie("csrf_cookie_name")
			},
			function(data) {
				
				var obj = jQuery.parseJSON(data);
				
				$('input[name="thumbnail"]').val('');
				$('input[name="image"]').val('');
				$('#thumbnail img').attr('src', 'http://placehold.it/'+obj.width+'x'+obj.height);
			});
			return false;
	});  

});