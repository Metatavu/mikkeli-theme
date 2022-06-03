(function( $ ) {
	$(function() {
		/*
		var url = MyAutocomplete.url + "?action=mikkeli_live_search";
		$( "#search-form-2" ).autocomplete({
			source: url,
			delay: 500,
			minLength: 3
		});*/
		$('#search-form-2').autocomplete({
			source: function(request, response) {
				$.ajax({
					dataType: 'json',
					url: MyAutocomplete.url,
					data: {
						term: request.term,
						action: 'mikkeli_live_search',
					},
					success: function(data) {
						response(data);
					}
				});
			},
			select: function(event, ui) {
				window.location.href = ui.item.link;
			},
		});
	});

})( jQuery );