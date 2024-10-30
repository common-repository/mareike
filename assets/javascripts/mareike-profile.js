function form_filled() {
	no_errors = true;

	if ( ! mareike_is_valid_iban()) {
		document.getElementById( 'account_iban' ).classList.add( 'mareike-error' );
		no_errors = false;
	} else {
		document.getElementById( 'account_iban' ).classList.remove( 'mareike-error' );
	}

	if ( ! mareike_is_valid_email( document.getElementById( 'email' ).value )) {
		document.getElementById( 'email' ).classList.add( 'mareike-error' );
		no_errors = false;
	} else {
		document.getElementById( 'email' ).classList.remove( 'mareike-error' );
	}

	if (document.getElementById( 'first_name' ).value == '') {
		document.getElementById( 'first_name' ).classList.add( 'mareike-error' );
		no_errors = false;
	} else {
		document.getElementById( 'first_name' ).classList.remove( 'mareike-error' );
	}

	if (document.getElementById( 'last_name' ).value == '') {
		document.getElementById( 'last_name' ).classList.add( 'mareike-error' );
		no_errors = false;
	} else {
		document.getElementById( 'last_name' ).classList.remove( 'mareike-error' );

	}

	if (document.getElementById( 'account_owner' ).value == '') {
		document.getElementById( 'account_owner' ).classList.add( 'mareike-error' );
		no_errors = false;
	} else {
		document.getElementById( 'account_owner' ).classList.remove( 'mareike-error' );
	}

	return no_errors;
}