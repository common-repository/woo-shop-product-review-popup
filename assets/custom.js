jQuery(document).ready(function () {
	jQuery(document).on("click", "a.openform", function(){ 
		var productID = jQuery(this).attr('id');
		jQuery.ajax({
			type: "POST",
			url: reviewAjax.ajaxurl,
			data: 
			{
				action : 'woo_shop_product_review_form',
					productID : productID
			},
			success: function(data){
				 jQuery.fancybox(data,{
							'transitionIn'      : 'none',
							'transitionOut'     : 'none',
							'type': "html",
							'hideOnContentClick': false
			      		 });
			}
		});
	});
});

	
	
	
	
		/*e.preventDefault();
		var productID = jQuery(this).attr('id');
		jQuery.ajax({
				url : reviewAjax.ajax_url,
				type : 'post', 
				data : {
					action : 'woo_shop_product_review_form',
					productID : productID
				},
				success : function( response ) {
					/*jQuery.fancybox(response,{
							'transitionIn'      : 'none',
							'transitionOut'     : 'none',
							type: "html",
							'content' : response,
							'hideOnContentClick': false
			      		 });
						 alert(response);

					/*jQuery.fancybox(response, {
						type: "html"
					});
				}
		});
	});*/
