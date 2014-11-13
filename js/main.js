$(document).ready(function() {
	//$('#single-post .post-content img').overlay();
	$('#single-post .post-content img').parent().each(function() {
		var imageCaption = $(this).parent().find('.wp-caption-text').html();
		var id = 'a' + Math.round(Math.random() * (2000 - 0)) + 0;
		
		$(this).attr('data-lightbox', id);
		$(this).attr('data-title', imageCaption);
		
		/*
		$(this).click(function(event) {
			event.preventDefault();
		});
		*/
	});
	
	$('.gallery').each(function() {	
		var id = $(this).attr('id');
		$(this).find('a').each(function () {
			$(this).attr('data-lightbox', id);
		});
	});
	
	$('#back').click(function() {
		history.back(1);
	});
	
	/*
	$('#single-post .post-content img').each(function() {
		$(this).attr('data-lightbox', 'a' + Math.round(Math.random() * (2000 - 0)) + 0);
	});
	*/
	
	/*
	$('#single-post .post-content img').click(function() {
		$('#overlay-content').html('<img src="' + $(this).attr('src') + '">');
		//$('#overlay-content').css({width: $(this).attr('width'), height: $(this).attr('height')});
		$('#overlay').fadeIn();
	});
	
	$('#overlay, #overlay-content').click(function() {
		$('#overlay').fadeOut();
		$('#overlay-content').html('');
	});*/
});