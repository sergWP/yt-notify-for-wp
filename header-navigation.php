<a class="bell_action" href="<?php echo get_site_url()?>/subscriptions/">
	<div class="notify">
	    <?php
	    $current_user_channels = get_user_meta(get_current_user_id(), 'subscribe_channel_id', true);    // meta channels id

	    $user_posts_id = get_user_meta(get_current_user_id(), 'user_posts_id', true);                   // meta post id
	    $user_posts_id_to_array = explode(",", $user_posts_id);
	    $unique_user_posts_array = array_unique($user_posts_id_to_array);
	    $emptyRemoved = array_filter($unique_user_posts_array);

	//  var_dump($emptyRemoved);

	    // WP_Query arguments
	    $args = array(
		'post_type' => array('post'),
		'posts_per_page' => '-1',
		'post__in' => $emptyRemoved,
		'meta_query' => array(
		    'book_color' => array(
			'key'     => 'channel_id',
			'value'   => $current_user_channels,
			'compare' => 'IN',
		    ),
		),
	    );

	    // The Query
	    $query = new WP_Query($args);

	    // The Loop
	    if ($query->have_posts() && count($emptyRemoved) > 1) {
	//                                        while ($query->have_posts()) {
	//                                            $query->the_post();
	//                                            the_title();
	//                                        }
		echo $query->post_count;
	    } else {
		echo '0';
	    }

	    // Restore original Post Data
	    wp_reset_postdata();
	    ?>
	</div>
	<div class="bell-icon">
	<svg id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
	    <g>
		<path d="m256 512c30.692 0 57.122-18.539 68.719-45h-137.438c11.597 26.461 38.028 45 68.719 45z"/>
		<path d="m411 247.862v-32.862c0-69.822-46.411-129.001-110-148.33v-21.67c0-24.813-20.187-45-45-45s-45 20.187-45 45v21.67c-63.59 19.329-110 78.507-110 148.33v32.862c0 61.332-23.378 119.488-65.827 163.756-4.16 4.338-5.329 10.739-2.971 16.267s7.788 9.115 13.798 9.115h420c6.01 0 11.439-3.587 13.797-9.115s1.189-11.929-2.97-16.267c-42.449-44.268-65.827-102.425-65.827-163.756zm-140-187.134c-4.937-.476-9.94-.728-15-.728s-10.063.252-15 .728v-15.728c0-8.271 6.729-15 15-15s15 6.729 15 15z"/><path d="m451 215c0 8.284 6.716 15 15 15s15-6.716 15-15c0-60.1-23.404-116.603-65.901-159.1-5.857-5.857-15.355-5.858-21.213 0s-5.858 15.355 0 21.213c36.831 36.831 57.114 85.8 57.114 137.887z"/><path d="m46 230c8.284 0 15-6.716 15-15 0-52.086 20.284-101.055 57.114-137.886 5.858-5.858 5.858-15.355 0-21.213-5.857-5.858-15.355-5.858-21.213 0-42.497 42.497-65.901 98.999-65.901 159.099 0 8.284 6.716 15 15 15z"/>
	    </g>
	</svg>
	</div>
</a>
