<?php
function videopro_scripts_styles_child_theme() {
	global $wp_styles;
	wp_enqueue_style( 'videopro-parent', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('custom-script',get_stylesheet_directory_uri() . '/script.js' );
}
add_action( 'wp_enqueue_scripts', 'videopro_scripts_styles_child_theme' );

/**
 * Support MyCred plugin
 **/
add_filter('cactus_player_shortcode', 'videopro_child_cactus_player_shortcode_filter', 10, 3);
function videopro_child_cactus_player_shortcode_filter($html, $atts, $content){
	if(shortcode_exists('mycred_sell_this')){
		return do_shortcode('[mycred_sell_this]' . $html . '[/mycred_sell_this]');
	} else {
		return $html;
	}
}

/* Disable VC auto-update */
function videopro_vc_disable_update() {
    if (function_exists('vc_license') && function_exists('vc_updater') && ! vc_license()->isActivated()) {

        remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10);
        remove_filter( 'pre_set_site_transient_update_plugins', array(
            vc_updater()->updateManager(),
            'check_update'
        ) );

    }
}
add_action( 'admin_init', 'videopro_vc_disable_update', 9 );

/**
 * Add a sidebar.
 */
function video_pro_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Trending Videos', 'textdomain' ),
        'id'            => 'trending-sidebar',
        'description'   => __( 'This widget will be use to show top trending videos on page', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );

	 register_sidebar( array(
        'name'          => __( 'History', 'textdomain' ),
        'id'            => 'recent-view-sidebar',
        'description'   => __( 'This widget will be use to show history of the user', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );

	 register_sidebar( array(
        'name'          => __( 'Liked Post', 'textdomain' ),
        'id'            => 'liked-post-sidebar',
        'description'   => __( 'This widget will be use to show history of the user liked post', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'video_pro_widgets_init' );


add_action('wp_ajax_custom_update_usermeta', 'custom_update_usermeta');
add_action('wp_ajax_nopriv_custom_update_usermeta', 'custom_update_usermeta');

function add_post_id_to_user_meta($post_id, $post) {
    if($post->post_status === 'publish' && $post->post_type === 'post') {                   // only fire when published post
        $all_users = get_users();                                                           // get all users
        foreach ($all_users as $user) {
            $user_id = $user->id;

            $user_posts_id = get_user_meta($user_id, 'user_posts_id', true);                // get current id's
            if(isset($user_posts_id)) {
                $user_posts_id_to_array = explode(",", $user_posts_id);           // string to array
                $emptyRemovedArray = array_filter($user_posts_id_to_array);                 // removed empty values
                $unique_posts = array_unique($emptyRemovedArray);                           // removed duplicate values
                array_push($unique_posts, $post_id);                                // added new post_id to array after published post
                $user_posts_id_string = implode(",", $unique_posts);                    // array to string
                update_user_meta($user_id, 'user_posts_id', $user_posts_id_string);            // updated user meta
            }

        }
    } else {
        return;
    }
}
add_action( 'wp_insert_post', 'add_post_id_to_user_meta', 10, 2 );              // add new post id to user_meta after published post

add_action( 'wp_ajax_clear_meta', 'clear_meta_callback' );
add_action( 'wp_ajax_nopriv_clear_meta', 'clear_meta_callback' );

function clear_meta_callback() {
    delete_user_meta(get_current_user_id(), 'user_posts_id');
    wp_die();
}
add_action( 'wp_ajax_clear_meta', 'clear_meta_callback' );