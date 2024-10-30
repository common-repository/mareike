function mareike_settings_form_filled() {
	no_errors = true;

	if (document.getElementById( 'receipt_directory' ).value == '') {
		document.getElementById( 'receipt_directory' ).classList.add( 'mareike-error' );
		no_errors = false;
	} else {
		document.getElementById( 'receipt_directory' ).classList.remove( 'mareike-error' );
	}

	return no_errors;
}