<?php
/**
 * Plugin Name:  Share Buttons & Analytics by GetSocial
 * Plugin URI: http://getsocial.io
 * Description: Add social media sharing buttons from the most popular networks to track user activity, increase traffic, improve SEO, and follow conversions.
 * Version: 2.0.1
 * Author: Getsocial, S.A.
 * Author URI: http://getsocial.io
 * License: GPL2
 */

include('lib/gs.php');

/* MENU */

add_action( 'admin_menu', 'gs_getsocial_menu' );

function gs_getsocial_menu(){
    $GS = get_gs();

    add_menu_page( 'GetSocial', 'GetSocial', 'manage_options', slug_path('init.php'), '', plugins_url( 'images/on.png', __FILE__ ) );
    add_action( 'admin_init', 'register_gs_settings' );
}

function slug_path($s) {
    $main_slug = 'wp-share-buttons-analytics-by-getsocial/';
    return ($main_slug.$s);
}

add_action( 'wp_ajax_gs_update', 'update_getsocial' );

function update_getsocial() {
    global $wpdb; // this is how you get access to the database

    $GS = get_gs();
    $GS->refreshSite();

    wp_die(); // this is required to terminate immediately and return a proper response
}

function register_gs_settings(){
    register_setting( 'getsocial-gs-settings' , 'gs-api-key' );
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

add_filter('the_content', 'on_content');

function on_content($content) {
    if ( is_single() ):
        $GS = get_gs();

        $groups_active = $GS->is_active('sharing_bar');
        $native_active = $GS->is_active('native_bar');
        $custom_active = $GS->is_active('custom_actions');
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

                $position = $GS->prop('sharing_bar', 'position');

                if($position == 'bottom' || $position == 'both'):
                    $after_content = $groups;
                endif;

                if ( $position == 'top' || $position == 'both' ):
                    $before_content = $groups.'<br/>';
                endif;
            endif;

            if($custom_active):
                $custom = $GS->getCode('custom_actions');

                $position = $GS->prop('custom_actions', 'position');

                if($position == 'bottom' || $position == 'both'):
                    $after_content = $after_content.$custom;
                endif;

                if ( $position == 'top' || $position == 'both' ):
                    $before_content = $before_content.$custom.'<br/>';
                endif;
            endif;

            if($big_counter_bar_active):
                $big_counter = $GS->getCode('social_bar_big_counter');

                $position = $GS->prop('social_bar_big_counter', 'position');

                if($position == 'bottom' || $position == 'both'):
                    $after_content = $after_content.$big_counter;
                endif;

                if ( $position == 'top' || $position == 'both' ):
                    $before_content = $before_content.$big_counter.'<br/>';
                endif;
            endif;

            if($native_active):
                $native = $GS->getCode('native_bar');

                $position = $GS->prop('native_bar', 'position');

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
    if(array_key_exists('app',$atts)){
        return $GS->getCode($atts['app']);
    } else {
        return "";
    }


}
