<?php



function favorites_dashboard_widget() {
	wp_add_dashboard_widget('favorite_widget', 'List Of Favorites', 'show_dashboard_widget');
}

function show_dashboard_widget() {
	$img_src = plugins_url('/images/loader.gif', __FILE__);
	$user = wp_get_current_user();
	$favorites = get_user_meta($user->ID, 'favorites');
	$favorites = array_reverse($favorites);
	if(!$favorites){
		echo 'No Favorites';
		return;
	}
	echo '<ul>';
	foreach($favorites as $favorite){
		echo '<li class="cat-item cat-item-' . $favorite . '">
				<a href="' . get_permalink($favorite) . '" target="_blank">' . get_the_title($favorite) . '</a>
				<span><a href="#" data-post="' . $favorite . '" class="favorites-dash">&#10008</a></span>
				<span class="favorites-hidden"><img src="' . $img_src . '" alt="" ></span>
			 </li>';
		
	}
	echo '</ul>';
	echo '<div class="favorites-delete-all">
			<button class="button button-primary" id="favorites-delete-all">Delete All</button>
			<span class="favorites-hidden"><img src="' . $img_src . '" alt="" ></span>
		</div>';
	
}


function favorites_content($content) {
	if(!is_single() || !is_user_logged_in()) return $content;
	$img_src = plugins_url('/images/loader.gif', __FILE__);
	
	global $post;
	if(is_favorites($post->ID)) {
		return '<span class="favorites-link">
				<span class="favorites-hidden">
					<img src="' . $img_src . '" alt="" >
				</span>
				<a data-action="delete" href="#">Delete from favorites</a>
			</span>' .$content;
	}
	return '<span class="favorites-link">
				<span class="favorites-hidden">
					<img src="' . $img_src . '" alt="" >
				</span>
				<a data-action="add" href="#">Add to favorites</a>
			</span>' .$content;
}

function favorites_admin_scripts($hook) {
	if($hook != 'index.php') return;
	wp_enqueue_script('favorites-admin-scripts', plugins_url('/js/favorites-admin-script.js', __FILE__), array('jquery'), null, true);
	wp_enqueue_style('favorites-admin-style', plugins_url('/css/favorites-admin-style.css', __FILE__));
	wp_localize_script('favorites-admin-scripts', 'favorites', ['nonce' => wp_create_nonce('nonce-favorites')]);
}


function favorites_scripts() {
	if(!is_user_logged_in()) return;
	wp_enqueue_script('favorites-scripts', plugins_url('/js/favorites-script.js', __FILE__), array('jquery'), null, true);
	wp_enqueue_style('favorites-styles', plugins_url('/css/favorites-style.css', __FILE__));
	global $post;
	wp_localize_script('favorites-scripts', 'favorites', ['url' => admin_url('admin-ajax.php'),
					  'nonce' => wp_create_nonce('nonce-favorites'), 'postId' => $post->ID]);
}

//Add post to favorites list
function wp_ajax_add(){
	if( !wp_verify_nonce( $_POST['security'], 'nonce-favorites')){
		wp_die('Security error');
	}
	$post_id = (int)$_POST['postId'];
	$user = wp_get_current_user();
	
	 if(is_favorites($post_id)) wp_die();
	
	if(add_user_meta($user->ID, 'favorites', $post_id)){
		wp_die('Added');

	}
		
	wp_die('Request done');
}

//Function for button DELETE ALL
function wp_ajax_delete_all() {
	if( !wp_verify_nonce( $_POST['security'], 'nonce-favorites')){
		wp_die('Security error');
	}
	$user = wp_get_current_user();
	
	if(delete_metadata('user', $user->ID, 'favorites')) {
		wp_die('List of your favorites is clear');
		
	}else{
		wp_die('Error');
	}
}

//Function for icon X DELETE 
function wp_ajax_delete(){
	if( !wp_verify_nonce( $_POST['security'], 'nonce-favorites')){
		wp_die('Security error');
	}
	$post_id = (int)$_POST['postId'];
	$user = wp_get_current_user();
	
	if(!is_favorites($post_id)) wp_die();
	
	if(delete_user_meta($user->ID, 'favorites', $post_id)) {
		wp_die('Deleted');
	}	
	wp_die('Something wrong!');
}
function is_favorites($post_id){
	$user = wp_get_current_user();
	$favorites = get_user_meta($user->ID, 'favorites');
	foreach($favorites as $favorite){
		if($favorite == $post_id) return true;
	}
		return false;
}
