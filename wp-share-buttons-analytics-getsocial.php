<?php
/**
 * Plugin Name:  WP Share Buttons & Analytics by GetSocial
 * Plugin URI: http://getsocial.io
 * Description: A brief description of the Plugin.
 * Version: 1.0
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

    add_menu_page( 'Getsocial', 'Getsocial', 'manage_options', slug_path('init.php'), '', plugins_url( 'images/'.$needs_update.'.png', __FILE__ ) );
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

    register_setting( 'getsocial-gs-group' , 'gs-group-active' );
    register_setting( 'getsocial-gs-group' , 'gs-group-network-fb' );
    register_setting( 'getsocial-gs-group' , 'gs-group-network-tw' );
    register_setting( 'getsocial-gs-group' , 'gs-group-network-pn' );
    register_setting( 'getsocial-gs-group' , 'gs-group-network-gp' );
    register_setting( 'getsocial-gs-group' , 'gs-group-template' );
    register_setting( 'getsocial-gs-group' , 'gs-group-size' );
    register_setting( 'getsocial-gs-group' , 'gs-group-counter' );
    register_setting( 'getsocial-gs-group' , 'gs-group-position' );


    register_setting( 'getsocial-gs-custom-expressions' , 'gs-custom-expression-active' );
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

add_filter('the_content', 'add_gs_elements');

function add_gs_elements($content) {
    if ( is_single() ):
        $GS = get_gs();

        // $elements = $GS->getElements();

        $groups_active = get_option('gs-group-active') == 1;
        $custom_active = get_option('gs-custom-expression-active') == 1;
        //
        $groups = "";
        $buttons = "";
        //
        if(!is_feed() && !is_home()):
            // exit($GS->getGroup());
            if($groups_active):
                $groups .= $GS->getGroup();

                $position = get_option('gs-group-position');

                if($position == 0):
                    $custom_content = $content.$groups;
                else:
                    $custom_content = $groups.'<br/>'.$content;
                endif;
            endif;


            if($custom_active):
                foreach($GS->getElements() as $id => $action):
        		    $buttons .= $GS->getButton($id, $action);
                endforeach;

                $custom_content = $custom_content.$buttons;
            endif;
    	endif;



    	return $custom_content;
    else:
        return $content;
    endif;
}
