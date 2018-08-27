jQuery(document).ready(function($){
	
	$('.favorites-link a').click(function(e){
		var action = $(this).data('action');
		console.log(action);
		return;
		$.ajax({
			type: 'POST',
			url: favorites.url,
			data: {
				security: favorites.nonce,
				action: 'wfm_' + action,
				postId: favorites.postId
			},
			beforeSend: function() {
				$('.favorites-link a').fadeOut(300, function(){
					$('.favorites-link .favorites-hidden').fadeIn();
				});
			},
			success: function(res){
				$('.favorites-link .favorites-hidden').fadeIn(3000, function(){
					$('.favorites-link').html(res);
					if(action == 'delete') {
						$('.widget_favorites-widget').find('li.cat-item-' + favorites.postId).remove();
					}
				});
				console.log(res);

			},
			error: function(){
				alert('Error');

			}
		});
		e.preventDefault();
	})
})