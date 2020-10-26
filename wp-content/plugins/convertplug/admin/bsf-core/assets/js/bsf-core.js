jQuery( document ).on('click', '.bsf-envato-form-activation', function(event) {
	form 	 	= jQuery( this );
	product_id 	= form.siblings( 'form input[name="product_id"]' ).val();
	url 		= form.siblings( 'form input[name="url"]' ).val();
	redirect 	= form.siblings( 'form input[name="redirect"]' ).val();
	consent 	= form.siblings( '.bsf-license-consent-container' ).children('input#bsf-license-consent').is(":checked");

	jQuery.ajax({
		url: ajaxurl,
		dataType: 'json',
		data: {
			action: 'bsf_envato_redirect_url',
			product_id: product_id,
			url: url,
			redirect: redirect,
			consent: consent
		}
	})
	.done(function( response ) {
		window.location = response.data.url;
		return true;
	})
	.fail(function(e) {
		return false;
	});

	return false;
});
