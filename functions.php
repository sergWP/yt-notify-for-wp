<?php
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
