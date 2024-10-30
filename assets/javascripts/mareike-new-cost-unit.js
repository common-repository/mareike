function is_costunit_complete() {
	if (
		document.getElementById( 'costunit-type' ).value == '' ||
		document.getElementById( 'costunit-name' ).value == '' ||
		document.getElementById( 'costunit-email' ).value == '' ||
		document.getElementById( 'costunit-distance' ).value == ''
	) {
		return false;
	}

	if (document.getElementById( 'costunit-type' ).value == '1') {
		if (document.getElementById( 'costunit_begin' ).value == '' ||
			document.getElementById( 'costunit_end' ).value == ''
		) {
			return false;
		}
	}

	return true;
}

function new_event() {
	document.getElementById( 'costunit-type' ).value        = 1;
	document.getElementById( 'decision' ).style.display     = 'none';
	document.getElementById( 'event-line-1' ).style.display = 'table-row';
	document.getElementById( 'event-line-2' ).style.display = 'table-row';
	document.getElementById( 'submit-line' ).style.display  = 'table-row';
}

function new_job() {
	document.getElementById( 'costunit-type' ).value       = 2;
	document.getElementById( 'decision' ).style.display    = 'none';
	document.getElementById( 'submit-line' ).style.display = 'table-row';
}