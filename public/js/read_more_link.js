jQuery(document).ready(function( $ ) {
	$('#more').hide();
	$('#lnk_more').click(function() {
		event.preventDefault();
		$('#more').slideToggle("fast");
		$('#lnk_more').hide();
	});
	
	$('#lnk_hide').click(function() {
		event.preventDefault();
		$('#more').slideToggle("fast");
		$('#lnk_more').show();
	});
});