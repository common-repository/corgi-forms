jQuery( function($) {

    /*
     * Strips one query argument from a given URL string
     *
     */
    function remove_query_arg( key, sourceURL ) {

        var rtn = sourceURL.split("?")[0],
            param,
            params_arr = [],
            queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";

        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }

            rtn = rtn + "?" + params_arr.join("&");

        }

        if(rtn.split("?")[1] == "") {
            rtn = rtn.split("?")[0];
        }

        return rtn;
    }


    /*
     * Adds an argument name, value pair to a given URL string
     *
     */
    function add_query_arg( key, value, sourceURL ) {

        return sourceURL + '&' + key + '=' + value;

    }
    

	/******************************************************************/
	/* Tab Navigation
	/******************************************************************/
	$('.crfo-nav-tab').on( 'click', function(e) {
		e.preventDefault();

		// Nav Tab activation
		$('.crfo-nav-tab').removeClass('crfo-active').removeClass('nav-tab-active');
		$(this).addClass('crfo-active').addClass('nav-tab-active');

		// Show tab
		$('.crfo-tab').removeClass('crfo-active');

		var nav_tab = $(this).attr('data-tab');
		$('.crfo-tab[data-tab="' + nav_tab + '"]').addClass('crfo-active');
		$('input[name=active_tab]').val( nav_tab );

        // Change http referrer
        $_wp_http_referer = $('input[name=_wp_http_referer]');

        var _wp_http_referer = $_wp_http_referer.val();
        _wp_http_referer = remove_query_arg( 'tab', _wp_http_referer );
        $_wp_http_referer.val( add_query_arg( 'tab', $(this).attr('data-tab'), _wp_http_referer ) );
		
	});


	/******************************************************************/
    /* Show and hide back-end settings tool-tips
	/******************************************************************/
	$(document).on( 'mouseenter', '.crfo-settings-field-tooltip-icon', function() {
		$(this).siblings('div').css('opacity', 1).css('visibility', 'visible');
	});
	$(document).on( 'mouseleave', '.crfo-settings-field-tooltip-icon', function() {
		$(this).siblings('div').css('opacity', 0).css('visibility', 'hidden');
	});

	$(document).on( 'mouseenter', '.crfo-settings-field-tooltip-wrapper.crfo-has-link', function() {
		$(this).find('div').css('opacity', 1).css('visibility', 'visible');
	});
	$(document).on( 'mouseleave', '.crfo-settings-field-tooltip-wrapper.crfo-has-link', function() {
		$(this).find('div').css('opacity', 0).css('visibility', 'hidden');
	});


    /******************************************************************/
    /* Display settings fields based on checkbox field conditional value
    /******************************************************************/

    // Handle on page load
    $('.crfo-settings-field[data-conditional]').each( function() {

        // Handle checkboxes, because they are special
        if( $( '.crfo-settings-field input[type="checkbox"][name="' + $(this).data('conditional') + '"]' ).is(':checked') )
            $(this).show();

        // Handle rest of the fields if conditional value is set
        if( $( '.crfo-settings-field [name="' + $(this).data('conditional') + '"]' ).attr('type') != 'checkbox' ) {

            if( typeof $(this).data('conditional-value') != 'undefined' ) {

                if( $( '.crfo-settings-field [name="' + $(this).data('conditional') + '"]' ).val() == $(this).data('conditional-value') )
                    $(this).show();

            } else {

                if( $( '.crfo-settings-field [name="' + $(this).data('conditional') + '"]' ).val() != 0 || $( '.crfo-settings-field [name="' + $(this).data('conditional') + '"]' ).val() != '' )
                    $(this).show();

            }

        }

    });

    // Handle on field value change
    $('.crfo-settings-field *').change( function() {

        $this = $(this);

        // Handle checkboxes
        if( $this.attr('type') == 'checkbox' ) {

            if( $this.is(':checked') )
                $('.crfo-settings-field[data-conditional="' + $this.attr('name') + '"]').fadeIn();
            else
                $('.crfo-settings-field[data-conditional="' + $this.attr('name') + '"]').fadeOut();            

        // Handle rest of the fields
        } else {

            $('.crfo-settings-field[data-conditional="' + $this.attr('name') + '"]:not([data-conditional-value="' + $this.val() + '"])').hide();

            $('.crfo-settings-field[data-conditional="' + $this.attr('name') + '"][data-conditional-value="' + $this.val() + '"]').show();

        }
        
    });


    /******************************************************************/
    /* Show / hide form field settings fields
    /******************************************************************/
    $('.crfo-form-field-settings-name').click( function(e) {

        e.preventDefault();

        $(this).parent().toggleClass('crfo-active');
        $(this).siblings('.crfo-form-field-settings-inner').animate({
            height: "toggle",
            opacity: "toggle"
        }, 400 );

    });

    /******************************************************************/
    /* Disable a buttons
    /******************************************************************/
    $('a.crfo-button-primary.disabled').click( function(e) {
        e.preventDefault();
    });


});