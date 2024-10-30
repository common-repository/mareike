function mareike_generate_ajax_url(ajaxmethode, params) {
	return ajaxurl + '?action=mareike_show_ajax&&method=' + ajaxmethode + '&' + params;
}
function mareike_load_ajax_nw(ajaxmethode, params='') {
	ajaxurl = mareike_generate_ajax_url( ajaxmethode, params );
	window.open( ajaxurl );
}