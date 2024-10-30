function mareike_printscreen() {
	document.getElementById( 'hider' ).style.display                       = 'none';
	document.getElementById( 'mareike-deny-invoice-dialog' ).style.display = 'none';
}

function mareike_print_invoice(invoice_id) {
	mareike_load_ajax_nw( 'print-invoice', 'invoice-id=' + invoice_id )
}

function mareike_load_invoice(data_id) {
	mareike_load_ajax_nw( 'show-receipt', 'invoice-id=' + data_id )
}