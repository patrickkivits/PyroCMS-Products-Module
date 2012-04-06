function clearForm()
{
	$('[name="product"]').val(0);
	$('[name="product"]').trigger("liszt:updated");
	$('[name="old_price"]').val('');
	$('[name="new_price"]').val('');
	$('a#add-product-button').show();
	$('a#edit-product-button').hide();
	$('a#cancel-product-button').hide();
	$('#product-dropdown-container').show();
	$('#product-name').html('');
}
function validation()
{	
	$('.alert').hide();
	$('#content-body').prepend('<div class="alert error"><p>Something went wrong.</p></div>');
}

$(document).ready(function() {
	
	// Load all products
	$('#product-container').load(SITE_URL + 'admin/products/specials/ajax_get_products/' + $('[name="special"]').val(), function() {
	  
		  // Edit products
		$('a#edit-product').live("click", function(e){
			$.get(SITE_URL + 'admin/products/specials/ajax_get_special_product/', {
				id: $(this).data('id')
			},
			function(data){
				// Hide dropdown and show name of product
				$('#product-dropdown-container').hide();
				$('#product-name').html('<strong style="padding-left: 10px;">'+data[0].name+'</strong>');
				
				// Set value of inputs
				$('[name="special_x_product"]').val(data[0].id);
				$('[name="old_price"]').val(data[0].old_price.toString().replace(/\./g, ','));
				$('[name="new_price"]').val(data[0].new_price.toString().replace(/\./g, ','));
				
				// Hide an show buttons
				$('a#add-product-button').hide();
				$('a#edit-product-button').show();
				$('a#cancel-product-button').show();
			}, "json");
			return false;
	   });
	   
	   $('a#delete-product').live("click", function(e){
			$.post(SITE_URL + 'admin/products/specials/ajax_delete_product/', {
				id: $(this).data('id')
			},
			function(data) {
				// Reload the products
				clearForm();
				$('#product-container').load(SITE_URL + 'admin/products/specials/ajax_get_products/' + $('[name="special"]').val());
			});
			return false;
	   });  
		   
		
		// Add products
		$('a#add-product-button').live("click", function(e){
			// Define all data
			var inputSpecial = $('[name="special"]').val();
			var inputProduct = $('[name="product"]').val();
			var inputOldPrice = $('[name="old_price"]').val();
			var inputNewPrice = $('[name="new_price"]').val();
			
			if(inputSpecial && inputProduct && inputNewPrice) {
				$.post(SITE_URL + 'admin/products/specials/ajax_add_product/', {
					special: inputSpecial,
					product: inputProduct,
					old_price: inputOldPrice,
					new_price: inputNewPrice
				},
				function(data) {
					// Reload the products
					clearForm();
					$('#product-container').load(SITE_URL + 'admin/products/specials/ajax_get_products/' + $('[name="special"]').val());
				});
			} else {
				validation();	
			}
			return false;
		});
		
		// Add products
		$('a#edit-product-button').live("click", function(e){
			// Define all data
			var inputSpecialxProduct = $('[name="special_x_product"]').val();
			var inputOldPrice = $('[name="old_price"]').val();
			var inputNewPrice = $('[name="new_price"]').val();
		
			if(inputSpecialxProduct && inputNewPrice) {
				$.post(SITE_URL + 'admin/products/specials/ajax_edit_product/', {
					id: inputSpecialxProduct,
					old_price: inputOldPrice,
					new_price: inputNewPrice
				},
				function(data) {
					// Reload the products
					clearForm();
					$('#product-container').load(SITE_URL + 'admin/products/specials/ajax_get_products/' + $('[name="special"]').val());
				});
			} else {
				validation();	
			}
			return false;
		});
	   
		// Clear form to add new product
		 $('a#cancel-product-button').live("click", function(e){
			clearForm();
			return false;
		});
		
	});
});