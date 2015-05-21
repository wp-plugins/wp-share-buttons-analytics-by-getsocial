<?php
/**
 * Plugin Name:  Share Buttons by GetSocial.io
 * Plugin URI: http://getsocial.io
 * Description: Share Buttons by GetSocial.io is a freemium WordPress plugin that enables you to track social shares on Wordpress. Provide beautiful wordpress sharing buttons, track how many shares were made in each post and see how much traffic, conversions and shares each post generated. Optimize your SEO and increase social shares with GetSocial.io.
 * Version: 2.6
 * Author: Getsocial, S.A.
 * Author URI: http://getsocial.io
 * License: GPL2
 */

include('lib/gs.php');

/* MENU */

add_action( 'admin_menu', 'gs_getsocial_menu' );

function gs_getsocial_menu(){
    $GS = get_gs();

    add_menu_page( 'GetSocial', 'GetSocial', 'manage_options', slug_path('init.php'), '', 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMCAyMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjAgMjAiPjxwYXRoIGZpbGw9IiMzMzlFRDUiIGQ9Ik0xOCAwaC0xNmMtMS4xIDAtMiAuOS0yIDJ2MTZjMCAxLjEuOSAyIDIgMmgxNmMxLjEgMCAyLS45IDItMnYtMTZjMC0xLjEtLjktMi0yLTJ6bS0xMS45IDE0LjZjLTIgMC00LjEtMS4yLTQuMS0zLjkgMC0xLjMuNi0yLjcgMS42LTMuN3MyLjMtMS42IDMuOS0xLjZjMS44IDAgMi45LjcgMy42IDEuNWwtMS41IDEuM2MtLjUtLjYtMS4yLTEtMi4zLTEtLjkgMC0xLjcuNC0yLjMgMS0uNi42LTEgMS41LTEgMi41IDAgMS40IDEgMi4xIDIuMiAyLjEuNyAwIDEuMi0uMiAxLjYtLjNsLjQtMS41aC0xLjlsLjQtMS43aDMuOGwtMS4yIDQuNGMtLjkuNi0xLjkuOS0zLjIuOXptOC45LTUuMmMxLjIuNSAyIDEuMSAyIDIuMyAwIC43LS4zIDEuNC0uNyAxLjktLjYuNi0xLjUgMS0yLjUgMS0xLjYgMC0yLjgtLjUtMy42LTEuNWwxLjMtMS4xYy43LjggMS41IDEuMSAyLjQgMS4xLjggMCAxLjQtLjQgMS40LTEuMSAwLS41LS4zLS44LTEuNS0xLjMtMS4xLS41LTItMS0yLTIuMyAwLS43LjMtMS40LjctMS45LjYtLjYgMS41LTEgMi42LTEgMS4zIDAgMi4zLjQgMyAxLjJsLTEuMyAxLjNjLS42LS42LTEuMi0uOS0yLS45LS45IDAtMS40LjUtMS40IDEgMCAuNi41LjggMS42IDEuM3oiLz48L3N2Zz4=' );
    add_action( 'admin_init', 'register_gs_settings' );
}

function slug_path($s) {
    $main_slug = 'wp-share-buttons-analytics-by-getsocial/';
    return ($main_slug.$s);
}

add_action( 'wp_ajax_gs_update', 'update_getsocial' );
add_action( 'wp_ajax_gs_update_with_values', 'update_getsocial_with_values' );

function update_getsocial() {
    global $wpdb; // this is how you get access to the database

    $GS = get_gs();
    $GS->refreshSite();

    wp_die(); // this is required to terminate immediately and return a proper response
}

function update_getsocial_with_values() {
    global $wpdb; // this is how you get access to the database

    $GS = get_gs();

    $GS->refreshSite($_POST['response']);

    wp_die(); // this is required to terminate immediately and return a proper response
}


function register_gs_settings(){
    register_setting( 'getsocial-gs-settings' , 'gs-api-key' );
    register_setting( 'getsocial-gs-settings' , 'gs-place' );
    // register_setting( 'getsocial-gs-settings' , 'gs-buttons-position' );
    register_setting( 'getsocial-gs-settings' , 'gs-lang' );

    foreach(array('group', 'floating') as $app):
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-active' );
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-network-fb' );
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-network-tw' );
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-network-pn' );
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-network-gp' );
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-template' );
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-size' );
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-counter' );
        register_setting( 'getsocial-gs-'.$app , 'gs-'.$app.'-position' );
    endforeach;


    register_setting( 'getsocial-gs-custom-expressions' , 'gs-custom-expression-active' );
    register_setting( 'getsocial-gs-custom-expressions' , 'gs-custom-expression-position' );
}

function get_gs(){
    return new GS(get_option('gs-api-key'),
                    get_option('gs-identifier'),
                    get_option('gs-lang'));
}

add_action('wp_head','add_gs_lib');

function add_gs_lib(){
    $GS = get_gs();
    echo $GS->getLib();
}

if ( class_exists( 'WooCommerce' ) ) {
    add_action( 'woocommerce_single_product_summary', 'on_product_after_content', 55 );
}

add_filter('the_content', 'on_post_content');

function on_product_after_content($content) {
    echo add_buttons_to_content($content, true, 'bottom');
}


function on_post_content($content) {
    return add_buttons_to_content($content, false);
}

function add_buttons_to_content($content, $woocomerce, $wooposition = null){
    global $post;
    // $meta_values = get_post_meta( $post->post_id, '_my_meta_getsocialio_hide', true );

    $getsocial_meta = get_post_custom();

    if(isset($getsocial_meta['_my_meta_getsocialio_hide'])){
        $hide_bars = $getsocial_meta['_my_meta_getsocialio_hide'][0];

        if($hide_bars == 1){
            return $content;
        }
    }

    if(is_singular('page') && $post->post_type != 'page'){
        return $content;
    }

    if(!$woocomerce && $post->post_type == 'product'){
        return $content;
    }

    $places = get_option('gs-place');

    $condition = true;

    if($places == null || $places == 'place-all'):
        $condition = (is_single() || is_page());
    elseif ($places == 'place-posts'):
        $condition = is_single();
    elseif ($places == 'place-pages'):
        $condition = is_page();
    elseif ($places == 'only-shortcodes'):
        $condition = false;
    endif;

    if ( $condition ):
        $GS = get_gs();

        $groups_active = $GS->is_active('sharing_bar');
        $native_active = $GS->is_active('native_bar');
        $custom_active = $GS->is_active('custom_actions');
        $price_alert_active = $GS->is_active('price_alert');
        $big_counter_bar_active = $GS->is_active('social_bar_big_counter');
        //
        $before_content = "";
        $after_content = "";

        $custom_content = $content;

        //
        if(!is_feed() && !is_home()):
        // if(!is_home()):

            if($groups_active):
                $groups = $GS->getCode('sharing_bar');

                $position = ($wooposition != null ? $wooposition : $GS->prop('sharing_bar', 'position'));

                if($position == 'bottom' || $position == 'both'):
                    $after_content = $groups;
                endif;

                if ( $position == 'top' || $position == 'both' ):
                    $before_content = $groups.'<br/>';
                endif;
            endif;

            if($price_alert_active && $wooposition):

                $product = new WC_Product( get_the_ID() );
                $price = $product->price;

                $price_alert_button = $GS->getCode('price_alert', $price, get_woocommerce_currency_symbol());

                $position = $wooposition;

                $after_content = $price_alert_button;
            endif;

            if($custom_active):
                $custom = $GS->getCode('custom_actions');

                $position = ($wooposition != null ? $wooposition : $GS->prop('custom_actions', 'position'));

                if($position == 'bottom' || $position == 'both'):
                    $after_content = $after_content.$custom;
                endif;

                if ( $position == 'top' || $position == 'both' ):
                    $before_content = $before_content.$custom.'<br/>';
                endif;
            endif;

            if($big_counter_bar_active):
                $big_counter = $GS->getCode('social_bar_big_counter');

                $position = ($wooposition != null ? $wooposition : $GS->prop('social_bar_big_counter', 'position'));

                if($position == 'bottom' || $position == 'both'):
                    $after_content = $after_content.$big_counter;
                endif;

                if ( $position == 'top' || $position == 'both' ):
                    $before_content = $before_content.$big_counter.'<br/>';
                endif;
            endif;

            if($native_active):
                $native = $GS->getCode('native_bar');

                $position = ($wooposition != null ? $wooposition : $GS->prop('native_bar', 'position'));

                if($position == 'bottom' || $position == 'both'):
                    $after_content = $after_content.$native;
                endif;

                if ( $position == 'top' || $position == 'both' ):
                    $before_content = $before_content.$native.'<br/>';
                endif;
            endif;

            $custom_content = $before_content.$custom_content.$after_content;
    	endif;

    	return $custom_content;
    else:
        return $content;
    endif;
}

add_shortcode( 'getsocial', 'gs_bars_shortcode' );

function gs_bars_shortcode($atts) {
    $GS = get_gs();
    // if no type defined
    if(array_key_exists('app',$atts) && (is_single() || is_page())){
        return $GS->getCode($atts['app']);
    } else {
        return "";
    }
}

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function getsocialio_add_meta_box_settings() {

	$screens = array( 'post', 'page' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'getsocialio_settings',
			__( 'GetSocial', 'getsocialio_textdomain' ),
			'getsocialio_meta_box_callback',
			$screen,
            'side'
		);
	}
}
add_action( 'add_meta_boxes', 'getsocialio_add_meta_box_settings' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function getsocialio_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'getsocialio_meta_box', 'getsocialio_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_my_meta_getsocialio_hide', true );
    $checked = (esc_attr( $value ) == "1") ? 'checked' : '';

    echo '<input type="checkbox" id="getsocialio_hide" name="getsocialio_hide" value="1"' . $checked . ' />';
    echo '<label for="">';
	_e( ' Hide social bars?', 'getsocialio_textdomain' );
	echo '</label>';
    echo '<br/><br/><p class="howto"><i>Limited to Horizontal Bars</i></p>';

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function getsocialio_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['getsocialio_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['getsocialio_meta_box_nonce'], 'getsocialio_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['getsocialio_hide'] ) ) {
		$my_data = 0;
	} else {
        // Sanitize user input.
        $my_data = sanitize_text_field( $_POST['getsocialio_hide'] );
    }

	// Update the meta field in the database.
	update_post_meta( $post_id, '_my_meta_getsocialio_hide', $my_data );
}

add_action( 'save_post', 'getsocialio_save_meta_box_data' );
