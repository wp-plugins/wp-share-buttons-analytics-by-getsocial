<?php
/**
 * Plugin Name:  WP Share Buttons & Analytics by GetSocial
 * Plugin URI: http://getsocial.io
 * Description: A brief description of the Plugin.
 * Version: 1.1
 * Author: Getsocial, S.A.
 * Author URI: http://getsocial.io
 * License: A "Slug" license name e.g. GPL2
 */

include('lib/gs.php');

/* MENU */

add_action( 'admin_menu', 'gs_getsocial_menu' );

function gs_getsocial_menu(){
    $GS = get_gs();

    $needs_update = $GS->needs_update() == '0' ? 'on' : 'off';

    add_menu_page( 'GetSocial', 'GetSocial', 'manage_options', slug_path('init.php'), '', plugins_url( 'images/on.png', __FILE__ ) );
    add_action( 'admin_init', 'register_gs_settings' );
}

function slug_path($s) {
    $main_slug = 'wp-share-buttons-analytics-by-getsocial/';
    return ($main_slug.$s);
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
                    get_option('gs-elements'),
                    get_option('gs-lang'));
}

add_action('wp_head','add_gs_lib');

function add_gs_lib(){
    $GS = get_gs();
    echo $GS->getLib();
}

add_filter('the_content', 'on_content');
add_action('wp_footer', 'on_all_site');

function on_content($content) {
    if ( is_single() ):
        $GS = get_gs();

        $groups_active = get_option('gs-group-active') == 1;
        $custom_active = get_option('gs-custom-expression-active') == 1;
        //
        $groups = "";
        $buttons = "";

        $custom_content = $content;

        //
        if(!is_feed() && !is_home()):
            if($groups_active):
                $groups .= $GS->getGroup();

                $position = get_option('gs-group-position');

                if($position != 2 || $position != 3 ):
                    if($position == 0 ):
                        $custom_content = $custom_content.$groups;
                    elseif ( $position == 1 ):
                        $custom_content = $groups.'<br/>'.$custom_content;
                    elseif ( $position == 4 ):
                        $custom_content = $groups.'<br/>'.$custom_content.$groups;
                    endif;
                else:
                    $custom_content = $groups.$content;
                endif;
            endif;

            if($custom_active):
                foreach($GS->getElements() as $id => $action):
        		    $buttons .= $GS->getButton($id, $action);
                endforeach;

                $position = get_option('gs-custom-expression-position');

                if($position == 0):
                    $custom_content = $custom_content.$buttons;
                else:
                    $custom_content = $buttons.'<br/>'.$custom_content;
                endif;
            endif;
    	endif;



    	return $custom_content;
    else:
        return $content;
    endif;
}

function on_all_site(){
    $GS = get_gs();

    $floating_active = get_option('gs-floating-active') == 1;
    $floatingbar = "";

    if($floating_active):
        $floatingbar .= $GS->getFloatingBar();
    endif;

    echo $floatingbar;
}
