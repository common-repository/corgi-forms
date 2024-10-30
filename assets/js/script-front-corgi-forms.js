jQuery( function($) {

	/**
	 * Serialize array to object
	 *
	 */
	function serializeArrayToObject( arr ) {

		var obj = {};

		$.each( arr, function() {

			if( obj.hasOwnProperty( this.name ) ) {

				if( ! obj[this.name].push ) {
					obj[this.name] = [obj[this.name]];
				}

				obj[this.name].push( this.value || '' );

			} else {

				obj[this.name] = this.value || '';

			}

	   });

		return obj;

	}

	/**
	 * Form handling on form submit click
	 *
	 */
	$(document).on( 'click', '.corgi-forms-form button', function(e) {

		e.preventDefault();

		// Get current form
		$form = $(this).closest('form');

		// Button loading text
		var button_default_text = $form.find('span.corgi-forms-field-button-text').text();
		var button_loading_text = $form.find('span.corgi-forms-field-button-loading-text').text();

		// Get all form fields
		var data = serializeArrayToObject( $form.serializeArray() );

		// Add action
		data['action'] = 'crfo_form_submission';

		// Set button loading text
		$form.find('input, textarea').attr( 'disabled', true );
		$form.find('button').text( button_loading_text );

		$.post( crfo_ajax_url, data, function( response ) {

			// Format response
			var response = JSON.parse( response );

			/**
			 * Handle error case
			 *
			 */
			if( typeof response.errors != 'undefined' ) {

				// Set button text back to default
				$form.find('input, textarea').attr( 'disabled', false );
				$form.find('button').text( button_default_text ).blur();

				// Add form general error
				if( typeof response.errors.form_error != 'undefined' ) {

					$form.find('.corgi-forms-form-errors').addClass('corgi-forms-form-has-errors').html( response.errors.form_error );

					$('html, body').animate({
						scrollTop : $form.find('.corgi-forms-form-errors').offset().top - 50
					}, 800, 'linear' );
					
				}

				// Add field errors
				if( typeof response.errors.field_errors != 'undefined' ) {

					// Remove errors for all fields
					$form.find('.corgi-forms-field').removeClass('corgi-forms-field-error').find('.corgi-forms-field-errors-wrapper').html('');

					// Add errors for each field that has errors
					for( var index in response.errors.field_errors ) {
						$form.find('.corgi-forms-field[data-name=' + index + ']').addClass('corgi-forms-field-error').find('.corgi-forms-field-errors-wrapper').html( '<p>' + response.errors.field_errors[index] + '</p>' );
					}

				}

			}

			/**
			 * Handle success
			 *
			 */
			if( typeof response.success != 'undefined' ) {

				$form_wrapper = $form.parent();

				// Message response
				if( response.confirmation_type == 'message' ) {

					$form.fadeOut( 400, function() {

						$form.remove();

						$form_wrapper.append( '<div class="corgi-forms-form-success-message">' + response.confirmation_message + '</div>' );

						$form_wrapper.find('.corgi-forms-form-success-message').fadeIn(400);

						$('html, body').animate({
							scrollTop : $form_wrapper.find('.corgi-forms-form-success-message').offset().top - 50
						}, 800, 'linear' );

					});

				}

				// Redirect to page response
				if( response.confirmation_type == 'redirect_page' ) {

					window.location = response.confirmation_redirect_page;

				}

				// Redirect to url response
				if( response.confirmation_type == 'redirect_url' ) {

					window.location = response.confirmation_redirect_url;

				}
				

			}

		});

	});

});