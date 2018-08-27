jQuery(document).ready(function($){
	$('.favorites-dash').click(function(e){
		e.preventDefault();
		if(!confirm('Delete favorite post?')) return false;
		var post = $(this).data('post'),
			parent = $(this).parent(),
			loader = parent.next(),
			li = $(this).closest('li');
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				security: favorites.nonce,
				action: 'wfm_del',
				postId: post
			},
			beforeSend: function() {
				parent.fadeOut(300, function(){
					loader.fadeIn();
				});
			},
			success: function(res){
				loader.fadeIn(3000, function(){
					li.html(res);
				});
				console.log(res);

			},
			error: function(){
				alert('Error');

			}
		});
		
		
	});
	
	$('#favorites-delete-all').click(function(e){
		e.preventDefault();
		if( !confirm('Delete all favorites?')) return false;
		var $this = $(this),
			loader = $this.next(),
			parent = $this.parent(),
			list = parent.prev();
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				security: favorites.nonce,
				action: 'wfm_del_all'
			},
			beforeSend: function() {
				$this.fadeOut(300, function(){
					loader.fadeIn();
				});
			},
			success: function(res){
				loader.fadeIn(300, function(){
					if(res === 'List of your favorites is clear'){
						parent.html(res);
						list.fadeOut();
					}else{
						$this.fadeIn();
						alert(res);
					}
				});
				console.log(res);

			},
			error: function(){
				alert('Error');

			}
		});
	});
});